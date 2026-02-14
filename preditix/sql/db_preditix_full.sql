-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20-Maio-2025 às 20:45
-- Versão do servidor: 9.1.0
-- versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `preditix_v1`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `embarcacoes`
--

DROP TABLE IF EXISTS `embarcacoes`;
CREATE TABLE IF NOT EXISTS `embarcacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` enum('balsa_simples','balsa_motorizada','empurrador') NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `inscricao` varchar(50) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `armador` varchar(100) DEFAULT NULL,
  `ano_fabricacao` int DEFAULT NULL,
  `capacidade_volumetrica` decimal(10,2) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('ativo','inativo','manutencao') DEFAULT 'ativo',
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `embarcacoes`
--

INSERT INTO `embarcacoes` (`id`, `tipo`, `tag`, `inscricao`, `nome`, `armador`, `ano_fabricacao`, `capacidade_volumetrica`, `foto`, `status`, `data_criacao`, `data_atualizacao`) VALUES
(1, 'balsa_simples', 'BD53', 'BR123456', 'Balsa Rio Grande', 'Transportes Fluviais Ltda', 2018, 5000.00, NULL, 'ativo', '2025-04-06 20:28:39', '2025-04-15 12:48:03'),
(4, 'balsa_simples', 'VCL005', 'BR123458', 'Balsa Amazonas', 'Navegação Norte S.A', 2023, 24444.00, NULL, 'ativo', '2025-05-18 13:40:37', '2025-05-18 13:40:37'),
(3, 'empurrador', 'HN27', 'BR123458', 'Empurrador Tietê', 'Hidrovias do Brasil', 2019, 3000.00, NULL, 'ativo', '2025-04-06 20:28:39', '2025-04-15 12:50:19'),
(7, 'balsa_simples', '123123', '34234234234234234234', 'asasdasdas98dya8gtre3678wrtg873rw8937yrwaryhoawryh78w3arw3aryh3w87raytw387ryw387ryw87ryw3r87', 'ewqrqweqwiuyh7y', 2147483647, 99999999.99, NULL, 'ativo', '2025-05-19 22:31:59', '2025-05-19 22:31:59'),
(8, 'balsa_simples', '23423423', '234234234', 'fsdfsdfsf', '4234234', 2025, 3242423.00, NULL, 'ativo', '2025-05-19 23:17:28', '2025-05-19 23:17:28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `implementos`
--

DROP TABLE IF EXISTS `implementos`;
CREATE TABLE IF NOT EXISTS `implementos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` enum('semirreboque_tanque_2_eixos','semirreboque_tanque_3_eixos','semirreboque_tanque_5a_roda_traseira_3_eixos','comboio_abastecimento','bau','outro') NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `placa` varchar(10) DEFAULT NULL,
  `fabricante` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `ano_fabricacao` int DEFAULT NULL,
  `chassi` varchar(50) DEFAULT NULL,
  `renavam` varchar(50) DEFAULT NULL,
  `proprietario` varchar(100) DEFAULT NULL,
  `tara` decimal(10,2) DEFAULT NULL,
  `lotacao` decimal(10,2) DEFAULT NULL,
  `peso_bruto_total` decimal(10,2) DEFAULT NULL,
  `capacidade_maxima_tracao` decimal(10,2) DEFAULT NULL,
  `capacidade_volumetrica` decimal(10,2) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('ativo','inativo','manutencao') DEFAULT 'ativo',
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`),
  UNIQUE KEY `placa` (`placa`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `implementos`
--

INSERT INTO `implementos` (`id`, `tipo`, `tag`, `placa`, `fabricante`, `modelo`, `ano_fabricacao`, `chassi`, `renavam`, `proprietario`, `tara`, `lotacao`, `peso_bruto_total`, `capacidade_maxima_tracao`, `capacidade_volumetrica`, `cor`, `foto`, `status`, `data_criacao`, `data_atualizacao`) VALUES
(4, 'semirreboque_tanque_2_eixos', 'VCL005', 'JKL3456', 'BYD', 'FX-438', 2022, '9BWZZZ377VT004254', '12345678904', 'Transportes ABC Ltda', 2000.00, 12222.00, 122222.00, 12000.00, 5000.00, 'Preto', NULL, 'ativo', '2025-05-18 13:42:14', '2025-05-18 13:42:14'),
(2, 'semirreboque_tanque_3_eixos', 'IMP002', 'DEF5678', 'CIMC', 'Tank', 2022, '9BWZZZ377VT004252', '12345678902', 'Logística XYZ S.A', 10000.00, 25000.00, 35000.00, 50000.00, 40000.00, 'Azul', NULL, 'ativo', '2025-04-06 20:28:39', '2025-04-06 20:28:39'),
(3, 'comboio_abastecimento', 'IMP003', 'GHI9012', 'Fras-le', 'Fuel', 2020, '9BWZZZ377VT004253', '12345678903', 'Combustíveis Brasil Ltda', 12000.00, 30000.00, 42000.00, 60000.00, 50000.00, 'Vermelho', NULL, 'ativo', '2025-04-06 20:28:39', '2025-04-06 20:28:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_ordem_servico`
--

DROP TABLE IF EXISTS `itens_ordem_servico`;
CREATE TABLE IF NOT EXISTS `itens_ordem_servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ordem_servico_id` int NOT NULL,
  `descricao` text NOT NULL,
  `quantidade` decimal(10,2) NOT NULL,
  `unidade` varchar(20) NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ordem_servico_id` (`ordem_servico_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `itens_ordem_servico`
--

INSERT INTO `itens_ordem_servico` (`id`, `ordem_servico_id`, `descricao`, `quantidade`, `unidade`, `valor_unitario`, `data_criacao`, `data_atualizacao`) VALUES
(30, 1, 'Kit de manutenção do motor', 1.00, 'unidade', 1500.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(31, 1, 'Óleo lubrificante', 5.00, 'litros', 50.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(32, 1, 'Mão de obra especializada', 8.00, 'horas', 100.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(33, 4, 'Tinta para casco', 10.00, 'litros', 80.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(34, 4, 'Selante', 3.00, 'unidades', 45.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(35, 4, 'Mão de obra especializada', 16.00, 'horas', 100.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(36, 7, 'Kit de reparo hidráulico', 1.00, 'unidade', 1200.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(37, 7, 'Óleo hidráulico', 4.00, 'litros', 60.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(38, 7, 'Mão de obra especializada', 6.00, 'horas', 100.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(39, 11, 'Kit de válvulas', 1.00, 'unidade', 800.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(40, 11, 'Juntas e vedantes', 5.00, 'unidades', 30.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(41, 11, 'Mão de obra especializada', 7.00, 'horas', 100.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(42, 16, 'Kit de óleo e filtros', 1.00, 'unidade', 200.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(43, 16, 'Óleo lubrificante', 1.00, 'litro', 50.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(44, 16, 'Mão de obra', 3.00, 'horas', 50.00, '2025-05-17 17:13:19', '2025-05-17 17:13:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `manutencoes`
--

DROP TABLE IF EXISTS `manutencoes`;
CREATE TABLE IF NOT EXISTS `manutencoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo_equipamento` enum('embarcacao','implemento','tanque','veiculo') NOT NULL,
  `equipamento_id` int NOT NULL,
  `data_manutencao` date NOT NULL,
  `descricao` text NOT NULL,
  `custo` decimal(10,2) DEFAULT NULL,
  `status` enum('pendente','em_andamento','concluido') DEFAULT 'pendente',
  `usuario_id` int DEFAULT NULL,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `manutencoes`
--

INSERT INTO `manutencoes` (`id`, `tipo_equipamento`, `equipamento_id`, `data_manutencao`, `descricao`, `custo`, `status`, `usuario_id`, `data_criacao`, `data_atualizacao`) VALUES
(1, 'embarcacao', 1, '2024-03-15', 'Manutenção preventiva do motor', 15000.00, 'concluido', 1, '2025-04-06 20:28:39', '2025-04-06 20:28:39'),
(2, 'implemento', 1, '2024-03-20', 'Troca de pneus e revisão do sistema de freios', 8000.00, 'em_andamento', 1, '2025-04-06 20:28:39', '2025-04-06 20:28:39'),
(3, 'tanque', 1, '2024-04-01', 'Limpeza e inspeção de segurança', 5000.00, 'pendente', 1, '2025-04-06 20:28:39', '2025-04-06 20:28:39'),
(4, 'veiculo', 1, '2024-03-25', 'Revisão geral e troca de óleo', 3000.00, 'concluido', 1, '2025-04-06 20:28:39', '2025-04-06 20:28:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ordens_servico`
--

DROP TABLE IF EXISTS `ordens_servico`;
CREATE TABLE IF NOT EXISTS `ordens_servico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_os` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_equipamento` enum('embarcacao','veiculo','implemento','tanque') COLLATE utf8mb4_unicode_ci NOT NULL,
  `equipamento_id` int NOT NULL,
  `data_abertura` datetime NOT NULL,
  `data_prevista` datetime DEFAULT NULL,
  `data_conclusao` datetime DEFAULT NULL,
  `odometro` decimal(10,2) DEFAULT NULL,
  `tipo_manutencao` enum('preventiva','corretiva','preditiva') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sistemas_afetados` json DEFAULT NULL,
  `sintomas_detectados` json DEFAULT NULL,
  `causas_defeitos` json DEFAULT NULL,
  `tipo_intervencao` json DEFAULT NULL,
  `acoes_realizadas` json DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `mantenedores` text COLLATE utf8mb4_unicode_ci,
  `materiais_utilizados` text COLLATE utf8mb4_unicode_ci,
  `status` enum('aberta','em_andamento','concluida','cancelada') COLLATE utf8mb4_unicode_ci DEFAULT 'aberta',
  `prioridade` enum('baixa','media','alta','urgente') COLLATE utf8mb4_unicode_ci DEFAULT 'media',
  `usuario_abertura_id` int NOT NULL,
  `usuario_conclusao_id` int DEFAULT NULL,
  `usuario_responsavel_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_os` (`numero_os`),
  KEY `idx_tipo_equipamento` (`tipo_equipamento`),
  KEY `idx_equipamento_id` (`equipamento_id`),
  KEY `idx_status` (`status`),
  KEY `idx_data_abertura` (`data_abertura`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `ordens_servico`
--

INSERT INTO `ordens_servico` (`id`, `numero_os`, `tipo_equipamento`, `equipamento_id`, `data_abertura`, `data_prevista`, `data_conclusao`, `odometro`, `tipo_manutencao`, `sistemas_afetados`, `sintomas_detectados`, `causas_defeitos`, `tipo_intervencao`, `acoes_realizadas`, `observacoes`, `mantenedores`, `materiais_utilizados`, `status`, `prioridade`, `usuario_abertura_id`, `usuario_conclusao_id`, `usuario_responsavel_id`, `created_at`, `updated_at`) VALUES
(1, 'OS-20250518-0001', 'embarcacao', 4, '2025-05-18 00:00:00', NULL, NULL, NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'aberta', 'baixa', 1, NULL, NULL, '2025-05-18 18:42:54', '2025-05-18 15:42:54'),
(2, 'OS-20250518-0002', 'embarcacao', 4, '2025-05-18 00:00:00', NULL, NULL, NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'aberta', 'baixa', 1, NULL, NULL, '2025-05-18 18:43:56', '2025-05-18 15:43:56'),
(3, 'OS-20250518-0003', 'embarcacao', 4, '2025-05-18 00:00:00', NULL, '2025-05-18 19:55:07', NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'concluida', 'baixa', 1, 1, NULL, '2025-05-18 18:44:54', '2025-05-18 19:55:07'),
(4, 'OS-20250518-0004', 'embarcacao', 4, '2025-05-18 00:00:00', NULL, NULL, NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'aberta', 'baixa', 1, NULL, NULL, '2025-05-18 18:46:27', '2025-05-18 15:46:27'),
(5, 'OS-20250518-0005', 'implemento', 2, '2025-05-18 00:00:00', NULL, NULL, NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'aberta', 'baixa', 1, NULL, NULL, '2025-05-18 18:51:05', '2025-05-18 15:51:05'),
(6, 'OS-20250518-0006', 'implemento', 2, '2025-05-18 00:00:00', NULL, NULL, NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'aberta', 'baixa', 1, NULL, NULL, '2025-05-18 18:53:35', '2025-05-18 15:53:35'),
(7, 'OS-20250518-0007', 'tanque', 2, '2025-05-18 00:00:00', NULL, '2025-05-18 19:54:59', NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'concluida', 'baixa', 1, 1, NULL, '2025-05-18 18:56:32', '2025-05-18 19:54:59'),
(8, '', 'embarcacao', 3, '2025-05-18 00:00:00', NULL, NULL, NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'aberta', 'baixa', 1, NULL, NULL, '2025-05-18 17:21:39', '2025-05-18 17:21:39'),
(10, '2025000001', 'embarcacao', 3, '2025-05-18 00:00:00', NULL, NULL, NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'aberta', 'baixa', 1, NULL, NULL, '2025-05-18 17:26:49', '2025-05-18 17:26:49'),
(11, '2025000002', 'embarcacao', 3, '2025-05-18 00:00:00', NULL, NULL, NULL, 'corretiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'em_andamento', 'baixa', 1, NULL, NULL, '2025-05-18 17:28:59', '2025-05-18 19:55:28'),
(12, '2025000003', 'veiculo', 1, '2025-05-18 00:00:00', NULL, NULL, NULL, 'preventiva', '[\"cabine\", \"protecao_impactos\", \"controle_eletronico\", \"ventilacao\", \"freios\"]', '[\"aberto\", \"sem_freio\", \"sem_velocidade\", \"vibrando\", \"solto\"]', '[\"nao_identificada\", \"gasto\", \"sobrecarga_peso\", \"fadiga\"]', '[\"mecanica\", \"pintura\"]', '[\"acoplado\", \"substituido\", \"reposto\", \"retirado\"]', '', NULL, NULL, 'cancelada', 'baixa', 1, NULL, NULL, '2025-05-18 17:33:14', '2025-05-18 19:55:17'),
(13, '2025000004', 'embarcacao', 7, '2025-05-19 23:25:00', NULL, NULL, NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', 'dsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhasdsadsadasdjhashdiuashdiuashdiuhas', NULL, NULL, 'aberta', 'baixa', 1, NULL, NULL, '2025-05-19 23:25:35', '2025-05-19 23:25:35'),
(14, '2025000005', 'implemento', 2, '2025-05-19 23:32:00', NULL, NULL, NULL, 'preventiva', '[]', '[]', '[]', '[]', '[]', '', NULL, NULL, 'aberta', 'baixa', 1, NULL, NULL, '2025-05-19 23:32:50', '2025-05-19 23:32:50'),
(15, '2025000006', 'embarcacao', 7, '2025-05-19 23:32:00', NULL, NULL, NULL, 'preventiva', '[]', '[\"aberto\"]', '[\"fissura\"]', '[\"funilaria\"]', '[]', '', NULL, NULL, 'aberta', 'baixa', 1, NULL, NULL, '2025-05-19 23:33:09', '2025-05-19 23:33:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ordens_servico_old`
--

DROP TABLE IF EXISTS `ordens_servico_old`;
CREATE TABLE IF NOT EXISTS `ordens_servico_old` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero_os` varchar(20) NOT NULL,
  `tipo_equipamento` enum('embarcacao','implemento','tanque','veiculo') NOT NULL,
  `equipamento_id` int NOT NULL,
  `data_abertura` date NOT NULL,
  `data_prevista` date DEFAULT NULL,
  `data_conclusao` date DEFAULT NULL,
  `descricao_problema` text NOT NULL,
  `descricao_solucao` text,
  `status` enum('aberta','em_andamento','concluida','cancelada') DEFAULT 'aberta',
  `prioridade` enum('baixa','media','alta','urgente') DEFAULT 'media',
  `custo_estimado` decimal(10,2) DEFAULT NULL,
  `custo_final` decimal(10,2) DEFAULT NULL,
  `usuario_abertura_id` int NOT NULL,
  `usuario_responsavel_id` int DEFAULT NULL,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_os` (`numero_os`),
  KEY `usuario_abertura_id` (`usuario_abertura_id`),
  KEY `usuario_responsavel_id` (`usuario_responsavel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `ordens_servico_old`
--

INSERT INTO `ordens_servico_old` (`id`, `numero_os`, `tipo_equipamento`, `equipamento_id`, `data_abertura`, `data_prevista`, `data_conclusao`, `descricao_problema`, `descricao_solucao`, `status`, `prioridade`, `custo_estimado`, `custo_final`, `usuario_abertura_id`, `usuario_responsavel_id`, `data_criacao`, `data_atualizacao`) VALUES
(64, 'OS-2025-003', 'embarcacao', 1, '2025-05-18', '2025-05-19', NULL, 'sdfsdf', NULL, 'aberta', 'baixa', 0.00, NULL, 1, 1, '2025-05-18 12:59:02', '2025-05-18 12:59:02'),
(63, 'OS-2025-002', 'embarcacao', 2, '2025-05-18', '1970-01-01', NULL, 'sadsadas', NULL, 'em_andamento', 'alta', 0.00, NULL, 1, 1, '2025-05-18 12:53:54', '2025-05-18 12:53:54'),
(62, 'OS-2025-001', 'embarcacao', 1, '2025-05-18', '2026-11-18', '2025-05-19', 'asdasdas', '', 'em_andamento', 'baixa', 0.00, 0.00, 1, 1, '2025-05-18 12:53:07', '2025-05-18 14:12:46'),
(37, 'OS-2024-004', 'embarcacao', 2, '2024-01-05', '2024-01-07', '2024-01-07', 'Manutenção do casco', NULL, 'concluida', 'alta', 3500.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(38, 'OS-2024-005', 'embarcacao', 2, '2024-02-15', '2024-02-16', '2024-02-16', 'Reparo no sistema elétrico', NULL, 'concluida', 'alta', 2000.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(39, 'OS-2024-006', 'embarcacao', 2, '2024-03-01', '2024-03-01', '2024-03-01', 'Troca de baterias', NULL, 'concluida', 'media', 1200.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(40, 'OS-2024-007', 'embarcacao', 2, '2024-03-15', '2024-03-18', NULL, 'Manutenção do sistema de propulsão', NULL, 'aberta', 'alta', 2800.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(41, 'OS-2024-008', 'implemento', 1, '2024-01-10', '2024-01-11', '2024-01-11', 'Reparo no sistema hidráulico', NULL, 'concluida', 'alta', 1800.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(42, 'OS-2024-009', 'implemento', 1, '2024-02-05', '2024-02-05', '2024-02-05', 'Troca de pneus', NULL, 'concluida', 'media', 1200.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(43, 'OS-2024-010', 'implemento', 1, '2024-03-12', '2024-03-14', NULL, 'Manutenção preventiva', NULL, 'em_andamento', 'baixa', 900.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(44, 'OS-2024-011', 'implemento', 2, '2024-01-20', '2024-01-22', '2024-01-22', 'Reparo no sistema de elevação', NULL, 'concluida', 'alta', 2200.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(45, 'OS-2024-012', 'implemento', 2, '2024-03-08', '2024-03-10', NULL, 'Manutenção geral', NULL, 'aberta', 'media', 1500.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(46, 'OS-2024-013', 'tanque', 1, '2024-01-08', '2024-01-09', '2024-01-09', 'Limpeza e inspeção', NULL, 'concluida', 'alta', 800.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(47, 'OS-2024-014', 'tanque', 1, '2024-02-10', '2024-02-11', '2024-02-11', 'Reparo no sistema de válvulas', NULL, 'concluida', 'alta', 1500.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(48, 'OS-2024-015', 'tanque', 1, '2024-02-25', '2024-02-25', '2024-02-25', 'Troca de sensores', NULL, 'concluida', 'media', 1200.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(49, 'OS-2024-016', 'tanque', 1, '2024-03-14', '2024-03-16', NULL, 'Manutenção preventiva', NULL, 'em_andamento', 'baixa', 900.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(50, 'OS-2024-017', 'tanque', 2, '2024-01-12', '2024-01-13', '2024-01-13', 'Reparo no sistema de pressão', NULL, 'concluida', 'alta', 2000.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(51, 'OS-2024-018', 'tanque', 2, '2024-02-15', '2024-02-15', '2024-02-15', 'Limpeza interna', NULL, 'concluida', 'media', 600.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(52, 'OS-2024-019', 'tanque', 2, '2024-03-10', '2024-03-12', NULL, 'Manutenção do sistema de segurança', NULL, 'aberta', 'alta', 1800.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(53, 'OS-2024-020', 'veiculo', 1, '2024-01-05', '2024-01-05', '2024-01-05', 'Troca de óleo e filtros', NULL, 'concluida', 'media', 400.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(54, 'OS-2024-021', 'veiculo', 1, '2024-01-20', '2024-01-20', '2024-01-20', 'Alinhamento e balanceamento', NULL, 'concluida', 'media', 300.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(55, 'OS-2024-022', 'veiculo', 1, '2024-02-10', '2024-02-11', '2024-02-11', 'Reparo no sistema de freios', NULL, 'concluida', 'alta', 1200.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(56, 'OS-2024-023', 'veiculo', 1, '2024-02-25', '2024-02-25', '2024-02-25', 'Manutenção preventiva', NULL, 'concluida', 'media', 800.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(57, 'OS-2024-024', 'veiculo', 1, '2024-03-12', '2024-03-14', NULL, 'Reparo no sistema de ar condicionado', NULL, 'em_andamento', 'baixa', 600.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(58, 'OS-2024-025', 'veiculo', 2, '2024-01-15', '2024-01-15', '2024-01-15', 'Troca de pneus', NULL, 'concluida', 'media', 2000.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(59, 'OS-2024-026', 'veiculo', 2, '2024-02-05', '2024-02-06', '2024-02-06', 'Manutenção do motor', NULL, 'concluida', 'alta', 2500.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(60, 'OS-2024-027', 'veiculo', 2, '2024-02-20', '2024-02-21', '2024-02-21', 'Reparo no sistema elétrico', NULL, 'concluida', 'alta', 1500.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19'),
(61, 'OS-2024-028', 'veiculo', 2, '2024-03-08', '2024-03-10', NULL, 'Manutenção preventiva', NULL, 'aberta', 'media', 900.00, NULL, 1, 1, '2025-05-17 17:13:19', '2025-05-17 17:13:19');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tanques`
--

DROP TABLE IF EXISTS `tanques`;
CREATE TABLE IF NOT EXISTS `tanques` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tag` varchar(50) DEFAULT NULL,
  `fabricante_responsavel` varchar(100) DEFAULT NULL,
  `ano_fabricacao` int DEFAULT NULL,
  `localizacao` varchar(255) DEFAULT NULL,
  `capacidade_volumetrica` decimal(10,2) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('ativo','inativo','manutencao') DEFAULT 'ativo',
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tanques`
--

INSERT INTO `tanques` (`id`, `tag`, `fabricante_responsavel`, `ano_fabricacao`, `localizacao`, `capacidade_volumetrica`, `foto`, `status`, `data_criacao`, `data_atualizacao`) VALUES
(2, 'TNK002', 'Metalúrgica ABC Ltda', 2020, 'Terminal de Paranaguá', 150000.00, NULL, 'ativo', '2025-04-06 20:28:39', '2025-04-06 20:28:39'),
(3, 'TNK003', 'Indústria de Tanques XYZ', 2021, 'Terminal de Rio Grande', 200000.00, NULL, 'ativo', '2025-04-06 20:28:39', '2025-04-06 20:28:39'),
(7, 'VCL001', '123123', 123123, '123123', 123123.00, NULL, 'ativo', '2025-05-18 14:01:07', '2025-05-18 14:01:07');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nivel_acesso` enum('gestor','responsavel') DEFAULT 'responsavel',
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `nivel_acesso`, `data_criacao`, `data_atualizacao`) VALUES
(1, 'Administrador', 'admin@preditix.com', '$2a$12$z2GuWOMGQ44dWk0LqaskVO8sQnKc1yIIw7fqD0T8V3ENdf3r7JiZS', 'gestor', '2025-04-06 20:25:54', '2025-04-29 23:40:18');

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculos`
--

DROP TABLE IF EXISTS `veiculos`;
CREATE TABLE IF NOT EXISTS `veiculos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` enum('caminhao_toco','cavalo_mecanico_eixo_simples','cavalo_mecanico_trucado','veiculo_leve_administrativo','veiculo_leve_operacional') NOT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `placa` varchar(10) DEFAULT NULL,
  `fabricante` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `ano_fabricacao` int DEFAULT NULL,
  `chassi` varchar(50) DEFAULT NULL,
  `renavam` varchar(50) DEFAULT NULL,
  `proprietario` varchar(100) DEFAULT NULL,
  `tara` decimal(10,2) DEFAULT NULL,
  `lotacao` decimal(10,2) DEFAULT NULL,
  `peso_bruto_total` decimal(10,2) DEFAULT NULL,
  `peso_bruto_total_combinado` decimal(10,2) DEFAULT NULL,
  `capacidade_maxima_tracao` decimal(10,2) DEFAULT NULL,
  `cor` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('ativo','inativo','manutencao') DEFAULT 'ativo',
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`),
  UNIQUE KEY `placa` (`placa`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `veiculos`
--

INSERT INTO `veiculos` (`id`, `tipo`, `tag`, `placa`, `fabricante`, `modelo`, `ano_fabricacao`, `chassi`, `renavam`, `proprietario`, `tara`, `lotacao`, `peso_bruto_total`, `peso_bruto_total_combinado`, `capacidade_maxima_tracao`, `cor`, `foto`, `status`, `data_criacao`, `data_atualizacao`) VALUES
(1, 'cavalo_mecanico_trucado', 'VCL001', 'JKL3456', 'Volvo', 'FH 540', 2021, '9BWZZZ377VT004254', '12345678904', 'Transportes ABC Ltda', 12000.00, 30000.00, 42000.00, 74000.00, 60000.00, 'Prata', NULL, 'ativo', '2025-04-06 20:28:39', '2025-04-12 17:46:04'),
(2, 'caminhao_toco', 'VCL002', 'MNO7890', 'Mercedes-Benz', 'Actros 2651', 2021, '9BWZZZ377VT004255', '12345678905', 'Logística XYZ S.A', 8000.00, 20000.00, 28000.00, 28000.00, 20000.00, 'Branco', NULL, 'ativo', '2025-04-06 20:28:39', '2025-04-06 20:28:39'),
(3, 'veiculo_leve_administrativo', 'VCL003', 'PQR1234', 'Toyota', 'Hilux', 2023, '9BWZZZ377VT004256', '12345678906', 'Combustíveis Brasil Ltda', 2000.00, 1000.00, 3000.00, 3000.00, 1000.00, 'Preto', NULL, 'ativo', '2025-04-06 20:28:39', '2025-04-06 20:28:39');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
