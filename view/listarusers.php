<?php
require_once('../models/users.php');
require_once('../models/trabalho.php');
require_once('../controller/autenticado.php');
require_once('../controller/privilegios.php');
$min = 1;
$max = 5;
$trabalho = new TrabalhoDAO();
if(!empty($_SESSION['listauser'])){
    $dados = $_SESSION['listauser']['cargos'];

}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Funcionário</title>
    <link rel="stylesheet" type="text/css" href="arte.css" media="screen" />
</head>
<body>
    <header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>RH Connect</h1>
    </header>
    <br>
<br>
<br>
<br>
    <!-- Formulário para buscar o funcionário -->
    <div class="container">
        <div class="formulario-exibicao-cargo">
            <form method="POST" action="../controller/main.php" class="formulario-busca-cargo">
                <input type="number" id="min" name="min" value="<?php echo $min ?>" hidden>
                <input type="number" id="max" name="max" value="<?php echo $max ?>" hidden>
                <button type="submit" value="Listar_funcionario" name="submit">Listar funcionários</button>
            </form>
            
            <div class="IBuscaF">
                <table>
                    <?php if (!empty($dados)) {
                        foreach ($dados as $d) { ?>
                    <tr>
                        <th>ID</th>
                        <th>NOME</th>
                        <th>TRABALHO</th>
                        <th>Desativado</th>
                    </tr>
                                <td><?php echo $d->getId(); ?></td>
                                <td><?php echo $d->getNome(); ?></td>
                                <td><?php echo $trabalho->buscarPorId($d->getTrabalho()); ?></td>
                                <td><?php echo $d->getDeletedAt(); ?></td>
                                <td>
                                    <form action="../controller/main.php" method="POST">
                                        <button type="submit" value="Desativar_usuario" name="submit">Desativar funcionário</button>
                                        <button type="submit" value="Ativar_usuariolist" name="submit">Ativar funcionário</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </table>
            </div>
        </div>
    </div>
    
    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/saida.png" alt="Logout">
    </a>
    <a href="welcomeadmins.php" class="back-button">Voltar</a>
</body>
</html>