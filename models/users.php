<?php
// testar o codigo e corrigir erros aqui e na mains
// criar yma uma tabela para endereço, fazer o dao dela tb
require_once("salario.php");
// add functions for crud from salarios
// vai ser bem simples essa parte, mais primeiro quero verificar algumas outras coisas de fazer essa parte
class endereco {}
interface crudendereco {}
abstract class enderecoa {}
class enderecodao extends enderecoa {}


// so fiz isso pq sim, tava etediado com o jeito normal
interface crud
{
    public function persit(user $user): user;
    public function getbyemail(string $email): user;
    public function getbyName(string $nome): User;
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
// so fiz isso pq sim, tava etediado com o jeito normal
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
        // if (empty($nome) || empty($email) || empty($senha) || empty($dataNascimento) || empty($dataAdmissao) || empty($telefone) || empty($sexo) || empty($trabalho) ) {
        //     throw new Exception("Está faltando um dado");
        // }

        // if (($msg = $this->validarCampos($nome, $email, $trabalho, $cpf, $senha, $sexo)) != true) {
        //     throw new Exception($msg);
        // }

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
    public function getissalario(): Salario
    {
        return $this->salario;
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
    public function setSalario(salario $salario)
    {
        $this->salario = $salario;
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
        return $this->salario->calcsalarLiquid($this->salario->getSalarioBruto(), $this->salario->getIr(), $this->salario->getInss(), $this->salario->getAdicional());
    }
}


// define a classe que trabalha com a tabela relacionada ao usuario
class UserDAO implements crud
{
    public $conn;
    // o contrutor seta a conn para receber a conexao do banco de dados
    function __construct()
    {
        require_once("../config/db.php");
        $this->conn = $pdo;
    }

