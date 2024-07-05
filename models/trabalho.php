<?php

require_once("./models/users.php");

class Trabalho {
    private $id_cargo;
    private $nome;
    private $descricao;

    public function __construct($nome, $descricao) {
        if (empty($nome) || empty($descricao)) {
            throw new Exception("Está faltando um dado");
        }
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->id_cargo = null; // Inicializa o ID como null
    }

    public function getId() {
        return $this->id_cargo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setId($id_cargo) {
        $this->id_cargo = $id_cargo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}



<?php

require_once("./models/users.php");

class Trabalho {
    private $id_cargo;
    private $nome;
    private $descricao;

    public function __construct($nome, $descricao) {
        if (empty($nome) || empty($descricao)) {
            throw new Exception("Está faltando um dado");
        }
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->id_cargo = null; // Initialize id_cargo as null
    }

    public function getIdCargo() {
        return $this->id_cargo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdCargo($id_cargo) {
        $this->id_cargo = $id_cargo;
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

    function __construct() {
        require_once("../config/db.php"); // Assuming this file correctly sets $pdo
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

        $trabalho->setIdCargo($this->conn->lastInsertId());

        return $trabalho;
    }

    public function buscarPorId($id_cargo) {
        $sql = "SELECT * FROM trabalhos WHERE id_cargo = :id_cargo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_cargo", $id_cargo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        } else {
            $trabalho = new Trabalho($result['nome'], $result['descricao']);
            $trabalho->setIdCargo($result['id_cargo']);
            return $trabalho;
        }
    }

    public function atualizar(Trabalho $trabalho) {
        $id_cargo = $trabalho->getIdCargo();
        $nome = $trabalho->getNome();
        $descricao = $trabalho->getDescricao();

        $sql = "UPDATE trabalhos SET nome = :nome, descricao = :descricao WHERE id_cargo = :id_cargo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":id_cargo", $id_cargo);
        $stmt->execute();

        return $trabalho;
    }

    public function deletar($id_cargo) {
        $sql = "DELETE FROM trabalhos WHERE id_cargo = :id_cargo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_cargo", $id_cargo);
        $stmt->execute();
    }

    public function listarCargo() {
        $sql = "SELECT * FROM trabalhos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $trabalhos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $listaTrabalhos = [];
        foreach ($trabalhos as $trabalho) {
            $t = new Trabalho($trabalho['nome'], $trabalho['descricao']);
            $t->setIdCargo($trabalho['id_cargo']);
            $listaTrabalhos[] = $t;
        }

        return $listaTrabalhos;
    }
}
?>
