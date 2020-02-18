-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: luismorettoneto.com.br    Database: guiafloripa_app
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
-- Table structure for table `Place`
--

DROP TABLE IF EXISTS `Place`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Place` (
  `idPlace` int(11) NOT NULL AUTO_INCREMENT,
  `nmPlace` varchar(500) NOT NULL,
  `nrPhone` varchar(200) DEFAULT NULL,
  `deWebsite` varchar(200) DEFAULT 'null',
  `deAddress` varchar(400) NOT NULL,
  `deLogo` varchar(300) DEFAULT 'null',
  `dePlace` varchar(4000) DEFAULT NULL,
  `deEmail` varchar(100) DEFAULT NULL,
  `Placecol` varchar(45) DEFAULT NULL,
  `nrLat` float NOT NULL DEFAULT '0',
  `nrLng` float NOT NULL DEFAULT '0',
  `nrCep` varchar(10) NOT NULL,
  `idPlaceBranch` int(11) DEFAULT NULL COMMENT 'Branch',
  PRIMARY KEY (`idPlace`),
  UNIQUE KEY `deEmail_UNIQUE` (`deEmail`),
  KEY `fk_Estabelecimento_Estabelecimento_idx` (`idPlaceBranch`),
  CONSTRAINT `fk_Estabelecimento_Estabelecimento` FOREIGN KEY (`idPlaceBranch`) REFERENCES `Place` (`idPlace`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=62444 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-19 17:12:02