    // cria um usuario, ele recebe um usuario e volta o usuario ja com o id do banco de dados
    private function insert(User $user): User
    {
        $this->conn->beginTransaction();
        $result = $this->insertsalario($user->getslario());
        if ($result == false) {
            throw new Exception("deu um erro ao criar o salario");
        }

        $grupo = $user->getGrupo() == "" ? "user" : $user->getGrupo();
        var_dump($grupo);
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
        $user->setId($this->conn->lastInsertId());
        $this->conn->commit();
        return $user;
    }
    // adiciona o salario, a gente pode adicionar mais coisas aqui, ou a gente nao precisa salvar algumas
    // por que, aluns atributos sao o que o chefe da
    // dai a gente pode ver esse tipo de atibutos, ja que e por mes
    // se quiserem ou a gente pode deixar mais padrao  e deixar so um valor 
    // ces que sabem
    private function insertsalario(Salario $salario): int
    {  //`salariobruto` float DEFAULT NULL,
        //   `ir` float DEFAULT NULL,
        //   `inss` float DEFAULT NULL,
        //   `adicional` float DEFAULT NULL,
        //   `salarioliquido` float DEFAULT NULL
        // )

        $bruto = $salario->getSalariobruto();
        $ir = $salario->descIR($bruto);
        $inss = $salario->descINSS($bruto);
        $liquido = $salario->calcsalarLiquid($bruto, $ir, $inss, 1);
        $adicional = $salario->getAdicional();
        $sql = "insert into salario(salariobruto,ir,inss,adicional,salarioliquido) values(:salariobruto,:ir,:inss,:adicional,:salarioliquido)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":salariobruto", $bruto);
        $stmt->bindParam(":ir", $ir);
        $stmt->bindParam(":inss", $inss);
        $stmt->bindParam(":salarioliquido", $liquido);
        $stmt->bindParam(":adicional", $adicional);
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
        $result = $this->insertsalario($user->getslario());
        if ($result == false) {
            throw new Exception("deu um erro ao criar o salario");
        }
        $sql = "insert into users(NOME,EMAIL,SENHA,TELEFONE,DATA_NASCIMENTO,DATA_ADMISSAO,SEXO,CPF,tr_id,GRUPO,SALARIO_ID) values(:nome,:email,:senha,:telefone,:data_nas,:data_ad,:sexo,:cpf,:tr_id,:grupo,:salario)";
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
        $stmt->bindParam(":salario", $result);
        $stmt->execute();
        $user->setId($this->conn->lastInsertId());
        return $user;
    }
    private function updatesalario(Salario $salario): Salario
    {
        $sql = "UPDATE salario SET salariobruto=:bruto,ir=:ir,inss=:inss,adicional=:adicional,salarioliquido=:liquido WHERE ID=:id";
        $id = $salario->getId();
        $bruto = $salario->getSalariobruto();
        $ir = $salario->getIr();
        $inss = $salario->getInss();
        $adicional = $salario->getAdicional();
        $stmt =  $this->conn->prepare($sql);
        $salario->calcsalarLiquid($bruto, $ir, $inss, $adicional);
        $liquido = $salario->getSalarioliquido();
        $stmt->bindParam(":bruto", $bruto);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":ir", $ir);
        $stmt->bindParam(":inss", $inss);
        $stmt->bindParam(":adicional", $adicional);
        $stmt->bindParam(":liquido", $liquido);
        $stmt->execute();
        return $salario;
    }
    // ele atualiza um usuario
    private function update(User $user): User
    {
        $this->conn->beginTransaction();
        $this->updatesalario($user->getissalario());
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
        $salario = $user->getslario()->getId();
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":sexo", $sexo);
        $stmt->bindParam(":data_ad", $data_adimisao);
        $stmt->bindParam(":salarioid", $salario);
        $stmt->execute();
        $this->conn->commit();
        return $user;
    }

    // a funçao que decide qual metodo e chamado
    public function persit(User $user): User
    { 
        if (!$user->getId()) {
            return $this->insert($user);
        } else {
            return $this->update($user);
        }
    }

    // obtem uma instancia de User com base no email fonercido
    // getbyName
    public function getbyName($nome): User
    {
        $sql = "SELECT * FROM users u inner join salario s on u.SALARIO_ID = s.ID WHERE NOME = :nome";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            throw new Exception("Usuário não encontrado com o nome: " . $nome);
        }

        $salario = new Salario(
            $dados["salariobruto"],
            $dados["adicional"],
            $dados["salarioliquido"],
            $dados["ir"],
            $dados["inss"],
        );
        $salario->setId($dados["SALARIO_ID"]);


        $user = new User($dados["NOME"], $dados["EMAIL"], $dados["TR_ID"], $dados["CPF"], $dados["SENHA"], $dados["DATA_NASCIMENTO"], $dados["DATA_ADMISSAO"], $dados["TELEFONE"], $dados["SEXO"], $salario);
        $user->setId($dados["ID"]);
        $user->setDeletedAt($dados["DELETE_AT"]);
        $user->setGrupo($dados["GRUPO"]);
        return $user;
    }
    public function getByEmail($email): User
    {
        // deois de confimar como vamo fazer o sql adicionar aqui o salario
        $sql = "SELECT * FROM users u inner join salario s on u.SALARIO_ID = s.ID WHERE EMAIL = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            throw new Exception("Usuário não encontrado com o email: " . $email);
        }
        $salario = new Salario(
            $dados["salariobruto"],
            $dados["adicional"],
            $dados["salarioliquido"],
            $dados["ir"],
            $dados["inss"],
        );
        $salario->setId($dados["SALARIO_ID"]);
        $user = new User($dados["NOME"], $dados["EMAIL"], $dados["TR_ID"], $dados["CPF"], $dados["SENHA"], $dados["DATA_NASCIMENTO"], $dados["DATA_ADMISSAO"], $dados["TELEFONE"], $dados["SEXO"], $salario);
        $user->setId($dados["ID"]);
        $user->setDeletedAt($dados["DELETE_AT"]);
        $user->setGrupo($dados["GRUPO"]);
        return $user;
    }
    // ele desativa o usuario
    public function delete($id): bool
    {
        try {
            // foi corrigindo o sql
            $this->conn->beginTransaction();
            $sql = "UPDATE users SET DELETE_AT = NOW() WHERE ID = :id";
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

    // ele ativa o usuario denovo
    public function aiivacao($id): bool
    {
        try {
            echo "vem";
            // foi corrigindo o sql
            $this->conn->beginTransaction();
            $sql = "UPDATE users SET DELETE_AT = null WHERE ID = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $result = $stmt->execute();
            $this->conn->commit();
            echo "aqui";
            return $result;
        } catch (Exception $e) {
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
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($results as $row) {
            $salario = new Salario(
                $row["salariobruto"],
                $row["adicional"],
                $row["salarioliquido"],
                $row["ir"],
                $row["inss"],
            );
            $salario->setId($row["SALARIO_ID"]);
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
        return $users;
    }
    public function getbyallon(int $min, int $max): array
    { // Seleciona todos os usuarios, ativados ou não
        $sql = "SELECT * FROM users u 
        INNER JOIN salario s ON u.SALARIO_ID = s.ID 
        WHERE u.DELETE_AT IS NULL AND u.ID BETWEEN :min AND :max";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':min' => $min, ':max' => $max]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($results as $row) {
            $salario = new Salario(
                $row["salariobruto"],
                $row["adicional"],
                $row["salarioliquido"],
                $row["ir"],
                $row["inss"],
            );
            $salario->setId($row["SALARIO_ID"]);
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
        return $users;   
    }
}
