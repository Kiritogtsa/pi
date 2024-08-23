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

if ($submit == 'Cadatrar_user') { 
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $userDAO = new UserDAO();
    if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
        try {
            // foi adicionados as variaveis para obter um salario minimo
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
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
                'message' => 'deu algum erro',
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

    if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
        echo "entra aqui";
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
                'cargos' => $dados
            ];
            $_SESSION['listauser'] = $response;
            header('Location: ../view/listarusers.php');
            exit();
        } catch (Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            $response = [
                'success' => true,
                'message' => 'deu algum erro',
                'erro' => $e->getMessage()
            ];

            $_SESSION['listauser'] = $response;
            header('Location: ./view/listarusers.php');
            exit();
        }
    }


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
            'message' => 'Usuário logado não pode se desativar',
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
            $_SESSION['reponse'] = $response;
            header('Location: ../view/listarusers.php');
            exit();
        } catch (Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header('Location: ../view/listarusers.php');
            exit();
        }
    }
} else if ($submit == 'Atualizar_usuario') {
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $userDAO = new UserDAO(); 
    try { 
        if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
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
            if(!empty($user)){
                $user = serialize($user);
                $response = [
                    "success" => true,
                    "messagem" => "Usuário atualizado com sucesso!",
                    'user_atuali' => $user
                ];
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
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    echo $id;
    if ($usuario->getGrupo() == 'gerente' && $usuario->getId() != $id && $id != null) {
        try {
            // adiconem
            $userDAO = new UserDAO();
            $userDAO->aiivacao($id);
            $response = [
                'success' => true,
                'message' => 'Usuário ativado com sucesso!',
            ];
            header('Location: ../view/listarusers.php');
            exit();
            $_SESSION['reponse'] = $response;
        } catch (Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            header('Location: ../view/listarusers.php');
        }
    }
}

else if ($submit == 'Buscar_funcionario') {
    try {
        $usuario = unserialize($_SESSION['user']);
        if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
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
        echo $e->getMessage(); 
    }
} else if ($submit == 'Buscar_cargos') {
    try {
        $usuario = unserialize($_SESSION['user']);
        if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
            $trabalhoDAO = new TrabalhoDAO();
            $trabalho = $trabalhoDAO->buscarPorNome($nome);
            $ntrab = serialize($trabalho);
            if (!empty($trabalho)) {
                $response = [
                    'success' => true,
                    'messagem' => 'Cargo encontrado com sucesso!',
                    'cargos' => $ntrab
                ];
                $_SESSION['buscar'] = $response;
                header('Location: ../view/buscacargo.php');
            } else {
                $response = [
                    'success' => false,
                    'messagem' => 'Cargo não encontrado!',	
                    'erro' => null
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
            $trabatu = $trabalhoDAO->atualizar($trabalho);
            $trabatu = serialize($trabatu);
            $response = [
                'success' => true,
                'message' => 'Atualizado com sucesso!',
                'trabalho' => $trabatu,
            ];
            $_SESSION['buscar'] = $response;
            header('Location: ../view/buscacargo.php');
        }else{
            $_SESSION['buscar'] = 'Sem permissão para atualizar!';
            header('Location: ../view/buscacargo.php');
        }
    } catch (Exception $e) {
        $response = [
            'success' => false,
            'message' => 'erro ao atualizar',
            'trabalho' => $e->getMessage()
        ];
        $_SESSION['buscar'] = $response;
        header('Location: ../view/buscacargo.php');
        $e->getMessage();
    }
} else if ($submit == "Criar_cargo") {
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_var($_POST['descricao']);
    $trabalho = new Trabalho($nome, $descricao);
    $TrabalhoDAO = new TrabalhoDAO();
    $trabatualizado = $TrabalhoDAO->salvar($trabalho);
    if (!empty($trabatualizado)) {
        $_SESSION['data'] = "Cargo criado com sucesso";
        header('Location: ../view/Criatrab.php');
    } else {
        $_SESSION['data'] = "Erro ao criar trabalho";
        header('Location: ../view/Criatrab.php');
    }
}

else if ($submit == "Deletar_trabalho") {
    try {
        // if($usuario->getGrupo() == "auxiliar" || $usuario->getGrupo() == "gerente"){
        $id = filter_var($_POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);
        $trabalhoDAO = new TrabalhoDAO();
        $trabdel = $trabalhoDAO->deletar($id);
        if (!empty($trabdel)) {
            $_SESSION['message'] = $trabdel;
            header('Location: ../view/buscacargo.php');
        } else {
            $_SESSION['message'] = "Erro ao deletar trabalho!";
            header('Location: ../view/buscacargo.php');
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
