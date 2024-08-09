<?php
require_once('../models/users.php');
require_once('../controller/autenticado.php');
require_once('../controller/privilegios.php');

if(!empty($_SESSION['buscuser'])){
    $user = unserialize($_SESSION['buscuser']['userb']);
    $salario = $user->getissalario(); // Certifique-se que o método getSalario() existe e está retornando o objeto correto
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Funcionário</title>
</head>
<body>
    <!-- Formulário para buscar o funcionário -->
    <form method="POST" action="../controller/main.php">
        <input type="text" name="nome" placeholder="Digite o nome do funcionário">
        <button type="submit" value="Buscar_funcionario" name="submit">Buscar Funcionário</button>
    </form>

    <!-- Exibição do formulário para atualizar as informações do funcionário -->
    <?php if(!empty($user)){ ?>
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
                <th>Trabalho</th>
                <th>Grupo</th>
            </tr>
            <tr>
                <td><input type="text" name="id" value="<?= $user->getId(); ?>" readonly></td>
                <td><input type="text" name="nome" value="<?= $user->getNome(); ?>"></td>
                <td><input type="text" name="email" value="<?= $user->getEmail(); ?>"></td>
                <td><input type="text" name="data_nascimento" value="<?= $user->getDataNascimento(); ?>"></td>
                <td><input type="text" name="data_admissao" value="<?= $user->getDataAdmissao(); ?>"></td>
                <td><input type="text" name="telefone" value="<?= $user->getTelefone(); ?>"></td>
                <td><input type="text" name="cpf" value="<?= $user->getCpf(); ?>"></td>
                <td><input type="text" name="sexo" value="<?= $user->getSexo(); ?>"></td>
                <td><input type="text" name="trabalho" value="<?= $user->getTrabalho(); ?>"></td>
                <td><input type="text" name="grupo" value="<?= $user->getGrupo(); ?>"></td>
            </tr>
            <tr>
                <td colspan="18">
                    <button type="submit" value="Atualizar_usuario" name="submit">Atualizar</button>
                    <button type="submit" value="Desativar" name="submit">Desativar</button>
                </td>
            </tr>
        </table>
    </form>
    <?php } ?>
</body>
</html>
