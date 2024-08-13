<?php
require_once('../models/trabalho.php');
require_once('../controller/autenticado.php');
require_once('../controller/privilegios.php');
if (!empty($_SESSION['data'])){
$data = $_SESSION['data'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="arte.css" media="screen" />
    <title>Criar Cargo</title>
</head>
<body>
<header>
    <img src="imagens/RH.png" alt="Logo RH Connect">
    <h1>RH Connect</h1>
</header>
    <?php if(!empty($data)){
        echo $data;
    }?>   
<div class="Ctab2">
<form method="POST" action="../controller/main.php" class="Ctab" >
<h1> Cadastrar cargo </h1>
    <label for="nome"></label>
    <input type="text" id="nome" name="nome" required placeholder="Nome">
        
    <label for="nome"></label>
    <input type="text" id="nome" name="descricao" required placeholder="Descrição">

    <button type="submit" value="Criar_cargo" name="submit" class="Bcargo">Cadastrar cargo</button>
    </form>
</div>
</body>
</html>

