-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 06/08/2024 às 01:22
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12
setsql_mode = "NO_AUTO_VALUE_ON_ZERO";
starttransaction;
settime_zone = "+00:00";
/* !40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/* !40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/* !40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/* !40101 SET NAMES utf8mb4 */;
--
-- Banco de dados: `sistrh`
--
-- --------------------------------------------------------
--
-- Estrutura para tabela `salario`
--
createtable `salario`(
`ID`INT(11) notnull,
`salariobruto` floatdefaultnull,
`ir` floatdefaultnull,
`inss` floatdefaultnull,
`adicional` floatdefaultnull,
`salarioliquido` floatdefaultnull
)engine = innodbdefaultcharset=utf8mb4collate = utf8mb4_general_ci;
--
-- Despejando dados para a tabela `salario`
--
INSERT INTO `salario`(
`ID`,
`salariobruto`,
`ir`,
`inss`,
`adicional`,
`salarioliquido`,
`mes`,
`decimo`,
`ano`
)
VALUES(
1,
5000,
500,
400,
100,
4000,
6,
500,
2024
),
(
2,
1200,
NULL,
NULL,
NULL,
NULL,
8,
NULL,
NULL
),
(
3,
1200,
NULL,
NULL,
NULL,
NULL,
8,
NULL,
NULL
),
(
4,
1200,
NULL,
NULL,
NULL,
NULL,
8,
NULL,
NULL
),
(
5,
1200,
NULL,
NULL,
NULL,
NULL,
8,
NULL,
NULL
),
(
13,
1200,
NULL,
NULL,
NULL,
NULL,
8,
NULL,
NULL
),
(
15,
1200,
NULL,
NULL,
NULL,
NULL,
8,
NULL,
NULL
),
(
26,
1200,
NULL,
NULL,
NULL,
NULL,
8,
NULL,
NULL
);
-- --------------------------------------------------------
--
-- Estrutura para tabela `trabalhos`
--
createtable `trabalhos`(
`ID`INT(11) notnull,
`DESCRICAO`VARCHAR(30) defaultnull,
`NOME` textdefaultnull
)engine = innodbdefaultcharset=utf8mb4collate = utf8mb4_general_ci;
--
-- Despejando dados para a tabela `trabalhos`
--
INSERT INTO `trabalhos`(
`ID`,
`DESCRICAO`,
`NOME`
)
VALUES(
1,
'ajuda o gerente',
'gerente'
),
(
2,
'ajuda o gerente',
'auxiliar gerente'
),
(
3,
'teste1',
'teste'
);
-- --------------------------------------------------------
--
-- Estrutura para tabela `users`
--
createtable `users`(
`ID`INT(11) notnull,
`NOME`VARCHAR(50) defaultnull,
`CPF`VARCHAR(11) defaultnull,
`EMAIL`VARCHAR(50) defaultnull,
`DATA_NASCIMENTO` datedefaultnull,
`TELEFONE`VARCHAR(15) defaultnull,
`DATA_ADMISSAO` datedefaultnull,
`SEXO`VARCHAR(10) defaultnull,
`SENHA`VARCHAR(60) defaultnull,
`GRUPO`VARCHAR(12) defaultnull,
`DELETE_AT` datetimedefaultnull,
`TR_ID`INT(11) defaultnull,
`SALARIO_ID`INT(11) defaultnull
)engine = innodbdefaultcharset=utf8mb4collate = utf8mb4_general_ci;
--
-- Despejando dados para a tabela `users`
--
INSERT INTO `users`(
`ID`,
`NOME`,
`CPF`,
`EMAIL`,
`DATA_NASCIMENTO`,
`TELEFONE`,
`DATA_ADMISSAO`,
`SEXO`,
`SENHA`,
`GRUPO`,
`DELETE_AT`,
`TR_ID`,
`SALARIO_ID`
)
VALUES(
1,
'FULANO',
'05346585498',
'MATHEUS@GMAIL.COM',
'9999-05-24',
'55981447752',
'5555-09-24',
'MASCULINO',
'$2y$10$yWbj3ojEM.BChIuHyiGwZe8EFfY/qDsPMhNCO5HS4jaTSCciHbhp2',
'gerente',
NULL,
1,
1
),
(
4,
'teste1',
'123',
'',
'2001-03-21',
'213',
'2001-03-21',
'masculino',
'$2y$10$kxf4Z3vsQrWevLiLXTEUJeNNFVB15C7UYw4RSrJWYSOWt.kdVjFeq',
'auxiliar',
'2024-08-04 20:10:38',
2,
3
),
(
13,
'teste12',
'1233',
'teste@123',
'2001-03-21',
'2133',
'2001-03-21',
'masculino',
'$2y$10$O3YpBG2TiUxPwy6Y7/jW3uTQeEc3xri6dFhcvjegCywhJ7bC8dZum',
'user',
NULL,
3,
13
),
(
15,
'2teste12',
'12332',
'teste@1232',
'2001-03-21',
'21331',
'2001-03-21',
'masculino',
'$2y$10$ia4B/osduyZiuw9RUUvEhOKJSzcKs5wQjNLBRoENUGuwI4ulvLon.',
'user',
NULL,
3,
15
),
(
26,
'2teste12',
'112332',
'teste@12321',
'2001-03-21',
'213311',
'2001-03-21',
'masculino',
'$2y$10$HpQyXnkuZpG2KDC1.pcageM0ELrXXym8eymPus4OpwvgrR.kce3rq',
'user',
NULL,
3,
26
);
--
-- Índices para tabelas despejadas
--
--
-- Índices de tabela `salario`
--
altertable `salario`addprimarykey(
`ID`
);
--
-- Índices de tabela `trabalhos`
--
altertable `trabalhos`addprimarykey(
`ID`
);
--
-- Índices de tabela `users`
--
altertable `users`addprimarykey(
`ID`
),
adduniquekey `CPF`(
`CPF`
),
adduniquekey `EMAIL`(
`EMAIL`
),
adduniquekey `TELEFONE`(
`TELEFONE`
),
addkey `TR_ID`(
`TR_ID`
),
addkey `SALARIO_ID`(
`SALARIO_ID`
);
--
-- AUTO_INCREMENT para tabelas despejadas
--
--
-- AUTO_INCREMENT de tabela `salario`
--
altertable `salario`modify `ID`INT(11) notnullauto_increment,
auto_increment = 27;
--
-- AUTO_INCREMENT de tabela `trabalhos`
--
altertable `trabalhos`modify `ID`INT(11) notnullauto_increment,
auto_increment = 4;
--
-- AUTO_INCREMENT de tabela `users`
--
altertable `users`modify `ID`INT(11) notnullauto_increment,
auto_increment = 27;
--
-- Restrições para tabelas despejadas
--
--
-- Restrições para tabelas `users`
--
altertable `users`addconstraint `users_ibfk_1`foreignkey(
`TR_ID`
)REFERENCES`trabalhos`(
`ID`
),
addconstraint `users_ibfk_2`foreignkey(
`SALARIO_ID`
)REFERENCES`salario`(
`ID`
);
COMMIT;
/* !40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/* !40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/* !40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
