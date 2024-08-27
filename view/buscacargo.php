<?php
require_once('../models/trabalho.php');
require_once('../controller/privilegiosadmin.php');

if (!empty($_SESSION['buscar'])) {
    $response = $_SESSION['buscar'];
    if(!empty ($response['cargos'])){
    $cargos = unserialize($response['cargos']);
    }
    if(!empty($_SESSION['buscar']['message'])){
    $messagem = $response['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="arte.css" media="screen" />
    <title>Buscar Cargo</title>

</head>
<body>
<header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>Buscar Cargo</h1>
    </header>
        <div class="container">
        <?php if (!empty($messagem)){ ?>
              <h1>  <?php echo $messagem; ?>  </h1>
            <?php } ?>
            <div class="formulario-busca-cargo">
                <form method="POST" action="../controller/main.php">
                    <label for="nome">Nome trabalho:</label>
                    <input type="text" id="nome" name="nome" required>
                    <button type="submit" value="Buscar_cargos" name="submit">Buscar Cargo</button>

                </form>
            </div>
           <?php if (!empty($response)) { ?>
                <div class="formulario-exibicao-cargo">
                    <form method="POST" action="../controller/main.php">
                        <table>
                             <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                                </tr>
                                <td><input type="text" name="id" value="<?php echo ($cargos->getIdCargo()); ?>" readonly></td>
                                <td><input type="text" name="nome" value="<?php echo ($cargos->getNome()); ?>"></td>
                                <td><input type="text" name="descricao" value="<?php echo ($cargos->getDescricao()); ?>"></td>
                                <td>
                                    <button type="submit" value="Atualizar_trabalho" name="submit">Atualizar</button>
                                    <button type="submit" value="Deletar_trabalho" name="submit">Deletar</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            <?php } ?>

        </div>
        <a href="../controller/logout.php" class="logout-icon">
            <img src="imagens/saida.png" alt="Logout">
            </a>
            <a href="welcomeadmins.php"class="back-button">Voltar</a>
    </body>

</html>