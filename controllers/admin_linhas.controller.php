<?php

/**
 * Admin CRUD for tb_linhas (prepared statements + transactional audit).
 * Delete refuses when tb_pontos still reference the linha.
 */

/** Default page size for admin linhas list. */
const ADMIN_LINHAS_PER_PAGE = 20;

/**
 * List rows for admin index (joined categoria nome) + pagination.
 *
 * @return array{
 *   rows: list<array{
 *     id:int, nome:string, categoria_id:int, categoria_nome:string,
 *     canal_youtube:?string, saudacao:?string
 *   }>,
 *   total: int,
 *   page: int,
 *   per_page: int,
 *   total_pages: int
 * }
 */
function admin_linhas_list(PDO $connection, int $page = 1, int $perPage = ADMIN_LINHAS_PER_PAGE): array
{
    if ($perPage < 1) {
        $perPage = ADMIN_LINHAS_PER_PAGE;
    }
    if ($page < 1) {
        $page = 1;
    }

    $countStmt = $connection->prepare('SELECT COUNT(*) FROM `tb_linhas`');
    $countStmt->execute();
    $total = (int) $countStmt->fetchColumn();

    $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 1;
    if ($page > $totalPages) {
        $page = $totalPages;
    }
    $offset = ($page - 1) * $perPage;

    $sql = 'SELECT
                l.`id`,
                l.`nome`,
                l.`categoria` AS categoria_id,
                c.`nome` AS categoria_nome,
                l.`canal_youtube`,
                l.`saudacao`
            FROM `tb_linhas` l
            INNER JOIN `tb_categorias` c ON c.`id` = l.`categoria`
            ORDER BY l.`nome` ASC, l.`id` ASC
            LIMIT :limit OFFSET :offset';

    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $rows = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = admin_linhas_hydrate_row($row);
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
 * @return array{
 *   id:int, nome:string, categoria_id:int, categoria_nome:string,
 *   canal_youtube:?string, saudacao:?string
 * }|null
 */
function admin_linhas_find(PDO $connection, int $id): ?array
{
    if ($id <= 0) {
        return null;
    }

    $sql = 'SELECT
                l.`id`,
                l.`nome`,
                l.`categoria` AS categoria_id,
                c.`nome` AS categoria_nome,
                l.`canal_youtube`,
                l.`saudacao`
            FROM `tb_linhas` l
            INNER JOIN `tb_categorias` c ON c.`id` = l.`categoria`
            WHERE l.`id` = :id
            LIMIT 1';

    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!is_array($row)) {
        return null;
    }

    return admin_linhas_hydrate_row($row);
}

/**
 * Create a linha inside a transaction; audit create must succeed or rollback.
 *
 * @param array{nome?:mixed,categoria?:mixed,canal_youtube?:mixed,saudacao?:mixed} $data
 * @param array{user_id?:mixed,username?:mixed} $actor
 */
