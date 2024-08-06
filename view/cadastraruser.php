<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Cadastro</title>
</head>
<body>
    <form id='form' method='POST' action='../controller/main.php' class='pessoa'>
        <label for='nome'>Nome:</label>
        <input type='text' id='nome' name='nome' required>
        
        <label for='cpf'>CPF:</label>
        <input type='text' id='cpf' name='cpf' required>
        
        <label for='sexo'>Sexo:</label>
        <input type='text' id='sexo' name='sexo' required>
        
        <label for='email'>Email:</label>
        <input type='email' id='email' name='email' required>
        
        <label for='dataadmissao'>Data de Admissao:</label>
        <input type='date' id='dataadmissao' name='dataadmissao' required>

        <label for='datanascimento'>Data de Nascimento:</label>
        <input type='date' id='datanascimento' name='datanascimento' required>

        <label for='senha'>Senha:</label>
        <input type='password' id='senha' name='senha' required>
        
        <label for='telefone'>Telefone:</label>
        <input type='text' id='telefone' name='telefone' required>

        <label for='trabalho'>Selecione um Cargo:</label>
        <select type ='cargoSelect' name='trabalho' required></select>

        <label for='grupo'>Grupo: </label>
        <input type = 'text' name='grupo' required></input>

        <label for='Salário'>Salário bruto</label>
        <input id='Salario' name='bruto' required></input>


        <button type='submit' name='submit' value='Cadatrar_user'>Cadastrar-se</button>
    </form>

    <script src='script.js'></script>
</body>
</html>
