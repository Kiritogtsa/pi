<?php
session_start();
require_once('../models/users.php');
try{
    if(isset($_SESSION['autenticacao'])){
        if(!$_SESSION['autenticacao']){
            // usuário não autenticado
            throw new Exception('Usuário não autenticado!');
        }
    }else{
        throw new Exception('Falha de autenticação!');
    }
}catch (Exception $e){
    $_SESSION['mensagem'] = $e->getMessage();
    header('Location: ../view/login.php');
}finally{
    $user = unserialize($_SESSION['user']);
}