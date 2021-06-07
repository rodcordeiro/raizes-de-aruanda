<?php
date_default_timezone_set('America/Sao_Paulo');
$db= mysqli_connect('localhost', 'id8872570_cordeiro', '@C0rdeiro', 'id8872570_icnt');
mysqli_set_charset($db,"utf8");
$orixas = mysqli_query($db, "select linha from linha where categoria like 'orixa' order by linha asc;");
$guia = mysqli_query($db, "select linha from linha where categoria like 'guia' order by linha asc;");
$outros = mysqli_query($db, "select linha from linha where categoria like 'outros' order by linha asc;");
//Variáveis
if (isset($_POST['Salvar'])) {
$linha = mysqli_real_escape_string($db,$_POST['linha']);
$tipo = mysqli_real_escape_string($db, $_POST['tipo']);
$ritmo = mysqli_real_escape_string($db, $_POST['ritmo']);
$ponto = mysqli_real_escape_string($db, $_POST['ponto']);

$extensao= strtolower(substr($_FILES['audio']['name'], -4));
$newname = md5(time()).$extensao;
// $uploaddir = '/storage/ssd5/570/8872570/public_html/pontos/';
$uploaddir = './pontos/';
$uploadfile = $uploaddir . $newname;
move_uploaded_file($_FILES['audio']['tmp_name'], $uploadfile);
if ($_FILES['audio'] != ""){
    $audio = $newname;
    $title = "Ponto de $linha - ".$_FILES['audio']['name'];
} else {
    $audio = "null";
    $title = "null";
};
mysqli_query($db, "INSERT INTO pontos (ritmo, ponto, linha, tipo, audio_link, title) VALUES ('$ritmo', '$ponto', '$linha', '$tipo', '$audio', '$title')");
header('location:form.php');
}

if (isset($_FILES['new_audio'])) {
	$extensao= strtolower(substr($_FILES['new_audio']['name'], -4));
	$newname = md5(time()).$extensao;
	$uploaddir = '/storage/ssd5/570/8872570/public_html/pontos/';
	$uploadfile = $uploaddir . $newname;
	move_uploaded_file($_FILES['audio']['tmp_name'], $uploadfile);
	$id = $_GET['id'];
	mysqli_query($db, "UPDATE pontos SET audio_link = '$newname' WHERE id = $id");
	header('location:form.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pontos de umbanda | ICNT</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!-- assets/favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="assets/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/assets/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/assets/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/assets/favicon-16x16.png">
	<link rel="manifest" href="assets/favicon/manifest.json">
	<meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">

	<!-- LINKS -->
	<link rel="stylesheet" type="text/css" href="assets/css/form.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dev.css">
</head>
<body>
	<div id="conteudo">
		<div id="header">
			<div id="head"><a href="https://icnt.000webhostapp.com"><img src="assets/logo.png"></a>
				<span>Instituto Cultural Nação Tambor</span>
			</div>
		</div>
		<div id="form">
			<form action="form.php" method="post" enctype="multipart/form-data">
				<select name="linha" id="linha">
					<option>linha</option>
					<?php while ($row = mysqli_fetch_array($orixas)) { ?>
						<option><?php echo $row['linha']; ?></option>
					<?php } ?>
					<?php while ($row = mysqli_fetch_array($guia)) { ?>
						<option><?php echo $row['linha']; ?></option>
					<?php } ?>
					<?php while ($row = mysqli_fetch_array($outros)) { ?>
						<option><?php echo $row['linha']; ?></option>
					<?php } ?>
				</select>
				<select name="tipo" id="tipo">
					<option>Tipo</option>
					<option>Chamada</option>
					<option>Sustentação</option>
					<option>Subida</option>
				</select>
				<input type="text" name="ritmo" id="ritmo" placeholder="Ritmo do ponto"><br>
				<fieldset>
					<legend>Ponto:</legend>
					<textarea name="ponto" id="ponto"></textarea>
				</fieldset><br>
				<input type="file" name="audio"><br>
				<input type="submit" name="Salvar">
			</form>
		</div>

		</div>
	</body>
	</html>
