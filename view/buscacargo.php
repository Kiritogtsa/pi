<?php
require_once('../models/trabalho.php');
require_once('../controller/autenticado.php');
require_once('../controller/privilegios.php');
if (!empty($_SESSION['response'])) {
$response = $_SESSION['response'];
$cargos = unserialize($response['cargo']);
$sucesso = $response['success'];
$messagem = $response['messagem'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar cargo</title>
</head>
<body>
    <form method="POST" action="../controller/main.php">
        <label for="nome">Nome da função:</label>
        <input type="text" id="nome" name="nome" required>

        <button type="submit" value="Buscar_cargos" name="submit">Buscar cargo</button>
    </form>

    <?php if (!empty($response)) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>DESCRIÇÃO</th>
            </tr>
            <tr>
                <td><?php echo $cargos->getIdCargo(); ?></td>
                <td><?php echo $cargos->getNome(); ?></td>
                <td><?php echo $cargos->getDescricao(); ?></td>
            </tr>
        </table>
    <?php } ?>
</body>
</html>
