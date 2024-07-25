<?php
// testar o codigo e corrigir erros aqui e na mains
// criar yma uma tabela para endereço, fazer o dao dela tb
require_once("salario.php");
// add functions for crud from salarios
class endereco {}
interface crudendereco {}
abstract class enderecoa {}
class enderecodao extends enderecoa {}

interface crud
{
    public function persit(user $user): user;
    public function getbyemail(string $email): user;
    public function getbyall(int $min, int $max): array;
    public function delete(int $id): bool;
    public function insertgrupo(User $user): User;
}
// a interface for user from adding contracts 
// the contracts require what be implements in strucs or  class
interface userit
{
    public function getsalario(): int;
}
// ceate a abstract class for share responsabilidade and implements for interface

abstract class UserAbstract implements UserIT
{
    protected $id;
    protected $nome;
    protected $email;
    protected $trabalho;
    protected $grupo;
    protected $senha;
    protected $dataNascimento;
    protected $dataAdmissao;
    protected $telefone;
    protected $sexo;
    protected $cpf;
    protected $deletedAt;
    protected Salario $salario;

    // Construtor na classe abstrata
    public function __construct(
        $nome,
        $email,
        $trabalho,
        $cpf,
        $senha,
        $dataNascimento,
        $dataAdmissao,
        $telefone,
        $sexo,
        $salario = null
    ) {
        if (empty($nome) || empty($email) || empty($senha) || empty($dataNascimento) || empty($dataAdmissao) || empty($telefone) || empty($sexo) || empty($trabalho) || empty($salario)) {
            throw new Exception("Está faltando um dado");
        }

        if (($msg = $this->validarCampos($nome, $email, $trabalho, $cpf, $senha, $sexo)) != true) {
            throw new Exception($msg);
        }

        $this->nome = $nome;
        $this->email = $email;
        $this->trabalho = $trabalho;
        $this->cpf = $cpf;
        $this->senha = $senha;
        $this->dataNascimento = $dataNascimento;
        $this->dataAdmissao = $dataAdmissao;
        $this->telefone = $telefone;
        $this->sexo = $sexo;
        $this->salario = $salario;
    }

    private function validarEmail($email)
    {
        $pattern = "^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,4}$";
        return preg_match($pattern, $email) ? true : false;
    }

    abstract public function getSalario(): int;

    private function validarCampos($nome, $email, $trabalho, $cpf, $senha, $sexo)
    {
        // if (!$this->validarCpf($cpf)) {
        //     return "CPF inválido";
        // }

        // if (!$this->validarEmail($email)) {
        //     return "Email inválido";
        // }
        if (!$salario = null) {
            return "nao existe um salario";
        }
        if (!is_numeric($trabalho)) {
            return "Trabalho inválido, recebido um valor não numérico";
        }

        if ($sexo != "masculino" && $sexo != "feminino") {
            return "sexo errado";
        }

        if (empty($salario)) {
            return "Salário não fornecido";
        }

        return true;
    }

