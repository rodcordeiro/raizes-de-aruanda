<?php

require_once __DIR__ . '/_bootstrap.php';
require_once __DIR__ . '/_shell.php';

requireAuth();

if (canReadCatalog()) {
    redirect('/admin/pontos/');
}

if (hasPermission('audit:read')) {
    redirect('/admin/auditoria/');
}

http_response_code(403);
admin_render_header('Acesso negado', '');
?>
    <div class="admin-denied">
        <h1>Acesso negado</h1>
        <p>Você não tem permissão para ler o catálogo. Peça acesso a quem administra o terreiro, ou saia da sessão.</p>
        <p><a class="admin-btn" href="/admin/logout.php">Sair</a></p>
    </div>
<?php
admin_render_footer();
