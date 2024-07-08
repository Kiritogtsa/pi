<?php
require_once('../models/users.php');
require_once('../models/trabalho.php');
// adicinei na ultima um jeito de fazer mais verificaçoes usando o init_set eo erro_reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$submit = filter_var($_POST["submit"], FILTER_SANITIZE_SPECIAL_CHARS);

if($submit == "Cadatrar_user"){ // Cadastra os colaboradores na tabela users
    try{
        $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
        $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sexo = filter_var($POST['sexo'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $data_nascimento = filter_var($_POST['datanascimento'], FILTER_SANITIZE_NUMBER_INT);
        $data_admissao = filter_var($POST['dataadmissao'], FILTER_SANITIZE_NUMBER_INT);
        $trabalho = filter_var($_POST['trabalho'], FILTER_SANITIZE_NUMBER_INT);// verficar se tem o ID do trabalho no banco de dados ou deixar o insert dar o erro
        $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
        $user = new User($nome, $email, $trabalho, $cpf, $senha, $data_nasicmento, $data_admissao, $telefone, $sexo);
        $userDAO = new UserDAO();    
        $userDAO->persit($user);
        $data = array(); // A partir daqui as mensagem vão ser enviadas por JSON
        // header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
}catch(Exception $e){
    echo $e->getMessage();
}

}else if($submit == "Criar_cargo"){ // Cria um cargo na tabela TRABALHOS
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_SPECIAL_CHARS);
    $trabalho = new Trabalho($nome, $descricao);
    $trabalhoDAO = new TrabalhoDAO();
    $trabalhoDAO->salvar($trabalho);
    $data = array(); // A partir daqui as mensagem vão ser enviadas por JSON
    // header('Content-Type: application/json; charset=utf-8');
    // echo json_encode($data);
}

# Login
else if ($submit == "login") {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Filtra e valida o email recebido
    $senha = filter_var($_POST['senha'], FILTER_SANITIZE_STRING); // Filtra a senha recebida

    try {
<<<<<<< HEAD
       $user= isset($_SESSION["user"])?unserialize("user") : null;
       $nome = filter_var($_POST['nome'],FILTER_SANITIZE_SPECIAL_CHARS);
       $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
       $data_nascimento = filter_var($_POST['data_nascimento'],FILTER_SANITIZE_NUMBER_INT);
       $data_adimisao = filter_var($_POST['data_adimisao'],FILTER_SANITIZE_NUMBER_INT);
       $telefone = filter_var($_POST['telefone'],FILTER_SANITIZE_NUMBER_INT);
       $sexo = filter_var($_POST['sexo'],FILTER_SANITIZE_SPECIAL_CHARS);
       $cpf = filter_var($_POST['cpf'],FILTER_SANITIZE_NUMBER_INT);
       $user->SetNome($nome);
       $user->SetEmail($email);
       $user->SetDataNascimento($data_nascimento);
       $user->SetDataAdmisao($data_adimisao);
       $user->SetTelefone($telefone);
       $user->SetSexo($sexo);
       $user->SetCpf($cpf);
       $user->setID($id);
       $userDAO = new UserDAO();
       $user = $userDAO->persit($user);
       echo json_encode($data);
=======
        $userDAO = new UserDAO(); // Instancia o DAO de usuário
        $user = $userDAO->getByEmail($email); // Obtém o usuário pelo email fornecido
        $data = array();

        // Verifica se a senha fornecida corresponde à senha hash armazenada

        // if (password_verify($senha, $user->getSenha())) {
        //     // Verifica o tipo de trabalho do usuário
        //     // tem verificaçoes desnecessárias
        //     // coisa demais aqui, o if e inutil aqui
        //     if ($user->getTrabalho() == "chefe" || $user->getTrabalho() == "auxiliar") {
        //         $_SESSION["user"] = serialize($user); // Armazena o usuário na sessão
        //         echo json_encode($data);
        //         $_SESSION['autenticacao'] = true; // Define a autenticação como verdadeira
        //         header('Location: ../view/welcome.php'); // Redireciona para a página de boas-vindas
        //         exit();
        //     } else {
        //         $_SESSION["user"] = serialize($user); // Armazena o usuário na sessão
        //         echo json_encode($data);
        //         $_SESSION['autenticacao'] = true; // Define a autenticação como verdadeira
        //         header('Location: ../view/perfil.php'); // Redireciona para o perfil do usuário
        //         exit();
        //     }
        // } else {
        //     // Caso a senha não corresponda, redireciona para o perfil
        //     $_SESSION["user"] = serialize($user); // Armazena o usuário na sessão
        //     echo json_encode($data);
        //     $_SESSION['autenticacao'] = true; // Define a autenticação como verdadeira
        //     header('Location: ../view/perfil.php'); // Redireciona para o perfil do usuário
        //     exit();
        // }
>>>>>>> 823998f74c56d5a1bf74a6c0a19a6465627a03ac
    } catch (Exception $e) {
        echo $e->getMessage(); // Em caso de exceção, imprime a mensagem de erro
    }
}

# Atualizar pelo usuario
else if ($submit == "Atualizar") {
    try {
        $user = isset($_SESSION["user"]) ? unserialize($_SESSION["user"]) : null; // Recupera o usuário da sessão
        $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS); // Filtra o nome
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Valida o email
        $data_nascimento = filter_var($_POST['data_nascimento'], FILTER_SANITIZE_NUMBER_INT); // Filtra a data de nascimento
        $data_adimisao = filter_var($_POST['data_adimisao'], FILTER_SANITIZE_NUMBER_INT); // Filtra a data de admissão
        $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_NUMBER_INT); // Filtra o telefone
        $sexo = filter_var($_POST['sexo'], FILTER_SANITIZE_SPECIAL_CHARS); // Filtra o sexo
        $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_NUMBER_INT); // Filtra o CPF

        // Define os novos valores para o usuário
        $user->setNome($nome);
        $user->setEmail($email);
        $user->setDataNascimento($data_nascimento);
        $user->setDataAdmissao($data_adimisao);
        $user->setTelefone($telefone);
        $user->setSexo($sexo);
        $user->setCpf($cpf);

        $userDAO = new UserDAO(); // Instancia o DAO de usuário
        $user = $userDAO->persit($user); // Persiste as alterações do usuário no banco de dados
        echo json_encode($data);
    } catch (Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage(); // Em caso de exceção, define a mensagem de erro na sessão
    }
    // header('Location: '); // Redireciona de volta para a página atual (provavelmente para a página de perfil)
    // exit();
}


