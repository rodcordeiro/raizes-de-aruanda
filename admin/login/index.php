<?php

require_once __DIR__ . '/../_bootstrap.php';

if (isAuthenticated()) {
    redirect(ADMIN_HOME_PATH);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = isset($_POST['csrf_token']) ? (string) $_POST['csrf_token'] : null;
    $username = isset($_POST['username']) ? (string) $_POST['username'] : '';
    $password = isset($_POST['password']) ? (string) $_POST['password'] : '';

    if (!csrf_validate($token)) {
        $error = 'Sessão inválida. Tente novamente.';
    } elseif ($connection === null) {
        $error = 'Serviço indisponível. Tente novamente mais tarde.';
    } elseif (attemptLogin($connection, $username, $password)) {
        redirect(ADMIN_HOME_PATH);
    } else {
        $error = 'Usuário ou senha inválidos.';
    }
}

$token = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
$errorHtml = $error !== '' ? htmlspecialchars($error, ENT_QUOTES, 'UTF-8') : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar no admin — Raízes de Aruanda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/mobile.css">
    <link rel="stylesheet" href="./styles.css">
</head>
<body class="login-page">
    <main>
        <form method="post" action="./" class="login-form" autocomplete="on">
            <p class="login-brand">Raízes de Aruanda</p>
            <h1 class="login-title">Entrar no admin</h1>

            <?php if ($errorHtml !== ''): ?>
                <p class="login-error" role="alert"><?php echo $errorHtml; ?></p>
            <?php endif; ?>

            <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">

            <div class="login-field">
                <label class="login-label" for="username">Usuário</label>
                <input
                    class="login-input"
                    id="username"
                    name="username"
                    type="text"
                    required
                    autofocus
                    autocomplete="username"
                    maxlength="255"
                    placeholder="seu.usuario"
                >
            </div>

            <div class="login-field">
                <label class="login-label" for="password">Senha</label>
                <input
                    class="login-input"
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                >
            </div>

            <button class="login-submit" type="submit">Entrar</button>
        </form>
    </main>
</body>
</html>
