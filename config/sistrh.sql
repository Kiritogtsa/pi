-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 13/08/2024 às 01:06
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
-- Estrutura para tabela `salario`
--

CREATE TABLE `salario` (
  `ID` int(11) NOT NULL,
  `salariobruto` float DEFAULT NULL,
  `ir` float DEFAULT NULL,
  `inss` float DEFAULT NULL,
  `adicional` float DEFAULT NULL,
  `salarioliquido` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `salario`
--

INSERT INTO `salario` (`ID`, `salariobruto`, `ir`, `inss`, `adicional`, `salarioliquido`) VALUES
(1, 5000, 500, 400, 100, 4000),
(2, 1200, NULL, NULL, NULL, NULL);
--
-- Estrutura para tabela `trabalhos`
--

CREATE TABLE `trabalhos` (
  `ID` int(11) NOT NULL,
  `DESCRICAO` varchar(30) DEFAULT NULL,
  `NOME` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `trabalhos`
--

INSERT INTO `trabalhos` (`ID`, `DESCRICAO`, `NOME`) VALUES
(1, 'ajuda o gerente', 'gerente'),
(2, 'ajuda o gerente', 'auxiliar gerente'),
(3,"teste","teste");-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `NOME` varchar(50) DEFAULT NULL,
  `CPF` varchar(11) DEFAULT NULL,
  `EMAIL` varchar(50) DEFAULT NULL,
  `DATA_NASCIMENTO` date DEFAULT NULL,
  `TELEFONE` varchar(15) DEFAULT NULL,
  `DATA_ADMISSAO` date DEFAULT NULL,
  `SEXO` varchar(10) DEFAULT NULL,
  `SENHA` varchar(60) DEFAULT NULL,
  `GRUPO` varchar(12) DEFAULT NULL,
  `DELETE_AT` datetime DEFAULT NULL,
  `TR_ID` int(11) DEFAULT NULL,
  `SALARIO_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`ID`, `NOME`, `CPF`, `EMAIL`, `DATA_NASCIMENTO`, `TELEFONE`, `DATA_ADMISSAO`, `SEXO`, `SENHA`, `GRUPO`, `DELETE_AT`, `TR_ID`, `SALARIO_ID`) VALUES
(1, 'FULANO', '05346585498', 'MATHEUS@GMAIL.COM', '9999-05-24', '55981447752', '5555-09-24', 'MASCULINO', '$2y$10$yWbj3ojEM.BChIuHyiGwZe8EFfY/qDsPMhNCO5HS4jaTSCciHbhp2', 'gerente', NULL, 1, 1),
(2, 'teste1', '123', '', '2001-03-21', '213', '2001-03-21', 'masculino', '$2y$10$kxf4Z3vsQrWevLiLXTEUJeNNFVB15C7UYw4RSrJWYSOWt.kdVjFeq', 'auxiliar', '2024-08-04 20:10:38', 2, 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `salario`
--
ALTER TABLE `salario`
  ADD PRIMARY KEY (`ID`);

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
  ADD UNIQUE KEY `CPF` (`CPF`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD UNIQUE KEY `TELEFONE` (`TELEFONE`),
  ADD KEY `TR_ID` (`TR_ID`),
  ADD KEY `SALARIO_ID` (`SALARIO_ID`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `salario`
--
-- som colocar o proximo id
ALTER TABLE `salario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `trabalhos`
--
ALTER TABLE `trabalhos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`TR_ID`) REFERENCES `trabalhos` (`ID`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`SALARIO_ID`) REFERENCES `salario` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Inserção na tabela `salario`
INSERT INTO `salario` (`ID`, `salariobruto`, `ir`, `inss`, `adicional`, `salarioliquido`) VALUES
(1, 5000, 500, 400, 100, 4000),
(2, 1200, NULL, NULL, NULL, NULL),
(3, 2500, 250, 200, 50, 2000),
(4, 3200, 320, 256, 64, 2560),
(5, 4000, 400, 320, 80, 3200),
(6, 1500, 150, 120, 30, 1200),
(7, 3500, 350, 280, 70, 2800),
(8, 4500, 450, 360, 90, 3600),
(9, 2200, 220, 176, 44, 1760),
(10, 2800, 280, 224, 56, 2240);

-- Inserção na tabela `trabalhos`
INSERT INTO `trabalhos` (`ID`, `DESCRICAO`, `NOME`) VALUES
(1, 'ajuda o gerente', 'gerente'),
(2, 'ajuda o gerente', 'auxiliar gerente'),
(3, 'teste', 'teste'),
(4, 'responsável pelo suporte', 'suporte técnico'),
(5, 'gerencia projetos', 'gerente de projetos'),
(6, 'administra redes', 'administrador de redes'),
(7, 'analista de sistemas', 'analista de sistemas'),
(8, 'desenvolve software', 'desenvolvedor'),
(9, 'testa software', 'analista de testes'),
(10, 'gerencia TI', 'gerente de TI');

-- Inserção na tabela `users`
INSERT INTO `users` (`ID`, `NOME`, `CPF`, `EMAIL`, `DATA_NASCIMENTO`, `TELEFONE`, `DATA_ADMISSAO`, `SEXO`, `SENHA`, `GRUPO`, `DELETE_AT`, `TR_ID`, `SALARIO_ID`) VALUES
(1, 'FULANO', '05346585498', 'MATHEUS@GMAIL.COM', '9999-05-24', '55981447752', '5555-09-24', 'MASCULINO', '$2y$10$yWbj3ojEM.BChIuHyiGwZe8EFfY/qDsPMhNCO5HS4jaTSCciHbhp2', 'gerente', NULL, 1, 1),
(2, 'teste1', '123', '', '2001-03-21', '213', '2001-03-21', 'masculino', '$2y$10$kxf4Z3vsQrWevLiLXTEUJeNNFVB15C7UYw4RSrJWYSOWt.kdVjFeq', 'auxiliar', '2024-08-04 20:10:38', 2, 2),
(3, 'JOÃO SILVA', '00123456789', 'JOAO.SILVA@EMAIL.COM', '1995-07-15', '55912345678', '2020-01-10', 'MASCULINO', '$2y$10$L1r6HG7on4XXRMYzkdKco.', 'user', NULL, 3, 3),
(4, 'MARIA OLIVEIRA', '98765432100', 'MARIA.OLIVEIRA@EMAIL.COM', '1987-11-23', '55987654321', '2019-05-12', 'FEMININO', '$2y$10$abcdeFGHIJKLmnopQrstuv', 'gerente', NULL, 4, 4),
(5, 'CARLOS SANTOS', '12345678901', 'CARLOS.SANTOS@EMAIL.COM', '1990-02-18', '55876543210', '2018-07-24', 'MASCULINO', '$2y$10$UVWXYZ0123456789abcd', 'auxiliar', NULL, 5, 5),
(6, 'ANA PEREIRA', '23456789012', 'ANA.PEREIRA@EMAIL.COM', '1993-05-04', '55823456789', '2017-03-14', 'FEMININO', '$2y$10$mnopqRSTUVwxyzABcdef', 'user', NULL, 6, 6),
(7, 'PEDRO LIMA', '34567890123', 'PEDRO.LIMA@EMAIL.COM', '1992-10-19', '55765432109', '2021-08-09', 'MASCULINO', '$2y$10$hijklmNOPQRstuvWXyz01', 'gerente', NULL, 7, 7),
(8, 'JULIA COSTA', '45678901234', 'JULIA.COSTA@EMAIL.COM', '1985-01-12', '55654321098', '2016-06-21', 'FEMININO', '$2y$10$bcdefGHIJKLmnoPQRSTUV', 'auxiliar', NULL, 8, 8),
(9, 'ROBERTO ALVES', '56789012345', 'ROBERTO.ALVES@EMAIL.COM', '1998-12-03', '55543210987', '2022-11-15', 'MASCULINO', '$2y$10$WXYZabcdefGHIJKLMnopqr', 'user', NULL, 9, 9),
(10, 'LARISSA MENDES', '67890123456', 'LARISSA.MENDES@EMAIL.COM', '1996-09-27', '55432109876', '2020-09-05', 'FEMININO', '$2y$10$CDEFGHIJKLMNOPQRSTUV', 'gerente', NULL, 10, 10);
