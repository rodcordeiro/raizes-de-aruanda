<?php
include_once '../controllers/session.controller.php';
include_once '../db/db.class.php';

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
    <title>Admin</title>
    <link rel="stylesheet" href="./styles.css">
    <script src="./main.js"></script>
</head>

<body>
    <div class="container">
        <div class="button" onClick="reload('./linhas')">
            Gerenciar Linhas
        </div>
        <div class="button" onClick="reload('./ritmos')">
            Gerenciar Ritmos
        </div>
        <div class="button" onClick="reload('./pontos')">
            Gerenciar Pontos
        </div>
        <div class="button" onClick="reload('./users')">
            Gerenciar Usuários
        </div>
    </div>
</body>

</html>