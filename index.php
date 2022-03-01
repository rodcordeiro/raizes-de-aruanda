<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php
        date_default_timezone_set('America/Sao_Paulo');
        include_once './components/metadata/header.php';
        include_once './db/db.class.php';
        include_once './controllers/linhas.controller.php';
        include_once './controllers/pontos.controller.php';
        $db = new DBClass();
        $connection = $db->getConnection();
        $Linhas = new Linhas($connection);
        $Pontos = new Pontos($connection);
        $categorias = $Linhas->getCategories();
        if(isset($_GET['buscar'])){
            $buscar = $_GET['buscar'];
            $pontos = $Pontos->filter($buscar);
        if(isset($_GET['show'])){
            $busca = $_GET['show'];
        }else{
            $busca = $buscar;
        };} else{
            $busca = "";
        };
        
    ?>
    <style type="text/css">
	<?php if(isset($_GET['buscar'])){
        echo "
            #apresentacao{
                display: none;
            }
            #pontos{
                display: block;
            }";
        } else {
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
<script src="https://unpkg.com/feather-icons"></script>
<script src="./assets/js/main.js"></script>
</head>
<body>
	<div id="conteudo">
		<header id="header">
            <!-- <img src="assets/logo.png"> -->
            <span>Pontos de Umbanda</span>
            <div class="mobile-menu" onClick="handleMobileMenu()">
                <i data-feather="menu"></i>
            </div>
		</header>
		<aside class='hide'>
			<nav>
				<ul>
                    <?php
                    foreach($categorias as $categoria){
                    ?>
                    <li id="linha_title">
					<?php echo $categoria; ?>
					</li>
					<li id="linha_lista">
						<ul>
						<?php
                         $linhas = $Linhas->filterByCategory($categoria);
                         foreach($linhas as $linha){
                        ?>

                          <a href="index.php?buscar=<?php echo $linha['linha']; ?>"><li><?php echo $linha['linha']; ?></li></a>
                          <?php
                         }
                        ?>
						</ul>
					</li>
                    <?php
                         }
                        ?>
				</ul>
			</nav>
		</aside>
		<div id="apresentacao">
			<h1>Apresentação</h1>
			<p>
				Pontos de Umbanda utilizados durante as giras pela curimba do terreiro Raízes de Aruanda, bem como para o compartilhamento de conhecimentos.
			</p>
		</div>
		<div id="busca">
			<h1><?php echo $busca; ?></h1>
			<div id="pontos">
				<?php 
                    $i=1; 
                    foreach($pontos as $ponto) { ?>
                    <div id="ponto">
						<h4><span><?php echo $i;?></span>| <?php echo $ponto['ritmo'];?></h4>
						<pre>
<?php echo $ponto['ponto'];?>
						</pre>
						<?php if (preg_match("/.mp3/", $ponto['audio_link']) || preg_match("/.mp4/", $ponto['audio_link']) || preg_match("/.m4a/", $ponto['audio_link']) || preg_match("/.ogg/", $ponto['audio_link']) || preg_match("/.wma/", $ponto['audio_link'])){
							echo '
								<audio controls>
									<source src="pontos/'.$ponto['audio_link'].'" type="audio/mp3">
								</audio>
							';} ?>
							<hr>
						</div>
					
					<?php $i++; } ?>

				</div>
			</div>
		</div>

	</div>

    <script>
      feather.replace()
    </script>
</body>
</html>
