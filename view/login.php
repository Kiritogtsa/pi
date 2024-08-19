<?php
//primeiro = len() | count() 
//maximo = primeiro + 6

for($id=0;$id<21;$i++){

}


// USUARIO 1= ID = 1
// USUARIO 2 = ID = 5
// USUARIO 3 = ID = 21

?> 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RH Connect - Login</title>
    <link rel="stylesheet" type="text/css" href="arte.css" media="screen" />
</head>
<body>
    <header>
        <img src="imagens/RH.png">
        <h1>RH Connect</h1>
    </header>
    <main class="login">
        <form action="../controller/main.php" method="post">
            <div class="input-container">
                <img src="imagens/perfil.png" alt="Ícone de Email" class="input-icon">
                <input type="text" id="usuario" name="email" required placeholder="Email">
            </div>

            <div class="input-container">
                <img src="imagens/senha.png" alt="Ícone de Senha" class="input-icon">
                <input type="password" id="senha" name="senha" required placeholder="Senha">
            </div>
            <div class="input-container">
            <img src="imagens/login.png" alt="Ícone de Senha" class="input-icon">
            <button type="submit" name="submit" value="login">LOGIN</button>
            </div>
        </form>
    </main>
</body>
</html>
