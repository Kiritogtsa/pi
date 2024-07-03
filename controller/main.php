<?php

$botao = filter_var($_POST["submit"], FILTER_SANITIZE_SPECIAL_CHARS);

if($botao == "Cadatraruser"){
    try{
        $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
        $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_STRING);
        $sexo = filter_var($POST['sexo'], FILTER_SANITIZE_STRING);
        $idade = filter_var($_POST['idade'], FILTER_SANITIZE_NUMBER_INT);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $nascimento = filter_var($_POST['datanascimento'], FILTER_SANITIZE_NUMBER_INT);
        $dataadmissao = filter_var($POST['dataadmissao'], FILTER_SANITIZE_NUMBER_INT);
        $trabalho = filter_var($_POST['trabalho'], FILTER_SANITIZE_SPECIAL_CHARS);
        $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
        $user = new user($nome, $email, $trabalho, $cpf, $senha, $nascimento )
}catch(Exception $e){
    echo $e->getMessage();
}
}





