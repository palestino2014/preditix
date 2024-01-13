-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 13-Jan-2024 às 13:47
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `manutencao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ativo_caminhao`
--

CREATE TABLE `ativo_caminhao` (
  `id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `fabricante` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `ano_fabricacao` date DEFAULT NULL,
  `chassis` varchar(255) NOT NULL,
  `renavam` varchar(255) NOT NULL,
  `cor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ativo_caminhao`
--

INSERT INTO `ativo_caminhao` (`id`, `foto`, `placa`, `fabricante`, `modelo`, `ano_fabricacao`, `chassis`, `renavam`, `cor`) VALUES
(1, 'Captura de tela de 2024-01-05 10-27-16.png', 'wwweeeerrrr', 'volvo', 'SW4', NULL, '234234werwerwfsdfsdfs', '3333444433334444', 'branco'),
(2, 'Captura de tela de 2024-01-05 10-27-16.png', 'wwweeeerrrr', 'volvo', 'SW4', NULL, '234234werwerwfsdfsdfs', '3333444433334444', 'branco');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ativo_tanque`
--

CREATE TABLE `ativo_tanque` (
  `id` int(11) NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `fabricante` varchar(255) DEFAULT NULL,
  `anoFabricacao` int(11) DEFAULT NULL,
  `capacidadeVolumetrica` varchar(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ativo_tanque`
--

INSERT INTO `ativo_tanque` (`id`, `tag`, `fabricante`, `anoFabricacao`, `capacidadeVolumetrica`, `foto`) VALUES
(1, '111', 'volvo', 5555, '', '416457550_778141584114395_1375641987417283047_n.jpg'),
(2, '111', 'volvo', 5555, '', '416457550_778141584114395_1375641987417283047_n.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `embarcacao`
--

CREATE TABLE `embarcacao` (
  `id` int(11) NOT NULL,
  `tipo_embarcacao` varchar(50) DEFAULT NULL,
  `num_inscricao` varchar(20) DEFAULT NULL,
  `fabricante` varchar(255) DEFAULT NULL,
  `armador` varchar(255) DEFAULT NULL,
  `ano_fabricacao` int(11) DEFAULT NULL,
  `capacidade_volumetrica` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `embarcacao`
--

INSERT INTO `embarcacao` (`id`, `tipo_embarcacao`, `num_inscricao`, `fabricante`, `armador`, `ano_fabricacao`, `capacidade_volumetrica`, `foto`) VALUES
(1, NULL, NULL, 'Cumis ', 'AP Marine ', NULL, NULL, 'WhatsApp Image 2024-01-09 at 18.04.42.jpeg'),
(2, NULL, NULL, 'Cumis ', 'AP Marine ', NULL, NULL, 'WhatsApp Image 2024-01-09 at 18.04.42.jpeg'),
(3, NULL, NULL, 'volvo', 'AP Marine ', NULL, NULL, '4c6e292df945a64ea23cbffdab0882ba5602a936.webp'),
(4, NULL, NULL, 'volvo', 'AP Marine ', NULL, NULL, '4c6e292df945a64ea23cbffdab0882ba5602a936.webp'),
(5, NULL, NULL, 'volvo', 'AP Marine ', NULL, NULL, 'Captura de tela de 2024-01-09 20-11-48.png'),
(6, NULL, NULL, 'volvo', 'AP Marine ', NULL, NULL, 'Captura de tela de 2024-01-09 20-11-48.png'),
(7, NULL, NULL, 'Cumis ', 'AP Marine ', 333333, 3333, 'Captura de tela de 2023-10-22 07-48-30.png'),
(8, NULL, NULL, 'Cumis ', 'AP Marine ', 333333, 3333, 'Captura de tela de 2023-10-22 07-48-30.png'),
(9, NULL, NULL, 'Cumis ', 'AP Marine ', 333333, 3333, 'Captura de tela de 2023-10-22 07-48-30.png'),
(10, 'barco', '2222', 'Cumis ', 'AP Marine ', 11111, 123, '416457550_778141584114395_1375641987417283047_n.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `ativo_caminhao`
--
ALTER TABLE `ativo_caminhao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `ativo_tanque`
--
ALTER TABLE `ativo_tanque`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `embarcacao`
--
ALTER TABLE `embarcacao`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ativo_caminhao`
--
ALTER TABLE `ativo_caminhao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `ativo_tanque`
--
ALTER TABLE `ativo_tanque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `embarcacao`
--
ALTER TABLE `embarcacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
