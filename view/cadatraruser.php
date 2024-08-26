<?php
require_once('../controller/privilegios.php');
require_once('../controller/autenticado.php');
require_once("../models/trabalho.php");
$cargosdao = new TrabalhoDAO();
$cargos = $cargosdao->listarCargo();
if (empty($cargos)) {
    echo "Nenhum trabalho cadastrado";
}

?>
<!DOCTYPE html>
<html lang='pt-br'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel="stylesheet" type="text/css" href="arte.css" media="screen" />
    <title>Cadastro</title>
</head>

<body>
    <header>
        <img src="imagens/RH.png" alt="Logo RH Connect">
        <h1>Cadastrar funcionário</h1>
    </header>
<div class="cadastrauser">

    <?php if(!empty($_SESSION['mensagemcadasuser'])){?>
        <h1> <?php echo $_SESSION['mensagemcadasuser'];?></h1>
    <?php } ?>
    </div>
    <div class="form-container">
   
    <form id='form' method='POST' action='../controller/main.php'>
            <div class="Cpessoa">

                <h1>Dados pessoais</h1>

                <label for='nome'>Nome:</label>
                <input type='text' id='nome' name='nome' required>

                <label for='cpf'>CPF:</label>
                <input type='text' min="11" max="14" id='cpf' name='cpf' required>

                <label for='sexo'>Sexo:</label>
                <select name="sexo" id="sexo">
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                </select>
                <label for='email'>Email:</label>
                <input type='email' id='email' name='email' required>

                <label for='datanascimento'>Data de Nascimento:</label>
                <input type='date' id='datanascimento' name='datanascimento' required>

                <label for='senha'>Senha:</label>
                <input type='password' id='senha' name='senha' required>


            </div>

            <div class="Csetor">
                <h1>Dados do setor</h1>
                <label for='dataadmissao'>Data de Admissao:</label>
                <input type='date' id='dataadmissao' name='dataadmissao' required>


                <label for='trabalho'>Selecione um Trabalho:</label>
                <select name='trabalho' required>
                    <?php
                    foreach ($cargos as $cargo) {
                    ?><option value="<?= $cargo->getIdCargo() ?>"> <?= $cargo->getNome() ?></option><?php
                                                                                                }
                                                                                                    ?>
                </select>
                <label for='grupo'>Selecione um Grupo:</label>
                <select name="grupo" id="grupo">
                    <option value="gerente">gerente</option>
                    <option value="auxiliar">auxiliar</option>
                    <option value="user">user</option>
                </select>
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" required  pattern="\(\d{2}\)\s\d{4,5}-\d{4}" title="O formato esperado é: (55) 93112-4241">


                <label for='Salario'>Salário bruto:</label>
                <input type='text' id='Salario' name='bruto' required>

                <label for='Adicional'>Adicional:</label>
                <input type='number' id='adicional' name='adicional' required>
                </select>
                </select>
            </div>
            <button type='submit' name='submit' value='Cadatrar_user' class="Bcada">Cadastrar</button>
        </form>
    </div>

    <a href="../controller/logout.php" class="logout-icon">
        <img src="imagens/saida.png" alt="Logout">
        </a>
        <a href="welcomeadmins.php"class="back-button">Voltar</a>
</nav>
</body>
</html>