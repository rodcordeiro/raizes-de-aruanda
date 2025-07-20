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

        $pontos = [];
        if (isset($_GET['buscar'])) {
            $buscar = $_GET['buscar'];
            $pontos = $Pontos->filter($buscar);
            $busca = $_GET['show'] ?? $buscar;
        } else {
            $busca = "";
        }
    ?>

    <style type="text/css">
        <?php if (isset($_GET['buscar'])): ?>
            #apresentacao {
                display: none;
            }
            #conteudo article {
                display: block;
            }
        <?php else: ?>
            #apresentacao {
                display: block;
            }
            #conteudo article {
                display: none;
            }
        <?php endif; ?>
    </style>

    <script src="https://unpkg.com/feather-icons"></script>
    <script src="./assets/js/main.js"></script>
    <title>Pontos de Umbanda</title>
</head>
<body>
    <div id="conteudo">
        <header id="header">
            <img src="https://rodcordeiro.github.io/shares/favicons/favicon-raizes/android-icon-192x192.png" alt="Logo" width="48" height="48">
            <span>Pontos de Umbanda</span>
            <div class="mobile-menu" onclick="handleMobileMenu()">
                <i data-feather="menu"></i>
            </div>
        </header>

        <aside class='hide'>
            <nav>
                <ul>
                    <?php foreach($categorias as $categoria): ?>
                        <li id="linha_title"><?php echo htmlspecialchars($categoria); ?></li>
                        <li id="linha_lista">
                            <ul>
                                <?php
                                    $linhas = $Linhas->filterByCategory($categoria);
                                    foreach($linhas as $linha):
                                ?>
                                    <li><a href="index.php?buscar=<?php echo urlencode($linha['linha']); ?>"><?php echo htmlspecialchars($linha['linha']); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </aside>

        <div id="apresentacao">
            <h1>Apresentação</h1>
            <p>
                Pontos de Umbanda utilizados durante as giras pela curimba do terreiro Raízes de Aruanda, bem como para o compartilhamento de conhecimentos.
            </p>
        </div>

        <article>
            <h1><?php echo htmlspecialchars($busca); ?></h1>

            <?php
                $i = 1;
                foreach ($pontos as $ponto):
            ?>
                <section id="ponto-<?php echo $ponto['id']; ?>">
                    <h2>
                        <?php echo htmlspecialchars($ponto['ritmo']); ?>
                        <?php if (strcasecmp($ponto['tipo'], 'subida') === 0): ?>
                            <span> (Subida)</span>
                        <?php endif; ?>
                    </h2>

                    <p><strong>Ponto nº <?php echo $i; ?></strong></p>

                    <?php
                        $linhas = explode("\n", trim($ponto['ponto']));
                        foreach ($linhas as $linha) {
                            if (trim($linha) !== '') {
                                echo '<p>' . htmlspecialchars($linha) . '</p>';
                            }
                        }
                    ?>

                    <?php if (preg_match("/\.(mp3|mp4|m4a|ogg|wma)$/", $ponto['audio_link'])): ?>
                        <audio controls>
                            <source src="pontos/<?php echo htmlspecialchars($ponto['audio_link']); ?>" type="audio/mp3">
                        </audio>
                    <?php endif; ?>

                    <hr>
                </section>
            <?php
                $i++;
                endforeach;
            ?>
        </article>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>