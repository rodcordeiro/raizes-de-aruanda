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

        $canalYoutube = '';
        $busca = '';
        $pontos = [];
        $hasLinha = isset($_GET['buscar']) && $_GET['buscar'] !== '';

        if ($hasLinha) {
            $buscar = $_GET['buscar'];
            $pontos = $Pontos->filter($buscar) ?: [];
            $linhaData = $Linhas->findByName($buscar);

            if ($linhaData && !empty($linhaData['canal_youtube'])) {
                $canalYoutube = $linhaData['canal_youtube'];
            }

            $busca = isset($_GET['show']) ? $_GET['show'] : $buscar;
        }

        $linhaAtual = htmlspecialchars($busca, ENT_QUOTES, 'UTF-8');
    ?>
    <script src="https://unpkg.com/feather-icons" defer></script>
    <script src="./assets/js/main.js" defer></script>
</head>
<body class="<?php echo $hasLinha ? 'page-linha' : 'page-home'; ?>">
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
            <section id="apresentacao" <?php echo $hasLinha ? 'hidden' : ''; ?>>
                <h1>Apresentação</h1>
                <p>
                    Pontos de Umbanda utilizados durante as giras pela curimba do terreiro Raízes de Aruanda, bem como para o compartilhamento de conhecimentos.
                </p>
                <br/>
                <hr/>
                <p>
                    Regência de 2026: <a href="index.php?buscar=Omulu" class="brand">Omulu</a> e <a href="index.php?buscar=Oxum" class="brand">Oxum</a>.
                </p>
                <br/>
                <hr/>
                <p>
                    <a href="./ordem-ritualistica.php" class="brand">Ordem ritualística de abertura dacasa.</a>
                </p>
                <p>
                    Neste link você encontrará o passo a passo, o procedimento ritualístico, executado para a abertura de cada gira. 
                </p>
            </section>

            <section id="busca" <?php echo $hasLinha ? '' : 'hidden'; ?>>
                <?php if ($hasLinha) { ?>
                <?php /* Nome da linha (hero no mobile) + chips sticky — separados para o sticky não limitar ao bloco curto */ ?>
                <div class="linha-nome" id="linha-nome">
                    <?php if (!empty($canalYoutube)) { ?>
                        <a href="<?php echo htmlspecialchars($canalYoutube, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo $linhaAtual; ?>
                        </a>
                    <?php } else { ?>
                        <?php echo $linhaAtual; ?>
                    <?php } ?>
                </div>
                <nav class="ritmo-chips" id="ritmo-chips" aria-label="Índice de ritmos">
                    <?php
                    $ritmoChips = [];
                    foreach ($pontos as $ponto) {
                        $ritmoNome = (string) ($ponto['ritmo'] ?? '');
                        $ritmoKey = function_exists('mb_strtolower')
                            ? mb_strtolower($ritmoNome, 'UTF-8')
                            : strtolower($ritmoNome);
                        if (!isset($ritmoChips[$ritmoKey])) {
                            $ritmoChips[$ritmoKey] = [
                                'nome' => $ritmoNome,
                                'count' => 0,
                                'firstId' => 'ponto-' . (int) $ponto['id'],
                            ];
                        }
                        $ritmoChips[$ritmoKey]['count']++;
                    }
                    $chipIndex = 0;
                    foreach ($ritmoChips as $ritmoKey => $chip) {
                        $chipLabel = $chip['count'] . ' ' . $chip['nome'];
                        $chipIndex++;
                    ?>
                    <a
                        class="ritmo-chip<?php echo $chipIndex === 1 ? ' is-active' : ''; ?>"
                        href="#<?php echo htmlspecialchars($chip['firstId'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-ponto-id="<?php echo htmlspecialchars($chip['firstId'], ENT_QUOTES, 'UTF-8'); ?>"
                        data-ritmo="<?php echo htmlspecialchars($ritmoKey, ENT_QUOTES, 'UTF-8'); ?>"
                    >
                        <?php echo htmlspecialchars($chipLabel, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                    <?php } ?>
                </nav>

                <h1 class="linha-title visually-hidden"><?php echo $linhaAtual; ?></h1>

                <div id="pontos">
                    <?php if (count($pontos) === 0) { ?>
                        <p class="empty-state">Nenhum ponto encontrado para esta linha.</p>
                    <?php } else {
                        $i = 1;
                        foreach ($pontos as $ponto) {
                            $pontoId = 'ponto-' . (int) $ponto['id'];
                            $ritmoNome = (string) ($ponto['ritmo'] ?? '');
                            $ritmoKey = function_exists('mb_strtolower')
                                ? mb_strtolower($ritmoNome, 'UTF-8')
                                : strtolower($ritmoNome);
                            $videoId = null;
                            if (!empty($ponto['audio_link']) && preg_match('#youtu\.be/([a-zA-Z0-9_-]+)#i', $ponto['audio_link'], $matches)) {
                                $videoId = $matches[1];
                            }
                    ?>
                    <article class="ponto" id="<?php echo $pontoId; ?>" data-ritmo="<?php echo htmlspecialchars($ritmoKey, ENT_QUOTES, 'UTF-8'); ?>">
                        <h2 class="ponto-ritmo">
                            <span><?php echo $i; ?></span>| <?php echo htmlspecialchars($ritmoNome, ENT_QUOTES, 'UTF-8'); ?>
                            <?php if (strcasecmp((string) ($ponto['tipo'] ?? ''), 'subida') === 0): ?>
                                <span> (Subida)</span>
                            <?php endif; ?>
                        </h2>
                        <div class="ponto-letra"><?php echo htmlspecialchars($ponto['ponto'], ENT_QUOTES, 'UTF-8'); ?></div>
                        <?php if ($videoId): ?>
                        <iframe
                            class="yt-embed"
                            src="https://www.youtube.com/embed/<?php echo htmlspecialchars($videoId, ENT_QUOTES, 'UTF-8'); ?>"
                            title="YouTube video player"
                            allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                        ></iframe>
                        <?php endif; ?>
                        <?php
                        if (!empty($ponto['audio_link']) && preg_match('/\.(mp3|mp4|m4a|ogg|wma)$/i', $ponto['audio_link'])) {
                            echo '<audio controls preload="none"><source src="pontos/' . htmlspecialchars($ponto['audio_link'], ENT_QUOTES, 'UTF-8') . '" type="audio/mpeg"></audio>';
                        }
                        ?>
                    </article>
                    <?php
                            $i++;
                        }
                    } ?>
                </div>
                <?php } ?>
            </section>
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
                        $isActive = $hasLinha && strcasecmp($busca, $nomeLinha) === 0;
                        $href = 'index.php?buscar=' . rawurlencode($nomeLinha);
                    ?>
                      <li>
                        <a
                            class="nav-line<?php echo $isActive ? ' is-active' : ''; ?>"
                            href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>"
                            data-linha="<?php echo htmlspecialchars(function_exists('mb_strtolower') ? mb_strtolower($nomeLinha, 'UTF-8') : strtolower($nomeLinha), ENT_QUOTES, 'UTF-8'); ?>"
                            <?php echo $isActive ? 'aria-current="page"' : ''; ?>
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
