-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 30-Jan-2024 às 23:51
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
  `tag` varchar(150) NOT NULL,
  `num_inscricao` varchar(20) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `armador` varchar(255) DEFAULT NULL,
  `ano_fabricacao` int(11) DEFAULT NULL,
  `capacidade_volumetrica` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ativo_embarcacao`
--

INSERT INTO `ativo_embarcacao` (`id`, `tipo_embarcacao`, `tag`, `num_inscricao`, `nome`, `armador`, `ano_fabricacao`, `capacidade_volumetrica`, `foto`) VALUES
(1, 'ferryboat', '', '014.112.991-32', '1985', 'Gustavo Lemes LTDA', 2005, 222, '416457550_778141584114395_1375641987417283047_n.jpg'),
(2, 'balsaSimples', '', '123000', 'Cumis ', 'Ap Marine ', 2000, 850, 'Captura de tela de 2024-01-16 09-53-33.png'),
(3, 'balsaSimples', '', '123000', 'Cumis ', 'Ap Marine ', 2000, 850, 'Captura de tela de 2024-01-16 09-53-33.png'),
(4, 'balsaMotorizada', '', '123000', 'Cumis ', 'Ap Marine ', 2000, 850, 'Captura de tela de 2024-01-16 09-53-33.png'),
(5, 'balsa simples', '', 'Cumis ', 'Ap Marine ', 'Maritimos ', 850, 333, 'Captura de tela de 2024-01-16 10-17-28.png'),
(6, 'balsa simples', '', 'Cumis ', 'Ap Marine ', 'Maritimos ', 850, 333, 'Captura de tela de 2024-01-16 10-17-28.png'),
(7, 'balsa simples', '123000', 'Cumis ', 'Ap Marine ', 'Maritimos ', 850, 333, 'Captura de tela de 2024-01-16 10-17-28.png'),
(8, 'empurrador', '123000', 'Cumis ', 'Ap Marine ', 'Maritimos ', 850, 333, 'Captura de tela de 2024-01-16 10-17-28.png'),
(9, 'balsa motorizada', '123000', 'Cumis ', 'Ap Marine ', 'Maritimos ', 850, 333, 'Captura de tela de 2024-01-16 10-17-28.png'),
(10, 'balsa simples', '123000', 'Cumis ', 'Ap Marine ', 'Maritimos ', 850, 333, 'Captura de tela de 2024-01-16 10-17-28.png'),
(11, 'balsa simples', '123000', 'Cumis ', 'Ap Marine ', 'Maritimos ', 850, 333, 'Captura de tela de 2024-01-16 10-17-28.png'),
(12, 'balsa simples', '123000', 'Cumis ', 'Fé em Deus ', 'Maritimos ', 850, 333, 'Captura de tela de 2024-01-16 10-17-28.png'),
(13, 'balsa simples', '123000', 'Cumis ', 'Fé em Deus ', 'Maritimos ', 850, 333, 'Captura de tela de 2024-01-16 10-17-28.png'),
(14, 'balsa motorizada', '123000', 'Cumis ', 'Fé em Deus ', 'Maritimos ', 850, 333, 'Captura de tela de 2024-01-16 10-17-28.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ativo_implemento`
--

