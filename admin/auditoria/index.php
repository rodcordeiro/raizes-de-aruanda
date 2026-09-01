<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

requireAuth();

if (!hasPermission('audit:read')) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Acesso negado.';
    exit;
}

if ($connection === null) {
    http_response_code(503);
    admin_render_header('Auditoria', 'auditoria');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$list = admin_audit_list($connection, $page);
$rows = $list['rows'];
$total = $list['total'];
$currentPage = $list['page'];
$totalPages = $list['total_pages'];

$buildListUrl = static function (int $pageNum): string {
    $params = [];
    if ($pageNum > 1) {
        $params['page'] = $pageNum;
    }
    $query = http_build_query($params);
    return '/admin/auditoria/' . ($query !== '' ? '?' . $query : '');
};

admin_render_header('Auditoria', 'auditoria');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title">Auditoria</h1>
            <p class="admin-page-lead">
                Registro de alterações e eventos do admin. Somente leitura.
            </p>
        </div>
    </div>

    <?php if ($rows === []): ?>
        <p class="admin-empty">Nenhum evento de auditoria registrado ainda.</p>
    <?php else: ?>
        <p class="admin-list-meta" aria-live="polite">
            <?php echo admin_h(admin_format_list_meta('evento', 'eventos', $list)); ?>
        </p>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th scope="col">Quando</th>
                        <th scope="col">Quem</th>
                        <th scope="col">Ação</th>
                        <th scope="col">Recurso</th>
                        <th scope="col">Origem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $resourceType = trim((string) ($row['resource_type'] ?? ''));
                        $resourceId = isset($row['resource_id']) && $row['resource_id'] !== null && $row['resource_id'] !== ''
                            ? (string) $row['resource_id']
                            : '';
                        $resourceLabel = $resourceType !== ''
                            ? ($resourceId !== '' ? $resourceType . ' #' . $resourceId : $resourceType)
                            : '—';
                        ?>
                        <tr>
                            <td class="admin-table__when"><?php echo admin_h((string) ($row['created_at'] ?? '')); ?></td>
                            <td><?php echo admin_h((string) ($row['actor_username'] ?? '')); ?></td>
                            <td><?php echo admin_h((string) ($row['action'] ?? '')); ?></td>
                            <td><?php echo admin_h($resourceLabel); ?></td>
                            <td><?php echo admin_h((string) (($row['origin'] ?? '') !== '' ? $row['origin'] : '—')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="admin-pagination" aria-label="Paginação de auditoria">
                <?php if ($currentPage > 1): ?>
                    <a class="admin-btn admin-btn--ghost" href="<?php echo admin_h($buildListUrl($currentPage - 1)); ?>">Anterior</a>
                <?php else: ?>
                    <span class="admin-btn admin-btn--ghost is-disabled" aria-disabled="true">Anterior</span>
                <?php endif; ?>

                <span class="admin-pagination__status"><?php echo admin_h(admin_format_pagination_status($list)); ?></span>

                <?php if ($currentPage < $totalPages): ?>
                    <a class="admin-btn admin-btn--ghost" href="<?php echo admin_h($buildListUrl($currentPage + 1)); ?>">Próxima</a>
                <?php else: ?>
                    <span class="admin-btn admin-btn--ghost is-disabled" aria-disabled="true">Próxima</span>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
<?php
admin_render_footer();
