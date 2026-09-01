<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

admin_require_catalog_read();

if ($connection === null) {
    http_response_code(503);
    admin_render_header('Linhas', 'linhas');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$canCreate = hasPermission('linha:create');
$canUpdate = hasPermission('linha:update');
$canDelete = hasPermission('linha:delete');

$flash = admin_flash_take();
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$list = admin_linhas_list($connection, $page);
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
    return '/admin/linhas/' . ($query !== '' ? '?' . $query : '');
};

admin_render_header('Linhas', 'linhas');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title">Linhas</h1>
            <p class="admin-page-lead">
                Correntes de trabalho do catálogo: nome, categoria e saudação opcional.
            </p>
        </div>
        <?php if ($canCreate): ?>
            <a class="admin-btn" href="/admin/linhas/form.php">Nova linha</a>
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
            Nenhuma linha cadastrada ainda.<?php echo $canCreate ? ' Use “Nova linha” para começar.' : ''; ?>
        </p>
    <?php else: ?>
        <p class="admin-list-meta" aria-live="polite">
            <?php echo admin_h(admin_format_list_meta('linha', 'linhas', $list)); ?>
        </p>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Saudação</th>
                        <th scope="col">Canal do YouTube</th>
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
                            <td><?php echo admin_h((string) ($row['categoria_nome'] ?? '')); ?></td>
                            <td><?php
                                $saudacao = isset($row['saudacao']) ? trim((string) $row['saudacao']) : '';
                                echo $saudacao !== '' ? admin_h($saudacao) : '—';
                            ?></td>
                            <td>
                                <?php
                                $canal = isset($row['canal_youtube']) ? trim((string) $row['canal_youtube']) : '';
                                echo $canal !== '' ? admin_h($canal) : '—';
                                ?>
                            </td>
                            <?php if ($canUpdate || $canDelete): ?>
                                <td class="admin-table__actions">
                                    <div class="admin-actions">
                                        <?php if ($canUpdate): ?>
                                            <a class="admin-btn admin-btn--ghost" href="/admin/linhas/form.php?id=<?php echo $id; ?>">Editar</a>
                                        <?php endif; ?>
                                        <?php if ($canDelete): ?>
                                            <a class="admin-btn admin-btn--danger" href="/admin/linhas/delete.php?id=<?php echo $id; ?>">Excluir</a>
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
            <nav class="admin-pagination" aria-label="Paginação de linhas">
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
