<?php
var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="../view/listar.html">aqui</a>
    <form id="form" method="POST" action="../controller/main.php" class="pessoa">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="cpf">CPF:</label>
        <input type="number" id="cpf" name="cpf" required>
        
        <label for="sexo">Sexo:</label>
        <input type="text" id="sexo" name="sexo" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="dataadmissao">Data de Admissao:</label>
        <input type="date" id="dataadmissao" name="dataadmissao" required>

        <label for="datanascimento">Data de Nascimento:</label>
        <input type="date" id="datanascimento" name="datanascimento" required>

        <label for="trabalho">Trabalho:</label>
        <input type="text" id="trabalho" name="trabalho" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit" name="submit" value="Enviar">Enviar</button>

        </form>
    
</body>
</html>