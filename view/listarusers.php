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
    if(!empty($_SESSION['listauser']['message'])){
        $mensagem = $_SESSION['listauser']['message'];
    }
}

if(!empty($_SESSION['desastiv_list'])){
    $mensagem = $_SESSION['desastiv_list']['message'];
}

if(!empty($_SESSION['ativar_list'])){
    $mensagem = $_SESSION['ativar_list']['message'];
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
    <div class="container">
        <div class="formulario-exibicao-cargo">
            <form method="POST" action="../controller/main.php" class="formulario-busca-cargo">
                <input type="number" id="min" name="min" value="<?php echo $min ?>" hidden>
                <input type="number" id="max" name="max" value="<?php echo $max ?>" hidden>
                <button type="submit" value="Listar_funcionario" name="submit">Listar funcionários</button>
            </form>
            <div class="IBuscaF">
            <?php if(!empty($mensagem)){?>
        <h1> <?php echo $mensagem;?></h1>
    <?php } ?>
                <table>
                    <?php if (!empty($dados)) {
                        foreach ($dados as $d) { ?>
                    <tr>
                        <th>NOME</th>
                        <th>TRABALHO</th>
                        <th>Desativado</th>
                    </tr>   <form action="../controller/main.php" method="POST">
                                <input type="hidden" name="id" readonly value="<?php echo $d->getId(); ?> ">
                                <td><?php echo $d->getNome(); ?></td>
                                <td><?php echo $trabalho->buscarPorId($d->getTrabalho()); ?></td>
                                <td><?php echo $d->getDeletedAt(); ?></td>
                                <td>
                                        <button type="submit" value="Desativar_usuariolist" name="submit">Desativar funcionário</button>
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