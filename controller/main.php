<?php
require_once('../models/users.php');
require_once('../models/trabalho.php');
// adicionei na ultima um jeito de fazer mais verificaçoes usando o init_set eo erro_reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$submit = filter_var($_POST['submit'], FILTER_SANITIZE_SPECIAL_CHARS);
// $userjson = ['nome'=>$user->getnome()]
if($submit == 'Cadatrar_user'){ // Cadastra os colaboradores na tabela users
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    try{// colocar analise se é gerente ou aux
        // devo dizer que colocar '' nas views sao initeis? e tb devo dizer que colocar aspas simples em algo que a gente ta criando ou mandado messagens tb e initil?
        // qual o sentido de dar um echo '' com aspas simples? nao sentido, mais ja que mudaram ok, mais isso nao faz difença, aspas simples e so para os
        // valores que a gente recebe das views pelos formularios, pq dai nao da para criar uma variavel ou acessar uma pela aspas simples mais e so isso mesmo
        if($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente'){
        $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
        $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_SPECIAL_CHARS);
        $sexo = filter_var($_POST['sexo'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $data_nascimento = filter_var($_POST['datanascimento'], FILTER_SANITIZE_NUMBER_INT);
        $data_admissao = filter_var($_POST['dataadmissao'], FILTER_SANITIZE_NUMBER_INT);
        $telefone = filter_var($_POST['telefone'],FILTER_SANITIZE_SPECIAL_CHARS);
        $trabalho = filter_var($_POST['trabalho'], FILTER_SANITIZE_NUMBER_INT);// verficar se tem o ID do trabalho no banco de dados ou deixar o insert dar o erro
        $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
        $user = new User($nome, $email, $trabalho, $cpf, $senha, $data_nascimento, $data_admissao, $telefone, $sexo);
        $userDAO = new UserDAO();   
        // nao era pra enviar uma mess3agens dizendo que foi um sucesso? 
        $userDAO->persit($user);
        $data = array("messagem"=>"foi um sucesso");
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        }else{
            header('Location: ./view/welcome');
        }
}catch(Exception $e){
    echo $e->getMessage();
}
}else if($submit == 'Criar_cargo'){ // Cria um cargo na tabela TRABALHOS
    try{
        if($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente'){
        $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
        $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_SPECIAL_CHARS);
        $trabalho = new Trabalho($nome, $descricao);
        $trabalhoDAO = new TrabalhoDAO();
        $trabalhoDAO->salvar($trabalho);
        $data = array('messagem'=>'sucesso'); 
        //A partir daqui as mensagem vão ser enviadas por JSON
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        }else{
            header('Location: ./view/welcome');
        }
    }catch(Exception $e){
        echo $e->getMessage();
    }
}
# Login
else if ($submit == 'login') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Filtra e valida o email recebido
    $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS); // Filtra a senha recebida

    try {
        $userDAO = new UserDAO(); // Instancia o DAO de usuário
        $user = $userDAO->getByEmail($email); // Obtém o usuário pelo email fornecido
        $data = array();
        if (password_verify($senha, $user->getSenha())) {
                $_SESSION['user'] = serialize($user); // Armazena o usuário na sessão
                $_SESSION['autenticacao'] = true; // Define a autenticação como verdadeira
                header('Location: ../view/perfil.php'); // Redireciona para o perfil do usuário
                exit();
            }else {
            // Caso a senha não corresponda, redireciona para o perfil
             // Armazena o usuário na sessão
            $_SESSION['autenticacao'] =  false; // Define a autenticação como verdadeira
            header('Location: ../view/login.php'); // Redireciona para o perfil do usuário=
            exit();
        }
    } catch (Exception $e) {
        echo $e->getMessage(); // Em caso de exceção, imprime a mensagem de erro
    }
}
else if ($submit == 'Atualizar_usuario') {
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    try {// analisar se é getente ou auxiliar_gerente
        if($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente'){
            $id = filter_var($_POST['id'], FILTER_SANITIZE_SPECIAL_CHARS); 
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS); // Filtra o nome
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Valida o email
            $data_nascimento = filter_var($_POST['data_nascimento'], FILTER_SANITIZE_NUMBER_INT); // NÃO PODE MUDAR O DATA NASCIMENTO
            $data_adimisao = filter_var($_POST['data_adimisao'], FILTER_SANITIZE_NUMBER_INT); // Filtra a data de admissão
            $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_NUMBER_INT); // Filtra o telefone
            $sexo = filter_var($_POST['sexo'], FILTER_SANITIZE_SPECIAL_CHARS); // NÃO PODE MUDAR O SEXO
            $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_NUMBER_INT); // NÃO PODE MUDAR O CPF
            $trabalho = filter_var($_POST['trabalho'], FILTER_SANITIZE_NUMBER_INT);
            $user= new User($nome, $email, $trabalho, $cpf, $senha, $data_nascimento, $data_admissao, $telefone, $sexo);
            $user->setId($id);
            $userDAO = new UserDAO(); // Instancia o DAO de usuário
            $user = $userDAO->persit($user); // Persiste as alterações do usuário no banco de dados
            echo json_encode($data);
        }
        else{
            header('Location: ./view/welcome');
        }    
    } catch (Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage(); // Em caso de exceção, define a mensagem de erro na sessão
    }
    // header('Location: '); // Redireciona de volta para a página atual (provavelmente para a página de perfil)
    // exit();
}
// volta um json com uma messagem 
else if($submit == 'Buscar_cargos'){
    $id_cargo = filter_var($_POST['nome'], FILTER_SANITIZE_NUMBER_INT);
    $trabalhoDAO = new TrabalhoDAO();
    $trabalho = $trabalhoDAO->buscarPorId($id);
    if ($trabalho != null){
        $response = [
            'success' => true,
            'messagem'=>'obtetido com sucesso',
            'cargo' => $trabalho
        ];
    }else{
    $response = [
    'success' => false,
    'messagem'=>'sem sucesso',
    'cargo' => null
    ];   
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
}
else if($submit == 'Listar_cargos'){
    $trabalhoDAO = new TrabalhoDAO();
    $lista_cargos = $trabalhoDAO->listarCargo();
    if ($lista_cargos) {
        $response = [
            'success' => true,
            'message' => 'Dados recebidos com sucesso!',
            'cargos' => $lista_cargos
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Erro ao obter lista de cargos.',
            'cargos' => []
        ];
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
}
else if($submit == 'Cadastrar_grupo'){
    echo 'nao vem';
    // adicione a deserialize o usuario para verificar o grupo
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    var_dump($usuario);
    // teste corretemente agora, o if nao ta comparando os literais com nada
    // depois coloca os headers de volta pelo momento
    if($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente'){
        try {
            $nome = filter_var($_POST['nome'],FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
            $data_nascimento = filter_var($_POST['datanascimento'],FILTER_SANITIZE_NUMBER_INT);
            $data_adimisao = filter_var($_POST['dataadmissao'],FILTER_SANITIZE_NUMBER_INT);
            $telefone = filter_var($_POST['telefone'],FILTER_SANITIZE_NUMBER_INT);
            $sexo = filter_var($_POST['sexo'],FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf = filter_var($_POST['cpf'],FILTER_SANITIZE_SPECIAL_CHARS);
            $senha = filter_var($_POST['senha'],FILTER_SANITIZE_SPECIAL_CHARS);
            $user = new User($nome, $email,'2',$cpf, $senha,$data_nascimento, $data_adimisao,$telefone, $sexo);
            $user->setGrupo('auxiliar');
            $userDAO = new UserDAO();
            $userDAO->insertgrupo($user);
         } catch (Exception $e) {
             $_SESSION['mensagem'] = $e->getMessage();
         }finally{
              header('Location: ');
              exit();
         }
    }
}else if($submit == 'Atualizar o estado'){
    echo 'nao vem';
    // adicione a deserialize o usuario para verificar o grupo
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    var_dump($usuario);
    // teste corretemente agora, o if nao ta comparando os literais com nada
    // depois coloca os headers de volta pelo momento
    if($usuario->getGrupo() == 'gerente'){
        try {
            echo '\n'.'vem aqui';
            // adiconem
            $userDAO = new UserDAO();
            $userDAO->delete($id);
         } catch (Exception $e) {
             $_SESSION['mensagem'] = $e->getMessage();
         }finally{
              header('Location: ');
              exit();
         }
    }
}else if($submit == 'ativar o usuario'){
    echo 'nao vem';
    // adicione a deserialize o usuario para verificar o grupo
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    var_dump($usuario);
    // teste corretemente agora, o if nao ta comparando os literais com nada
    // depois coloca os headers de volta pelo momento
    if($usuario->getGrupo() == 'gerente'){
        try {
            echo '\n'.'vem aqui';
            // adiconem
            $userDAO = new UserDAO();
            $userDAO->aiivacao($id);
         } catch (Exception $e) {
             $_SESSION['mensagem'] = $e->getMessage();
         }finally{
              header('Location: ');
              exit();
         }
    }
}else if($submit == 'users'){
    echo 'nao vem';
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $min = filter_var($_POST['min'], FILTER_SANITIZE_NUMBER_INT); 
    $max = filter_var($_POST['max'], FILTER_SANITIZE_NUMBER_INT); 
    if($usuario->getGrupo() == 'gerente') {
        try {
            echo '\n'.'vem aqui';
            $userDAO = new UserDAO();
            $users= $userDAO->getbyall($min,$max);
            $dados = [];
            foreach($users as $user){
                $user=[
                    'Nome'=>$user->getNOME(),
                    'Cpf'=>$user->getCPF(),
                    'Email'=>$user->getEmail(),
                    'senha'=>$user->getSenha(),
                    'data_nas'=>$user->getDataNascimento(),
                    'data_at'=>$user->getDataAdimisao(),
                    'telefone'=>$user->getTelefone(),
                    'grupo'=>$user->getGrupo(),
                    'sexo'=>$user->getSexo(),
                    'trabalho'=>$user->getTrabalho(),
                    'id'=>$user->getID(),
                    'delete'=>$user->getDelete()
                ];
                $dados[]=$user;
            }
            echo json_encode($dados);
         } catch (Exception $e) {
             $_SESSION['mensagem'] = $e->getMessage();
         }finally{
              header('Location: ');
              exit();
         }
    }
}
