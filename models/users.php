<?php
class User {
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

    // thiago.da.silva@

    function __construct($nome, $email, $trabalho, $cpf, $senha, $data_nascimento, $data_adimisao, $telefone, $sexo) {
        if (empty($nome) || empty($email) || empty($senha) || empty($data_nascimento) || empty($data_adimisao) || empty($telefone) || empty($sexo) || empty($trabalho)) {
            throw new Exception("Está faltando um dado");
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

class UserDAO{
    private $conn;
    function __construct() {
        require_once("../config/db.php");
        $this->conn = $pdo;
    }
    private function insert(User $user){
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
        $user->setId($this->conn->lastInsertId());
        return $user;
    }
    private function update(User $user) {
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
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":sexo", $sexo);
        $stmt->bindParam(":data_nas", $data_nascimento);
        $stmt->bindParam(":data_ad", $data_adimisao);
        $stmt->execute();
    }
    public function persit(User $user){
        if (!$user->getId()) {
            return $this->insert($user);
        } else {
            return $this->update($user);
        }
    }
    public function getByNome($nome){
        $sql = "SELECT * FROM users WHERE nome = :nome";
        $stmt = $this->conn->prepare($sql);
        echo "<br>";
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<br>";
        var_dump($dados);
        if (!$dados) {
            throw new Exception("Usuário não encontrado com o nome: " . $nome);
        }
        $user = new User($dados["nome"], $dados["email"],$dados["trabalho"],$dados["cpf"], $dados["senha"], $dados["data_nascimento"], $dados["data_adimisao"],$dados["telefone"],$dados["sexo"]);
        $user->setId($dados["id"]);
        return $user; 
    }
    public function getByEmail($email){
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        echo "<br>";
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<br>";
        var_dump($dados);
        if (!$dados) {
            throw new Exception("Usuário não encontrado com o nome: " . $email);
        }
        $user = new User($dados["nome"], $dados["email"],$dados["trabalho"],$dados["cpf"], $dados["senha"], $dados["data_nascimento"], $dados["data_adimisao"],$dados["telefone"],$dados["sexo"]);
        $user->setId($dados["id"]);
        return $user; 
    }
    public function delete($id){
        try {
            $this->conn->beginTransaction();
            
            $sql = "UPDATE users SET deleted_at = NOW() WHERE ID = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            
            $result = $stmt->execute();
            
            $this->conn->commit();
            
            return $result;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

}
