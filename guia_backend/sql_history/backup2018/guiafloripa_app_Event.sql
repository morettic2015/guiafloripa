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
-- Table structure for table `Event`
--

DROP TABLE IF EXISTS `Event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Event` (
  `idEvent` int(11) NOT NULL AUTO_INCREMENT,
  `deEvent` varchar(800) NOT NULL,
  `deDetail` varchar(15000) NOT NULL,
  `dtFrom` datetime NOT NULL,
  `dtUntil` datetime NOT NULL,
  `idPlaceOwner` int(11) NOT NULL,
  `nrEdition` varchar(45) DEFAULT NULL,
  `idType` int(11) NOT NULL,
  `deImg` varchar(300) DEFAULT NULL,
  `deRecurring` json DEFAULT NULL,
  `statusKO` enum('ON','OFF') DEFAULT 'ON',
  PRIMARY KEY (`idEvent`),
  KEY `fk_Event_Estabelecimento1_idx` (`idPlaceOwner`),
  KEY `fk_Event_Type1_idx` (`idType`),
  CONSTRAINT `fk_Event_Estabelecimento1` FOREIGN KEY (`idPlaceOwner`) REFERENCES `Place` (`idPlace`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Event_Type1` FOREIGN KEY (`idType`) REFERENCES `Type` (`idType`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=62534 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-04-19 17:11:51
