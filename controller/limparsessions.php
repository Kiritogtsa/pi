<?php
require_once('../controller/autenticado.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia a sessão apenas se ainda não estiver iniciada
}

if(!empty($_SESSION['mensagemcadasuser'])){
    unset($_SESSION['mensagemcadasuser']);

} else if(!empty($_SESSION['listauser'])){
    unset($_SESSION['listauser']);  

} else if(!empty($_SESSION['desativado'])){
    unset($_SESSION['desativado']);

} else if(!empty($_SESSION['desastiv_list'])){
    unset($_SESSION['desastiv_list']);

} else if(!empty($_SESSION['user_atualiz'])){
    unset($_SESSION['user_atualiz']);

} else if(!empty($_SESSION['ativado'])){
    unset($_SESSION['ativado']);

} else if(!empty($_SESSION['ativar_list'])){
    echo ($_SESSION['ativar_list']);
    unset($_SESSION['ativar_list']);

} else if(!empty($_SESSION['buscuser'])){
    unset($_SESSION['buscuser']);

} else if(!empty($_SESSION['buscar'])){
    unset($_SESSION['buscar']);

} else if(!empty($_SESSION['listar'])){
    unset($_SESSION['listar']);
    
} else if(!empty($_SESSION['data'])){
    unset($_SESSION['data']);
}else if (!empty($_SESSION['naopermitido'])){
    unset($_SESSION['naopermitido']);
}

?>