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
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `company` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_company1_idx` (`company`),
  CONSTRAINT `fk_department_company1` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (2,'TIC','Tecnologia da informação e comunicação',1),(3,'Setor de tecnoclogia da informação e comunica','O departamento de tecnologia da informação e comunicação congrega os segmentos Telecom, Hardwares de informática e Software e Serviços de TI. Responsável por sustentar a parte tecnológica da empresa e planejar os investimento em tecnologia. ',2),(4,'Setor Financeiro','O departamento financeiro é aquele que administra os recursos de uma empresa. Ele faz o controle da tesouraria, dos investimentos e dos riscos, além da gestão de contas e impostos, do planejamento financeiro da companhia e da divulgação de seus resultados',2),(5,'Setor administrativo','O setor administrativo é o coração da empresa. Ele é responsável pelo planejamento estratégico e pela gestão das tarefas, coordenando e fiscalizando os demais setores e fornecendo os dados necessários para a tomada de decisões pelos executivos da companhi',2),(6,'Setor de recursos humanos','O departamento de recursos humanos é o responsável pelo recrutamento do pessoal e pela gestão de pessoas. Ele busca soluções para conflitos, controla os horários de entrada e saída dos trabalhadores, as horas extras e estabelece políticas para a retenção ',2),(7,'Setor comercial','Também chamado de departamento de marketing, o foco do setor comercial é nos clientes externos da empresa. Ele é o responsável pelas vendas, garantindo a geração de receitas para a empresa.',2),(8,'Setor operacional','O departamento operacional, que em alguns casos pode ser chamado de setor de produção ou de setor técnico, é o responsável por administrar todo o processo de transformação dos insumos no produto final.',2);
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
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
