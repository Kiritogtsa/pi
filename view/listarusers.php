<?php
require_once('../models/users.php');
require_once('../models/trabalho.php');
require_once('../controller/privilegios.php');
$min = 0;
$max = 5;
$trabalho = new TrabalhoDAO();
$limite = $trabalho->lastID();

if (!empty($_SESSION['listauser'])) {
    $dados = $_SESSION['listauser']['cargos'];
    $mensagem = $_SESSION['listauser']['message'];
    $min = $_SESSION['listauser']['min'];
    $max = $_SESSION['listauser']['max'];
}
if (!empty($_SESSION['desastiv_list'])) {
    $mensagem = $_SESSION['desastiv_list']['message'];
}

if (!empty($_SESSION['ativar_list'])) {
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
    <style>
        a.back-button {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>RH Connect</h1>
    </header>
    <div class="container">
        <div class="formulario-exibicao-cargo">
            <form method="POST" action="../controller/main.php" class="formulario-busca-cargo">
                <input type="number" id="min" name="min" value="<?php echo $min ?>" hidden>
                <input type="number" id="max" name="max" value="<?php echo $max ?>" hidden>
                <button type="submit" value="Listar_funcionario" name="submit">Listar funcionários</button>
            </form>

            <?php if (!empty($mensagem)) { ?>
                <h1><?php echo $mensagem; ?></h1>
            <?php } ?>

            <table>
                <?php if (!empty($dados)) { ?>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>TRABALHO</th>
                            <th>Desativado</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados as $d) { ?>
                            <tr>
                                <td><?php echo $d->getId(); ?></td>
                                <td><?php echo $d->getNome(); ?></td>
                                <td><?php echo $trabalho->buscarPorId($d->getTrabalho()); ?></td>
                                <td><?php echo $d->getDeletedAt(); ?></td>
                                <td>
                                    <form action="../controller/main.php" method="POST">
                                        <input type="number" hidden name="id" value="<?= $d->getId() ?>">
                                        <?php if ($d->getDeletedAt() == null) { ?>
                                            <button type="submit" value="Desativar_usuariolist" name="submit">Desativar funcionário</button>
                                        <?php } else { ?>
                                            <button type="submit" value="Ativar_usuariolist" name="submit">Ativar funcionário</button>
                                        <?php } ?>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="pagination-buttons">
                    <form method="POST" action="../controller/main.php" class="formulario-busca-cargo">
                        <input type="number" id="min" name="min" value="<?php echo $min ?>" hidden>
                        <input type="number" id="max" name="max" value="<?php echo $max ?>" hidden>
                        <button type="submit" value="Voltar" name="submit" <?php echo $min <= 0 ? 'disabled' : ''; ?>>Voltar</button>
                    </form>
                    <form method="POST" action="../controller/main.php" class="formulario-busca-cargo">
                        <input type="number" id="min" name="min" value="<?php echo $min ?>" hidden>
                        <input type="number" id="max" name="max" value="<?php echo $max; ?>" hidden>
                        <button type="submit" value="Avancar" name="submit" <?php echo $max >= $limite['ID'] ? 'disabled' : ''; ?>>Avançar</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>

    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/sair.png" alt="Logout">
    </a>
    <a href="welcomeadmins.php" class="back-button">Voltar</a>
</body>

</html>