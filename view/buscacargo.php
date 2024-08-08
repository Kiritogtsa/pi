<?php
require_once('../models/trabalho.php');
require_once('../controller/autenticado.php');
require_once('../controller/privilegios.php');

if (!empty($_SESSION['response'])) {
    $response = $_SESSION['response'];
    $cargos = unserialize($response['cargos']);
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
        <label for="nome">Nome trabalho:</label>
        <input type="text" id="nome" name="nome" required>
        <button type="submit" value="Buscar_cargos" name="submit">Buscar Cargo</button>
    </form>

    <?php if (!empty($response)) { 
     ?>
            <form method="POST" action="../controller/main.php">
                <table>
                    <tr>
                        <td><input type="text" name="id" value="<?php echo ($cargos->getIdCargo()); ?>"></td>
                        <td><input type="text" name="nome" value="<?php echo ($cargos->getNome()); ?>"></td>
                        <td><input type="text" name="descricao" value="<?php echo ($cargos->getDescricao()); ?>"></td>
                        <td>
                            <button type="submit" value="Atualizar_trabalho" name="submit">Atualizar</button>
                            <button type="submit" value="Deletar_trabalho" name="submit">Deletar</button>
                        </td>
                    </tr>
                </table>
            </form>
        <?php } ?>
</body>
</html>
