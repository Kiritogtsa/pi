<?php
require_once('../models/salario.php');
require_once('../models/users.php');
require_once('../models/trabalho.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $submit = filter_var($_POST['submit'], FILTER_SANITIZE_SPECIAL_CHARS);
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $submit = filter_var($_GET['submit'], FILTER_SANITIZE_SPECIAL_CHARS);
}

function listar($usuario, $min, $max){
    if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
        try {
            $userDAO = new UserDAO();
            $users = $userDAO->getbyall($min, $max);
            $dados = array();
            foreach ($users as $user) {
                $dados[] = $user;
            }
            $response = [
                'success' => true,
                'message' => 'Dados recebidos com sucesso!',
                'cargos' => $dados,
                'min'=> $min,
                'max'=>$max
            ];
            require_once("../controller/limparsessions.php");
            $_SESSION['listauser'] = $response;
            header('Location: ../view/listarusers.php');
            return;
        } catch (Exception $e) {
            require_once("../controller/limparsessions.php");
            $response = [
                'success' => true,
                'message' => 'deu algum erro!',
                'erro' => $e->getMessage()
            ];
            $_SESSION['listauser'] = $response;
            header('Location: ./view/listarusers.php');
            exit();
            return;
        }
    }
}
if ($submit == 'Cadatrar_user') { 
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $userDAO = new UserDAO();
    if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
        try {
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
            $buscado = $userDAO->getbyName($nome);
            if(!empty($buscado)){
                require_once("../controller/limparsessions.php");
                $response = 'Usuário já cadastrado na base de dados!';
                $_SESSION['mensagemcadasuser'] = $response;
                header('Location: ../view/cadatraruser.php'); 
                exit();   
            }
            $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_SPECIAL_CHARS);
            $sexo = filter_var($_POST['sexo'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $data_nascimento = filter_var($_POST['datanascimento'], FILTER_SANITIZE_NUMBER_INT);
            $data_admissao = filter_var($_POST['dataadmissao'], FILTER_SANITIZE_NUMBER_INT);
            $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_SPECIAL_CHARS);
            $trabalho = filter_var($_POST['trabalho'], FILTER_SANITIZE_SPECIAL_CHARS);
            $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
            $adicional = filter_var($_POST['adicional'], FILTER_SANITIZE_NUMBER_FLOAT);
            $grupo = filter_var($_POST['grupo'], FILTER_SANITIZE_SPECIAL_CHARS);
            $salario_bruto = filter_var($_POST['bruto'], FILTER_SANITIZE_NUMBER_FLOAT);
            $salario = new Salario($salario_bruto, $adicional);
            $user = new User($nome, $email, $trabalho, $cpf, $senha, $data_nascimento, $data_admissao, $telefone, $sexo, $salario, $adicional, $grupo);
            $user = $userDAO->persit($user);
            if(!empty($user)){
                $response = 'Usuário cadastrado com sucesso!';
                $_SESSION['mensagemcadasuser'] = $response;
                header('Location: ../view/cadatraruser.php'); 
                exit();   
            }
        } catch (Exception $e) {
            $userDAO->conn->rollBack();
            $response = [
                'success' => true,
                'message' => 'deu algum erro!',
                'erro' => $e->getMessage()
            ];
            $_SESSION['mensagemcadasuser'] = $e->getMessage();
            header('Location: ../view/cadatraruser.php');
            exit();
        }
    }
}

else if ($submit == 'Listar_funcionario') {
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $min = filter_var($_POST['min'], FILTER_SANITIZE_NUMBER_INT);
    $max = filter_var($_POST['max'], FILTER_SANITIZE_NUMBER_INT);
    listar($usuario, $min, $max);



} else if($submit == 'Avancar'){
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $min = filter_var($_POST['min'], FILTER_SANITIZE_NUMBER_INT);
    $max = filter_var($_POST['max'], FILTER_SANITIZE_NUMBER_INT);
    $min = $max+1;
    $max += 5;      
    listar($usuario, $min, $max);
}

