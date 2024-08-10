<?php
require_once("../controller/autenticado.php");
require_once("../models/salario.php");
$user = unserialize($_SESSION["user"]);
$salario = $user->getissalario();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil usuário</title>
</head>
<body>
    <table>
        <tr class="header-row">
            <th>Nome</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Sexo</th>
            <th>Trabalho</th>
            <th>Grupo</th>
            <th>Data de Admissão</th>
            <th>Telefone</th>
        </tr>
        <tr>
            <td><?php echo $user->getNome(); ?></td>
            <td><?php echo $user->getEmail(); ?></td>
            <td><?php echo $user->getCPF(); ?></td>
            <td><?php echo $user->getDataNascimento(); ?></td>
            <td><?php echo $user->getSexo(); ?></td>
            <td><?php echo $user->getTrabalho(); ?></td>
            <td><?php echo $user->getGrupo(); ?></td>
            <td><?php echo $user->getDataAdmissao(); ?></td>
            <td><?php echo $user->getTelefone(); ?></td>
            <td><?php echo $salario->getSalariobruto(); ?></td>
        </tr>
    </table>
</body>
</html>
