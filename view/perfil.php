<?php
require_once("../controller/autenticado.php");
$user = unserialize($_SESSION["user"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: slategray;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td {
            color: #333;
        }
        .header-row {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <table>
        <tr class="header-row">
            <th>Nome</th>
            <th>Email</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Sexo</th>
            <th>Trabalho</th>
            <th>Grupo</th>
            <th>Data de Admissão</th>
            <th>Telefone</th>
        </tr>
        <tr>
            <td><?php echo $user->getNome(); ?></td>
            <td><?php echo $user->getEmail(); ?></td>
            <td><?php echo $user->getCPF(); ?></td>
            <td><?php echo $user->getDataNascimento(); ?></td>
            <td><?php echo $user->getSexo(); ?></td>
            <td><?php echo $user->getTrabalho(); ?></td>
            <td><?php echo $user->getGrupo(); ?></td>
            <td><?php echo $user->getDataAdimisao(); ?></td>
            <td><?php echo $user->getTelefone(); ?></td>
        </tr>
    </table>
</body>
</html>
