<?php

interface crud{
    public function persit(user $user): user;
    public function getbyemail(string $email): user;
    public function getbyall(int $min, int $max): array;
    public function delete(int $id) : bool;
    public function insertgrupo(User $user):User;
}

// define uma classe de usuario
class User {
    // define os atributos do usuario
    private $id;
    private $nome;
    private $email;
    private $trabalho;
    private $grupo;
    private $senha;
    private $data_nascimento;
    private $data_adimisao;
    private $telefone;
    private $sexo;
    private $cpf;
    
    // o construtor verifica se tem algum campo em branco e se tem gera um erro

    function __construct($nome, $email, $trabalho, $cpf, $senha, $data_nascimento, $data_adimisao, $telefone, $sexo) {
        if (empty($nome) || empty($email) || empty($senha) || empty($data_nascimento) || empty($data_adimisao) || empty($telefone) || empty($sexo) || empty($trabalho)) {
            throw new Exception("Está faltando um dado");
        }
        // chama um metodo para validar os campos, se nao recebr um true  e porque recebeu uma messagem dai gera o erro personalizado
        if($msg = $this->validarcampos($nome,$email, $trabalho,$cpf,$senha,$sexo)!=true){
            throw new Exception($msg);
        }
        $this->nome = $nome;
        $this->email = $email;
        $this->trabalho = $trabalho;
        $this->cpf = $cpf;
        $this->senha = $senha;
        $this->data_nascimento = $data_nascimento;
        $this->data_adimisao = $data_adimisao;
        $this->telefone = $telefone;
        $this->sexo = $sexo;
    }
    private function validaremail($email) {
        $conta = "^[a-zA-Z0-9\._-]+@";
        $domino = "[a-zA-Z0-9\._-]+.";
        $extensao = "([a-zA-Z]{2,4})$";
        
        $pattern = $conta.$domino.$extensao;
        
        if (preg_match($pattern, $email)) {
            return true;
            } else {
            return false;
        }
    }
    
    // valida os campos
    private function validarcampos($nome, $email,$trabalho,$cpf,$senha,$sexo){
        if (!$this->validarcpf($cpf)) {
            return $msg = "cpf invalido";
        }
        if (!$this->validaremail($email)) {
            return $msg = "email invalido";
        }
        if (is_numeric($trabalho)){
            return $msg = "trabalho invalido, recebido um character invalido, era esperado um numero";
        }
        if($sexo == "masculino" || $sexo == "feminino"){
            return $msg =  "sexo incorreto";
        }
    }
    private function validarcpf($cpf){

    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }
    public function getCPF() {
        return $this->cpf;
    }


    public function getTrabalho() {
        return $this->trabalho;
    }

