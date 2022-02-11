<?php

date_default_timezone_set('America/Sao_Paulo');

$db= mysqli_connect('localhost', 'id8872570_cordeiro', '@C0rdeiro', 'id8872570_icnt');



//Variáveis

if (isset($_POST['Salvar'])) {

$linha = mysqli_real_escape_string($db,$_POST['linha']);

$tipo = mysqli_real_escape_string($db, $_POST['tipo']);

$ritmo = mysqli_real_escape_string($db, $_POST['ritmo']);

$ponto = mysqli_real_escape_string($db, $_POST['ponto']);



$extensao= strtolower(substr($_FILES['audio']['name'], -4));

$newname = md5(time()).$extensao;

$uploaddir = '../pontos/';

$uploadfile = $uploaddir . $newname;

move_uploaded_file($_FILES['audio']['tmp_name'], $uploadfile);

if ($_FILES['audio'] != ""){

    $audio = $newname;

} else {

    $audio = "null";

};

mysqli_query($db, "INSERT INTO pontos (ritmo, ponto, linha, tipo, audio_link, title) VALUES ('$ritmo', '$ponto', '$linha', '$tipo', '$audio', 'Ponto de ".$linha." - ".$_FILES['audio']['name']."')");

header('location:form.php');

}



if (isset($_FILES['new_audio'])) {

	$extensao= strtolower(substr($_FILES['new_audio']['name'], -4));

	$newname = md5(time()).$extensao;

	$uploaddir = '../pontos/';

	$uploadfile = $uploaddir . $newname;

	move_uploaded_file($_FILES['audio']['tmp_name'], $uploadfile);

	$id = $_GET['id'];

	mysqli_query($db, "UPDATE pontos SET audio_link = '$newname' WHERE id = $id");

	header('location:form.php');

}

?>