-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 20/09/2024 às 18:35
-- Versão do servidor: 5.7.23-23
-- Versão do PHP: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `autode51_manutencao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `ativo_embarcacao`
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
-- Despejando dados para a tabela `ativo_embarcacao`
--

INSERT INTO `ativo_embarcacao` (`id`, `tipo_embarcacao`, `tag`, `num_inscricao`, `nome`, `armador`, `ano_fabricacao`, `capacidade_volumetrica`, `foto`) VALUES
(70, 'balsa motorizada', 'AP3', '022.002.886-9', 'AP MARINE III', 'AP Marine LTDA..', 2006, 70000, 'logo_ap_marine.png'),
(71, 'balsa motorizada', 'AP4', '001.143.554-2', 'AP MARINE IV', 'AP Marine LTDA', 2012, 474690, 'ap_marine_4.png'),
(72, 'balsa motorizada', 'AMCI', '021.098.557-7', 'AMC I ', 'RMS LTDA', 2009, 556538, 'AMC_1.png'),
(73, 'empurrador', 'AMC', 'xxx.xxx.xxx-x', 'AMC ', 'RMS LTDA', 2014, 0, 'logo_ap_marine.png'),
(74, 'balsa simples', 'atualizar_forms', 'xxx.xxxbbbb', 'YASMIM MARIANA', 'RMS LTDA', 0, 1200000, 'logo_ap_marine.png'),
(75, 'balsa simples', 'AP6 ', 'xxx.xxx.xxx-x', 'AP MARINE VI', 'AP Marine LTDA', 0, 850000, 'logo_ap_marine.png'),
(76, 'balsa simples', 'ROS', 'xxx.xxx.xxx-x', 'ROSA CRISTINA ', 'AP Marine LTDA', 0, 368550, 'logo_ap_marine.png'),
(77, 'balsa motorizada', 'AP1', '022-008130-1', 'AP MARINE I', 'AP Marine LTDA', 2010, 190000, 'Captura de tela de 2024-04-14 16-02-55.png'),
(78, 'balsa motorizada', '#', '*', 'Almirante Guilhem ', '*', 0, 0, '451865294_18453340186063289_919201227180aaaa8478734_n.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ativo_implemento`
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
-- Despejando dados para a tabela `ativo_implemento`
--

