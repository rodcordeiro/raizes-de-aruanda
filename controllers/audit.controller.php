<?php

/**
 * Write a catalog mutation audit row. Caller owns the PDO transaction
 * (begin/commit/rollback). On insert failure throws RuntimeException with
 * message containing `audit_write_failed` so the caller can roll back.
 *
 * Never stores password or tokens.
 *
 * @param string $action create|update|delete
 * @param array|string|null $beforeJson Snapshot before mutation (array encoded as JSON)
 * @param array|string|null $afterJson Snapshot after mutation (array encoded as JSON)
 */
function writeAuditMutation(
    PDO $connection,
    string $action,
    string $resourceType,
    ?string $resourceId,
    $beforeJson,
    $afterJson,
    ?int $actorUserId,
    string $actorUsername
): void {
    if ($action !== 'create' && $action !== 'update' && $action !== 'delete') {
        throw new InvalidArgumentException('Invalid audit mutation action');
    }

    $resourceType = mb_substr(trim($resourceType), 0, 100);
    if ($resourceType === '') {
        throw new InvalidArgumentException('resource_type is required');
    }

    try {
        $before = audit_encode_json_payload($beforeJson);
        $after = audit_encode_json_payload($afterJson);

        $sql = 'INSERT INTO `tb_audit_logs` (
                    `actor_user_id`,
                    `actor_username`,
                    `action`,
                    `resource_type`,
                    `resource_id`,
                    `before_json`,
                    `after_json`,
                    `created_at`,
                    `origin`,
                    `http_method`,
                    `http_path`,
                    `ip`,
                    `user_agent`
                ) VALUES (
                    :actor_user_id,
                    :actor_username,
                    :action,
                    :resource_type,
                    :resource_id,
                    :before_json,
                    :after_json,
                    UTC_TIMESTAMP(),
                    :origin,
                    :http_method,
                    :http_path,
                    :ip,
                    :user_agent
                )';

        $stmt = $connection->prepare($sql);

        if ($actorUserId === null) {
            $stmt->bindValue(':actor_user_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':actor_user_id', $actorUserId, PDO::PARAM_INT);
        }

        $username = mb_substr(trim($actorUsername), 0, 255);
        if ($username === '') {
            $username = 'unknown';
        }

        $stmt->bindValue(':actor_username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':action', $action, PDO::PARAM_STR);
        $stmt->bindValue(':resource_type', $resourceType, PDO::PARAM_STR);

        if ($resourceId === null || $resourceId === '') {
            $stmt->bindValue(':resource_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':resource_id', mb_substr($resourceId, 0, 255), PDO::PARAM_STR);
        }

        if ($before === null) {
            $stmt->bindValue(':before_json', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':before_json', $before, PDO::PARAM_STR);
        }

        if ($after === null) {
            $stmt->bindValue(':after_json', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':after_json', $after, PDO::PARAM_STR);
        }

        $stmt->bindValue(':origin', 'admin-web', PDO::PARAM_STR);
        $stmt->bindValue(
            ':http_method',
            isset($_SERVER['REQUEST_METHOD']) ? (string) $_SERVER['REQUEST_METHOD'] : 'POST',
            PDO::PARAM_STR
        );
        $stmt->bindValue(':http_path', audit_request_path(), PDO::PARAM_STR);
        $stmt->bindValue(':ip', audit_client_ip(), PDO::PARAM_STR);
        $stmt->bindValue(':user_agent', audit_user_agent(), PDO::PARAM_STR);

        $stmt->execute();
    } catch (Throwable $e) {
        throw new RuntimeException(
            'audit_write_failed: ' . $e->getMessage(),
            0,
            $e
        );
    }
}

/**
 * @param array|string|null $payload
 */
function audit_encode_json_payload($payload): ?string
{
    if ($payload === null) {
        return null;
    }

    if (is_string($payload)) {
        $trimmed = trim($payload);
        return $trimmed === '' ? null : $trimmed;
    }

    if (!is_array($payload)) {
        throw new InvalidArgumentException('Audit JSON payload must be array, string, or null');
    }

    $encoded = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($encoded === false) {
        throw new RuntimeException('audit_write_failed: json_encode error');
    }

    return $encoded;
}

/**
 * Best-effort audit writer for login events.
 * Never stores password or tokens. Failures must not block auth flow.
 *
 * @param int|null $actorUserId Nullable for failures / unknown users
 */
function writeAuditLogin(
    PDO $connection,
    ?int $actorUserId,
    string $actorUsername,
    string $action
): void {
    if ($action !== 'login_success' && $action !== 'login_failure') {
        return;
    }

    try {
        $sql = 'INSERT INTO `tb_audit_logs` (
                    `actor_user_id`,
                    `actor_username`,
                    `action`,
                    `resource_type`,
                    `resource_id`,
                    `before_json`,
                    `after_json`,
                    `created_at`,
                    `origin`,
                    `http_method`,
                    `http_path`,
                    `ip`,
                    `user_agent`
                ) VALUES (
                    :actor_user_id,
                    :actor_username,
                    :action,
                    :resource_type,
                    :resource_id,
                    NULL,
                    NULL,
                    UTC_TIMESTAMP(),
                    :origin,
                    :http_method,
                    :http_path,
                    :ip,
                    :user_agent
                )';

        $stmt = $connection->prepare($sql);

        if ($actorUserId === null) {
            $stmt->bindValue(':actor_user_id', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':actor_user_id', $actorUserId, PDO::PARAM_INT);
        }

        $username = mb_substr(trim($actorUsername), 0, 255);
        if ($username === '') {
            $username = 'unknown';
        }

        $stmt->bindValue(':actor_username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':action', $action, PDO::PARAM_STR);
        $stmt->bindValue(':resource_type', 'session', PDO::PARAM_STR);
        $stmt->bindValue(':resource_id', null, PDO::PARAM_NULL);
        $stmt->bindValue(':origin', 'admin-web', PDO::PARAM_STR);
        $stmt->bindValue(
            ':http_method',
            isset($_SERVER['REQUEST_METHOD']) ? (string) $_SERVER['REQUEST_METHOD'] : 'POST',
            PDO::PARAM_STR
        );
        $stmt->bindValue(':http_path', audit_request_path(), PDO::PARAM_STR);
        $stmt->bindValue(':ip', audit_client_ip(), PDO::PARAM_STR);
        $stmt->bindValue(':user_agent', audit_user_agent(), PDO::PARAM_STR);

        $stmt->execute();
    } catch (Throwable $e) {
        // Best-effort: never block login/logout on audit failure.
        return;
    }
}

function audit_request_path(): string
{
    $path = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '/admin/login/';
    $path = strtok($path, '?') ?: '/admin/login/';
    return mb_substr($path, 0, 2048);
}

function audit_client_ip(): ?string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? null;
    if (!is_string($ip) || $ip === '') {
        return null;
    }
    return mb_substr($ip, 0, 45);
}

function audit_user_agent(): ?string
{
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? null;
    if (!is_string($ua) || $ua === '') {
        return null;
    }
    return mb_substr($ua, 0, 512);
}
