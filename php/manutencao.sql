-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 29-Jan-2024 às 16:13
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
  `odometer` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `maintenance_type` varchar(255) DEFAULT NULL,
  `cabine` varchar(400) DEFAULT NULL,
  `combustivel` varchar(120) DEFAULT NULL,
  `direcao` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `os_veiculo`
--

INSERT INTO `os_veiculo` (`id`, `odometer`, `start_date`, `start_time`, `end_date`, `end_time`, `maintenance_type`, `cabine`, `combustivel`, `direcao`) VALUES
(1, 111, '2024-01-03', '12:00:00', '2024-01-22', '13:00:00', 'on', NULL, NULL, NULL),
(2, 12, '2023-10-31', '12:00:00', '2023-11-07', '12:00:00', 'on', NULL, NULL, NULL),
(3, 7456746, '2024-01-02', '12:22:00', '2024-01-10', '12:22:00', '', NULL, NULL, NULL),
(4, 7456746, '2024-01-02', '12:22:00', '2024-01-10', '12:22:00', 'Preditiva', NULL, NULL, NULL),
(5, 7456746, '2024-01-02', '12:22:00', '2024-01-10', '12:22:00', 'Preditiva', NULL, NULL, NULL),
(6, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Corretiva', NULL, NULL, NULL),
(7, 7456746, '2024-01-02', '12:22:00', '2024-01-10', '12:22:00', 'Preditiva', NULL, NULL, NULL),
(8, 74, '2024-01-02', '12:22:00', '2024-01-10', '12:22:00', 'Preventiva', NULL, NULL, NULL),
(9, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Preventiva', NULL, NULL, NULL),
(10, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Preventiva', '', NULL, NULL),
(11, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Preventiva', '', NULL, NULL),
(12, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Preventiva', '', NULL, NULL),
(13, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Preventiva', '', NULL, NULL),
(14, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Preventiva', '', NULL, NULL),
(15, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Preventiva', '', NULL, NULL),
(16, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Preventiva', '', NULL, NULL),
(17, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Preventiva', '', NULL, NULL),
(18, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Preventiva', '', NULL, NULL),
(19, 333, '2024-01-02', '05:05:00', '2024-01-03', '06:06:00', 'Corretiva', '', NULL, NULL),
(20, 8, '2024-01-22', '12:00:00', '2024-01-16', '12:00:00', 'Preditiva', '', NULL, NULL),
(21, 5, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preditiva', '', NULL, NULL),
(22, 5, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preditiva', '', NULL, NULL),
(23, 5, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preditiva', '', NULL, NULL),
(24, 55, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preventiva', '', NULL, NULL),
(25, 55, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preventiva', '', NULL, NULL),
(26, 55, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Corretiva', '', NULL, NULL),
(27, 55, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Corretiva', '', NULL, NULL),
(28, 55999, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Corretiva', '', NULL, NULL),
(29, 55999, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Corretiva', '', NULL, NULL),
(30, 55999, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Corretiva', '', NULL, NULL),
(31, 55999, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preventiva', '', NULL, NULL),
(32, 55999, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preventiva', '', NULL, NULL),
(33, 55999, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preventiva', '', NULL, NULL),
(34, 1122, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preventiva', '', NULL, NULL),
(35, 1122, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preventiva', '', NULL, NULL),
(36, 123, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preventiva', '', NULL, NULL),
(37, 123, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'Preditiva', '', NULL, NULL),
(38, 123, '2024-01-09', '08:08:00', '2024-01-02', '07:07:00', 'preditiva', 'direcao', NULL, NULL),
(39, 888, '2024-01-02', '12:00:00', '2024-01-02', '13:00:00', 'preditiva', 'direcao', NULL, NULL),
(40, 888, '2024-01-02', '12:00:00', '2024-01-02', '13:00:00', 'corretiva', '', NULL, NULL),
(41, 888, '2024-01-02', '12:00:00', '2024-01-02', '13:00:00', 'corretiva', '', NULL, NULL),
(42, 1514, '2024-01-02', '12:00:00', '2024-01-01', '13:00:00', 'corretiva', '1', '1', NULL),
(43, 1514, '2024-01-02', '12:00:00', '2024-01-01', '13:00:00', 'preventiva', '0', '0', NULL),
(44, 1514, '2024-01-02', '12:00:00', '2024-01-01', '13:00:00', 'preventiva', '1', '0', NULL),
(45, 1514, '2024-01-02', '12:00:00', '2024-01-01', '13:00:00', 'preventiva', '0', '1', NULL),
(46, 1514, '2024-01-02', '12:00:00', '2024-01-01', '13:00:00', 'preditiva', '1', '1', '1');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
