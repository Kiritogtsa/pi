<?php

require_once("./models/users.php");

class Trabalho {
    private $id;
    private $nome;
    private $descricao;

    public function __construct($nome, $descricao) {
        if (empty($nome) || empty($descricao)) {
            throw new Exception("Está faltando um dado");
        }
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->id = null; // Inicializa o ID como null
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}




class TrabalhoDAO {
    private $conn;
    // o contrutor seta a conn para receber a conexao do banco de dados
    function __construct() {
        require_once("../config/db.php");
        $this->conn = $pdo;
    }


    public function salvar(Trabalho $trabalho) {
        $nome = $trabalho->getNome();
        $descricao = $trabalho->getDescricao();

        $sql = "INSERT INTO trabalhos (nome, descricao) VALUES (:nome, :descricao)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->execute();

        $trabalho->setId($this->conn->lastInsertId());

        return $trabalho;
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM trabalhos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        } else {
            $trabalho = new Trabalho($result['nome'], $result['descricao']);
            $trabalho->setId($result['id']);
            return $trabalho;
        }
    }

    public function atualizar(Trabalho $trabalho) {
        $id = $trabalho->getId();
        $nome = $trabalho->getNome();
        $descricao = $trabalho->getDescricao();

        $sql = "UPDATE trabalhos SET nome = :nome, descricao = :descricao WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $trabalho;
    }

    public function deletar($id) {
        $sql = "DELETE FROM trabalhos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }
}
?>
