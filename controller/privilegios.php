<?php
require_once('../models/users.php');
require_once('../controller/autenticado.php');

if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
    if ($user->getGrupo() != 'auxiliar' && $user->getGrupo() != 'gerente') {
        $_SESSION['naopermitido'] = 'Você não possui permissões para acessar';
        header('Location: ../view/welcome.php');
        exit();
    }
} else {
    header(''); // Substitua pelo caminho da página de login
    exit();
}
