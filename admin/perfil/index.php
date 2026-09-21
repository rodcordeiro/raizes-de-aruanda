<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

requireAuth();

if ($connection === null) {
    http_response_code(503);
    admin_render_header('Meu perfil', 'perfil');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$actor = admin_actor();
$userId = $actor['user_id'];
$profile = admin_profile_find($connection, $userId);

if ($profile === null) {
    http_response_code(404);
    admin_render_header('Meu perfil', 'perfil');
    echo '<p class="admin-alert admin-alert--error" role="alert">Perfil não encontrado.</p>';
    admin_render_footer();
    exit;
}

$errors = [];
$fieldErrors = [];
$form = [
    'name' => $profile['name'],
    'current_password' => '',
    'new_password' => '',
    'new_password_confirm' => '',
];
$flash = admin_flash_take();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = isset($_POST['csrf']) ? (string) $_POST['csrf'] : (isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : null);
    $form = [
        'name' => isset($_POST['name']) ? (string) $_POST['name'] : '',
        'current_password' => isset($_POST['current_password']) ? (string) $_POST['current_password'] : '',
        'new_password' => isset($_POST['new_password']) ? (string) $_POST['new_password'] : '',
        'new_password_confirm' => isset($_POST['new_password_confirm']) ? (string) $_POST['new_password_confirm'] : '',
    ];

    if (!csrf_validate($csrf)) {
        http_response_code(403);
        $errors[] = 'Sessão inválida. Tente novamente.';
    } else {
        try {
            $result = admin_profile_update_self(
                $connection,
                $userId,
                $form['name'],
                $form['current_password'],
                $form['new_password'],
                $form['new_password_confirm'],
                $actor
            );

            if ($result['ok']) {
                admin_flash_set('ok', 'Perfil atualizado.');
                redirect('/admin/perfil/');
            }

            $errors = $result['errors'];
            $fieldErrors = $result['fields'];
        } catch (Throwable $e) {
            if (admin_is_audit_failure($e)) {
                $errors[] = ADMIN_AUDIT_FAIL_MESSAGE;
            } else {
                $errors[] = 'Não foi possível salvar. Tente novamente.';
            }
        }
    }

    $form['current_password'] = '';
    $form['new_password'] = '';
    $form['new_password_confirm'] = '';
}

$token = csrf_token();
$hasErrors = $errors !== [];

admin_render_header('Meu perfil', 'perfil');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title">Meu perfil</h1>
            <p class="admin-page-lead">
                Altere somente o seu nome e a sua senha. Papéis e outros usuários não são editados aqui.
            </p>
        </div>
    </div>

    <?php if ($flash !== null): ?>
        <div
            class="admin-alert <?php echo $flash['type'] === 'error' ? 'admin-alert--error' : 'admin-alert--ok'; ?>"
            role="status"
        >
            <p><strong><?php echo admin_h($flash['message']); ?></strong></p>
            <?php if ($flash['type'] !== 'error'): ?>
                <p>Suas alterações foram salvas.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($hasErrors): ?>
        <div class="admin-alert admin-alert--error" role="alert">
            <p><strong>Não foi possível salvar</strong></p>
            <p>Corrija os campos marcados. Nada foi alterado.</p>
        </div>
    <?php endif; ?>

    <form class="admin-form" method="post" action="/admin/perfil/" novalidate>
        <input type="hidden" name="csrf" value="<?php echo admin_h($token); ?>">

        <div class="admin-field">
            <label class="admin-label" for="name">Nome</label>
            <input
                class="admin-input<?php echo isset($fieldErrors['name']) ? ' is-invalid' : ''; ?>"
                id="name"
                name="name"
                type="text"
                maxlength="255"
                required
                autocomplete="name"
                value="<?php echo admin_h($form['name']); ?>"
                <?php if (isset($fieldErrors['name'])): ?>
                    aria-invalid="true"
                    aria-describedby="name-error"
                <?php endif; ?>
            >
            <?php if (isset($fieldErrors['name'])): ?>
                <p class="admin-field__error" id="name-error"><?php echo admin_h($fieldErrors['name']); ?></p>
            <?php endif; ?>
        </div>

        <div class="admin-field">
            <label class="admin-label" for="current_password">Senha atual</label>
            <input
                class="admin-input<?php echo isset($fieldErrors['current_password']) ? ' is-invalid' : ''; ?>"
                id="current_password"
                name="current_password"
                type="password"
                required
                autocomplete="current-password"
                <?php if (isset($fieldErrors['current_password'])): ?>
                    aria-invalid="true"
                    aria-describedby="current_password-error current_password-hint"
                <?php else: ?>
                    aria-describedby="current_password-hint"
                <?php endif; ?>
            >
            <p class="admin-hint" id="current_password-hint">Obrigatória para confirmar qualquer alteração.</p>
            <?php if (isset($fieldErrors['current_password'])): ?>
                <p class="admin-field__error" id="current_password-error"><?php echo admin_h($fieldErrors['current_password']); ?></p>
            <?php endif; ?>
        </div>

        <div class="admin-field">
            <label class="admin-label" for="new_password">Nova senha</label>
            <input
                class="admin-input<?php echo isset($fieldErrors['new_password']) ? ' is-invalid' : ''; ?>"
                id="new_password"
                name="new_password"
                type="password"
                autocomplete="new-password"
                aria-describedby="new_password-hint"
            >
            <p class="admin-hint" id="new_password-hint">Preencha só se quiser trocar a senha.</p>
        </div>

        <div class="admin-field">
            <label class="admin-label" for="new_password_confirm">Confirmar nova senha</label>
            <input
                class="admin-input<?php echo isset($fieldErrors['new_password_confirm']) ? ' is-invalid' : ''; ?>"
                id="new_password_confirm"
                name="new_password_confirm"
                type="password"
                autocomplete="new-password"
                <?php if (isset($fieldErrors['new_password_confirm'])): ?>
                    aria-invalid="true"
                    aria-describedby="new_password_confirm-error"
                <?php endif; ?>
            >
            <?php if (isset($fieldErrors['new_password_confirm'])): ?>
                <p class="admin-field__error" id="new_password_confirm-error"><?php echo admin_h($fieldErrors['new_password_confirm']); ?></p>
            <?php endif; ?>
        </div>

        <div class="admin-form__actions">
            <button class="admin-btn admin-btn--save-profile" type="submit">Salvar alterações</button>
        </div>
    </form>
<?php
admin_render_footer();
