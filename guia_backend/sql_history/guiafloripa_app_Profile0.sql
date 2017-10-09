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
-- Table structure for table `Profile`
--

DROP TABLE IF EXISTS `Profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Profile` (
  `idProfile` int(11) NOT NULL AUTO_INCREMENT,
  `deName` varchar(200) DEFAULT NULL,
  `deEmail` varchar(200) DEFAULT NULL,
  `deOrigin` enum('FACEBOOK','GOOOGLE','TWITTER','GUIA','ANOTHER') DEFAULT 'GUIA',
  `userID` varchar(300) DEFAULT NULL,
  `pushToken` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idProfile`),
  UNIQUE KEY `deEmail` (`deEmail`),
  UNIQUE KEY `userID_UNIQUE` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Profile`
--

LOCK TABLES `Profile` WRITE;
/*!40000 ALTER TABLE `Profile` DISABLE KEYS */;
INSERT INTO `Profile` VALUES (1,'Luis','malacma@gmail.com','GUIA','93e2fd6a-8ac8-421d-8d0b-a169127f24a9','APA91bHF8JIocD9QqkXdmx9C0T0Is0WAKjBmH1k6kP7KOgY9FNcjrOksR8QQIFNcuruo0rCwK94ZHNeHK66NZX3D5PIZaVaCqYtoNZQP_yBGIt1kHJsV_jHSAjUNTsa4N7f_3Ba3lP5LmJgYd0vcTNyl-zywGotYIA'),(2,'Vilson','vilsonrudineisouza@gmail.com','GUIA','ca71e96f-f628-4f13-ab68-2f9028e30e56','APA91bF4S3xUfofOyCPwHBeeT1rf4cUzA9XIokbQXUsGukWhoegsLDXAfJ0B1-NJc6fFCPmcIxlvJvsYcWro6__BgfviJG2KJfVKwoqtsSciZy9EuyS2zAzwhY8g8iqrXEEON7UGqra6R3I8UkxzpgYd14HV9tdd4Q');
/*!40000 ALTER TABLE `Profile` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-09  3:48:39
