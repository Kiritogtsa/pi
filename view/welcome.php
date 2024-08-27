<?php


if (!empty($_SESSION['user'])){
    $user = unserialize($_SESSION['user']);
}

if(!empty($_SESSION['naopermitido'])){
    $mensagem = $_SESSION['naopermitido'];
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
    <h2><?php if (!empty($user)) {echo 'BEM-VINDO',' ', $user->getNome(); }?>!</h2>
    <h2><?php if(!empty($mensagem)) { echo $mensagem; } ?></h2>
    </div>


    <div class="links">
        <a href="perfil.php">Meus Dados</a>
    </div>
    
   

    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/saida.png" alt="Logout">
    </a>
</body>
</html>
