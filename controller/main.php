<?php
require_once('../models/users.php');
$botao = filter_var($_POST["submit"], FILTER_SANITIZE_SPECIAL_CHARS);

if($botao == "Cadatrar_user"){ // Cadastra os colaboradores na tabela users
    try{
        $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
        $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sexo = filter_var($POST['sexo'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $data_nascimento = filter_var($_POST['datanascimento'], FILTER_SANITIZE_NUMBER_INT);
        $data_admissao = filter_var($POST['dataadmissao'], FILTER_SANITIZE_NUMBER_INT);
        $trabalho = filter_var($_POST['trabalho'], FILTER_SANITIZE_NUMBER_INT);
        $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
        $user = new User($nome, $email, $trabalho, $cpf, $senha, $data_nasicmento, $data_admissao, $telefone, $sexo);
        $userDAO = new UserDAO();
        $userDAO->persit($user);
        $data = array(); // A partir daqui as mensagem vão ser enviadas por JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
}catch(Exception $e){
    echo $e->getMessage();
}

}else if($botao == "Criar_cargo"){ // Cria um cargo na tabela TRABALHOS
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_SPECIAL_CHARS);
    $trabalho = new Trabalho($nome, $descricao);
    $trabalhoDAO = new TrabalhoDAO();
    $trabalhoDAO->salvar($trabalho);
    $data = array(); // A partir daqui as mensagem vão ser enviadas por JSON
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}





