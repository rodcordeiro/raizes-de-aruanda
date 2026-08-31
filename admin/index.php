<?php

require_once __DIR__ . '/_bootstrap.php';

requireAuth();

$username = htmlspecialchars((string) ($_SESSION['username'] ?? ''), ENT_QUOTES, 'UTF-8');
$roles = isset($_SESSION['roles']) && is_array($_SESSION['roles'])
    ? array_map(static fn($r) => htmlspecialchars((string) $r, ENT_QUOTES, 'UTF-8'), $_SESSION['roles'])
    : [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Raízes de Aruanda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/mobile.css">
</head>
<body>
    <main class="doc-page">
        <h1>Admin</h1>
        <p>Olá, <?php echo $username !== '' ? $username : 'usuário'; ?>. Sessão autenticada.</p>
        <?php if ($roles !== []): ?>
            <p>Papéis: <?php echo implode(', ', $roles); ?></p>
        <?php endif; ?>
        <p>Catálogo (CRUD) ainda não disponível neste lote.</p>
        <p><a href="./logout.php">Sair</a></p>
    </main>
</body>
</html>
