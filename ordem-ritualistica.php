<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php
        date_default_timezone_set('America/Sao_Paulo');
        include_once './components/metadata/header.php';
        include_once './db/db.class.php';
        include_once './controllers/linhas.controller.php';

        $db = new DBClass();
        $connection = $db->getConnection();
        $Linhas = new Linhas($connection);
        $categorias = $Linhas->getCategories();
        $hasLinha = false;
        $busca = '';
    ?>
    <script src="https://unpkg.com/feather-icons" defer></script>
    <script src="./assets/js/main.js" defer></script>
</head>
<body class="page-home">
	<div id="conteudo">
		<header id="header">
            <a class="brand" href="index.php" aria-label="Raízes de Aruanda — início">
                <img src="./assets/favicon/android-icon-192x192.png" alt="Raízes de Aruanda" width="48" height="48">
            </a>
            <span class="header-title">Pontos de Umbanda</span>
            <button type="button" class="mobile-menu" id="menu-open" aria-label="Abrir menu de linhas" aria-controls="nav-sheet" aria-expanded="false">
                <i data-feather="menu"></i>
            </button>
		</header>

		<main id="main">
            <article id="ordem-ritualistica" class="doc-page">
                <h1>Ordem ritualística de abertura</h1>
                <p>
                    A abertura de cada gira no terreiro Raízes de Aruanda segue uma ordem fixa. Este texto é o canhoto da Curimba e também referência para os filhos da casa: o procedimento ritualístico executado antes do trabalho das linhas.
                </p>
                <ol class="ordem-passos">
                    <li>Saudamos a matriarca — ou, em sua ausência, o patriarca.</li>
                    <li>
                        Cantamos para a defumação e para a entrada dos demais filhos, nesta ordem:
                        <ul>
                            <li>egbomis;</li>
                            <li>yawos;</li>
                            <li>abians.</li>
                        </ul>
                    </li>
                    <li>Cantamos para as yalorixás da casa entrarem.</li>
                    <li>Cantamos para os babalorixás da casa entrarem.</li>
                </ol>
                <p>
                    <strong>5.</strong> Cantamos para o babalorixá patriarca da casa entrar somente se ele ainda não tiver sido o primeiro a entrar — ou seja, quando a abertura não começou pela saudação ao patriarca.
                </p>
                <ol class="ordem-passos" start="6">
                    <li>
                        Saudamos a esquerda: as linhas de Exu, Pomba-gira e Exu-mirim, saudadas no início de cada trabalho, nesta ordem:
                        <ol>
                            <li>
                                <a href="index.php?buscar=Exu#ponto-880" class="brand">Exu Arranca Toco</a> (Pai Edgar) — ponto 880
                            </li>
                            <li>
                                <a href="index.php?buscar=Exu#ponto-707" class="brand">Exu do Lodo</a> (Mãe Leonor e Pai Gilberto) — ponto 707
                            </li>
                            <li>
                                Pombagira Maria Mulambo (Mãe Leonor e Mãe Jaciara) — ponto não registrado
                            </li>
                            <li>
                                <a href="index.php?buscar=Pomba-gira#ponto-887" class="brand">Pombagira Dona Pitombeira</a> (Pai Edgar) — ponto 887
                            </li>
                            <li>
                                <a href="index.php?buscar=Exu-mirim#ponto-718" class="brand">Exu Mirim</a> (Egbomi Anderson) — ponto 718
                            </li>
                        </ol>
                    </li>
                    <li>Cantamos o ponto para retirar as esteiras de bater cabeça.</li>
                    <li>Cantamos para abrir a gira.</li>
                    <li>
                        Saudamos os orixás da casa:
                        <ul>
                            <li>Oxóssi;</li>
                            <li>Xangô;</li>
                            <li>Oyá.</li>
                        </ul>
                    </li>
                    <li>Saudamos o orixá regente do ano em nossa casa.</li>
                    <li>Cantamos para o orixá que será saudado na gira.</li>
                    <li>Cantamos para a linha que será saudada na gira.</li>
                </ol>
                <p>
                    <strong>13.</strong> Se o ano estiver regido por dois orixás — como em 2026, com <a href="index.php?buscar=Omulu" class="brand">Omulu</a> e <a href="index.php?buscar=Oxum" class="brand">Oxum</a> —, cantamos também para o segundo orixá regente da casa.
                </p>
                <ol class="ordem-passos" start="14">
                    <li>Saudamos o fechamento da gira.</li>
                    <li>
                        Saudamos o fechamento do couro: o encerramento espiritual dos trabalhos daquela gira.
                    </li>
                </ol>
            </article>
        </main>
	</div>

    <div class="nav-scrim" id="nav-scrim" hidden></div>
    <aside id="nav-sheet" class="nav-sheet" aria-label="Navegação por linhas">
        <div class="nav-sheet-handle" aria-hidden="true"></div>
        <div class="nav-sheet-header">
            <h2 id="nav-sheet-title">Linhas</h2>
            <button type="button" class="nav-close" id="menu-close" aria-label="Fechar menu">
                <i data-feather="x"></i>
            </button>
        </div>
        <label class="nav-filter-label" for="nav-filter">Buscar linha</label>
        <input type="search" id="nav-filter" class="nav-filter" placeholder="Buscar linha…" autocomplete="off">
        <nav>
            <ul class="nav-categories">
                <?php foreach ($categorias as $categoria) { ?>
                <li class="nav-category">
                    <span class="nav-category-title"><?php echo htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8'); ?></span>
                    <ul class="nav-lines">
                    <?php
                     $linhas = $Linhas->filterByCategory($categoria);
                     foreach ($linhas as $linha) {
                        $nomeLinha = $linha['linha'];
                        $href = 'index.php?buscar=' . rawurlencode($nomeLinha);
                    ?>
                      <li>
                        <a
                            class="nav-line"
                            href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>"
                            data-linha="<?php echo htmlspecialchars(function_exists('mb_strtolower') ? mb_strtolower($nomeLinha, 'UTF-8') : strtolower($nomeLinha), ENT_QUOTES, 'UTF-8'); ?>"
                        ><?php echo htmlspecialchars($nomeLinha, ENT_QUOTES, 'UTF-8'); ?></a>
                      </li>
                    <?php } ?>
                    </ul>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </aside>
</body>
</html>

<?php
/*
 * Pile (writing-shape) — não editar; fonte da sequência:
 * 1.primeiro, saudasse a matriarca (ou, em sua ausência, o patriarca)
 * 2. Cantamos para a defumação e entrada dos demais filhos. A ordem de entrada dos filhos é:
 * - egbomis;
 * - yawos;
 * - abians;
 * 3. Cantamos para as yalorixás da casa entrarem;
 * 4. Cantamos para os babalorixás da casa entrarem;
 * 5. Cantamos para o babalorixá patriarca da casa entrar, caso não tenha sido o primeiro a entrar;
 * 6. Saudamos a esquerda;
 * 7. Cantamos o ponto para retirar as esteiras de bater cabeça;
 * 8. Cantamos para abrir a gira;
 * 9. Saudamos os orixas da casa;
 * - Oxóssi;
 * - Xangô;
 * - Oyá;
 * 10. Saudamos o orixá regente do ano em nossa casa;
 * 11. Cantamos para o orixá que será saudado na gira;
 * 12. Cantamos para a linha que será saudada na gira;
 * 13. Caso o ano esteja sendo regido por dois orixás, como em 2026 que foi regido por Omulu e Oxum, cantamos para o segundo orixá regente do ano em nossa casa;
 * 14. Saudamos o fechamento da gira;
 * 15. Saudamos o fechamento do couro.
 */
?>
