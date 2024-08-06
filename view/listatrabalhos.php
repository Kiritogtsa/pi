<?php
session_start();
// require_once("../controller/autenticado.php");
// require_once("../controller/privilegios.php");
$response = $_SESSION['response'];
$cargos = unserialize($response['cargos']);
$sucesso = $response['success'];
$messagem = $response['message'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form method="POST" action="../controller/main.php">
<button type="submit" value="Listar_cargos" name="submit">Listar cargos</button>
</form>
 
    <?php if($sucesso == true){ ?>
        <?php echo $messagem ?>
        <table>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>DESCRIÇÃO</th>
            </tr>
            <tr>
                <?php foreach($cargos as $cg){ ?>
                <th><?php echo $cg->getIdCargo(); ?></th>    
                <th><?php echo $cg->getNome(); ?></th>
                <th><?php echo $cg->getDescricao(); ?></th>
                <?php }; ?>
            </tr>
                </table>
    <?php }else{
        echo $messagem;
    } ?>
</body>
</html>