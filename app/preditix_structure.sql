-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: preditix_os
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ordem_servico`
--

DROP TABLE IF EXISTS `ordem_servico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordem_servico` (
  `id_os` int NOT NULL AUTO_INCREMENT,
  `id_ativo` int NOT NULL,
  `tipo_manutencao` enum('preventiva','corretiva','preditiva') COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioridade` enum('baixa','media','alta','critica') COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_abertura` datetime DEFAULT NULL,
  `data_aprovacao` datetime DEFAULT NULL,
  `data_conclusao` datetime DEFAULT NULL,
  `data_cancelamento` datetime DEFAULT NULL,
  `status` enum('aberta','em_andamento','editada','concluida','cancelada','rejeitada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aberta',
  `autorizada` tinyint(1) DEFAULT '0',
  `status_anterior` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acao_rejeitada` enum('abertura','edicao','conclusao','cancelamento') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_gestor` int NOT NULL,
  `id_responsavel` int NOT NULL,
  `sistemas_afetados` json DEFAULT NULL,
  `sintomas_detectados` json DEFAULT NULL,
  `causas_defeitos` json DEFAULT NULL,
  `intervencoes_realizadas` json DEFAULT NULL,
  `acoes_realizadas` json DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_os`),
  KEY `id_ativo` (`id_ativo`),
  KEY `idx_status` (`status`),
  KEY `idx_autorizada` (`autorizada`),
  KEY `idx_gestor` (`id_gestor`),
  KEY `idx_responsavel` (`id_responsavel`),
  KEY `idx_data_abertura` (`data_abertura`),
  KEY `idx_prioridade` (`prioridade`),
  CONSTRAINT `ordem_servico_ibfk_1` FOREIGN KEY (`id_ativo`) REFERENCES `veiculo` (`id_ativo`) ON DELETE RESTRICT,
  CONSTRAINT `ordem_servico_ibfk_2` FOREIGN KEY (`id_gestor`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `ordem_servico_ibfk_3` FOREIGN KEY (`id_responsavel`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `os_backup`
--

DROP TABLE IF EXISTS `os_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `os_backup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_os` int NOT NULL,
  `tipo_manutencao` enum('preventiva','corretiva','preditiva') COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioridade` enum('baixa','media','alta','critica') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sistemas_afetados` json DEFAULT NULL,
  `sintomas_detectados` json DEFAULT NULL,
  `causas_defeitos` json DEFAULT NULL,
  `intervencoes_realizadas` json DEFAULT NULL,
  `acoes_realizadas` json DEFAULT NULL,
  `observacoes` text COLLATE utf8mb4_unicode_ci,
  `data_backup` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_os` (`id_os`),
  KEY `idx_data_backup` (`data_backup`),
  CONSTRAINT `os_backup_ibfk_1` FOREIGN KEY (`id_os`) REFERENCES `ordem_servico` (`id_os`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `os_historico`
--

DROP TABLE IF EXISTS `os_historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `os_historico` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_os` int NOT NULL,
  `usuario_id` int NOT NULL,
  `acao` enum('abertura','edicao','conclusao','cancelamento','aprovacao','rejeicao','tentar_novamente','desistencia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_de` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_para` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `justificativa` text COLLATE utf8mb4_unicode_ci,
  `data_hora` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_os` (`id_os`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_acao` (`acao`),
  KEY `idx_data` (`data_hora`),
  CONSTRAINT `os_historico_ibfk_1` FOREIGN KEY (`id_os`) REFERENCES `ordem_servico` (`id_os`) ON DELETE CASCADE,
  CONSTRAINT `os_historico_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `os_itens`
--

DROP TABLE IF EXISTS `os_itens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `os_itens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_os` int NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  `valor_unitario` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) GENERATED ALWAYS AS ((`quantidade` * `valor_unitario`)) STORED,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_os` (`id_os`),
  CONSTRAINT `os_itens_ibfk_1` FOREIGN KEY (`id_os`) REFERENCES `ordem_servico` (`id_os`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acesso` enum('tecnico','gestor') COLLATE utf8mb4_unicode_ci NOT NULL,
  `ativo` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `veiculo`
--

DROP TABLE IF EXISTS `veiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `veiculo` (
  `id_ativo` int NOT NULL AUTO_INCREMENT,
  `tag` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proprietario` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pbt` int DEFAULT NULL,
  `pbtc` int DEFAULT NULL,
  `cmt` int DEFAULT NULL,
  `tipo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ano_fabricacao` year DEFAULT NULL,
  `tara` int DEFAULT NULL,
  `placa` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chassi` varchar(17) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lotacao` int DEFAULT NULL,
  `cor` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fabricante` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `renavam` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacidade_volumetrica` int DEFAULT NULL,
  `inscricao` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `armador` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `localizacao` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'ativo',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ativo`),
  UNIQUE KEY `unique_tag` (`tag`),
  KEY `idx_placa` (`placa`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-19 20:40:30
