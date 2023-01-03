<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="./assets/dev-css/mobile.css">
    <link rel="stylesheet" type="text/css" href="./assets/dev-css/main.css">
    <link rel="stylesheet" type="text/css" href="./assets/dev-css/print.css" media="print">
    <?php
    include_once './components/Navbar.php'
    ?>
</head>

<body>
    <div id="content">
        <aside>
            <nav>
                <?php NavBar([["name" => "oi", "url" => "#"]]); ?>
            </nav>
            <p>Desenvolvido com &lt;3 por <a href='https://rodcordeiro.com.br'>RodCordeiro</a> </p>

        </aside>
    </div>
</body>

</html>