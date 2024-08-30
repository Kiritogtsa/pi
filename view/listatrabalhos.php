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
    <link rel="stylesheet" href="arte.css"> <!-- Link para o arquivo CSS -->
</head>
<body>
<header style="padding-bottom: 0.01%";>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>Lista de Trabalhos</h1>
        <style>
        a.back-button {
            text-decoration: none;
        }
    </style>
    </header >
    <div class="container">
    <form method="POST" action="../controller/main.php">
            <button type="submit" name="submit" value="Listar_cargos" class="Bcargo">Listar trabalhos</button>
            </form>
    <?php if ($status == true) { 
                 ?> <h1 style='text-align: center';><?php echo $messagem;?></h1>
            <div class="formulario-exibicao-cargo">
        </form>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>NOME</th>
                        <th>DESCRIÇÃO</th>
                    </tr>
                    <?php foreach ($cargos as $cg) { ?>
                        <tr>
                            <td><?php echo $cg->getIdCargo(); ?></td>
                            <td><?php echo $cg->getNome(); ?></td>
                            <td><?php echo $cg->getDescricao(); ?></td>
                        </tr>
                    <?php } ?>
               
                </table>
            </div>
        <?php } ?>
    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/sair.png" alt="Logout">
    </a>
    <a href="welcomeadmins.php"class="back-button">Voltar</a>
</body>
</html>