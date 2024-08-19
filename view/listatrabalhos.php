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
<header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>RH Connect</h1>
    </header>
    <div class="container">
        <form method="POST" action="../controller/main.php" class="formulario-busca-cargo">
            <button type="submit" name="submit" value="Listar_cargos" class="Bcargo">Listar trabalhos</button>
            <?php if ($status == true) { ?>
            <div class="formulario-exibicao-cargo">
                <?php echo $messagem; ?>
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
    </div>
    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/saida.png" alt="Logout">
    </a>
    <a href="welcomeadmins.php"class="back-button">Voltar</a>
</body>
</html>
