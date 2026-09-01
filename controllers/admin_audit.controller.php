<?php

/**
 * Admin read-only list for tb_audit_logs.
 * No mutations / purge.
 */

/** Default page size for admin audit list. */
const ADMIN_AUDIT_PER_PAGE = 20;

/**
 * Paginated audit log rows (lean columns; no before/after JSON).
 *
 * @return array{
 *   rows: list<array{
 *     id:int,
 *     created_at:string,
 *     actor_username:string,
 *     action:string,
 *     resource_type:string,
 *     resource_id:?string,
 *     origin:?string
 *   }>,
 *   total: int,
 *   page: int,
 *   per_page: int,
 *   total_pages: int
 * }
 */
function admin_audit_list(PDO $connection, int $page = 1, int $perPage = ADMIN_AUDIT_PER_PAGE): array
{
    if ($perPage < 1) {
        $perPage = ADMIN_AUDIT_PER_PAGE;
    }
    if ($page < 1) {
        $page = 1;
    }

    $countStmt = $connection->prepare('SELECT COUNT(*) FROM `tb_audit_logs`');
    $countStmt->execute();
    $total = (int) $countStmt->fetchColumn();

    $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 1;
    if ($page > $totalPages) {
        $page = $totalPages;
    }
    $offset = ($page - 1) * $perPage;

    $sql = 'SELECT
                `id`,
                `created_at`,
                `actor_username`,
                `action`,
                `resource_type`,
                `resource_id`,
                `origin`
            FROM `tb_audit_logs`
            ORDER BY `created_at` DESC, `id` DESC
            LIMIT :limit OFFSET :offset';

    $stmt = $connection->prepare($sql);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $rows = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = [
            'id' => (int) $row['id'],
            'created_at' => (string) $row['created_at'],
            'actor_username' => (string) $row['actor_username'],
            'action' => (string) $row['action'],
            'resource_type' => (string) $row['resource_type'],
            'resource_id' => isset($row['resource_id']) && $row['resource_id'] !== null && $row['resource_id'] !== ''
                ? (string) $row['resource_id']
                : null,
            'origin' => isset($row['origin']) && $row['origin'] !== null && $row['origin'] !== ''
                ? (string) $row['origin']
                : null,
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