function admin_linhas_create(PDO $connection, array $data, array $actor): int
{
    $validated = admin_linhas_validate_with_fks($connection, $data);
    if (!$validated['ok']) {
        throw new InvalidArgumentException(implode('; ', $validated['errors']));
    }

    $clean = $validated['clean'];
    $actorUserId = isset($actor['user_id']) ? (int) $actor['user_id'] : null;
    $actorUsername = isset($actor['username']) ? (string) $actor['username'] : 'unknown';

    $connection->beginTransaction();

    try {
        $sql = 'INSERT INTO `tb_linhas` (`nome`, `categoria`, `canal_youtube`, `saudacao`)
                VALUES (:nome, :categoria, :canal_youtube, :saudacao)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':nome', $clean['nome'], PDO::PARAM_STR);
        $stmt->bindValue(':categoria', $clean['categoria'], PDO::PARAM_INT);
        if ($clean['canal_youtube'] === null) {
            $stmt->bindValue(':canal_youtube', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':canal_youtube', $clean['canal_youtube'], PDO::PARAM_STR);
        }
        if ($clean['saudacao'] === null) {
            $stmt->bindValue(':saudacao', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':saudacao', $clean['saudacao'], PDO::PARAM_STR);
        }
        $stmt->execute();

        $newId = (int) $connection->lastInsertId();
        if ($newId <= 0) {
            throw new RuntimeException('Failed to obtain new linha id');
        }

        $after = admin_linhas_audit_snapshot([
            'id' => $newId,
            'nome' => $clean['nome'],
            'categoria' => $clean['categoria'],
            'canal_youtube' => $clean['canal_youtube'],
            'saudacao' => $clean['saudacao'],
        ]);

        writeAuditMutation(
            $connection,
            'create',
            'linha',
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
 * Update a linha inside a transaction; audit update must succeed or rollback.
 *
 * @param array{nome?:mixed,categoria?:mixed,canal_youtube?:mixed,saudacao?:mixed} $data
 * @param array{user_id?:mixed,username?:mixed} $actor
 */
function admin_linhas_update(PDO $connection, int $id, array $data, array $actor): void
{
    if ($id <= 0) {
        throw new InvalidArgumentException('Invalid linha id');
    }

    $validated = admin_linhas_validate_with_fks($connection, $data);
    if (!$validated['ok']) {
        throw new InvalidArgumentException(implode('; ', $validated['errors']));
    }

    $clean = $validated['clean'];
    $actorUserId = isset($actor['user_id']) ? (int) $actor['user_id'] : null;
    $actorUsername = isset($actor['username']) ? (string) $actor['username'] : 'unknown';

    $connection->beginTransaction();

    try {
        $beforeRow = admin_linhas_find_for_audit($connection, $id);
        if ($beforeRow === null) {
            throw new RuntimeException('Linha not found');
        }

        $sql = 'UPDATE `tb_linhas`
                SET `nome` = :nome,
                    `categoria` = :categoria,
                    `canal_youtube` = :canal_youtube,
                    `saudacao` = :saudacao
                WHERE `id` = :id
                LIMIT 1';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':nome', $clean['nome'], PDO::PARAM_STR);
        $stmt->bindValue(':categoria', $clean['categoria'], PDO::PARAM_INT);
        if ($clean['canal_youtube'] === null) {
            $stmt->bindValue(':canal_youtube', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':canal_youtube', $clean['canal_youtube'], PDO::PARAM_STR);
        }
        if ($clean['saudacao'] === null) {
            $stmt->bindValue(':saudacao', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':saudacao', $clean['saudacao'], PDO::PARAM_STR);
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() < 1 && admin_linhas_find_for_audit($connection, $id) === null) {
            throw new RuntimeException('Linha not found');
        }

        $after = admin_linhas_audit_snapshot([
            'id' => $id,
            'nome' => $clean['nome'],
            'categoria' => $clean['categoria'],
            'canal_youtube' => $clean['canal_youtube'],
            'saudacao' => $clean['saudacao'],
        ]);

        writeAuditMutation(
            $connection,
            'update',
            'linha',
            (string) $id,
            admin_linhas_audit_snapshot($beforeRow),
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
 * Delete a linha inside a transaction; audit delete must succeed or rollback.
 * Refuses when pontos still reference this linha.
 *
 * @param array{user_id?:mixed,username?:mixed} $actor
 */
function admin_linhas_delete(PDO $connection, int $id, array $actor): void
{
    if ($id <= 0) {
        throw new InvalidArgumentException('Invalid linha id');
    }

    $actorUserId = isset($actor['user_id']) ? (int) $actor['user_id'] : null;
    $actorUsername = isset($actor['username']) ? (string) $actor['username'] : 'unknown';

    $connection->beginTransaction();

    try {
        $beforeRow = admin_linhas_find_for_audit($connection, $id);
        if ($beforeRow === null) {
            throw new RuntimeException('Linha not found');
        }

        // Re-check inside the transaction so a concurrent ponto insert cannot
        // slip past the app-level guard while FK CASCADE remains on the DB.
        $pontosCount = admin_linhas_count_pontos($connection, $id);
        if ($pontosCount > 0) {
            throw new InvalidArgumentException(
                'Não é possível excluir: existem pontos ligados a esta linha.'
            );
        }

        $sql = 'DELETE FROM `tb_linhas` WHERE `id` = :id LIMIT 1';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            throw new RuntimeException('Linha not found');
        }

        writeAuditMutation(
            $connection,
            'delete',
            'linha',
            (string) $id,
            admin_linhas_audit_snapshot($beforeRow),
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
 * @param array{nome?:mixed,categoria?:mixed,canal_youtube?:mixed,saudacao?:mixed} $data
 * @return array{ok:bool, errors:string[], clean:array{nome?:string,categoria?:int,canal_youtube:?string,saudacao:?string}}
 */
function admin_linhas_validate(array $data): array
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

    $categoria = filter_var($data['categoria'] ?? null, FILTER_VALIDATE_INT);
    if ($categoria === false || (int) $categoria <= 0) {
        $errors[] = 'Categoria é obrigatória.';
    } else {
        $clean['categoria'] = (int) $categoria;
    }

    $canalRaw = $data['canal_youtube'] ?? null;
    if ($canalRaw === null || (is_string($canalRaw) && trim($canalRaw) === '')) {
        $clean['canal_youtube'] = null;
    } else {
        $canal = trim((string) $canalRaw);
        if (!admin_linhas_is_valid_url($canal)) {
            $errors[] = 'Canal do YouTube URL inválida.';
        } else {
            $clean['canal_youtube'] = function_exists('mb_substr')
                ? mb_substr($canal, 0, 255)
                : substr($canal, 0, 255);
        }
    }

    $saudacaoRaw = $data['saudacao'] ?? null;
    if ($saudacaoRaw === null || (is_string($saudacaoRaw) && trim($saudacaoRaw) === '')) {
        $clean['saudacao'] = null;
    } else {
        $saudacao = trim((string) $saudacaoRaw);
        $len = function_exists('mb_strlen') ? mb_strlen($saudacao) : strlen($saudacao);
        if ($len > 100) {
            $errors[] = 'Saudação deve ter no máximo 100 caracteres.';
        } else {
            $clean['saudacao'] = $saudacao;
        }
    }

    return [
        'ok' => $errors === [],
        'errors' => $errors,
        'clean' => $clean,
    ];
}

/**
 * Validate create/update fields including FK existence for categoria.
 *
 * @param array{nome?:mixed,categoria?:mixed,canal_youtube?:mixed,saudacao?:mixed} $data
 * @return array{ok:bool, errors:string[], clean:array}
 */
function admin_linhas_validate_with_fks(PDO $connection, array $data): array
{
    $result = admin_linhas_validate($data);
    if (!$result['ok']) {
        return $result;
    }

    $errors = $result['errors'];
    $clean = $result['clean'];

    if (!admin_linhas_categoria_exists($connection, $clean['categoria'])) {
        $errors[] = 'Categoria selecionada não existe.';
    }

    return [
        'ok' => $errors === [],
        'errors' => $errors,
        'clean' => $clean,
    ];
}

/**
 * @return list<array{id:int, nome:string}>
 */
function admin_list_categorias_select(PDO $connection): array
{
    $sql = 'SELECT `id`, `nome` FROM `tb_categorias` ORDER BY `nome` ASC';
    $stmt = $connection->prepare($sql);
    $stmt->execute();

    $rows = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = [
            'id' => (int) $row['id'],
            'nome' => (string) $row['nome'],
        ];
    }

    return $rows;
}

/**
 * Count pontos that reference this linha.
 */
function admin_linhas_count_pontos(PDO $connection, int $linhaId): int
{
    if ($linhaId <= 0) {
        return 0;
    }

    $sql = 'SELECT COUNT(*) FROM `tb_pontos` WHERE `linha` = :id';
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':id', $linhaId, PDO::PARAM_INT);
    $stmt->execute();

    return (int) $stmt->fetchColumn();
}

/**
 * @param array<string,mixed> $row
 * @return array{
 *   id:int, nome:string, categoria_id:int, categoria_nome:string,
 *   canal_youtube:?string, saudacao:?string
 * }
 */
function admin_linhas_hydrate_row(array $row): array
{
    return [
        'id' => (int) $row['id'],
        'nome' => (string) $row['nome'],
        'categoria_id' => (int) $row['categoria_id'],
        'categoria_nome' => (string) $row['categoria_nome'],
        'canal_youtube' => isset($row['canal_youtube']) && $row['canal_youtube'] !== null && $row['canal_youtube'] !== ''
            ? (string) $row['canal_youtube']
            : null,
        'saudacao' => isset($row['saudacao']) && $row['saudacao'] !== null && $row['saudacao'] !== ''
            ? (string) $row['saudacao']
            : null,
    ];
}

/**
 * Load linha columns needed for audit snapshot (no joins).
 *
 * @return array{id:int,nome:string,categoria:int,canal_youtube:?string,saudacao:?string}|null
 */
function admin_linhas_find_for_audit(PDO $connection, int $id): ?array
{
    $sql = 'SELECT `id`, `nome`, `categoria`, `canal_youtube`, `saudacao`
            FROM `tb_linhas`
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
        'categoria' => (int) $row['categoria'],
        'canal_youtube' => isset($row['canal_youtube']) && $row['canal_youtube'] !== null && $row['canal_youtube'] !== ''
            ? (string) $row['canal_youtube']
            : null,
        'saudacao' => isset($row['saudacao']) && $row['saudacao'] !== null && $row['saudacao'] !== ''
            ? (string) $row['saudacao']
            : null,
    ];
}

/**
 * @param array{id:int,nome:string,categoria:int,canal_youtube:?string,saudacao:?string} $row
 * @return array{id:int,nome:string,categoria:int,canal_youtube:?string,saudacao:?string}
 */
function admin_linhas_audit_snapshot(array $row): array
{
    return [
        'id' => (int) $row['id'],
        'nome' => (string) $row['nome'],
        'categoria' => (int) $row['categoria'],
        'canal_youtube' => $row['canal_youtube'] ?? null,
        'saudacao' => $row['saudacao'] ?? null,
    ];
}

function admin_linhas_categoria_exists(PDO $connection, int $id): bool
{
    if ($id <= 0) {
        return false;
    }

    $sql = 'SELECT 1 FROM `tb_categorias` WHERE `id` = :id LIMIT 1';
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return (bool) $stmt->fetchColumn();
}

function admin_linhas_is_valid_url(string $url): bool
{
    if (function_exists('admin_pontos_is_valid_audio_url')) {
        return admin_pontos_is_valid_audio_url($url);
    }

    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        return $scheme === 'http' || $scheme === 'https';
    }

    return false;
}