CREATE TABLE `ativo_implemento` (
  `id` int(11) NOT NULL,
  `tipo_implemento` varchar(255) DEFAULT NULL,
  `vincular` varchar(250) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `placa` varchar(15) DEFAULT NULL,
  `fabricante` varchar(255) DEFAULT NULL,
  `modelo` varchar(255) DEFAULT NULL,
  `ano_fabricao` varchar(150) DEFAULT NULL,
  `chassis` varchar(255) DEFAULT NULL,
  `renavam` varchar(20) DEFAULT NULL,
  `proprietario` varchar(255) DEFAULT NULL,
  `tara` int(11) DEFAULT NULL,
  `lotacao` int(11) DEFAULT NULL,
  `PTB` int(11) DEFAULT NULL,
  `capacidadeMaxTracao` int(11) DEFAULT NULL,
  `capacidadeVolumetrica` int(11) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ativo_implemento`
--

INSERT INTO `ativo_implemento` (`id`, `tipo_implemento`, `vincular`, `tag`, `placa`, `fabricante`, `modelo`, `ano_fabricao`, `chassis`, `renavam`, `proprietario`, `tara`, `lotacao`, `PTB`, `capacidadeMaxTracao`, `capacidadeVolumetrica`, `cor`, `foto`) VALUES
(1, 'tanqueSemiReboque5eixos', NULL, 'TTPPEE', 'xxx-6565-0000', 'volvo', '34TBC', '2024', '333344445555', '4423423423', 'Gustavo Lemes', 120, 12, 1299, NULL, 20, 'branca ', '81R-zMnuHHL._AC_UF894,1000_QL80_.jpg'),
(2, 'tanqueSemiReboque5eixos', NULL, 'TTPPEE', 'xxx-6565-0000', 'volvo', '34TBC', '2024', '333344445555', '4423423423', 'Gustavo Lemes', 120, 12, 1299, NULL, 20, 'branca ', '81R-zMnuHHL._AC_UF894,1000_QL80_.jpg'),
(3, 'tanqueSemiReboque2eixos', NULL, '00 BB 22', 'xxx-290-415', 'Volvo', '3540', '2024', 'rwrwrwerwe', 'rwerwrwerw', 'wewrwer', 11, 22, 33, NULL, 44, '55', 'Captura de tela de 2023-12-26 08-25-07.png'),
(4, 'tanqueSemiReboque2eixos', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, NULL, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(5, 'tanqueSemiReboque2eixos', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, NULL, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(6, 'tanqueSemiReboque2eixos', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, NULL, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(7, 'tanqueSemiReboque2eixos', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, NULL, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(8, 'tanqueSemiReboque2eixos', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, NULL, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(9, 'tanqueSemiReboque2eixos', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, NULL, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(10, 'tanqueSemiReboque2eixos', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, NULL, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(11, 'tanqueSemiReboque2eixos', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, 35000, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(12, 'tanqueSemiReboque2eixos', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, 35000, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(13, 'Tanque semirreboque com 5ª roda traseira', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, 35000, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(14, 'Baú', NULL, '## 09', '334/567', 'Fiat ', '147 ', '2024', '3333333333ffffffffffgggggggggggg', '654634563453645', 'Auto Center ', 1000, 10, 1500, 35000, 20000, 'Branco', 'Captura de tela de 2023-12-26 20-06-27.png'),
(15, 'Comboio de abastecimento', NULL, '234', '33EE', 'Fiat  ', '!47', NULL, '654634563453645', '234', 'Augusto', 10, 1500, 3000, 20000, 55, 'Azul', 'Tabela-de-interpretacao-dos-Espectros.png'),
(16, 'Comboio de abastecimento', NULL, '234', '33EE', 'Fiat  ', '!47', '6', '654634563453645', '234', 'Augusto', 10, 1500, 3000, 20000, 55, 'Azul', 'Tabela-de-interpretacao-dos-Espectros.png'),
(17, 'Comboio de abastecimento', NULL, '234', '33EE', 'Fiat  ', '!47', '6', '654634563453645', '234', 'Augusto', 10, 1500, 3000, 20000, 55, 'Azul', 'Tabela-de-interpretacao-dos-Espectros.png'),
(18, 'Tanque semirreboque com 5ª roda traseira', NULL, '234', '33EE', 'Fiat  ', '!47', '6', '654634563453645', '234', 'Augusto', 10, 1500, 3000, 20000, 55, 'Azul', 'Tabela-de-interpretacao-dos-Espectros.png'),
(19, 'Tanque semirreboque com 5ª roda traseira', '## 09', '234', '33EE', 'Fiat  ', '!47', '6', '654634563453645', '234', 'Augusto', 10, 1500, 3000, 20000, 55, 'Azul', 'Tabela-de-interpretacao-dos-Espectros.png'),
(20, 'Tanque semirreboque com 5ª roda traseira', '## 09', '234', '33EE', 'Fiat  ', '!47', '6', '654634563453645', '234', 'Augusto', 10, 1500, 3000, 20000, 55, 'Azul', 'Tabela-de-interpretacao-dos-Espectros.png'),
(21, 'Tanque semirreboque com 5ª roda traseira', '## 09', '234', '33EE', 'Fiat  ', '!47', '6', '654634563453645', '234', 'Augusto', 10, 1500, 3000, 35000, 20000, '55', 'Captura de tela de 2023-12-26 20-06-27.png'),
(22, 'Tanque semirreboque com 5ª roda traseira', '## 09', '234', '33EE', 'Fiat  ', '!47', '6', '654634563453645', '234', 'Augusto', 10, 1500, 3000, 35000, 20000, '55', 'Captura de tela de 2023-12-26 20-06-27.png'),
(23, 'Tanque semirreboque com 5ª roda traseira', '## 09', '234', '33EE', 'Fiat  ', '!47', '6', '654634563453645', '234', 'Augusto', 10, 1500, 3000, 35000, 20000, '55', 'Captura de tela de 2023-12-26 20-06-27.png'),
(24, 'Tanque semirreboque com 5ª roda traseira', '## 09', '234', '33EE', 'Fiat  ', '!47', '6', '654634563453645', '234', 'Augusto', 10, 1500, 3000, 35000, 20000, '55', 'Captura de tela de 2023-12-26 20-06-27.png'),
(25, 'Tanque semirreboque com 5ª roda traseira', '## 09', '234', '33EE', 'Fiat  ', '!47', '6', '654634563453645', '234', 'Augusto', 10, 1500, 3000, 35000, 20000, '55', 'Captura de tela de 2023-12-26 20-06-27.png');

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
(2, 'externo', 'Metalmar', '2004', 'Belém - PA', '80', 'Captura de tela de 2023-12-26 21-06-26.png'),
(3, 'TQ 01', 'Metalmar ', '2024-01-01', 'São Paulo - SP ', '80', '414927476_917225716429122_6886172699108488252_n.jpg'),
(4, 'TQ 01', 'Metalmar ', '2024-01-01', 'São Paulo - SP ', '80', '414927476_917225716429122_6886172699108488252_n.jpg'),
(5, '9900!@#$%¨&*()', 'Tanques Du bom', '2000', 'Manaus - MA ', '250 ', 'Captura de tela de 2024-01-09 20-11-48.png'),
(6, '9900!@#$%¨&*()', 'Tanques Du bom', '2000', 'Manaus - MA ', '250 ', 'Captura de tela de 2024-01-09 20-11-48.png');

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
  `CMT` varchar(10) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `ativo_veiculo`
--

INSERT INTO `ativo_veiculo` (`id`, `tipo_veiculo`, `tag`, `placa`, `fabricante`, `modelo`, `ano_fabricacao`, `chassis`, `renavam`, `proprietario`, `tara`, `lotacao`, `PTB`, `PBTC`, `CMT`, `cor`, `foto`) VALUES
(1, 'caminhaoTocoComBau', '789GHG', 'xxx-444-555', 'Volvo', '190M', '2017', '444444444ggggggghhhhh', '66655544433221', 'Santos Dumond ', 100, 3, 3500, 6000, NULL, 'verde', 'Captura de tela de 2024-01-09 20-11-41.png'),
(2, 'caminhaoTocoComBau', '7', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, NULL, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(3, 'caminhaoTocoComBau', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, NULL, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(4, 'caminhaoTocoComBau', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, NULL, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(5, 'VeiculoLeveAdm', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, NULL, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(6, 'VeiculoLeveAdm', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, NULL, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(7, 'VeiculoLeveAdm', '789GHG', 'xxx556677', 'ford', 'ma140', NULL, '444444444ggggggghhhhh', '122.333.333.57', 'Santos Dumond', 100, 3, 3500, 6000, NULL, 'Preto', 'Captura de tela de 2023-12-12 09-48-37.png'),
(8, 'caminhaoTocoComBau', '789GHG', 'AB90393OF', 'oookkkooolll', '190M', NULL, '444444444ggggggghhhhh', '66655544433221', 'Santos Dumond', 100, 3, 3500, 6000, NULL, 'blol', '68810235_2906696346071195_215575450947158016_n.jpg'),
(9, 'caminhaoTocoComBau', '789GHG', 'AB90393OF', 'oookkkooolll', '190M', NULL, '444444444ggggggghhhhh', '66655544433221', 'Santos Dumond', 100, 3, 3500, 6000, NULL, 'blol', '68810235_2906696346071195_215575450947158016_n.jpg'),
(10, 'caminhão toco', 'CA 01 ', 'xxx-2024', 'Volvo ', '3450e', NULL, 'fff-fff-ooo-777-000', '123321098890', 'Ap Marine ', 100, 12, 12, 12, '12', 'preto', 'Captura de tela de 2024-01-08 15-31-16.png'),
(11, 'caminhão toco', 'CA 01 ', 'xxx-2024', 'Volvo ', '3450e', NULL, 'fff-fff-ooo-777-000', '123321098890', 'Ap Marine ', 100, 12, 12, 12, '12', 'preto', 'Captura de tela de 2024-01-08 15-31-16.png'),
(12, 'caminhão toco', 'CA 01 ', 'xxx-2024', 'Volvo ', '3450e', NULL, 'fff-fff-ooo-777-000', '123321098890', 'Ap Marine ', 100, 12, 12, 12, '12', 'preto', 'Captura de tela de 2024-01-08 15-31-16.png'),
(13, 'caminhão toco', 'CA 01 ', 'xxx-2024', 'Volvo ', '3450e', NULL, 'fff-fff-ooo-777-000', '123321098890', 'Ap Marine ', 100, 12, 12, 12, '12', 'preto', 'Captura de tela de 2024-01-08 15-31-16.png'),
(14, 'caminhão toco', 'CA 01 ', 'xxx-2024', 'Volvo ', '3450e', NULL, 'fff-fff-ooo-777-000', '123321098890', 'Ap Marine ', 100, 12, 12, 12, '12', 'preto', 'Captura de tela de 2024-01-08 15-31-16.png'),
(15, 'caminhão toco', 'CA 01 ', 'xxx-2024', 'Volvo ', '3450e', NULL, 'fff-fff-ooo-777-000', '123321098890', 'Ap Marine ', 100, 12, 12, 12, '12', 'preto', 'Captura de tela de 2024-01-08 15-31-16.png'),
(16, 'caminhão toco', 'CA 01 ', 'xxx-2024', 'Volvo ', '3450e', NULL, 'fff-fff-ooo-777-000', '123321098890', 'Ap Marine ', 100, 12, 12, 12, '7712', 'preto', 'Captura de tela de 2024-01-08 15-31-16.png'),
(17, 'caminhão toco', 'CA 01 ', 'xxx-2024', 'Volvo ', '3450e', NULL, 'fff-fff-ooo-777-000', '123321098890', 'Ap Marine ', 100, 12, 12, 12, '7712', 'preto', 'Captura de tela de 2024-01-08 15-31-16.png'),
(18, 'caminhão toco', 'CA 01 ', 'xxx-2024', 'Volvo ', '3450e', NULL, 'fff-fff-ooo-777-000', '123321098890', 'Ap Marine ', 100, 12, 12, 12, '7712', 'preto', 'Captura de tela de 2024-01-08 15-31-16.png'),
(19, 'caminhão toco', '33333', 'rtwertwer', 'twertwert', 'twertwer', '1', '1', '1', '1', 1, 1, 1, 1, NULL, '1', ''),
(20, 'caminhão toco', '33333', 'rtwertwer', 'twertwert', 'twertwer', '1', '1', '1', '1', 1, 1, 1, 1, NULL, '1', ''),
(21, 'caminhão toco', '33333', 'rtwertwer', 'twertwert', 'twertwer', '2000', '1', '1', '1', 1, 1, 1, 1, NULL, '1', ''),
(22, 'caminhão toco', '33333', 'rtwertwer', 'twertwert', 'twertwer', '2000', '1', '1', '1', 1, 1, 1, 1, NULL, '1', ''),
(23, 'caminhão toco', '33333', 'rtwertwer', 'twertwert', 'twertwer', '2000', '1', '1', '1', 1, 1, 1, 1, NULL, '1', ''),
(24, 'caminhão toco', '33333', 'rtwertwer', 'twertwert', 'twertwer', '2000', '1', '1', '1', 1, 1, 1, 1, NULL, '1', ''),
(25, 'caminhão toco', '33333', 'rtwertwer', 'twertwert', 'twertwer', '2000', '1', '1', '1', 1, 1, 1, 1, '1200', '1', ''),
(26, 'caminhão toco', '33333', 'rtwertwer', 'twertwert', 'twertwer', '2000', '1', '1', '1', 1, 1, 1, 1, '1200', '1', ''),
(27, 'cavalo mecânico trucado', '33333', 'rtwertwer', 'twertwert', 'twertwer', '2000', '1', '1', '1', 1, 1, 1, 1, '1200', '1', ''),
(28, 'caminhão toco', 'CA 330', '555AF350', 'Volvo ', 'A380', '2000', 'xxx-uuu-3456', '123123123123', 'Porto Brasil ', 2000, 14, 2500, 3500, '1500', 'Azul ', 'Captura de tela de 2024-01-16 09-53-33.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `operador`
--

CREATE TABLE `operador` (
  `id` int(3) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `funcao` varchar(150) NOT NULL,
  `matricula` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `operador`
--

INSERT INTO `operador` (`id`, `nome`, `funcao`, `matricula`) VALUES
(1, 'Vinicius Gustavo de Jesus Ferreira Lemes', 'Gerente Operacional ', '1122'),
(2, 'Manoella M. O. Antunes', 'Engenheria Mecânica', '1111'),
(3, 'Jefferson Mendes ', 'Gerente de Marketing ', '2222');

-- --------------------------------------------------------

--
-- Estrutura da tabela `os_veiculo`
--

CREATE TABLE `os_veiculo` (
  `id` int(11) NOT NULL,
  `odometer` varchar(255) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `start_time` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `end_time` varchar(255) DEFAULT NULL,
  `maintenance_type` varchar(255) DEFAULT NULL,
  `cabine` tinyint(4) DEFAULT NULL,
  `direcao` tinyint(4) DEFAULT NULL,
  `combustivel` tinyint(4) DEFAULT NULL,
  `medicao_controle` tinyint(4) DEFAULT NULL,
  `protecao_impactos` tinyint(4) DEFAULT NULL,
  `transmissao` tinyint(4) DEFAULT NULL,
  `estrutural` tinyint(4) DEFAULT NULL,
  `acoplamento` tinyint(4) DEFAULT NULL,
  `controle_eletronico` tinyint(4) DEFAULT NULL,
  `exaustao` tinyint(4) DEFAULT NULL,
  `propulsao` tinyint(4) DEFAULT NULL,
  `protecao_contra_incendio` tinyint(4) DEFAULT NULL,
  `ventilacao` tinyint(4) DEFAULT NULL,
  `tanque` tinyint(4) DEFAULT NULL,
  `arrefecimento` tinyint(4) DEFAULT NULL,
  `descarga` tinyint(4) DEFAULT NULL,
  `freios` tinyint(4) DEFAULT NULL,
  `protecao_ambiental` tinyint(4) DEFAULT NULL,
  `suspensao` tinyint(4) DEFAULT NULL,
  `eletrico` tinyint(4) DEFAULT NULL,
  `componentesAfetados` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `os_veiculo`
--

INSERT INTO `os_veiculo` (`id`, `odometer`, `start_date`, `start_time`, `end_date`, `end_time`, `maintenance_type`, `cabine`, `direcao`, `combustivel`, `medicao_controle`, `protecao_impactos`, `transmissao`, `estrutural`, `acoplamento`, `controle_eletronico`, `exaustao`, `propulsao`, `protecao_contra_incendio`, `ventilacao`, `tanque`, `arrefecimento`, `descarga`, `freios`, `protecao_ambiental`, `suspensao`, `eletrico`, `componentesAfetados`) VALUES
(1, '123', '2024-01-01', '12:12', '2024-01-29', '12:12', 'preditiva', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Hidráulico'),
(2, '123', '2024-01-01', '12:12', '2024-01-29', '12:12', 'preditiva', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Hidráulico'),
(3, '123', '2024-01-01', '12:12', '2024-01-29', '12:12', 'preditiva', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Hidráulico'),
(4, '123', '2024-01-01', '12:12', '2024-01-29', '12:12', 'preditiva', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Hidráulico'),
(5, '123', '2024-01-01', '12:12', '2024-01-29', '12:12', 'preditiva', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 'Hidráulico'),
(6, '123', '2024-01-01', '12:12', '2024-01-29', '12:12', 'preditiva', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'Hidráulico'),
(7, '2', '2024-01-01', '11:11', '2024-01-01', '22:22', 'corretiva', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''),
(8, '2', '2024-01-01', '11:11', '2024-01-01', '22:22', 'preditiva', 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''),
(9, '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ''),
(10, '11', '2024-01-01', '11:11', '2024-01-02', '22:22', 'corretiva', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, ''),
(11, '11', '2024-01-01', '11:11', '2024-01-02', '22:22', 'corretiva', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculo_os`
--

CREATE TABLE `veiculo_os` (
  `id` int(11) NOT NULL,
  `sintomas_detectados` varchar(10000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `veiculo_os`
--

INSERT INTO `veiculo_os` (`id`, `sintomas_detectados`) VALUES
(2, 'odometerValue: 1144 | maintenanceStartDate: 2024-01-01 | maintenanceStartTime: 11:11 | maintenanceEndDate: 2024-01-02 | maintenanceFinishTime: 22:22 | radio-maintenance: corretiva | cabineCheckbox: cabine | direcaoCheckbox: direcao | combustivelCheckbox: combustivel | medicaoControleCheckbox: medicaoControle | protecaoImpactosCheckbox: protecaoImpactos | transmissaoCheckbox: transmissaoCheckbox | estruturalCheckbox: estruturalCheckbox | acoplamentoCheckbox: acoplamentoCheckbox | controleEletronicoCheckbox: controleEletronicoCheckbox | exaustaoCheckbox: exaustaoCheckbox | propulsaoCheckbox: propulsaoCheckbox | protecaoContraIncendioCheckbox: protecaoContraIncendioCheckbox | ventilacaoCheckbox: ventilacaoCheckbox | tanqueCheckbox: tanqueCheckbox | arrefecimentoCheckbox: arrefecimentoCheckbox | descargaCheckbox: descargaCheckbox | freiosCheckbox: freiosCheckbox | protecaoAmbientalCheckbox: protecaoAmbientalCheckbox | suspensaoCheckbox: suspensaoCheckbox | eletricoCheckbox: eletricoCheckbox | componentesAfetados: AAAAAAAAAA | abertoCheckbox: Aberto | desvioLateralCheckbox: Desvio lateral | queimadoCheckbox: Queimado | semFreioCheckbox: Sem freio | sujoCheckbox: Sujo | vazandoCheckbox: Vazando | baixoRendimentoCheckbox: Baixo Rendimento | empenadoCheckbox: Empenado | rompidoCheckbox: Rompido | semVelocidadeCheckbox: Sem velocidade | travadoCheckbox: Travado | vibrandoCheckbox: Vibrando | desarmadoCheckbox: Desarmado | preventivaPreditivaCheckbox: Preventiva ou Preditiva | ruidoAnormalCheckbox: Ruído Anormal | soltoCheckbox: Solto | trincadoCheckbox: Trincado | othersCheckboxValue: Outros | causaNaoIdentificadaCheckbox: causaNaoIdentificadaCheckbox | causaDefeitoDeFabricaCheckbox: causaDefeitoDeFabricaCheckbox | causaDesnivelamentoCheckbox: causaDesnivelamentoCheckbox | causaDestensionamentoCheckbox: causaDestensionamentoCheckbox | causaFissuraCheckbox: causaFissuraCheckbox | causaGastoCheckbox: causaGastoCheckbox | causaPreventivaPreditivaCheckbox: causaPreventivaPreditivaCheckbox | causaRotaDeInspecaoCheckbox: causaRotaDeInspecaoCheckbox | causaSobrecargaDeCorrenteCheckbox: causaSobrecargaDeCorrenteCheckbox | causaDesalinhamentoCheckbox: causaDesalinhamentoCheckbox | causaFaltaDeProtecaoCheckbox: causaFaltaDeProtecaoCheckbox | causaEngripamentoCheckbox: causaEngripamentoCheckbox | causaFolgaCheckbox: causaFolgaCheckbox | causaSobrecargaDePesoCheckbox: causaSobrecargaDePesoCheckbox | causaSubdimensionamentoCheckbox: causaSubdimensionamentoCheckbox | causaDesbalanceamentoCheckbox: causaDesbalanceamentoCheckbox | causaDesregulamentoCheckbox: causaDesregulamentoCheckbox | causaFadigaCheckbox: causaFadigaCheckbox | causaForaDeEspecificacaoCheckbox: causaForaDeEspecificacaoCheckbox | causaNivelBaixoCheckbox: causaNivelBaixoCheckbox | causaRompidoCheckbox: causaRompidoCheckbox | causaSobrecargaDeTensaoCheckbox: causaSobrecargaDeTensaoCheckbox | causaOthersCheckboxValue: GGGGGGGGGGGGGGGGG | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoPinturaCheckbox: intervencaoPinturaCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoFunilariaCheckbox: intervencaoFunilariaCheckbox | intervencaoCaldeirariaCheckbox: intervencaoCaldeirariaCheckbox | intervencaoHidraulicoCheckbox: intervencaoHidraulicoCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoAcopladoCheckbox: intervencaoAcopladoCheckbox | intervencaoDesacopladoCheckbox: intervencaoDesacopladoCheckbox | intervencaoInstaladoCheckbox: intervencaoInstaladoCheckbox | intervencaoRearmadoCheckbox: intervencaoRearmadoCheckbox | intervencaoSoldadoCheckbox: intervencaoSoldadoCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoLimpezaCheckbox: intervencaoLimpezaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | intervencaoAlinhadoCheckbox: intervencaoAlinhadoCheckbox | intervencaoFixadoCheckbox: intervencaoFixadoCheckbox | intervencaoLubrificadoCheckbox: intervencaoLubrificadoCheckbox | intervencaoRepostoCheckbox: intervencaoRepostoCheckbox | intervencaoApertadoCheckbox: intervencaoApertadoCheckbox | intervencaoInspecionadoCheckbox: intervencaoInspecionadoCheckbox | intervencaoModificadoCheckbox: intervencaoModificadoCheckbox | intervencaoRetiradoCheckbox: intervencaoRetiradoCheckbox');

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
-- Índices para tabela `operador`
--
ALTER TABLE `operador`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `os_veiculo`
--
ALTER TABLE `os_veiculo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `veiculo_os`
--
ALTER TABLE `veiculo_os`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ativo_embarcacao`
--
ALTER TABLE `ativo_embarcacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `ativo_implemento`
--
ALTER TABLE `ativo_implemento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `ativo_tanque`
--
ALTER TABLE `ativo_tanque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `ativo_veiculo`
--
ALTER TABLE `ativo_veiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `operador`
--
ALTER TABLE `operador`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `os_veiculo`
--
ALTER TABLE `os_veiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `veiculo_os`
--
ALTER TABLE `veiculo_os`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
