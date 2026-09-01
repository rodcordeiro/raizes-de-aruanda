<?php

/**
 * Admin CRUD for tb_ritmos (prepared statements + transactional audit).
 * Delete refuses when tb_pontos still reference the ritmo.
 */

/** Default page size for admin ritmos list. */
const ADMIN_RITMOS_PER_PAGE = 20;

/**
 * List rows for admin index + pagination.
 *
 * @return array{
 *   rows: list<array{id:int, nome:string}>,
 *   total: int,
 *   page: int,
 *   per_page: int,
 *   total_pages: int
 * }
 */
function admin_ritmos_list(PDO $connection, int $page = 1, int $perPage = ADMIN_RITMOS_PER_PAGE): array
{
    if ($perPage < 1) {
        $perPage = ADMIN_RITMOS_PER_PAGE;
    }
    if ($page < 1) {
        $page = 1;
    }

    $countStmt = $connection->prepare('SELECT COUNT(*) FROM `tb_ritmos`');
    $countStmt->execute();
    $total = (int) $countStmt->fetchColumn();

    $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 1;
    if ($page > $totalPages) {
        $page = $totalPages;
    }
    $offset = ($page - 1) * $perPage;

    $sql = 'SELECT `id`, `nome`
            FROM `tb_ritmos`
            ORDER BY `nome` ASC, `id` ASC
            LIMIT :limit OFFSET :offset';

    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $rows = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = [
            'id' => (int) $row['id'],
            'nome' => (string) $row['nome'],
        ];
    }

    return [
        'rows' => $rows,
        'total' => $total,
        'page' => $page,
        'per_page' => $perPage,
        'total_pages' => $totalPages,
    ];
}

/**
 * @return array{id:int, nome:string}|null
 */
function admin_ritmos_find(PDO $connection, int $id): ?array
{
    if ($id <= 0) {
        return null;
    }

    $sql = 'SELECT `id`, `nome`
            FROM `tb_ritmos`
            WHERE `id` = :id
            LIMIT 1';

    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!is_array($row)) {
        return null;
    }

    return [
        'id' => (int) $row['id'],
        'nome' => (string) $row['nome'],
    ];
}

/**
 * Create a ritmo inside a transaction; audit create must succeed or rollback.
 *
 * @param array{nome?:mixed} $data
 * @param array{user_id?:mixed,username?:mixed} $actor
 */
function admin_ritmos_create(PDO $connection, array $data, array $actor): int
{
    $validated = admin_ritmos_validate($data);
    if (!$validated['ok']) {
        throw new InvalidArgumentException(implode('; ', $validated['errors']));
    }

    $clean = $validated['clean'];
    $actorUserId = isset($actor['user_id']) ? (int) $actor['user_id'] : null;
    $actorUsername = isset($actor['username']) ? (string) $actor['username'] : 'unknown';

    $connection->beginTransaction();

    try {
        $sql = 'INSERT INTO `tb_ritmos` (`nome`) VALUES (:nome)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':nome', $clean['nome'], PDO::PARAM_STR);
        $stmt->execute();

        $newId = (int) $connection->lastInsertId();
        if ($newId <= 0) {
            throw new RuntimeException('Failed to obtain new ritmo id');
        }

        $after = admin_ritmos_audit_snapshot([
            'id' => $newId,
            'nome' => $clean['nome'],
        ]);

        writeAuditMutation(
            $connection,
            'create',
            'ritmo',
            (string) $newId,
            null,
            $after,
            $actorUserId,
            $actorUsername
        );

        $connection->commit();

        return $newId;
    } catch (Throwable $e) {
        if ($connection->inTransaction()) {
            $connection->rollBack();
        }
        throw $e;
    }
}

/**
 * Update a ritmo inside a transaction; audit update must succeed or rollback.
 *
 * @param array{nome?:mixed} $data
 * @param array{user_id?:mixed,username?:mixed} $actor
 */
