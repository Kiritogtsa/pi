<?php
require_once("../controller/autenticado.php");
require_once("../controller/autenticado.php");
$cargos = unserialize($_SESSION['response']['cargos']);
$sucesso = $_SESSION['response']['true'];
$messagem = $_SESSION['response']['message'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
                <th><?php $cg->getIdCargo(); ?></th>    
                <th><?php $cg->getNome(); ?></th>
                <th><?php $cg->getDescricao(); ?></th>
                <?php }; ?>
            </tr>
                </table>
    <?php }else{
        echo $messagem;
    } ?>
</body>
</html>