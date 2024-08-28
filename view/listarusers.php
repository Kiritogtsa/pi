<?php
require_once('../models/users.php');
require_once('../models/trabalho.php');
require_once('../controller/privilegios.php');

if (!isset($_SESSION["incremento"])) {
    $incremento = 5;
} else {
    $incremento = $_SESSION["incremento"];
}

if (!isset($_SESSION["min"])) {
    $min = 5;
} else {
    $min = $_SESSION["min"];
}

$max = $min + $incremento;

$trabalho = new TrabalhoDAO();

if (!empty($_SESSION['listauser'])) {
    $dados = $_SESSION['listauser']['cargos'];
    $mensagem = $_SESSION['listauser']['message'];
    $min = $max;
    $incre = 5;
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
</head>

<body>
    <header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>RH Connect</h1>
    </header>
    <br><br><br><br>
    
    <!-- Formulário para buscar o funcionário -->
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
                <?php } ?>
            </table>
        </div>
    </div>

    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/saida.png" alt="Logout">
    </a>
    <a href="welcomeadmins.php" class="back-button">Voltar</a>
</body>

</html>
