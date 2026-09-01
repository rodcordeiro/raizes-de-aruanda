<?php

require_once __DIR__ . '/../_bootstrap.php';
require_once __DIR__ . '/../_shell.php';

requireAuth();

if ($connection === null) {
    http_response_code(503);
    admin_render_header('Pontos');
    echo '<p class="admin-alert admin-alert--error" role="alert">Serviço indisponível. Tente novamente mais tarde.</p>';
    admin_render_footer();
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isEdit = $id > 0;

if ($isEdit) {
    requirePermission('ponto:update');
    $ponto = admin_pontos_find($connection, $id);
    if ($ponto === null) {
        http_response_code(404);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Ponto não encontrado.';
        exit;
    }
} else {
    requirePermission('ponto:create');
    $ponto = null;
}

$linhas = admin_list_linhas_select($connection);
$ritmos = admin_list_ritmos_select($connection);
$tipos = admin_pontos_allowed_tipos();

$errors = [];
$form = [
    'letra' => $ponto['letra'] ?? '',
    'tipo' => $ponto['tipo'] ?? '',
    'linha' => isset($ponto['linha_id']) ? (string) (int) $ponto['linha_id'] : '',
    'ritmo' => isset($ponto['ritmo_id']) ? (string) (int) $ponto['ritmo_id'] : '',
    'audio_url' => $ponto['audio_url'] ?? '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrf = isset($_POST['csrf']) ? (string) $_POST['csrf'] : (isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : null);
    if (!csrf_validate($csrf)) {
        http_response_code(403);
        $errors[] = 'Sessão inválida. Tente novamente.';
    } else {
        $form = [
            'letra' => isset($_POST['letra']) ? (string) $_POST['letra'] : '',
            'tipo' => isset($_POST['tipo']) ? (string) $_POST['tipo'] : '',
            'linha' => isset($_POST['linha']) ? (string) $_POST['linha'] : '',
            'ritmo' => isset($_POST['ritmo']) ? (string) $_POST['ritmo'] : '',
            'audio_url' => isset($_POST['audio_url']) ? (string) $_POST['audio_url'] : '',
        ];

        $data = [
            'letra' => $form['letra'],
            'tipo' => $form['tipo'],
            'linha' => $form['linha'],
            'ritmo' => $form['ritmo'],
            'audio_url' => $form['audio_url'],
        ];

        try {
            if ($isEdit) {
                admin_pontos_update($connection, $id, $data, admin_actor());
                admin_flash_set('ok', 'Ponto atualizado.');
                redirect('/admin/pontos/');
            }

            admin_pontos_create($connection, $data, admin_actor());
            admin_flash_set('ok', 'Ponto criado.');
            redirect('/admin/pontos/');
        } catch (InvalidArgumentException $e) {
            $parts = array_filter(array_map('trim', explode(';', $e->getMessage())));
            $errors = $parts !== [] ? array_values($parts) : [$e->getMessage()];
        } catch (Throwable $e) {
            if (admin_is_audit_failure($e)) {
                $errors[] = ADMIN_AUDIT_FAIL_MESSAGE;
            } elseif (str_contains($e->getMessage(), 'not found')) {
                $errors[] = 'Ponto não encontrado.';
            } else {
                $errors[] = 'Não foi possível salvar. Tente novamente.';
            }
        }
    }
}

$pageTitle = $isEdit ? 'Editar ponto' : 'Novo ponto';
$token = csrf_token();
$formAction = $isEdit ? '/admin/pontos/form.php?id=' . $id : '/admin/pontos/form.php';

admin_render_header($pageTitle, 'pontos');
?>
    <div class="admin-page-head">
        <div>
            <h1 class="admin-page-title"><?php echo admin_h($pageTitle); ?></h1>
            <p class="admin-page-lead">
                <?php echo $isEdit
                    ? 'Atualize letra, função, linha, ritmo e áudio opcional deste ponto.'
                    : 'Cadastre um ponto no catálogo com letra, função, linha e ritmo.'; ?>
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
            <label class="admin-label" for="letra">Letra</label>
            <textarea
                class="admin-textarea"
                id="letra"
                name="letra"
                required
                rows="8"
            ><?php echo admin_h((string) $form['letra']); ?></textarea>
        </div>

        <div class="admin-field">
            <label class="admin-label" for="tipo">Função</label>
            <select class="admin-select" id="tipo" name="tipo" required>
                <option value="">Selecione…</option>
                <?php foreach ($tipos as $tipoOpt): ?>
                    <?php
                    $normalized = admin_pontos_normalize_tipo((string) $form['tipo']);
                    $selected = $normalized === $tipoOpt || (string) $form['tipo'] === $tipoOpt;
                    ?>
                    <option value="<?php echo admin_h($tipoOpt); ?>"<?php echo $selected ? ' selected' : ''; ?>>
                        <?php echo admin_h(ADMIN_PONTOS_TIPO_LABELS[$tipoOpt] ?? $tipoOpt); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="admin-field">
            <label class="admin-label" for="linha">Linha</label>
            <select class="admin-select" id="linha" name="linha" required>
                <option value="">Selecione…</option>
                <?php foreach ($linhas as $linha): ?>
                    <?php $lid = (string) (int) $linha['id']; ?>
                    <option value="<?php echo admin_h($lid); ?>"<?php echo $form['linha'] === $lid ? ' selected' : ''; ?>>
                        <?php echo admin_h((string) $linha['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="admin-field">
            <label class="admin-label" for="ritmo">Ritmo</label>
            <select class="admin-select" id="ritmo" name="ritmo" required>
                <option value="">Selecione…</option>
                <?php foreach ($ritmos as $ritmo): ?>
                    <?php $rid = (string) (int) $ritmo['id']; ?>
                    <option value="<?php echo admin_h($rid); ?>"<?php echo $form['ritmo'] === $rid ? ' selected' : ''; ?>>
                        <?php echo admin_h((string) $ritmo['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="admin-field">
            <label class="admin-label" for="audio_url">Áudio / YouTube URL</label>
            <input
                class="admin-input"
                id="audio_url"
                name="audio_url"
                type="text"
                inputmode="url"
                maxlength="255"
                placeholder="https://youtu.be/…"
                value="<?php echo admin_h((string) $form['audio_url']); ?>"
            >
            <p class="admin-hint">Opcional.</p>
        </div>

        <div class="admin-form__actions">
            <button class="admin-btn" type="submit"><?php echo $isEdit ? 'Salvar' : 'Criar ponto'; ?></button>
            <a class="admin-btn admin-btn--ghost" href="/admin/pontos/">Cancelar</a>
        </div>
    </form>
<?php
admin_render_footer();
