<?php
interface crud{
    // Local onde vai ser criado o CRUD básico, ou seja, cria contrato com a classe que implementa a interface, insere, atualiza e desativa o usuário. Estar funções são necessárias 
    // nas outras classes  
    function insert();
}

class  teste implements crud{ 
    function insert()
    {
        
    }
    function __construct()
    {
        
    }
}
class outraclasse implements crud{
    function insert()
    {
        
    }
}
