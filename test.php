<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&family=Roboto+Mono:wght@300;400;700&family=Roboto+Slab:wght@100;400;700&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <link rel="stylesheet" type="text/css" href="./assets/dev-css/main.css">
    <link rel="stylesheet" type="text/css" href="./assets/dev-css/mobile.css">
    <link rel="stylesheet" type="text/css" href="./assets/dev-css/print.css" media="print">

    <?php
    include_once './components/Navbar.php';
    include_once './components/Ponto.php';
    include_once './db/db.class.php';
    include_once './controllers/linhas.controller.php';
    include_once './controllers/pontos.controller.php';
    $db = new DBClass();
    $connection = $db->getConnection();
    $Linhas = new Linhas($connection);
    $Pontos = new Pontos($connection);
    $categorias = $Linhas->getCategories();

    ?>
    <style type="text/css">
        <?php if (isset($_GET['search'])) {
            echo "
            #content .presentation{
                display: none;
            }
            #content.pontos{
                display: block;
            }";
        } else {
            echo "
            #content .presentation{
                display: flex;
            }
            #content.pontos{
                display: none;
            }";
        }

        ?>
    </style>
</head>

<body>
    <div id="container">
        <div class="mobile-menu" onClick="handleMobileMenu()">
            <i data-feather="menu"></i>
        </div>
        <div id="mobileHeader">
            <nav>
                <img src="HTTPS://rodcordeiro.github.io/shares/favicons/favicon-raizes/ms-icon-310x310.png" alt="Logotipo Raizes de Aruanda" class="logo">
                <ul>
                    <?php
                    foreach ($categorias as $categoria) {
                    ?>
                        <li class="category" onClick="toggleVisibility('<?php echo $categoria; ?>')">
                            <p><?php echo $categoria; ?></p>
                            <i data-feather="chevron-down" class='<?php echo $categoria; ?>-icon-closed'></i>
                            <i data-feather="chevron-right" class='<?php echo $categoria; ?>-icon hidden'></i>
                        </li>
                        <div class="<?php echo $categoria; ?>">
                            <?php $linhas = $Linhas->filterByCategory($categoria);
                            // print_r($linhas);
                            NavBar($linhas); ?></div>
                        <!-- NavBar([["name" => "Logun edé", "url" => "logunede"]]); ?></div> -->

                    <?php
                    }
                    ?>
                </ul>
            </nav>
            <div class="footer">
                <p>Desenvolvido com &lt;3 por <a href='https://rodcordeiro.com.br' target="_blank">RodCordeiro</a> </p>
            </div>
        </div>
        <aside>
            <nav>
                <img src="HTTPS://rodcordeiro.github.io/shares/favicons/favicon-raizes/ms-icon-310x310.png" alt="Logotipo Raizes de Aruanda" class="logo">
                <ul>
                    <?php
                    foreach ($categorias as $categoria) {
                    ?>
                        <li class="category" onClick="toggleVisibility('<?php echo $categoria; ?>')" onselect="toggleVisibility('<?php echo $categoria; ?>')">
                            <p><?php echo $categoria; ?></p>
                            <i data-feather="chevron-down" class='<?php echo $categoria; ?>-icon-closed'></i>
                            <i data-feather="chevron-right" class='<?php echo $categoria; ?>-icon hidden'></i>
                        </li>
                        <div class="<?php echo $categoria; ?>">
                            <?php $linhas = $Linhas->filterByCategory($categoria);
                            // print_r($linhas);
                            NavBar($linhas); ?></div>
                        <!-- NavBar([["name" => "Logun edé", "url" => "logunede"]]); ?></div> -->

                    <?php
                    }
                    ?>
                </ul>
            </nav>
            <div class="footer">
                <p>Desenvolvido com &lt;3 por <a href='https://rodcordeiro.com.br' target="_blank">RodCordeiro</a> </p>
            </div>
        </aside>
        <section id="content">
            <section class="presentation">
                <h1>Aqui você encontrará os pontos cantados pela curimba
                    do nosso terreiro.</h1>
            </section>
            <section class="pontos">
                <?php
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $pontos = $Pontos->filter($search);
                    $index = 1;
                }
                ?>
                <h1><?php $linha = $Linhas->getById($_GET['search']);
                    echo $linha['linha'] ?></h1>

                <?php
                foreach ($pontos as $ponto) {
                    Ponto($index, $ponto);
                    $index++;
                }
                ?>
            </section>

        </section>
    </div>
    <script>
        function toggleVisibility(target) {
            const container = document.querySelector(`.${target}`)
            const closed_icon = document.querySelector(`.${target}-icon-closed`)
            const open_icon = document.querySelector(`.${target}-icon`)
            container.classList.toggle('hidden')
            closed_icon.classList.toggle('hidden')
            open_icon.classList.toggle('hidden')
        }
    </script>
    <script>
        feather.replace()
    </script>
</body>

</html>