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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) DEFAULT NULL,
  `photo` longblob,
  `status` int(11) DEFAULT NULL COMMENT '0=disabled\n1=okay\n2=need validation\n3=expired',
  `role` varchar(45) DEFAULT NULL,
  `company` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  `changed` datetime DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `mail_UNIQUE` (`email`),
  KEY `fk_user_company1_idx` (`company`),
  CONSTRAINT `fk_user_company1` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'qunY2fg6OlJCNDFKeUZxQlhMdGZGRT0=','iunY2fjTiAG6TaY90HxRbGSYuPc6OlJCNDFKeUZxQlhMdGZGRT0=','3f75509b223bf62b576179ee29493e7fa990d6cd92989277d1dab04d5f25130e',NULL,1,'admin',1,'2019-01-20 14:45:52',NULL,NULL),(2,'ueLRwv/0l0adTKcy2iA6OlJCNDFKeUZxQlhMdGZGRT0=','meLRwv/0lya9TKcy2iAcbSoHu2GQOjpSQjQxSnlGcUJYTHRmRkU9','22cebd283728bad166ea068666c5dbcd96ec9486a9a72b34bd98e2b9f9ba6b8f',NULL,1,'admin',1,'2019-01-20 14:45:52',NULL,NULL),(3,'r+TH0/PmOjpSQjQxSnlGcUJYTHRmRkU9','j+TH0/PmuBa4W6Eo3j0cYHzSfGXLOjpSQjQxSnlGcUJYTHRmRkU9','3f75509b223bf62b576179ee29493e7fa990d6cd92989277d1dab04d5f25130e',NULL,1,'admin',1,'2019-01-20 14:45:52',NULL,NULL),(4,'r+jY3/jgjBS+/XWfHD06OlJCNDFKeUZxQlhMdGZGRT0=','j+jY39bjnwOsSrMzkTFdbg8+nDo6UkI0MUp5RnFCWEx0ZkZFPQ==','3f75509b223bf62b576179ee29493e7fa990d6cd92989277d1dab04d5f25130e',NULL,1,'manager',2,'2019-01-20 14:45:52',NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,STRICT_ALL_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ALLOW_INVALID_DATES,ERROR_FOR_DIVISION_BY_ZERO,TRADITIONAL,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `pgestao_app`.`user_BEFORE_INSERT` BEFORE INSERT ON `user` FOR EACH ROW
BEGIN
	SET NEW.created = now();
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-09 12:22:36