    private function validarCpf($cpf)
    {
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

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

    // Getters e Setters
    public function getId()
    {
        return $this->id;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getTrabalho()
    {
        return $this->trabalho;
    }

    public function getGrupo()
    {
        return $this->grupo;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    public function getDataAdmissao()
    {
        return $this->dataAdmissao;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDeletedAt($data)
    {
        $this->deletedAt = $data;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setTrabalho($trabalho)
    {
        $this->trabalho = $trabalho;
    }

    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;
    }

    public function setDataAdmissao($dataAdmissao)
    {
        $this->dataAdmissao = $dataAdmissao;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }
    public function getslario(): Salario
    {
        return $this->salario;
    }
}

// Classe concreta que implementa a interface e herda da classe abstrata
class User extends UserAbstract
{
    public function getSalario(): int
    {
        return $this->salario->calcsalarLiquid($this->salario->getSalarioBruto(), $this->salario->getIr(), $this->salario->getInss(), $this->salario->getAdicional(), $this->salario->getMes());
    }
}


// define a classe que trabalha com a tabela relacionada ao usuario
class UserDAO implements crud
{
    private $conn;
    // o contrutor seta a conn para receber a conexao do banco de dados
    function __construct()
    {
        require_once("../config/db.php");
        $this->conn = $pdo;
    }

    // cria um usuario, ele recebe um usuario e volta o usuario ja com o id do banco de dados
    private function insert(User $user): User
    {
        $result = $this->insertsalario($user->getslario());
        if ($result == false) {
            throw new Exception("deu um erro ao criar o salario");
        }
        $grupo = $user->getGrupo() == "" ? "user" : $user->getGrupo();
        echo "vem aqui insert" . "\n";
        $sql = "insert into users(NOME,EMAIL,SENHA,TELEFONE,DATA_NASCIMENTO,DATA_ADMISSAO,SEXO,CPF,TR_ID,GRUPO,SALARIO_ID) values(:nome,:email,:senha,:telefone,:data_nas,:data_ad,:sexo,:cpf,:tr_id,:grupo,:salarioid)";
        $nome = $user->getNome();
        $email = $user->getEmail();
        $senha = $user->getSenha();
        $data_nascimento = $user->getDataNascimento();
        $data_adimisao = $user->getDataAdmissao();
        $telefone = $user->getTelefone();
        $cpf = $user->getCpf();
        $sexo = $user->getSexo();
        $tr_id = $user->getTrabalho();
        $stmt = $this->conn->prepare($sql);
        echo "insert prepara o sql" . "\n";
        var_dump($tr_id);
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":sexo", $sexo);
        $stmt->bindParam(":data_nas", $data_nascimento);
        $stmt->bindParam(":data_ad", $data_adimisao);
        $stmt->bindParam(":tr_id", $tr_id);
        $stmt->bindParam(":grupo", $grupo);
        $stmt->bindParam(":salarioid", $result);
        $stmt->execute();
        echo "insert executa o sql" . "\n";
        $user->setId($this->conn->lastInsertId());
        return $user;
    }
    // CREATE TABLE salario(
    //     ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    //     FLOAT salariobruto,
    //     FLOAT ir,
    //     FLOAT inss,
    //     FLOAT adicional,
    //     FLOAT salarioliquido,
    //     INT mes,
    //     FLOAT decimo,
    //     INT ano
    // ) 
    private function insertsalario(Salario $salario)
    {
        $sql = "insert into salario(salariobruto,ir,adicional,salarioliquido,decimo,ano,mes) values(:salariobruto,:ir,:adicional,:salarioliquido,:decimo,:ano,:mes)";
        $salariobruto = $salario->getSalariobruto();
        $ir = $salario->getIr();
        $adicional = $salario->getAdicional();
        $salarioliquido = $salario->getSalarioliquido();
        $decimo = $salario->getDecimo();
        $ano = $salario->getAno();
        $mes = $salario->getMes();
        echo "se nao apareceu a outra messagem depois, tem um erro na linha 316";
        $stmt = $this->conn->prepare($sql);
        echo "se nao apareceu a outra messagem depois, tem algum erro nos bind param do salario";
        $stmt->bindParam(":salariobruto", $salariobruto);
        $stmt->bindParam(":ir", $ir);
        $stmt->bindParam("adicional", $adicional);
        $stmt->bindParam(":salarioliquido", $salarioliquido);
        $stmt->bindParam(":decimo", $decimo);
        $stmt->bindParam(":ano", $ano);
        $stmt->bindParam(":mes", $mes);
        echo "se nao apareceu a outra messagem depois, tem um erro na linha 333";
        $result = $stmt->execute();
        if (!$result) {
            return false;
        }
        return $this->conn->lastInsertId();
    }
    // um insert que adiciona um grupo
    public function insertgrupo(User $user): User
    {
        if (empty($user->getGrupo())) {
            throw new Exception(" nao tem um grupo");
        }
        echo "chega no insertgrupo" . "\n";
        $sql = "insert into users(NOME,EMAIL,SENHA,TELEFONE,DATA_NASCIMENTO,DATA_ADMISSAO,SEXO,CPF,tr_id,GRUPO) values(:nome,:email,:senha,:telefone,:data_nas,:data_ad,:sexo,:cpf,:tr_id,:grupo)";
        $nome = $user->getNome();
        $email = $user->getEmail();
        $senha = $user->getSenha();
        $data_nascimento = $user->getDataNascimento();
        $data_adimisao = $user->getDataAdmissao();
        $telefone = $user->getTelefone();
        $cpf = $user->getCpf();
        $sexo = $user->getSexo();
        $tr_id = $user->getTrabalho();
        $grupo = $user->getGrupo();
        $stmt = $this->conn->prepare($sql);
        echo "insertgrupo prepara o sql" . "\n";
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
        echo "insertgrupo executa o sql" . "\n";
        $user->setId($this->conn->lastInsertId());
        return $user;
    }
    // ele atualiza um usuario
    private function update(User $user): User
    {
        echo "chega aqui no update" . "\n";
        $sql = "UPDATE users SET 
            NOME = :nome,
            EMAIL = :email,
            TELEFONE = :telefone,
            DATA_ADMISSAO = :data_ad,
            SEXO = :sexo,
        CPF = :cpf,
        SALARIO_ID = :salarioid
        WHERE ID = :id";
        $id = $user->getId();
        $nome = $user->getNome();
        $email = $user->getEmail();
        $data_adimisao = $user->getDataAdmissao();
        $telefone = $user->getTelefone();
        $cpf = $user->getCpf();
        $sexo = $user->getSexo();
        $stmt = $this->conn->prepare($sql);
        echo "update prepara o sql" . "\n";
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":sexo", $sexo);
        $stmt->bindParam(":data_ad", $data_adimisao);
        $stmt->bindParam(":salarioid", $user->getslario()->getId());
        $stmt->execute();
        echo "update executa o sql" . "\n";
        return $user;
    }

    // a funçao que decide qual metodo e chamado
    public function persit(User $user): User
    {
        echo "Chega no persit" . "\n";
        if (!$user->getId()) {
            return $this->insert($user);
        } else {
            return $this->update($user);
        }
    }

    // obtem uma instancia de User com base no email fonercido
    public function getByEmail($email): User
    {
        // deois de confimar como vamo fazer o sql adicionar aqui o salario
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        echo "getemail prepara o sql" . "\n";
        echo "<br>";
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        echo "getemail executa o sql" . "\n";
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dados) {
            throw new Exception("Usuário não encontrado com o nome: " . $email);
        }
        var_dump($dados);
        $user = new User($dados["NOME"], $dados["EMAIL"], $dados["TR_ID"], $dados["CPF"], $dados["SENHA"], $dados["DATA_NASCIMENTO"], $dados["DATA_ADMISSAO"], $dados["TELEFONE"], $dados["SEXO"], null);
        $user->setId($dados["ID"]);
        $user->setDeletedAt($dados["DELETE_AT"]);
        $user->setGrupo($dados["GRUPO"]);
        echo "getemail termina retornado uma instacia" . "\n";
        return $user;
    }
    // ele desativa o usuario
    public function delete($id): bool
    {
        try {
            $this->conn->beginTransaction();
            echo "chega no delete" . "\n";
            $sql = "UPDATE users SET deleted_at = NOW() WHERE ID = :id";
            $stmt = $this->conn->prepare($sql);
            echo "prepara o sql" . "\n";
            $stmt->bindParam(":id", $id);

            $result = $stmt->execute();
            echo "executa o sql" . "\n";
            $this->conn->commit();
            return $result;
        } catch (Exception $e) {
            echo "deu um erro" . "\n";
            $this->conn->rollBack();
            throw $e;
        }
    }

    // ele ativa o usuario denovo
    public function aiivacao($id): bool
    {
        try {
            $this->conn->beginTransaction();
            echo "chega no delete" . "\n";
            $sql = "UPDATE users SET DELETE_AT = null WHERE ID = :id";
            $stmt = $this->conn->prepare($sql);
            echo "prepara o sql" . "\n";
            $stmt->bindParam(":id", $id);

            $result = $stmt->execute();
            echo "executa o sql" . "\n";
            $this->conn->commit();
            return $result;
        } catch (Exception $e) {
            echo "deu um erro" . "\n";
            $this->conn->rollBack();
            throw $e;
        }
    }
    public function getbyall(int $min, int $max): array
    { // seleciona todos os usuarios ativados
        // deois de confimar como vamo fazer o sql adicionar aqui o salario
        $sql = "SELECT * FROM users u 
        INNER JOIN salario s ON u.SALARIO_ID = s.ID 
        WHERE u.ID BETWEEN :min AND :max";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':min' => $min, ':max' => $max]);
        echo "executa o sql" . "\n";
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "obtem os dados" . "\n";
        $users = [];
        foreach ($results as $row) {
            $salario = new Salario(
                $row["SALARIO_ID"],
                $row["salariobruto"],
                $row["ir"],
                $row["inss"],
                $row["adicional"],
                $row["salarioliquido"],
                $row["mes"],
                $row["decimo"],
            );
            $user = new User(
                $row['NOME'],
                $row['EMAIL'],
                $row['TR_ID'],
                $row['CPF'],
                $row['SENHA'],
                
                $row['DATA_NASCIMENTO'],
                $row['DATA_ADMISSAO'],
             
                $row['TELEFONE'],
               
                $row['SEXO'],
                $salario
            );

            $user->setId($row['ID']);
            $user->setDeletedAt($row["DELETE_AT"]);
            $user->setGrupo($row["GRUPO"]);
            $users[] = $user;
        }

        echo "retorna os dados" . "\n";
        return $users;
    }
    public function getbyallon(int $min, int $max): array
    { // Seleciona todos os usuarios, ativados ou não
        $sql = "SELECT * FROM users u 
        INNER JOIN salario s ON u.SALARIO_ID = s.ID 
        WHERE u.DELETE_AT IS NULL AND u.ID BETWEEN :min AND :max";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':min' => $min, ':max' => $max]);
        echo "executa o sql" . "\n";
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "obtem os dados" . "\n";
        $users = [];
        foreach ($results as $row) {
            $salario = new Salario(
                $row["SALARIO_ID"],
                $row["salariobruto"],
                $row["ir"],
                $row["inss"],
                $row["adicional"],
                $row["salarioliquido"],
                $row["mes"],
                $row["decimo"],
            );
            $user = new User(
                $row['NOME'],
                $row['EMAIL'],
                $row['TR_ID'],
                $row['CPF'],
                $row['SENHA'],
                
                $row['DATA_NASCIMENTO'],
                $row['DATA_ADMISSAO'],
             
                $row['TELEFONE'],
               
                $row['SEXO'],
                $salario
            );

            $user->setId($row['ID']);
            $user->setDeletedAt($row["DELETE_AT"]);
            $user->setGrupo($row["GRUPO"]);
            $users[] = $user;
        }
        echo "retorna os dados" . "\n";
        return $users;    // Retornar o array de objetos User
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