else if($submit == 'Voltar'){
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $min = filter_var($_POST['min'], FILTER_SANITIZE_NUMBER_INT);
    $max = filter_var($_POST['max'], FILTER_SANITIZE_NUMBER_INT);
    $max = $min-1;
    $min = max(0, $max - 5);
    listar($usuario, $min, $max);



} else if ($submit == 'Desativar_usuario') {
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    if ($usuario->getGrupo() == 'gerente' && $usuario->getId() != $id && $id != null && $id != 1) {
        try {
            $userDAO = new UserDAO();
            $userDAO->delete($id);
            $user = $userDAO->getbyName($nome);
            if(!empty($user)){
                $user = serialize($user);
                $response = [
                    'success' => true,
                    'message' => 'Usuário desativado com sucesso!',
                    'user'=> $user
                ];
                require_once("../controller/limparsessions.php");
                $_SESSION['desativado'] = $response;
                header('Location: ../view/buscarfuncionario.php');
                exit();
        }
        } catch (Exception $e) {
            $_SESSION['desativado'] = $e->getMessage();
            header('Location: ../view/buscarfuncionario.php');
            exit();
        }
    }else{
        $response = [
            'success' => true,
            'message' => 'Usuário logado não pode se desativar!',
            'user'=> $user
        ];
        $_SESSION['desativado'] = $response;
        header('Location: ../view/buscarfuncionario.php');
        exit();
    }
}
else if ($submit == 'Desativar_usuariolist') {
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    if ($usuario->getGrupo() == 'gerente' && $usuario->getId() != $id && $id != null && $id != 1) {
        try {
            $userDAO = new UserDAO();
            echo $userDAO->delete($id);
            $response = [
                'success' => true,
                'message' => 'Usuário desativado com sucesso!',
            ];
            require_once("../controller/limparsessions.php");
            $_SESSION['desastiv_list'] = $response;
            header('Location: ../view/listarusers.php');
            exit();
        } catch (Exception $e) {
            require_once("../controller/limparsessions.php");
            $_SESSION['desastiv_list'] = $e->getMessage();
            header('Location: ../view/listarusers.php');
            exit();
        }
    }

} else if ($submit == 'Atualizar_usuario') {
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $userDAO = new UserDAO(); 
    try { 
        if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
            $deletado = filter_var($_POST['deletado'], FILTER_SANITIZE_SPECIAL_CHARS);
            if($deletado != null){
                $response = [
                    "success" => true,
                    "messagem" => "Não pode atualizar um usuário desativado!" 
                ];
                require_once("../controller/limparsessions.php");
                $_SESSION['user_atualiz'] = $response;
                header('Location: ../view/buscarfuncionario.php');
                exit();
            }
            $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_SPECIAL_CHARS);
            $sexo = filter_var($_POST['sexo'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            $data_nascimento = filter_var($_POST['datanascimento'], FILTER_SANITIZE_NUMBER_INT);
            $data_admissao = filter_var($_POST['dataadmissao'], FILTER_SANITIZE_NUMBER_INT);
            $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_SPECIAL_CHARS);
            $trabalho = filter_var($_POST['trabalho'], FILTER_SANITIZE_SPECIAL_CHARS);
            $adicional = filter_var($_POST['adicional'], FILTER_SANITIZE_NUMBER_FLOAT);
            $grupo = filter_var($_POST['grupo'], FILTER_SANITIZE_SPECIAL_CHARS);
            $salario_bruto = filter_var($_POST['bruto'], FILTER_SANITIZE_NUMBER_FLOAT);
            $adicional = filter_var($_POST['adicional'], FILTER_SANITIZE_NUMBER_FLOAT);
            $salario = new Salario($salario_bruto, $adicional);
            $salario->setId($id);
            $salario->descIR($salario->getSalariobruto());
            $salario->descINSS($salario->getSalariobruto());
            $user = new User($nome, $email, $trabalho, $cpf, "", $data_nascimento, $data_admissao, $telefone, $sexo, $salario);
            $user->setId($id);
            $user->setGrupo($grupo);
            $user =  $userDAO->persit($user);
            echo $user->getTrabalho();
            if(!empty($user)){
                $user = serialize($user);
                $response = [
                    "success" => true,
                    "messagem" => "Usuário atualizado com sucesso!",
                    'user_atuali' => $user
                ];
                require_once("../controller/limparsessions.php");
                $_SESSION['user_atualiz'] = $response;
                header('Location: ../view/buscarfuncionario.php');
                exit();
            }
        } else {
            $response = ["success" => false, "messagem" => "nao e auteticado"];
            header('Location: ./view/welcome');
        }
    } catch (Exception $e) {
        $userDAO->conn->rollBack();
        $_SESSION['mensagem'] = $e->getMessage();
    }


} else if ($submit == 'Ativar_usuario') {
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    if ($usuario->getGrupo() == 'gerente' && $usuario->getId() != $id && $id != null) {
        try {
            $userDAO = new UserDAO();
            $userDAO->aiivacao($id);
            $user = $userDAO->getbyName($nome);
            if(!empty($user)){
            $user = serialize($user);
            $response = [
                'success' => true,
                'message' => 'Usuário ativado com sucesso!',
                'usera'=> $user
            ];
            require_once("../controller/limparsessions.php");
            $_SESSION['ativado'] = $response;
            header('Location: ../view/buscarfuncionario.php');
            exit();
        }
        } catch (Exception $e) {
            $_SESSION['ativado'] = $e->getMessage();
            header('Location: ../view/buscarfuncionario.php');
            exit();
        }
    }
}

