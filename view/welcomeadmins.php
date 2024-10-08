<?php
require_once("../controller/limparsessions.php");

require_once("../controller/privilegios.php");
if (!empty($_SESSION['user'])){
    $user = unserialize($_SESSION['user']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de RH - Bem-vindo</title>
    <link rel="stylesheet" type="text/css" href="arte.css" media="screen" />
</head>
<body>
<header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>RH Connect</h1>
    </header>
    <div class="content">
        <h2>BEM-VINDO <?php if (!empty($user)) {echo $user->getNome(); }?>!</h2>
    </div>


    <div class="links">
        <a href="cadatraruser.php">Adicionar Funcionário</a>
        <a href="Criatrab.php">Cadastrar cargo</a>
        <a href="buscarfuncionario.php">Buscar Funcionário</a>
        <a href="buscacargo.php">Buscar Cargo</a>
        <a href="listarusers.php">Lista de Funcionário</a>
        <a href="listatrabalhos.php">Lista de Trabalhos</a>
        <a href="perfil.php">Meus Dados</a>

    </div>
    
   

    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/sair.png" alt="Logout">
    </a>
</body>
</html>