else if($submit == "Buscar_cargos"){
    $id_cargo = filter_var($_POST['nome'], FILTER_SANITIZE_NUMBER_INT);
    $trabalhoDAO = new TrabalhoDAO();
    $trabalho = $trabalhoDAO->buscarPorId($id);
    $_SESSION['trabalho'] = $trabalho;
    // header('Location: ./view');
}

else if($submit == "Listar_cargos"){
    echo "vem aqui";
    $trabalhoDAO = new TrabalhoDAO();
    $lista_cargos = $trabalhoDAO->listarCargo();
    $_SESSION['cargos'] = $lista_cargos; 
    var_dump($lista_cargos);
}



else if($submit == "Cadastrar_grupo"){
    // adicione a deserialize o usuario para verificar o grupo
    $usuario = isset($_SESSION["user"]) ? unserialize("user") : null;
    // teste corretemente agora, o if nao ta comparando os literais com nada
    // depois coloca os headers de volta pelo momento
    if("axuliar_gerente" || "gerente"){
        try {
            $user= isset($_SESSION["user"])?unserialize("user") : null;
            $nome = filter_var($_POST['nome'],FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
            $data_nascimento = filter_var($_POST['data_nascimento'],FILTER_SANITIZE_NUMBER_INT);
            $data_adimisao = filter_var($_POST['data_adimisao'],FILTER_SANITIZE_NUMBER_INT);
            $telefone = filter_var($_POST['telefone'],FILTER_SANITIZE_NUMBER_INT);
            $sexo = filter_var($_POST['sexo'],FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf = filter_var($_POST['cpf'],FILTER_SANITIZE_NUMBER_INT);
            $user->SetNome($nome);
            $user->SetEmail($email);
            $user->SetDataNascimento($data_nascimento);
            $user->SetDataAdmisao($data_adimisao);
            $user->SetTelefone($telefone);
            $user->SetSexo($sexo);
            $user->SetCpf($cpf);
            $user->setID($id);
            $user->setGrupo("axuliar_gerente");
            $userDAO = new UserDAO();
            $_SESSION['user'] = $user = $userDAO->insertgrupo($user);
         } catch (Exception $e) {
             $_SESSION['mensagem'] = $e->getMessage();
         }
        //  header('Location: ');
        //  exit();
    }
}