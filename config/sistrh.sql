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
(2, 1200, NULL, NULL, NULL, NULL),
(3, 1200, NULL, NULL, NULL, NULL),
(4, 1200, NULL, NULL, NULL, NULL),
(5, 1200, NULL, NULL, NULL, NULL),
(13, 1200, NULL, NULL, NULL, NULL),
(15, 1200, NULL, NULL, NULL, NULL),
(26, 1200, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

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
(3, 'teste1', 'teste');

-- --------------------------------------------------------

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
(4, 'teste1', '123', '', '2001-03-21', '213', '2001-03-21', 'masculino', '$2y$10$kxf4Z3vsQrWevLiLXTEUJeNNFVB15C7UYw4RSrJWYSOWt.kdVjFeq', 'auxiliar', '2024-08-04 20:10:38', 2, 3),
(13, 'teste12', '1233', 'teste@123', '2001-03-21', '2133', '2001-03-21', 'masculino', '$2y$10$O3YpBG2TiUxPwy6Y7/jW3uTQeEc3xri6dFhcvjegCywhJ7bC8dZum', 'user', NULL, 3, 13),
(15, '2teste12', '12332', 'teste@1232', '2001-03-21', '21331', '2001-03-21', 'masculino', '$2y$10$ia4B/osduyZiuw9RUUvEhOKJSzcKs5wQjNLBRoENUGuwI4ulvLon.', 'user', NULL, 3, 15),
(26, '2teste12', '112332', 'teste@12321', '2001-03-21', '213311', '2001-03-21', 'masculino', '$2y$10$HpQyXnkuZpG2KDC1.pcageM0ELrXXym8eymPus4OpwvgrR.kce3rq', 'user', NULL, 3, 26);

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
ALTER TABLE `salario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `trabalhos`
--
ALTER TABLE `trabalhos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`TR_ID`) REFERENCES `trabalhos` (`ID`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`SALARIO_ID`) REFERENCES `salario` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
