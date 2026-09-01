<?php

require_once __DIR__ . '/../utils/functions.php';

const ADMIN_SESSION_TIMEOUT = 14400;
const ADMIN_LOGIN_PATH = '/admin/login/';
const ADMIN_HOME_PATH = '/admin/';

/**
 * Start (or resume) the admin session with timeout + cookie hardening.
 */
function admin_session_start(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        admin_session_touch_or_expire();
        return;
    }

    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443);

    session_set_cookie_params([
        'lifetime' => ADMIN_SESSION_TIMEOUT,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => $secure,
    ]);

    session_start();
    admin_session_touch_or_expire();
}

/**
 * Enforce idle timeout (legacy 14400s) and refresh the activity stamp.
 */
function admin_session_touch_or_expire(): void
{
    if (isset($_SESSION['timeout'])) {
        $elapsed = time() - (int) $_SESSION['timeout'];
        if ($elapsed > ADMIN_SESSION_TIMEOUT) {
            $_SESSION = [];
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_regenerate_id(true);
            }
        }
    }

    $_SESSION['timeout'] = time();
}

function isAuthenticated(): bool
{
    return isset($_SESSION['user_id']) && (int) $_SESSION['user_id'] > 0
        && !empty($_SESSION['username']);
}

/**
 * Require an authenticated session; redirect to login if missing.
 */
function requireAuth(): void
{
    if (!isAuthenticated()) {
        redirect(ADMIN_LOGIN_PATH);
    }
}

/**
 * Ensure a CSRF token exists and return it.
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_validate(?string $token): bool
{
    if ($token === null || $token === '' || empty($_SESSION['csrf_token'])) {
        return false;
    }

    return hash_equals((string) $_SESSION['csrf_token'], $token);
}

/**
 * Authenticate against tb_user (bcrypt via password_verify).
 * On success: populates session, loads RBAC, audits login_success.
 * On failure: audits login_failure (best-effort) and returns false.
 */
function attemptLogin(PDO $connection, string $username, string $password): bool
{
    $username = trim($username);

    $sql = 'SELECT `id`, `username`, `name`, `password`
            FROM `tb_user`
            WHERE `username` = :username
            LIMIT 1';

    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $valid = is_array($row)
        && isset($row['password'])
        && is_string($row['password'])
        && $row['password'] !== ''
        && password_verify($password, $row['password']);

    if (!$valid) {
        // Reduce username timing oracle: always run password_verify.
        if (!is_array($row) || empty($row['password'])) {
            password_verify(
                $password,
                '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
            );
        }

        if (function_exists('writeAuditLogin')) {
            writeAuditLogin(
                $connection,
                null,
                $username !== '' ? $username : 'unknown',
                'login_failure'
            );
        }
        return false;
    }

    $userId = (int) $row['id'];

    try {
        $rbac = function_exists('fetchUserRbac')
            ? fetchUserRbac($connection, $userId)
            : ['roles' => [], 'permissions' => []];
    } catch (Throwable $e) {
        if (function_exists('writeAuditLogin')) {
            writeAuditLogin(
                $connection,
                $userId,
                (string) $row['username'],
                'login_failure'
            );
        }
        return false;
    }

    session_regenerate_id(true);

    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = (string) $row['username'];
    $_SESSION['name'] = isset($row['name']) ? (string) $row['name'] : '';
    $_SESSION['roles'] = $rbac['roles'];
    $_SESSION['permissions'] = $rbac['permissions'];
    $_SESSION['timeout'] = time();
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    if (function_exists('writeAuditLogin')) {
        writeAuditLogin(
            $connection,
            $userId,
            (string) $row['username'],
            'login_success'
        );
    }

    return true;
}

function logout(): void
{
    $_SESSION = [];

    if (session_status() === PHP_SESSION_ACTIVE) {
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires' => time() - 42000,
                'path' => $params['path'] ?? '/',
                'domain' => $params['domain'] ?? '',
                'secure' => (bool) ($params['secure'] ?? false),
                'httponly' => (bool) ($params['httponly'] ?? true),
                'samesite' => $params['samesite'] ?? 'Lax',
            ]);
        }
        session_destroy();
    }
}
