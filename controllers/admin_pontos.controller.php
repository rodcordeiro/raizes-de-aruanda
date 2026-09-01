<?php

/**
 * Admin CRUD for tb_pontos (prepared statements + transactional audit).
 * Does not touch legacy icnt_* tables or Pontos::filter().
 */

/** Canonical tipo values for NEW writes (majority in DB: Sustentação with accent). */
const ADMIN_PONTOS_TIPOS = ['Chamada', 'Sustentação', 'Subida'];

/** UI / API labels keyed by canonical tipo. */
const ADMIN_PONTOS_TIPO_LABELS = [
    'Chamada' => 'Chamada',
    'Sustentação' => 'Sustentação',
    'Subida' => 'Subida',
];

/**
 * Map accepted aliases to canonical write values.
 * Accepts Sustentacao (ASCII) and Sustentação (accented) on read/input.
 */
function admin_pontos_normalize_tipo(string $tipo): ?string
{
    $trimmed = trim($tipo);
    if ($trimmed === '') {
        return null;
    }

    $aliases = [
        'Chamada' => 'Chamada',
        'Sustentacao' => 'Sustentação',
        'Sustentação' => 'Sustentação',
        'Subida' => 'Subida',
    ];

    return $aliases[$trimmed] ?? null;
}

/**
 * @return list<string>
 */
function admin_pontos_allowed_tipos(): array
{
    return ADMIN_PONTOS_TIPOS;
}

/** Default page size for admin pontos list. */
const ADMIN_PONTOS_PER_PAGE = 20;

/**
 * List rows for admin index (joined linha/ritmo names), optional linha filter + pagination.
 *
 * @return array{
 *   rows: list<array{
 *     id:int, letra:string, tipo:?string, audio_url:?string,
 *     linha_id:int, ritmo_id:int, linha_nome:string, ritmo_nome:string
 *   }>,
 *   total: int,
 *   page: int,
 *   per_page: int,
 *   total_pages: int,
 *   linha_id: int|null
 * }
 */
function admin_pontos_list(PDO $connection, ?int $linhaId = null, int $page = 1, int $perPage = ADMIN_PONTOS_PER_PAGE): array
{
    if ($perPage < 1) {
        $perPage = ADMIN_PONTOS_PER_PAGE;
    }
    if ($page < 1) {
        $page = 1;
    }
    if ($linhaId !== null && $linhaId <= 0) {
        $linhaId = null;
    }

    $where = '';
    $params = [];
    if ($linhaId !== null) {
        $where = ' WHERE p.`linha` = :linha_id';
        $params['linha_id'] = $linhaId;
    }

    $countSql = 'SELECT COUNT(*) FROM `tb_pontos` p' . $where;
    $countStmt = $connection->prepare($countSql);
    foreach ($params as $key => $value) {
        $countStmt->bindValue(':' . $key, $value, PDO::PARAM_INT);
    }
    $countStmt->execute();
    $total = (int) $countStmt->fetchColumn();

    $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 1;
    if ($page > $totalPages) {
        $page = $totalPages;
    }
    $offset = ($page - 1) * $perPage;

    $sql = 'SELECT
                p.`id`,
                p.`letra`,
                p.`tipo`,
                p.`audio_url`,
                p.`linha` AS linha_id,
                p.`ritmo` AS ritmo_id,
                l.`nome` AS linha_nome,
                r.`nome` AS ritmo_nome
            FROM `tb_pontos` p
            INNER JOIN `tb_linhas` l ON l.`id` = p.`linha`
            INNER JOIN `tb_ritmos` r ON r.`id` = p.`ritmo`'
            . $where . '
            ORDER BY l.`nome` ASC, r.`nome` ASC, p.`id` ASC
            LIMIT :limit OFFSET :offset';

    $stmt = $connection->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue(':' . $key, $value, PDO::PARAM_INT);
    }
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $rows = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = admin_pontos_hydrate_row($row);
    }

    return [
        'rows' => $rows,
        'total' => $total,
        'page' => $page,
        'per_page' => $perPage,
        'total_pages' => $totalPages,
        'linha_id' => $linhaId,
    ];
}

/**
 * @return array{
 *   id:int, letra:string, tipo:?string, audio_url:?string,
 *   linha_id:int, ritmo_id:int, linha_nome:string, ritmo_nome:string
 * }|null
 */
