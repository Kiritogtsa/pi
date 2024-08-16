<?php
require_once("../controller/privilegios.php");
require_once("../models/trabalho.php");
if(!empty($_SESSION['listar'])){
$response = $_SESSION['listar'];
$cargos = unserialize($response['cargos']);
$sucesso = $response['successo'];
$messagem = $response['menssagem'];
$status = true;
}else{
    $status= false;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar cargos</title>
</head>
<body>   
<form method='POST' action='../controller/main.php'>
<button type='submit' name='submit' value='Listar_cargos'>Listar trabalhos</button>
</form>
    <?php if($status == true){ ?>
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
        if($status == true){
        echo $messagem;
        }
    } ?>
</body>
</html>