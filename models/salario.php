<?php
class Salario {
    private $id;
    private $salariobruto;
    private $ir;
    private $inss;
    private $adicional;
    private $salarioliquido;
    private $mes;
    private $ano;
    private $decimo;

    public function __construct($id, $salariobruto, $ir = 0, $inss = 0, $adicional = 0, $salarioliquido = 0, $mes, $decimo = 1)
    {
        if (empty($id) || empty($salariobruto) || empty($mes)) {
            throw new Exception("Preencha todos os campos obrigatórios!");
        }
        if ($mes < 1 || $mes > 12) {
            throw new Exception("Mês inválido!");
        }
        if ($mes == 7 || $mes == 12){
            $decimo = 0.5;
        }
        $this->id = $id;
        $this->salariobruto = $salariobruto;
        $this->ir = $ir;
        $this->inss = $inss;
        $this->adicional = $adicional;
        $this->salarioliquido = $salarioliquido;
        $this->mes = $mes;
        $this->decimo = $decimo;

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

    public function setMes($mes)
    {
        $this->mes = $mes;
        return $this;
    }

    public function setDecimo($decimo)
    {
        $this->decimo = $decimo;
        return $this;
    }

    public function setAno($ano): self
    {
        $this->ano = $ano;

        return $this;
    }


    public function getDecimo()
    {
        return $this->decimo;
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

    public function getMes()
    {
        return $this->mes;
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function descIR($salariobruto, $mes, $decimo) {
        if($mes == 7 || $mes == 12){
            $salariobruto = $salariobruto * $decimo;
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
        }else{
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
    }
    public function descINSS($salariobruto, $decimo, $mes) {
        if($mes == 7 || $mes == 12){
            $salariobruto = $salariobruto * $decimo;
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
    }else{
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
}
    public function calcsalarLiquid($salariobruto, $ir, $inss, $adicional, $mes) {
    $salarioComAdicional = $salariobruto + ($salariobruto * ($adicional / 100));
    if ($mes == 7 || $mes == 12) {
         $salarioComAdicional += $salariobruto * $this->decimo;
        }
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
?>
