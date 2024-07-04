<?php

class trabalho{
private $id;
private $discricao;
private $nome;

function __construct($nome,$discricao) {
    if (empty($nome) || empty($discricao)) {
        throw new Exception("Está faltando um dado");
    }
    $this->nome = $nome;
    $this->discricao = $discricao;
}
public function getId() {
    return $this->id;
}

public function getNome() {
    return $this->nome;
}

public function getDiscricao() {
    return $this->discricao;
}

//setters
public function setId($id) {
    $this->id = $id;
}

public function setNome($nome) {
    $this->nome = $nome;
}

public function setDiscricao($discricao) {
    $this->discricao = $discricao;
}
}
class TrabalhoDAO {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function salvar(trabalho $trabalho) {
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
            $trabalho = new trabalho($row['nome'], $row['descricao']);
            $trabalho->setId($row['id']);
            return $trabalho;
        }
    }

    public function atualizar(trabalho $trabalho) {
        $id = $trabalho->getId();
        $nome = $trabalho->getNome();
        $descricao = $trabalho->getDescricao();

        $sql = "UPDATE trabalhos SET nome = ?, descricao = ? WHERE id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ssi", $nome, $descricao, $id);
        $stmt->execute();

        return $trabalho;
    }

    public function deletar(trabalho $trabalho) {
        $id = $trabalho->getId();

        $sql = "DELETE FROM trabalhos WHERE id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
