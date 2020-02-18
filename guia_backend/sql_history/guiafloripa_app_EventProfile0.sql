CREATE DATABASE  IF NOT EXISTS `guiafloripa_app` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `guiafloripa_app`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: luismorettoneto.com.br    Database: guiafloripa_app
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

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
-- Table structure for table `EventProfile`
--

DROP TABLE IF EXISTS `EventProfile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EventProfile` (
  `Event_idEvent` int(11) NOT NULL,
  `Profile_idProfile` int(11) NOT NULL,
  `nrRate` float DEFAULT NULL,
  `deEventType` enum('CHECKIN','LIKE','INVITE','SHARE','PRETEND') DEFAULT NULL,
  PRIMARY KEY (`Event_idEvent`,`Profile_idProfile`),
  KEY `fk_Event_has_Profile_Profile1_idx` (`Profile_idProfile`),
  KEY `fk_Event_has_Profile_Event1_idx` (`Event_idEvent`),
  CONSTRAINT `fk_Event_has_Profile_Event1` FOREIGN KEY (`Event_idEvent`) REFERENCES `Event` (`idEvent`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Event_has_Profile_Profile1` FOREIGN KEY (`Profile_idProfile`) REFERENCES `Profile` (`idProfile`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EventProfile`
--

LOCK TABLES `EventProfile` WRITE;
/*!40000 ALTER TABLE `EventProfile` DISABLE KEYS */;
/*!40000 ALTER TABLE `EventProfile` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-09  3:49:02
