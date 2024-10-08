<?php
require_once('../models/trabalho.php');
require_once('../models/users.php');
require_once('../models/salario.php');
require_once('../controller/privilegios.php');

$trabalhosdao = new TrabalhoDAO();
$cargos = $trabalhosdao->listarCargosemgerente();
$cargost = $trabalhosdao->listarCargo();
$user = null;
$salario = null;
$mensagem = null;

if (!empty($_SESSION['buscuser'])) {
    if (!empty($_SESSION['buscuser']['userb'])) {
        $user = unserialize($_SESSION['buscuser']['userb']);
        $salario = $user->getissalario();
    }
    $mensagem = $_SESSION['buscuser']['mensagem'];
}

if (!empty($_SESSION['user_atualiz'])) {
    if (!empty($_SESSION['user_atualiz']["user_atuali"])) {
        $user = unserialize($_SESSION['user_atualiz']["user_atuali"]);
        $salario = $user->getissalario();
    }
    $mensagem = $_SESSION['user_atualiz']["messagem"];
}

if (!empty($_SESSION['ativado'])) {
    if (!empty($_SESSION['ativado']["usera"])) {
        $user = unserialize($_SESSION['ativado']["usera"]);
        $salario = $user->getissalario();
        $mensagem = $_SESSION['ativado']["message"];
    }
}

if (!empty($_SESSION['desativado'])) {
    if (!empty($_SESSION['desativado']["user"])) {
        $user = unserialize($_SESSION['desativado']['user']);
        $salario = $user->getissalario();
        $mensagem = $_SESSION['desativado']['message'];
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="arte.css" media="screen" />
    <title>Buscar Funcionário</title>
    <style>
        a.back-button {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>Buscar Funcionário</h1>
    </header>

    <form method="POST" action="../controller/main.php" class="BuscarF">
        <input type="text" name="nome" placeholder="Digite o nome do funcionário">
        <button type="submit" value="Buscar_funcionario" name="submit">Buscar Funcionário</button>
    </form>

    <?php if (!empty($mensagem)) { ?>
        <h1 style='text-align: center;'><?php echo $mensagem; ?></h1>
    <?php } ?>

    <?php if (!empty($user) && !empty($salario)) { ?>
        <div class="IBuscaF">
            <form method="POST" action="../controller/main.php">
                <table>
                    <!-- Dados do Funcionário -->
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data de Nascimento</th>
                        <th>Data de Admissão</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th>Sexo</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="id" value="<?= $user->getId(); ?>" readonly></td>
                        <td><input type="text" name="nome" value="<?= $user->getNome(); ?>"></td>
                        <td><input type="text" name="email" value="<?= $user->getEmail(); ?>"></td>
                        <td><input type="text" name="datanascimento" value="<?= $user->getDataNascimento(); ?>" readonly></td>
                        <td><input type="text" name="dataadmissao" value="<?= $user->getDataAdmissao(); ?>"></td>
                        <td><input type="text" name="telefone" value="<?= $user->getTelefone(); ?>"></td>
                        <td><input type="text" name="cpf" value="<?= $user->getCpf(); ?>" readonly></td>
                        <td><input type="text" name="sexo" value="<?= $user->getSexo(); ?>" readonly></td>
                    </tr>
                    <tr>
                        <th>Cargo</th>
                        <th>Grupo</th>
                        <th>Salário bruto</th>
                        <th>IR</th>
                        <th>INSS</th>
                        <th>Adicional</th>
                        <th>Salário líquido</th>
                        <th>Desativado</th>
                    </tr>
                    <tr>
                        <td>
                            <?php if ($user->getGrupo() == 'gerente') { ?>
                                <select name='trabalho' required>
                                    <option value="<?= $user->getTrabalho() ?>" selected> <?= $cargost[$user->getTrabalho()-1]->getNome() ?></option>
                                    <?php foreach ($cargost as $cargot) { 
                                        if ($cargot->getIdCargo() != $user->getTrabalho()) { ?>
                                            <option value="<?= $cargot->getIdCargo() ?>"> <?= $cargot->getNome() ?></option>
                                    <?php } } ?>
                                </select>
                            <?php } else { ?>
                                <select name='trabalho' required>
                                    <option value="<?= $user->getTrabalho() ?>"> <?= $cargos[$user->getTrabalho() - 2]->getNome() ?></option>
                                    <?php foreach ($cargos as $cargo) {
                                        if ($cargo->getIdCargo() != $user->getTrabalho()) { ?>
                                            <option value="<?= $cargo->getIdCargo() ?>"> <?= $cargo->getNome() ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            <?php } ?>
                        </td>
                        <td><input type="text" name="grupo" value="<?= $user->getGrupo(); ?>" readonly></td>
                        <input type='number' hidden name='id' value='<?= $salario->getId(); ?>'>
                        <td><input type='number' name="bruto" value="<?= $salario->getSalariobruto(); ?>"></td>
                        <td><input type="text" name="ir" value="<?= $salario->getIr(); ?>" readonly></td>
                        <td><input type="text" name="inss" value="<?= $salario->getInss(); ?>" readonly></td>
                        <td><input type='number' name="adicional" value="<?= $salario->getAdicional(); ?>"></td>
                        <td><input type="text" name="salarioliquido" value="<?= $salario->getSalarioliquido(); ?>" readonly></td>
                        <td><input type="text" name="deletado" value="<?php if ($user->getDeletedAt() == null) {
                            echo '';
                        } else {
                            echo $user->getDeletedAt();
                        } ?>" readonly></td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <button type="submit" value="Atualizar_usuario" name="submit">Atualizar</button>
                            <button type="submit" value="Desativar_usuario" name="submit">Desativar</button>
                            <button type="submit" value="Ativar_usuario" name="submit">Ativar</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    <?php } ?>

    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/sair.png" alt="Logout">
    </a>
    <a href="welcomeadmins.php" class="back-button">Voltar</a>
</body>

</html>
