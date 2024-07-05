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
    private $conn; // Armazena a conexão com o banco de dados

    function __construct() {
        require_once("../config/db.php"); // Inclui o arquivo de configuração do banco de dados (assumindo que define $pdo)
        $this->conn = $pdo; // Inicializa a conexão com o banco de dados
    }

    // Salva um novo trabalho no banco de dados
    public function salvar(Trabalho $trabalho) {
        $nome = $trabalho->getNome();
        $descricao = $trabalho->getDescricao();

        $sql = "INSERT INTO trabalhos (nome, descricao) VALUES (:nome, :descricao)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->execute();

        $trabalho->setIdCargo($this->conn->lastInsertId()); // Define o ID do trabalho com o ID gerado no banco

        return $trabalho; // Retorna o objeto Trabalho atualizado com o ID
    }

    // Busca um trabalho pelo ID no banco de dados
    public function buscarPorId($id_cargo) {
        $sql = "SELECT * FROM trabalhos WHERE id_cargo = :id_cargo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_cargo", $id_cargo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null; // Retorna nulo se não encontrar o trabalho
        } else {
            // Cria um objeto Trabalho com os dados do resultado da consulta
            $trabalho = new Trabalho($result['nome'], $result['descricao']);
            $trabalho->setIdCargo($result['id_cargo']); // Define o ID do trabalho
            return $trabalho; // Retorna o objeto Trabalho encontrado
        }
    }

    // Atualiza um trabalho existente no banco de dados
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

        return $trabalho; // Retorna o objeto Trabalho atualizado
    }

    // Deleta um trabalho pelo ID no banco de dados
    public function deletar($id_cargo) {
        $sql = "DELETE FROM trabalhos WHERE id_cargo = :id_cargo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_cargo", $id_cargo);
        $stmt->execute();
    }

    // Lista todos os trabalhos presentes no banco de dados
    public function listarCargo() {
        $sql = "SELECT * FROM trabalhos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $trabalhos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $listaTrabalhos = [];
        foreach ($trabalhos as $trabalho) {
            // Cria objetos Trabalho com os dados de cada resultado da consulta
            $t = new Trabalho($trabalho['nome'], $trabalho['descricao']);
            $t->setIdCargo($trabalho['id_cargo']); // Define o ID do trabalho
            $listaTrabalhos[] = $t; // Adiciona o objeto à lista de trabalhos
        }

        return $listaTrabalhos; // Retorna a lista de objetos Trabalho
    }
}
