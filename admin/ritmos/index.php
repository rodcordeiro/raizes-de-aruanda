<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

admin_require_catalog_read();

if ($connection === null) {
    http_response_code(503);
    admin_render_header('Ritmos', 'ritmos');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$canCreate = hasPermission('ritmo:create');
$canUpdate = hasPermission('ritmo:update');
$canDelete = hasPermission('ritmo:delete');

$flash = admin_flash_take();
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$list = admin_ritmos_list($connection, $page);
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
    return '/admin/ritmos/' . ($query !== '' ? '?' . $query : '');
};

admin_render_header('Ritmos', 'ritmos');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title">Ritmos</h1>
            <p class="admin-page-lead">
                Toques de atabaque do catálogo: cada ritmo nomeia o compasso dos pontos.
            </p>
        </div>
        <?php if ($canCreate): ?>
            <a class="admin-btn" href="/admin/ritmos/form.php">Novo ritmo</a>
        <?php endif; ?>
    </div>

    <?php if ($flash !== null): ?>
        <p
            class="admin-alert <?php echo $flash['type'] === 'error' ? 'admin-alert--error' : 'admin-alert--ok'; ?>"
            role="status"
        ><?php echo admin_h($flash['message']); ?></p>
    <?php endif; ?>

    <?php if ($rows === []): ?>
        <p class="admin-empty">
            Nenhum ritmo cadastrado ainda.<?php echo $canCreate ? ' Use “Novo ritmo” para começar.' : ''; ?>
        </p>
    <?php else: ?>
        <p class="admin-list-meta" aria-live="polite">
            <?php echo (int) $total; ?> ritmo<?php echo $total === 1 ? '' : 's'; ?>
            <?php if ($totalPages > 1): ?>
                · Página <?php echo (int) $currentPage; ?> de <?php echo (int) $totalPages; ?>
            <?php endif; ?>
        </p>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <?php if ($canUpdate || $canDelete): ?>
                            <th scope="col">Ações</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <?php $id = (int) $row['id']; ?>
                        <tr>
                            <td><?php echo admin_h((string) $row['nome']); ?></td>
                            <?php if ($canUpdate || $canDelete): ?>
                                <td class="admin-table__actions">
                                    <div class="admin-actions">
                                        <?php if ($canUpdate): ?>
                                            <a class="admin-btn admin-btn--ghost" href="/admin/ritmos/form.php?id=<?php echo $id; ?>">Editar</a>
                                        <?php endif; ?>
                                        <?php if ($canDelete): ?>
                                            <a class="admin-btn admin-btn--danger" href="/admin/ritmos/delete.php?id=<?php echo $id; ?>">Excluir</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="admin-pagination" aria-label="Paginação de ritmos">
                <?php if ($currentPage > 1): ?>
                    <a class="admin-btn admin-btn--ghost" href="<?php echo admin_h($buildListUrl($currentPage - 1)); ?>">Anterior</a>
                <?php else: ?>
                    <span class="admin-btn admin-btn--ghost is-disabled" aria-disabled="true">Anterior</span>
                <?php endif; ?>

                <span class="admin-pagination__status">Página <?php echo (int) $currentPage; ?> de <?php echo (int) $totalPages; ?></span>

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
