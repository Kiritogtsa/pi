<?php
require_once("../controller/autenticado.php");

$user = unserialize($_SESSION["user"]);
$salario = $user->getissalario();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="arte.css" media="screen" />
    <title>Perfil usuário</title>
    <style>
        a.back-button {
            text-decoration: none;
        }
    </style>
</head>
<body>
<header>
    <img src="imagens/RH.png" alt="Logo RH Connect">
    <h1>Perfil</h1>
</header>
    <div class="perfil-container">
        <!-- Tabela de Informações Pessoais -->
        <table class="perfil-info">
            <tr>
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
            </tr>
        </table>

        <!-- Tabela de Salário -->
        <table class="perfil-salario">
            <tr>
                <th>Salário bruto</th>
                <th>IR</th>
                <th>INSS</th>
                <th>Adicional</th>
                <th>Salário Líquido</th>
            </tr>
            <tr>
                <td><?php echo $salario->getSalariobruto(); ?></td>
                <td><?php echo $salario->getIr(); ?></td>
                <td><?php echo $salario->getInss(); ?></td>
                <td><?php echo $salario->getAdicional(); ?></td>
                <td><?php echo $salario->getSalarioliquido(); ?></td>
            </tr>
        </table>
    </div>

    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/sair.png" alt="Logout">
    </a>
    <?php if($user->getGrupo() == 'gerente' || $user->getGrupo() == 'auxiliar'){ ?>
        <a href="welcomeadmins.php"class="back-button">Voltar</a>
    <?php }else{ ?>
       <?php require_once("../controller/limparsessions.php"); ?>
        <a href="welcome.php"class="back-button">Voltar</a>
    <?php } ?>
</body>
</html>