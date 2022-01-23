<?php
include_once './db/db.class.php';
include_once './controllers/linhas.controller.php';
$db = new DBClass();
$connection = $db->getConnection();
$linhas = new Linhas($connection);
$teste = $linhas->getCategories();
print_r($teste);


?>