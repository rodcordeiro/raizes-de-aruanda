<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

requirePermission('ritmo:delete');

if ($connection === null) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        admin_flash_set('error', 'Serviço indisponível. Tente novamente mais tarde.');
        redirect('/admin/ritmos/');
    }
    http_response_code(503);
    admin_render_header('Excluir ritmo', 'ritmos');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$id = $_SERVER['REQUEST_METHOD'] === 'POST'
    ? (isset($_POST['id']) ? (int) $_POST['id'] : 0)
    : (isset($_GET['id']) ? (int) $_GET['id'] : 0);

$ritmo = admin_ritmos_find($connection, $id);
if ($ritmo === null) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        admin_flash_set('error', 'Ritmo não encontrado.');
        redirect('/admin/ritmos/');
    }
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Ritmo não encontrado.';
    exit;
}

$pontosCount = admin_ritmos_count_pontos($connection, $id);
$blocked = $pontosCount > 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = isset($_POST['csrf'])
        ? (string) $_POST['csrf']
        : (isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : null);

    if (!csrf_validate($csrf)) {
        admin_flash_set('error', 'Sessão inválida. Tente novamente.');
        redirect('/admin/ritmos/');
    }

    if ($blocked) {
        admin_flash_set('error', 'Não é possível excluir: existem pontos ligados a este ritmo.');
        redirect('/admin/ritmos/');
    }

    try {
        admin_ritmos_delete($connection, $id, admin_actor());
        admin_flash_set('ok', 'Ritmo excluído.');
        redirect('/admin/ritmos/');
    } catch (InvalidArgumentException $e) {
        admin_flash_set('error', $e->getMessage() !== '' ? $e->getMessage() : 'Ritmo inválido.');
        redirect('/admin/ritmos/');
    } catch (Throwable $e) {
        if (admin_is_audit_failure($e)) {
            admin_flash_set('error', ADMIN_AUDIT_FAIL_MESSAGE);
        } elseif (str_contains($e->getMessage(), 'not found')) {
            admin_flash_set('error', 'Ritmo não encontrado.');
        } else {
            admin_flash_set('error', 'Não foi possível excluir. Tente novamente.');
        }
        redirect('/admin/ritmos/');
    }
}

$token = csrf_token();

admin_render_header('Excluir ritmo', 'ritmos');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title">Excluir ritmo</h1>
            <p class="admin-page-lead">Confirme a exclusão deste ritmo do catálogo. Esta ação não pode ser desfeita.</p>
        </div>
    </div>

    <?php if ($blocked): ?>
        <p class="admin-alert admin-alert--error" role="alert">
            Não é possível excluir: existem <?php echo (int) $pontosCount; ?> ponto<?php echo $pontosCount === 1 ? '' : 's'; ?> ligado<?php echo $pontosCount === 1 ? '' : 's'; ?> a este ritmo.
        </p>
        <p class="admin-form__actions">
            <a class="admin-btn admin-btn--ghost" href="/admin/ritmos/">Voltar</a>
        </p>
    <?php else: ?>
        <form class="admin-form" method="post" action="/admin/ritmos/delete.php">
            <input type="hidden" name="csrf" value="<?php echo admin_h($token); ?>">
            <input type="hidden" name="id" value="<?php echo (int) $ritmo['id']; ?>">

            <p class="admin-dialog__preview"><?php echo admin_h((string) $ritmo['nome']); ?></p>

            <div class="admin-form__actions">
                <button type="submit" class="admin-btn admin-btn--danger">Excluir</button>
                <a class="admin-btn admin-btn--ghost" href="/admin/ritmos/">Cancelar</a>
            </div>
        </form>
    <?php endif; ?>
<?php
admin_render_footer();
