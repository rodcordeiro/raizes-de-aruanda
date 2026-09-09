<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

requireAuth();

if ($connection === null) {
    http_response_code(503);
    admin_render_header('Linhas', 'linhas');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isEdit = $id > 0;

if ($isEdit) {
    requirePermission('linha:update');
    $linha = admin_linhas_find($connection, $id);
    if ($linha === null) {
        http_response_code(404);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Linha não encontrada.';
        exit;
    }
} else {
    requirePermission('linha:create');
    $linha = null;
}

$categorias = admin_list_categorias_select($connection);

$errors = [];
$form = [
    'nome' => $linha['nome'] ?? '',
    'categoria' => isset($linha['categoria_id']) ? (string) (int) $linha['categoria_id'] : '',
    'canal_youtube' => $linha['canal_youtube'] ?? '',
    'saudacao' => $linha['saudacao'] ?? '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = isset($_POST['csrf']) ? (string) $_POST['csrf'] : (isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : null);
    if (!csrf_validate($csrf)) {
        http_response_code(403);
        $errors[] = 'Sessão inválida. Tente novamente.';
    } else {
        $form = [
            'nome' => isset($_POST['nome']) ? (string) $_POST['nome'] : '',
            'categoria' => isset($_POST['categoria']) ? (string) $_POST['categoria'] : '',
            'canal_youtube' => isset($_POST['canal_youtube']) ? (string) $_POST['canal_youtube'] : '',
            'saudacao' => isset($_POST['saudacao']) ? (string) $_POST['saudacao'] : '',
        ];

        $data = [
            'nome' => $form['nome'],
            'categoria' => $form['categoria'],
            'canal_youtube' => $form['canal_youtube'],
            'saudacao' => $form['saudacao'],
        ];

        try {
            if ($isEdit) {
                admin_linhas_update($connection, $id, $data, admin_actor());
                admin_flash_set('ok', 'Linha atualizada.');
                redirect('/admin/linhas/');
            }

            admin_linhas_create($connection, $data, admin_actor());
            admin_flash_set('ok', 'Linha criada.');
            redirect('/admin/linhas/');
        } catch (InvalidArgumentException $e) {
            $parts = array_filter(array_map('trim', explode(';', $e->getMessage())));
            $errors = $parts !== [] ? array_values($parts) : [$e->getMessage()];
        } catch (Throwable $e) {
            if (admin_is_audit_failure($e)) {
                $errors[] = ADMIN_AUDIT_FAIL_MESSAGE;
            } elseif (str_contains($e->getMessage(), 'not found')) {
                $errors[] = 'Linha não encontrada.';
            } else {
                $errors[] = 'Não foi possível salvar. Tente novamente.';
            }
        }
    }
}

$pageTitle = $isEdit ? 'Editar linha' : 'Nova linha';
$token = csrf_token();
$formAction = $isEdit ? '/admin/linhas/form.php?id=' . $id : '/admin/linhas/form.php';

admin_render_header($pageTitle, 'linhas');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title"><?php echo admin_h($pageTitle); ?></h1>
            <p class="admin-page-lead">
                <?php echo $isEdit
                    ? 'Atualize nome, categoria, canal do YouTube e saudação desta linha.'
                    : 'Cadastre uma linha com nome, categoria e, se quiser, canal e saudação.'; ?>
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

        <div class="admin-field">
            <label class="admin-label" for="categoria">Categoria</label>
            <select class="admin-select" id="categoria" name="categoria" required>
                <option value="">Selecione…</option>
                <?php foreach ($categorias as $categoria): ?>
                    <?php $cid = (string) (int) $categoria['id']; ?>
                    <option value="<?php echo admin_h($cid); ?>"<?php echo $form['categoria'] === $cid ? ' selected' : ''; ?>>
                        <?php echo admin_h((string) $categoria['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="admin-field">
            <label class="admin-label" for="canal_youtube">Canal do YouTube</label>
            <input
                class="admin-input"
                id="canal_youtube"
                name="canal_youtube"
                type="text"
                inputmode="url"
                maxlength="255"
                placeholder="https://…"
                value="<?php echo admin_h((string) $form['canal_youtube']); ?>"
            >
            <p class="admin-hint">Opcional.</p>
        </div>

        <div class="admin-field">
            <label class="admin-label" for="saudacao">Saudação</label>
            <input
                class="admin-input"
                id="saudacao"
                name="saudacao"
                type="text"
                maxlength="100"
                value="<?php echo admin_h((string) $form['saudacao']); ?>"
            >
            <p class="admin-hint">Opcional. Cumprimento ritual da linha.</p>
        </div>

        <div class="admin-form__actions">
            <button class="admin-btn" type="submit"><?php echo $isEdit ? 'Salvar' : 'Criar linha'; ?></button>
            <a class="admin-btn admin-btn--ghost" href="/admin/linhas/">Cancelar</a>
        </div>
    </form>
<?php
admin_render_footer();
