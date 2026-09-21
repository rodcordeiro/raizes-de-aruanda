<?php

/**
 * Self-service profile: own display name (`tb_user.name`) + optional password.
 * Never writes password hashes or tokens into audit payloads.
 */

/**
 * @return array{id:int, username:string, name:string}|null
 */
function admin_profile_find(PDO $connection, int $userId): ?array
{
    if ($userId <= 0) {
        return null;
    }

    $sql = 'SELECT `id`, `username`, `name`
            FROM `tb_user`
            WHERE `id` = :id
            LIMIT 1';
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!is_array($row)) {
        return null;
    }

    return [
        'id' => (int) $row['id'],
        'username' => (string) $row['username'],
        'name' => (string) $row['name'],
    ];
}

/**
 * @return array{ok:true}|array{ok:false, errors:string[], fields:array<string,string>}
 */
function admin_profile_validate(string $name, string $currentPassword, string $newPassword, string $newPasswordConfirm): array
{
    $errors = [];
    $fields = [];

    $name = trim($name);
    if ($name === '') {
        $errors[] = 'Informe o nome.';
        $fields['name'] = 'Informe o nome.';
    } elseif (function_exists('mb_strlen') && mb_strlen($name) > 255) {
        $errors[] = 'O nome deve ter no máximo 255 caracteres.';
        $fields['name'] = 'O nome deve ter no máximo 255 caracteres.';
    } elseif (strlen($name) > 255) {
        $errors[] = 'O nome deve ter no máximo 255 caracteres.';
        $fields['name'] = 'O nome deve ter no máximo 255 caracteres.';
    }

    if ($currentPassword === '') {
        $errors[] = 'Informe a senha atual.';
        $fields['current_password'] = 'Obrigatória para confirmar qualquer alteração.';
    }

    $changingPassword = $newPassword !== '' || $newPasswordConfirm !== '';
    if ($changingPassword && $newPassword !== $newPasswordConfirm) {
        $errors[] = 'A confirmação não coincide com a nova senha.';
        $fields['new_password_confirm'] = 'A confirmação não coincide com a nova senha.';
    }

    if ($errors === []) {
        return ['ok' => true];
    }

    return ['ok' => false, 'errors' => $errors, 'fields' => $fields];
}

/**
 * Update the authenticated user's display name and optional password.
 * Current password is required. Username, other users and roles are never touched.
 *
 * @param array{user_id?:mixed,username?:mixed} $actor
 * @return array{ok:true, name:string}|array{ok:false, errors:string[], fields:array<string,string>}
 */
function admin_profile_update_self(
    PDO $connection,
    int $userId,
    string $name,
    string $currentPassword,
    string $newPassword,
    string $newPasswordConfirm,
    array $actor
) {
    $validated = admin_profile_validate($name, $currentPassword, $newPassword, $newPasswordConfirm);
    if (!$validated['ok']) {
        return $validated;
    }

    $name = trim($name);
    $changePassword = $newPassword !== '';
    $actorUserId = isset($actor['user_id']) ? (int) $actor['user_id'] : $userId;
    $actorUsername = isset($actor['username']) ? (string) $actor['username'] : 'unknown';

    if ($actorUserId !== $userId) {
        return [
            'ok' => false,
            'errors' => ['Você só pode alterar o próprio perfil.'],
            'fields' => [],
        ];
    }

    $connection->beginTransaction();

    try {
        $sql = 'SELECT `id`, `username`, `name`, `password`
                FROM `tb_user`
                WHERE `id` = :id
                LIMIT 1
                FOR UPDATE';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!is_array($row)) {
            throw new RuntimeException('User not found');
        }

        $hash = isset($row['password']) && is_string($row['password']) ? $row['password'] : '';
        if ($hash === '' || !password_verify($currentPassword, $hash)) {
            $connection->rollBack();
            return [
                'ok' => false,
                'errors' => ['Senha atual incorreta.'],
                'fields' => ['current_password' => 'Senha atual incorreta.'],
            ];
        }

        $before = [
            'id' => (int) $row['id'],
            'name' => (string) $row['name'],
        ];

        if ($changePassword) {
            $updateSql = 'UPDATE `tb_user`
                          SET `name` = :name,
                              `password` = :password
                          WHERE `id` = :id
                          LIMIT 1';
            $update = $connection->prepare($updateSql);
            $update->bindValue(':name', $name, PDO::PARAM_STR);
            $update->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $update->bindValue(':id', $userId, PDO::PARAM_INT);
            $update->execute();
        } else {
            $updateSql = 'UPDATE `tb_user`
                          SET `name` = :name
                          WHERE `id` = :id
                          LIMIT 1';
            $update = $connection->prepare($updateSql);
            $update->bindValue(':name', $name, PDO::PARAM_STR);
            $update->bindValue(':id', $userId, PDO::PARAM_INT);
            $update->execute();
        }

        $after = [
            'id' => $userId,
            'name' => $name,
            'password_changed' => $changePassword,
        ];

        writeAuditMutation(
            $connection,
            'update',
            'user',
            (string) $userId,
            $before,
            $after,
            $actorUserId,
            $actorUsername
        );

        $connection->commit();
    } catch (Throwable $e) {
        if ($connection->inTransaction()) {
            $connection->rollBack();
        }
        throw $e;
    }

    $_SESSION['name'] = $name;

    if ($changePassword) {
        session_regenerate_id(true);
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return ['ok' => true, 'name' => $name];
}
