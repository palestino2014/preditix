-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 14-Jan-2024 às 19:24
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
-- Estrutura da tabela `ativo_embarcacao`
--

CREATE TABLE `ativo_embarcacao` (
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
-- Extraindo dados da tabela `ativo_embarcacao`
--

INSERT INTO `ativo_embarcacao` (`id`, `tipo_embarcacao`, `num_inscricao`, `fabricante`, `armador`, `ano_fabricacao`, `capacidade_volumetrica`, `foto`) VALUES
(1, 'ferryboat', '014.112.991-32', '1985', 'Gustavo Lemes LTDA', 2005, 222, '416457550_778141584114395_1375641987417283047_n.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ativo_implemento`
--

CREATE TABLE `ativo_implemento` (
  `id` int(11) NOT NULL,
  `tipo_implemento` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `placa` varchar(15) DEFAULT NULL,
  `fabricante` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `ano_fabricao` int(11) DEFAULT NULL,
  `chassis` varchar(255) DEFAULT NULL,
  `renavam` varchar(20) DEFAULT NULL,
  `proprietario` varchar(255) DEFAULT NULL,
  `tara` int(11) DEFAULT NULL,
  `lotacao` int(11) DEFAULT NULL,
  `PTB` int(11) DEFAULT NULL,
  `PBTC` int(11) DEFAULT NULL,
  `capacidadeMaxTracao` int(11) DEFAULT NULL,
  `capacidadeVolumetrica` int(11) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ativo_implemento`
--

INSERT INTO `ativo_implemento` (`id`, `tipo_implemento`, `tag`, `placa`, `fabricante`, `modelo`, `ano_fabricao`, `chassis`, `renavam`, `proprietario`, `tara`, `lotacao`, `PTB`, `PBTC`, `capacidadeMaxTracao`, `capacidadeVolumetrica`, `cor`, `foto`) VALUES
(1, 'tanqueSemiReboque5eixos', 'TTPPEE', 'xxx-6565-0000', 'volvo', '34TBC', 2024, '333344445555', '4423423423', 'Gustavo Lemes', 120, 12, 1299, 150, NULL, 20, 'branca ', '81R-zMnuHHL._AC_UF894,1000_QL80_.jpg'),
(2, 'tanqueSemiReboque5eixos', 'TTPPEE', 'xxx-6565-0000', 'volvo', '34TBC', 2024, '333344445555', '4423423423', 'Gustavo Lemes', 120, 12, 1299, 150, NULL, 20, 'branca ', '81R-zMnuHHL._AC_UF894,1000_QL80_.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ativo_tanque`
--

CREATE TABLE `ativo_tanque` (
  `id` int(11) NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `fabricante` varchar(255) DEFAULT NULL,
  `anoFabricacao` varchar(11) DEFAULT NULL,
  `localizacao` varchar(140) DEFAULT NULL,
  `capacidadeVolumetrica` varchar(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ativo_tanque`
--

INSERT INTO `ativo_tanque` (`id`, `tag`, `fabricante`, `anoFabricacao`, `localizacao`, `capacidadeVolumetrica`, `foto`) VALUES
(1, 'externo', 'Metalmar', '2004', 'Belém - PA', '80', 'Captura de tela de 2023-12-26 21-06-26.png'),
(2, 'externo', 'Metalmar', '2004', 'Belém - PA', '80', 'Captura de tela de 2023-12-26 21-06-26.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ativo_veiculo`
--

CREATE TABLE `ativo_veiculo` (
  `id` int(11) NOT NULL,
  `tipo_veiculo` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `placa` varchar(15) DEFAULT NULL,
  `fabricante` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `ano_fabricacao` varchar(110) DEFAULT NULL,
  `chassis` varchar(255) DEFAULT NULL,
  `renavam` varchar(20) DEFAULT NULL,
  `proprietario` varchar(255) DEFAULT NULL,
  `tara` int(11) DEFAULT NULL,
  `lotacao` int(11) DEFAULT NULL,
  `PTB` int(11) DEFAULT NULL,
  `PBTC` int(11) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ativo_veiculo`
--

INSERT INTO `ativo_veiculo` (`id`, `tipo_veiculo`, `tag`, `placa`, `fabricante`, `modelo`, `ano_fabricacao`, `chassis`, `renavam`, `proprietario`, `tara`, `lotacao`, `PTB`, `PBTC`, `cor`, `foto`) VALUES
(1, 'caminhaoTocoComBau', '789GHG', 'xxx-444-555', 'Volvo', '190M', '2017', '444444444ggggggghhhhh', '66655544433221', 'Santos Dumond ', 100, 3, 3500, 6000, 'verde', 'Captura de tela de 2024-01-09 20-11-41.png'),
(2, 'caminhaoTocoComBau', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(3, 'caminhaoTocoComBau', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(4, 'caminhaoTocoComBau', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(5, 'VeiculoLeveAdm', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(6, 'VeiculoLeveAdm', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(7, 'VeiculoLeveAdm', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(8, 'caminhaoTocoComBau', '789GHG', 'AB90393OF', 'oookkkooolll', '190M', NULL, '444444444ggggggghhhhh', '66655544433221', 'Santos Dumond', 100, 3, 3500, 6000, 'blol', '68810235_2906696346071195_215575450947158016_n.jpg'),
(9, 'caminhaoTocoComBau', '789GHG', 'AB90393OF', 'oookkkooolll', '190M', NULL, '444444444ggggggghhhhh', '66655544433221', 'Santos Dumond', 100, 3, 3500, 6000, 'blol', '68810235_2906696346071195_215575450947158016_n.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `ativo_embarcacao`
--
ALTER TABLE `ativo_embarcacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `ativo_implemento`
--
ALTER TABLE `ativo_implemento`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `ativo_tanque`
--
ALTER TABLE `ativo_tanque`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `ativo_veiculo`
--
ALTER TABLE `ativo_veiculo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ativo_embarcacao`
--
ALTER TABLE `ativo_embarcacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `ativo_implemento`
--
ALTER TABLE `ativo_implemento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `ativo_tanque`
--
ALTER TABLE `ativo_tanque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `ativo_veiculo`
--
ALTER TABLE `ativo_veiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
