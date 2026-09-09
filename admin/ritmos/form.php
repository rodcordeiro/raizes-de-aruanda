<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

requireAuth();

if ($connection === null) {
    http_response_code(503);
    admin_render_header('Ritmos', 'ritmos');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isEdit = $id > 0;

if ($isEdit) {
    requirePermission('ritmo:update');
    $ritmo = admin_ritmos_find($connection, $id);
    if ($ritmo === null) {
        http_response_code(404);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Ritmo não encontrado.';
        exit;
    }
} else {
    requirePermission('ritmo:create');
    $ritmo = null;
}

$errors = [];
$form = [
    'nome' => $ritmo['nome'] ?? '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = isset($_POST['csrf']) ? (string) $_POST['csrf'] : (isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : null);
    if (!csrf_validate($csrf)) {
        http_response_code(403);
        $errors[] = 'Sessão inválida. Tente novamente.';
    } else {
        $form = [
            'nome' => isset($_POST['nome']) ? (string) $_POST['nome'] : '',
        ];

        $data = [
            'nome' => $form['nome'],
        ];

        try {
            if ($isEdit) {
                admin_ritmos_update($connection, $id, $data, admin_actor());
                admin_flash_set('ok', 'Ritmo atualizado.');
                redirect('/admin/ritmos/');
            }

            admin_ritmos_create($connection, $data, admin_actor());
            admin_flash_set('ok', 'Ritmo criado.');
            redirect('/admin/ritmos/');
        } catch (InvalidArgumentException $e) {
            $parts = array_filter(array_map('trim', explode(';', $e->getMessage())));
            $errors = $parts !== [] ? array_values($parts) : [$e->getMessage()];
        } catch (Throwable $e) {
            if (admin_is_audit_failure($e)) {
                $errors[] = ADMIN_AUDIT_FAIL_MESSAGE;
            } elseif (str_contains($e->getMessage(), 'not found')) {
                $errors[] = 'Ritmo não encontrado.';
            } else {
                $errors[] = 'Não foi possível salvar. Tente novamente.';
            }
        }
    }
}

$pageTitle = $isEdit ? 'Editar ritmo' : 'Novo ritmo';
$token = csrf_token();
$formAction = $isEdit ? '/admin/ritmos/form.php?id=' . $id : '/admin/ritmos/form.php';

admin_render_header($pageTitle, 'ritmos');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title"><?php echo admin_h($pageTitle); ?></h1>
            <p class="admin-page-lead">
                <?php echo $isEdit
                    ? 'Atualize o nome deste ritmo.'
                    : 'Cadastre um ritmo pelo nome do toque.'; ?>
            </p>
        </div>
    </div>

    <?php if ($errors !== []): ?>
        <div class="admin-alert admin-alert--error" role="alert">
            <?php foreach ($errors as $err): ?>
                <p><?php echo admin_h((string) $err); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form class="admin-form" method="post" action="<?php echo admin_h($formAction); ?>">
        <input type="hidden" name="csrf" value="<?php echo admin_h($token); ?>">

        <div class="admin-field">
            <label class="admin-label" for="nome">Nome</label>
            <input
                class="admin-input"
                id="nome"
                name="nome"
                type="text"
                required
                maxlength="255"
                value="<?php echo admin_h((string) $form['nome']); ?>"
            >
        </div>

        <div class="admin-form__actions">
            <button class="admin-btn" type="submit"><?php echo $isEdit ? 'Salvar' : 'Criar ritmo'; ?></button>
            <a class="admin-btn admin-btn--ghost" href="/admin/ritmos/">Cancelar</a>
        </div>
    </form>
<?php
admin_render_footer();
