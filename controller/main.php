<?php
require_once('../models/users.php');
require_once('../models/trabalho.php');
// adicionei na ultima um jeito de fazer mais verificaçoes usando o init_set eo erro_reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
// use o metodo de persit ao criar o usuario com grupo por arrumei e planejo remover o outro metodo se possivel, acabei de terminal mais so menos 
// o usuario com o salario, alias eu pensei que e melhor o usaurio ter uma refencia ao seu salario do que o salario ter uma refencia ao usuario
// pode arrumar o sql depois?
// isto ta me dando um odio

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $submit = filter_var($_POST['submit'], FILTER_SANITIZE_SPECIAL_CHARS);
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $submit = filter_var($_GET['submit'], FILTER_SANITIZE_SPECIAL_CHARS);
}
// adicione os metodos do salario dao, para ficar melhor e mais modular depois, e tb mais facil de adicionar novas coisas, so precisa criar o dao
// que eu faço o resto no usuario dao para chamar o salario, dai o usuario controla o solario, sem mudar muitas coisas, isso e uma idei
// $userjson = ['nome'=>$user->getnome()]
if ($submit == 'Cadatrar_user') { // Cadastra os colaboradores na tabela users
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    try {
        // foi adicionados as variaveis para obter um salario minimo
        if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_SPECIAL_CHARS);
            $sexo = filter_var($_POST['sexo'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $data_nascimento = filter_var($_POST['datanascimento'], FILTER_SANITIZE_NUMBER_INT);
            $data_admissao = filter_var($_POST['dataadmissao'], FILTER_SANITIZE_NUMBER_INT);
            $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_SPECIAL_CHARS);
            $trabalho = filter_var($_POST['trabalho'], FILTER_SANITIZE_NUMBER_INT); // verficar se tem o ID do trabalho no banco de dados ou deixar o insert dar o erro
            $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
            $salario_bruto = $_POST['bruto'];
            $mes = date('m');
            $salario = new Salario($salario_bruto, $mes);
            $mes = date('m');
            $user = new User($nome, $email, $trabalho, $cpf, $senha, $data_nascimento, $data_admissao, $telefone, $sexo, $salario);
            $userDAO = new UserDAO();
            // nao era pra enviar uma mess3agens dizendo que foi um sucesso? 
            $userDAO->persit($user);
            $data = array("messagem" => "foi um sucesso");
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        } else {
            $userDAO->conn->rollBack();
            $response = [
                'success' => true,
                'message' => 'deu algum erro',
                'erro' => $e->getMessage()
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            $_SESSION['mensagem'] = $e->getMessage();
            exit();
            header('Location: ./view/welcome');
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else if ($submit == 'Criar_cargo') { // Cria um cargo na tabela TRABALHOS
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    try {
        if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_var($_POST['descricao'], FILTER_SANITIZE_SPECIAL_CHARS);
            $trabalho = new Trabalho($nome, $descricao);
            $trabalhoDAO = new TrabalhoDAO();
            $trabalhoDAO->salvar($trabalho);
            $data = array('messagem' => 'sucesso');
            //A partir daqui as mensagem vão ser enviadas por JSON
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        } else {
            header('Location: ./view/welcome');
        }
    } catch (Exception $e) {
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
        } else {
            // Caso a senha não corresponda, redireciona para o perfil
            // Armazena o usuário na sessão
            $_SESSION['autenticacao'] =  false; // Define a autenticação como verdadeira
            header('Location: ../view/login.php'); // Redireciona para o perfil do usuário=
            exit();
        }
    } catch (Exception $e) {
        echo $e->getMessage(); // Em caso de exceção, imprime a mensagem de erro
    }
} else if ($submit == 'Atualizar_usuario') {
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    try { // analisar se é getente ou auxiliar_gerente
        if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
            $id = filter_var($_POST['id'], FILTER_SANITIZE_SPECIAL_CHARS);
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS); // Filtra o nome
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Valida o email
            $data_nascimento = filter_var($_POST['data_nascimento'], FILTER_SANITIZE_NUMBER_INT); // NÃO PODE MUDAR O DATA NASCIMENTO
            $data_adimisao = filter_var($_POST['data_adimisao'], FILTER_SANITIZE_NUMBER_INT); // Filtra a data de admissão
            $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_NUMBER_INT); // Filtra o telefone
            $sexo = filter_var($_POST['sexo'], FILTER_SANITIZE_SPECIAL_CHARS); // NÃO PODE MUDAR O SEXO
            $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_NUMBER_INT); // NÃO PODE MUDAR O CPF
            $trabalho = filter_var($_POST['trabalho'], FILTER_SANITIZE_NUMBER_INT);
            $user = new User($nome, $email, $trabalho, $cpf, $senha, $data_nascimento, $data_admissao, $telefone, $sexo);
            $user->setId($id);
            $userDAO = new UserDAO(); // Instancia o DAO de usuário
            $user = $userDAO->persit($user); // Persiste as alterações do usuário no banco de dados
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        } else {
            header('Location: ./view/welcome');
        }
    } catch (Exception $e) {
        $_SESSION['mensagem'] = $e->getMessage(); // Em caso de exceção, define a mensagem de erro na sessão
    }
    // header('Location: '); // Redireciona de volta para a página atual (provavelmente para a página de perfil)
    // exit();
}
// volta um json com uma messagem 
// ta uma vazia este buscar cargo
// agora ta correto, aqui tb tinha um erro, que era, pq tava passado o $id? sendo que nao existia a variavel?,
else if ($submit == 'Buscar_cargos') {
    $id_cargo = filter_var($_POST['nome'], FILTER_SANITIZE_NUMBER_INT);
    $trabalhoDAO = new TrabalhoDAO();
    $trabalho = $trabalhoDAO->buscarPorId($id_cargo);
    if ($trabalho != null) {
        $response = [
            'success' => true,
            'messagem' => 'obtetido com sucesso',
            'cargo' => $trabalho
        ];
    } else {
        $response = [
            'success' => false,
            'messagem' => 'sem sucesso',
            'erro' => null
        ];
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
} else if ($submit == 'Listar_cargos') {
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
} else if ($submit == 'Cadastrar_grupo') {
    // adicione a deserialize o usuario para verificar o grupo
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    echo $usuario->getGrupo();
    // teste corretemente agora, o if nao ta comparando os literais com nada
    // depois coloca os headers de volta pelo momento
    if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
        try {
            var_dump($_POST);
            $nome = filter_var($_POST['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $data_nascimento = filter_var($_POST['datanascimento'], FILTER_SANITIZE_NUMBER_INT);
            $data_adimisao = filter_var($_POST['dataadmissao'], FILTER_SANITIZE_NUMBER_INT);
            $telefone = filter_var($_POST['telefone'], FILTER_SANITIZE_NUMBER_INT);
            $sexo = filter_var($_POST['sexo'], FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf = filter_var($_POST['cpf'], FILTER_SANITIZE_SPECIAL_CHARS);
            $senha = filter_var($_POST['senha'], FILTER_SANITIZE_SPECIAL_CHARS);
            $salario_bruto = $_POST['bruto'];
            $mes = date('m');
            $salario = new Salario($salario_bruto, $mes);
            $user = new User($nome, $email, '2', $cpf, $senha, $data_nascimento, $data_adimisao, $telefone, $sexo, $salario);
            $user->setGrupo('auxiliar');
            $usuario->setSalario($salario);
            $userDAO = new UserDAO();
            $userDAO->insertgrupo($user);
        } catch (Exception $e) {
            $response = [
                'success' => true,
                'message' => 'deu algum erro',
                'erro' => $e->getMessage()
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            $_SESSION['mensagem'] = $e->getMessage();
            exit();
        }
    }
} else if ($submit == 'Atualizar o estado') {
    // arrumei o comportamento
    // ta funcionado agora, tava faltado pegar o id do POST
    // adicione a deserialize o usuario para verificar o grupo
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    // teste corretemente agora, o if nao ta comparando os literais com nada
    // depois coloca os headers de volta pelo momento
    if ($usuario->getGrupo() == 'gerente' && $usuario->getId() != $id && $id != null) {
        try {
            // adiconem
            $userDAO = new UserDAO();
            $userDAO->delete($id);
            $response = [
                'success' => true,
                'message' => 'foi deletado o usuario',
            ];
            http_response_code(200);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
        } catch (Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
        }
    }
} else if ($submit == 'ativar o usuario') {
    // se a gente vai usar o um javascript do meu jeito, a gente meio que pode remover o redirecionamento de algumas coisas
    // ta funcionado agora, tava faltado pegar o id do POS, a verificaçao tava meio incompleta
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    if ($usuario->getGrupo() == 'gerente' && $usuario->getId() != $id && $id != null) {
        try {
            // adiconem
            $userDAO = new UserDAO();
            $userDAO->aiivacao($id);
            $response = [
                'success' => true,
                'message' => 'foi um susseso',
                'status' => 201
            ];
            http_response_code(201);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
        } catch (Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
        }
    }
} else if ($submit == 'users') {
    $usuario = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
    $min = filter_var($_GET['min'], FILTER_SANITIZE_NUMBER_INT);
    $max = filter_var($_GET['max'], FILTER_SANITIZE_NUMBER_INT);


    if ($usuario->getGrupo() == 'auxiliar' || $usuario->getGrupo() == 'gerente') {
        echo "entra aqui";
        try {
            $userDAO = new UserDAO();
            $users = $userDAO->getbyall($min, $max);
            $dados = array();
            foreach ($users as $user) {
                $salario = $user->getissalario();
                $salariojson = [
                    "salario_liquido" => $salario->getSalarioliquido(),
                    "salario_bruto" => $salario->getSalariobruto()
                ];
                $usera = [
                    'Nome' => $user->getNome(),
                    'Cpf' => $user->getCpf(),
                    'Email' => $user->getEmail(),
                    'Senha' => $user->getSenha(),
                    'DataNascimento' => $user->getDataNascimento(),
                    'DataAdmissao' => $user->getDataAdmissao(),
                    'Telefone' => $user->getTelefone(),
                    'Grupo' => $user->getGrupo(),
                    'Sexo' => $user->getSexo(),
                    'Trabalho' => $user->getTrabalho(),
                    'Id' => $user->getId(),
                    'Delete' => $user->getDeletedAt(),
                    'salalario' => $salariojson
                ];
                $dados[] = $usera;
            }
            $response = [
                'success' => true,
                'message' => 'Dados recebidos com sucesso!',
                'cargos' => $dados
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            $_SESSION['mensagem'] = $e->getMessage();
            $response = [
                'success' => true,
                'message' => 'deu algum erro',
                'erro' => $e->getMessage()
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($response);
            exit();
        }
    }
} else if ($submit == "teste") {
    $reponse = [
        "status" => 200,
        'messagem' => "vem aqui"
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($reponse);
}
