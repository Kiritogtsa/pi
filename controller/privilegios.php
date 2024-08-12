<?php
require_once('../models/users.php');
require_once('../controller/autenticado.php');
if (isset($_SESSION['user'])){
    $user = unserialize($_SESSION['user']);
    if ($user->getGrupo() != 'axuliar_gerente' || $user->getGrupo() != 'gerente'){
        header('');
    }
}else{
    header('');
}