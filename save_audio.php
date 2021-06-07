<html>
<head>
	<title>Pontos de umbanda | ICNT</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!-- ../assets/favicon -->
	<link rel="apple-touch-icon" sizes="57x57" href="../assets/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="../assets/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../assets/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../assets/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../assets/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="../assets/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../assets/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="../assets/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/../assets/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../assets/favicon/../assets/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/../assets/favicon-16x16.png">
	<link rel="manifest" href="../assets/favicon/manifest.json">
	<meta name="msapplication-TileImage" content="../assets/favicon/ms-icon-144x144.png">

	<!-- LINKS -->
	<link rel="stylesheet" type="text/css" href="assets/css/form.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dev.css">
</head>
<?php
$db= mysqli_connect('localhost', 'id8872570_cordeiro', '@C0rdeiro', 'id8872570_icnt');
if (isset($_FILES['new_audio'])) {
	$ponto = mysqli_real_escape_string($db, $_POST['ponto']);
	$extensao= strtolower(substr($_FILES['new_audio']['name'], -4));
	$newname = md5(time()).$extensao;
	// $uploaddir = '/storage/ssd5/570/8872570/public_html/pontos/';
	$uploaddir = './pontos/';
	$uploadfile = $uploaddir . $newname;
	move_uploaded_file($_FILES['new_audio']['tmp_name'], $uploadfile);

	mysqli_query($db, "update pontos SET audio_link = '$newname' WHERE ponto like '%$ponto%'");
	mysqli_query($db, "update pontos SET audio_link = '".$_FILES['new_audio']['name']."' WHERE ponto like '%$ponto%'");
}?>
<body>
	<div id="conteudo">
		<div id="header">
			<div id="head"><img src="../assets/logo.png">
				<span>Instituto Cultural Nação Tambor</span>
			</div>
		</div>
		<div id="form">
			<form action="save_audio.php" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>Ponto:</legend>
					<textarea name="ponto" id="ponto"></textarea>
				</fieldset><br>
				<input type="file" name="new_audio"><br>
				<input type="submit" name="Salvar">
			</form>
		</div>

		</div>
	</body>
	</html>