INSERT INTO `ativo_implemento` (`id`, `tipo_implemento`, `vincular`, `tag`, `placa`, `fabricante`, `modelo`, `ano_fabricao`, `chassis`, `renavam`, `proprietario`, `tara`, `lotacao`, `PTB`, `capacidadeMaxTracao`, `capacidadeVolumetrica`, `cor`, `foto`) VALUES
(15, 'Tanque semirreboque 2 eixos', 'não', '03', 'NJH0830/PA', 'SR/NOMA SRTD3E TACLD', 'CARGA SEMI-REBOQUE', '2007', '9EP21123071004848', '00940102242', 'AP Marine', 0, 0, 0, 0, 0, 'brancaaaaaahhhy', 'logo_ap_marine.png'),
(16, 'Tanque semirreboque 2 eixos', 'não', '04', 'NJH0H60', 'SR/NOMA SRTT3E TACLT', 'SR/NOMA SRTT3E TACLT', '2007', '9EP21123071004849', '00940100983', 'AP Marine', 0, 0, 0, 0, 0, 'BRANCA', 'logo_ap_marine.png'),
(18, 'Tanque semirreboque 2 eixos', 'não', '##', 'NEM3776', 'GOTTI ', 'SR/GOTTI SRTQL3E 101', '2013', '9A9V12730D2AD9488', '00568329970', 'AP Marine', 0, 0, 0, 0, 0, 'PRETA', 'logo_ap_marine.png'),
(19, 'Tanque semirreboque 2 eixos', 'NÃO', '##', 'KQD5613', 'SR/RANDON', 'SR/RANDON', '1979', 'NÃO TEM', '00304418110', 'AP Marine', 0, 0, 0, 0, 0, 'PRETA', 'logo_ap_marine.png'),
(20, 'Tanque semirreboque 2 eixos', 'NÃO', '##', 'KKE8366', 'GOTTI', 'REB/GOTTI', '1997', '9A9V11530V2AD9091', '00677045743', 'AP Marine', 0, 0, 0, 0, 0, 'BRANCA', 'logo_ap_marine.png'),
(21, 'Tanque semirreboque 2 eixos', 'não ', '##', 'JWB4F45', ' NOMA', 'SR/NOMA SRT1E AP', '2002', '9EP21081021002174', '00785017305', 'AP Marine', 0, 0, 0, 0, 0, 'PRETA', 'logo_ap_marine.png'),
(22, 'Tanque semirreboque 2 eixos', 'NÃO ', '##', 'JVF2874', 'VOLVO', 'VOLVO/FH 440 4X2T', '2008', '9BVAS02A58E742262', '00973223294', 'AP Marine', 0, 0, 0, 0, 0, '0', 'logo_ap_marine.png'),
(23, 'Tanque semirreboque 2 eixos', 'NÃO ', '##', 'JWB4F45', 'NOMA', 'SR/NOMA SRT1E AP', '2002', '9EP21081021002174', '00785017305', 'AP Marine', 0, 0, 0, 0, 0, '0', 'logo_ap_marine.png'),
(24, 'Tanque semirreboque 2 eixos', 'não ', '##', 'JUE6E52', 'RANDON', 'SR/RANDON SR TQ', '2003', '9ADV113333M184850', '00799516694', 'AP Marine', 0, 0, 0, 0, 0, 'PRETA', 'logo_ap_marine.png'),
(25, 'Tanque semirreboque 2 eixos', 'NÃO', '##', 'BWU6016', 'RANDON', 'SR TQ TL ', '1992', '9ADV12330NS095341', '00603950167', 'AP Marine', 0, 0, 0, 0, 0, 'BRANCA', 'logo_ap_marine.png'),
(26, 'Tanque semirreboque 2 eixos', 'NÃO ', '##', 'ATL0E02', 'GOTTI', 'SR/GOTTI SRTQL2E 092', '2008', '9A9V0922082AD9264', '00958752427', 'AP Marine', 0, 0, 0, 0, 0, 'BRANCA', 'logo_ap_marine.png'),
(27, 'Tanque semirreboque 2 eixos', 'NÃO ', '##', 'ATL0D70', 'GOTTI', 'SR/GOTTI SRTQL2E 095D', '2008', '9A9V0952082AD9261', '00958732833', 'AP Marine', 0, 0, 0, 0, 0, 'BRANCA', 'logo_ap_marine.png'),
(28, 'Tanque semirreboque 2 eixos', 'NÃO ', '##', 'KJU3E97', 'GUERRA', 'SR/GUERRA AG TQ', '2007', '9AA21082G7C069157', '00928754316', 'AP Marine', 0, 0, 0, 0, 0, 'PRETA', 'logo_ap_marine.png'),
(29, 'Tanque semirreboque 2 eixos', 'NÃO', '##', 'KJU3D07', 'SR/GUERRA AG TQ', 'GUERRA', '2007', '9AA21102G7C069156', '223429398118', 'AP Marine', 0, 0, 0, 0, 0, 'PRETA', 'logo_ap_marine.png'),
(30, 'Tanque semirreboque 2 eixos', 'NÃO', '##', 'NEC0429', 'GUERRA', 'SR/GUERRA AG TQ', '2008', '9AA21082G9C082026', '00111293839', 'AP Marine', 0, 0, 0, 0, 0, 'VERMELHA', 'logo_ap_marine.png'),
(31, 'Tanque semirreboque 2 eixos', 'NÃO', '##', 'NEC0399', 'GUERRA', 'SR/GUERRA AG TQ', '2008', '9AA21102G9C082025', '00111292018', 'AP Marine', 0, 0, 0, 0, 0, 'VERMELHA', 'logo_ap_marine.png'),
(32, 'Tanque semirreboque 2 eixos', 'NÃO', '##', 'JVO7D81', 'GUERRA', 'SR/GUERRA AG TQ', '2007', '9AA21082G8C072852', '00949882003', 'AP Marine', 0, 0, 0, 0, 0, 'PRATA', 'logo_ap_marine.png'),
(34, 'Tanque semirreboque 2 eixos', 'não ', '##', 'AER2660', 'RANDON ', 'XXX', '2000', 'XXX', 'XXX', 'XXX', 0, 0, 0, 0, 0, '0', 'craiyon_104943_future_green_city_with_big_skycrapper_like_trees_linked_by_bridge.png'),
(35, 'Tanque semirreboque 2 eixos', 'nec0429', '##', 'NEC 0399', 'GUERRA', 'xxx', '2000', 'xxx', 'xxx', 'xxx', 0, 0, 0, 0, 0, '0', 'logo_ap_marine.png'),
(36, 'Tanque semirreboque 2 eixos', 'NKD5977/NKD5892', '22', 'NKD5977', 'XXX', 'BI-TREM', '2000', 'XXXX', 'XXXX', 'AP Marine', 0, 0, 0, 0, 0, '0', 'logo_ap_marine.png'),
(37, 'Tanque semirreboque 2 eixos', 'não ', '##', 'IJT 5101', 'xxx', 'xxx', '2000', 'xxx', 'xxx', 'AP Marine', 0, 0, 0, 0, 0, '0', 'logo_ap_marine.png'),
(38, 'Outro', 'não', '###', 'OEZ9A84', 'não sei ', 'não sei ', '1000', 'xxxxx', 'xxxxxx', 'xxxxxxx', 0, 0, 0, 0, 0, 'branco', 'canonical-renovou-o-logotipo-do-ubuntu-1.jpg'),
(39, 'Tanque semirreboque 2 eixos', 'não', '###', 'KJU 3497', 'x', 'x', '1000', 'x', 'x', 'x', 0, 0, 0, 0, 0, '0', '3.jpeg'),
(40, 'Tanque semirreboque 2 eixos', 'não ', '##', 'KJU 3307', '*', '*', '1000', 'XXX', 'XXX', '*', 0, 0, 0, 0, 0, 'Branco', '20210709065704_revolução capa.jpg'),
(41, 'Tanque semirreboque 2 eixos', 'não ', '##', 'NKD 5897', '*', '*', '1000', '***', '***', '*', 0, 0, 0, 0, 0, 'branco', '0df9684f7b7e44c0bea0df6aa4b69e2b.jpg'),
(42, 'Tanque semirreboque 2 eixos', 'não', '##', 'QVW1J69', '*', '*', '1000', '*', '*', '*', 0, 0, 0, 0, 0, 'branco', '449030011_1201367121298071_4966564204391865968_n.jpg'),
(43, 'Tanque semirreboque 2 eixos', 'não ', '#', 'JUE8050', '*', '*', '1000', '*', '*', 'RMS', 0, 0, 0, 0, 50000, 'preta', 'GM53U98WMAAj8w6.jpeg'),
(44, 'Tanque semirreboque 2 eixos', 'não', '#', 'NHJ0160', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, 0, '0', 'Semaaa título.jpeg'),
(45, 'Tanque semirreboque 2 eixos', 'não', '*', 'JTG2J36', '*', '*', '0', '0', '0', '0', 0, 0, 0, 0, 0, 'branco', 'orgulho_negro_importancia.png'),
(46, 'Tanque semirreboque 2 eixos', 'não', '*', 'NEP0271', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, 0, 'BRANCO', '66015308_2792235644183933_5553662888645754880_n.jpg'),
(47, 'Tanque semirreboque 2 eixos', '*', '*', 'JTF2197', '+', '+', '0', '+', '+', '+', 0, 0, 0, 0, 0, 'branco', '449680742_7795996093840870_7330328140431184070_n.jpg'),
(48, 'Tanque semirreboque 2 eixos', 'não', '*', 'JTH7G07', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, 0, 'BRANCO', 'craiyon_104807_generate_nice_looking_logo_of_bitcoin_in_beautiful_green_and_blue_colored_ecology_env.png'),
(49, 'Tanque semirreboque 2 eixos', 'não', '*', 'NJH0760', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, 0, 'branco', 'GS3bjSJX0AAC_qt.jpeg'),
(50, 'Tanque semirreboque 2 eixos', '*', '*', 'NSN0982', '*', '*', '0', '0', '0', '0', 0, 0, 0, 0, 0, '0', 'GRkSy_CWMAEWbPq.jpeg'),
(51, 'Tanque semirreboque 2 eixos', '*', '*', 'JXA5685', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, 0, 'branco', 'GS1Abs_bYAAGh1s.jpeg'),
(52, 'Tanque semirreboque 2 eixos', 'não ', '*', 'JUP9617', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, 0, 'branca', 'Semaaa título.jpeg'),
(53, 'Tanque semirreboque 2 eixos', 'não', '*', 'JUP9G27', '*', '*', '0', '0', '0', '0', 0, 0, 0, 0, 0, 'branco', '95f6536533dcf06b3eca5e120cbbe4d4.png'),
(54, 'Tanque semirreboque 2 eixos', 'não', '*', 'NSN0842', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, 0, 'branco', 'IMG_20240715_133258243.jpg'),
(55, 'Tanque semirreboque 2 eixos', 'não', '*', 'OSZ7397', '*', '*', '0', '0', '0', '0', 0, 0, 0, 0, 0, 'BRANCO', 'IMG_20240715_133305896.jpg'),
(56, 'Tanque semirreboque 2 eixos', 'não', '*', 'OTB3256', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, 0, 'branco', 'IMG_20240716_084424599.jpg'),
(57, 'Tanque semirreboque 2 eixos', 'não', '+', 'RWX6C87', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, 0, 'BRANCO', 'IMG_20240716_084411065.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ativo_tanque`
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
-- Despejando dados para a tabela `ativo_tanque`
--

INSERT INTO `ativo_tanque` (`id`, `tag`, `fabricante`, `anoFabricacao`, `localizacao`, `capacidadeVolumetrica`, `foto`) VALUES
(8, '##22', 'Erickkk - Engenheiro mecânico', '2024', 'Belém - PA', '10000', 'AMC_1.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ativo_veiculo`
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
-- Despejando dados para a tabela `ativo_veiculo`
--

INSERT INTO `ativo_veiculo` (`id`, `tipo_veiculo`, `tag`, `placa`, `fabricante`, `modelo`, `ano_fabricacao`, `chassis`, `renavam`, `proprietario`, `tara`, `lotacao`, `PTB`, `PBTC`, `CMT`, `cor`, `foto`) VALUES
(9, 'caminhão toco', '01', 'SAL0G83', 'DAF ', 'DAF/XF FTT 530', '2022', '98PTTH430PB132382', '01330479405', 'AP Marine', 0, 0, 0, 0, '0', 'PRATA', 'SAL-0G83 - FOTO FRENTE.jpeg'),
(10, 'veículo leve operacional', '02', 'SAL1A08', 'FIAT', 'FIAT/STRADA FREEDOM 13CS', '2022', '9BD281A9JPYY20596', '01331776969', 'AP Marine', 0, 0, 0, 0, '0', 'BRANCAAaaa', ''),
(11, 'caminhão toco', 'MERC01', 'QVW1J69', 'ACTROS 2651S6X4', 'M.BENZ', '2019', '9BM938142KS050374', '01200840329', 'AP Marine', 0, 0, 0, 0, '0', 'BRANCA', 'logo_ap_marine.png'),
(12, 'Veiculo leve administrativo', 'jeepinho', 'QLT3A88', 'JEEP', 'RENEGADE MOAB', '2021', '9886111H6MK383326', '01257989771', 'AP Marine', 0, 0, 0, 0, '0', 'VERDE', 'logo_ap_marine.png'),
(13, 'caminhão toco', '##', 'QLS2H94', 'DAF', 'XF105 FTT 510A', '2020', '98PTT47MSLB111155', '01228784733', 'AP Marine', 0, 0, 0, 0, '0', 'PRATA', 'logo_ap_marine.png'),
(14, 'caminhão toco', '##', 'QLS2H93', 'DAF', 'XF105 FTT 510A', '2020', '98PTT47MSLB111164', '01228784717', '0', 0, 0, 0, 0, '0', 'PRATA', 'logo_ap_marine.png'),
(15, 'caminhão toco', '##', 'QLS2H91', 'DAF', 'XF105 FTT 510A', '2020', '98PTT47MSLB111169', '01228784652', 'AP Marine', 0, 0, 0, 0, '0', 'PRATA', 'logo_ap_marine.png'),
(16, 'caminhão toco', '##777777', 'QLS2H90', 'DAF', 'XF105 FTT 510A', '2020', '98PTT47MSLB111157', '01228784504', 'AP Marine', 0, 0, 0, 0, '0', 'PRATA', 'logo_ap_marine.png'),
(17, 'caminhão toco', '##', 'QEZ9A84', 'M.BENZ', 'ACTROS 2651S6X4', '2018', '9BM938142KS046599', '01178469295', 'AP Marine', 0, 0, 0, 0, '0', 'BRANCA', 'logo_ap_marine.png'),
(18, 'caminhão toco', '##', 'NEO3701', 'GOTTI', 'SR/GOTTI SRTQL3E 101', '2014', '9A9V12730E2AD9305', '01014331754', 'AP Marine', 0, 0, 0, 0, '0', 'PRETA', 'logo_ap_marine.png'),
(19, 'caminhão toco', '##', 'NEO3703', 'GOTTI', 'SR/GOTTI SRTQL3E 101', '0', '9A9V12730E2AD9312', '01014334710', 'AP Marine', 0, 0, 0, 0, '0', 'PRETA', 'logo_ap_marine.png'),
(20, 'caminhão toco', '##', 'NEM3774', 'GOTTI', 'SR/GOTTI SRTQL3E 101', '2013', '9A9V12730D2AD9490', '00568329074', '0', 0, 0, 0, 0, '0', 'PRETA', 'logo_ap_marine.png'),
(21, 'caminhão toco', '##', 'JVF2874', 'VOLVO', 'FH 440 4X2T', '2008', '9BVAS02A58E742262', '00973223294', 'AP Marine', 0, 0, 0, 0, '0', 'BRANCA', 'logo_ap_marine.png'),
(22, 'caminhão toco', 'caminhão', 'RWY 3S27', 'DAF', 'XF 530', '2024', 'xxx.yyy.www-9000', 'FEFEEFEF', 'FEFEFE', 10, 10, 10, 10, '10', 'FEFEFE', '0df9684f7b7e44c0bea0df6aa4b69e2b.webp'),
(23, 'caminhão toco', '#', 'RWZ9A12', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, '0', 'branco', '450987386_18417327370068707_3282432111833703729_n.jpg'),
(24, 'caminhão toco', '#', 'QLQ2004', '*', '*', '1', '*', '*', '*', 0, 0, 0, 0, '0', 'branco', 'orgulho_negro_importancia_detailed.png'),
(25, 'caminhão toco', '#', 'AMI8908', '#', '#', '0', '0', '0', '0', 0, 0, 0, 0, '0', 'branco', 'banner_site_FT_ps2024.png'),
(26, 'caminhão toco', '#', 'JWB4F45', '*', '*', '0', '0', '0', '0', 0, 0, 0, 0, '0', 'branco', 'WhatsApp Image 2024-04-29 at 10.36.39.jpeg'),
(27, 'caminhão toco', '*', 'APV9B37', '*', '*', '0', '0', '0', '0', 0, 0, 0, 0, '0', 'branco', '448881428_1012142687154269_1649374715508568554_n.jpg'),
(28, 'caminhão toco', '*', 'APV9B33', '*', '*', '0', '0', '0', '0', 0, 0, 0, 0, '0', 'branco', 'ubuntu-pictures-m67dfn6hxfo9v391.jpg'),
(29, 'caminhão toco', 'não', 'BAK8I63', '*', '*', '0', '0', '0', '0', 0, 0, 0, 0, '0', 'branco', 'orgulho_negro_importancia.png'),
(30, 'caminhão toco', '*', 'JVO7V21', '*', '*', '1', '*', '*', '*', 0, 0, 0, 0, '', '', ''),
(31, 'caminhão toco', '*', 'SAL4G04', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, '0', 'BRANCO ', 'WhatsApp Image 2019-11-11 at 7.28.23 PM.jpeg'),
(32, 'caminhão toco', '*', 'JVO2G42', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, '0', 'Branco', 'GTQk7XWWEAApshH.jpeg'),
(34, 'caminhão toco', '*', 'JUE6E52', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, '0', 'branca', 'foto caminhao toco.jpg'),
(35, 'caminhão toco', '*', 'ATL5E40', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, '0', 'Branca', '1000132280.jpg'),
(36, 'caminhão toco', '*', 'JVO2G02', '*', '*', '0', '*', '*', '*', 0, 0, 0, 0, '0', 'Br', '1000132280.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `embarcacao_os`
--

CREATE TABLE `embarcacao_os` (
  `id` int(11) NOT NULL,
  `id_ativo` varchar(4) NOT NULL,
  `dados` varchar(15000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `embarcacao_os`
--

INSERT INTO `embarcacao_os` (`id`, `id_ativo`, `dados`) VALUES
(2, '77 ', 'odometerValue:  | maintenanceStartDate: 2024-06-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-07-04 | maintenanceFinishTime: 12:00 | id: 77 | radio-maintenance: preventiva | motorCheckbox: motorCheckbox | preventivaPreditivaCheckbox: Preventiva ou Preditiva | causaPreventivaPreditivaCheckbox: causaPreventivaPreditivaCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Feito revisão de troca de óleo e filtros dos motores BB, BE,feito revisão de troca de óleo e filtros dos reversores BB,BE , limpado o sistema de combustível do tanque . | mantenedores: Heber costa aguiar  | materiaisUtilizados: 32 litros de óleo 15W/40\r\n2 filtros de óleo do lubricamente do motor \r\n4 filtros do diesel \r\n20 litros de óleo 40w\r\n2 filtros do reversor'),
(5, '71', 'odometerValue: 0 | maintenanceStartDate: 2023-01-06 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-06 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Troca de refletor, reator e lâmpada\r\nInstalação da bomba\r\nCompra do gerador | mantenedores: Everaldo  | materia1: lâmpada, reator e refletor | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(6, '71', 'odometerValue:  | maintenanceStartDate: 2023-01-11 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-11 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | causaSobrecargaDeTensaoCheckbox: causaSobrecargaDeTensaoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca do gerador da ponta de eixo | mantenedores: Everaldo | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2: gerador  | quantidade2: 1 | valor2: 6140 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(7, '71', 'odometerValue:  | maintenanceStartDate: 2023-01-11 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-13 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Manutenção do gerador MCA; troca do gerador de cabeça do motor da AP4 | mantenedores: Everaldo | materia1: Mão de Obra | quantidade1: 1 | valor1: 700 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(8, '72', 'odometerValue:  | maintenanceStartDate: 2023-01-27 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-27 | maintenanceFinishTime: 18:00 | id: 72 | radio-maintenance: corretiva | arrefecimentoCheckbox: arrefecimentoCheckbox | causaNaoIdentificadaCheckbox: causaNaoIdentificadaCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Substituição; radiador de água, bomba de transferência, óleo do motor, filtro de óleo do motor. Material reserva deixado na balsa, 02 filtro diesel, 6 filtros racool 20x20 | mantenedores: Héber | materia1: radiador de água, bomba de transferência, óleo do motor, filtro de óleo do motor. Material reserva deixado na balsa, 02 filtro diesel, 6 filtros racool 20x20 | quantidade1: 1 | valor1: 4500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(10, '78', 'odometerValue:  | maintenanceStartDate: 2023-01-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-23 | maintenanceFinishTime: 18:00 | id: 78 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão corretiva da parte elétrica. | mantenedores: Everaldo  | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(11, '70', 'odometerValue:  | maintenanceStartDate: 2023-02-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-16 | maintenanceFinishTime: 18:00 | id: 70 | radio-maintenance: corretiva | motorCheckbox: motorCheckbox | combustivelCheckbox: combustivel | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca do óleo do motor, troca do filtro de óleo do motor, troca do filtro racool, troca de mangueira da geral do diesel, lavagem de 02 tanques de combustíveis. | mantenedores: Héber | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(12, '78', 'odometerValue:  | maintenanceStartDate: 2023-02-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-17 | maintenanceFinishTime: 18:00 | id: 78 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Serviços de elétrica em geral. | mantenedores: Everaldo | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(13, '71', 'odometerValue:  | maintenanceStartDate: 2023-02-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-17 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | observacoes: manutenção do MCA. | mantenedores: Everaldo  | materia1: Valor Material | quantidade1: 1 | valor1: 200 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(14, '71', 'odometerValue:  | maintenanceStartDate: 2023-02-22 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-25 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: preventiva | outroCheckbox: outroCheckbox | observacoes: Remoção da ferrugem e preparo para jateamento. | mantenedores: Emérson  | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(15, '74', 'odometerValue:  | maintenanceStartDate: 2023-02-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-15 | maintenanceFinishTime: 18:00 | id: 74 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | observacoes: Troca e instalação de baterias e terminais. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(16, '70', 'odometerValue:  | maintenanceStartDate: 2023-02-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-16 | maintenanceFinishTime: 18:00 | id: 70 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Troca de baterias e reposição de cabos e terminais. | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(17, '78', 'odometerValue:  | maintenanceStartDate: 2023-03-03 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-03 | maintenanceFinishTime: 18:00 | id: 78 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Solda de 13 porta-cadeados. | mantenedores: Frank  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(18, '71', 'odometerValue:  | maintenanceStartDate: 2023-03-01 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-01 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: preventiva | outroCheckbox: outroCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Fabricação do carrinho da bomba. | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(19, '70', 'odometerValue:  | maintenanceStartDate: 2023-02-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-16 | maintenanceFinishTime: 18:00 | id: 70 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | observacoes: Revisão corretiva. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(20, '70 ', 'odometerValue:  | maintenanceStartDate: 2023-02-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-16 | maintenanceFinishTime: 18:00 | id: 70 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | observacoes: Revisão corretiva. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(21, '71', 'odometerValue:  | maintenanceStartDate: 2023-04-10 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-10 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: corretiva | motorCheckbox: motorCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | observacoes: Retificado motor agrale MCA | mantenedores: Héber | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(22, '71', 'odometerValue:  | maintenanceStartDate: 2023-05-18 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-18 | maintenanceFinishTime: 17:00 | id: 71 | radio-maintenance: preventiva | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de óleo, filtro, mangueiras | mantenedores: Héber | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(23, '77', 'odometerValue:  | maintenanceStartDate: 2023-05-18 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-18 | maintenanceFinishTime: 18:00 | id: 77 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes: Serviço no motor de partida | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(24, '70', 'odometerValue:  | maintenanceStartDate: 2023-05-18 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-18 | maintenanceFinishTime: 18:00 | id: 70 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Recuperação de instalação e troca de fios e cabos 01 buzina à ar, 01 buzina bibi, 01 sensor de bóia de nível, 20 metros de cabo 2x1, 01 sirene de ré, 01 giroflex led. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 1100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(25, '78', 'odometerValue:  | maintenanceStartDate: 2023-02-01 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-01 | maintenanceFinishTime: 18:00 | id: 78 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes: Instalação elétrica | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(26, '70', 'odometerValue:  | maintenanceStartDate: 2023-04-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-13 | maintenanceFinishTime: 18:00 | id: 70 | radio-maintenance: corretiva | motorCheckbox: motorCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Retirada e recolocação do motor da bomba de engrenagem e troca de lâmpadas  | mantenedores: Everaldo | materia1: Mão de obra | quantidade1: 1 | valor1: 2000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(27, '71', 'odometerValue:  | maintenanceStartDate: 2023-01-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-23 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Manutenção do gerador MCA, troca do gerador da cabeça do motor | mantenedores: Everaldo | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(28, '72', 'odometerValue:  | maintenanceStartDate: 2023-01-06 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-06 | maintenanceFinishTime: 18:00 | id: 72 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | intervencaoAlinhadoCheckbox: intervencaoAlinhadoCheckbox | observacoes: Troca de lâmpadas e reatores dos refletores, instalação de um exaustor | mantenedores: Everaldo | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(29, '71', 'odometerValue:  | maintenanceStartDate: 2023-01-11 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-11 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca do gerador | mantenedores: Everaldo | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2: Valor material | quantidade2: 1 | valor2: 6150 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(30, '77', 'odometerValue:  | maintenanceStartDate: 2022-12-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2022-12-15 | maintenanceFinishTime: 18:00 | id: 77 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de 01 cabo da máquina de solda, retirada do motor da intermediária, retirada de 01 bomba-dagua na AP1 e instalação de 01 bomba d\'água.  | mantenedores: Everaldo | materia1: Mão de obra | quantidade1: 1 | valor1: 650 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(31, '77', 'odometerValue:  | maintenanceStartDate: 2022-11-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2022-11-17 | maintenanceFinishTime: 18:00 | id: 77 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Manutenção geral e troca de fiação do quadro. | mantenedores: Everaldo | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(32, '77', 'odometerValue:  | maintenanceStartDate: 2023-05-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-15 | maintenanceFinishTime: 18:00 | id: 77 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | motorCheckbox: motorCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca da chave tá da bomba de descarregamento  | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(33, ' 72', 'odometerValue:  | maintenanceStartDate: 2023-06-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-16 | maintenanceFinishTime: 18:00 | id: 72 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão do painel de instrumentos, 01 relógio de temperatura  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(34, '70', 'odometerValue:  | maintenanceStartDate: 2023-06-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-14 | maintenanceFinishTime: 18:00 | id: 70 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de instalação, troca de fios e cabos, serviços de motor de partida, principal e reserva. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 1100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(35, '71', 'odometerValue:  | maintenanceStartDate: 2023-07-08 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-08 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Confecção de um protetor para o radiador | mantenedores: Frank  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(36, '70', 'odometerValue:  | maintenanceStartDate: 2023-02-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-17 | maintenanceFinishTime: 18:00 | id: 70 | radio-maintenance: preventiva | motorCheckbox: motorCheckbox | combustivelCheckbox: combustivel | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoLimpezaCheckbox: intervencaoLimpezaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: revisão troca de óleo e filtro	Trocados : Óleo do motor, filtro de óleo do motor, filtro racool, mangueira do geral do diesel e lavado os dois tanques de combustível | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(37, '70', 'odometerValue:  | maintenanceStartDate: 2023-08-06 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-19 | maintenanceFinishTime: 18:00 | id: 70 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão, Instalação e reposição do motor de partida  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2: material | quantidade2: 1 | valor2: 250 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(38, '74', 'odometerValue:  | maintenanceStartDate: 2023-09-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-19 | maintenanceFinishTime: 18:00 | id: 74 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Recuperação, instalação e reposição de cabos, baterias e motor de partida  | mantenedores: Eládio | materia1: Valor Material | quantidade1: 1 | valor1: 600 | materia2: Mão de obra | quantidade2: 1 | valor2: 600 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(39, '71', 'odometerValue:  | maintenanceStartDate: 2023-09-11 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-19 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Recuperação e instalação de giroflex e sirene  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(40, '71', 'odometerValue:  | maintenanceStartDate: 2023-10-11 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-10-13 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Recuperação, instalação, retirada e reposição de cabos elétricos  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2: Valor material | quantidade2: 1 | valor2: 500 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(41, '71', 'odometerValue:  | maintenanceStartDate: 2023-11-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-15 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | observacoes: Serviço no motor de partida | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(46, '75 ', 'odometerValue:  | maintenanceStartDate: 2023-11-22 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-24 | maintenanceFinishTime: 18:00 | id: 75 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Serviço de instalação elétrica - 03 MTs de cabo de bateria - 05 Terminais ponteira - 01 chave geral  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 450 | materia2: Material | quantidade2: 1 | valor2: 450 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(47, '', 'odometerValue:  | maintenanceStartDate: 2023-12-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-12-15 | maintenanceFinishTime: 18:00 | id: 72 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Serviço de alternador , troca de terminais de bateria | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 350 | materia2: Material | quantidade2: 1 | valor2: 350 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(48, '', 'odometerValue:  | maintenanceStartDate: 2023-12-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-12-21 | maintenanceFinishTime: 18:00 | id: 73 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: recuperação, instalação e troca de sensores do alarme de nível, recuperação do painel do instrumento de alarme de nível, instalação do motor do limpador de parabrisa, lampada da bússola, troca de cabos e sensores do alarme de nível da sala de máquinas | mantenedores: Eládio | materia1: mão de obra | quantidade1: 1 | valor1: 1200 | materia2: material | quantidade2: 1 | valor2: 1200 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(49, '', 'odometerValue:  | maintenanceStartDate: 2023-01-22 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-25 | maintenanceFinishTime: 18:00 | id: 73 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Serviço de instalação geral, Instalação de antena, GPS, rádio, limpador, buzina, confecção e montagem de quadro de instrumento e caixa de bateria | mantenedores: Eládio | materia1: mão de obra | quantidade1: 1 | valor1: 4500 | materia2: material | quantidade2: 1 | valor2: 4500 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(50, '', 'odometerValue:  | maintenanceStartDate: 2023-01-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-15 | maintenanceFinishTime: 18:00 | id: 72 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: serviço de alternador, recuperação da base e troca da correia  | mantenedores: Eládio | materia1: mão de obra | quantidade1: 1 | valor1: 250 | materia2: material | quantidade2: 1 | valor2: 250 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(51, '', 'odometerValue:  | maintenanceStartDate: 2024-06-24 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-06-28 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: preventiva | observacoes: Limpeza de 15 Cofferdans, 2 tanques de combustível e lavagem geral da balsa | mantenedores: Jean  | materia1: Mão de obra | quantidade1: 1 | valor1: 3000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(52, '', 'odometerValue:  | maintenanceStartDate: 2024-06-26 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-06-28 | maintenanceFinishTime: 18:00 | id: 71 | radio-maintenance: corretiva | observacoes: Manutenção das  vávulas de descarregamento | mantenedores:  | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(53, '', 'odometerValue:  | maintenanceStartDate: 2024-06-27 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-06-28 | maintenanceFinishTime: 18:00 | id: 72 | radio-maintenance: preventiva | observacoes: Limpeza de casco | mantenedores: Jean | materia1: M | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(54, '', 'odometerValue:  | maintenanceStartDate: 2024-06-18 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-06-21 | maintenanceFinishTime: 18:00 | id: 70 | radio-maintenance: preventiva | outroCheckbox: outroCheckbox | observacoes: Instalação e confecção de um banco para o comando. | mantenedores: Mário | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fotos`
--

CREATE TABLE `fotos` (
  `caminho` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `fotos`
--

INSERT INTO `fotos` (`caminho`) VALUES
('embarcacao/WhatsApp Image 2024-03-26 at 16.04.35.jpeg'),
('embarcacao/20240228_155624.jpg'),
('implemento/WhatsApp Image 2024-02-26 at 17.12.12.jpeg'),
('implemento/pessoas-tiram-fotos-junto-do-touro-de-ouro-escultura-inaugurada-em-frente-a-sede-da-b3-1637095398341_v2_900x506.jpg'),
('tanque/Captura de tela de 2024-03-23 09-48-49.png'),
('veiculo/Captura de tela de 2024-03-23 09-30-21.png'),
('embarcacao/264548_588803857876473_173865530_n.jpg'),
('implemento/Captura de tela de 2024-03-26 19-38-27.png'),
('implemento/Captura de tela de 2024-03-26 19-38-27.png'),
('tanque/Captura de tela de 2024-03-23 09-30-21.png'),
('veiculo/430097932_7281567705270097_5972524756072621974_n.jpg'),
('embarcacao/433183933_18426916492016873_9061483184095530678_n.jpg'),
('veiculo/Captura de tela de 2024-03-23 09-48-49.png'),
('implemento/431137614_955864559234430_1938277859405268141_n.jpg'),
('tanque/WhatsApp Image 2019-07-08 at 10.44.54 AM.jpeg'),
('tanque/WhatsApp Image 2019-07-08 at 10.44.54 AM.jpeg'),
('embarcacao/20240325_170235.jpg'),
('embarcacao/Contact_Information.png'),
('embarcacao/doja.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/Contact_Information.png'),
('embarcacao/icons8-wi-fi-off-96.png'),
('embarcacao/Imagem do WhatsApp de 2023-07-20 à(s) 16.38.55.jpg'),
('embarcacao/icons8-wi-fi-off-96.png'),
('embarcacao/icons8-wi-fi-off-96.png'),
('embarcacao/icons8-wi-fi-off-96.png'),
('embarcacao/icons8-wi-fi-off-96.png'),
('embarcacao/doja.png'),
('embarcacao/doja.png'),
('embarcacao/IMG_20200506_093634.jpg'),
('embarcacao/WhatsApp Image 2024-03-29 at 11.15.00 PM.jpeg'),
('implemento/WhatsApp Image 2024-02-23 at 10.56.03.jpeg'),
('tanque/20240325_170431.jpg'),
('veiculo/20240325_170431.jpg'),
('veiculo/20200123_143818(1).jpg'),
('embarcacao/Contact_Information.png'),
('embarcacao/Fn_fa08XwAAJs0b.jpeg'),
('embarcacao/Contact_Information.png'),
('embarcacao/triu.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/Snapinsta.app_435569592_941784110783564_8970030545133563130_n_1080.jpeg'),
('embarcacao/thoth-1024-x-1024-wallpaper-1b74opjel6h8z0gh.webp'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/flutuante.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/teatro amazonas.jpg'),
('embarcacao/ap_marine_1.png'),
('embarcacao/logo_ap_marine.png'),
('embarcacao/ap-marine4.png'),
('embarcacao/AMC_1.png'),
('embarcacao/logo_ap_marine.png'),
('embarcacao/logo_ap_marine.png'),
('embarcacao/logo_ap_marine.png'),
('embarcacao/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('tanque/Fimaco_Blog_Tanque-de-armazenamento-importancia-da-qualidade-na-industria-de-alimentos-scaled.jpg'),
('veiculo/logo_ap_marine.png'),
('veiculo/SAL-0G83 - FOTO FRENTE.jpeg'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('veiculo/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('tanque/AMC_1.png'),
('embarcacao/Captura de tela de 2024-04-14 16-02-55.png'),
('implemento/craiyon_104943_future_green_city_with_big_skycrapper_like_trees_linked_by_bridge.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('implemento/logo_ap_marine.png'),
('veiculo/0df9684f7b7e44c0bea0df6aa4b69e2b.webp'),
('implemento/canonical-renovou-o-logotipo-do-ubuntu-1.jpg'),
('implemento/3.jpeg'),
('implemento/20210709065704_revolução capa.jpg'),
('implemento/0df9684f7b7e44c0bea0df6aa4b69e2b.jpg'),
('implemento/449030011_1201367121298071_4966564204391865968_n.jpg'),
('veiculo/450987386_18417327370068707_3282432111833703729_n.jpg'),
('implemento/GM53U98WMAAj8w6.jpeg'),
('veiculo/orgulho_negro_importancia_detailed.png'),
('veiculo/banner_site_FT_ps2024.png'),
('veiculo/WhatsApp Image 2024-04-29 at 10.36.39.jpeg'),
('embarcacao/451865294_18453340186063289_919201227180aaaa8478734_n.jpg'),
('implemento/Semaaa título.jpeg'),
('veiculo/448881428_1012142687154269_1649374715508568554_n.jpg'),
('veiculo/ubuntu-pictures-m67dfn6hxfo9v391.jpg'),
('veiculo/orgulho_negro_importancia.png'),
('implemento/orgulho_negro_importancia.png'),
('implemento/66015308_2792235644183933_5553662888645754880_n.jpg'),
('implemento/449680742_7795996093840870_7330328140431184070_n.jpg'),
('implemento/craiyon_104807_generate_nice_looking_logo_of_bitcoin_in_beautiful_green_and_blue_colored_ecology_env.png'),
('implemento/GS3bjSJX0AAC_qt.jpeg'),
('veiculo/WhatsApp Image 2019-11-11 at 7.28.23 PM.jpeg'),
('implemento/GRkSy_CWMAEWbPq.jpeg'),
('veiculo/GTQk7XWWEAApshH.jpeg'),
('implemento/GS1Abs_bYAAGh1s.jpeg'),
('implemento/Semaaa título.jpeg'),
('implemento/95f6536533dcf06b3eca5e120cbbe4d4.png'),
('implemento/IMG_20240715_133258243.jpg'),
('implemento/IMG_20240715_133305896.jpg'),
('implemento/IMG_20240716_084424599.jpg'),
('implemento/IMG_20240716_084411065.jpg'),
('veiculo/download.jpg'),
('veiculo/foto caminhao toco.jpg'),
('veiculo/1000132280.jpg'),
('veiculo/1000132280.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `implemento_os`
--

CREATE TABLE `implemento_os` (
  `id` int(111) NOT NULL,
  `id_ativo` varchar(4) NOT NULL,
  `dados` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `implemento_os`
--

INSERT INTO `implemento_os` (`id`, `id_ativo`, `dados`) VALUES
(18, '32', 'odometerValue: 000 | maintenanceStartDate: 2024-02-13 | maintenanceStartTime: 13:00 | maintenanceEndDate: 2024-02-15 | maintenanceFinishTime: 17:00 | id: 32 | radio-maintenance: preventiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoLubrificadoCheckbox: intervencaoLubrificadoCheckbox | intervencaoInspecionadoCheckbox: intervencaoInspecionadoCheckbox | observacoes: Solicitante: Aldemis\r\n\r\nDescrição e instalação: 02 jogos de lona, 01 tambor de Freio, 02 pino rei, 08 juntas da tampa do cubo, 04 eixos \"5\", 04 buchas do eixo \"5\", 08 aranha trava. OBS: lubrificado todos os rolamentos do cubo de roda. Feita revisão na parte elétrica.\r\n\r\nMaterial usado: \r\n02 pino rei\r\n02 jogos de lona \r\n01 tambor de freio \r\n08 junta de cubo de roda\r\n04 bucha do eixo \"5\"'),
(19, '34', 'odometerValue: 000 | maintenanceStartDate: 2024-02-02 | maintenanceStartTime: 14:00 | maintenanceEndDate: 2024-02-02 | maintenanceFinishTime: 17:00 | id: 34 | radio-maintenance: corretiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Nome do Solicitante: Daniel Silva\r\n\r\nRemoção e instalação na Válvula de fundo.'),
(20, '35', 'odometerValue: 000 | maintenanceStartDate: 2024-03-06 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-03-08 | maintenanceFinishTime: 12:00 | id: 35 | radio-maintenance: preditiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Nome do solicitante: Não possui. \r\n\r\nRevisão Geral de Freio: \r\n\r\nTrocado as lonas geral. \r\nTrocado 08 buchas do eixo \"5\". \r\nTrocado 08 junta do cubo de roda. \r\nTrocado 8 aranha trava. \r\nLubricado todos os 8 cubos de roda. \r\nRegulado freio.'),
(21, '32', 'odometerValue: 000 | maintenanceStartDate: 2024-02-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-02-28 | maintenanceFinishTime: 17:00 | id: 32 | radio-maintenance: corretiva | observacoes: Nome do Solicitante: Aldenilson Silva. \r\nVincular: jud7081/juo7f21\r\n\r\nTrocado 02 pino rei, 03 cuica de freio, tracado 1 válvula de emergência, regulador de freio. \r\n\r\nMaterias utilizados: \r\n\r\n3 cuicas de freio 30x30\r\n1 válcula de emergência \r\n2 pino rei'),
(22, '36', 'odometerValue: 000 | maintenanceStartDate: 2024-02-21 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-02-23 | maintenanceFinishTime: 12:00 | id: 36 | radio-maintenance: preditiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Nome do solicitante: Daniel Silva. \r\n\r\nRemoção e instalação: 1 portinhola, 2 faixas do para-choque, 2 cuicas de freio, 2 válculas de descarga rápida, freio regulado. \r\n\r\nMateriais utilizados: \r\n\r\n01 portinhola\r\n02 faixa de para-choque \r\n02 cuica de freio \r\n02 válvulas de descarga rápida'),
(23, '27', 'odometerValue: 000 | maintenanceStartDate: 2024-04-11 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-04-11 | maintenanceFinishTime: 17:00 | id: 27 | radio-maintenance: preditiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Nome do solicitante: AP Marine \r\n\r\nRevisão de freio (corretiva). \r\nRemoção e instalação de 03 jogos de Lona. \r\n\r\nMaterial utilizado: \r\n\r\n03 lonas de freio.'),
(24, '37', 'odometerValue: 000 | maintenanceStartDate: 2024-04-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-04-18 | maintenanceFinishTime: 17:00 | id: 37 | radio-maintenance: preditiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Nome do solicitante: AP Marine \r\n\r\nRemoção e instalação: \r\n\r\n05 - tambor de freio \r\n06 - catraca de freio \r\n03 - jogos de lona de freio \r\n06 - kit de bucha do eixo \"5\"\r\n06 - junta da tampa de cubo \r\n10 - molas do patins de freio \r\n12 - rolamentos do cubo de roda \r\n\r\nMateriais utilizados: \r\n\r\n05 - tambor de freio \r\n06 - ajustador mecânico \r\n3 - jogos de lona de freio \r\n06 - kit de bucha do eixo \"5\"\r\n12 - rolamento do cubo de roda \r\n10 - mola do patins \r\n'),
(27, '32', 'odometerValue:  | maintenanceStartDate: 2024-05-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-05-13 | maintenanceFinishTime: 17:00 | id: 32 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | freiosCheckbox: freiosCheckbox | semFreioCheckbox: Sem freio | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Remoção e instalação de lona de freio geral, trocado 4 retentor do cubo e 4 aranha trava.\r\n | mantenedores: Heber costa aguiar  | materiaisUtilizados: 4 jogos de lona\r\n4 retentor do cubo \r\n12 molas do patins'),
(29, '38', 'odometerValue:  | maintenanceStartDate: 2023-01-04 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-05 | maintenanceFinishTime: 18:00 | id: 38 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoSoldadoCheckbox: intervencaoSoldadoCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | observacoes: Confecção da rampa do cavalo. \nMontagem da rampa. Material usado: chapa de 0.09 x 1.20 x 3/8 (4 unidades); Solda 1/2 kg; massarico; lata de spray preta - Caminhão do ABDIAS | mantenedores: Franck | materia1: chapa de 0.09 x 1.20 x 3/8  | quantidade1: 4 | valor1: 0 | materia2: Solda 1/2 kg | quantidade2: 1 | valor2: 0 | materia3: massarico | quantidade3: 1 | valor3: 0 | materia4: lata de spray preta | quantidade4: 1 | valor4: 0 | materia5:  | quantidade5:  | valor5:'),
(30, '39', 'odometerValue:  | maintenanceStartDate: 2023-01-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-13 | maintenanceFinishTime: 18:00 | id: 39 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | intervencaoPinturaCheckbox: intervencaoPinturaCheckbox | observacoes: Pintura em textura de piso antiderrapante. | mantenedores: Emerson  | materia1: Mão de Obra  | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(31, '40', 'odometerValue:  | maintenanceStartDate: 2023-01-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-13 | maintenanceFinishTime: 18:00 | id: 40 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | intervencaoPinturaCheckbox: intervencaoPinturaCheckbox | observacoes: Pintura em textura de piso antiderrapante. | mantenedores: Emerson | materia1: Tinta  | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(32, '36', 'odometerValue:  | maintenanceStartDate: 2023-01-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-13 | maintenanceFinishTime: 18:00 | id: 36 | radio-maintenance: corretiva | intervencaoPinturaCheckbox: intervencaoPinturaCheckbox | observacoes: Pintura em textura de piso antiderrapante. | mantenedores: Emerson  | materia1: Tinta  | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(33, '41', 'odometerValue:  | maintenanceStartDate: 2023-01-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-13 | maintenanceFinishTime: 18:00 | id: 41 | radio-maintenance: corretiva | intervencaoPinturaCheckbox: intervencaoPinturaCheckbox | observacoes: Pintura em textura de piso antiderrapante. | mantenedores: Emerson  | materia1: Material geral  | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(34, '42', 'odometerValue:  | maintenanceStartDate: 2022-12-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2022-12-28 | maintenanceFinishTime: 18:00 | id: 42 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | transmissaoCheckbox: transmissaoCheckbox | tanqueCheckbox: tanqueCheckbox | rompidoCheckbox: Rompido | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Substituição do Cardan da bomba de descarregamento.  | mantenedores: Héber Costa Aguiar  | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(35, '18', 'odometerValue:  | maintenanceStartDate: 2022-12-26 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2022-12-26 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | suspensaoCheckbox: suspensaoCheckbox | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Substituição; 2 rolamentos do cubo de roda, 2 retentores do cubo.\r\nSubstituição; 8 buchas do tirante, suporte do feixe de mola. | mantenedores: Héber Costa Aguiar  | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(36, '43', 'odometerValue:  | maintenanceStartDate: 2023-01-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-12 | maintenanceFinishTime: 18:00 | id: 43 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | rompidoCheckbox: Rompido | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Válvula de fundo e portinhola.	\r\nReparo de solda do suporte da válvula. | mantenedores: Frank  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(37, '40', 'odometerValue:  | maintenanceStartDate: 2023-01-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-17 | maintenanceFinishTime: 18:00 | id: 40 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Reparo de chassis ou alteração.	\r\nTroca da chapa da mesa do pino-rei. | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(38, '18', 'odometerValue:  | maintenanceStartDate: 2023-01-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-23 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | rompidoCheckbox: Rompido | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | observacoes: Serviço de solda na balança. | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(39, '18', 'odometerValue:  | maintenanceStartDate: 2023-01-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-23 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Serviço de solda na balança. | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(40, '42', 'odometerValue:  | maintenanceStartDate: 2023-02-04 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-10 | maintenanceFinishTime: 18:00 | id: 42 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Serviço de socorro e reparo do alternador. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 800 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(41, '18', 'odometerValue:  | maintenanceStartDate: 2023-02-10 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-10 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | semFreioCheckbox: Sem freio | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de 1 cuica de freio. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(42, '22', 'odometerValue:  | maintenanceStartDate: 2023-03-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-02 | maintenanceFinishTime: 18:00 | id: 22 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de 01 suporte da balança, troca de 1 pino da balança,  troca de 04 buchas da balança, troca de 02 parafusos do tirante, retificada a rampa. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(43, '22', 'odometerValue:  | maintenanceStartDate: 2023-03-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-02 | maintenanceFinishTime: 18:00 | id: 22 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de 01 suporte da balança, troca de 1 pino da balança,  troca de 04 buchas da balança, troca de 02 parafusos do tirante, retificada a rampa. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(44, '42', 'odometerValue:  | maintenanceStartDate: 2023-02-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-28 | maintenanceFinishTime: 18:00 | id: 42 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | queimadoCheckbox: Queimado | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de instalação, troca e confecção do chicote, 02 tomadas macho, 01 chicote sanfonado. | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(45, '42', 'odometerValue:  | maintenanceStartDate: 2023-03-10 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-10 | maintenanceFinishTime: 18:00 | id: 42 | radio-maintenance: preventiva | outroCheckbox: outroCheckbox | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoInstaladoCheckbox: intervencaoInstaladoCheckbox | observacoes: Instalação de 1 sirene de ré. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 50 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(46, '22', 'odometerValue:  | maintenanceStartDate: 2023-03-09 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-09 | maintenanceFinishTime: 18:00 | id: 22 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoInstaladoCheckbox: intervencaoInstaladoCheckbox | observacoes: Revisão geral de faróis e lanternas, troca de 2 lentes da lanterna traseira. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(47, '22', 'odometerValue:  | maintenanceStartDate: 2023-03-09 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-09 | maintenanceFinishTime: 18:00 | id: 22 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão geral de faróis e lanternas, troca de 2 lentes da lanterna traseira. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(48, '38', 'odometerValue:  | maintenanceStartDate: 2023-03-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-02 | maintenanceFinishTime: 18:00 | id: 38 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca do motor do vidro elétrico e reposição de acessórios do retrovisor. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 450 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(49, '27', 'odometerValue:  | maintenanceStartDate: 2023-04-04 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-04 | maintenanceFinishTime: 18:00 | id: 27 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: reparo de chassis ou alteração.\r\nConfecção de suporte de cones. | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(50, '36', 'odometerValue:  | maintenanceStartDate: 2023-03-31 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-31 | maintenanceFinishTime: 18:00 | id: 36 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | observacoes: Reparo de chassis ou alteração.	\r\nSolda na chapa do pino rei. | mantenedores: Frank  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(51, '35', 'odometerValue:  | maintenanceStartDate: 2023-04-04 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-04 | maintenanceFinishTime: 18:00 | id: 35 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | queimadoCheckbox: Queimado | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de lanternas do bitrem. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(52, '32', 'odometerValue:  | maintenanceStartDate: 2023-03-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-28 | maintenanceFinishTime: 18:00 | id: 32 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Confecção de um suporte de cone. | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(53, '36', 'odometerValue:  | maintenanceStartDate: 2023-03-30 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-30 | maintenanceFinishTime: 18:00 | id: 36 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Solda na chapa de suporte do pino-rei. | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(54, '29', 'odometerValue:  | maintenanceStartDate: 2023-03-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-23 | maintenanceFinishTime: 18:00 | id: 29 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Solda em suporte do apoio do tanque. | mantenedores: Frank  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(55, '22', 'odometerValue:  | maintenanceStartDate: 2023-03-21 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-21 | maintenanceFinishTime: 18:00 | id: 22 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Recuperação do chicote do módulo do motor. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2: material | quantidade2: 1 | valor2: 2064 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(56, '30', 'odometerValue:  | maintenanceStartDate: 2024-06-24 | maintenanceStartTime: 08:10 | maintenanceEndDate: 2024-06-24 | maintenanceFinishTime: 12:00 | id: 30 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | freiosCheckbox: freiosCheckbox | trincadoCheckbox: Trincado | causaFissuraCheckbox: causaFissuraCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Remoção e instalação do cubo de roda ,regulado o freio. | mantenedores: Heber costa aguiar  | materia1: Cubo de roda  | quantidade1: 1 | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(57, '36', 'odometerValue:  | maintenanceStartDate: 2023-03-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-28 | maintenanceFinishTime: 18:00 | id: 36 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de instalação e troca de tomadas e lanternas do bitrem | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(58, '29', 'odometerValue:  | maintenanceStartDate: 2023-03-27 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-27 | maintenanceFinishTime: 18:00 | id: 29 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de instalação geral e troca de lanternas traseira e três Marias  | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(59, '29', 'odometerValue:  | maintenanceStartDate: 2023-03-25 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-25 | maintenanceFinishTime: 18:00 | id: 29 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | observacoes: CIV e CNPP. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 400 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(60, '44', 'odometerValue:  | maintenanceStartDate: 2023-04-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-17 | maintenanceFinishTime: 18:00 | id: 44 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Reparo de chassis ou alteração.	\r\nTroca da chapa da mesa da 5 roda e pés.  | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(61, '23', 'odometerValue:  | maintenanceStartDate: 2023-04-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-12 | maintenanceFinishTime: 18:00 | id: 23 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes:  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2: Valor material | quantidade2: 1 | valor2: 50 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(63, '18', 'odometerValue:  | maintenanceStartDate: 2023-04-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-12 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão de instalação. | mantenedores: Eládio | materia1: Valor Material | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(64, '42', 'odometerValue:  | maintenanceStartDate: 2023-04-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-12 | maintenanceFinishTime: 18:00 | id: 42 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de bateria e revisão dos cabos dos terminais  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(65, '44', 'odometerValue:  | maintenanceStartDate: 2023-05-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-02 | maintenanceFinishTime: 18:00 | id: 44 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | intervencaoFixadoCheckbox: intervencaoFixadoCheckbox | intervencaoLubrificadoCheckbox: intervencaoLubrificadoCheckbox | observacoes: Revisão e reposição de instalação, 02 lanternas laterais led | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(66, '37', 'odometerValue:  | maintenanceStartDate: 2023-05-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-16 | maintenanceFinishTime: 18:00 | id: 37 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão geral de instalação, reposição de lanternas traseira e lateral, 02 lanternas redondas traseira, 02 lanternas laterais, 04 lâmpadas 1034 24v, 03 lâmpadas 1141 24v, 02 lâmpadas 64 24v | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(67, '38', 'odometerValue:  | maintenanceStartDate: 2023-04-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-28 | maintenanceFinishTime: 18:00 | id: 38 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão da bomba de engrenagem, Cardan e troca do flange do cardan | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(68, '37', 'odometerValue:  | maintenanceStartDate: 2023-05-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-15 | maintenanceFinishTime: 18:00 | id: 37 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de : 01 pino rei, retoque de pintura, faixa de parachoque traseiro, regulagem de freios | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(69, '25', 'odometerValue:  | maintenanceStartDate: 2023-06-06 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-06 | maintenanceFinishTime: 18:00 | id: 25 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca da tampa do tanque completa  | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(70, '45', 'odometerValue:  | maintenanceStartDate: 2023-06-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-15 | maintenanceFinishTime: 18:00 | id: 45 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Placa JTG2J36 - recuperação de instalação: 03 lanternas traseiras, 01 lanterna de placa de led, 01 lanterna lateral de led, 02 lâmpadas 67.24V, 06 lâmpadas 1141.24V | mantenedores: Eládio | materia1: Valor Material | quantidade1: 1 | valor1: 200 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(71, '46', 'odometerValue:  | maintenanceStartDate: 2023-06-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-14 | maintenanceFinishTime: 18:00 | id: 46 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: NEP 0271 - Revisão de instalação e lanternas: 01 lanterna lateral, 02 lâmpadas 1141.24V, 1 lâmpada 67.24V. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(72, '47', 'odometerValue:  | maintenanceStartDate: 2023-06-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-14 | maintenanceFinishTime: 18:00 | id: 47 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: JTF 2197 - Revisão de instalação e lanternas, 01 lanternas de placa led, 02 lâmpadas 1141.24V, 01 lâmpada 67.24V | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(73, '48', 'odometerValue:  | maintenanceStartDate: 2023-06-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-02 | maintenanceFinishTime: 18:00 | id: 48 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: revisão de instalação l, troca de tomada, troca de lanterna traseira e lateral. 01 tomada redonda de 7 pinos, 02 lanternas traseiras, 03 lanternas laterais, 02 lâmpadas 67.24V, 06 lâmpadas 1141.24V | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(74, '18', 'odometerValue:  | maintenanceStartDate: 2023-06-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-02 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de instalação e troca de lanternas traseira e lateral. 02 lanternas traseira led, 02 lanternas laterais de led. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(75, '42', 'odometerValue:  | maintenanceStartDate: 2023-06-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-16 | maintenanceFinishTime: 18:00 | id: 42 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | intervencaoAlinhadoCheckbox: intervencaoAlinhadoCheckbox | observacoes: Revisão e troca de tomada | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 50 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(76, '27', 'odometerValue:  | maintenanceStartDate: 2023-06-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-16 | maintenanceFinishTime: 18:00 | id: 27 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de instalação e troca de lanternas, 01 tomada redonda 7 polos fêmea.  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 50 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(77, '22', 'odometerValue:  | maintenanceStartDate: 2023-06-27 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-27 | maintenanceFinishTime: 18:00 | id: 22 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | transmissaoCheckbox: transmissaoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Trocados: cilindro de embreagem, mangueira de embreagem. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(78, '30', 'odometerValue:  | maintenanceStartDate: 2023-06-18 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-18 | maintenanceFinishTime: 18:00 | id: 30 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Trocados 04 pneus, regulagem de freio, solda da bucha do S, solda no varão do pé da manivela. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(79, '42', 'odometerValue:  | maintenanceStartDate: 2023-07-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-12 | maintenanceFinishTime: 18:00 | id: 42 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de 02 catracas de freio, 1 bicha do V, limpeza do sensor ABS, retirada do vazamento de óleo do motor | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 700 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(80, '31', 'odometerValue:  | maintenanceStartDate: 2023-06-22 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-22 | maintenanceFinishTime: 18:00 | id: 31 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Troca de 04 pneus, regulagem de freio, solda na bucha do eixo S, soldado e revisado pé do bitrem. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 400 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(81, '18', 'odometerValue:  | maintenanceStartDate: 2023-06-27 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-27 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Solda do suporte de pino da balança, regulagem de freio, verificação de folgas do cubo de roda. | mantenedores: Héber | materia1: Valor Material | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(82, '42', 'odometerValue:  | maintenanceStartDate: 2023-08-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-08-05 | maintenanceFinishTime: 13:00 | id: 42 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de faróis e lanternas  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(83, '30', 'odometerValue:  | maintenanceStartDate: 2023-06-20 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-20 | maintenanceFinishTime: 18:00 | id: 30 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão geral e recuperação de lanternas traseiras  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(84, '28', 'odometerValue:  | maintenanceStartDate: 2023-03-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-03 | maintenanceFinishTime: 18:00 | id: 28 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão corretiva.\r\nTrocados : 01 Pino rei, 02 Para-lamas, 02 Portinhola, 02 Faixa do Para Choque e freio Regulado. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(85, '18', 'odometerValue:  | maintenanceStartDate: 2023-06-29 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-30 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Serviço de colocação de um cabo de aço para servir como gia pr sinto de segurança da carreta. | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(86, '49', 'odometerValue:  | maintenanceStartDate: 2023-08-30 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-01 | maintenanceFinishTime: 18:00 | id: 49 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão preventiva | mantenedores: Eládio | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(87, '27', 'odometerValue:  | maintenanceStartDate: 2023-08-31 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-01 | maintenanceFinishTime: 18:00 | id: 27 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | observacoes: Revisão e instalação de lanternas - 01 Tomada macho redonda | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(88, '28', 'odometerValue:  | maintenanceStartDate: 2023-08-31 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-01 | maintenanceFinishTime: 18:00 | id: 28 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão e instalação de lanternas - 01 Tomada macho Redonda | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(89, '18', 'odometerValue:  | maintenanceStartDate: 2023-08-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-08-18 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes: Troca e instalação de tomadas e lanternas - 10 MTs de cabo 7x1 - 12 MTs de cabo 2x1 - 06 lanternas Lateral Led - 06 soquetes 2 vias - 01 omada Fêmea - 10 MTs de conduíte | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 350 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(90, '18', 'odometerValue:  | maintenanceStartDate: 2023-08-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-08-18 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes: Troca e instalação de tomadas e lanternas - 10 MTs de cabo 7x1 - 12 MTs de cabo 2x1 - 06 lanternas Lateral Led - 06 soquetes 2 vias - 01 omada Fêmea - 10 MTs de conduíte | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 350 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(91, '35', 'odometerValue:  | maintenanceStartDate: 2023-08-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-08-18 | maintenanceFinishTime: 18:00 | id: 35 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Reposição e Instalação de tomadas e Lanternas - 01 Tomada macho - 05 MTs de cabo 7x1 - 06 MTs de cabo 2x1 - 04 Lanternas Led  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(92, '50', 'odometerValue:  | maintenanceStartDate: 2023-08-30 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-08-31 | maintenanceFinishTime: 18:00 | id: 50 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão, instalação e reposição de lanternas - 03 Lanternas Lateral LED  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 305 | materia2: Valor material | quantidade2: 1 | valor2: 105 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:');
INSERT INTO `implemento_os` (`id`, `id_ativo`, `dados`) VALUES
(93, '18', 'odometerValue:  | maintenanceStartDate: 2023-09-04 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-04 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Instalação e trocas de lanternas traseiras e revisão geral | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(94, '51', 'odometerValue:  | maintenanceStartDate: 2023-09-01 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-04 | maintenanceFinishTime: 18:00 | id: 51 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Serviço Elétrico, Luz de ré. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2: Valor material | quantidade2: 1 | valor2: 100 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(95, '52', 'odometerValue:  | maintenanceStartDate: 2023-05-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-05 | maintenanceFinishTime: 18:00 | id: 52 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão geral, troca de lanternas e tomadas. | mantenedores: Eládio | materia1: Mão de Obra | quantidade1: 1 | valor1: 400 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(96, '53', 'odometerValue:  | maintenanceStartDate: 2023-10-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-10-05 | maintenanceFinishTime: 18:00 | id: 53 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão geral, troca de lanternas e tomadas  | mantenedores: Eládio | materia1: Mão de Obra | quantidade1: 1 | valor1: 400 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(97, '54', 'odometerValue:  | maintenanceStartDate: 2023-10-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-10-17 | maintenanceFinishTime: 18:00 | id: 54 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Recuperação, instalação e reposição de tomadas e lanternas traseiras e laterais. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(98, '55', 'odometerValue:  | maintenanceStartDate: 2023-10-26 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-10-30 | maintenanceFinishTime: 18:00 | id: 55 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão geral e troca de lanternas e placas. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(99, '56', 'odometerValue:  | maintenanceStartDate: 2023-10-26 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-10-30 | maintenanceFinishTime: 18:00 | id: 56 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão geral e troca de lanternas e placas  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(100, '32', 'odometerValue:  | maintenanceStartDate: 2023-10-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-10-20 | maintenanceFinishTime: 18:00 | id: 32 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão geral e troca de lanternas e soquetes | mantenedores: Eládio | materia1: Mão de obra  | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(101, '55', 'odometerValue:  | maintenanceStartDate: 2023-11-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-20 | maintenanceFinishTime: 18:00 | id: 55 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: revisão, instalação e troca de tomada e cabo  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(102, '57', 'odometerValue:  | maintenanceStartDate: 2023-11-08 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-10 | maintenanceFinishTime: 18:00 | id: 57 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Instalação de buzina marítima ( Com a Buzina )  | mantenedores: Eládio | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(103, '31', 'odometerValue:  | maintenanceStartDate: 2023-11-08 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-10 | maintenanceFinishTime: 18:00 | id: 31 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão e reposição de lanternas | mantenedores:  | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(104, '29', 'odometerValue:  | maintenanceStartDate: 2023-11-07 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-10 | maintenanceFinishTime: 18:00 | id: 29 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão, instalação e reposição de lanternas traseira e lateral. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2: Valor material | quantidade2: 1 | valor2: 200 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(112, '57', 'odometerValue: 126120 | maintenanceStartDate: 2024-08-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-08-23 | maintenanceFinishTime: 18:00 | id: 57 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Remoção e instalação da lona traseira. \r\nRemoção e instalação da bateria de 180 A. \r\nRegulado freio e lubrificação dos agregados.  | mantenedores: Héber  | materia1: Lona de Freio  | quantidade1: 2 | valor1: 0 | materia2: Bateria  | quantidade2: 2 | valor2: 0 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mtbf_embarcacao`
--

CREATE TABLE `mtbf_embarcacao` (
  `id_ativo` int(11) NOT NULL,
  `mtbf` float NOT NULL,
  `num_os` int(11) NOT NULL,
  `data_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `mtbf_embarcacao`
--

INSERT INTO `mtbf_embarcacao` (`id_ativo`, `mtbf`, `num_os`, `data_registro`) VALUES
(70, 0, 1, '2024-08-02 11:31:43'),
(71, 489.643, 14, '2024-08-02 11:31:43'),
(72, 0, 1, '2024-08-02 11:31:43'),
(74, 2503, 2, '2024-08-02 11:31:43'),
(77, 1084.5, 4, '2024-08-02 11:31:43'),
(78, 196.5, 4, '2024-08-02 11:31:43');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mtbf_implemento`
--

CREATE TABLE `mtbf_implemento` (
  `id_ativo` int(11) NOT NULL,
  `mtbf` float NOT NULL,
  `num_os` int(11) NOT NULL,
  `data_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `mtbf_implemento`
--

INSERT INTO `mtbf_implemento` (`id_ativo`, `mtbf`, `num_os`, `data_registro`) VALUES
(18, 534.182, 11, '2024-08-02 11:31:48'),
(22, 459.667, 6, '2024-08-02 11:31:48'),
(23, 0, 1, '2024-08-02 11:31:48'),
(25, 0, 1, '2024-08-02 11:31:48'),
(27, 2224.5, 4, '2024-08-02 11:31:48'),
(28, 1795, 2, '2024-08-02 11:31:48'),
(29, 1366.5, 4, '2024-08-02 11:31:48'),
(30, 2969.39, 3, '2024-08-02 11:31:48'),
(31, 1663, 2, '2024-08-02 11:31:48'),
(32, 1947, 5, '2024-08-02 11:31:48'),
(34, 0, 1, '2024-08-02 11:31:48'),
(35, 2665.33, 3, '2024-08-02 11:31:48'),
(36, 1931.2, 5, '2024-08-02 11:31:48'),
(37, 2681.33, 3, '2024-08-02 11:31:48'),
(38, 897.333, 3, '2024-08-02 11:31:48'),
(39, 0, 1, '2024-08-02 11:31:48'),
(40, 31, 2, '2024-08-02 11:31:48'),
(41, 0, 1, '2024-08-02 11:31:48'),
(42, 624.25, 8, '2024-08-02 11:31:48'),
(43, 0, 1, '2024-08-02 11:31:48'),
(44, 175, 2, '2024-08-02 11:31:48'),
(45, 0, 1, '2024-08-02 11:31:48'),
(46, 0, 1, '2024-08-02 11:31:48'),
(47, 0, 1, '2024-08-02 11:31:48'),
(48, 0, 1, '2024-08-02 11:31:48'),
(49, 0, 1, '2024-08-02 11:31:48'),
(50, 0, 1, '2024-08-02 11:31:48'),
(51, 0, 1, '2024-08-02 11:31:48'),
(52, 0, 1, '2024-08-02 11:31:48'),
(53, 0, 1, '2024-08-02 11:31:48'),
(54, 0, 1, '2024-08-02 11:31:48'),
(55, 175, 2, '2024-08-02 11:31:48'),
(56, 0, 1, '2024-08-02 11:31:48'),
(57, 0, 1, '2024-08-02 11:31:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mtbf_tanque`
--

CREATE TABLE `mtbf_tanque` (
  `id_ativo` int(11) NOT NULL,
  `mtbf` float NOT NULL,
  `num_os` int(11) NOT NULL,
  `data_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mtbf_veiculo`
--

CREATE TABLE `mtbf_veiculo` (
  `id_ativo` int(11) NOT NULL,
  `mtbf` float NOT NULL,
  `num_os` int(11) NOT NULL,
  `data_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `mtbf_veiculo`
--

INSERT INTO `mtbf_veiculo` (`id_ativo`, `mtbf`, `num_os`, `data_registro`) VALUES
(9, 798.4, 5, '2024-08-02 11:32:05'),
(11, 0, 1, '2024-08-02 11:32:05'),
(13, 544.5, 4, '2024-08-02 11:32:05'),
(14, 873.808, 13, '2024-08-02 11:32:05'),
(15, 0, 1, '2024-08-02 11:32:05'),
(16, 563.2, 5, '2024-08-02 11:32:05'),
(17, 526.286, 7, '2024-08-02 11:32:05'),
(18, 148.5, 4, '2024-08-02 11:32:05'),
(19, 161.333, 3, '2024-08-02 11:32:05'),
(20, 415.667, 6, '2024-08-02 11:32:05'),
(21, 1121.33, 3, '2024-08-02 11:32:05'),
(22, 1250.8, 5, '2024-08-02 11:32:05'),
(23, 0, 1, '2024-08-02 11:32:05'),
(24, 0, 1, '2024-08-02 11:32:05'),
(25, 976.5, 4, '2024-08-02 11:32:05'),
(26, 0, 1, '2024-08-02 11:32:05'),
(27, 1481.33, 3, '2024-08-02 11:32:05'),
(28, 2359, 2, '2024-08-02 11:32:05'),
(29, 0, 1, '2024-08-02 11:32:05'),
(30, 0, 1, '2024-08-02 11:32:05'),
(31, 991, 2, '2024-08-02 11:32:05'),
(32, 0, 1, '2024-08-02 11:32:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mttr_embarcacao`
--

CREATE TABLE `mttr_embarcacao` (
  `id_ativo` int(11) NOT NULL,
  `mttr` float NOT NULL,
  `num_os` int(11) NOT NULL,
  `data_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `mttr_embarcacao`
--

INSERT INTO `mttr_embarcacao` (`id_ativo`, `mttr`, `num_os`, `data_registro`) VALUES
(70, 130, 9, '2024-08-02 11:31:11'),
(71, 47.6429, 14, '2024-08-02 11:31:11'),
(72, 10, 3, '2024-08-02 11:31:11'),
(74, 94, 2, '2024-08-02 11:31:11'),
(77, 109.6, 5, '2024-08-02 11:31:11'),
(78, 40, 4, '2024-08-02 11:31:11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mttr_implemento`
--

CREATE TABLE `mttr_implemento` (
  `id_ativo` int(11) NOT NULL,
  `mttr` float NOT NULL,
  `num_os` int(11) NOT NULL,
  `data_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `mttr_implemento`
--

INSERT INTO `mttr_implemento` (`id_ativo`, `mttr`, `num_os`, `data_registro`) VALUES
(18, 16.5455, 11, '2024-08-02 11:31:17'),
(22, 10, 6, '2024-08-02 11:31:17'),
(23, 10, 1, '2024-08-02 11:31:17'),
(25, 10, 1, '2024-08-02 11:31:17'),
(27, 15.75, 4, '2024-08-02 11:31:17'),
(28, 94, 2, '2024-08-02 11:31:17'),
(29, 28, 4, '2024-08-02 11:31:17'),
(30, 7.94444, 3, '2024-08-02 11:31:17'),
(31, 34, 2, '2024-08-02 11:31:17'),
(32, 32.4, 5, '2024-08-02 11:31:17'),
(34, 3, 1, '2024-08-02 11:31:17'),
(35, 48, 3, '2024-08-02 11:31:17'),
(36, 18.4, 5, '2024-08-02 11:31:17'),
(37, 33.6667, 3, '2024-08-02 11:31:17'),
(38, 18, 3, '2024-08-02 11:31:17'),
(39, 10, 1, '2024-08-02 11:31:17'),
(40, 22, 2, '2024-08-02 11:31:17'),
(41, 10, 1, '2024-08-02 11:31:17'),
(42, 36.375, 8, '2024-08-02 11:31:17'),
(43, 10, 1, '2024-08-02 11:31:17'),
(44, 10, 2, '2024-08-02 11:31:17'),
(45, 10, 1, '2024-08-02 11:31:17'),
(46, 10, 1, '2024-08-02 11:31:17'),
(47, 10, 1, '2024-08-02 11:31:17'),
(48, 10, 1, '2024-08-02 11:31:17'),
(49, 58, 1, '2024-08-02 11:31:17'),
(50, 34, 1, '2024-08-02 11:31:17'),
(51, 82, 1, '2024-08-02 11:31:17'),
(52, 82, 1, '2024-08-02 11:31:17'),
(53, 82, 1, '2024-08-02 11:31:17'),
(54, 58, 1, '2024-08-02 11:31:17'),
(55, 130, 2, '2024-08-02 11:31:17'),
(56, 106, 1, '2024-08-02 11:31:17'),
(57, 58, 1, '2024-08-02 11:31:17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mttr_tanque`
--

CREATE TABLE `mttr_tanque` (
  `id_ativo` int(11) NOT NULL,
  `mttr` float NOT NULL,
  `num_os` int(11) NOT NULL,
  `data_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mttr_veiculo`
--

CREATE TABLE `mttr_veiculo` (
  `id_ativo` int(11) NOT NULL,
  `mttr` float NOT NULL,
  `num_os` int(11) NOT NULL,
  `data_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Despejando dados para a tabela `mttr_veiculo`
--

INSERT INTO `mttr_veiculo` (`id_ativo`, `mttr`, `num_os`, `data_registro`) VALUES
(9, 9.14286, 7, '2024-08-02 11:31:33'),
(11, 14, 6, '2024-08-02 11:31:33'),
(13, 8.6, 5, '2024-08-02 11:31:33'),
(14, 119.731, 13, '2024-08-02 11:31:33'),
(15, 269.109, 17, '2024-08-02 11:31:33'),
(16, 10, 5, '2024-08-02 11:31:33'),
(17, 54.5714, 7, '2024-08-02 11:31:33'),
(18, 734.6, 5, '2024-08-02 11:31:33'),
(19, 29.0909, 11, '2024-08-02 11:31:33'),
(20, 20.2857, 7, '2024-08-02 11:31:33'),
(21, 10, 3, '2024-08-02 11:31:33'),
(22, 70, 5, '2024-08-02 11:31:33'),
(23, 58, 1, '2024-08-02 11:31:33'),
(24, 10, 1, '2024-08-02 11:31:33'),
(25, 10, 4, '2024-08-02 11:31:33'),
(26, 10, 1, '2024-08-02 11:31:33'),
(27, 122, 3, '2024-08-02 11:31:33'),
(28, 34, 3, '2024-08-02 11:31:33'),
(29, 54, 1, '2024-08-02 11:31:33'),
(30, 202, 1, '2024-08-02 11:31:33'),
(31, 118, 2, '2024-08-02 11:31:33'),
(32, 10, 1, '2024-08-02 11:31:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `operador`
--

CREATE TABLE `operador` (
  `id` int(3) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `funcao` varchar(150) NOT NULL,
  `matricula` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `operador`
--

INSERT INTO `operador` (`id`, `nome`, `funcao`, `matricula`, `email`, `senha`) VALUES
(1, 'Héber Soares', 'Mecânico chefe', '123456', 'roo@root', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Estrutura para tabela `os_2023`
--

CREATE TABLE `os_2023` (
  `Carimbo de data/hora` varchar(19) DEFAULT NULL,
  `CARRETA, PLACA OU ITEM` varchar(17) DEFAULT NULL,
  `DATA INICIAL` varchar(10) DEFAULT NULL,
  `DATA FINAL` varchar(10) DEFAULT NULL,
  `EXECUTOR` varchar(8) DEFAULT NULL,
  `EMPRESA` varchar(9) DEFAULT NULL,
  `SERVIÇO` varchar(52) DEFAULT NULL,
  `DESCRIÇÃO` varchar(257) DEFAULT NULL,
  `SETOR` varchar(7) DEFAULT NULL,
  `Valor serviço` varchar(12) DEFAULT NULL,
  `Valor material` varchar(14) DEFAULT NULL,
  `Quilometragem` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `os_2023`
--

INSERT INTO `os_2023` (`Carimbo de data/hora`, `CARRETA, PLACA OU ITEM`, `DATA INICIAL`, `DATA FINAL`, `EXECUTOR`, `EMPRESA`, `SERVIÇO`, `DESCRIÇÃO`, `SETOR`, `Valor serviço`, `Valor material`, `Quilometragem`) VALUES
('09/01/2023 10:14:09', 'MG IV', '06/01/2023', '06/01/2023', 'Everaldo', 'RMS', 'Elétrica em geral', 'Troca de lâmpadas e reator do refletor\nInstalação do exaustor', 'BALSA', ' R$  500,00 ', '', ''),
('09/01/2023 10:16:03', 'AP4', '06/01/2023', '06/01/2023', 'Everaldo', 'RMS', 'Elétrica em geral', 'Troca de refletor, reator e lâmpada\nInstalação da bomba\nCompra do gerador', 'BALSA', ' R$  500,00 ', '', ''),
('09/01/2023 10:27:45', 'OEZ9A84', '04/01/2023', '05/01/2023', 'Franck', 'AP MARINE', 'Confecção da rampa do cavalo ', 'Montagem da rampa. Material usado: chapa de 0.09 x 1.20 x 3/8 (4 unidades); Solda 1/2 kg; massarico; lata de spray preta - Caminhão do ABDIAS', 'PÁTIO', '', '', ''),
('09/01/2023 10:31:03', 'QVW1J69', '02/01/2023', '03/01/2023', 'Franck', 'AP MARINE', 'Confecção da rampa do cavalo ', 'Barra chata 0.09 x 1.20 x 3/8 - 4 chapas; massarico, solda, lata de spray preto. ', 'PÁTIO', '', '', ''),
('09/01/2023 14:20:41', 'QLS2H91', '09/01/2023', '09/01/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca do retentor do cubo de roda; troca da aranha trava.', 'OFICINA', ' R$  300,00 ', '', ''),
('11/01/2023 08:49:36', 'AP4', '07/01/2023', '07/01/2023', 'Rafael', 'RMS', 'rancho', 'Rancho Mensal', 'BALSA', ' R$  795,53 ', '', ''),
('11/01/2023 12:04:45', 'AP4', '11/01/2023', '11/01/2023', 'Everaldo', 'RMS', 'gerador elétrico', 'Troca do gerador da ponta de eixo ', 'BALSA', ' R$  300,00 ', ' R$  6.140,00 ', ''),
('13/01/2023 15:48:40', 'NEM-3774', '13/01/2023', '13/01/2023', 'Emerson', 'AP MARINE', 'pintura', 'Pintura em textura de piso antiderrapante.', 'OFICINA', '300', '', ''),
('13/01/2023 15:49:33', 'NEO-3703', '13/01/2023', '13/01/2023', 'Emerson', 'AP MARINE', 'pintura', 'Pintura em textura de piso antiderrapante.', 'OFICINA', '300', '', ''),
('13/01/2023 15:50:43', 'KJU 3497', '13/01/2023', '13/01/2023', 'Emerson', 'AP MARINE', 'pintura', 'Pintura em textura de piso antiderrapante.', 'OFICINA', '150', '', ''),
('13/01/2023 15:52:44', 'KJU 3307', '13/01/2023', '13/01/2023', 'Emerson', 'AP MARINE', 'pintura', 'Pintura em textura de piso antiderrapante.', 'OFICINA', '150', '', ''),
('13/01/2023 15:53:29', 'NKD-5977', '13/01/2023', '13/01/2023', 'Emerson', 'AP MARINE', 'pintura', 'Pintura em textura de piso antiderrapante.', 'OFICINA', '150', '', ''),
('13/01/2023 15:54:04', 'NKD-5897', '13/01/2023', '13/01/2023', 'Emerson', 'AP MARINE', 'pintura', 'Pintura em textura de piso antiderrapante.', 'OFICINA', '150', '', ''),
('13/01/2023 16:44:02', 'AP4', '11/01/2023', '13/01/2023', 'Everaldo', 'RMS', 'gerador elétrico', 'Manutenção do gerador MCA', 'BALSA', '700', '', ''),
('16/01/2023 09:53:41', 'NEO-3703', '14/12/2022', '14/12/2022', 'Heber', 'AP MARINE', 'revisão preventiva', 'Troca de pino-rei, colocado espelho da roda.', 'OFICINA', '125', '', ''),
('16/01/2023 09:58:02', 'NEO-3703', '14/12/2022', '14/12/2022', 'Heber', 'AP MARINE', 'pneu', 'Trocado 2 pneus', 'OFICINA', '125', '', ''),
('16/01/2023 09:59:17', 'NEO-3703', '14/12/2022', '14/12/2022', 'Heber', 'AP MARINE', 'reparo de chassis ou alteração', 'Feito antiderrapante, colocada faixa lateral e faixa do parachoque.', 'OFICINA', '125', '', ''),
('16/01/2023 10:00:31', 'NEO-3703', '14/12/2022', '14/12/2022', 'Heber', 'AP MARINE', 'freio e acessórios', 'Regulagem de freio e colocação de mangueira de descida.', 'OFICINA', '125', '', ''),
('16/01/2023 10:02:23', 'NEO-3703', '14/12/2022', '14/12/2022', 'Heber', 'AP MARINE', 'suspensão e acessórios', 'Substituição de;  1 balança,  1 pino de balança, 3 molas-mestras, 6 buchas do tirante', 'OFICINA', '400', '', ''),
('16/01/2023 10:03:49', 'NEO-3703', '04/01/2023', '04/01/2023', 'Heber', 'AP MARINE', 'freio e acessórios', 'Substituição de 1 rolamento do cubo de roda, revisão do cubo de roda do último eixo.', 'OFICINA', '400', '', ''),
('16/01/2023 10:05:24', 'QVW-1J69', '28/12/2022', '28/12/2022', 'Heber', 'AP MARINE', 'revisão corretiva', 'Substituição do Cardan da bomba de descarregamento. ', 'OFICINA', '200', '', ''),
('16/01/2023 10:07:40', 'NEM-3776', '26/12/2022', '26/12/2022', 'Heber', 'AP MARINE', 'freio e acessórios', 'Substituição; 2 rolamentos do cubo de roda, 2 retentores do cubo', 'OFICINA', '500', '', ''),
('16/01/2023 10:09:03', 'NEM-3776', '26/12/2022', '26/12/2022', 'Heber', 'AP MARINE', 'suspensão e acessórios', 'Substituição; 8 buchas do tirante, suporte do feixe de mola', 'OFICINA', '500', '', ''),
('16/01/2023 10:37:43', 'RWZ9A12', '09/01/2023', '11/01/2023', 'Franck', 'RMS', 'reparo de chassis ou alteração', 'Construção da rampa', 'OFICINA', '', '11000', ''),
('16/01/2023 10:38:57', 'JUE-8050', '12/01/2023', '12/01/2023', 'Franck', 'RMS', 'válvula de fundo e portinhola', 'Reparo de solda do suporte da válvula ', 'OFICINA', '', '', ''),
('23/01/2023 08:04:51', 'AP1', '21/01/2023', '21/01/2023', 'Rafael', 'AP MARINE', 'rancho', 'Rancho semanal', 'BALSA', '', '1306', ''),
('23/01/2023 08:16:11', 'KJU 3307', '16/01/2023', '17/01/2023', 'Franck', 'AP MARINE', 'reparo de chassis ou alteração', 'Troca da chapa da mesa do pino-rei', 'OFICINA', '', '', ''),
('23/01/2023 11:56:01', 'QVW-1J69', '12/01/2023', '12/01/2023', 'Heber', 'AP MARINE', 'suspensão e acessórios', '', 'OFICINA', '', '2300', ''),
('23/01/2023 17:02:36', 'AP4', '23/01/2023', '23/01/2023', 'Everaldo', 'RMS', 'gerador elétrico', 'Instalação de padrão elétrico no porto novo', 'PÁTIO', '1000', '1815', ''),
('23/01/2023 17:05:14', 'AP4', '23/01/2023', '23/01/2023', 'Everaldo', 'RMS', 'gerador elétrico', 'Manutenção do gerador MCA AP4; troca do gerador de cabeça do motor da AP4', 'BALSA', '1000', '', ''),
('23/01/2023 17:16:06', 'QLQ-2004', '23/01/2023', '23/01/2023', 'Eládio', 'AP MARINE', 'motor de partida', 'Substituição do motor de partida', 'PÁTIO', '200', '498', ''),
('27/01/2023 14:26:23', 'outros', '23/01/2023', '27/01/2023', 'Emerson', 'AP MARINE', 'limpeza e organização', 'Limpeza dos tanques de armazenamento (externa) e limpeza da área próxima ao píer', 'PÁTIO', '980', '', ''),
('27/01/2023 15:34:01', 'NEM-3776', '23/01/2023', '23/01/2023', 'Franck', 'RMS', 'suspensão e acessórios', 'Serviço de solda na balança ', 'OFICINA', '', '', ''),
('27/01/2023 15:35:53', 'AMI-8908', '27/01/2023', '27/01/2023', 'Franck', 'RMS', 'motor caixa e diferencial', 'Extração de 2 parafusos do bloco do motor', 'OFICINA', '', '', ''),
('27/01/2023 15:38:20', 'JWB-4F45', '24/01/2023', '24/01/2023', 'Heber', 'RMS', 'revisão corretiva', 'Troca da válvula da portinhola', 'OFICINA', '100', '', ''),
('27/01/2023 16:33:33', 'QLS-2H93', '23/01/2023', '23/01/2023', 'Heber', 'RMS', 'revisão corretiva', 'Substituição de 10 perno de roda completos', 'OFICINA', '150', '', ''),
('27/01/2023 16:53:08', 'MG4', '27/01/2023', '27/01/2023', 'Heber', 'RMS', 'radiador', 'Substituição; radiador de água, bomba de transferência, óleo do motor, filtro de óleo do motor. Material reserva deixado na balsa, 02 filtro diesel, 6 filtros racool 20x20', 'BALSA', '', '4.500', ''),
('31/01/2023 07:56:05', 'AP4', '28/01/2023', '28/01/2023', 'Rafael', 'RMS', 'rancho', '', 'BALSA', '', '1735', ''),
('31/01/2023 08:36:26', 'NEM-3776', '23/01/2023', '31/01/2023', 'Franck', 'RMS', 'reparo de chassis ou alteração', 'Serviço de solda na balança ', 'OFICINA', '', '', ''),
('01/02/2023 14:40:56', 'Almirante Guilhem', '23/01/2023', '27/02/2023', 'Everaldo', 'RMS', 'revisão corretiva', 'Revisão corretiva da parte elétrica ', 'BALSA', '1000', '', ''),
('10/02/2023 14:23:23', 'outros', '19/01/2023', '10/02/2023', 'Franck', 'AP MARINE', 'outros', 'Confecção de 11 cavaletes', 'PÁTIO', '', '11.000', ''),
('10/02/2023 14:25:42', 'QVW-1J69', '04/02/2023', '10/02/2023', 'Eládio', 'AP MARINE', 'outros', 'Serviço de socorro e reparo do alternador', 'OFICINA', '800', '', ''),
('10/02/2023 14:29:04', 'AMI-8908', '08/02/2023', '08/02/2023', 'Eládio', 'AP MARINE', 'revisão preventiva', '', 'OFICINA', '700', '160', ''),
('10/02/2023 14:31:19', 'outros', '03/02/2023', '03/02/2023', 'Heber', 'AP MARINE', 'outros', 'Compra de ferramentas para a oficina mecânica ', 'OFICINA', '', '1.650', ''),
('13/02/2023 08:17:11', 'QEZ 9A84', '07/02/2023', '07/02/2023', 'Franck', 'AP MARINE', 'reparo de chassis ou alteração', 'Serviço de desempeno da barra do estirante do cavalo mecânico.', 'OFICINA', '', '', ''),
('13/02/2023 08:24:08', 'QEZ 9A84', '02/01/2023', '02/01/2023', 'Franck', 'AP MARINE', 'reparo de chassis ou alteração', 'Serviço de corte com maçarico dos parafusos da quinta roda', 'OFICINA', '', '', ''),
('13/02/2023 08:29:49', 'SAL0G83', '03/01/2023', '03/01/2023', 'Franck', 'AP MARINE', 'outros', 'Troca de placas sinalizadoras ', 'OFICINA', '', '', ''),
('13/02/2023 08:35:18', 'SAL0G83', '09/02/2023', '09/02/2023', 'Franck', 'AP MARINE', 'válvula de fundo e portinhola', 'Troca das bocas de 3 polegadas da bomba auxiliar ', 'OFICINA', '', '', ''),
('14/02/2023 14:38:22', 'SAL0G83', '03/01/2023', '03/01/2023', 'Heber', 'AP MARINE', 'reparo de chassis ou alteração', 'Moção da quinta roda dois furos para frente', 'OFICINA', '200', '', ''),
('14/02/2023 14:39:39', 'outros', '04/02/2023', '04/02/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Revisão corretiva na bomba de descarregamento ', 'PÁTIO', '700', '', ''),
('17/02/2023 08:29:50', 'QLS-2H93', '10/02/2023', '10/02/2023', 'Eládio', 'AP MARINE', 'revisão corretiva', 'Revisão de faróis e lanternas, instalação de faróis de milha em curto, 04 lâmpadas led, 03 lâmpadas 67-24V, 02 lâmpadas H3.24V, 01 lâmpada, 1141-24V', 'OFICINA', '150', '1442', ''),
('17/02/2023 08:35:21', 'QEZ 9A84', '10/02/2023', '10/02/2023', 'Eládio', 'RMS', 'revisão corretiva', 'Revisão geral de faróis e lanternas, troca de lanternas em geral', 'OFICINA', '250', '310', ''),
('17/02/2023 08:38:43', 'QEZ 9A84', '13/02/2023', '13/02/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Substituição de 5 roda, troca de 3 tambores de freio, recondicionamento do tirante da suspensão,  troca de lona, troca de óleo, troca de filtro de ar, troca do filtro de diesel, troca de filtro de óleo do motor, troca de filtro da válvula secadora', 'OFICINA', '1250', '', ''),
('17/02/2023 08:40:32', 'outros', '14/02/2023', '14/02/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca de óleo do motor, troca de filtro de óleo do motor, troca de filtro do sistema de arrefecimento, troca de filtro racool 20x20', 'OFICINA', '150', '', ''),
('17/02/2023 08:41:46', 'NEM-3776', '10/02/2023', '10/02/2023', 'Heber', 'AP MARINE', 'freio e acessórios', 'Troca de 1 cuica de freio', 'OFICINA', '150', '', ''),
('17/02/2023 08:43:18', 'QLS-2H93', '13/02/2023', '13/02/2023', 'Heber', 'AP MARINE', 'freio e acessórios', 'Troca de patins de freio completo, troca do eixo S, retirado vazamento de óleo ', 'OFICINA', '300', '', ''),
('17/02/2023 11:20:25', 'QLS-2H91', '17/02/2023', '17/02/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca do cabeçote do filtro completo', 'OFICINA', '100', '', ''),
('17/02/2023 11:21:59', 'AP3', '16/02/2023', '16/02/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca do óleo do motor, troca do filtro de óleo do motor, troca do filtro racool, troca de mangueira da geral do diesel, lavagem de 02 tanques de combustíveis ', 'BALSA', '', '', ''),
('17/02/2023 15:23:11', 'AP4', '13/02/2023', '17/02/2023', 'Emerson', 'RMS', 'pintura', 'Pintura em regiões de desgaste, lavagem interna e externa, retirada de ferrugem, aplicação de prime nas regiões críticas. Teve ajudante com 5 diárias trabalhadas, valor de R$ 80,00.', 'BALSA', '1560', '', ''),
('17/02/2023 15:38:24', 'Almirante Guilhem', '12/02/2023', '17/02/2023', 'Everaldo', 'RMS', 'elétrica', 'Serviços de elétrica em geral ', 'BALSA', '1000', '', ''),
('17/02/2023 15:39:20', 'AP4', '13/02/2023', '17/02/2023', 'Everaldo', 'RMS', 'gerador elétrico', 'manutenção do MCA ', 'BALSA', '200', '', ''),
('25/02/2023 14:02:04', 'AP4', '22/02/2023', '25/02/2023', 'Emerson', 'RMS', 'pintura', 'Remoção da ferrugem e preparo para jateamento ', 'BALSA', '1000', '', ''),
('28/02/2023 10:56:14', 'Yasmim Mariana', '15/02/2023', '15/02/2023', 'Eládio', 'RMS', 'bateria', 'Troca e instalação de baterias e terminais', 'BALSA', '200', '', ''),
('28/02/2023 10:57:19', 'AP3', '16/02/2023', '16/02/2023', 'Eládio', 'AP MARINE', 'bateria', 'Troca de baterias e reposição de cabos e terminais', 'BALSA', '300', '', ''),
('28/02/2023 10:59:08', 'QLS-2H91', '17/02/2023', '17/02/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de faróis e lanternas ', 'OFICINA', '250', '', ''),
('06/03/2023 14:06:43', 'JVF-2874', '27/02/2023', '02/03/2023', 'Franck', 'AP MARINE', 'suspensão e acessórios', 'Solda do suporte da balança e complemento de rampa da quinta roda', 'OFICINA', '', '', ''),
('06/03/2023 14:07:37', 'Almirante Guilhem', '03/03/2023', '03/03/2023', 'Franck', 'RMS', 'outros', 'Solda de 13 porta-cadeados', 'BALSA', '', '', ''),
('06/03/2023 14:09:13', 'outros', '27/02/2023', '27/02/2023', 'Franck', 'RMS', 'suspensão e acessórios', 'Troca de pé da Negona', 'OFICINA', '', '', ''),
('06/03/2023 14:12:00', 'QLS-2H91', '17/02/2023', '17/02/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca de 02 rolamentos do cubo, troca de 01 retentor do cubo, troca de 01 aranha trava, completado 08 litros de óleo do motor', 'OFICINA', '400', '', ''),
('06/03/2023 14:13:11', 'QLS-2H91', '28/02/2023', '28/02/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Retirada a cuica, troca de 02 filtros de óleo diesel', 'OFICINA', '100', '', ''),
('06/03/2023 14:14:51', 'JVF-2874', '02/03/2023', '02/03/2023', 'Heber', 'RMS', 'revisão corretiva', 'Troca de 01 suporte da balança, troca de 1 pino da balança,  troca de 04 buchas da balança, troca de 02 parafusos do tirante, retificada a rampa', 'OFICINA', '500', '', ''),
('06/03/2023 14:16:48', 'QLS-2H93', '28/02/2023', '28/02/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação, troca e confecção do chicote, 02 tomadas macho, 01 chicote sanfonado', 'OFICINA', '150', '', ''),
('06/03/2023 14:17:57', 'QLS-2H91', '28/02/2023', '28/02/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Troca de lâmpadas do farol, usadas 02 lâmpadas h724v', 'OFICINA', '50', '', ''),
('06/03/2023 14:20:11', 'QVW-1J69', '28/02/2023', '28/02/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Serviço de revisão de instalação e troca de lanterna lateral, troca de lâmpadas do farol e lanternas traseiras e acessórios dos retrovisores.', 'OFICINA', '400', '', ''),
('23/03/2023 08:28:13', 'QLS-2H93', '15/03/2023', '15/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Serviço de instalação ', 'OFICINA', '50', '', ''),
('23/03/2023 08:29:22', 'SAL-0G83', '09/03/2023', '09/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de 1 farol de kilha e 1 sirene de ré', 'OFICINA', '100', '', ''),
('23/03/2023 08:30:23', 'QVW-1J69', '10/03/2023', '10/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de 1 sirene de ré', 'OFICINA', '50', '', ''),
('23/03/2023 08:31:50', 'outros', '07/03/2023', '07/03/2023', 'Eládio', 'RMS', 'elétrica', 'Recuperação do painel de instrumentos, reposição de baterias e cabos, 1 chave de ignição ', 'BALSA', '400', '', ''),
('23/03/2023 08:33:19', 'JVF-2874', '09/03/2023', '09/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão geral de faróis e lanternas, troca de 2 lentes da lanterna traseira', 'OFICINA', '100', '', ''),
('23/03/2023 08:34:49', 'QLS-2H94', '09/03/2023', '09/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão, 03 lâmpadas 67-24V, 01 lâmpada H7-24V', 'OFICINA', '150', '', ''),
('23/03/2023 08:38:25', 'QLS-2H90', '15/03/2023', '15/03/2023', 'Heber', 'AP MARINE', 'revisão preventiva', 'Troca do óleo do motor, troca de filtro do óleo do motor, troca do filtro de diesel, troca do refil do filtro diesel, troca do filtro de ar', 'OFICINA', '300', '', ''),
('23/03/2023 08:40:11', 'QEZ-9A84', '02/03/2023', '02/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Troca do motor do vidro elétrico e reposição de acessórios do retrovisor ', 'OFICINA', '450', '', ''),
('23/03/2023 08:41:17', 'outros', '06/03/2023', '07/03/2023', 'Franck', 'AP MARINE', 'outros', 'Fabricação de uma mesa de bancada para a oficina ', 'OFICINA', '', '', ''),
('23/03/2023 08:42:40', 'AP4', '01/03/2023', '01/03/2023', 'Franck', 'RMS', 'outros', 'Fabricação do carrinho da bomba', 'BALSA', '', '', ''),
('27/03/2023 10:28:51', 'AP1', '22/03/2023', '22/03/2023', 'Rafael', 'AP MARINE', 'outros', 'Abastecimento de 1000 litros', 'BALSA', '', '', ''),
('27/03/2023 10:29:43', 'AP4', '24/03/2023', '24/03/2023', 'Rafael', 'RMS', 'outros', 'Abastecimento da AP4 2000 litros', 'BALSA', '', '', ''),
('27/03/2023 10:30:23', 'AP1', '27/03/2023', '27/03/2023', 'Rafael', 'AP MARINE', 'outros', 'Abastecimento de AP1 1000 litros', 'BALSA', '', '', ''),
('29/03/2023 11:38:07', 'AP1', '29/03/2023', '29/03/2023', 'Rafael', 'AP MARINE', 'rancho', 'Rancho semanal', 'BALSA', '', '1.263', ''),
('01/04/2023 10:42:10', 'AP4', '01/04/2023', '01/04/2023', 'Rafael', 'RMS', 'outros', 'Abastecimento de 2000 litros de diesel', 'BALSA', '', '', ''),
('10/04/2023 10:05:23', 'outros', '31/03/2023', '01/04/2023', 'Franck', 'RMS', 'outros', 'Confecção de um par de pés para a carreta JTE1G84', 'OFICINA', '', '', ''),
('10/04/2023 10:06:54', 'AP4', '07/04/2023', '07/04/2023', 'Rafael', 'AP MARINE', 'rancho', 'Reforço de rancho para missão salgado', 'BALSA', '', '880', ''),
('10/04/2023 10:09:09', 'AP4', '07/04/2023', '07/04/2023', 'Michel', 'RMS', 'outros', 'Abastatecimento duas vezes da AP4 3 mil litros ', 'BALSA', '', '', ''),
('10/04/2023 11:42:21', 'ATL-0D70', '04/04/2023', '04/04/2023', 'Franck', 'AP MARINE', 'reparo de chassis ou alteração', 'Confecção de suporte de cones', 'OFICINA', '', '', ''),
('10/04/2023 11:43:33', 'NKD-5977', '31/03/2023', '31/03/2023', 'Franck', 'AP MARINE', 'reparo de chassis ou alteração', 'Solda na chapa do pino rei', 'OFICINA', '', '', ''),
('10/04/2023 11:46:42', 'NEC-0399', '04/04/2023', '04/04/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Troca de lanternas do bitrem', 'OFICINA', '300', '', ''),
('10/04/2023 14:22:00', 'JVO-7D81', '28/03/2023', '28/03/2023', 'Franck', 'AP MARINE', 'revisão corretiva', 'Confecção de um suporte de cone', 'OFICINA', '', '', ''),
('10/04/2023 14:23:07', 'NKD-5977', '30/03/2023', '30/03/2023', 'Franck', 'AP MARINE', 'revisão corretiva', 'Solda na chapa de suporte do pino-rei', 'OFICINA', '', '', ''),
('10/04/2023 14:24:46', 'NEM-3774', '29/03/2023', '29/03/2023', 'Franck', 'AP MARINE', 'revisão corretiva', 'Confecção de um protetor de ciclista e tampa do maleiro', 'OFICINA', '', '', ''),
('10/04/2023 14:25:57', 'KJU-3D07', '23/03/2023', '23/03/2023', 'Franck', 'AP MARINE', 'revisão corretiva', 'Solda em suporte do apoio do tanque', 'OFICINA', '', '', ''),
('10/04/2023 14:27:15', 'outros', '22/03/2023', '22/03/2023', 'Franck', 'AP MARINE', 'revisão corretiva', 'Substituição das travessas de apoio dos pés', 'OFICINA', '', '', ''),
('10/04/2023 14:29:09', 'JVF-2874', '21/03/2023', '21/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Recuperação do chicote do módulo do motor', 'OFICINA', '1000', '2064', ''),
('10/04/2023 14:34:31', 'NEM-3774', '27/03/2023', '27/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Reposição de lanternas traseiras', 'OFICINA', '250', '460', ''),
('10/04/2023 14:36:02', 'AMI-8908', '28/03/2023', '28/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação e de lanternas', 'OFICINA', '100', '', ''),
('10/04/2023 14:37:19', 'QLS-2H91', '28/03/2023', '28/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de sirene de ré e faróis de milha', 'OFICINA', '150', '', ''),
('10/04/2023 14:38:16', 'QLS-2H94', '27/03/2023', '27/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de sirene de ré ', 'OFICINA', '50', '', ''),
('10/04/2023 14:40:05', 'QEZ-9A84', '27/03/2023', '27/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Troca de faróis de milha e bomba d\'água do interclima', 'OFICINA', '150', '', ''),
('10/04/2023 14:41:38', 'QVW-1J69', '24/03/2023', '24/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação geral', 'OFICINA', '400', '', ''),
('10/04/2023 14:42:58', 'NKD-5897', '28/03/2023', '28/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação e troca de tomadas e lanternas do bitrem', 'OFICINA', '250', '', ''),
('10/04/2023 14:44:27', 'KJU-3D07', '27/03/2023', '27/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação geral e troca de lanternas traseira e três Marias ', 'OFICINA', '300', '', ''),
('10/04/2023 14:46:45', 'outros', '14/02/2023', '10/04/2023', 'Heber', 'AP MARINE', 'injeção (mangueiras, filtros, bico e bomba injetora)', 'Revisão corretiva e troca de óleo ', 'OFICINA', '250', '', ''),
('10/04/2023 14:48:06', 'QLS-2H91', '17/02/2023', '17/02/2023', 'Heber', 'AP MARINE', 'revisão corretiva', '', 'OFICINA', '400', '', ''),
('10/04/2023 14:49:02', 'AP3', '16/02/2023', '16/02/2023', 'Heber', 'AP MARINE', 'revisão corretiva', '', 'BALSA', '300', '', ''),
('10/04/2023 14:50:20', 'JVF-2874', '02/03/2023', '02/03/2023', 'Heber', 'AP MARINE', 'revisão corretiva', '', 'OFICINA', '500', '', ''),
('10/04/2023 14:51:42', 'KJU-3D07', '25/03/2023', '25/03/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'CIV e CNPP', 'OFICINA', '400', '', ''),
('10/04/2023 14:52:49', 'QLS-2H91', '23/03/2023', '23/03/2023', 'Heber', 'AP MARINE', 'revisão corretiva', '', 'OFICINA', '700', '', ''),
('17/04/2023 08:25:44', 'AP3', '17/04/2023', '17/04/2023', 'Rafael', 'AP MARINE', 'outros', 'Abastecimento 1000L AP3', 'BALSA', '', '', ''),
('03/05/2023 14:30:39', 'AP1', '03/05/2023', '03/05/2023', 'Rafael', 'AP MARINE', 'outros', 'Abastecimento de 1 mil litros ', 'BALSA', '', '', ''),
('03/05/2023 14:32:08', 'AP4', '10/04/2023', '10/04/2023', 'Heber', 'RMS', 'revisão corretiva', 'Retificado motor agrale MCA', 'BALSA', '', '', ''),
('03/05/2023 14:33:29', 'AP4', '15/04/2023', '15/04/2023', 'Heber', 'RMS', 'revisão preventiva', 'Troca de óleo, filtro, mangueiras', 'BALSA', '', '', ''),
('03/05/2023 14:35:09', 'NHJ-0160', '17/04/2023', '20/05/2023', 'Franck', 'AP MARINE', 'reparo de chassis ou alteração', 'Troca da chapa da mesa da 5 roda e pés ', 'OFICINA', '', '', ''),
('03/05/2023 14:36:10', 'JWB-4F45', '12/04/2023', '12/04/2023', 'Eládio', 'AP MARINE', 'elétrica', '', 'OFICINA', '150', '50', ''),
('03/05/2023 14:37:20', 'APV-9B37', '05/04/2023', '05/04/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação ', 'OFICINA', '100', '', ''),
('03/05/2023 14:38:32', 'APV-9B33', '05/04/2023', '05/04/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação ', 'OFICINA', '100', '', ''),
('03/05/2023 14:39:52', 'NEM-3776', '12/04/2023', '12/04/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação ', 'OFICINA', '100', '', ''),
('03/05/2023 14:41:16', 'QVW-1J69', '12/04/2023', '12/04/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Troca de bateria e revisão dos cabos dos terminais ', 'OFICINA', '100', '', ''),
('18/05/2023 14:46:17', 'QEZ-9A84', '02/05/2023', '15/05/2023', 'Heber', 'AP MARINE', 'revisão preventiva', 'Troca de: 2 jogos de lona, 2 amortecedores da cabine dianteira, 2 amortecedores transversais, revisada válvula niveladora, lubrificação.', 'OFICINA', '1500', '', ''),
('18/05/2023 14:48:18', 'NEO-3701', '05/05/2023', '15/05/2023', 'Heber', 'AP MARINE', 'revisão preventiva', 'Troca de: 1 pino completo, 24 tampas de proteção de ciclista, regulagem de freios, pintura antiderrapante, faixa do parachoque, lubrificação. ', 'OFICINA', '500', '', ''),
('18/05/2023 14:50:35', 'QVW-1J69', '24/03/2023', '24/03/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca de: óleo do motor, todos os filtros, filtro da válvula PV, verificado óleo da caixa e diferencial.', 'OFICINA', '300', '', ''),
('18/05/2023 14:51:55', 'QLS-2H90', '27/04/2023', '27/04/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca de: luva da tomada de força ', 'OFICINA', '200', '', ''),
('18/05/2023 14:53:58', 'QVW-1J69', '05/05/2023', '05/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de faróis e lanternas: 2 faróis, 2 lâmpadas 1034 24V, 1 suporte de placa dianteira.', 'OFICINA', '150', '', ''),
('18/05/2023 14:57:18', 'NEO-3701', '05/05/2023', '05/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação e lanternas, troca de: 1 tomada redonda, 1 lanterna lateral.', 'OFICINA', '100', '', ''),
('18/05/2023 14:59:33', 'QEZ-9A84', '02/05/2023', '02/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de faróis e lanternas: 03 lâmpadas 67 24v, 02 lâmpadas 1034 24v', 'OFICINA', '50', '', ''),
('18/05/2023 15:01:21', 'NHJ-0160', '02/05/2023', '02/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão e reposição de instalação, 02 lanternas laterais led', 'OFICINA', '150', '', ''),
('26/05/2023 09:35:01', 'AP1', '18/05/2023', '18/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Serviço no motor de partida', 'BALSA', '300', '', ''),
('26/05/2023 09:36:57', 'AP3', '18/05/2023', '18/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Recuperação de instalação e troca de fios e cabos 01 buzina à ar, 01 buzina bibi, 01 sensor de bóia de nível, 20 metros de cabo 2x1, 01 sirene de ré, 01 giroflex led.', 'BALSA', '1100', '', ''),
('26/05/2023 09:38:29', 'QLS-2H90', '19/05/2023', '19/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de faróis e troca de 02 faróis de milha led', 'OFICINA', '100', '', '234731'),
('26/05/2023 09:39:56', 'QLS-2H91', '19/05/2023', '19/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de cabos de bateria e troca de posição de baterias e reposição de solução de bateria', 'OFICINA', '50', '', '321641'),
('26/05/2023 09:41:15', 'QLS-2H94', '19/05/2023', '19/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Troca da sirene de ré e revisão no painel de instrumentos ', 'OFICINA', '50', '', '278584'),
('26/05/2023 09:43:26', 'IJT-5101', '16/05/2023', '16/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão geral de instalação, reposição de lanternas traseira e lateral, 02 lanternas redondas traseira, 02 lanternas laterais, 04 lâmpadas 1034 24v, 03 lâmpadas 1141 24v, 02 lâmpadas 64 24v', 'OFICINA', '250', '', ''),
('05/06/2023 15:06:17', 'Almirante Guilhem', '01/02/2023', '01/02/2023', 'Everaldo', 'RMS', 'elétrica', 'Instalação elétrica ', 'BALSA', '1000', '', ''),
('05/06/2023 15:07:35', 'AP3', '13/04/2023', '13/04/2023', 'Everaldo', 'AP MARINE', 'elétrica', 'Retirada e recolocação do motor da bomba de engrenagem e troca de lâmpadas ', 'BALSA', '2000', '', ''),
('05/06/2023 15:09:04', 'outros', '23/01/2023', '23/01/2023', 'Everaldo', 'RMS', 'elétrica', 'Instalação de um padrão metálico no porto novo', 'BALSA', '1000', '', ''),
('05/06/2023 15:10:30', 'AP4', '23/01/2023', '23/01/2023', 'Everaldo', 'RMS', 'elétrica', 'Manutenção do gerador MCA, troca do gerador da cabeça do motor', 'BALSA', '1000', '', ''),
('05/06/2023 15:41:03', 'MG4', '06/01/2023', '06/01/2023', 'Everaldo', 'RMS', 'elétrica', 'Troca de lâmpadas e reatores dos refletores, instalação de um exaustor', 'BALSA', '1000', '', ''),
('05/06/2023 15:42:04', 'AP4', '11/01/2023', '11/01/2023', 'Everaldo', 'RMS', 'gerador elétrico', 'Troca do gerador', 'BALSA', '300', '6150', ''),
('05/06/2023 15:43:40', 'outros', '29/12/2022', '29/12/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Serviços elétricos diversos na base', 'PÁTIO', '1300', '', ''),
('05/06/2023 15:46:28', 'outros', '22/12/2022', '22/12/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Serviços diversos, carregamento do boiler, troca de 04 refletores, instalação do motor intermediário...', 'PÁTIO', '1125', '', ''),
('05/06/2023 15:49:53', 'AP1', '15/12/2022', '15/12/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Troca de 01 cabo da máquina de solda, retirada do motor da intermediária, retirada de 01 bomba-dagua na AP1 e instalação de 01 bomba d\'água. ', 'BALSA', '650', '', ''),
('05/06/2023 16:07:18', 'outros', '27/10/2022', '27/10/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Ligação da bomba elétrica do boiler para retirada do óleo, instalação de 01 quadro de distribuição no poste do pátio com a colocação de cabos trifásicos, ligação de 01 bomba para retirada de óleo,  ligação de 01 refletor com fotorelé na bomba intermediária.', 'PÁTIO', '930', '', ''),
('05/06/2023 16:09:21', 'outros', '21/10/2022', '21/10/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Manutenção na rede elétrica do poste do porto', 'PÁTIO', '1000', '', ''),
('05/06/2023 16:10:51', 'outros', '21/10/2022', '21/10/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Operação no boiler, instalação para circuito da bomba-dagua.', 'PÁTIO', '1000', '', ''),
('05/06/2023 16:12:02', 'outros', '03/12/2022', '03/12/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Serviço de manutenção no boiler de aquecimento ', 'PÁTIO', '500', '', ''),
('05/06/2023 16:13:29', 'outros', '10/11/2022', '10/11/2022', 'Everaldo', 'AP MARINE', 'elétrica', '02 malhas de aterramento para carretas no porto', 'PÁTIO', '1260', '', ''),
('05/06/2023 16:14:50', 'AP1', '17/11/2022', '17/11/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Manutenção geral e troca de fiação do quadro', 'BALSA', '1000', '', ''),
('05/06/2023 16:17:30', 'outros', '24/11/2022', '24/11/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Serviços diversos, ligação de uma bomba d\'água na baia, troca de luminárias no escritório, retirada de 02 bombas d\'água na MG, instalação de 02 refletores no porto, retirada de um cabo trifásico no poste da bomba intermediária, instalação elétrica na AP1.', 'PÁTIO', '900', '', ''),
('05/06/2023 16:20:22', 'outros', '24/01/2023', '24/01/2023', 'Everaldo', 'AP MARINE', 'elétrica', 'Serviços diversos, conserto da tomada do motor da baia de descarregamento, conserto da bomba de descarregamento, troca das tomadas do motor-bomba, troca de fiação de tomadas do escritório. ', 'PÁTIO', '600', '', ''),
('05/06/2023 16:22:12', 'outros', '17/10/2022', '17/12/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Instalação do quadro do motor bomba na baia, instalação de motor de descarregamento do boiler, operação de aquecimento do boiler.', 'PÁTIO', '1000', '', ''),
('05/06/2023 16:31:01', 'outros', '26/11/2022', '26/11/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Montagem de quadro elétrico ', 'PÁTIO', '200', '', ''),
('05/06/2023 16:32:14', 'outros', '28/11/2022', '28/11/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Montagem de quadro bifasico.', 'PÁTIO', '100', '', ''),
('05/06/2023 16:33:08', 'outros', '01/12/2022', '01/12/2022', 'Everaldo', 'AP MARINE', 'elétrica', 'Montagem de quadro trifásico.', 'PÁTIO', '100', '', ''),
('06/06/2023 11:28:08', 'outros', '26/05/2023', '26/05/2023', 'Heber', 'RMS', 'revisão corretiva', 'Troca de 02 mangueiras espiral completas da bicuda JXA5685', 'OFICINA', '', '', ''),
('13/06/2023 10:28:00', 'QEZ-9A84', '28/04/2023', '28/04/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Revisão da bomba de engrenagem, Cardan e troca do flange do cardan', 'OFICINA', '500', '', ''),
('13/06/2023 10:29:47', 'AP1', '15/05/2023', '15/05/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca da chave tá da bomba de descarregamento ', 'BALSA', '500', '', ''),
('13/06/2023 10:31:37', 'IJT-5101', '15/05/2023', '15/05/2023', 'Heber', 'RMS', 'revisão preventiva', 'Troca de : 01 pino rei, retoque de pintura, faixa de parachoque traseiro, regulagem de freios', 'OFICINA', '500', '', ''),
('13/06/2023 10:32:39', 'QLS-2H90', '16/05/2023', '16/05/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca da válvula  APU', 'OFICINA', '500', '', ''),
('13/06/2023 10:34:13', 'QLS-2H93', '17/05/2023', '17/05/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca de 01 paralamas dianteiro, 01 lameira traseira ', 'OFICINA', '300', '', ''),
('13/06/2023 10:35:12', 'outros', '11/04/2023', '11/04/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Remoção e instalação do radiador do gerador da base', 'OFICINA', '200', '', ''),
('19/06/2023 08:19:43', 'QLS-2H91', '28/02/2023', '28/02/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Retirada a cuíca, trocados 02 filtros refil do óleo diesel', 'OFICINA', '300', '', ''),
('19/06/2023 08:20:43', 'QLS-2H91', '17/05/2023', '17/05/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca do cabeçote com filtro completo', 'OFICINA', '100', '', ''),
('19/06/2023 08:21:47', 'BWU-6016', '06/06/2023', '06/06/2023', 'Heber', 'RMS', 'revisão corretiva', 'Troca da tampa do tanque completa ', 'OFICINA', '300', '', ''),
('19/06/2023 08:23:53', 'outros', '25/05/2023', '25/05/2023', 'Heber', 'RMS', 'freio e acessórios', 'BAK8I63 - troca de pastilhas, dianteiras e traseiras, troca de 02 discos dianteiros, troca do filtro racool.', 'OFICINA', '800', '', ''),
('19/06/2023 08:26:16', 'QLS-2H94', '09/06/2023', '09/06/2023', 'Heber', 'AP MARINE', 'revisão preventiva', 'Troca de: óleo do motor; filtro de ar; filtro de diesel; filtro racool; filtro de óleo do motor; filtro da válvula secadora, verificado óleo da caixa e do diferencial.', 'OFICINA', '500', '', ''),
('19/06/2023 08:28:29', 'QLS-2H93', '11/04/2023', '11/04/2023', 'Heber', 'AP MARINE', 'revisão preventiva', 'Troca de: óleo do motor; filtro de ar; filtro refil de diesel; filtro do motor refil; filtro da secadora; filtro do arla. ', 'OFICINA', '500', '', ''),
('19/06/2023 10:14:36', 'AP3', '17/06/2023', '17/06/2023', 'Rafael', 'AP MARINE', 'outros', 'Abastecimento de 1000L mil litros de diesep', 'BALSA', '', '', ''),
('19/06/2023 11:25:40', 'MG4', '16/06/2023', '16/06/2023', 'Eládio', 'RMS', 'elétrica', 'Revisão do painel de instrumentos, 01 relógio de temperatura ', 'BALSA', '100', '', ''),
('19/06/2023 11:28:33', 'outros', '15/06/2023', '15/06/2023', 'Eládio', 'RMS', 'elétrica', 'Placa JTG2J36 - recuperação de instalação: 03 lanternas traseiras, 01 lanterna de placa de led, 01 lanterna lateral de led, 02 lâmpadas 67.24V, 06 lâmpadas 1141.24V', 'OFICINA', '200', '', ''),
('19/06/2023 11:30:46', 'outros', '14/06/2023', '14/06/2023', 'Eládio', 'RMS', 'elétrica', 'NEP 0271 - Revisão de instalação e lanternas: 01 lanterna lateral, 02 lâmpadas 1141.24V, 1 lâmpada 67.24V.', 'OFICINA', '100', '', ''),
('19/06/2023 11:32:59', 'outros', '14/06/2023', '14/06/2023', 'Eládio', 'RMS', 'elétrica', 'JTF 2197 - Revisão de instalação e lanternas, 01 lanternas de placa led, 02 lâmpadas 1141.24V, 01 lâmpada 67.24V', 'OFICINA', '100', '', ''),
('19/06/2023 11:35:28', 'outros', '02/06/2023', '02/06/2023', 'Eládio', 'RMS', 'elétrica', 'JTH7G07 - revisão de instalação l, troca de tomada, troca de lanterna traseira e lateral. 01 tomada redonda de 7 pinos, 02 lanternas traseiras, 03 lanternas laterais, 02 lâmpadas 67.24V, 06 lâmpadas 1141.24V', 'OFICINA', '250', '', ''),
('19/06/2023 11:36:19', 'AP4', '01/06/2023', '01/06/2023', 'Eládio', 'RMS', 'elétrica', 'Motor de partida', 'BALSA', '300', '', ''),
('20/06/2023 08:43:10', 'NEM-3776', '02/06/2023', '02/06/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação e troca de lanternas traseira e lateral. 02 lanternas traseira led, 02 lanternas laterais de led.', 'OFICINA', '200', '', ''),
('20/06/2023 08:48:09', 'AP3', '14/06/2023', '14/06/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação, troca de fios e cabos, serviços de motor de partida, principal e reserva.', 'BALSA', '1100', '', ''),
('20/06/2023 08:50:27', 'outros', '15/06/2023', '15/06/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de buzina marítima.', 'OFICINA', '350', '', ''),
('20/06/2023 08:51:53', 'QVW-1J69', '16/06/2023', '16/06/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão e troca de tomada', 'OFICINA', '50', '', ''),
('20/06/2023 08:52:57', 'ATL-0D70', '16/06/2023', '16/06/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação e troca de lanternas, 01 tomada redonda 7 polos fêmea. ', 'OFICINA', '50', '', ''),
('23/06/2023 10:30:57', 'AP1', '23/06/2023', '23/06/2023', 'Rafael', 'AP MARINE', 'outros', 'Abastecimento 1000L', 'BALSA', '', '', ''),
('30/06/2023 14:33:00', 'JVF-2874', '27/06/2023', '27/06/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Trocados: cilindro de embreagem, mangueira de embreagem.', 'OFICINA', '500', '', ''),
('30/06/2023 14:34:29', 'AP3', '21/06/2023', '21/06/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Remoção e instalação da bomba d\'água, trocados: mangote de água, filtros de diesel, correias.', 'BALSA', '1000', '', ''),
('30/06/2023 14:35:43', 'QVW-1J69', '15/06/2023', '15/06/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Revisão e instalação  da válvula de freio de estacionamento.', 'OFICINA', '500', '', ''),
('30/06/2023 14:37:45', 'NEC-0429', '18/06/2023', '18/06/2023', 'Heber', 'AP MARINE', 'revisão preventiva', 'Trocados 04 pneus, regulagem de freio, solda da bucha do S, solda no varão do pé da manivela.', 'OFICINA', '500', '', ''),
('07/07/2023 09:11:53', 'AP1', '06/07/2023', '06/07/2023', 'Rafael', 'AP MARINE', 'outros', 'Abastecimento de 500L de diesel', 'BALSA', '', '', ''),
('07/07/2023 09:12:23', 'AP4', '06/07/2023', '06/07/2023', 'Rafael', 'RMS', 'outros', 'Abastecimento de 2000L', 'BALSA', '', '', ''),
('18/07/2023 11:40:15', 'AP1', '18/07/2023', '18/07/2023', 'Rafael', 'AP MARINE', 'outros', 'Abastecimento de 1000L', 'BALSA', '', '', ''),
('21/07/2023 16:19:48', 'QVW-1J69', '12/07/2023', '12/07/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca de 02 catracas de freio, 1 bicha do V, limpeza do sensor ABS, retirada do vazamento de óleo do motor', 'OFICINA', '700', '', ''),
('21/07/2023 16:20:58', 'AMI-8908', '10/07/2023', '10/07/2023', 'Heber', 'RMS', 'revisão corretiva', 'Troca do intercambiador, óleo do motor e filtro lubrificante ', 'OFICINA', '500', '', ''),
('21/07/2023 16:22:26', 'NEC-0399', '22/06/2023', '22/06/2023', 'Heber', 'AP MARINE', 'revisão preventiva', 'Troca de 04 pneus, regulagem de freio, solda na bucha do eixo S, soldado e revisado pé do bitrem.', 'OFICINA', '400', '', ''),
('21/07/2023 16:23:39', 'NEO-3703', '28/06/2023', '28/06/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Regulagem de freio, solda no suporte da balança,  troca de lona do eixo do suspensor.', 'OFICINA', '600', '', ''),
('21/07/2023 16:24:49', 'NEM-3776', '27/06/2023', '27/06/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Solda do suporte de pino da balança, regulagem de freio, verificação de folgas do cubo de roda.', 'OFICINA', '300', '', ''),
('21/07/2023 16:26:00', 'SAL-0G83', '20/06/2023', '20/06/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de buzina original ', 'OFICINA', '200', '', ''),
('21/07/2023 16:26:56', 'QLS-2H93', '12/07/2023', '12/07/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de sirene de ré ', 'OFICINA', '50', '', ''),
('21/07/2023 16:27:53', 'QVW-1J69', '12/07/2023', '12/07/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de faróis e lanternas ', 'OFICINA', '100', '', ''),
('21/07/2023 16:28:55', 'QLS-2H90', '12/07/2023', '12/07/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de faróis e lanternas, instalação de sirene de ré ', 'OFICINA', '150', '', ''),
('21/07/2023 16:29:44', 'QEZ-9A84', '20/06/2023', '20/06/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de faróis e lanternas ', 'OFICINA', '100', '', ''),
('21/07/2023 16:30:49', 'NEC-0429', '20/06/2023', '20/06/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão geral e recuperação de lanternas traseiras ', 'OFICINA', '150', '', ''),
('24/07/2023 09:13:16', 'outros', '18/07/2023', '19/07/2023', 'Franck', 'AP MARINE', 'outros', 'Confecção da tubulação de drenagem da caixa do tanque novo', 'PÁTIO', '', '', ''),
('24/07/2023 09:14:58', 'JVF-2874', '18/07/2023', '18/07/2023', 'Franck', 'RMS', 'outros', 'Servico de solda no tanque', 'PÁTIO', '', '', ''),
('25/07/2023 16:50:54', 'AP4', '08/07/2023', '08/07/2023', 'Franck', 'RMS', 'outros', 'Confecção de um protetor para o radiador', 'BALSA', '', '', ''),
('25/07/2023 16:51:59', 'NEM-3774', '10/07/2023', '10/07/2023', 'Franck', 'AP MARINE', 'outros', 'Solda no suporte do extintor e dos cones', 'OFICINA', '', '', ''),
('25/07/2023 16:53:16', 'outros', '13/07/2023', '13/07/2023', 'Franck', 'AP MARINE', 'outros', 'Manutenção na tubulação do tanque do hidrate.', 'PÁTIO', '', '', ''),
('25/07/2023 16:54:23', 'outros', '17/07/2023', '17/07/2023', 'Franck', 'AP MARINE', 'outros', 'Colocação do cabo da linha de vida', 'OFICINA', '', '', ''),
('02/08/2023 09:28:28', 'KJU-3E97', '28/03/2023', '14/04/2023', 'Heber', 'AP MARINE', 'revisão corretiva', 'Trocados : 01 Pino rei, 02 Para-lamas, 02 Portinhola, 02 Faixa do Para Choque e freio Regulado', 'OFICINA', '500', '', ''),
('02/08/2023 09:48:16', 'APV-9B37', '03/04/2023', '14/04/2023', 'Heber', 'AP MARINE', 'revisão preventiva', 'Trocados: 16 Rolamento, 06 Retentores da Roda, 02 Faixas do Para Choque, 02 Jogos de Lona, 03 Para-lamas, 03 Pino Rei e Freio Regulado.', 'OFICINA', '1000', '', ''),
('02/08/2023 09:49:48', 'APV-9B33', '03/04/2023', '14/04/2023', 'Heber', 'AP MARINE', 'revisão preventiva', 'Trocados: 16 Rolamento, 06 Retentores da Roda, 02 Faixas do Para Choque, 02 Jogos de Lona, 03 Para-lamas, 03 Pino Rei e Freio Regulado.', 'OFICINA', '1000', '', ''),
('02/08/2023 09:54:28', 'outros', '15/05/2023', '31/05/2023', 'Franck', 'AP MARINE', 'outros', 'Foram Fabricados 12 calavetes feitos de cantoneiras 3\'\' 5\\16 e ao todo foram usados 22 cantoneiras e 10 discos de corte de lixadeira.', 'PÁTIO', '', '', ''),
('02/08/2023 10:00:53', 'outros', '17/06/2023', '17/06/2023', 'Franck', 'AP MARINE', 'outros', 'Serviço de solda na caixa do pé do tanque do Hidrante', 'PÁTIO', '', '', ''),
('02/08/2023 10:04:48', 'SAL-0G83', '19/06/2023', '20/06/2023', 'Franck', 'AP MARINE', 'suspensão e acessórios', 'Foi Fabricado A Rampa Do Cavalo Mecânico do modelo daf  ', 'PÁTIO', '', '', ''),
('02/08/2023 10:08:01', 'NEM-3776', '29/06/2023', '30/06/2023', 'Franck', 'RMS', 'outros', 'Serviço de colocação de um cabo de aço para servir como gia pr sinto de segurança da carreta', 'PÁTIO', '', '', ''),
('02/08/2023 10:11:19', 'NEO-3701', '20/06/2023', '30/06/2023', 'Franck', 'AP MARINE', 'suspensão e acessórios', 'Serviço de colocação de um cabo de aço para servir como guia para o sinto de segurança ', 'PÁTIO', '', '', ''),
('02/08/2023 10:13:41', 'NEO-3703', '30/06/2023', '01/07/2023', 'Franck', 'AP MARINE', 'freio e acessórios', 'Serviço de colocação de um cabo de aço para servir como suporte e guia do sinto de segurança ', 'PÁTIO', '', '', ''),
('02/08/2023 10:16:07', 'NEM-3774', '30/06/2023', '01/07/2023', 'Franck', 'AP MARINE', 'freio e acessórios', 'serviço de colocação de um cabo de aço para servir como guia e suporte do sinto de segurança', 'PÁTIO', '', '', ''),
('02/08/2023 10:18:07', 'NEM-3774', '04/07/2023', '05/07/2023', 'Franck', 'AP MARINE', 'válvula de fundo e portinhola', 'serviço de confecção da tampa de um malão', 'PÁTIO', '', '', ''),
('02/08/2023 10:24:01', 'NEM-3774', '04/07/2023', '05/07/2023', 'Franck', 'AP MARINE', 'válvula de fundo e portinhola', 'Serviço de confecção da tampa de um malão da carreta ', 'PÁTIO', '', '', ''),
('02/08/2023 15:01:23', 'AP3', '16/02/2023', '17/02/2023', 'Heber', 'AP MARINE', 'revisão troca de óleo e filtro', 'Trocados : Óleo do motor, filtro de óleo do motor, filtro racool, mangueira do geral do diesel e lavado os dois tanques de combustível', 'BALSA', '300', '', ''),
('02/08/2023 15:01:23', 'QVW1J69', '05/05/2023', '05/05/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de farol e lanternas do cavalo mecânico ', 'OFICINA', '150', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `os_2024_1`
--

CREATE TABLE `os_2024_1` (
  `Carimbo de data/hora` varchar(19) DEFAULT NULL,
  `CARRETA, PLACA OU ITEM` varchar(13) DEFAULT NULL,
  `DATA INICIAL` varchar(10) DEFAULT NULL,
  `DATA FINAL` varchar(10) DEFAULT NULL,
  `EXECUTOR` varchar(8) DEFAULT NULL,
  `EMPRESA` varchar(9) DEFAULT NULL,
  `SERVIÇO` varchar(30) DEFAULT NULL,
  `DESCRIÇÃO` varchar(150) DEFAULT NULL,
  `SETOR` varchar(7) DEFAULT NULL,
  `VALOR DO SERVIÇO` varchar(4) DEFAULT NULL,
  `VALOR DO MATERIAL` varchar(4) DEFAULT NULL,
  `QUILOMETRAGEM` varchar(10) DEFAULT NULL,
  `OBSERVAÇÕES` varchar(62) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `os_2024_1`
--

INSERT INTO `os_2024_1` (`Carimbo de data/hora`, `CARRETA, PLACA OU ITEM`, `DATA INICIAL`, `DATA FINAL`, `EXECUTOR`, `EMPRESA`, `SERVIÇO`, `DESCRIÇÃO`, `SETOR`, `VALOR DO SERVIÇO`, `VALOR DO MATERIAL`, `QUILOMETRAGEM`, `OBSERVAÇÕES`) VALUES
('04/08/2023 08:44:07', 'JTG-2J36', '15/06/2023', '15/06/2023', 'Franck', 'Ap Marine', 'SUSPENSÃO E ACESSÓRIOS', 'Serviço de Solda na base dos pés da carreta.', 'PATIO', '', '', '', ''),
('04/08/2023 08:46:42', 'AGQ-4C41', '22/06/2023', '22/06/2023', 'Franck', 'Ap Marine', 'REPARO DE CHASSIS OU ALTERAÇÃO', 'Serviço de Solda no eixo da carreta', 'PATIO', '', '', '', ''),
('04/08/2023 08:49:35', 'NEO-3703', '30/06/2023', '30/06/2023', 'Franck', 'Ap Marine', '', 'Serviço de confecção de um gua do sinto de segurança feito com um cabo de aço.', 'PATIO', '', '', '', ''),
('04/08/2023 08:50:52', 'NEO-3701', '29/06/2023', '29/06/2023', 'Franck', 'Ap Marine', '', 'confecção de um guia feito de um cabo de aço para o sinto de segurança ', 'OFICINA', '', '', '', ''),
('04/08/2023 08:52:22', 'NEM-3776', '29/06/2023', '29/06/2023', 'Franck', 'Ap Marine', '', 'confecção de um guia pro sinto de segurança feito à partir de um cabo de aço\n', 'OFICINA', '', '', '', ''),
('04/08/2023 08:55:10', 'HIdrante', '17/06/2023', '17/06/2023', 'Franck', 'Ap Marine', '', 'Serviço de solda na xai', 'PATIO', '', '', '', ''),
('04/08/2023 09:00:22', 'KJU-3E97', '28/03/2023', '14/04/2023', 'Heber', 'Ap Marine', 'REVISÃO CORRETIVA', 'Trocados: 01 pino rei, 02 Para-lama,02 portinhola, 2 feixa do para-choque e regulagem de freio.', 'OFICINA', '', '', '', ''),
('04/08/2023 09:35:01', 'APV-9B33', '03/04/2023', '14/04/2023', 'Heber', 'Ap Marine', 'REVISÃO PREVENTIVA', 'Trocados: 16 rolamentos, 06 retentor da roda, 02 faixa do para-choque, 02 jogos de lona, 03 para-lamas, 02 pino rei e regulagem de freio.', 'OFICINA', '1000', '1000', '', ''),
('04/08/2023 09:37:43', 'APV-9B37', '03/04/2023', '14/04/2023', 'Heber', 'Ap Marine', 'REVISÃO PREVENTIVA', 'Trocados: 16 rolamentos, 06 retentor da roda, 02 faixa do para-choque, 02 jogos de lona, 03 para-lamas, 02 pino rei e regulagem de freio.', 'OFICINA', '1000', '', '', ''),
('04/08/2023 09:40:28', 'SAL-0G83', '19/05/2023', '20/05/2023', 'Franck', 'Ap Marine', 'SUSPENSÃO E ACESSÓRIOS', 'Fabricação de uma rampa do cavalo mecânico do modelo DAF', 'OFICINA', '', '', '', ''),
('04/08/2023 09:47:11', 'KIZ-6C57', '03/07/2023', '03/07/2023', 'Franck', 'Ap Marine', 'SUSPENSÃO E ACESSÓRIOS', 'Serviço de solda na carreta, troca de suporte do para-lama e a travessa de apoio dos pés e na base do feche de mola da carreta.', 'OFICINA', '', '', '', ''),
('04/08/2023 09:53:37', 'Tanque Grande', '18/07/2023', '19/07/2023', 'Franck', 'Ap Marine', 'HIDRÁULICO', 'Confecção das tubulações de drenagem da caixa do tanque grande. Material: 3 tubos de 3x6.00Mts, 02 curvas de 3\'\' e 01 Chave de válvula esférica de 3\'\'', 'PATIO', '', '', '', ''),
('04/08/2023 09:56:41', 'QVW-1J69', '12/07/2023', '13/07/2023', 'Heber', 'Ap Marine', 'REVISÃO CORRETIVA', 'Trocados: 02 de freios, 01 Bucha do \"v\", foi limpado o sensor do ABS e foi retirado o vazamento de óleo do motor.', 'OFICINA', '700', '', '', ''),
('04/08/2023 10:01:39', 'NEC-0399', '18/06/2023', '30/06/2023', 'Heber', 'Ap Marine', 'REVISÃO PREVENTIVA', 'Trocados: 04 Pneus, Regulado o freio, Soldada a bucha do \"S\", Soldado o varão do pé da manivela.', 'OFICINA', '500', '', '', ''),
('04/08/2023 10:03:46', 'NEC-0429', '18/06/2023', '30/06/2023', 'Heber', 'Ap Marine', 'REVISÃO PREVENTIVA', 'Trocados: 4 Pneus, Regulado o freio e soldados, A bucha do \"S\" e o varão do pé da manivela.', 'OFICINA', '500', '', '', ''),
('04/08/2023 10:07:28', 'SAL-4G04', '15/06/2023', '20/06/2023', 'Eládio', 'Ap Marine', 'REVISÃO PREVENTIVA', 'Serviço de instalação da Buzina Marítima do cavalo mecânico.', 'OFICINA', '350', '', '', ''),
('04/08/2023 10:10:57', 'NJH-0H60', '02/05/2023', '03/05/2023', 'Eládio', 'Ap Marine', 'REVISÃO CORRETIVA', 'Revisão e reposição de instalação e lanternas : 02 lanternas de led', 'OFICINA', '150', '', '', ''),
('04/08/2023 10:15:33', 'NJH-0H60', '17/04/2023', '20/04/2023', 'Franck', 'Ap Marine', 'SUSPENSÃO E ACESSÓRIOS', 'Serviço de troca da chapa da mesa da 5ª roda. Medida: 1,03x0,80,05x5/16 e os opes na medida 0,10x0,11x0,80x1/4.', 'OFICINA', '', '', '', ''),
('04/08/2023 10:17:46', 'AGQ-4C41', '22/03/2023', '23/03/2023', 'Franck', 'Ap Marine', 'SUSPENSÃO E ACESSÓRIOS', 'Serviço de substituição das travessas de apoio dos pés da carreta. ', 'OFICINA', '', '', '', ''),
('04/08/2023 10:21:02', 'JTG-2J36', '18/01/2023', '19/01/2023', 'Franck', 'Ap Marine', 'SUSPENSÃO E ACESSÓRIOS', 'Confecção de um par de pés da carreta com medidas de 0,10x0,01x0,85x3/8', 'OFICINA', '', '', '', ''),
('04/08/2023 10:24:24', 'JTE-1G84', '20/01/2023', '21/01/2023', 'Franck', 'Ap Marine', 'SUSPENSÃO E ACESSÓRIOS', 'Reparo de solda nos pés da carreta. Material: Somente solda.', 'OFICINA', '', '', '', ''),
('04/08/2023 10:26:28', 'JTG-2J36', '25/01/2023', '06/01/2023', 'Franck', 'Ap Marine', 'SUSPENSÃO E ACESSÓRIOS', 'Confecção da caixa dos pés da carreta. 0,75x0,11x0,11x1/4', 'OFICINA', '', '', '', ''),
('04/08/2023 10:28:59', 'QLS-2H90', '06/03/2023', '15/03/2023', 'Heber', 'Ap Marine', 'REVISÃO PREVENTIVA', 'Trocados: óleo do motor, filtro de óleo do motor, filtro diesel, refil do filtro de diesel e o filtro de ar.', 'OFICINA', '300', '', '', ''),
('07/08/2023 15:56:31', 'Rosa Cristina', '02/08/2023', '03/08/2023', 'Everaldo', 'Ap Marine', 'ELÉTRICA', 'Serviço elétrico do quadro de distribuição.', 'BALSA', '', '', '', 'refez o quadro de energia que foi furtado durante a madrugada\n'),
('07/08/2023 15:58:50', '', '01/08/2023', '02/08/2023', 'Everaldo', 'Ap Marine', 'ELÉTRICA', 'instalação elétrica da bomba de engrenagem movel e instalação de uma tomada para o Sr Guido.', 'PATIO', '', '', '', ''),
('07/08/2023 16:00:30', '', '02/08/2023', '03/08/2023', 'Everaldo', 'Ap Marine', 'ELÉTRICA', 'Serviço elétrico no quadro de tomada na oficina.', 'OFICINA', '', '', '', ''),
('07/08/2023 16:01:52', 'NKD-5897', '28/07/2023', '28/07/0023', 'Franck', 'Ap Marine', 'REPARO DE CHASSIS OU ALTERAÇÃO', 'Reparo de solda no protetor de ciclista', 'OFICINA', '', '', '', ''),
('07/08/2023 16:04:18', '', '27/07/2023', '28/07/2023', 'Franck', 'Ap Marine', '', 'Serviço de confecção do gradeado da bomba do tanque grande nas medidas 2x6x2 foi usado tubos de metalon na confecção.', 'OFICINA', '', '', '', ''),
('07/08/2023 16:06:58', 'NSN-0982', '25/07/2023', '26/07/2023', 'Franck', 'Ap Marine', 'REPARO DE CHASSIS OU ALTERAÇÃO', 'Serviço de solda na base de apoio do pé da carreta', 'OFICINA', '', '', '', ''),
('07/08/2023 16:08:49', 'AMC I', '14/07/2023', '15/07/2023', 'Franck', 'Ap Marine', '', 'Serviço de solda da sanfona da descarga do motor auxiliar da balsa', 'BALSA', '', '', '', ''),
('07/08/2023 16:10:48', 'CZC-3049', '03/08/2023', '04/08/2023', 'Franck', 'Ap Marine', 'VÁLVULA DE FUNDO E PORTINHOLA', 'Serviço de troca de válvula de fundo da carreta e solda no tudo de suporte da válvula ', 'OFICINA', '', '', '', ''),
('07/08/2023 16:15:14', 'AP 4', '02/08/2023', '03/08/2023', 'Franck', 'Ap Marine', 'MOTOR', 'Serviço de extração de um \"permo\" quebrado na balsa ', 'BALSA', '', '', '', ''),
('07/08/2023 16:16:43', '', '01/08/2023', '02/08/2023', 'Franck', 'Ap Marine', 'Bomba', 'Serviço de bomba de transferência da bai ', 'BALSA', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `os_2024_3`
--

CREATE TABLE `os_2024_3` (
  `COL 1` varchar(19) DEFAULT NULL,
  `COL 2` varchar(26) DEFAULT NULL,
  `COL 3` varchar(12) DEFAULT NULL,
  `COL 4` varchar(11) DEFAULT NULL,
  `COL 5` varchar(27) DEFAULT NULL,
  `COL 6` varchar(9) DEFAULT NULL,
  `COL 7` varchar(30) DEFAULT NULL,
  `COL 8` varchar(251) DEFAULT NULL,
  `COL 9` varchar(10) DEFAULT NULL,
  `COL 10` varchar(13) DEFAULT NULL,
  `COL 11` varchar(14) DEFAULT NULL,
  `COL 12` varchar(13) DEFAULT NULL,
  `COL 13` varchar(18) DEFAULT NULL,
  `COL 14` varchar(10) DEFAULT NULL,
  `COL 15` varchar(10) DEFAULT NULL,
  `COL 16` varchar(10) DEFAULT NULL,
  `COL 17` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `os_2024_3`
--

INSERT INTO `os_2024_3` (`COL 1`, `COL 2`, `COL 3`, `COL 4`, `COL 5`, `COL 6`, `COL 7`, `COL 8`, `COL 9`, `COL 10`, `COL 11`, `COL 12`, `COL 13`, `COL 14`, `COL 15`, `COL 16`, `COL 17`) VALUES
('DATA_HORA', '', 'DATA INICIAL', 'DATA FINAL ', 'EXECUTOR ', 'EMPRESA ', 'SERVIÇO ', 'DESCRICAO', 'SETOR ', 'VALOR_SERVICO', 'VALOR_MATERIAL', 'QUILOMETRAGEM', 'HORAS_MOTOR_LIGADO', '', '', '', ''),
('28/03/2024 06:55:43', 'Teste', '01/01/2024', '02/01/2024', 'Heber', 'AP MARINE', 'freio e acessórios', 'teste de descrição ', 'PÁTIO', '200', '250', '120', '', '', '', '', ''),
('28/03/2024 07:07:15', 'teste', '01/01/2024', '01/02/2024', 'Heber', 'RMS', 'revisão troca de óleo e filtro', 'teste', 'PÁTIO', '100', '1500', '150', '50', '', '', '', ''),
('02/04/2024 21:53:03', 'NEC - 0399', '01/01/0001', '01/01/0001', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão geral, Troca de todas as Lanternas do Bitrem ', 'OFICINA', '700', '700', '', '', '', '', '', NULL),
('02/04/2024 21:57:18', 'NEC - 0429', '01/01/0001', '01/01/0001', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão Geral de todas as lanternas do bitrem ', 'OFICINA', '700', '700', '', '', '', '', '', ''),
('02/04/2024 21:58:58', 'NJH - 0830', '01/01/0001', '01/01/0001', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação e troca de todas as lanternas e tomadas ', 'OFICINA', '700', '700', '', '', '', '', '', ''),
('02/04/2024 22:00:24', 'NJH - 0760', '01/01/0001', '01/01/0001', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação e troca de todas as lanternas e tomadas ', 'OFICINA', '700', '700', '', '', '', '', '', ''),
('02/04/2024 22:02:51', 'JXA - 5685', '01/01/0001', '01/01/0001', 'Eládio', 'AP MARINE', 'elétrica', 'Troca do motor de partida do caminhão MBB 1935 ', 'OFICINA', '300', '300', '', '', '', '', '', ''),
('02/04/2024 22:05:58', 'NEM - 3776', '17/05/2019', '17/05/2019', 'Eládio', 'AP MARINE', 'elétrica', 'Serviço de instalação de sirenes de ré na carreta ', 'OFICINA', '300', '300', '', '', '', '', '', ''),
('02/04/2024 22:08:01', 'NET - 2392', '01/01/0001', '01/01/0001', 'Eládio', 'AP MARINE', 'elétrica', 'Troca de um farol dianteiro de LED e revisão nas lanternas traseiras.', 'OFICINA', '100', '100', '', '', '', '', '', ''),
('10/04/2024 14:58:11', 'JVO - 7V21', '24/08/2023', '01/09/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão e instalação de lanternas', 'OFICINA', '100', '100', '', '', '', '', '', ''),
('10/04/2024 14:59:54', 'NJH - 0760', '30/08/2023', '01/08/2023', 'Eládio', 'AP MARINE', 'elétrica', '', 'OFICINA', '', '', '', '', '', '', '', ''),
('10/04/2024 15:02:48', 'KJU - 3E97', '31/08/2023', '01/09/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão e instalação de lanternas - 01 Tomada macho Redonda', 'OFICINA', '250', '250', '', '', '', '', '', ''),
('10/04/2024 15:10:10', 'ATL - OD70', '31/08/2023', '01/09/2023', 'Eládio', 'AP MARINE', 'revisão corretiva', 'Revisão e instalação de lanternas - 01 Tomada macho redonda', 'OFICINA', '250', '250', '', '', '', '', '', ''),
('10/04/2024 15:12:54', 'QLS - 2H93', '15/08/2023', '18/08/2023', 'Eládio', 'AP MARINE', 'revisão preventiva', 'Revisão Elétrica no cavalo Mecanico - 01 Lampada H7, 01 Tomada macho', 'OFICINA', '100', '100', '', '', '', '', '', NULL),
('10/04/2024 15:16:16', 'NEO - 3703', '10/08/2023', '18/03/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão Elétrica - 01 Lanterna Lateral Led - 01 Lanterna Placa led - 02 Lampadas 67.24v', 'OFICINA', '100', '100', '', '', '', '', '', ''),
('10/04/2024 15:19:29', 'SAL - 4G04', '10/08/2023', '18/08/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de faróis de milha - 01 Chave de Luz Tic Tac - 01 Farol de Milha Led ', 'OFICINA', '100', '100', '', '', '', '', '', ''),
('10/04/2024 15:22:34', 'NEM - 3776', '17/08/2023', '18/08/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Troca e instalação de tomadas e lanternas - 10 MTs de cabo 7x1 - 12 MTs de cabo 2x1 - 06 lanternas Lateral Led - 06 soquetes 2 vias - 01 omada Fêmea - 10 MTs de conduíte', 'OFICINA', '350', '350', '', '', '', '', '', ''),
('10/04/2024 15:24:57', 'NEC - 0399', '15/08/2023', '18/08/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Reposição e Instalação de tomadas e Lanternas - 01 Tomada macho - 05 MTs de cabo 7x1 - 06 MTs de cabo 2x1 - 04 Lanternas Led ', 'OFICINA', '250', '250', '', '', '', '', '', ''),
('10/04/2024 15:28:35', 'NSN - 0982 (CARRETA - RMS)', '30/08/2023', '31/08/2023', 'Eládio', 'RMS', 'elétrica', 'Revisão, instalação e reposição de lanternas - 03 Lanternas Lateral LED ', 'OFICINA', '305', '105', '', '', '', '', '', NULL),
('10/04/2024 15:33:26', 'NEM - 3776', '04/09/2023', '04/09/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação e trocas de lanternas traseiras e revisão geral', 'OFICINA', '150', '', '', '', '', '', '', ''),
('10/04/2024 15:36:44', 'RWY - 3J27', '13/09/2023', '19/09/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de Sirene de Ré , Farol de milha, Lanternas foguinho e terra da quinta roda ', 'OFICINA', '200', '200', '', '', '', '', NULL, NULL),
('10/04/2024 15:38:49', 'RWY - 3J27', '14/09/2023', '19/09/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de sirene de ré, Farol de milha, lanternas foguinho e terra da quinta roda do cavalo mecanico', 'OFICINA', '200', '200', '', '', '', '', NULL, NULL),
('10/04/2024 15:40:14', 'QLS - 2H93', '06/09/2023', '19/09/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão, recuperação e troca de faróis ', 'OFICINA', '200', '200', '', '', '', '', '', NULL),
('10/04/2024 15:42:48', 'AP 3', '06/08/2023', '19/09/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão, Instalação e reposição do motor de partida ', 'BALSA', '250', '250', '', '', '', '', '', NULL),
('10/04/2024 15:46:45', 'JVO - 2G42', '05/09/2023', '05/09/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão, Instalação, troca e recuperação de Lanternas', 'OFICINA', '300', '300', '', '', '', '', NULL, NULL),
('10/04/2024 15:48:26', 'QLS - 2H93', '05/09/2023', '19/09/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de faróis de milha e lanternas foguinho ', 'OFICINA', '100', '', '', '', '', '', '', ''),
('10/04/2024 15:52:16', 'JXA - 568 5', '01/09/2023', '04/09/2023', 'Eládio', 'RMS', 'elétrica', 'Serviço Elétrico, Luz de ré ', 'OFICINA', '100', '100', '', '', '', '', '', NULL),
('10/04/2024 15:54:37', 'Yasmin Mariana', '12/09/2023', '19/09/2023', 'Eládio', 'RMS', 'elétrica', 'Recuperação, instalação e reposição de cabos, baterias e motor de partida ', 'BALSA', '600', '600', '', '', '', '', NULL, NULL),
('10/04/2024 15:56:37', 'AP4', '11/09/2023', '19/09/2023', 'Eládio', 'RMS', 'elétrica', 'Recuperação e instalação de giroflex e sirene ', 'BALSA', '250', '250', '', '', '', '', '', ''),
('10/04/2024 16:04:02', 'JUP - 9617', '02/10/2023', '05/10/2023', 'Eládio', 'RMS', 'elétrica', 'Revisão geral, troca de lanternas e tomadas ', 'OFICINA', '400', '400', '', '', '', '', '', NULL),
('10/04/2024 16:04:53', 'JUP - 9G27', '02/10/2023', '05/10/2023', 'Eládio', 'RMS', 'elétrica', 'Revisão geral, troca de lanternas e tomadas ', 'OFICINA', '400', '400', '', '', '', '', '', NULL),
('10/04/2024 16:06:15', 'AP4', '11/10/2023', '13/10/2023', 'Eládio', 'RMS', 'elétrica', 'Recuperação, instalação, retirada e reposição de cabos elétricos ', 'BALSA', '500', '500', '', '', '', '', NULL, NULL),
('10/04/2024 16:09:03', 'NSN - 0842', '15/10/2023', '17/10/2023', 'Eládio', 'RMS', 'elétrica', 'Recuperação, instalação e reposição de tomadas e lanternas traseiras e laterais.', 'OFICINA', '250', '250', '', '', '', '', '', NULL),
('10/04/2024 16:11:39', 'OSZ - 7397', '26/10/2023', '30/10/2023', 'Eládio', 'RMS', 'elétrica', 'Revisão geral e troca de lanternas e placas ', 'OFICINA', '250', '250', '', '', '', '', '', ''),
('10/04/2024 16:12:17', 'OTB - 3256', '26/10/2023', '30/10/2023', 'Eládio', 'RMS', 'elétrica', 'Revisão geral e troca de lanternas e placas ', 'OFICINA', '250', '250', '', '', '', '', '', ''),
('10/04/2024 16:17:35', 'APV - 9B37', '17/10/2023', '20/10/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão e instalação de lanternas ', 'OFICINA', '150', '150', '', '', '', '', '', ''),
('10/04/2024 16:18:25', 'APV - 9B33', '17/10/2023', '20/10/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão e instalação de lanternas ', 'OFICINA', '150', '150', '', '', '', '', '', ''),
('10/04/2024 16:20:12', 'RWY - 3J27', '18/10/2023', '20/10/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de buzina ', 'OFICINA', '1200', '1200', '', '', '', '', '', ''),
('10/04/2024 16:22:33', 'JVO - 7D81', '17/10/2023', '20/10/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão geral e troca de lanternas e soquetes', 'OFICINA', '150', '150', '', '', '', '', '', ''),
('10/04/2024 16:25:12', 'QLS - 2H91', '17/10/2023', '20/10/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de faróis e lanternas ', 'OFICINA', '150', '150', '', '', '', '', '', ''),
('10/04/2024 16:26:42', 'AP4', '12/11/2023', '15/10/2023', 'Eládio', 'RMS', 'motor de partida', 'Serviço no motor de partida', 'BALSA', '300', '300', '', '', '', '', '', ''),
('10/04/2024 16:28:16', 'OSZ - 7397', '14/11/2023', '20/11/2023', 'Eládio', 'RMS', 'elétrica', 'revisão, instalação e troca de tomada e cabo ', 'OFICINA', '150', '150', '', '', '', '', '', NULL),
('10/04/2024 16:29:45', 'SAL - 4G04', '09/11/2023', '10/11/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de buzina marítima ( Com a Buzina ) ', 'OFICINA', '1200', '1200', '', '', '', '', '', ''),
('10/04/2024 16:30:47', 'RWX - 6C87', '08/11/2023', '10/11/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de buzina marítima ( Com a Buzina ) ', 'OFICINA', '1200', '1200', '', '', '', '', '', ''),
('10/04/2024 16:31:38', 'NEC - 0399', '08/11/2023', '10/11/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão e reposição de lanternas ', 'OFICINA', '150', '150', '', '', '', '', '', ''),
('10/04/2024 16:33:55', 'KJU - 3D07', '07/11/2023', '10/11/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão, instalação e reposição de lanternas traseira e lateral ', 'OFICINA', '200', '200', '', '', '', '', '', NULL),
('10/04/2024 16:36:18', 'AP6', '22/11/2023', '24/11/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Serviço de instalação elétrica - 03 MTs de cabo de bateria - 05 Terminais ponteira - 01 chave geral ', 'BALSA', '450', '450', '', '', '', '', '', ''),
('10/04/2024 16:39:07', 'JUE - 6E52', '23/11/2023', '24/11/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão geral, instalação e troca de lanternas traseiras e laterais ', 'OFICINA', '250', '250', '', '', '', '', '', NULL),
('10/04/2024 16:43:05', 'ATL - 5E40', '14/11/2023', '23/11/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão, instalação e troca de lanternas lateral e placa ', 'OFICINA', '300', '300', '', '', '', '', '', NULL),
('10/04/2024 16:45:47', 'QLS - 2H91', '11/11/2023', '15/11/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Troca de baterias e terminais de baterias', 'OFICINA', '100', '100', '', '', '', '', '', ''),
('10/04/2024 16:48:32', 'JVF - 2874', '11/11/2023', '15/11/2023', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão, instalação e troca de lanternas ', 'OFICINA', '100', '100', '', '', '', '', '', NULL),
('10/04/2024 16:49:48', 'AMC I', '12/12/2023', '15/12/2023', 'Eládio', 'RMS', 'elétrica', 'Serviço de alternador , troca de terminais de bateria', 'BALSA', '350', '350', '', '', '', '', '', NULL),
('10/04/2024 16:51:23', 'JVO - 2G02', '29/12/2023', '05/01/2024', 'Eládio', 'AP MARINE', 'elétrica', 'revisão, instalação e troca de lanternas traseiras, reposição de lampadas e soquetes', 'OFICINA', '400', '400', '', '', '', '', NULL, NULL),
('10/04/2024 16:52:37', 'JVO - 2G42', '29/12/2023', '05/01/2023', 'Eládio', 'AP MARINE', 'elétrica', 'revisão, instalação e troca de lanternas traseiras, reposição de lampadas e soquetes', 'OFICINA', '400', '400', '', '', '', '', NULL, NULL),
('10/04/2024 16:54:31', 'QLS - 2H94', '26/12/2023', '05/01/2024', 'Eládio', 'AP MARINE', 'elétrica', 'revisão de faróis e lanternas ', 'OFICINA', '100', '100', '', '', '', '', '', ''),
('10/04/2024 16:56:09', 'APV - 9B37', '29/12/2023', '05/01/2024', 'Eládio', 'AP MARINE', 'elétrica', 'revisão, instalação e reposição de lanternas ', 'OFICINA', '200', '200', '', '', '', '', '', NULL),
('10/04/2024 16:57:11', 'QLS - 2H94', '21/12/2023', '21/12/2023', 'Eládio', 'AP MARINE', 'elétrica', 'troca de baterias e terminais de bateria', 'OFICINA', '50', '50', '', '', '', '', '', ''),
('10/04/2024 17:00:30', 'AMC', '17/12/2023', '04/01/2024', 'Eládio', 'RMS', 'elétrica', 'recuperação, instalação e troca de sensores do alarme de nível, recuperação do painel do instrumento de alarme de nível, instalação do motor do limpador de parabrisa, lampada da bússola, troca de cabos e sensores do alarme de nível da sala de máquinas', 'BALSA', '1200', '1200', '', NULL, NULL, NULL, NULL, NULL),
('10/04/2024 17:02:29', 'AMC', '22/01/2024', '25/01/2024', 'Eládio', 'RMS', 'elétrica', 'Serviço de instalação geral, Instalação de antena, GPS, rádio, limpador, buzina, confecção e montagem de quadro de instrumento e caixa de bateria', 'BALSA', '4500', '4500', NULL, NULL, NULL, NULL, NULL, NULL),
('10/04/2024 17:04:40', 'AMC I', '12/01/2024', '15/01/2024', 'Eládio', 'RMS', 'elétrica', 'serviço de alternador, recuperação da base e troca da correia ', 'BALSA', '250', '250', '', '', '', '', '', NULL),
('03/07/2024 17:37:16', 'JTH7G07', '28/06/2024', '28/06/2024', 'Izaías Campos - Borracheiro', 'RMS', 'pneu', 'Montagem e Desmontagem', 'PÁTIO', '30.0', '', '', '', '', '', '', ''),
('03/07/2024 17:40:10', 'NSN - 0982 (CARRETA - RMS)', '28/06/2024', '28/06/2024', 'Izaías ', 'RMS', 'pneu', 'Montagem e montagem de 2 pneus', 'PÁTIO', '60.0', '', '', '', '', '', '', ''),
('03/07/2024 17:42:11', 'NEP 0261', '28/06/2024', '28/06/2024', 'Izaías', 'RMS', 'pneu', 'Montagem e desmontagem de 2 pneus', 'PÁTIO', '60.0', '', '', '', '', '', '', ''),
('03/07/2024 17:52:13', 'OSZ - 7397', '28/06/2024', '28/06/2024', '60.0', 'RMS', 'pneu', 'Troca de 2 pneus estourados', 'PÁTIO', '60.', '', '', '', '', '', '', ''),
('03/07/2024 18:13:20', 'AP4', '24/06/2024', '28/06/2024', 'Jean', 'RMS', 'limpeza e organização', 'Limpeza de 15 Cofferdans, 2 tanques de combustível e lavagem geral da balsa.', 'BALSA', '3000', '', '', '', '', '', '', NULL),
('03/07/2024 18:15:08', 'AP4', '26/06/2024', '28/06/2024', 'Jean', 'RMS', 'revisão corretiva', 'Manutenção das  vávulas de descarregamento ', 'BALSA', '1000', '', '', '', '', '', '', ''),
('03/07/2024 18:16:50', 'AMC I', '27/06/2024', '28/06/2024', 'Jean', 'RMS', 'limpeza e organização', 'Limpeza de casco', 'BALSA', '500', '', '', '', '', '', '', ''),
('04/07/2024 11:22:44', 'Casa de Força da Empresa', '31/05/2024', '08/06/2024', 'Guido Barradas', 'AP MARINE', 'outros', 'Reforma da parade da casa de força que foi danificada devido a uma batida de uma carreta que saiu do suporte do \"cavalete\"', 'PÁTIO', '2000', '673', '', '', '', '', '', ''),
('04/07/2024 11:28:19', 'AP1', '18/06/2024', '21/06/2024', 'Moiés ', 'AP MARINE', 'outros', 'Instalação de um banco de madeira.', 'BALSA', '1000', '', '', '', '', '', '', ''),
('04/07/2024 11:30:11', 'AP 3', '18/06/2024', '21/06/2024', 'Mário', 'AP MARINE', 'outros', 'Instalação e confecção de um banco para o comando.', 'BALSA', '300', '', '', '', '', '', '', ''),
('04/07/2024 11:34:08', 'Sala que será do Eládio', '18/06/2024', '21/06/2024', 'Marin', 'AP MARINE', 'outros', 'Reforma da porta de entrada', 'OFICINA', '650', '', '', '', '', '', '', ''),
('04/07/2024 15:15:59', 'SZE 5A84', '27/06/2024', '27/06/2024', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de buzina marítima no cavalo mecânico', 'PÁTIO', '1200', '', '', '', '', '', '', ''),
('04/07/2024 15:22:38', 'SAM 1B88', '17/06/2024', '17/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem - 1PÇ', 'PÁTIO', '60', '', '', '', '', '', '', ''),
('04/07/2024 15:25:07', 'SAL 0G83', '18/06/2024', '18/06/2024', 'Heber', 'RMS', 'pneu', 'Montagem e desmontagem - 10 PÇ', 'PÁTIO', '300', '', '', '', '', '', '', ''),
('04/07/2024 15:29:44', 'JUP - 9617', '24/06/2024', '28/06/2024', 'Eládio', 'AP MARINE', 'elétrica', 'Troca de instalação, todas as lanternas e tomadas do bitrem de placa JUP 9G17', 'PÁTIO', '400', '', '', '', '', '', '', NULL),
('04/07/2024 15:32:17', 'KJU - 3E97', '17/06/2024', '17/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem - 6 PÇ', 'OFICINA', '180', '', '', '', '', '', '', ''),
('04/07/2024 15:33:41', 'JUP - 9G27', '24/06/2024', '28/06/2024', 'Eládio', 'AP MARINE', 'elétrica', 'Troca de instalação, todas as lanternas e tomadas do bitrem de placa JUP 9G27', 'PÁTIO', '400', '', '', '', '', '', '', NULL),
('04/07/2024 15:33:48', 'RWY - 3J27', '18/06/2024', '18/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem - 8PÇ', 'OFICINA', '240', '', '', '', '', '', '', ''),
('04/07/2024 15:36:36', 'QLS - 2H93', '18/06/2024', '18/06/2024', 'Heber', 'AP MARINE', 'revisão corretiva', 'Troca de roda trincada.', 'OFICINA', '30', '', '', '', '', '', '', ''),
('04/07/2024 15:36:40', 'SAM 1B84', '17/06/2024', '17/06/2024', 'Eládio', 'AP MARINE', 'elétrica', 'Instalação de buzina marítima no cavalo mecânico de placa SAM 1B84', 'PÁTIO', '1200', '', '', '', '', '', '', ''),
('04/07/2024 15:38:16', 'QLS - 2H93', '18/06/2024', '18/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem', 'OFICINA', '60', '', '', '', '', '', '', ''),
('04/07/2024 15:41:37', 'SAM1B84 - SLZ', '17/06/2024', '17/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem', 'OFICINA', '30', '', '', '', '', '', '', ''),
('04/07/2024 15:47:25', 'AP4', '07/03/2024', '14/03/2024', 'Eládio', 'AP MARINE', 'elétrica', 'Serviço de instalação na balsa AP Marine VI (Bateria da Bomba)', 'BALSA', '300', '', '', '', '', '', '', ''),
('04/07/2024 15:49:44', 'OCA 2089', '13/06/2024', '13/06/2024', 'Heber', 'RMS', 'pneu', 'Montagem e desmontagem - 8 PÇ', 'OFICINA', '240', '', '', '', '', '', '', ''),
('04/07/2024 15:51:59', 'JUE 8050', '13/06/2024', '13/06/2024', 'Heber', 'RMS', 'pneu', 'Montagem e desmontagem - 3PÇ', 'OFICINA', '90', '', '', '', '', '', '', ''),
('04/07/2024 15:55:38', 'SAL 0G83', '14/06/2024', '14/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem - 4 PÇ', 'OFICINA', '120', '', '', '', '', '', '', ''),
('04/07/2024 15:59:37', 'KJU - 3E97', '11/03/2024', '11/03/2024', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão no bitrem de placa KJU 3E97 troca de 2 lanternas vermelha (Três Marias)', 'PÁTIO', '180', '', '', '', '', '', '', ''),
('04/07/2024 16:01:13', 'KJU - 3D07', '11/03/2024', '11/03/2024', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão no bitrem de placa KJU 3D07 troca de 2 lanternas vermelha (Três Marias)', 'PÁTIO', '180', '', '', '', '', '', '', ''),
('04/07/2024 16:02:43', 'Aline - Balsa', '10/06/2024', '17/06/2024', 'Jean ', 'RMS', 'outros', 'Apoio operacional na contenção e limpeza da balsa', 'BALSA', '1000', '', '', '', '', '', '', ''),
('04/07/2024 16:09:50', 'AP 3', '13/03/2024', '13/03/2024', 'Carlos Barros', 'AP MARINE', 'outros', 'Limpeza da praia para o posicionamento da AP III', 'BALSA', '400', '', '', '', '', '', '', ''),
('04/07/2024 16:11:21', 'NEC - 0399', '07/06/2024', '07/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem - 2PÇ', 'OFICINA', '60', '', '', '', '', '', '', ''),
('04/07/2024 16:35:29', 'KEV 5109', '12/06/2024', '12/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem - 18 PÇ', 'OFICINA', '540', '', '', '', '', '', '', ''),
('04/07/2024 16:39:09', 'APV - 9B33', '10/06/2024', '10/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem - 16PÇ', 'OFICINA', '', '', '', '', '', '', '', ''),
('04/07/2024 17:27:46', 'NEO 3701', '28/05/2024', '28/05/2024', 'Eládio', 'AP MARINE', 'revisão corretiva', 'Revisão e instalação de lanternas da placa ', 'OFICINA', '75', '', '', '', '', '', '', ''),
('04/07/2024 17:29:19', 'AP 3', '13/03/2024', '13/03/2024', 'Carlos Barros', 'AP MARINE', 'outros', 'Montagem de um elevado de madeira na praia para posicionar a AP Marine III', 'BALSA', '400', '', '', '', '', '', '', ''),
('04/07/2024 17:29:59', 'NEO 3701', '28/05/2024', '28/05/2024', 'Heber', 'AP MARINE', 'revisão corretiva', 'Tomada e lanterna da lateral da carreta.', 'OFICINA', '', '', '', '', '', '', '', ''),
('04/07/2024 17:40:30', 'KEV 5119', '11/06/2024', '11/06/2024', 'Eládio', 'AP MARINE', 'revisão corretiva', 'Troca e instalação de todas as lanternas traseiras e laterais, troca de tomadas', 'OFICINA', '400', '', '', '', '', '', '', NULL),
('04/07/2024 17:40:50', 'APV - 9B37', '20/03/2024', '20/03/2024', 'Eládio', 'AP MARINE', 'revisão corretiva', 'Revisão geral desinstalação troca de tomadas e troca de lanternas laterais e placa no bitrem de placa APV 9B37', 'PÁTIO', '200', '140', '', '', '', '', '', ''),
('04/07/2024 17:41:43', 'KEV 5109', '11/06/2024', '11/06/2024', 'Eládio', 'AP MARINE', 'revisão preventiva', 'Troca e instalação de todas as lanternas traseiras e laterais, troca de tomadas', 'OFICINA', '400', '', '', '', '', '', '', NULL),
('04/07/2024 17:41:53', 'APV - 9B33', '20/03/2024', '20/03/2024', 'Eládio', 'AP MARINE', 'revisão corretiva', 'Revisão geral desinstalação troca de tomadas e troca de lanternas laterais e placa no bitrem de placa APV 9B33', 'PÁTIO', '200', '140', '', '', '', '', '', ''),
('04/07/2024 17:44:26', 'QLS - 2H94', '28/05/2024', '28/05/2024', 'Eládio', 'AP MARINE', 'revisão preventiva', 'Revisão de faróis e lanternas', 'OFICINA', '75', '', '', '', '', '', '', ''),
('04/07/2024 17:45:34', 'QEZ 9A84', '26/03/2024', '26/03/2024', 'Eládio', 'AP MARINE', 'revisão corretiva', 'Revisão de baterias, troca de tomadas no cavalo mecânico de placa QEZ 9A87', 'PÁTIO', '100', '', '', '', '', '', '', NULL),
('04/07/2024 17:46:21', 'QLS - 2H94', '28/05/2024', '28/05/2024', 'Eládio', 'AP MARINE', 'revisão corretiva', 'Troca de baterias do cavalo mecânico', 'OFICINA', '75', '', '', '', '', '', '', ''),
('04/07/2024 17:48:08', 'JWB 4F45', '26/03/2024', '26/03/2024', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de instalação e troca de lanternas 3 Marias na carreta de placa JWB 4F45', 'PÁTIO', '150', '', '', '', '', '', '', ''),
('04/07/2024 17:52:06', 'JVO - 7V21', '23/05/2024', '23/05/2024', 'Eládio', 'AP MARINE', 'revisão preventiva', 'Revisão de instalação da troca de lanternas traseira e laterais', 'OFICINA', '175', '', '', '', '', '', '', ''),
('04/07/2024 17:53:26', 'JVO - 7D81', '23/05/2024', '23/05/2024', 'Eládio', 'AP MARINE', 'revisão preventiva', 'Revisão de instalação da troca de lanternas traseira e laterais', 'OFICINA', '175', '', '', '', '', '', '', ''),
('04/07/2024 17:55:25', 'NEM - 3774', '24/05/2024', '24/05/2024', 'Eládio', 'AP MARINE', 'revisão corretiva', 'Revisão e reposição de lanternas laterais.', 'OFICINA', '100', '', '', '', '', '', '', ''),
('04/07/2024 17:58:34', 'JUE 8050', '13/06/2024', '13/06/2024', 'Eládio', 'AP MARINE', 'revisão corretiva', 'Revisão de lanternas laterais.', 'OFICINA', '200', '', '', '', '', '', '', ''),
('04/07/2024 17:59:52', 'QLS - 2H91', '25/03/2024', '25/03/2024', 'Eládio', 'AP MARINE', 'elétrica', 'Revisão de farois, lanternas e troca de palheta do limpador de parabrisa no cavalo mecânico de placa QLS 2H91', 'PÁTIO', '100', '', '', '', '', '', '', NULL),
('04/07/2024 18:00:50', 'IEA 8370', '13/06/2024', '13/06/2024', 'Eládio', 'RMS', 'revisão corretiva', 'Troca de lanternas laterais e traseira.', 'OFICINA', '200', '', '', '', '', '', '', ''),
('04/07/2024 18:01:51', 'AMC', '21/03/2024', '21/03/2024', 'Eládio', 'RMS', 'elétrica', 'Instalação de antena AIS', 'BALSA', '200', '', '', '', '', '', '', ''),
('04/07/2024 18:03:26', 'JTL 8663', '27/05/2024', '27/05/2024', 'Eládio', 'RMS', 'revisão corretiva', 'Revisão e instalação de lanternas laterais e traseira.', 'OFICINA', '200', '', '', '', '', '', '', ''),
('04/07/2024 18:06:59', 'JTA 5485', '29/05/2024', '29/05/2024', 'Eládio', 'RMS', 'revisão corretiva', 'Revisão e instalação de lanternas laterais e traseira.', 'OFICINA', '', '', '', '', '', '', '', ''),
('04/07/2024 18:11:44', 'JVT 1572', '24/05/2024', '24/05/2024', 'Eládio', 'RMS', 'revisão corretiva', 'Troca de tomadas, revisão e instalação de lanternas laterais e traseira.', 'OFICINA', '200', '', '', '', '', '', '', NULL),
('04/07/2024 18:15:31', 'AMC', '13/06/2024', '13/06/2024', 'Eládio', 'RMS', 'elétrica', 'Troca de lanternas do mastro.', 'BALSA', '100', '', '', '', '', '', '', ''),
('05/07/2024 09:43:50', 'SAL - 4G04', '28/05/2024', '28/05/2024', 'Eládio', 'RMS', 'revisão corretiva', 'Revisão e troca de lanternas e baterias', 'OFICINA', '150', '', '', '', '', '', '', ''),
('05/07/2024 09:49:24', 'JUP - 9617', '25/06/2024', '25/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Instalação de pneus novos. - 7 PÇ', 'OFICINA', '210', '', '', '', '', '', '', ''),
('05/07/2024 10:08:08', 'AMC I', '29/02/2024', '02/03/2024', 'Jean ', 'RMS', 'revisão corretiva', 'Tornear Eixo, Alinhar Hélice, Refazer Bucha', 'BALSA', '4500', '', '', '', '', '', NULL, NULL),
('05/07/2024 10:11:51', 'AP 3', '18/04/2024', '18/10/2024', 'Jean', 'AP MARINE', 'revisão preventiva', 'Manta de Vedação na Descarga da APIII', 'BALSA', '200', '', '', '', '', '', '', ''),
('05/07/2024 10:14:23', 'AMC', '06/03/2024', '06/03/2024', 'Jean', 'RMS', 'revisão preventiva', 'Manutenção no Empurrador AMC', 'BALSA', '600', '', '', '', '', '', '', ''),
('05/07/2024 10:15:35', 'Yasmin Mariana', '06/03/2024', '06/03/2024', 'Jean', 'RMS', 'revisão corretiva', 'Válvula da Yasmin', 'BALSA', '600', '', '', '', '', '', '', ''),
('05/07/2024 10:15:38', 'JUP - 9G27', '25/06/2024', '25/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Instalação de pneus novos - 7 PÇ', 'OFICINA', '210', '', '', '', '', '', '', ''),
('05/07/2024 10:16:55', 'AMC I', '06/03/2024', '06/03/2024', 'Jean', 'RMS', 'revisão corretiva', 'Remoção dos Suportes da AMC1, Limpeza dos Cofferdans de Ré', 'BALSA', '600', '', '', '', '', '', '', NULL),
('05/07/2024 10:19:19', 'AMC I', '15/04/2024', '19/04/2024', 'Jean', 'RMS', 'revisão corretiva', 'Arames de Suporte da Descarga da AMC1', 'BALSA', '150', '', '', '', '', '', '', ''),
('05/07/2024 10:20:53', 'AMC I', '15/04/2024', '19/04/2024', 'Jean', 'RMS', 'pintura', 'Pintura Preventiva da AMC1', 'BALSA', '1200', '', '', '', '', '', '', ''),
('05/07/2024 10:21:49', 'AMC I', '03/04/2024', '09/04/2024', 'Jean', 'RMS', 'pintura', 'Pintura Preventiva na AMC1', 'BALSA', '1050', '', '', '', '', '', '', ''),
('05/07/2024 10:24:14', 'AMC', '09/04/2024', '10/04/2024', 'Jean', 'RMS', 'outros', 'Forro do Empurrador AMC - Comando e Primeiro e Segundo Convés', 'BALSA', '2000', '', '', '', '', '', '', ''),
('05/07/2024 10:26:49', 'KJU - 3E97', '26/06/2024', '26/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Troca de pneus por pneus novos - 4 PÇ', 'OFICINA', '135', '', '', '', '', '', '', ''),
('05/07/2024 10:29:49', 'Pátio', '03/07/2024', '05/07/2024', 'Heber', 'AP MARINE', 'outros', 'Confecção de um carro completo para adaptação de motor e bomba de longitividade conforme solicitação', 'PÁTIO', '5500', '', '', '', '', '', '', ''),
('05/07/2024 10:33:01', 'Pátio', '03/07/2024', '05/07/2024', 'Heber', 'AP MARINE', 'outros', 'Serviço de recuperação de uma bomba longetividade com retifica e procu de embuchamento com montagem fina', 'PÁTIO', '2000', '', '', '', '', '', '', ''),
('05/07/2024 10:34:17', 'AP4', '02/07/2024', '03/07/2024', 'Jean', 'RMS', 'limpeza e organização', 'Limpeza em Dois Tanques de Consumo da AP IV', 'BALSA', '800', '', '', '', '', '', '', ''),
('05/07/2024 10:35:51', 'AP4', '01/07/2024', '02/07/2024', 'Evandro', 'RMS', 'limpeza e organização', 'Limpeza Tanque de Carga', 'BALSA', '2000', '', '', '', '', '', '', ''),
('05/07/2024 10:41:50', 'JVO7F21 e JVO7D81 (bitrem)', '15/02/2024', '28/02/2024', 'Jean', 'AP MARINE', 'revisão corretiva', 'Revisão de Instalação, troca de lanternas lateral e recuperação de duas lanternas traseiras', 'OFICINA', '400', '', '', '', '', '', '', NULL),
('05/07/2024 10:44:30', 'QEZ9A84', '26/02/2024', '28/02/2024', 'Jean', 'AP MARINE', 'revisão corretiva', 'Revisão de Faróis, Lanternas e Troca de Lâmpadas no cavalo mecânico', 'OFICINA', '100', '', '', '', '', '', '', NULL),
('05/07/2024 10:46:41', 'JTH7G07', '26/02/2024', '28/02/2024', 'Jean', 'RMS', 'revisão corretiva', 'Revisão de Instalação, Lanternas e Reposição de Tomada na carreta', 'OFICINA', '100', '', '', '', '', '', '', NULL),
('05/07/2024 10:53:47', 'AMC', '08/03/2024', '14/03/2024', 'Jean', 'RMS', 'revisão corretiva', 'Serviço de Instalação no Rebocador AMC, Retirada e Reposição de Todas as Lâmpadas e Cabos do Mastro, Instalação do Holofote e Instalação do Radar', 'BALSA', '2200', '', '', '', '', '', NULL, NULL),
('05/07/2024 10:58:51', 'ATL - OD70', '24/10/2023', '30/10/2023', 'Heber', 'AP MARINE', 'pintura', 'Pintura de Letras', 'OFICINA', '800', '', '', '', '', '', '', ''),
('05/07/2024 10:59:49', 'NEC - 0399', '23/10/2023', '24/10/2023', 'Heber', 'AP MARINE', 'pintura', 'Pintura de Letras', 'OFICINA', '400', '', '', '', '', '', '', ''),
('05/07/2024 11:00:33', 'KJU - 3D07', '26/06/2024', '26/06/2024', 'Eládio', 'AP MARINE', 'pneu', 'Instalação de 4 pneus novos e uma troca de pneu furado.', 'OFICINA', '175', '', '', '', '', '', '', ''),
('05/07/2024 11:03:47', 'SAL - 4G04', '22/06/2024', '22/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem - 8PÇ', 'OFICINA', '240', '', '', '', '', '', '', ''),
('05/07/2024 11:03:49', 'KQD - 5613', '08/10/2023', '09/10/2023', 'Heber', 'AP MARINE', 'pintura', 'Pintura de Letras', 'OFICINA', '400', '', '', '', '', '', '', ''),
('05/07/2024 11:05:03', 'NEM - 3776', '13/10/2023', '15/10/2023', 'Heber', 'AP MARINE', 'pintura', 'Pintura de Letras', 'OFICINA', '400', '', '', '', '', '', '', ''),
('05/07/2024 11:07:09', 'QLS - 2H91', '21/06/2024', '21/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem - 2 PÇ', 'OFICINA', '60', '', '', '', '', '', '', ''),
('05/07/2024 11:08:29', 'AP6', '11/03/2024', '07/03/2024', 'Jean', 'AP MARINE', 'revisão corretiva', 'Conserto e manutenção de todo o sistema de alarme de nível dos tanques', 'BALSA', '2500', '', '', '', '', '', '', ''),
('05/07/2024 11:10:25', 'AP6', '17/06/2024', '21/06/2024', 'Evandro', 'AP MARINE', 'limpeza e organização', '500', 'BALSA', '', '', '', '', '', '', '', ''),
('05/07/2024 11:11:49', 'AP6', '01/02/2024', '01/02/2024', 'Jean', 'AP MARINE', 'outros', 'Adesivagem nas válvulas da AP VI', 'BALSA', '150', '', '', '', '', '', '', ''),
('05/07/2024 11:13:35', 'Escritório da Coordenação', '01/02/2024', '01/02/2024', 'Jean', 'AP MARINE', 'pintura', 'Pintura do Escritório da Coordenação', 'ESCRITÓRIO', '2300', '670.98', '', '', '', '', '', ''),
('05/07/2024 11:13:40', 'JTV 1572', '30/06/2024', '30/06/2024', 'Heber', 'RMS', 'pneu', 'Montagem e desmontagem - 3PÇ', 'OFICINA', '90', '', '', '', '', '', '', ''),
('05/07/2024 11:16:52', 'SAL - 4G04', '26/06/2024', '26/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Troca de pneus por pneus novos - 8 PÇ', 'OFICINA', '240', '', '', '', '', '', '', ''),
('05/07/2024 11:17:58', 'AP1', '27/03/2024', '01/04/2024', 'Jean', 'AP MARINE', 'revisão corretiva', 'Dreno do Banheiro da AP1, Estrutura do Balustrato de Popa, Corrigir Infiltrações nos Pisos Superiores e Inferior', 'BALSA', '2625', '', '', '', '', '', NULL, NULL),
('05/07/2024 11:18:54', 'JUE - 6E52', '29/06/2024', '29/06/2024', 'Heber', 'AP MARINE', 'pneu', 'Montagem e desmontagem -  1pneu', 'OFICINA', '30', '', '', '', '', '', '', ''),
('05/07/2024 11:19:01', 'AP1', '27/03/2024', '01/04/2024', 'Jean', 'AP MARINE', 'pintura', 'Pintura de Comando e Convés', 'BALSA', '875', '', '', '', '', '', '', ''),
('05/07/2024 11:23:43', 'AP1', '02/04/2024', '05/04/2024', 'Jean', 'AP MARINE', 'outros', 'Proteção das panelas do fogão, 6 pontos de cabo de aço no mastro, uma caixa d\'água de mil litros, troca de tubulação da caixa d\'água, implantação do armário do comando, instalação da mesa lateral e suporte em cima da pia', 'BALSA', '4200', '', '', NULL, NULL, NULL, NULL, NULL),
('05/07/2024 11:31:13', 'AP 3', '17/01/2024', '24/01/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Drenar cofferdans, Limpeza dos Camarotes e remoção de níveis e limpeza da praça de máquinas', 'BALSA', '2250', '', '', '', '', '', '', NULL),
('05/07/2024 11:32:13', 'AMC I', '17/01/2024', '24/01/2024', 'Jean', 'RMS', 'limpeza e organização', 'Limpeza de cofferdans de popa', 'BALSA', '750', '', '', '', '', '', '', ''),
('05/07/2024 11:38:17', 'AP6', '21/01/2024', '26/01/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Limpeza dos convés e sala de bombas', 'BALSA', '1000', '', '', '', '', '', '', ''),
('05/07/2024 11:39:24', 'AP1', '21/01/2024', '26/01/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Limpeza da sala de máquinas, sala de bombas, cozinha e comando', 'BALSA', '1000', '', '', '', '', '', NULL, NULL),
('05/07/2024 11:40:28', 'Yasmin Mariana', '21/01/2024', '26/01/2024', 'Jean', 'RMS', 'limpeza e organização', 'Limpeza da sala de bombas e casaria', 'BALSA', '1000', '', '', '', '', '', '', ''),
('05/07/2024 11:40:33', 'AMC', '08/03/2024', '08/03/2024', 'Franck', 'AP MARINE', 'outros', 'Serviço de solda no suporte do radar.', 'BALSA', '', '', '', '', '', '', '', ''),
('05/07/2024 11:44:10', 'APV - 9B37', '07/03/2024', '07/03/2024', 'Franck', 'AP MARINE', 'outros', 'Serviço de solda na base da balança da carreta.', 'OFICINA', '', '', '', '', '', '', '', ''),
('05/07/2024 11:49:59', 'AP4', '09/02/2024', '12/02/2024', 'Jean', 'RMS', 'limpeza e organização', 'Limpeza do Cofferdan, Tanques de consumo, Tanques e Desgazificação', 'BALSA', '2100', '', '', '', '', '', NULL, NULL),
('05/07/2024 11:51:11', 'Yasmin Mariana', '09/02/2024', '12/02/2024', 'Jean', 'RMS', 'limpeza e organização', 'Limpeza da Sala de bombas e caixa de respingo', 'BALSA', '1050', '', '', '', '', '', '', ''),
('05/07/2024 11:51:50', 'AMC', '06/03/2024', '06/03/2024', 'Franck', 'RMS', 'outros', 'Serviço de solda na base do holofote do empurrador.', 'BALSA', '', '', '', '', '', '', '', ''),
('05/07/2024 11:52:21', 'AMC I', '09/02/2024', '12/02/2024', 'Jean', 'RMS', 'limpeza e organização', 'Limpeza de Cofferdams e pintura', 'BALSA', '1050', '', '', '', '', '', '', ''),
('05/07/2024 11:54:33', 'AMC', '15/02/2024', '17/02/2024', 'Evandro', 'RMS', 'limpeza e organização', 'Limpeza de Máquinas', 'BALSA', '750', '', '', '', '', '', '', ''),
('05/07/2024 11:55:34', 'AMC', '05/03/2024', '05/03/2024', 'Franck', 'RMS', 'outros', 'Serviço de confecção de um suporte da base da geladeira do empurrador.', 'BALSA', '', '', '', '', '', '', '', ''),
('05/07/2024 11:56:07', 'AMC I', '15/02/2024', '17/02/2024', 'Evandro', 'RMS', 'limpeza e organização', 'Remoção de obstáculos para docagem das balsas, Limpeza de 12 cofferdams e Limpeza da Sala de Máquinas devido a um vazamento de óleo', 'BALSA', '2250', '', '', '', '', '', '', NULL),
('05/07/2024 11:58:40', 'AMC I', '05/03/2024', '05/03/2024', 'Franck', 'RMS', 'outros', 'Serviço de solda no suporte de iluminação do mastro da balsa.', 'BALSA', '', '', '', '', '', '', '', ''),
('05/07/2024 11:59:34', 'AP6', '26/02/2024', '28/02/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Limpeza e drenagem de 8 cofferdams', 'BALSA', '1000', '', '', '', '', '', '', ''),
('05/07/2024 12:00:45', 'AMC I', '26/02/2024', '28/02/2024', 'Jean', 'RMS', 'limpeza e organização', 'Limpeza e Raspagem do casco lateral', 'BALSA', '500', '', '', '', '', '', '', ''),
('05/07/2024 12:01:21', 'Yasmin Mariana', '26/02/2024', '28/02/2024', 'Jean', 'RMS', 'limpeza e organização', 'Limpeza e raspagem do casco lateral', 'BALSA', '500', '', '', '', '', '', '', ''),
('05/07/2024 12:02:36', 'AP6', '29/02/2024', '29/02/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Posicionar, cavar, sala de máquinas', 'BALSA', '2500', '', '', '', '', '', NULL, NULL),
('05/07/2024 12:03:43', 'AP6', '07/03/2024', '10/03/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Limpeza geral para Vistoria', 'BALSA', '1200', '', '', '', '', '', '', ''),
('05/07/2024 12:04:53', 'AP1', '11/03/2024', '20/03/2024', 'Jean', 'AP MARINE', 'revisão preventiva', 'Manutenção de 6 válvulas', 'BALSA', '1200', '', '', '', '', '', '', ''),
('05/07/2024 12:07:12', 'AP 3', '19/03/2024', '19/03/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Drenagem dos Tanques', 'BALSA', '1150', '', '', '', '', '', '', ''),
('05/07/2024 12:07:57', 'AP 3', '19/03/2024', '19/03/2024', 'Jean', 'AP MARINE', 'outros', 'Posicionamento de um elevado de madeira para posicionar a AP3', 'BALSA', '1150', '', '', '', '', '', '', ''),
('05/07/2024 12:09:18', 'AP1', '05/04/2024', '05/04/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Limpeza da sala de bombas, drenagem e limpeza dos cofferdams de popa', 'BALSA', '1100', '', '', '', '', '', '', NULL),
('05/07/2024 12:10:19', 'AP1', '05/04/2024', '05/04/2024', 'Jean', 'AP MARINE', 'revisão preventiva', 'Manutenção de 5 válvulas', 'BALSA', '550', '', '', '', '', '', '', ''),
('05/07/2024 12:11:01', 'AP1', '05/04/2024', '05/04/2024', 'Jean', 'AP MARINE', 'outros', 'Suporte para remoção de hélice', 'BALSA', '550', '', '', '', '', '', '', ''),
('05/07/2024 12:11:53', 'AP1', '09/04/2024', '10/04/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Limpeza da sala de máquinas e sala de bombas', 'BALSA', '765', '', '', '', '', '', '', ''),
('05/07/2024 12:13:05', 'AP6', '09/04/2024', '09/04/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Drenagem e limpeza de dois cofferdams de proa', 'BALSA', '765', '', '', '', '', '', '', ''),
('05/07/2024 12:15:17', 'AMC', '09/04/2024', '09/04/2024', 'Jean', 'RMS', 'pintura', 'Pintura e remoção de ferrumgem', 'BALSA', '390', '', '', '', '', '', '', ''),
('05/07/2024 12:16:17', 'AMC', '09/04/2024', '09/04/2024', 'Jean', 'RMS', 'revisão corretiva', 'Reforma da Janela (parte da esquadria)', 'BALSA', '390', '', '', '', '', '', '', ''),
('05/07/2024 13:14:23', 'AP6', '18/04/2024', '18/04/2024', 'Jean', 'AP MARINE', 'limpeza e organização', 'Limpeza de 4 cofferdans e Lavagem da Sala de Bombas e Casinhola', 'BALSA', '1200', '', '', '', '', '', '', ''),
('05/07/2024 13:15:40', 'AMC I', '18/04/2024', '18/04/2024', 'Jean', 'RMS', 'revisão preventiva', '6 Válvulas de Tanques e 4 Válvulas de Tubulação', 'BALSA', '2500', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tanque_os`
--

CREATE TABLE `tanque_os` (
  `id` int(11) NOT NULL,
  `id_ativo` varchar(4) NOT NULL,
  `dados` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `veiculo_os`
--

CREATE TABLE `veiculo_os` (
  `id` int(11) NOT NULL,
  `id_ativo` varchar(111) NOT NULL,
  `dados` varchar(10000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `veiculo_os`
--

INSERT INTO `veiculo_os` (`id`, `id_ativo`, `dados`) VALUES
(61, '15', 'odometerValue: 376356 | maintenanceStartDate: 2024-02-22 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-02-22 | maintenanceFinishTime: 10:30 | id: 15 | radio-maintenance: preditiva | observacoes: Sistemas afetados: Motor \n\nNome solicitante: \n\nMateriais utilizados: \n\nOléo 15w40 - 2x40l \nFiltro de combustível - 02\nFiltro Racoor - 01\nFiltro de ar - 01 \nFiltro Rotativo - 01 \nfiltro secador de ar - 01  \n'),
(62, '15', 'odometerValue:  | maintenanceStartDate: 2024-02-04 | maintenanceStartTime: 16:00 | maintenanceEndDate: 2024-02-05 | maintenanceFinishTime: 12:00 | id: 15 | radio-maintenance: corretiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Nome do solicitante: Daniel Silva\r\n\r\nRemoção e instalação de 04 Perro de roda dianteiro, 02 para-lamas dianteiro.'),
(63, '19', 'odometerValue: 000 | maintenanceStartDate: 2024-02-19 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-02-19 | maintenanceFinishTime: 12:00 | id: 19 | radio-maintenance: corretiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Nome do Solicitante: Francisco Reginaldo. \r\n\r\nTrocado mola do freio de estacionamento da cuica. \r\nTrocado diafragma 30x30 da cuica, regulado freio.\r\n\r\nMaterias utilizados: \r\n\r\n01 mola do freio de serviço. \r\n02 diafragma 30x30'),
(64, '14', 'odometerValue:  | maintenanceStartDate: 2024-03-22 | maintenanceStartTime: 14:00 | maintenanceEndDate: 2024-03-22 | maintenanceFinishTime: 16:30 | id: 14 | radio-maintenance: preventiva | observacoes: Motor de Combustão (intervenção).\r\n\r\nNome do Solicitante: Daniel Silva \r\n\r\nMateriais utilizados: \r\n\r\n36 litros de óleo 15w40\r\n01 filtro de ar \r\n01 filtro racool \r\n01 filtro cabine \r\n01 filtro óleo lubrificante \r\n02 filtro de óleo diesel \r\n\r\n'),
(69, '15', 'odometerValue: 411493 | maintenanceStartDate: 2024-05-03 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-05-03 | maintenanceFinishTime: 10:30 | id: 15 | radio-maintenance: preventiva | causaPreventivaPreditivaCheckbox: causaPreventivaPreditivaCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Revisão de troca de óleo e filtros  | mantenedores: Heber costa aguiar  | materiaisUtilizados: 37 litros de óleo 15w/40\r\n1 filtro de ar \r\n2 filtro diesel \r\n1 filtro de óleo lubrificante do motor\r\n1 filtro rotativo'),
(70, '15', 'odometerValue: 416767 | maintenanceStartDate: 2024-05-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-05-16 | maintenanceFinishTime: 15:51 | id: 15 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | freiosCheckbox: freiosCheckbox | vazandoCheckbox: Vazando | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Remoção e instalação de 2 rolamentos do cubo de roda L/D e trocado a lona de freio. | mantenedores: Heber costa aguiar  | materiaisUtilizados: 2 rolamentos do cubo de roda\r\n1 retentor do cubo\r\n1 aranha trava \r\n1 par de lona de freio'),
(71, '18 ', 'odometerValue:  | maintenanceStartDate: 2024-05-20 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-05-21 | maintenanceFinishTime: 17:00 | id: 18 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | observacoes: Remoção e instalação: 2 jogos de lona de freio, 2 kit de bucha do eixo \"s\", trocado faixa do para-choque trocado, faixa refletida, regulado freio.  | mantenedores: Héber Costa Aguiar. | materiaisUtilizados: Lona de freio 2 jogos , embuchamento do eixo \"s\" 2 unidades, faixa refletiva lateral 34 und, faixa ou para-choque 2 und.'),
(72, '13 ', 'odometerValue: 310658 | maintenanceStartDate: 2024-06-05 | maintenanceStartTime: 09:10 | maintenanceEndDate: 2024-06-05 | maintenanceFinishTime: 12:10 | id: 13 | radio-maintenance: preventiva | motorCheckbox: motorCheckbox | preventivaPreditivaCheckbox: Preventiva ou Preditiva | causaPreventivaPreditivaCheckbox: causaPreventivaPreditivaCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão preventiva de troca de óleo e filtros do motor,trocado óleo da caixa de câmbio  | mantenedores: Heber costa aguiar  | materiaisUtilizados: 38 litros de óleo 15w/40\r\n13 litros de óleo sintético 75w/80\r\n1 filtro de ar \r\n1 filtro da cabine\r\n1 filtro rotativo\r\n1 filtro do óleo do motor\r\n2 filtro de combustível \r\n1 filtro do racol'),
(74, '22', 'odometerValue: 104731 | maintenanceStartDate: 2024-06-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-06-14 | maintenanceFinishTime: 12:00 | id: 22 | radio-maintenance: corretiva | freiosCheckbox: freiosCheckbox | semFreioCheckbox: Sem freio | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: 2 jogos de lona de freio - Quantidade 2 jogos | mantenedores: Héber Consta Aguiar  | materiaisUtilizados: 2 jogos de lona de freio 2 jogos'),
(75, '9 ', 'odometerValue: 106900 | maintenanceStartDate: 2024-06-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-06-13 | maintenanceFinishTime: 12:00 | id: 9 | radio-maintenance: preditiva | semFreioCheckbox: Sem freio | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Remoção e instalação das lonas de freio trazeiro.  | mantenedores: Héber Costa Aguiar  | materiaisUtilizados: Lona de Freio - 2 Jogos'),
(76, '22', 'odometerValue: 104731 | maintenanceStartDate: 2024-06-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-06-13 | maintenanceFinishTime: 12:00 | id: 22 | radio-maintenance: preditiva | semFreioCheckbox: Sem freio | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Remoção e instalação ads lonas de freio trazeiro  | mantenedores: Héber Costa Aguiar  | materiaisUtilizados: Lona de Freio - 2 jogos'),
(77, '14', 'odometerValue: 279966 | maintenanceStartDate: 2024-06-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-07-14 | maintenanceFinishTime: 12:00 | id: 14 | radio-maintenance: preventiva | arrefecimentoCheckbox: arrefecimentoCheckbox | preventivaPreditivaCheckbox: Preventiva ou Preditiva | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Remoção e instalação da bomba d’água  | mantenedores: Heber costa aguiar  | materiaisUtilizados: 1 bomba d’água do motor'),
(79, '11', 'odometerValue:  | maintenanceStartDate: 2023-01-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-03 | maintenanceFinishTime: 18:00 | id: 11 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoSoldadoCheckbox: intervencaoSoldadoCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Confecção da rampa do cavalo | mantenedores: Franck | materia1: Barra chata 0.09 x 1.20 x 3/8 | quantidade1: 4 | valor1: 0 | materia2: massarico  | quantidade2: 1 | valor2: 0 | materia3: solda | quantidade3: 1 | valor3: 0 | materia4: lata de spray preto  | quantidade4: 1 | valor4: 0 | materia5:  | quantidade5:  | valor5:'),
(80, '15', 'odometerValue:  | maintenanceStartDate: 2023-01-09 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-09 | maintenanceFinishTime: 14:00 | id: 15 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | freiosCheckbox: freiosCheckbox | semFreioCheckbox: Sem freio | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoInstaladoCheckbox: intervencaoInstaladoCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | observacoes: Troca do retentor do cubo de roda; troca da aranha trava. | mantenedores: Héber Costa Aguiar.  | materia1: Oficina  | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(81, '20 ', 'odometerValue:  | maintenanceStartDate: 2024-01-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-01-13 | maintenanceFinishTime: 18:00 | id: 20 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | intervencaoPinturaCheckbox: intervencaoPinturaCheckbox | observacoes: Pintura em textura de piso antiderrapante. | mantenedores: Emerson  | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(82, '19', 'odometerValue:  | maintenanceStartDate: 2024-01-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-01-13 | maintenanceFinishTime: 18:00 | id: 19 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | intervencaoPinturaCheckbox: intervencaoPinturaCheckbox | observacoes: Pintura em textura de piso antiderrapante. | mantenedores: Emerson  | materia1: Mão de obra  | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(83, '19 ', 'odometerValue:  | maintenanceStartDate: 2022-12-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2022-12-14 | maintenanceFinishTime: 18:00 | id: 19 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldadoCheckbox: intervencaoSoldadoCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Troca de pino-rei, colocado espelho da roda. | mantenedores: Héber | materia1: Material geral  | quantidade1: 1 | valor1: 125 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(84, '19 ', 'odometerValue:  | maintenanceStartDate: 2022-12-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2022-12-14 | maintenanceFinishTime: 18:00 | id: 19 | radio-maintenance: preventiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Troca de 2 pneus.  | mantenedores: Héber | materia1: Material geral  | quantidade1: 1 | valor1: 125 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(85, '19', 'odometerValue:  | maintenanceStartDate: 2022-12-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2022-12-14 | maintenanceFinishTime: 18:00 | id: 19 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | estruturalCheckbox: estruturalCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: reparo de chassis ou alteração.\r\nFeito antiderrapante, colocada faixa lateral e faixa do parachoque. | mantenedores: Héber  | materia1: Material Geral  | quantidade1: 1 | valor1: 125 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(86, '19', 'odometerValue:  | maintenanceStartDate: 2022-12-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2022-12-14 | maintenanceFinishTime: 18:00 | id: 19 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: freio e acessórios.\r\nRegulagem de freio e colocação de mangueira de descida. | mantenedores: Héber  | materia1: Material Geral  | quantidade1: 1 | valor1: 125 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(88, '19', 'odometerValue:  | maintenanceStartDate: 2022-12-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2022-12-14 | maintenanceFinishTime: 18:00 | id: 19 | radio-maintenance: preventiva | suspensaoCheckbox: suspensaoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Substituição de 1 balança, 1 pino de balança, 3 molas-mestras, 6 buchas do tirante | mantenedores: Héber | materia1: Mão de obra  | quantidade1: 1 | valor1: 400 | materia2: balança  | quantidade2: 1 | valor2: 0 | materia3: 1 pino de balança  | quantidade3: 1 | valor3: 0 | materia4: mola-mestra | quantidade4: 3 | valor4: 0 | materia5: bucha do tirante | quantidade5: 6 | valor5: 0'),
(89, '19 ', 'odometerValue:  | maintenanceStartDate: 2023-01-04 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-04 | maintenanceFinishTime: 18:00 | id: 19 | radio-maintenance: preditiva | freiosCheckbox: freiosCheckbox | semFreioCheckbox: Sem freio | causaGastoCheckbox: causaGastoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Substituição de 1 rolamento do cubo de roda, revisão do cubo de roda do último eixo. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 400 | materia2: rolamento do cubo | quantidade2: 1 | valor2: 0 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(90, '23 ', 'odometerValue: 0 | maintenanceStartDate: 2023-01-09 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-11 | maintenanceFinishTime: 18:00 | id: 23 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | acoplamentoCheckbox: acoplamentoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Construção da rampa | mantenedores: Frank | materia1: Valor Material  | quantidade1: 1 | valor1: 1100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(91, '11', 'odometerValue:  | maintenanceStartDate: 2023-01-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-12 | maintenanceFinishTime: 18:00 | id: 11 | radio-maintenance: preventiva | suspensaoCheckbox: suspensaoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | observacoes: suspensão e acessórios. | mantenedores: Hérber Costa Aguiar  | materia1: Material total  | quantidade1: 1 | valor1: 2300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(92, '24', 'odometerValue:  | maintenanceStartDate: 2024-01-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-01-23 | maintenanceFinishTime: 18:00 | id: 24 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Substituição do motor de partida. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2: material  | quantidade2: 1 | valor2: 480 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(93, '25', 'odometerValue:  | maintenanceStartDate: 2023-01-27 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-27 | maintenanceFinishTime: 18:00 | id: 25 | radio-maintenance: corretiva | motorCheckbox: motorCheckbox | empenadoCheckbox: Empenado | causaNaoIdentificadaCheckbox: causaNaoIdentificadaCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Motor caixa e diferencial.	\r\nExtração de 2 parafusos do bloco do motor. | mantenedores: Frank  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(95, '26', 'odometerValue:  | maintenanceStartDate: 2023-01-24 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-24 | maintenanceFinishTime: 18:00 | id: 26 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | causaNaoIdentificadaCheckbox: causaNaoIdentificadaCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca da válvula da portinhola. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(96, '14', 'odometerValue:  | maintenanceStartDate: 2023-01-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-23 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | causaNaoIdentificadaCheckbox: causaNaoIdentificadaCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Substituição de 10 perno de roda completos. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(97, '25', 'odometerValue:  | maintenanceStartDate: 2023-02-08 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-08 | maintenanceFinishTime: 18:00 | id: 25 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes:  | mantenedores:  | materia1: Mão de obra | quantidade1: 1 | valor1: 700 | materia2: Valor material | quantidade2: 1 | valor2: 160 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(98, '17', 'odometerValue:  | maintenanceStartDate: 2023-02-07 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-07 | maintenanceFinishTime: 18:00 | id: 17 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Reparo de chassis ou alteração.\r\nServiço de desempeno da barra do estirante do cavalo mecânico. | mantenedores: Franck  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(99, '17', 'odometerValue:  | maintenanceStartDate: 2023-01-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-02 | maintenanceFinishTime: 18:00 | id: 17 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Reparo de chassis ou alteração.\r\nServiço de desempeno da barra do estirante do cavalo mecânico. | mantenedores: Franck  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(100, '9', 'odometerValue:  | maintenanceStartDate: 2023-01-03 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-03 | maintenanceFinishTime: 18:00 | id: 9 | radio-maintenance: preventiva | outroCheckbox: outroCheckbox | observacoes: Troca de placas sinalizadoras. | mantenedores: Frank  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(101, '9', 'odometerValue:  | maintenanceStartDate: 2023-02-09 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-09 | maintenanceFinishTime: 18:00 | id: 9 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | observacoes: Válvula de fundo e portinhola.\r\nTroca das bocas de 3 polegadas da bomba auxiliar. | mantenedores: Frank  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(102, '9', 'odometerValue:  | maintenanceStartDate: 2023-01-03 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-01-03 | maintenanceFinishTime: 18:00 | id: 9 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Moção da quinta roda dois furos para frente. | mantenedores: Héber   | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(103, '14', 'odometerValue:  | maintenanceStartDate: 2023-02-10 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-10 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de faróis e lanternas, instalação de faróis de milha em curto, 04 lâmpadas led, 03 lâmpadas 67-24V, 02 lâmpadas H3.24V, 01 lâmpada, 1141-24V. | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2: Valor material | quantidade2: 1 | valor2: 1442 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(104, '17', 'odometerValue:  | maintenanceStartDate: 2023-02-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-13 | maintenanceFinishTime: 18:00 | id: 17 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Substituição de 5 roda, troca de 3 tambores de freio, recondicionamento do tirante da suspensão,  troca de lona, troca de óleo, troca de filtro de ar, troca do filtro de diesel, troca de filtro de óleo do motor, troca de filtro da válvula secadora. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 1250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(105, '14', 'odometerValue:  | maintenanceStartDate: 2023-02-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-13 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | semFreioCheckbox: Sem freio | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de patins de freio completo, troca do eixo S, retirado vazamento de óleo. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(106, '15', 'odometerValue:  | maintenanceStartDate: 2023-02-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-17 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: corretiva | motorCheckbox: motorCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca do cabeçote do filtro completo. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(107, '15', 'odometerValue:  | maintenanceStartDate: 2023-02-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-17 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de faróis e lanternas. | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(108, '21', 'odometerValue:  | maintenanceStartDate: 2023-02-27 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-27 | maintenanceFinishTime: 18:00 | id: 21 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | suspensaoCheckbox: suspensaoCheckbox | rompidoCheckbox: Rompido | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Solda do suporte da balança e complemento de rampa da quinta roda. | mantenedores:  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(109, '15', 'odometerValue:  | maintenanceStartDate: 2023-02-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-17 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | outroCheckbox: outroCheckbox | freiosCheckbox: freiosCheckbox | semFreioCheckbox: Sem freio | empenadoCheckbox: Empenado | rompidoCheckbox: Rompido | trincadoCheckbox: Trincado | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de 02 rolamentos do cubo, troca de 01 retentor do cubo, troca de 01 aranha trava, completado 08 litros de óleo do motor | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 400 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(110, '15', 'odometerValue:  | maintenanceStartDate: 2023-02-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-28 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: corretiva | motorCheckbox: motorCheckbox | outroCheckbox: outroCheckbox | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Retirada a cuica, troca de 02 filtros de óleo diesel. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(112, '15', 'odometerValue: 0 | maintenanceStartDate: 2023-02-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-28 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | queimadoCheckbox: Queimado | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de lâmpadas do farol, usadas 02 lâmpadas h724v | mantenedores: Eládio. | materia1: Mão de obra | quantidade1: 1 | valor1: 50 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(113, '14', 'odometerValue:  | maintenanceStartDate: 2023-02-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-28 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Revisão de instalação, troca e confecção do chicote, 02 tomadas macho, 01 chicote sanfonado. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(114, '14', 'odometerValue:  | maintenanceStartDate: 2023-03-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-15 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes: Serviço de instalação.  | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 50 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(115, '9', 'odometerValue:  | maintenanceStartDate: 2023-03-09 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-09 | maintenanceFinishTime: 18:00 | id: 9 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Instalação de 1 farol de kilha e 1 sirene de ré. | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(116, '13', 'odometerValue:  | maintenanceStartDate: 2023-03-09 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-09 | maintenanceFinishTime: 18:00 | id: 13 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão, 03 lâmpadas 67-24V, 01 lâmpada H7-24V. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(117, '16', 'odometerValue:  | maintenanceStartDate: 2023-03-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-15 | maintenanceFinishTime: 18:00 | id: 16 | radio-maintenance: preventiva | motorCheckbox: motorCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca do óleo do motor, troca de filtro do óleo do motor, troca do filtro de diesel, troca do refil do filtro diesel, troca do filtro de ar. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(118, '20', 'odometerValue:  | maintenanceStartDate: 2023-03-29 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-29 | maintenanceFinishTime: 18:00 | id: 20 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Confecção de um protetor de ciclista e tampa do maleiro. | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(119, '20', 'odometerValue:  | maintenanceStartDate: 2023-03-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-23 | maintenanceFinishTime: 18:00 | id: 20 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Reposição de lanternas traseiras | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 250 | materia2: material | quantidade2: 1 | valor2: 460 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(120, '25', 'odometerValue:  | maintenanceStartDate: 2023-03-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-28 | maintenanceFinishTime: 18:00 | id: 25 | radio-maintenance: preventiva | outroCheckbox: outroCheckbox | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de instalação e de lanternas. | mantenedores: Eládio | materia1: Material geral | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(122, '15', 'odometerValue:  | maintenanceStartDate: 2023-03-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-28 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | queimadoCheckbox: Queimado | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Instalação de sirene de ré e faróis de milha. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(123, '13', 'odometerValue:  | maintenanceStartDate: 2023-03-27 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-27 | maintenanceFinishTime: 18:00 | id: 13 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Instalação de sirene de ré. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 50 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(124, '17', 'odometerValue:  | maintenanceStartDate: 2023-03-27 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-27 | maintenanceFinishTime: 18:00 | id: 17 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de faróis de milha e bomba d\'água do interclima | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(125, '11', 'odometerValue:  | maintenanceStartDate: 2023-03-24 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-24 | maintenanceFinishTime: 18:00 | id: 11 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão de instalação geral | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 400 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(126, '15', 'odometerValue:  | maintenanceStartDate: 2023-02-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-02-17 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | observacoes: Revisão corretiva. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 400 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(127, '21', 'odometerValue:  | maintenanceStartDate: 2023-03-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-02 | maintenanceFinishTime: 18:00 | id: 21 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | observacoes: Revisão corrretiva.  | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(128, '15', 'odometerValue:  | maintenanceStartDate: 2023-03-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-23 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | observacoes: Revisão corretiva.  | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 700 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(129, '27', 'odometerValue:  | maintenanceStartDate: 2023-04-05 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-05 | maintenanceFinishTime: 18:00 | id: 27 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes: Revisão de instalação. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(130, '28 ', 'odometerValue:  | maintenanceStartDate: 2023-04-05 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-05 | maintenanceFinishTime: 18:00 | id: 28 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes: Revisão de instalação  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(131, '18', 'odometerValue:  | maintenanceStartDate: 2023-01-05 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-15 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Troca de: 1 pino completo, 24 tampas de proteção de ciclista, regulagem de freios, pintura antiderrapante, faixa do parachoque, lubrificação.  | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(132, '17', 'odometerValue:  | maintenanceStartDate: 2023-05-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-15 | maintenanceFinishTime: 18:00 | id: 17 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de: 2 jogos de lona, 2 amortecedores da cabine dianteira, 2 amortecedores transversais, revisada válvula niveladora, lubrificação. | mantenedores:  | materia1: Mão de obra | quantidade1: 1 | valor1: 1500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(133, '18', 'odometerValue:  | maintenanceStartDate: 2023-05-05 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-15 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | preventivaPreditivaCheckbox: Preventiva ou Preditiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de: 1 pino completo, 24 tampas de proteção de ciclista, regulagem de freios, pintura antiderrapante, faixa do parachoque, lubrificação.  | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(134, '11 ', 'odometerValue:  | maintenanceStartDate: 2023-03-24 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-03-24 | maintenanceFinishTime: 18:00 | id: 11 | radio-maintenance: corretiva | combustivelCheckbox: combustivelCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de: óleo do motor, todos os filtros, filtro da válvula PV, verificado óleo da caixa e diferencial. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(135, '16', 'odometerValue:  | maintenanceStartDate: 2023-04-27 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-27 | maintenanceFinishTime: 18:00 | id: 16 | radio-maintenance: corretiva | eletricoCheckbox: eletricoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de: luva da tomada de força. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(136, '18', 'odometerValue:  | maintenanceStartDate: 2023-05-05 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-05 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes: Revisão de instalação e lanternas, troca de: 1 tomada redonda, 1 lanterna lateral. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(137, '17', 'odometerValue:  | maintenanceStartDate: 2023-05-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-02 | maintenanceFinishTime: 18:00 | id: 17 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de faróis e lanternas: 03 lâmpadas 67 24v, 02 lâmpadas 1034 24v | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 50 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(138, '16', 'odometerValue: 234731 | maintenanceStartDate: 2023-05-19 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-19 | maintenanceFinishTime: 18:00 | id: 16 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de faróis e troca de 02 faróis de milha led | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(139, '15 ', 'odometerValue: 321641 | maintenanceStartDate: 2023-05-19 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-19 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | preventivaPreditivaCheckbox: Preventiva ou Preditiva | observacoes: Revisão de cabos de bateria e troca de posição de baterias e reposição de solução de bateria | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 50 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(140, '13', 'odometerValue: 278584 | maintenanceStartDate: 2023-05-19 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-19 | maintenanceFinishTime: 18:00 | id: 13 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca da sirene de ré e revisão no painel de instrumentos  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 50 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(141, '16', 'odometerValue:  | maintenanceStartDate: 2023-05-16 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-16 | maintenanceFinishTime: 18:00 | id: 16 | radio-maintenance: corretiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca da válvula  APU | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(142, '14', 'odometerValue:  | maintenanceStartDate: 2023-05-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-17 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: corretiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca de 01 paralamas dianteiro, 01 lameira traseira  | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(143, '15', 'odometerValue:  | maintenanceStartDate: 2023-02-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-08-28 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: corretiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Retirada a cuíca, trocados 02 filtros refil do óleo diesel | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(144, '15', 'odometerValue:  | maintenanceStartDate: 2023-05-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-17 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: corretiva | motorCheckbox: motorCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca do cabeçote com filtro completo | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(145, '29', 'odometerValue:  | maintenanceStartDate: 2023-08-02 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-08-04 | maintenanceFinishTime: 14:00 | id: 29 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: troca de pastilhas, dianteiras e traseiras, troca de 02 discos dianteiros, troca do filtro racool. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 800 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:');
INSERT INTO `veiculo_os` (`id`, `id_ativo`, `dados`) VALUES
(146, '13', 'odometerValue:  | maintenanceStartDate: 2023-06-09 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-09 | maintenanceFinishTime: 18:00 | id: 13 | radio-maintenance: preventiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Troca de: óleo do motor; filtro de ar; filtro de diesel; filtro racool; filtro de óleo do motor; filtro da válvula secadora, verificado óleo da caixa e do diferencial. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(147, '14', 'odometerValue:  | maintenanceStartDate: 2023-04-11 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-11 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: preventiva | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Troca de: óleo do motor; filtro de ar; filtro refil de diesel; filtro do motor refil; filtro da secadora; filtro do arla.  | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(148, '11', 'odometerValue:  | maintenanceStartDate: 2023-06-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-15 | maintenanceFinishTime: 18:00 | id: 11 | radio-maintenance: corretiva | outroCheckbox: outroCheckbox | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão e instalação  da válvula de freio de estacionamento. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(149, '25', 'odometerValue:  | maintenanceStartDate: 2023-07-10 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-10 | maintenanceFinishTime: 18:00 | id: 25 | radio-maintenance: corretiva | motorCheckbox: motorCheckbox | outroCheckbox: outroCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Troca do intercambiador, óleo do motor e filtro lubrificante. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 500 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(150, '19', 'odometerValue:  | maintenanceStartDate: 2023-06-28 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-28 | maintenanceFinishTime: 18:00 | id: 19 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | outroCheckbox: outroCheckbox | freiosCheckbox: freiosCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Regulagem de freio, solda no suporte da balança,  troca de lona do eixo do suspensor. | mantenedores: Héber  | materia1: Mão de obra | quantidade1: 1 | valor1: 600 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(151, '9', 'odometerValue:  | maintenanceStartDate: 2023-06-20 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-20 | maintenanceFinishTime: 18:00 | id: 9 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Instalação de buzina original  | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(152, '14', 'odometerValue:  | maintenanceStartDate: 2023-07-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-12 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Instalação de sirene de ré  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 50 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(153, '16', 'odometerValue:  | maintenanceStartDate: 2023-07-12 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-12 | maintenanceFinishTime: 18:00 | id: 16 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão de faróis e lanternas, instalação de sirene de ré. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(154, '17', 'odometerValue:  | maintenanceStartDate: 2023-06-20 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-20 | maintenanceFinishTime: 18:00 | id: 17 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão de faróis e lanternas  | mantenedores: Eládio | materia1: Valor Material | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(155, '21', 'odometerValue:  | maintenanceStartDate: 2023-07-18 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-18 | maintenanceFinishTime: 18:00 | id: 21 | radio-maintenance: corretiva | estruturalCheckbox: estruturalCheckbox | tanqueCheckbox: tanqueCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | observacoes: Servico de solda no tanque | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(156, '20', 'odometerValue:  | maintenanceStartDate: 2023-07-10 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-10 | maintenanceFinishTime: 18:00 | id: 20 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | observacoes: Solda no suporte do extintor e dos cones | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(157, '27', 'odometerValue:  | maintenanceStartDate: 2023-04-03 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-14 | maintenanceFinishTime: 18:00 | id: 27 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | suspensaoCheckbox: suspensaoCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão preventiva.\r\nTrocados: 16 Rolamento, 06 Retentores da Roda, 02 Faixas do Para Choque, 02 Jogos de Lona, 03 Para-lamas, 03 Pino Rei e Freio Regulado. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(158, '28', 'odometerValue:  | maintenanceStartDate: 2023-04-03 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-04-03 | maintenanceFinishTime: 18:00 | id: 28 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | intervencaoMecanicaCheckbox: intervencaoMecanicaCheckbox | observacoes: Trocados: 16 Rolamento, 06 Retentores da Roda, 02 Faixas do Para Choque, 02 Jogos de Lona, 03 Para-lamas, 03 Pino Rei e Freio Regulado. | mantenedores: Héber | materia1: Mão de obra | quantidade1: 1 | valor1: 1000 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(159, '9 ', 'odometerValue:  | maintenanceStartDate: 2023-06-19 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-19 | maintenanceFinishTime: 18:00 | id: 9 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Foi Fabricado A Rampa Do Cavalo Mecânico do modelo daf   | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(160, '18', 'odometerValue:  | maintenanceStartDate: 2023-06-20 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-06-30 | maintenanceFinishTime: 18:00 | id: 18 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | observacoes: Serviço de colocação de um cabo de aço para servir como guia para o sinto de segurança  | mantenedores: Frank | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(161, '19', 'odometerValue:  | maintenanceStartDate: 2023-06-30 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-01 | maintenanceFinishTime: 18:00 | id: 19 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Serviço de colocação de um cabo de aço para servir como suporte e guia do sinto de segurança  | mantenedores:  | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(162, '20', 'odometerValue:  | maintenanceStartDate: 2023-06-30 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-01 | maintenanceFinishTime: 18:00 | id: 20 | radio-maintenance: preventiva | freiosCheckbox: freiosCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: serviço de colocação de um cabo de aço para servir como guia e suporte do sinto de segurança. | mantenedores: Franck | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(163, '20', 'odometerValue:  | maintenanceStartDate: 2023-07-04 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-05 | maintenanceFinishTime: 18:00 | id: 20 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | intervencaoUsinagemCheckbox: intervencaoUsinagemCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: válvula de fundo e portinhola, serviço de confecção da tampa de um malão | mantenedores: Frenck | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(164, '20', 'odometerValue:  | maintenanceStartDate: 2023-07-04 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-07-05 | maintenanceFinishTime: 18:00 | id: 20 | radio-maintenance: preventiva | estruturalCheckbox: estruturalCheckbox | intervencaoFunilariaCheckbox: intervencaoFunilariaCheckbox | intervencaoSoldagemCheckbox: intervencaoSoldagemCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: válvula de fundo e portinhola, Serviço de confecção da tampa de um malão da carreta  | mantenedores: Franck | materia1:  | quantidade1:  | valor1:  | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(165, '11', 'odometerValue:  | maintenanceStartDate: 2023-05-05 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-05-05 | maintenanceFinishTime: 18:00 | id: 11 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão de farol e lanternas do cavalo mecânico. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(166, '30', 'odometerValue:  | maintenanceStartDate: 2023-08-24 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-01 | maintenanceFinishTime: 18:00 | id: 30 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | observacoes: Revisão e instalação de lanternas | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(167, '14', 'odometerValue:  | maintenanceStartDate: 2023-08-15 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-08-18 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão Elétrica no cavalo Mecanico - 01 Lampada H7, 01 Tomada macho | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(168, '19', 'odometerValue:  | maintenanceStartDate: 2023-08-10 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-08-18 | maintenanceFinishTime: 18:00 | id: 19 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão Elétrica - 01 Lanterna Lateral Led - 01 Lanterna Placa led - 02 Lampadas 67.24v | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(169, '31', 'odometerValue:  | maintenanceStartDate: 2023-08-10 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-08-18 | maintenanceFinishTime: 18:00 | id: 31 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoFabricadoCheckbox: intervencaoFabricadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Instalação de faróis de milha - 01 Chave de Luz Tic Tac - 01 Farol de Milha Led  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(170, '22', 'odometerValue:  | maintenanceStartDate: 2023-09-13 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-19 | maintenanceFinishTime: 18:00 | id: 22 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Instalação de Sirene de Ré , Farol de milha, Lanternas foguinho e terra da quinta roda  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2: Valor material | quantidade2: 1 | valor2: 200 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(171, '22', 'odometerValue:  | maintenanceStartDate: 2023-09-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-19 | maintenanceFinishTime: 18:00 | id: 22 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Instalação de sirene de ré, Farol de milha, lanternas foguinho e terra da quinta roda do cavalo mecanico | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2: Valor material | quantidade2: 1 | valor2: 200 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(172, '14', 'odometerValue:  | maintenanceStartDate: 2023-09-06 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-19 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoAjustadoCheckbox: intervencaoAjustadoCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão, recuperação e troca de faróis  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2: material | quantidade2: 1 | valor2: 200 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(173, '32', 'odometerValue:  | maintenanceStartDate: 2023-09-05 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-05 | maintenanceFinishTime: 18:00 | id: 32 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão, Instalação, troca e recuperação de Lanternas | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(174, '14', 'odometerValue:  | maintenanceStartDate: 2023-09-05 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-09-19 | maintenanceFinishTime: 18:00 | id: 14 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Instalação de faróis de milha e lanternas foguinho. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(175, '27', 'odometerValue:  | maintenanceStartDate: 2023-10-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-10-20 | maintenanceFinishTime: 18:00 | id: 27 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão e instalação de lanternas. | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(176, '28', 'odometerValue:  | maintenanceStartDate: 2023-10-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-10-20 | maintenanceFinishTime: 18:00 | id: 28 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão e instalação de lanternas. | mantenedores: Mão de obra  | materia1: Material  | quantidade1: 1 | valor1: 100 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(177, '22', 'odometerValue:  | maintenanceStartDate: 2023-10-18 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-10-20 | maintenanceFinishTime: 18:00 | id: 22 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Instalação de buzina  | mantenedores: Eládio | materia1: Valor Material | quantidade1: 1 | valor1: 1200 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(178, '15', 'odometerValue:  | maintenanceStartDate: 2023-10-17 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-10-20 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | intervencaoRecuperacaoCheckbox: intervencaoRecuperacaoCheckbox | intervencaoSubstituidoCheckbox: intervencaoSubstituidoCheckbox | observacoes: Revisão de faróis e lanternas  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 150 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(179, '31', 'odometerValue:  | maintenanceStartDate: 2023-11-09 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-10 | maintenanceFinishTime: 18:00 | id: 31 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Instalação de buzina marítima ( Com a Buzina )  | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 1200 | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(184, '', 'odometerValue:  | maintenanceStartDate: 2023-11-23 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-24 | maintenanceFinishTime: 18:00 | id: 34 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão geral, instalação e troca de lanternas traseiras e laterais  | mantenedores: Eládio | materia1: mão de obra | quantidade1: 1 | valor1: 250 | materia2: material  | quantidade2: 1 | valor2: 250 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(185, '', 'odometerValue:  | maintenanceStartDate: 2023-11-14 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-23 | maintenanceFinishTime: 18:00 | id: 35 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão, instalação e troca de lanternas lateral e placa | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 300 | materia2: Material | quantidade2: 1 | valor2: 300 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(186, '', 'odometerValue:  | maintenanceStartDate: 2023-11-11 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-15 | maintenanceFinishTime: 18:00 | id: 15 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Troca de baterias e terminais de baterias | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2: Material | quantidade2: 1 | valor2: 100 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(187, '', 'odometerValue:  | maintenanceStartDate: 2023-11-11 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-11-15 | maintenanceFinishTime: 18:00 | id: 21 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: Revisão, instalação e troca de lanternas  | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2: Material | quantidade2: 1 | valor2: 100 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(188, '', 'odometerValue:  | maintenanceStartDate: 2023-12-29 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-01-05 | maintenanceFinishTime: 18:00 | id: 36 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: revisão, instalação e troca de lanternas traseiras, reposição de lampadas e soquetes | mantenedores: Eládio | materia1: Mão de obra | quantidade1: 1 | valor1: 400 | materia2: Material | quantidade2: 1 | valor2: 400 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(189, '', 'odometerValue:  | maintenanceStartDate: 2023-12-29 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-01-05 | maintenanceFinishTime: 18:00 | id: 32 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: revisão, instalação e troca de lanternas traseiras, reposição de lampadas e soquetes | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 400 | materia2: Material | quantidade2: 1 | valor2: 400 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(190, '', 'odometerValue:  | maintenanceStartDate: 2023-12-26 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-01-05 | maintenanceFinishTime: 18:00 | id: 13 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: revisão de faróis e lanternas | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 100 | materia2: Material | quantidade2: 1 | valor2: 100 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(191, '', 'odometerValue:  | maintenanceStartDate: 2023-12-29 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2024-01-05 | maintenanceFinishTime: 18:00 | id: 27 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: revisão, instalação e reposição de lanternas | mantenedores: Eládio  | materia1: Mão de obra | quantidade1: 1 | valor1: 200 | materia2: Material | quantidade2: 1 | valor2: 200 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(192, '', 'odometerValue:  | maintenanceStartDate: 2023-12-21 | maintenanceStartTime: 08:00 | maintenanceEndDate: 2023-12-21 | maintenanceFinishTime: 18:00 | id: 13 | radio-maintenance: preventiva | eletricoCheckbox: eletricoCheckbox | intervencaoEletricaCheckbox: intervencaoEletricaCheckbox | observacoes: troca de baterias e terminais de bateria | mantenedores: Eládio | materia1: mão de obra | quantidade1: 1 | valor1: 50 | materia2: Material | quantidade2: 1 | valor2: 50 | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:'),
(193, '', 'odometerValue: teste | maintenanceStartDate: 2024-08-20 | maintenanceStartTime: 12:00 | maintenanceEndDate: 2024-08-28 | maintenanceFinishTime: 11:00 | id: 9 | radio-maintenance: preventiva | arrefecimentoCheckbox: arrefecimentoCheckbox | observacoes: teste | mantenedores: teste | materia1: teste | quantidade1: 1 | valor1: teste | materia2:  | quantidade2:  | valor2:  | materia3:  | quantidade3:  | valor3:  | materia4:  | quantidade4:  | valor4:  | materia5:  | quantidade5:  | valor5:');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `ativo_embarcacao`
--
ALTER TABLE `ativo_embarcacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ativo_implemento`
--
ALTER TABLE `ativo_implemento`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ativo_tanque`
--
ALTER TABLE `ativo_tanque`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ativo_veiculo`
--
ALTER TABLE `ativo_veiculo`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `embarcacao_os`
--
ALTER TABLE `embarcacao_os`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `implemento_os`
--
ALTER TABLE `implemento_os`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `mtbf_embarcacao`
--
ALTER TABLE `mtbf_embarcacao`
  ADD PRIMARY KEY (`id_ativo`,`data_registro`);

--
-- Índices de tabela `mtbf_implemento`
--
ALTER TABLE `mtbf_implemento`
  ADD PRIMARY KEY (`id_ativo`,`data_registro`);

--
-- Índices de tabela `mtbf_tanque`
--
ALTER TABLE `mtbf_tanque`
  ADD PRIMARY KEY (`id_ativo`,`data_registro`);

--
-- Índices de tabela `mtbf_veiculo`
--
ALTER TABLE `mtbf_veiculo`
  ADD PRIMARY KEY (`id_ativo`,`data_registro`);

--
-- Índices de tabela `mttr_embarcacao`
--
ALTER TABLE `mttr_embarcacao`
  ADD PRIMARY KEY (`id_ativo`,`data_registro`);

--
-- Índices de tabela `mttr_implemento`
--
ALTER TABLE `mttr_implemento`
  ADD PRIMARY KEY (`id_ativo`,`data_registro`);

--
-- Índices de tabela `mttr_tanque`
--
ALTER TABLE `mttr_tanque`
  ADD PRIMARY KEY (`id_ativo`,`data_registro`);

--
-- Índices de tabela `mttr_veiculo`
--
ALTER TABLE `mttr_veiculo`
  ADD PRIMARY KEY (`id_ativo`,`data_registro`);

--
-- Índices de tabela `operador`
--
ALTER TABLE `operador`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tanque_os`
--
ALTER TABLE `tanque_os`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `veiculo_os`
--
ALTER TABLE `veiculo_os`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ativo_embarcacao`
--
ALTER TABLE `ativo_embarcacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de tabela `ativo_implemento`
--
ALTER TABLE `ativo_implemento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `ativo_tanque`
--
ALTER TABLE `ativo_tanque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `ativo_veiculo`
--
ALTER TABLE `ativo_veiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `embarcacao_os`
--
ALTER TABLE `embarcacao_os`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `implemento_os`
--
ALTER TABLE `implemento_os`
  MODIFY `id` int(111) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de tabela `operador`
--
ALTER TABLE `operador`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tanque_os`
--
ALTER TABLE `tanque_os`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `veiculo_os`
--
ALTER TABLE `veiculo_os`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
