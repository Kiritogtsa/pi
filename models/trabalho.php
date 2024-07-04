<?php

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
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function salvar(Trabalho $trabalho) {
        $nome = $trabalho->getNome();
        $descricao = $trabalho->getDescricao();

        $sql = "INSERT INTO trabalhos (nome, descricao) VALUES (?, ?)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ss", $nome, $descricao);
        $stmt->execute();

        $trabalho->setId($stmt->insert_id);

        return $trabalho;
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM trabalhos WHERE id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            return null;
        } else {
            $row = $result->fetch_assoc();
            $trabalho = new Trabalho($row['nome'], $row['descricao']);
            $trabalho->setId($row['id']);
            return $trabalho;
        }
    }

    public function atualizar(Trabalho $trabalho) {
        $id = $trabalho->getId();
        $nome = $trabalho->getNome();
        $descricao = $trabalho->getDescricao();

        $sql = "UPDATE trabalhos SET nome = ?, descricao = ? WHERE id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ssi", $nome, $descricao, $id);
        $stmt->execute();

        return $trabalho;
    }

    public function deletar($id) {
        $sql = "DELETE FROM trabalhos WHERE id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
