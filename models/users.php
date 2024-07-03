<?php
class UserVO {
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

    function __construct($nome, $email, $trabalho, $cpf, $senha, $data_nascimento, $data_adimisao, $telefone, $sexo) {
        if (empty($nome) || empty($email) || empty($senha) || empty($data_nascimento) || empty($data_adimisao) || empty($telefone) || empty($sexo) || empty($trabalho)) {
            throw new Exception("Está faltando um dado");
        }
        $this->nome = $nome;
        $this->email = $email;
        $this->trabalho = $trabalho;
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
}

class UserDAO{
    private $conn;
    function __construct() {
        require_once("../config/db.php");
        $this->conn = $pdo;
    }
    private function insert(UserVO $user){
        $sql = "insert into users(NOME,EMAIL,SENHA,TELEFONE,DATA_NASCIMENTO,DATA_ADMISSAO,SEXO,CPF) values(:nome,:email,:senha,:telefone,data_nas,:data_ad,:sexo,:cpf)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam("", $user.getName());
    }
}
