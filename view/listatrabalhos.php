<?php
require_once("../controller/autenticado.php");
$cargos = unserialize($_SESSION['cargos']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <tr>
        <th>ID</th>
        <th>NOME</th>
        <th>DESCRIÇÃO</th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</body>
</html>