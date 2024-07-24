-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/07/2024 às 02:22
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistrh`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `trabalhos`
--

CREATE TABLE `trabalhos` (
  `ID` int(11) NOT NULL,
  `DESCRICAO` varchar(30) DEFAULT NULL,
  `NOME` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--
CREATE TABLE salario(
        ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
        salariobruto FLOAT,
        ir  FLOAT,
        inss float,
        adicional float,
        salarioliquido float,
        mes int,
        decimo float,
        ano int
    ); 
CREATE TABLE `users` (
  `ID`    int(11) NOT NULL,
  `NOME`  varchar(50) ,
  `CPF`   varchar(11) UNIQUE,
  `EMAIL` varchar(50) UNIQUE,
  `DATA_NASCIMENTO` date NULL,
  `TELEFONE` varchar(15) UNIQUE,
  `DATA_ADMISSAO` date,
  `SEXO` varchar(10),
  `SENHA` varchar(60),
  `GRUPO` varchar(12), /* USADO PARA DEFINIR SE ELE PODE ACESSAR AS OUTRAS PÁGINAS ALÉM DA DELE*/
  `DELETE_AT`DATETIME,
  `TR_ID` int(11),
  `SALARIO_ID` int(11)/* DIZ O TRABALHO DO USUÁRIO*/
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `trabalhos`
--
ALTER TABLE `trabalhos`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `TR_ID` (`TR_ID`),
  add KEY `SALARIO_ID`;

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `trabalhos`
--
ALTER TABLE `trabalhos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`TR_ID`) REFERENCES `trabalhos` (`ID`);
  add CONSTRAINT `users_ibfk_1` foreion key (`SALARIO_ID`) REFERENCES `salario`(`ID`)
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

insert into trabalhos( DESCRICAO, NOME)
VALUES('ajuda o gerente','gerente');

insert into trabalhos( DESCRICAO, NOME)
VALUES('ajuda o gerente','axiliar gerente');

/* alter table trabalhos AUTO_INCREMENT=1;
 * delete from trabalhos ;
 * senha 123
 */

insert into users(NOME, CPF, EMAIL, DATA_NASCIMENTO, TELEFONE, DATA_ADMISSAO, SEXO,SENHA, GRUPO, TR_ID)
VALUES("FULANO","05346585498","MATHEUS@GMAIL.COM","24/05/9999", "55981447752","24/09/5555","MASCULINO","$2y$10$yWbj3ojEM.BChIuHyiGwZe8EFfY/qDsPMhNCO5HS4jaTSCciHbhp2","gerente",1);


delete  from users where id = 6;
