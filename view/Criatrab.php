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
    <title>Criar Cargo</title>
</head>
<body>
    <?php if(!empty($data)){
        echo $data;
    }?>   
<form method="POST" action="../controller/main.php">
    <label for="nome">Nome trabalho:</label>
    <input type="text" id="nome" name="nome" required>
        
    <label for="nome">Descrição:</label>
    <input type="text" id="nome" name="descricao" required>

    <button type="submit" value="Criar_cargo" name="submit">Cadastrar cargo</button>
    </form>
</body>
</html>

