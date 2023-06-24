CREATE DATABASE  IF NOT EXISTS `pgestao_app` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `pgestao_app`;
-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: pgestao_app
-- ------------------------------------------------------
-- Server version	5.6.38

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `department` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_role_department1_idx` (`department`),
  CONSTRAINT `fk_role_department1` FOREIGN KEY (`department`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (2,'Gestor de TIC','Gerencia setor TIC',2),(3,'Auxiliar de Faturamento','Calcula a movimentação diária do faturamento, encaminhando aos setores competentes, conforme normas e procedimentos da empresa ; auxilia nos controles de documentos (pedidos) que dão entrada para sejam feitos os respectivos faturamento; preenche minutas, c',4),(4,'Encarregado de Recursos Humanos','Está sob as responsabilidades de um Encarregado de Recursos Humanos manter o plano de cargos, salários e carreira da empresa de acordo com as normas da instituição, prestar informações aos funcionários da instituição sobre procedimentos do setor de recurso',6),(5,'Analista Comercial Interno ','Está sob as responsabilidades de um Analista Comercial Interno realizar a atualização de cadastros de clientes, fazer tratamento e arquivamento de documentação, analisar o volume de faturamento, assim como a análise de processos de venda , cotações, propos',7),(6,'Gerente Administrativo','Um Gerente Administrativo atua com a gestão da equipe, respondendo pelos recursos humanos, supervisionando o setor de compras dando assessoria a presidência da empresa, elaborando relatórios gerenciais e conduzir reuniões de recursos materiais e financeiro',5),(7,'Coordenador de Infraestrutura','Administra as rotinas de manutenção, implantação e configuração de infraestrutura de telecomunicações, redes, servidores e internet, acompanha o suporte aos usuários e desenvolve soluções de tecnologia, a fim de manter a alta disponibilidade dos serviços.',3),(8,'Analista Fiscal','Está sob as responsabilidades de um Analista Fiscal executar rotinas contábeis, como atividades de lançamentos, conciliação e demonstrativos, consolidar conversões, caderno anual juntamente ao analista sênior e gerente, analisar e elaborar relatórios com o',4),(9,'Eletricista de Manutenção ','Está sob as responsabilidades de um Eletricista de Manutenção executar manutenção elétrica, preventiva e corretiva, a fim de manter máquinas, equipamentos, motores, painéis, rede elétrica, aparelhos e instalações em perfeitas condições de funcionamento, at',8),(10,'Fresador','Está sob as responsabilidades de um Fresador operar máquina de fresa, documentar suas atividades e manter os formulários, como os de produção e de ocorrência de manutenção das máquinas, sempre atualizados, obter diferentes cortes nos materiais, abrir fenda',8),(11,'Fundidor','Está sob as responsabilidades de um Fundidor atuar com fabricação e fundição de medalhas, atuar com vulcanização e fundição, dar acabamento em peças de metais, fundir peças em moldes em conquilhas, fazer a reparação das peças, fazer a verificação e organiz',8);
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-09 12:22:36