else if ($submit == 'Ativar_usuariolist') {
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    if ($usuario->getGrupo() == 'gerente' && $usuario->getId() != $id && $id != null) {
        try {
            $userDAO = new UserDAO();
            $userDAO->aiivacao($id);
            $response = [
                'success' => true,
                'message' => 'Usuário ativado com sucesso!',
            ];
            require_once("../controller/limparsessions.php");
            $_SESSION['ativar_list'] = $response;
            header('Location: ../view/listarusers.php');
            exit();
        } catch (Exception $e) {
            require_once("../controller/limparsessions.php");
            $_SESSION['ativar_list'] = $e->getMessage();
            header('Location: ../view/listarusers.php');
            exit();
        }
    }
}

else if ($submit == 'Buscar_funcionario') {
    try {
        $usuario = unserialize($_SESSION['user']);
        if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
            require_once("../controller/limparsessions.php");
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
            $user = new UserDAO();
            $buscuser = $user->getbyName($nome);
            
            if (!empty($buscuser)) {
                $buscuser = serialize($buscuser);
                $userbuscado = [
                    'mensagem' => 'Usuário encontrado com sucesso!',
                    'userb' => $buscuser
                ];
            } else {
                $userbuscado = [
                    'mensagem' => 'Usuário não encontrado!',
                ];
            }
            $_SESSION['buscuser'] = $userbuscado;
            header('Location: ../view/buscarfuncionario.php');
            exit; 

        } else {
            throw new Exception("Sem permissão para modificar!");
        }
    } catch (Exception $e) {
        $_SESSION['buscuser'] = [
            'mensagem' => $e->getMessage()
        ];
        require_once("../controller/limparsessions.php");
        header('Location: ../view/buscarfuncionario.php');
        exit;
    }
}

else if ($submit == 'login') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); 
    $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS); 
    try {
        $userDAO = new UserDAO(); 
        $user = $userDAO->getByEmail($email); 
        if (password_verify($senha, $user->getSenha())) {
            if ($user->getGrupo() == 'gerente' || $user->getGrupo() == 'auxiliar' && $user->getDeletedAt() ==null) {
                $_SESSION['user'] = serialize($user); 
                $_SESSION['autenticacao'] = true; 
                header('Location: ../view/welcomeadmins.php'); 
                exit();
            } else if($user->getDeletedAt()==null) {
                $_SESSION['user'] = serialize($user); 
                $_SESSION['autenticacao'] = true; 
                header('Location: ../view/welcome.php'); 
                exit();
            }else{
                $_SESSION['autenticacao'] =  false;
                header('Location: ../view/login.php');
            }
        } else {
            $_SESSION['autenticacao'] =  false;
            $_SESSION['loginfalha'] = 'Usuário ou senha incorretos!';
            header('Location: ../view/login.php'); 
            exit();
        }
    } catch (Exception $e) {
        $e->getMessage();
        $_SESSION['loginfalha'] = "Usuário não cadastrado no sistema!";
        header('Location: ../view/login.php'); 
        exit();

    }
} else if ($submit == 'Buscar_cargos') {
    try {
        $usuario = unserialize($_SESSION['user']);
        if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
            require_once("../controller/limparsessions.php");
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
            $trabalhoDAO = new TrabalhoDAO();
            $trabalho = $trabalhoDAO->buscarPorNome($nome);
            if (!empty($trabalho)) {
                $ntrab = serialize($trabalho);
                $response = [
                    'success' => true,
                    'message' => 'Cargo encontrado com sucesso!',
                    'cargos' => $ntrab
                ];
                $_SESSION['buscar'] = $response;
                header('Location: ../view/buscacargo.php');
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Cargo não encontrado!',
                ];
                $_SESSION['buscar'] = $response;
                header('Location: ../view/buscacargo.php');
            }
        }
    }catch (Exception $e) {
        $_SESSION['buscar'] = [
            'mensagem' => $e->getMessage()
        ];
        header('Location: ../view/buscacargo.php');
        exit;
    }


}

