<?php
require_once("../controller/autenticado.php");
require_once("../controller/privilegios.php");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de RH - Bem-vindo</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <ul>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Welcome!</h2>
        <h3><?php echo (isset($_SESSION["mensagem"])) ? $_SESSION["mensagem"] : ""; ?></h3>
    </div>
    <div class="link">
        <a href="../controller/logout.php">Logout</a>
    </div>
</body>
</html>