function admin_pontos_find(PDO $connection, int $id): ?array
{
    if ($id <= 0) {
        return null;
    }

    $sql = 'SELECT
                p.`id`,
                p.`letra`,
                p.`tipo`,
                p.`audio_url`,
                p.`linha` AS linha_id,
                p.`ritmo` AS ritmo_id,
                l.`nome` AS linha_nome,
                r.`nome` AS ritmo_nome
            FROM `tb_pontos` p
            INNER JOIN `tb_linhas` l ON l.`id` = p.`linha`
            INNER JOIN `tb_ritmos` r ON r.`id` = p.`ritmo`
            WHERE p.`id` = :id
            LIMIT 1';

    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!is_array($row)) {
        return null;
    }

    return admin_pontos_hydrate_row($row);
}

/**
 * Create a ponto inside a transaction; audit create must succeed or rollback.
 *
 * @param array{letra?:mixed,tipo?:mixed,audio_url?:mixed,linha?:mixed,ritmo?:mixed} $data
 * @param array{user_id?:mixed,username?:mixed} $actor
 */
function admin_pontos_create(PDO $connection, array $data, array $actor): int
{
    $validated = admin_pontos_validate_with_fks($connection, $data);
    if (!$validated['ok']) {
        throw new InvalidArgumentException(implode('; ', $validated['errors']));
    }

    $clean = $validated['clean'];
    $actorUserId = isset($actor['user_id']) ? (int) $actor['user_id'] : null;
    $actorUsername = isset($actor['username']) ? (string) $actor['username'] : 'unknown';

    $connection->beginTransaction();

    try {
        $sql = 'INSERT INTO `tb_pontos` (`letra`, `tipo`, `audio_url`, `linha`, `ritmo`)
                VALUES (:letra, :tipo, :audio_url, :linha, :ritmo)';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':letra', $clean['letra'], PDO::PARAM_STR);
        $stmt->bindValue(':tipo', $clean['tipo'], PDO::PARAM_STR);
        if ($clean['audio_url'] === null) {
            $stmt->bindValue(':audio_url', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':audio_url', $clean['audio_url'], PDO::PARAM_STR);
        }
        $stmt->bindValue(':linha', $clean['linha'], PDO::PARAM_INT);
        $stmt->bindValue(':ritmo', $clean['ritmo'], PDO::PARAM_INT);
        $stmt->execute();

        $newId = (int) $connection->lastInsertId();
        if ($newId <= 0) {
            throw new RuntimeException('Failed to obtain new ponto id');
        }

        $after = admin_pontos_audit_snapshot([
            'id' => $newId,
            'letra' => $clean['letra'],
            'tipo' => $clean['tipo'],
            'audio_url' => $clean['audio_url'],
            'linha' => $clean['linha'],
            'ritmo' => $clean['ritmo'],
        ]);

        writeAuditMutation(
            $connection,
            'create',
            'ponto',
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
 * Update a ponto inside a transaction; audit update must succeed or rollback.
 *
 * @param array{letra?:mixed,tipo?:mixed,audio_url?:mixed,linha?:mixed,ritmo?:mixed} $data
 * @param array{user_id?:mixed,username?:mixed} $actor
 */
function admin_pontos_update(PDO $connection, int $id, array $data, array $actor): void
{
    if ($id <= 0) {
        throw new InvalidArgumentException('Invalid ponto id');
    }

    $validated = admin_pontos_validate_with_fks($connection, $data);
    if (!$validated['ok']) {
        throw new InvalidArgumentException(implode('; ', $validated['errors']));
    }

    $clean = $validated['clean'];
    $actorUserId = isset($actor['user_id']) ? (int) $actor['user_id'] : null;
    $actorUsername = isset($actor['username']) ? (string) $actor['username'] : 'unknown';

    $connection->beginTransaction();

    try {
        $beforeRow = admin_pontos_find_for_audit($connection, $id);
        if ($beforeRow === null) {
            throw new RuntimeException('Ponto not found');
        }

        $sql = 'UPDATE `tb_pontos`
                SET `letra` = :letra,
                    `tipo` = :tipo,
                    `audio_url` = :audio_url,
                    `linha` = :linha,
                    `ritmo` = :ritmo
                WHERE `id` = :id
                LIMIT 1';

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':letra', $clean['letra'], PDO::PARAM_STR);
        $stmt->bindValue(':tipo', $clean['tipo'], PDO::PARAM_STR);
        if ($clean['audio_url'] === null) {
            $stmt->bindValue(':audio_url', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':audio_url', $clean['audio_url'], PDO::PARAM_STR);
        }
        $stmt->bindValue(':linha', $clean['linha'], PDO::PARAM_INT);
        $stmt->bindValue(':ritmo', $clean['ritmo'], PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // MySQL PDO rowCount is 0 when SET values are unchanged; only fail if the row vanished.
        if ($stmt->rowCount() < 1 && admin_pontos_find_for_audit($connection, $id) === null) {
            throw new RuntimeException('Ponto not found');
        }

        $after = admin_pontos_audit_snapshot([
            'id' => $id,
            'letra' => $clean['letra'],
            'tipo' => $clean['tipo'],
            'audio_url' => $clean['audio_url'],
            'linha' => $clean['linha'],
            'ritmo' => $clean['ritmo'],
        ]);

        writeAuditMutation(
            $connection,
            'update',
            'ponto',
            (string) $id,
            admin_pontos_audit_snapshot($beforeRow),
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
 * Delete a ponto inside a transaction; audit delete must succeed or rollback.
 *
 * @param array{user_id?:mixed,username?:mixed} $actor
 */
function admin_pontos_delete(PDO $connection, int $id, array $actor): void
{
    if ($id <= 0) {
        throw new InvalidArgumentException('Invalid ponto id');
    }

    $actorUserId = isset($actor['user_id']) ? (int) $actor['user_id'] : null;
    $actorUsername = isset($actor['username']) ? (string) $actor['username'] : 'unknown';

    $connection->beginTransaction();

    try {
        $beforeRow = admin_pontos_find_for_audit($connection, $id);
        if ($beforeRow === null) {
            throw new RuntimeException('Ponto not found');
        }

        $sql = 'DELETE FROM `tb_pontos` WHERE `id` = :id LIMIT 1';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            throw new RuntimeException('Ponto not found');
        }

        writeAuditMutation(
            $connection,
            'delete',
            'ponto',
            (string) $id,
            admin_pontos_audit_snapshot($beforeRow),
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
 * @param array{letra?:mixed,tipo?:mixed,audio_url?:mixed,linha?:mixed,ritmo?:mixed} $data
 * @return array{ok:bool, errors:string[], clean:array{letra?:string,tipo?:string,audio_url:?string,linha?:int,ritmo?:int}}
 */
function admin_pontos_validate(array $data): array
{
    $errors = [];
    $clean = [];

    $letra = isset($data['letra']) ? trim((string) $data['letra']) : '';
    if ($letra === '') {
        $errors[] = 'Letra é obrigatória.';
    } else {
        $clean['letra'] = $letra;
    }

    $tipoRaw = isset($data['tipo']) ? (string) $data['tipo'] : '';
    $tipo = admin_pontos_normalize_tipo($tipoRaw);
    if ($tipo === null) {
        $errors[] = 'Função inválida. Use: ' . implode(', ', ADMIN_PONTOS_TIPOS) . '.';
    } else {
        $clean['tipo'] = $tipo;
    }

    $linha = filter_var($data['linha'] ?? null, FILTER_VALIDATE_INT);
    if ($linha === false || (int) $linha <= 0) {
        $errors[] = 'Linha é obrigatória.';
    } else {
        $clean['linha'] = (int) $linha;
    }

    $ritmo = filter_var($data['ritmo'] ?? null, FILTER_VALIDATE_INT);
    if ($ritmo === false || (int) $ritmo <= 0) {
        $errors[] = 'Ritmo é obrigatório.';
    } else {
        $clean['ritmo'] = (int) $ritmo;
    }

    $audioRaw = $data['audio_url'] ?? null;
    if ($audioRaw === null || (is_string($audioRaw) && trim($audioRaw) === '')) {
        $clean['audio_url'] = null;
    } else {
        $audio = trim((string) $audioRaw);
        if (!admin_pontos_is_valid_audio_url($audio)) {
            $errors[] = 'Áudio/YouTube URL inválida.';
        } else {
            $clean['audio_url'] = mb_substr($audio, 0, 255);
        }
    }

    return [
        'ok' => $errors === [],
        'errors' => $errors,
        'clean' => $clean,
    ];
}

/**
 * Validate create/update fields including FK existence.
 *
 * @param array{letra?:mixed,tipo?:mixed,audio_url?:mixed,linha?:mixed,ritmo?:mixed} $data
 * @return array{ok:bool, errors:string[], clean:array}
 */
function admin_pontos_validate_with_fks(PDO $connection, array $data): array
{
    $result = admin_pontos_validate($data);
    if (!$result['ok']) {
        return $result;
    }

    $errors = $result['errors'];
    $clean = $result['clean'];

    if (!admin_pontos_fk_exists($connection, 'tb_linhas', $clean['linha'])) {
        $errors[] = 'Linha selecionada não existe.';
    }
    if (!admin_pontos_fk_exists($connection, 'tb_ritmos', $clean['ritmo'])) {
        $errors[] = 'Ritmo selecionado não existe.';
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
function admin_list_linhas_select(PDO $connection): array
{
    $sql = 'SELECT `id`, `nome` FROM `tb_linhas` ORDER BY `nome` ASC';
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
 * @return list<array{id:int, nome:string}>
 */
function admin_list_ritmos_select(PDO $connection): array
{
    $sql = 'SELECT `id`, `nome` FROM `tb_ritmos` ORDER BY `nome` ASC';
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
 * @param array<string,mixed> $row
 * @return array{
 *   id:int, letra:string, tipo:?string, audio_url:?string,
 *   linha_id:int, ritmo_id:int, linha_nome:string, ritmo_nome:string
 * }
 */
function admin_pontos_hydrate_row(array $row): array
{
    return [
        'id' => (int) $row['id'],
        'letra' => (string) $row['letra'],
        'tipo' => isset($row['tipo']) && $row['tipo'] !== null && $row['tipo'] !== ''
            ? (string) $row['tipo']
            : null,
        'audio_url' => isset($row['audio_url']) && $row['audio_url'] !== null && $row['audio_url'] !== ''
            ? (string) $row['audio_url']
            : null,
        'linha_id' => (int) $row['linha_id'],
        'ritmo_id' => (int) $row['ritmo_id'],
        'linha_nome' => (string) $row['linha_nome'],
        'ritmo_nome' => (string) $row['ritmo_nome'],
    ];
}

/**
 * Load ponto columns needed for audit snapshot (no joins).
 *
 * @return array{id:int,letra:string,tipo:?string,audio_url:?string,linha:int,ritmo:int}|null
 */
function admin_pontos_find_for_audit(PDO $connection, int $id): ?array
{
    $sql = 'SELECT `id`, `letra`, `tipo`, `audio_url`, `linha`, `ritmo`
            FROM `tb_pontos`
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
        'letra' => (string) $row['letra'],
        'tipo' => isset($row['tipo']) && $row['tipo'] !== null && $row['tipo'] !== ''
            ? (string) $row['tipo']
            : null,
        'audio_url' => isset($row['audio_url']) && $row['audio_url'] !== null && $row['audio_url'] !== ''
            ? (string) $row['audio_url']
            : null,
        'linha' => (int) $row['linha'],
        'ritmo' => (int) $row['ritmo'],
    ];
}

/**
 * @param array{id:int,letra:string,tipo:?string,audio_url:?string,linha:int,ritmo:int} $row
 * @return array{id:int,letra:string,tipo:?string,audio_url:?string,linha:int,ritmo:int}
 */
function admin_pontos_audit_snapshot(array $row): array
{
    return [
        'id' => (int) $row['id'],
        'letra' => (string) $row['letra'],
        'tipo' => $row['tipo'] ?? null,
        'audio_url' => $row['audio_url'] ?? null,
        'linha' => (int) $row['linha'],
        'ritmo' => (int) $row['ritmo'],
    ];
}

function admin_pontos_fk_exists(PDO $connection, string $table, int $id): bool
{
    if ($table !== 'tb_linhas' && $table !== 'tb_ritmos') {
        return false;
    }

    $sql = "SELECT 1 FROM `{$table}` WHERE `id` = :id LIMIT 1";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return (bool) $stmt->fetchColumn();
}

function admin_pontos_is_valid_audio_url(string $url): bool
{
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        return $scheme === 'http' || $scheme === 'https';
    }

    // Allow bare youtu.be paths used by the public parser.
    if (preg_match('#^(https?://)?(www\.)?youtu\.be/[A-Za-z0-9_-]{6,}#i', $url) === 1) {
        return true;
    }

    if (preg_match('#^youtu\.be/[A-Za-z0-9_-]{6,}#i', $url) === 1) {
        return true;
    }

    return false;
}
