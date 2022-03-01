<?php
include_once '../../controllers/session.controller.php';
include_once '../../controllers/pontos.controller.php';
include_once '../../db/db.class.php';

$conn = new DBClass();
$conn = $conn->getConnection();
$session = new User($conn);
$session->isAuthenticated();

$pontos = new Pontos($conn);
$ritmos = $pontos->listRythms();

if(isset($_POST['Salvar'])){
    if($_POST['id']){
        print_r("atualizar {$_POST['id']} {$_POST['ritmo']}");
    } else {
        $pontos->ritmo = $_POST['ritmo'];
        $pontos->saveRythm();
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
    <table>
            <theader>
                <tr>
                    <th>ID</th>
                    <th>Ritmo</th>
                </tr>
            </theader>
            <tbody>
                <?php 
                    foreach($ritmos as $ritmo){
                        ?>
                        <tr onClick="selectForChange(<?php echo $ritmo['id']; ?>,'<?php echo $ritmo['ritmo']; ?>')">
                            <td><?php echo $ritmo['id']; ?></td>
                            <td><?php echo $ritmo['ritmo']; ?></td>
                        </tr>
                        <?php
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
    </div>
    <script>
        function callAlert(){
            let confirmAction = confirm('Deseja mesmo deletar este ritmo');
            if(confirmAction){
                const idInput = document.querySelector('#id');
                const form = querySelector('form');
                form.method="get"
                form.action="./index.php?delete=" + idInput.value
                form.submit()
            }
        }
        function selectForChange(id,ritmo){
            const idInput = document.querySelector('#id');
            const ritmoInput = document.querySelector('#ritmo');
            idInput.value = id;
            ritmoInput.value = ritmo;
        }
    </script>
</body>
</html>