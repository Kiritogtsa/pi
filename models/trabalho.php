<?php

class Trabalho
{
    public $id_cargo;
    public $nome;
    public $descricao;

    public function __construct($nome, $descricao)
    {
        if (empty($nome) || empty($descricao)) {
            throw new Exception("Está faltando um dado");
        }
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->id_cargo = null; // Initialize id_cargo as null
    }

    public function getIdCargo()
    {
        return $this->id_cargo;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setIdCargo($id_cargo)
    {
        $this->id_cargo = $id_cargo;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
}

class TrabalhoDAO
{
    private $conn; // Armazena a conexão com o banco de dados

    function __construct()
    {
        require_once("../config/db.php"); // Inclui o arquivo de configuração do banco de dados (assumindo que define $pdo)
        $this->conn = $pdo; // Inicializa a conexão com o banco de dados
    }

    // Salva um novo trabalho no banco de dados
    public function salvar(Trabalho $trabalho)
    {
        $nome = $trabalho->getNome();
        $descricao = $trabalho->getDescricao();

        $sql = "INSERT INTO trabalhos (NOME, DESCRICAO) VALUES (:nome, :descricao)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->execute();

        $trabalho->setIdCargo($this->conn->lastInsertId()); // Define o ID do trabalho com o ID gerado no banco

        return $trabalho; // Retorna o objeto Trabalho atualizado com o ID
    }

    // Busca um trabalho pelo ID no banco de dados
    public function buscarPorNome($nome)
    {
        // a busca ta buscando por uma coluna que nao existe na tabela
        // tinha um erro aqui no sql, o erro era  id_cargo =, agora ta correto
        $sql = "SELECT * FROM trabalhos WHERE NOME = :nome";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null; // Retorna nulo se não encontrar o trabalho
        } else {
            // Cria um objeto Trabalho com os dados do resultado da consulta
            // tv tem erros, o erro daqui e que o nome ea descricao tao minusculas
            $trabalho = new Trabalho($result['NOME'], $result['DESCRICAO']);
            $trabalho->setIdCargo($result['ID']); // Define o ID do trabalho
            return $trabalho; // Retorna o objeto Trabalho encontrado
        }
    }

    // Atualiza um trabalho existente no banco de dados
    public function atualizar(Trabalho $trabalho)
    {
        try{
        $id_cargo = $trabalho->getIdCargo();
        $nome = $trabalho->getNome();
        $descricao = $trabalho->getDescricao();

        $sql = "UPDATE trabalhos SET nome = :nome, descricao = :descricao WHERE ID = :id_cargo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":id_cargo", $id_cargo);
        $stmt->execute();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }

    public function buscarPorId($id)
    {
        // a busca ta buscando por uma coluna que nao existe na tabela
        // tinha um erro aqui no sql, o erro era  id_cargo =, agora ta correto
        $sql = "SELECT * FROM trabalhos WHERE ID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return 'Cargo excluído do sistema!'; // Retorna nulo se não encontrar o trabalho
        } else {
            $nome = $result['NOME'];
            return $nome;
        }
    }

    // Deleta um trabalho pelo ID no banco de dados
    public function deletar($id_cargo)
    {
        $sql = "DELETE FROM trabalhos WHERE ID = :id_cargo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id_cargo", $id_cargo);
        $stmt->execute();
        return " Trabalho deletado com sucesso!";
    }

    public function lastID(){
        $sql = 'SELECT * FROM `users` ORDER BY `ID` DESC LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $valor = $stmt->fetch(PDO::FETCH_ASSOC); 
        return $valor;
    }

    // Lista todos os trabalhos presentes no banco de dados
    public function listarCargo()
    {
        $sql = "SELECT * FROM trabalhos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $trabalhos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $listaTrabalhos = [];
        foreach ($trabalhos as $trabalho) {
            if ($trabalho["NOME"] != "axiliar gerente") {
                $t = new Trabalho($trabalho['NOME'], $trabalho['DESCRICAO']);
                $t->setIdCargo($trabalho['ID']); // Define o ID do trabalho
                $listaTrabalhos[] = $t; // Adiciona o objeto à lista de trabalhos
            }
        }
        return $listaTrabalhos; // Retorna a lista de objetos Trabalho
    }

    public function listarCargosemgerente()
    {
        $sql = "SELECT * FROM trabalhos WHERE ID > 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $trabalhos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $listaTrabalhos = [];
        foreach ($trabalhos as $trabalho) {
            if ($trabalho["NOME"] != "axiliar gerente") {
                $t = new Trabalho($trabalho['NOME'], $trabalho['DESCRICAO']);
                $t->setIdCargo($trabalho['ID']); // Define o ID do trabalho
                $listaTrabalhos[] = $t; // Adiciona o objeto à lista de trabalhos
            }
        }
        return $listaTrabalhos; // Retorna a lista de objetos Trabalho
    }

}
