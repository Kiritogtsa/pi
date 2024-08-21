<?php
require_once('../models/users.php');
require_once('../controller/autenticado.php');
require_once('../controller/privilegios.php');
$min = 1;
$max = 5;
if(!empty($_SESSION['listauser'])){
    $dados = $_SESSION['listauser']['cargos'];

}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Funcionário</title>
</head>
<body>
<header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>RH Connect</h1>
    </header>
    <!-- Formulário para buscar o funcionário -->
    <form method="POST" action="../controller/main.php">
        <input hidden type="number" id = 'min' name = 'min' value = "<?php echo $min ?>">
        <input hidden type="number" id = 'max' name = 'max' value = "<?php echo $max ?>">
        <button type="submit" value="Listar_funcionario" name="submit">Listar funcionários</button>
    </form>
    <table>
    <?php if(!empty($dados)){
        foreach($dados as $d){
            echo $d->getId();
            echo $d->getNome();
            echo $d->getTrabalho();?>
            <form action="../controller/main.php">
            <button type="submit" value="Desativar_usuario" name="submit">Desativar funcionário</button>
            <button type="submit" value="Ativar_usuario" name="submit">Ativar funcionário</button>
            </form>
        <?php }}?>
        </table>
    </form>
</body>