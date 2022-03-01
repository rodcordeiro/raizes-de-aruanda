<?php
include_once '../../controllers/session.controller.php';
include_once '../../db/db.class.php';

$conn = new DBClass();
$conn = $conn->getConnection();
$session = new User($conn);

$session->isAuthenticated();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Pontos</title>
</head>
<body>
    <div class="container">
        <form action="index.php" method="post">
            <input type="text" name="user" placeholder="Insira seu usuário"/>
            <input type="password" name="password" placeholder="Insira sua senha"/>
            <button type="submit" name="login">Acessar</button>

        </form>
    </div>
</body>
</html>