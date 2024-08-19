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
<header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>RH Connect</h1>
    </header>
    <!-- Formulário para buscar o funcionário -->
    <form method="POST" action="../controller/main.php">
        <input type="text" name="nome" placeholder="Digite o nome do funcionário">
        <button type="submit" value="Buscar_funcionario" name="submit">Buscar Funcionário</button>
    </form>

    <!-- Exibição do formulário para atualizar as informações do funcionário -->
    <?php if(!empty($user)){ }?>
    <form method="POST" action="../controller/main.php">
        <table>
        </table>
    </form>
</body>