function admin_ritmos_update(PDO $connection, int $id, array $data, array $actor): void
{
    if ($id <= 0) {
        throw new InvalidArgumentException('Invalid ritmo id');
    }

    $validated = admin_ritmos_validate($data);
    if (!$validated['ok']) {
        throw new InvalidArgumentException(implode('; ', $validated['errors']));
    }

    $clean = $validated['clean'];
    $actorUserId = isset($actor['user_id']) ? (int) $actor['user_id'] : null;
    $actorUsername = isset($actor['username']) ? (string) $actor['username'] : 'unknown';

    $connection->beginTransaction();

    try {
        $beforeRow = admin_ritmos_find($connection, $id);
        if ($beforeRow === null) {
            throw new RuntimeException('Ritmo not found');
        }

        $sql = 'UPDATE `tb_ritmos`
                SET `nome` = :nome
                WHERE `id` = :id
                LIMIT 1';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':nome', $clean['nome'], PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() < 1 && admin_ritmos_find($connection, $id) === null) {
            throw new RuntimeException('Ritmo not found');
        }

        $after = admin_ritmos_audit_snapshot([
            'id' => $id,
            'nome' => $clean['nome'],
        ]);

        writeAuditMutation(
            $connection,
            'update',
            'ritmo',
            (string) $id,
            admin_ritmos_audit_snapshot($beforeRow),
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
}

/**
 * Delete a ritmo inside a transaction; audit delete must succeed or rollback.
 * Refuses when pontos still reference this ritmo.
 *
 * @param array{user_id?:mixed,username?:mixed} $actor
 */
function admin_ritmos_delete(PDO $connection, int $id, array $actor): void
{
    if ($id <= 0) {
        throw new InvalidArgumentException('Invalid ritmo id');
    }

    $actorUserId = isset($actor['user_id']) ? (int) $actor['user_id'] : null;
    $actorUsername = isset($actor['username']) ? (string) $actor['username'] : 'unknown';

    $connection->beginTransaction();

    try {
        $beforeRow = admin_ritmos_find($connection, $id);
        if ($beforeRow === null) {
            throw new RuntimeException('Ritmo not found');
        }

        // Re-check inside the transaction so a concurrent ponto insert cannot
        // slip past the app-level guard while FK CASCADE remains on the DB.
        $pontosCount = admin_ritmos_count_pontos($connection, $id);
        if ($pontosCount > 0) {
            throw new InvalidArgumentException(
                'Não é possível excluir: existem pontos ligados a este ritmo.'
            );
        }

        $sql = 'DELETE FROM `tb_ritmos` WHERE `id` = :id LIMIT 1';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            throw new RuntimeException('Ritmo not found');
        }

        writeAuditMutation(
            $connection,
            'delete',
            'ritmo',
            (string) $id,
            admin_ritmos_audit_snapshot($beforeRow),
            null,
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
}

/**
 * Validate and normalize input for create/update.
 *
 * @param array{nome?:mixed} $data
 * @return array{ok:bool, errors:string[], clean:array{nome?:string}}
 */
function admin_ritmos_validate(array $data): array
{
    $errors = [];
    $clean = [];

    $nome = isset($data['nome']) ? trim((string) $data['nome']) : '';
    if ($nome === '') {
        $errors[] = 'Nome é obrigatório.';
    } elseif (function_exists('mb_strlen') && mb_strlen($nome) > 255) {
        $errors[] = 'Nome deve ter no máximo 255 caracteres.';
    } elseif (!function_exists('mb_strlen') && strlen($nome) > 255) {
        $errors[] = 'Nome deve ter no máximo 255 caracteres.';
    } else {
        $clean['nome'] = function_exists('mb_substr') ? mb_substr($nome, 0, 255) : substr($nome, 0, 255);
    }

    return [
        'ok' => $errors === [],
        'errors' => $errors,
        'clean' => $clean,
    ];
}

/**
 * Count pontos that reference this ritmo.
 */
function admin_ritmos_count_pontos(PDO $connection, int $ritmoId): int
{
    if ($ritmoId <= 0) {
        return 0;
    }

    $sql = 'SELECT COUNT(*) FROM `tb_pontos` WHERE `ritmo` = :id';
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':id', $ritmoId, PDO::PARAM_INT);
    $stmt->execute();

    return (int) $stmt->fetchColumn();
}

/**
 * @param array{id:int,nome:string} $row
 * @return array{id:int,nome:string}
 */
function admin_ritmos_audit_snapshot(array $row): array
{
    return [
        'id' => (int) $row['id'],
        'nome' => (string) $row['nome'],
    ];
}
