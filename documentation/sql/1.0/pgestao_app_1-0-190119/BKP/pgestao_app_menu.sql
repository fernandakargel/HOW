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
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL COMMENT 'Unique identity number',
  `name` varchar(128) NOT NULL,
  `label` varchar(45) NOT NULL COMMENT 'Displayed name ',
  `url` varchar(512) DEFAULT '#' COMMENT 'Full electronic address',
  `title` varchar(256) DEFAULT NULL COMMENT 'Title of the link',
  `icon` varchar(45) DEFAULT NULL COMMENT 'Display icon of the Font Awesome Library',
  `parent` int(11) DEFAULT '0' COMMENT 'Parent on the tree',
  `allow` varchar(128) DEFAULT NULL COMMENT 'Roles that has access to the menu, separated by ;',
  `display` tinyint(4) DEFAULT '0' COMMENT 'Show on the menu',
  `order` int(11) DEFAULT NULL COMMENT 'Sequence in the menu',
  `commentary` varchar(512) DEFAULT NULL COMMENT 'Comment about the page',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'menuCadastros','Cadastros',NULL,NULL,NULL,NULL,';user;manager;admin;',1,1000,'Grupo de cadastros do sistema'),(2,'menuRelatorios','Relatórios',NULL,NULL,NULL,NULL,';user;manager;admin;',1,2000,'Grupo de cadastros do sistema'),(3,'menuConfiguracao','Configurações',NULL,NULL,NULL,NULL,';manager;admin;',1,9000,'Grupo de cadastros do sistema'),(4,'home','Página inicial',NULL,NULL,NULL,NULL,';guess;user;manager;admin;',NULL,NULL,'Página inicial do sistema'),(5,'login','Login',NULL,NULL,NULL,NULL,';guess;user;manager;admin;',NULL,NULL,'Ação de login'),(6,'logout','Logout',NULL,NULL,NULL,NULL,';guess;user;manager;admin;',NULL,NULL,'Ação de logout'),(7,'data.import','Importador','/data/import','Importadores de dados','ti-cloud-up',3,';manager;admin;',1,9300,NULL),(8,'company.list','Empresas','/company','Lista de empresas','fa-building-o',3,';admin;',1,9100,NULL),(9,'company.form','Cadastro de empresa','/company/form','Formulário de cadastro de empresa',NULL,NULL,';admin;',NULL,NULL,NULL),(10,'company.save','Salvar empresas','/company/save','Ação para salvar empresas',NULL,NULL,';admin;',NULL,NULL,NULL),(11,'company.update','Atualização de empresas','/company/form/[{id}]','Formulário de atualização de empresas',NULL,NULL,';admin;',NULL,NULL,NULL),(12,'users.list','Usuáros','/user','Lista de usuários','fa-unlock-alt',3,';manager;admin;',1,9200,NULL),(13,'users.form','Cadastro de usuários','/users/form','Formulário de cadastro de usuários',NULL,NULL,';manager;admin;',NULL,NULL,NULL),(14,'users.save','Salvar usuário','/user/save','Ação para salvar usuário',NULL,NULL,';manager;admin;',NULL,NULL,NULL),(15,'users.update','Atualizar usuário','/user/form/[{uid}]','Formulário de atualização de usuários',NULL,NULL,';manager;admin;',NULL,NULL,NULL),(16,'users.profile','Perfil de usuário','/profile/{id}','Formuário de perfil de usuário',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(17,'department.list','Departamentos','/department','Lista de departamentos','fa-sitemap',1,';user;manager;admin;\'',1,1100,NULL),(18,'department.form','Cadastro de departamento','/department/form','Formulário de cadastro de departamento',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(19,'department.save','Salvar departamento','/department/save','Ação para salvar departamento',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(20,'department.update','Atualizar departamento','/department/form/[{id}]','Formulário de atualização de departamento',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(21,'role.list','Cargos','/role','Lista de cargos','ti-id-badge',1,';user;manager;admin;\'',1,1200,NULL),(22,'role.form','Cadastro de cargo','/role/form','Formulário de cadastro de cargo',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(23,'role.save','Salvar cargo','/role/save','Ação para salvar cargo',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(24,'role.update','Atualizar cargo','/role/form/[{id}]','Formulário de atualização de cargo',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(25,'role.bydepartment','Lista de cargos de um departamento','/role/by/department/[{department}]','Webservice que retorna uma lista de cargos por departamento',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(26,'process.list','Procedimentos','/process','Lista de procedimentos','fa-check-square-o',1,';user;manager;admin;',1,1300,NULL),(27,'process.form','Cadastro de procedimento','/process/form','Formulário de cadastro de procedimento',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(28,'process.save','Salvar procedimento','/process/save','Ação para salvar procedimento',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(29,'process.update','Atualizar procedimento','/process/form/[{id}]','Formulário de atualização de procedimento',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(30,'staff.list','Colaboradores','/staff','Lista de colaboradores','fa-users',1,';user;manager;admin;',1,1500,NULL),(31,'staff.form','Cadastro de colaborador','/staff/form','Forulário de cadastro de colaboradores',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(32,'staff.save','Salvar colaborador','/staff/save','Ação para salvar colaboradores',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(33,'staff.update','Atualizar colaborador','/staff/form/[{id}]','Formulário de atualização de colaboradores',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(34,'staff.addskill','Adicionar habilidade','/staff/addskill','Ação para salvar habilidade do colaborador',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(35,'staff.delskill','Remover habilidade','/staff/delskill/[{param}]','Ação para remover habilidade do colaborador',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(36,'staff.status','Atualizar status','/staff/status/[{param}]','Açào para atualizar o status do colaborador',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(37,'skill.list','Habilidades','/skill','Lista de habilidades','fa-suitcase',1,';user;manager;admin;',1,1400,NULL),(38,'skill.form','Cadastro de habilidade','/skill/form','Formulário de cadastro de habilidade',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(39,'skill.save','Salvar habilidade','/skill/save','Ação para salvar habilidade',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(40,'skill.update','Atualizar habilidade','/skill/form/[{id}]','Formulário para atualização de habilidade',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(41,'matrix.list','Matriz','/matrix','Matriz de polivalência e versatilidade','fa-table',2,';user;manager;admin;',1,NULL,NULL),(42,'matrix.print','Matriz para impressão','/matrix/print','Matriz de polivalência e versatilidade para impressão',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-09 12:22:35
