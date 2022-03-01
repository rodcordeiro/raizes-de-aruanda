<?php
include_once '../../controllers/session.controller.php';
include_once '../../controllers/linhas.controller.php';
include_once '../../controllers/pontos.controller.php';
include_once '../../db/db.class.php';

$conn = new DBClass();
$conn = $conn->getConnection();
$session = new User($conn);
$session->isAuthenticated();

$Pontos = new Pontos($conn);
$Linhas = new Linhas($conn);
$linhas = $Linhas->list();

if(isset($_GET['filter'])){
    $pontos = $Pontos->filter($_GET['filter']);
    if(!$pontos){
        echo "alert('Falha ao buscar dados, favor tentar novamente.')";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Pontos</title>
</head>
<body>
    <div class="container">
    <form action="./index.php" method="post" id="selectLine">
        <select name="filter" id="filter" onChange="submitForm()">
            <?php foreach($linhas as $linha){?>
                <option <?php if(isset($_GET['filter']) && $_GET['filter'] == $linha['linha']){ echo "selected";}?> value="<?php echo $linha['linha']; ?>"><?php echo $linha['linha']; ?></option>
            <?php }?>

        </select>
    </form>
    <div class="data"><?php
    if(isset($_GET['filter'])){
    ?>
    <table>
            <theader>
                <tr>
                    <th>ID</th>
                    <th>Ponto</th>
                </tr>
            </theader>
            <tbody>
            <?php 
                    if($pontos){
                        foreach($pontos as $ponto){
                            ?>
                            <tr onClick="selectForChange(<?php echo $ponto['id']; ?>,'<?php echo $ponto['ponto']; ?>')">
                                <td><?php echo $ponto['id']; ?></td>
                                <td><pre><?php echo $ponto['ponto']; ?></pre></td>
                            </tr>
                            <?php
                        }
                    }             
                ?>
            </tbody>
        </table>
        <form method="post" action="./index.php">
            <input type="hidden" name="id" id="id">
            <input type="text" name="ritmo" id="ritmo" placeholder="Nome do ritmo">
            <input type="submit" name="Salvar">
            <button name="Deletar" onClick="callAlert()" class="delete-button">Deletar</button>
        </form>
    <?php } ?>
    </div>
    </div>
    <script>
        function submitForm(){
            const form = document.querySelector('#selectLine');
            const filterInput = document.querySelector('#filter');
            form.method="get"
            form.action="./index.php?filter=" + filterInput.value
            form.submit()
            
        }
        
    </script>
</body>
</html>