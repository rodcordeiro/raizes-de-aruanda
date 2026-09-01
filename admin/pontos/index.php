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
$rows = admin_pontos_list($connection);

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

    <?php if ($rows === []): ?>
        <p class="admin-empty">
            Nenhum ponto cadastrado ainda.<?php echo $canCreate ? ' Use “Novo ponto” para começar.' : ''; ?>
        </p>
    <?php else: ?>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th scope="col">Linha</th>
                        <th scope="col">Ritmo</th>
                        <th scope="col">Função</th>
                        <th scope="col">Letra</th>
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
                            <td><?php echo admin_h((string) $row['linha_nome']); ?></td>
                            <td><?php echo admin_h((string) $row['ritmo_nome']); ?></td>
                            <td><?php echo admin_h(admin_ponto_funcao_label($row['tipo'] ?? null)); ?></td>
                            <td class="admin-table__letra"><?php echo admin_h($preview); ?></td>
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
    <?php endif; ?>
<?php
admin_render_footer();
