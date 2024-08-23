<?php
class Salario
{
    private $id;
    private $salariobruto;
    private $ir;
    private $inss;
    private $adicional;
    private $salarioliquido;

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
    public function descIR($salariobruto)
    {
        $adicional = $this->adicional;
        $salariobruto = $salariobruto + $adicional;
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
        $adicional = $this->adicional;
        $salariobruto = $salariobruto + $adicional;
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

    public function calcsalarLiquid($salariobruto, $ir, $inss, $adicional)
    {
        $salarioComAdicional = $salariobruto + $adicional;
        $salarioliquido = $salarioComAdicional - $ir - $inss;
        return $this->salarioliquido = $salarioliquido;
    }
}