<?php
require_once('autenticado.php');
require_once('privilegios.php');
if(!empty($_SESSION['dados'])){
    $dados = unserialize(($_SESSION['dados']));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Funcionários</title>
</head>
<body>
    <table>
        <?php 
            foreach($dados as $d){
                    ?>
                <form method="POST" action="../controller/main.php">
                <input type="text" <?php $d['Nome'];?>>
                <label for="">Cpf: <?php $d['Cpf'];?></label>
                <input type="text" <?php $d['Email'];?>>
                <label hidden>Senha: <?php $d['senha'];?></label>
                <label for="">Data nascimento: <?php $d['data_nas'];?></label>
                <input type="text"<?php $d['data_at'];?>>
                <input type="text" <?php $d['telefone'];?>>
                <label for="">Grupo <?php $d['grupo'];?></label>
                <label for=""> Sexo: <?php $d['sexo'];?></label>
                <input type="text" <?php $d['trabalho'];?>>
                <label for=""> Matrícula: <?php $d['id'];?></label>
                <label for=""><?php $d['delete'];?></label>
                <button type="submit" value="Atualizar_usuario" name="submit">Atualizar</button>
                <button type="submit" value="Atualizar o estado" name="submit">Desativar</button>
                </form>
            <?php }?>
    </table>
    
</body>
</html>