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
-- Table structure for table `staff_has_skill`
--

DROP TABLE IF EXISTS `staff_has_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_has_skill` (
  `staff` int(11) NOT NULL,
  `skill` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `coach` varchar(64) DEFAULT NULL COMMENT '	',
  `date` date DEFAULT NULL,
  PRIMARY KEY (`staff`,`skill`),
  KEY `fk_employee_has_skill_skill1_idx` (`skill`),
  KEY `fk_employee_has_skill_employee1_idx` (`staff`),
  CONSTRAINT `fk_employee_has_skill_employee1` FOREIGN KEY (`staff`) REFERENCES `staff` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_employee_has_skill_skill1` FOREIGN KEY (`skill`) REFERENCES `skill` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_has_skill`
--

LOCK TABLES `staff_has_skill` WRITE;
/*!40000 ALTER TABLE `staff_has_skill` DISABLE KEYS */;
INSERT INTO `staff_has_skill` VALUES (3,1,1,'','0000-00-00'),(4,2,2,'','0000-00-00'),(4,3,4,'Augusto Woizhalfman','2018-12-11'),(4,4,1,'','0000-00-00'),(4,5,3,'','0000-00-00'),(5,2,3,'','0000-00-00'),(5,3,4,'Martin Luiz Fernandez','2009-03-10'),(5,4,3,'','0000-00-00'),(5,5,3,'','0000-00-00'),(6,2,3,'','0000-00-00'),(6,3,1,'','0000-00-00'),(6,5,2,'','0000-00-00');
/*!40000 ALTER TABLE `staff_has_skill` ENABLE KEYS */;
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
