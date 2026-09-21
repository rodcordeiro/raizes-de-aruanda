<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

admin_require_catalog_read();

if ($connection === null) {
    http_response_code(503);
    admin_render_header('Pontos');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$canCreate = hasPermission('ponto:create');
$canUpdate = hasPermission('ponto:update');
$canDelete = hasPermission('ponto:delete');

$flash = admin_flash_take();
$linhas = admin_list_linhas_select($connection);

$linhaFilter = isset($_GET['linha']) ? (int) $_GET['linha'] : 0;
$linhaId = $linhaFilter > 0 ? $linhaFilter : null;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$list = admin_pontos_list($connection, $linhaId, $page);
$rows = $list['rows'];
$total = $list['total'];
$currentPage = $list['page'];
$totalPages = $list['total_pages'];

$buildListUrl = static function (?int $linha, int $pageNum): string {
    $params = [];
    if ($linha !== null && $linha > 0) {
        $params['linha'] = $linha;
    }
    if ($pageNum > 1) {
        $params['page'] = $pageNum;
    }
    $query = http_build_query($params);
    return '/admin/pontos/' . ($query !== '' ? '?' . $query : '');
};

admin_render_header('Pontos', 'pontos');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title">Pontos</h1>
            <p class="admin-page-lead">
                Catálogo de pontos: cada registro une letra, ritmo e função (chamada, sustentação ou subida) à sua linha.
            </p>
        </div>
        <?php if ($canCreate): ?>
            <a class="admin-btn" href="/admin/pontos/form.php">Novo ponto</a>
        <?php endif; ?>
    </div>

    <?php if ($flash !== null): ?>
        <p
            class="admin-alert <?php echo $flash['type'] === 'error' ? 'admin-alert--error' : 'admin-alert--ok'; ?>"
            role="status"
        ><?php echo admin_h($flash['message']); ?></p>
    <?php endif; ?>

    <form class="admin-toolbar" method="get" action="/admin/pontos/">
        <div class="admin-field admin-toolbar__filter">
            <label class="admin-label" for="filtro-linha">Filtrar por linha</label>
            <select class="admin-select" id="filtro-linha" name="linha" onchange="this.form.submit()">
                <option value="">Todas as linhas</option>
                <?php foreach ($linhas as $linha): ?>
                    <?php $lid = (int) $linha['id']; ?>
                    <option value="<?php echo $lid; ?>"<?php echo $linhaId === $lid ? ' selected' : ''; ?>>
                        <?php echo admin_h((string) $linha['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <noscript>
            <button class="admin-btn admin-btn--ghost" type="submit">Filtrar</button>
        </noscript>
    </form>

    <?php if ($rows === []): ?>
        <p class="admin-empty">
            <?php if ($linhaId !== null): ?>
                Nenhum ponto nesta linha.
            <?php else: ?>
                Nenhum ponto cadastrado ainda.<?php echo $canCreate ? ' Use “Novo ponto” para começar.' : ''; ?>
            <?php endif; ?>
        </p>
    <?php else: ?>
        <p class="admin-list-meta" aria-live="polite">
            <?php echo admin_h(admin_format_list_meta('ponto', 'pontos', $list)); ?>
        </p>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th scope="col">Letra</th>
                        <th scope="col">Função</th>
                        <th scope="col">Linha</th>
                        <th scope="col">Ritmo</th>
                        <th scope="col">Gravar</th>
                        <?php if ($canUpdate || $canDelete): ?>
                            <th scope="col">Ações</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <?php
                        $id = (int) $row['id'];
                        $preview = admin_truncate((string) $row['letra'], 80);
                        ?>
                        <tr>
                            <td class="admin-table__letra"><?php echo admin_h($preview); ?></td>
                            <td><?php echo admin_h(admin_ponto_funcao_label($row['tipo'] ?? null)); ?></td>
                            <td><?php echo admin_h((string) $row['linha_nome']); ?></td>
                            <td><?php echo admin_h((string) $row['ritmo_nome']); ?></td>
                            <td><?php echo !empty($row['gravar_audio']) ? 'Sim' : '—'; ?></td>
                            <?php if ($canUpdate || $canDelete): ?>
                                <td class="admin-table__actions">
                                    <div class="admin-actions">
                                        <?php if ($canUpdate): ?>
                                            <a class="admin-btn admin-btn--ghost" href="/admin/pontos/form.php?id=<?php echo $id; ?>">Editar</a>
                                        <?php endif; ?>
                                        <?php if ($canDelete): ?>
                                            <a class="admin-btn admin-btn--danger" href="/admin/pontos/delete.php?id=<?php echo $id; ?>">Excluir</a>
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
            <nav class="admin-pagination" aria-label="Paginação do catálogo">
                <?php if ($currentPage > 1): ?>
                    <a class="admin-btn admin-btn--ghost" href="<?php echo admin_h($buildListUrl($linhaId, $currentPage - 1)); ?>">Anterior</a>
                <?php else: ?>
                    <span class="admin-btn admin-btn--ghost is-disabled" aria-disabled="true">Anterior</span>
                <?php endif; ?>

                <span class="admin-pagination__status"><?php echo admin_h(admin_format_pagination_status($list)); ?></span>

                <?php if ($currentPage < $totalPages): ?>
                    <a class="admin-btn admin-btn--ghost" href="<?php echo admin_h($buildListUrl($linhaId, $currentPage + 1)); ?>">Próxima</a>
                <?php else: ?>
                    <span class="admin-btn admin-btn--ghost is-disabled" aria-disabled="true">Próxima</span>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
<?php
admin_render_footer();