else if ($submit == 'Listar_cargos') {
    $trabalhoDAO = new TrabalhoDAO();
    $lista_cargos = $trabalhoDAO->listarCargo();
    $lista_cargos = serialize($lista_cargos);
    var_dump($lista_cargos);
    if (!empty($lista_cargos)) {
        $cargos = [
            'successo' => true,
            'menssagem' => 'Buscar realizada com sucesso!',
            'cargos' => $lista_cargos
        ];
        $_SESSION['listar'] = $cargos;
        header('Location: ../view/listatrabalhos.php');
    } else {
        $cargos = [
            'successo' => false,
            'menssagem' => 'Erro ao listar os cargos',
            'cargos' => []
        ];
        $_SESSION['listar'] = $cargos;
        header('Location: ../view/listatrabalhos.php');
    }
}

// ATUALIZA O TRABALHO

else if ($submit == "Atualizar_trabalho") {
    try {
        $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
        if ($usuario->getGrupo() == "auxiliar" || $usuario->getGrupo() == "gerente") {
            $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            $nome  = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_SPECIAL_CHARS);
            $trabalho = new Trabalho($nome, $descricao);
            $trabalho->setIdCargo($id);
            $trabalhoDAO = new TrabalhoDAO();
            $trabalhoDAO->atualizar($trabalho);
            $nome = $trabalhoDAO->buscarPorId($id);
            $trabatu = $trabalhoDAO->buscarPorNome($nome);
            if(!empty($trabatu)){
            $response = [
                'success' => true,
                'message' => 'Atualizado com sucesso!',
                'cargos' => serialize($trabatu)
            ];
            require_once("../controller/limparsessions.php");
            $_SESSION['buscar'] = $response;
            header('Location: ../view/buscacargo.php');
        }
        }else{
            $_SESSION['buscar'] = 'Sem permissão para atualizar!';
            header('Location: ../view/buscacargo.php');
            exit();
        }
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'message' => 'erro ao atualizar',
            'cargos' => $e->getMessage()
        ];
        $_SESSION['buscar'] = $response;
        header('Location: ../view/buscacargo.php');
        $e->getMessage();
        exit();
    }
} else if ($submit == "Criar_cargo") {
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_SPECIAL_CHARS);

    $TrabalhoDAO = new TrabalhoDAO();
    $busctrab = $TrabalhoDAO->buscarPorNome($nome);

    if ($busctrab != null) { 
        $_SESSION['data'] = "Cargo já existente na base de dados!";
        header('Location: ../view/Criatrab.php');
        exit();
    } else {
        $trabalho = new Trabalho($nome, $descricao);
        $trabatualizado = $TrabalhoDAO->salvar($trabalho);
        if (!empty($trabatualizado)) {
            $_SESSION['data'] = "Cargo criado com sucesso!";
        } else {
            $_SESSION['data'] = "Erro ao criar trabalho!";
        }

        header('Location: ../view/Criatrab.php');
        exit();
    }
}
else if ($submit == "Deletar_trabalho") {
    try {
        $id = filter_var($_POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $trabalhoDAO = new TrabalhoDAO();
        $trabdel = $trabalhoDAO->deletar($id);
        $listtrab = $trabalhoDAO->listarCargo();

        require_once("../controller/limparsessions.php");

        if ($trabdel) {
            $_SESSION['buscar'] = [
                'message' => 'Cargo deletado com sucesso!',
            ];
        } else {
            $_SESSION['buscar'] = [
                'message' => 'Erro ao deletar trabalho!',
            ];
        }

        header('Location: ../view/buscacargo.php');
        exit();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