    public function getGrupo() {
        return $this->grupo;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getDataNascimento() {
        return $this->data_nascimento;
    }

    public function getDataAdimisao() {
        return $this->data_adimisao;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getSexo() {
        return $this->sexo;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTrabalho($trabalho) {
        $this->trabalho = $trabalho;
    }

    public function setGrupo($grupo) {
        $this->grupo = $grupo;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setDataNascimento($data_nascimento) {
        $this->data_nascimento = $data_nascimento;
    }

    public function setDataAdimisao($data_adimisao) {
        $this->data_adimisao = $data_adimisao;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }
    public function setCPF($cpf) {
        $this->cpf = $cpf;
    }
}

// define a classe que trabalha com a tabela relacionada ao usuario
class UserDAO implements crud{
    private $conn;
    // o contrutor seta a conn para receber a conexao do banco de dados
    function __construct() {
        require_once("../config/db.php");
        $this->conn = $pdo;
    }

    // cria um usuario, ele recebe um usuario e volta o usuario ja com o id do banco de dados
    private function insert(User $user):User{
        echo "vem aqui insert"."\n";
        $sql = "insert into users(NOME,EMAIL,SENHA,TELEFONE,DATA_NASCIMENTO,DATA_ADMISSAO,SEXO,CPF,tr_id) values(:nome,:email,:senha,:telefone,data_nas,:data_ad,:sexo,:cpf,:tr_id)";
        $nome = $user->getNome();
        $email = $user->getEmail(); 
        $senha=$user->getSenha(); 
        $data_nascimento=$user->getDataNascimento(); 
        $data_adimisao=$user->getDataAdimisao(); 
        $telefone=$user->getTelefone();
        $cpf=$user->getCpf();
        $sexo = $user->getSexo();
        $tr_id = $user->getTrabalho();
        $stmt = $this->conn->prepare($sql);
        echo "insert prepara o sql"."\n";
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":sexo", $sexo);
        $stmt->bindParam(":data_nas", $data_nascimento);
        $stmt->bindParam(":data_nas", $data_nascimento);
        $stmt->bindParam(":data_ad", $data_adimisao);
        $stmt->bindParam(":tr_id", $tr_id);
        $stmt->execute();
        echo "insert executa o sql"."\n";
        $user->setId($this->conn->lastInsertId());
        return $user;
    }
    public function insertgrupo(User $user):User{
        if (empty($user->getGrupo())){
            throw new Exception(" nao tem um grupo");
        }
        echo "chega no insertgrupo"."\n";
        $sql = "insert into users(NOME,EMAIL,SENHA,TELEFONE,DATA_NASCIMENTO,DATA_ADMISSAO,SEXO,CPF,tr_id,GRUPO) values(:nome,:email,:senha,:telefone,data_nas,:data_ad,:sexo,:cpf,:tr_id,:grupo)";
        $nome = $user->getNome();
        $email = $user->getEmail(); 
        $senha=$user->getSenha(); 
        $data_nascimento=$user->getDataNascimento(); 
        $data_adimisao=$user->getDataAdimisao(); 
        $telefone=$user->getTelefone();
        $cpf=$user->getCpf();
        $sexo = $user->getSexo();
        $tr_id = $user->getTrabalho();
        $grupo = $user->getGrupo();
        $stmt = $this->conn->prepare($sql);
        echo "insertgrupo prepara o sql"."\n";
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":sexo", $sexo);
        $stmt->bindParam(":data_nas", $data_nascimento);
        $stmt->bindParam(":data_nas", $data_nascimento);
        $stmt->bindParam(":data_ad", $data_adimisao);
        $stmt->bindParam(":tr_id", $tr_id);
        $stmt->bindParam(":grupo", $grupo);
        $stmt->execute();
        echo "insertgrupo executa o sql"."\n";
        $user->setId($this->conn->lastInsertId());
        return $user;
    }
    // ele atualiza um usuario
    private function update(User $user):User {
        echo "chega aqui no update"."\n";
        $sql = "UPDATE users SET 
            NOME = :nome,
            EMAIL = :email,
            TELEFONE = :telefone,
            DATA_NASCIMENTO = :data_nas,
            DATA_ADMISSAO = :data_ad,
            SEXO = :sexo,
            CPF = :cpf
        WHERE ID = :id";
        $id = $user->getId();
        $nome = $user->getNome();
        $email = $user->getEmail(); 
        $data_nascimento = $user->getDataNascimento(); 
        $data_adimisao = $user->getDataAdimisao(); 
        $telefone = $user->getTelefone();
        $cpf = $user->getCpf();
        $sexo = $user->getSexo();
        $stmt = $this->conn->prepare($sql);
        echo "update prepara o sql"."\n";
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":sexo", $sexo);
        $stmt->bindParam(":data_nas", $data_nascimento);
        $stmt->bindParam(":data_ad", $data_adimisao);
        $stmt->execute();
        echo "update executa o sql"."\n";
        return $user;
    }

    // a funçao que decide qual metodo e chamado
    public function persit(User $user):User{
        echo "Chega no persit"."\n";
        if (!$user->getId()) {
            return $this->insert($user);
        } else {
            return $this->update($user);
        }
    }
    
    // obtem uma instancia de User com base no email fonercido
    public function getByEmail($email):User{
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        echo "getemail prepara o sql"."\n";
        echo "<br>";
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        echo "getemail executa o sql"."\n";
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($dados);
        if (!$dados) {
            throw new Exception("Usuário não encontrado com o nome: " . $email);
        }
        $user = new User($dados["nome"], $dados["email"],$dados["trabalho"],$dados["cpf"], $dados["senha"], $dados["data_nascimento"], $dados["data_adimisao"],$dados["telefone"],$dados["sexo"]);
        $user->setId($dados["id"]);
        $user->setGrupo($dados["grupo"]);
        echo "getemail termina retornado uma instacia"."\n";
        return $user; 
    }
    // ele desativa o usuario
    public function delete($id):bool{
        try {
            $this->conn->beginTransaction();
            echo "chega no delete"."\n";
            $sql = "UPDATE users SET deleted_at = NOW() WHERE ID = :id";
            $stmt = $this->conn->prepare($sql);
            echo "prepara o sql"."\n";
            $stmt->bindParam(":id", $id);
            
            $result = $stmt->execute();
            echo "executa o sql"."\n";
            $this->conn->commit();
            return $result;
        } catch (Exception $e) {
            echo "deu um erro"."\n";
            $this->conn->rollBack();
            throw $e;
        }
    }
    public function getbyall(int $min, int $max): array{
        $sql = "SELECT * FROM users WHERE id BETWEEN :min AND :max";
        echo "chega no getbyall"."\n";
        // Preparar a consulta
        $stmt = $this->conn->prepare($sql);
        echo "prepara o sql"."\n";
        
        // Executar a consulta com os parâmetros
        $stmt->execute([':min' => $min, ':max' => $max]);
        echo "executa o sql"."\n";
        // Buscar todos os resultados como array associativo
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "obtem os dados"."\n";
        // Array para armazenar os objetos User
        $users = [];
        
        // Iterar pelos resultados e criar objetos User
        foreach ($results as $row) {
            $user = new User(
                $row['NOME'],
                $row['EMAIL'],
                $row['SENHA'],
                $row['TELEFONE'],
                $row['DATA_NASCIMENTO'],
                $row['DATA_ADMISSAO'],
                $row['SEXO'],
                $row['CPF'],
                $row['tr_id']
            );
            $user->setId($row['ID']);
            $user->setGrupo($row["GRUPO"]);
            $users[] = $user;
        }
        echo "retorna os dados"."\n";
        // Retornar o array de objetos User
        return $users;
    }

}
// exemplo de como receber um json

// header('Content-Type: application/json');

// // Obtendo o conteúdo JSON do corpo da solicitação
// $inputJSON = file_get_contents('php://input');

// // Convertendo o JSON para um array associativo PHP
// $inputData = json_decode($inputJSON, true);

// // Exemplo de uso dos dados recebidos
// $nome = $inputData['nome'] ?? 'Desconhecido';
// $email = $inputData['email'] ?? 'email@example.com';

// $response = [
//     'success' => true,
//     'message' => 'Dados recebidos com sucesso!',
//     'received' => $inputData
// ];

// echo json_encode($response);