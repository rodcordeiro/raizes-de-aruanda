<?php

/**
 * Fetch role and permission slugs for a user (does not touch session).
 *
 * @return array{roles: string[], permissions: string[]}
 */
function fetchUserRbac(PDO $connection, int $userId): array
{
    $roles = [];
    $permissions = [];

    $sql = 'SELECT r.`slug` AS role_slug, p.`slug` AS permission_slug
            FROM `tb_user_roles` ur
            INNER JOIN `tb_roles` r ON r.`id` = ur.`role_id`
            LEFT JOIN `tb_role_permissions` rp ON rp.`role_id` = r.`id`
            LEFT JOIN `tb_permissions` p ON p.`id` = rp.`permission_id`
            WHERE ur.`user_id` = :user_id';

    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($row['role_slug'])) {
            $roles[(string) $row['role_slug']] = true;
        }
        if (!empty($row['permission_slug'])) {
            $permissions[(string) $row['permission_slug']] = true;
        }
    }

    return [
        'roles' => array_keys($roles),
        'permissions' => array_keys($permissions),
    ];
}

/**
 * Load role and permission slugs for a user into $_SESSION.
 *
 * Session keys:
 * - roles: string[] (e.g. admin, editor)
 * - permissions: string[] (e.g. ponto:create)
 */
function loadUserRbac(PDO $connection, int $userId): void
{
    $rbac = fetchUserRbac($connection, $userId);
    $_SESSION['roles'] = $rbac['roles'];
    $_SESSION['permissions'] = $rbac['permissions'];
}

function hasRole(string $slug): bool
{
    if (!isset($_SESSION['roles']) || !is_array($_SESSION['roles'])) {
        return false;
    }

    return in_array($slug, $_SESSION['roles'], true);
}

function hasPermission(string $slug): bool
{
    if (!isset($_SESSION['permissions']) || !is_array($_SESSION['permissions'])) {
        return false;
    }

    if (in_array($slug, $_SESSION['permissions'], true)) {
        return true;
    }

    // Matrix may store resource:* (e.g. linha:*, ritmo:*).
    $separator = strpos($slug, ':');
    if ($separator === false || str_ends_with($slug, ':*')) {
        return false;
    }

    $wildcard = substr($slug, 0, $separator + 1) . '*';

    return in_array($wildcard, $_SESSION['permissions'], true);
}

/**
 * Admin catalog reads of category/linha/ritmo/ponto are implicit for
 * anyone with ponto:create OR ponto:update (no *:read permissions).
 */
function canReadCatalog(): bool
{
    return hasPermission('ponto:create') || hasPermission('ponto:update');
}

/**
 * Require a permission; 403 if authenticated without it, else login redirect.
 */
function requirePermission(string $slug): void
{
    if (!function_exists('isAuthenticated') || !isAuthenticated()) {
        if (function_exists('requireAuth')) {
            requireAuth();
        }
        redirect(defined('ADMIN_LOGIN_PATH') ? ADMIN_LOGIN_PATH : '/admin/login/');
    }

    if (!hasPermission($slug)) {
        http_response_code(403);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Acesso negado.';
        exit;
    }
}
