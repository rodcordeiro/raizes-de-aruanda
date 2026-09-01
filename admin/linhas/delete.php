<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

requirePermission('linha:delete');

if ($connection === null) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        admin_flash_set('error', 'Serviço indisponível. Tente novamente mais tarde.');
        redirect('/admin/linhas/');
    }
    http_response_code(503);
    admin_render_header('Excluir linha', 'linhas');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$id = $_SERVER['REQUEST_METHOD'] === 'POST'
    ? (isset($_POST['id']) ? (int) $_POST['id'] : 0)
    : (isset($_GET['id']) ? (int) $_GET['id'] : 0);

$linha = admin_linhas_find($connection, $id);
if ($linha === null) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        admin_flash_set('error', 'Linha não encontrada.');
        redirect('/admin/linhas/');
    }
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Linha não encontrada.';
    exit;
}

$pontosCount = admin_linhas_count_pontos($connection, $id);
$blocked = $pontosCount > 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = isset($_POST['csrf'])
        ? (string) $_POST['csrf']
        : (isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : null);

    if (!csrf_validate($csrf)) {
        admin_flash_set('error', 'Sessão inválida. Tente novamente.');
        redirect('/admin/linhas/');
    }

    if ($blocked) {
        admin_flash_set('error', 'Não é possível excluir: existem pontos ligados a esta linha.');
        redirect('/admin/linhas/');
    }

    try {
        admin_linhas_delete($connection, $id, admin_actor());
        admin_flash_set('ok', 'Linha excluída.');
        redirect('/admin/linhas/');
    } catch (InvalidArgumentException $e) {
        admin_flash_set('error', $e->getMessage() !== '' ? $e->getMessage() : 'Linha inválida.');
        redirect('/admin/linhas/');
    } catch (Throwable $e) {
        if (admin_is_audit_failure($e)) {
            admin_flash_set('error', ADMIN_AUDIT_FAIL_MESSAGE);
        } elseif (str_contains($e->getMessage(), 'not found')) {
            admin_flash_set('error', 'Linha não encontrada.');
        } else {
            admin_flash_set('error', 'Não foi possível excluir. Tente novamente.');
        }
        redirect('/admin/linhas/');
    }
}

$token = csrf_token();
$saudacao = isset($linha['saudacao']) ? trim((string) $linha['saudacao']) : '';

admin_render_header('Excluir linha', 'linhas');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title">Excluir linha</h1>
            <p class="admin-page-lead">Confirme a exclusão desta linha do catálogo. Esta ação não pode ser desfeita.</p>
        </div>
    </div>

    <?php if ($blocked): ?>
        <p class="admin-alert admin-alert--error" role="alert">
            Não é possível excluir: existem <?php echo (int) $pontosCount; ?> ponto<?php echo $pontosCount === 1 ? '' : 's'; ?> ligado<?php echo $pontosCount === 1 ? '' : 's'; ?> a esta linha.
        </p>
        <p class="admin-form__actions">
            <a class="admin-btn admin-btn--ghost" href="/admin/linhas/">Voltar</a>
        </p>
    <?php else: ?>
        <form class="admin-form" method="post" action="/admin/linhas/delete.php">
            <input type="hidden" name="csrf" value="<?php echo admin_h($token); ?>">
            <input type="hidden" name="id" value="<?php echo (int) $linha['id']; ?>">

            <p class="admin-dialog__preview"><?php echo admin_h((string) $linha['nome']); ?></p>
            <p class="admin-hint">
                <?php echo admin_h((string) ($linha['categoria_nome'] ?? '')); ?>
                <?php if ($saudacao !== ''): ?>
                    · <?php echo admin_h($saudacao); ?>
                <?php endif; ?>
            </p>

            <div class="admin-form__actions">
                <button type="submit" class="admin-btn admin-btn--danger">Excluir</button>
                <a class="admin-btn admin-btn--ghost" href="/admin/linhas/">Cancelar</a>
            </div>
        </form>
    <?php endif; ?>
<?php
admin_render_footer();
