<?php
$db= mysqli_connect(getenv("CONN_URI"), getenv("ICNT_MYSQL_USER"), getenv("ICNT_MYSQL_PASSWORD"), getenv("ICNT_MYSQL_DATABASE"));
mysqli_set_charset($db,"utf8");

$orixas = mysqli_query($db, "select linha from linha where categoria like 'orixa' order by linha asc;");
$guia = mysqli_query($db, "select linha from linha where categoria like 'guia' order by linha asc;");
$outros = mysqli_query($db, "select linha from linha where categoria like 'outros' order by linha asc;");

if(isset($_GET['buscar'])){
	$buscar = $_GET['buscar'];
	$pontos = mysqli_query($db, "SELECT * FROM pontos where linha = '$buscar' order by ritmo asc");
if(isset($_GET['show'])){
	$busca = $_GET['show'];
}else{
	$busca = $buscar;
};} else{
	$busca = "";
};

?>
<!DOCTYPE html>
<html>
<head>
	<title>Pontos de umbanda | Raízes de Aruanda</title>
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
	<link rel="stylesheet" type="text/css" href="assets/css/dev.css">
	<link rel="stylesheet" type="text/css" href="assets/css/print.css" media="print">
	<style type="text/css">
	<?php if(isset($_GET['buscar'])){
		echo	"
		#apresentacao{
		display: none;
	}
		#pontos{
	display: block;
}";} else {
	echo "
		#apresentacao{
	display: block;
}
		#pontos{
display: none;
}";
}

?>
</style>
</head>
<body>
	<div id="conteudo">
		<div id="header">
			<div id="head"><img src="assets/logo.png">
				<span>Instituto Cultural Nação Tambor</span>
			</div>
		</div>
		<aside>
			<nav>
				<ul>
					<li id="orixa_title">
						Orixás
					</li>
					<li id="orixa_lista">
						<ul>
							<?php while ($row = mysqli_fetch_array($orixas)) { ?>
							<a href="index.php?buscar=<?php echo $row['linha']; ?>"><li><?php echo $row['linha']; ?></li></a>
						<?php } ?>
						</ul>
					</li>
					<li id="linha_title">
						Linhas
					</li>
					<li id="linha_lista">
						<ul>
								<?php while ($row = mysqli_fetch_array($guia)) { ?>
							<a href="index.php?buscar=<?php echo $row['linha']; ?>"><li><?php echo $row['linha']; ?></li></a>
					<?php } ?>

						</ul>
					</li>
					<li id="linha_title">
						Outros
					</li>
					<li id="linha_lista">
						<ul>
								<?php while ($row = mysqli_fetch_array($outros)) { ?>
							<a href="index.php?buscar=<?php echo $row['linha']; ?>"><li><?php echo $row['linha']; ?></li></a>
					<?php } ?>

						</ul>
					</li>
				</ul>
			</nav>
		</aside>
		<div id="apresentacao">
			<h1>Apresentação</h1>
			<p>
				Pontos de Umbanda cantados pelo ogã e babalaorixá Ricardo Barba, professor do Instituto Cultural Nação Tambor e presidente da Curimba Nação Tambor.
			</p>
		</div>
		<div id="busca">
			<h1><?php echo $busca; ?></h1>
			<div id="pontos">
				<?php $i=1; while ($row = mysqli_fetch_array($pontos)) { ?>
					<div id="ponto">
						<h4><span><?php echo $i;?></span>| <?php echo $row['ritmo'];?></h4>
						<pre>
<?php echo $row['ponto'];?>
						</pre>
						<?php if (preg_match("/.mp3/", $row['audio_link']) || preg_match("/.mp4/", $row['audio_link']) || preg_match("/.m4a/", $row['audio_link']) || preg_match("/.ogg/", $row['audio_link']) || preg_match("/.wma/", $row['audio_link'])){
							echo '
								<audio controls>
									<source src="pontos/'.$row['audio_link'].'" type="audio/mp3">
								</audio>
							';} ?>
							<hr>
						</div>
					<?php $i++; } ?>

				</div>
			</div>
		</div>

	</div>
</body>
</html>
