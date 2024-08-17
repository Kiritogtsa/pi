<?php
// pesando melhor e melhor ter um crud bem basico aqui para separar reponsabiladade
class Salario
{
    private $id;
    private $salariobruto;
    private $ir;
    private $inss;
    private $adicional;
    private $salarioliquido;

    // neste construtor o usuário deve declarar o salariobruto e o adicional
    public function __construct($salariobruto, $adicional, $salarioliquido = 0, $ir = 0, $inss = 0)
    {
        if (empty($salariobruto)) {
            throw new Exception("Preencha todos os campos obrigatórios!");
        }
        $this->salariobruto = $salariobruto;
        $this->ir = $ir;
        $this->inss = $inss;
        $this->adicional = $adicional;
        $this->salarioliquido = $salarioliquido;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setSalariobruto($salariobruto)
    {
        $this->salariobruto = $salariobruto;
        return $this;
    }

    public function setIr($ir)
    {
        $this->ir = $ir;
        return $this;
    }

    public function setInss($inss)
    {
        $this->inss = $inss;
        return $this;
    }

    public function setAdicional($adicional)
    {
        $this->adicional = $adicional;
        return $this;
    }

    public function setSalarioliquido($salarioliquido)
    {
        $this->salarioliquido = $salarioliquido;
        return $this;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getSalariobruto()
    {
        return $this->salariobruto;
    }

    public function getIr()
    {
        return $this->ir;
    }

    public function getInss()
    {
        return $this->inss;
    }

    public function getAdicional()
    {
        return $this->adicional;
    }

    public function getSalarioliquido()
    {
        return $this->salarioliquido;
    }


    // Os três métodos tem que ser chamados
    // Os três métodos tem que ser chamados
    // Os três métodos tem que ser chamados
    // Os três métodos tem que ser chamados
    // Os três métodos tem que ser chamados
    // Os três métodos tem que ser chamados
    // Os três métodos tem que ser chamados
    public function descIR($salariobruto)
    {
        if ($salariobruto < 2259.20) {
            return $this->ir = 0;
        } else if ($salariobruto >= 2259.21 && $salariobruto <= 2826.65) {
            return $this->ir = $salariobruto * 0.075;
        } else if ($salariobruto >= 2826.66 && $salariobruto <= 3751.05) {
            return $this->ir = $salariobruto * 0.15;
        } else if ($salariobruto >= 3751.06 && $salariobruto <= 4664.68) {
            return $this->ir = $salariobruto * 0.225;
        } else if ($salariobruto > 4664.68) {
            return $this->ir = $salariobruto * 0.275;
        } else {
            throw new Exception("Salário bruto inválido!");
        }
    }
    public function descINSS($salariobruto)
    {
        if ($salariobruto <= 1412.00) {
            return $this->inss = $salariobruto * 0.075;
        } else if ($salariobruto >= 1412.01 && $salariobruto <= 2666.68) {
            return $this->inss = $salariobruto * 0.09;
        } else if ($salariobruto >= 2666.69 && $salariobruto <= 4000.03) {
            return $this->inss = $salariobruto * 0.12;
        } else if ($salariobruto >= 4000.04 && $salariobruto <= 7786.02) {
            return $this->inss = $salariobruto * 0.14;
        } else if ($salariobruto > 7786.02) {
            return $this->inss = 7786.02 * 0.14;
        } else {
            throw new Exception("Salário bruto inválido!");
        }
    }

    // Este é o último a ser chamado
    // Este é o último a ser chamado
    // Este é o último a ser chamado
    // Este é o último a ser chamado
    public function calcsalarLiquid($salariobruto, $ir, $inss, $adicional)
    {
        $salarioComAdicional = $salariobruto + ($salariobruto * ($adicional / 100));
        $salarioliquido = $salarioComAdicional - $ir - $inss;
        return $this->salarioliquido = $salarioliquido;
    }
}



// class SalarioDAO{
//     public function getsalarioid($id){ // Lista os salários pelo ID
//         $stmt_insert = $pdo->prepare("SELECT FROM salario WHERE id= :id");
//         $stmt_insert ->bindparam($id, ":id");
//         $stmt_insert -> execute();
//         $salarios= $stmt_insert->fetch(PDO::FETCH_ASSOC);
//         return $salarios;
//     }

//     public function nomefuncionario($nome){ // Busca o id do usuario para poder consultar depois na tabela salario os meses de salario
//         $stmt_insert = $pdo->prepare("SELECT id FROM user WHERE nome = :nome");
//         $stmt_insert ->bindparam($nome, ":nome");
//         $usersal = $stmt_insert -> execute();
//         return $usersal;
//     }
//     public function insertsalario(Salario $salario){ // usada para inserir novos salário para um usuário existente (procura o id pelo nomefuncionario para depois usar nesta função)
//         $stmt_insert = $pdo->prepare("INSERT INTO salario(id, salariobruto, ir, inss, adicional, salarioliquido, mes, decimo) VALUES(:id, :salariobruto,:ir,:inss,:adicional,:salarioliquido,:mes,:decimo,:ano)");
//         $id = $salario->getId();
//         $salariobruto = $salario->getSalariobruto();
//         $ir = $salario->getIr();
//         $inss = $salario->getInss();
//         $adicional = $salario->getAdicional();
//         $salarioliquido = $salario->getSalarioliquido();
//         $mes = $salario->getMes();
//         $decimo = $salario->getDecimo();
//         $ano = $salario->getAno();
//         $stmt_insert ->bindparam(':id', $id);
//         $stmt_insert ->bindparam(':salariobruto', $salariobruto);
//         $stmt_insert ->bindparam(':ir', $ir);
//         $stmt_insert ->bindparam(':inss', $inss);
//         $stmt_insert ->bindparam(':adicional', $adicional);
//         $stmt_insert ->bindparam(':salarioliquido', $salarioliquido);
//         $stmt_insert ->bindparam(':mes',$mes);
//         $stmt_insert ->bindparam(':decimo', $decimo);
//         $stmt_insert ->bindparam(':ano', $ano);
//         $stmt_insert ->execute();
//         return $salario;
//     }
// public function consultadecimo($id, $mes, $ano){ // Consulta para evitar inserção dupla do mesmo mês
//     $stmt_insert = $pdo->prepare("SELECT FROM trabalho WHERE id = :id AND $mes = :mes AND $ano = :ano");
//     $stmt_insert ->bindparam($id, ":id");
//     $stmt_insert ->bindparam($mes, ":mes");
//     $stmt_insert ->bindparam($ano, ":ano");
//     if($stmt_insert ->execute()){
//         return True;
//     }else{
//         return False;
//     }
// }
// }


// CREATE TABLE salario(
//     ID INT PRIMARY KEY NOT NULL,
//     FLOAT salariobruto,
//     FLOAT ir,
//     FLOAT inss,
//     FLOAT adicional,
//     FLOAT salarioliquido,
//     INT mes,
//     FLOAT decimo,
//     INT ano,
//     FOREIGN KEY (id) REFERENCES user (id);
// )
