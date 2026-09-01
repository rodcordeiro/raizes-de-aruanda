<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

requirePermission('ponto:delete');

if ($connection === null) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        admin_flash_set('error', 'Serviço indisponível. Tente novamente mais tarde.');
        redirect('/admin/pontos/');
    }
    http_response_code(503);
    admin_render_header('Excluir ponto');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$id = $_SERVER['REQUEST_METHOD'] === 'POST'
    ? (isset($_POST['id']) ? (int) $_POST['id'] : 0)
    : (isset($_GET['id']) ? (int) $_GET['id'] : 0);

$ponto = admin_pontos_find($connection, $id);
if ($ponto === null) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        admin_flash_set('error', 'Ponto não encontrado.');
        redirect('/admin/pontos/');
    }
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Ponto não encontrado.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = isset($_POST['csrf'])
        ? (string) $_POST['csrf']
        : (isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : null);

    if (!csrf_validate($csrf)) {
        admin_flash_set('error', 'Sessão inválida. Tente novamente.');
        redirect('/admin/pontos/');
    }

    try {
        admin_pontos_delete($connection, $id, admin_actor());
        admin_flash_set('ok', 'Ponto excluído.');
        redirect('/admin/pontos/');
    } catch (InvalidArgumentException $e) {
        admin_flash_set('error', 'Ponto inválido.');
        redirect('/admin/pontos/');
    } catch (Throwable $e) {
        if (admin_is_audit_failure($e)) {
            admin_flash_set('error', ADMIN_AUDIT_FAIL_MESSAGE);
        } elseif (str_contains($e->getMessage(), 'not found')) {
            admin_flash_set('error', 'Ponto não encontrado.');
        } else {
            admin_flash_set('error', 'Não foi possível excluir. Tente novamente.');
        }
        redirect('/admin/pontos/');
    }
}

$preview = admin_truncate((string) $ponto['letra'], 160);
$token = csrf_token();

admin_render_header('Excluir ponto', 'pontos');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title">Excluir ponto</h1>
            <p class="admin-page-lead">Confirme a exclusão deste ponto do catálogo. Esta ação não pode ser desfeita.</p>
        </div>
    </div>

    <form class="admin-form" method="post" action="/admin/pontos/delete.php">
        <input type="hidden" name="csrf" value="<?php echo admin_h($token); ?>">
        <input type="hidden" name="id" value="<?php echo (int) $ponto['id']; ?>">

        <p class="admin-dialog__preview"><?php echo admin_h($preview); ?></p>
        <p class="admin-hint">
            <?php echo admin_h((string) $ponto['linha_nome']); ?>
            · <?php echo admin_h((string) $ponto['ritmo_nome']); ?>
            · <?php echo admin_h(admin_ponto_funcao_label($ponto['tipo'] ?? null)); ?>
        </p>

        <div class="admin-form__actions">
            <button type="submit" class="admin-btn admin-btn--danger">Excluir</button>
            <a class="admin-btn admin-btn--ghost" href="/admin/pontos/">Cancelar</a>
        </div>
    </form>
<?php
admin_render_footer();
