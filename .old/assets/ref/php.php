<?php

	$db= mysqli_connect('localhost', 'id8872570_cordeiro', '@C0rdeiro', 'id8872570_icnt');

if(isset($_GET['buscar'])){
	$buscar = $_GET['buscar'];
	$pontos = mysqli_query($db, "SELECT * FROM pontos where linha = '$buscar'");
};
if(isset($_GET['show'])){
	$busca = $_GET['show'];
}else{
	$busca = $buscar;
};

	mysqli_query($db, "INSERT INTO Tasks (Tasks, Prioridade, Origem) VALUES ('$task', '$lvl', 'Todo-Cordeiro')");
			header('location: index.php');



			if(isset($_POST['register'])){
		$uid = mysqli_real_escape_string($db, $_POST['uid']);
		$nome = mysqli_real_escape_string($db, $_POST['nome']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$passwd_1 = mysqli_real_escape_string($db, $_POST['passwd_1']);
	



?>

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
	
			<?php i=1; while ($row = mysqli_fetch_array($pontos)) { ?>
			<div id="ponto">
					<h4><span><?php echo $row['id'];?></span>| <?php echo $row['ritmo'];?></h4>
					<pre>
<?php echo $row['ponto'];?>
					</pre>
					<audio controls>
						<source src="pontos/<?php echo $row['audio_link']; ?>" type="audio/mp3">
					</audio>
					<hr>
				</div>
		<?php i++; } ?>