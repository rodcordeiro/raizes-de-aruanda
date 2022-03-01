<?php
date_default_timezone_set('America/Sao_Paulo');
$db= mysqli_connect(getenv("CONN_URI"), getenv("ICNT_MYSQL_USER"), getenv("ICNT_MYSQL_PASSWORD"), getenv("ICNT_MYSQL_DATABASE"));
mysqli_set_charset($db,"utf8");
$orixas = mysqli_query($db, "select linha from icnt_linha where categoria like '1' order by linha asc;");
$guia = mysqli_query($db, "select linha from icnt_linha where categoria like '2' order by linha asc;");
$outros = mysqli_query($db, "select linha from icnt_linha where categoria like '3' order by linha asc;");
//Variáveis
if (isset($_POST['Salvar'])) {
$linha = mysqli_real_escape_string($db,$_POST['linha']);
$tipo = mysqli_real_escape_string($db, $_POST['tipo']);
$ritmo = mysqli_real_escape_string($db, $_POST['ritmo']);
$ponto = mysqli_real_escape_string($db, $_POST['ponto']);

$extensao= strtolower(substr($_FILES['audio']['name'], -4));
$newname = md5(time()).$extensao;
// $uploaddir = '/storage/ssd5/570/8872570/public_html/pontos/';
$uploaddir = '../pontos/';
$uploadfile = $uploaddir . $newname;
move_uploaded_file($_FILES['audio']['tmp_name'], $uploadfile);
if ($_FILES['audio'] != ""){
    $audio = $newname;
    $title = "Ponto de $linha - ".$_FILES['audio']['name'];
} else {
    $audio = "null";
    $title = "null";
};
mysqli_query($db, "INSERT INTO icnt_pontos (ritmo, ponto, linha, tipo, audio_link, title) VALUES ('$ritmo', '$ponto', '$linha', '$tipo', '$audio', '$title')");
header('location:form.php');
}

if (isset($_FILES['new_audio'])) {
	$extensao= strtolower(substr($_FILES['new_audio']['name'], -4));
	$newname = md5(time()).$extensao;
	$uploaddir = '../pontos/';
	$uploadfile = $uploaddir . $newname;
	move_uploaded_file($_FILES['audio']['tmp_name'], $uploadfile);
	$id = $_GET['id'];
	mysqli_query($db, "UPDATE icnt_pontos SET audio_link = '$newname' WHERE id = $id");
	header('location:form.php');
}
?>
<!DOCTYPE html>
<html>
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
