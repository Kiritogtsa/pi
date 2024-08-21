<?php
require_once('../models/users.php');
require_once('../models/salario.php');
require_once('../controller/autenticado.php');
require_once('../controller/privilegios.php');

if (!empty($_SESSION['buscuser'])) {
    $user = unserialize($_SESSION['buscuser']['userb']);
    $salario = $user->getissalario();
    $menssagem = $_SESSION['buscuser']['mensagem'];
    echo $menssagem;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="arte.css" media="screen" />
    <title>Buscar Funcionário</title>
</head>

<body>
    <header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>Buscar Funcionário</h1>
    </header>
    <!-- Formulário para buscar o funcionário -->
    <form method="POST" action="../controller/main.php" class="BuscarF">
        <input type="text" name="nome" placeholder="Digite o nome do funcionário">
        <button type="submit" value="Buscar_funcionario" name="submit">Buscar Funcionário</button>
    </form>
    <?php if (!empty($menssagem)) {
                ?> <h1 style='text-align: center';><?php echo $menssagem;?> </h1>
            <?php } ?>
    <div class="IBuscaF">
        <?php if (!empty($user) && !empty($salario)) { ?>
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
                        <td><label for="idatanascimento">Data de Nascimento:</label></td> <!-- Este -->
                        <td><input type="text" name="dataadmissao" value="<?= $user->getDataAdmissao(); ?>"></td>
                        <td><input type="text" name="telefone" value="<?= $user->getTelefone(); ?>"></td>
                        <td><input type="text" name="cpf" value="<?= $user->getCpf(); ?>"></td> <!-- Este -->
                        <td><input type="text" name="sexo" value="<?= $user->getSexo(); ?>"></td> <!-- Este -->
                    </tr>
                    <tr>
                        <th>Trabalho</th>
                        <th>Grupo</th>
                        <th>Salário bruto</th>
                        <th>IR</th>
                        <th>INSS</th>
                        <th>Adicional</th>
                        <th>Salário líquido</th>
                    </tr>
                    <td><input type="text" name="trabalho" value="<?= $user->getTrabalho(); ?>"></td>
                    <td><input type="text" name="grupo" value="<?= $user->getGrupo(); ?>"></td> <!-- Este -->
                    <input type='number' hidden name ='id' value = '<? $salario->getId();?>'>
                    <td><input type='number' name="bruto" value="<?= $salario->getSalariobruto(); ?>"></td>
                    <td><input type='number' name="ir" value="<?= $salario->getIr(); ?>"></td> <!-- Este -->
                    <td><input type='number' name="inss" value="<?= $salario->getInss(); ?>"></td> <!-- Este -->
                    <td><input type='number' name="adicional" value="<?= $salario->getAdicional(); ?>"></td>
                    <td><input type='number' name="grupo" value="<?= $salario->getSalarioliquido(); ?>"></td> <!-- Este -->
                    <tr>
                        <td colspan="18">
                            <button type="submit" value="Atualizar_usuario" name="submit">Atualizar</button>
                            <button type="submit" value="Desativar_usuario" name="submit">Desativar</button>
                            <button type="submit" value="Ativar_usuario" name="submit">Ativar</button>
                        </td>
                    </tr>
                </table>
            </form>
        <?php } ?>
    </div>
    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/saida.png" alt="Logout">
        </a>
        <a href="welcomeadmins.php"class="back-button">Voltar</a>
</body>
</html>
