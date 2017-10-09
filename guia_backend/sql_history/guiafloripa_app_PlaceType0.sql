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
-- Table structure for table `PlaceType`
--

DROP TABLE IF EXISTS `PlaceType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PlaceType` (
  `fkIdType` int(11) NOT NULL,
  `fkIdPlace` int(11) NOT NULL,
  `lastUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`fkIdType`,`fkIdPlace`),
  KEY `fk_Type_has_Place_Place1_idx` (`fkIdPlace`),
  KEY `fk_Type_has_Place_Type1_idx` (`fkIdType`),
  CONSTRAINT `fk_Type_has_Place_Place1` FOREIGN KEY (`fkIdPlace`) REFERENCES `Place` (`idPlace`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Type_has_Place_Type1` FOREIGN KEY (`fkIdType`) REFERENCES `Type` (`idType`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PlaceType`
--

LOCK TABLES `PlaceType` WRITE;
/*!40000 ALTER TABLE `PlaceType` DISABLE KEYS */;
INSERT INTO `PlaceType` VALUES (1,8644,'2017-10-08 07:00:32'),(1,10676,'2017-10-08 07:00:31'),(1,10783,'2017-10-08 07:00:30'),(1,11618,'2017-10-01 07:00:27'),(1,11623,'2017-10-08 07:00:29'),(1,11664,'2017-10-08 07:00:28'),(1,11683,'2017-10-08 07:00:27'),(1,12038,'2017-10-08 07:00:27'),(1,12242,'2017-10-08 07:00:26'),(1,12257,'2017-10-08 07:00:25'),(1,12280,'2017-10-08 07:00:24'),(1,13824,'2017-10-08 07:00:23'),(1,13926,'2017-10-08 07:00:22'),(1,14265,'2017-10-08 07:00:22'),(1,14270,'2017-10-08 07:00:21'),(1,14275,'2017-10-08 07:00:20'),(1,14301,'2017-10-08 07:00:19'),(1,14325,'2017-10-08 07:00:19'),(1,14342,'2017-10-08 07:00:18'),(1,14344,'2017-10-08 07:00:17'),(1,14388,'2017-10-08 07:00:16'),(1,18304,'2017-10-08 07:00:16'),(1,18593,'2017-10-08 07:00:15'),(1,19471,'2017-10-08 07:00:14'),(1,19519,'2017-10-08 07:00:13'),(1,19636,'2017-10-08 07:00:12'),(1,21041,'2017-10-08 07:00:11'),(1,27883,'2017-10-08 07:00:10'),(1,35674,'2017-10-08 07:00:10'),(1,36588,'2017-10-08 07:00:09'),(1,36682,'2017-10-08 07:00:08'),(1,38286,'2017-10-08 07:00:08'),(1,48911,'2017-10-08 07:00:06'),(1,49310,'2017-10-08 07:00:05'),(1,52211,'2017-10-07 07:00:06'),(5,8593,'2017-10-08 06:00:36'),(5,9161,'2017-10-08 06:00:35'),(5,10223,'2017-10-08 06:00:35'),(5,10230,'2017-10-08 06:00:35'),(5,10337,'2017-10-08 06:00:34'),(5,10377,'2017-10-08 06:00:34'),(5,10381,'2017-10-08 06:00:33'),(5,10400,'2017-10-08 06:00:33'),(5,10408,'2017-10-08 06:00:32'),(5,10454,'2017-10-08 06:00:31'),(5,10476,'2017-10-08 06:00:31'),(5,10517,'2017-10-07 06:00:33'),(5,10525,'2017-10-08 06:00:30'),(5,10563,'2017-10-08 06:00:29'),(5,10568,'2017-10-08 06:00:29'),(5,10583,'2017-10-08 06:00:28'),(5,10594,'2017-10-08 06:00:27'),(5,14035,'2017-10-08 06:00:27'),(5,14424,'2017-10-08 06:00:27'),(5,15056,'2017-10-08 06:00:25'),(5,15064,'2017-10-07 06:00:26'),(5,15077,'2017-10-08 06:00:24'),(5,15332,'2017-10-08 06:00:24'),(5,16326,'2017-10-08 06:00:22'),(5,16388,'2017-10-08 06:00:22'),(5,16778,'2017-10-02 06:00:22'),(5,17494,'2017-10-08 06:00:20'),(5,17507,'2017-10-08 06:00:19'),(5,17526,'2017-10-08 06:00:18'),(5,17528,'2017-10-08 06:00:18'),(5,17647,'2017-10-08 06:00:17'),(5,18974,'2017-10-08 06:00:15'),(5,28632,'2017-10-08 06:00:14'),(5,29333,'2017-09-19 23:25:31'),(5,31449,'2017-10-08 06:00:14'),(5,31454,'2017-10-08 06:00:14'),(5,32641,'2017-10-08 06:00:13'),(5,32716,'2017-10-08 06:00:12'),(5,32806,'2017-10-08 06:00:11'),(5,32838,'2017-10-08 06:00:11'),(5,40312,'2017-10-08 06:00:09'),(5,41898,'2017-10-08 06:00:09'),(5,43859,'2017-10-08 06:00:08'),(5,43990,'2017-10-08 06:00:07'),(5,46145,'2017-10-08 06:00:07'),(5,48889,'2017-10-08 06:00:05'),(5,49189,'2017-09-25 19:48:46'),(8,8593,'2017-10-08 05:01:22'),(8,8877,'2017-10-08 05:01:22'),(8,8881,'2017-10-08 05:01:21'),(8,8919,'2017-10-08 05:01:19'),(8,8923,'2017-10-08 05:01:19'),(8,8927,'2017-10-08 05:01:18'),(8,8948,'2017-10-08 05:01:17'),(8,8998,'2017-10-08 05:01:16'),(8,9008,'2017-10-08 05:01:16'),(8,9016,'2017-10-08 05:01:15'),(8,9146,'2017-10-08 05:01:15'),(8,9157,'2017-10-08 05:01:14'),(8,9161,'2017-10-08 05:01:13'),(8,9177,'2017-10-08 05:01:12'),(8,9185,'2017-10-08 05:01:12'),(8,9193,'2017-10-08 05:01:11'),(8,9214,'2017-10-08 05:01:11'),(8,9218,'2017-10-08 05:01:10'),(8,9236,'2017-10-08 05:01:09'),(8,9241,'2017-10-08 05:01:09'),(8,9245,'2017-10-08 05:01:08'),(8,9255,'2017-10-08 05:01:07'),(8,9271,'2017-10-08 05:01:06'),(8,9279,'2017-10-08 05:01:05'),(8,9283,'2017-10-08 05:01:05'),(8,9302,'2017-09-19 23:39:12'),(8,9306,'2017-10-08 05:01:04'),(8,9310,'2017-10-08 05:01:03'),(8,9316,'2017-10-08 05:01:03'),(8,9331,'2017-10-08 05:01:02'),(8,9343,'2017-10-08 05:01:02'),(8,9360,'2017-10-08 05:01:01'),(8,9382,'2017-10-08 05:01:00'),(8,9386,'2017-10-08 05:00:59'),(8,9422,'2017-10-08 05:00:59'),(8,9438,'2017-10-08 05:00:58'),(8,9479,'2017-10-08 05:00:57'),(8,9488,'2017-10-08 05:00:57'),(8,9493,'2017-10-08 05:00:56'),(8,9606,'2017-10-08 05:00:55'),(8,9611,'2017-10-08 05:00:55'),(8,9616,'2017-10-08 05:00:54'),(8,9647,'2017-10-08 05:00:53'),(8,9651,'2017-10-08 05:00:52'),(8,9656,'2017-10-08 05:00:52'),(8,9664,'2017-10-08 05:00:51'),(8,9676,'2017-10-08 05:00:50'),(8,9686,'2017-10-08 05:00:49'),(8,9694,'2017-10-08 05:00:49'),(8,9698,'2017-10-08 05:00:48'),(8,9711,'2017-10-08 05:00:47'),(8,9726,'2017-10-08 05:00:46'),(8,9758,'2017-10-08 05:00:45'),(8,9762,'2017-10-08 05:00:45'),(8,9771,'2017-10-08 05:00:44'),(8,9775,'2017-10-08 05:00:43'),(8,9778,'2017-10-08 05:00:43'),(8,9783,'2017-10-08 05:00:42'),(8,9787,'2017-10-08 05:00:41'),(8,9796,'2017-10-08 05:00:41'),(8,9801,'2017-10-08 05:00:40'),(8,9819,'2017-10-08 05:00:39'),(8,9823,'2017-10-08 05:00:38'),(8,9827,'2017-10-08 05:00:37'),(8,9839,'2017-10-08 05:00:37'),(8,9844,'2017-10-08 05:00:36'),(8,9851,'2017-10-08 05:00:35'),(8,9867,'2017-10-08 05:00:35'),(8,9872,'2017-10-08 05:00:34'),(8,9876,'2017-10-08 05:00:33'),(8,9893,'2017-10-08 05:00:33'),(8,9897,'2017-10-08 05:00:32'),(8,11855,'2017-10-08 05:00:32'),(8,13824,'2017-10-08 05:00:31'),(8,13902,'2017-10-08 05:00:30'),(8,13909,'2017-10-08 05:00:29'),(8,13923,'2017-10-08 05:00:29'),(8,13926,'2017-10-08 05:00:28'),(8,13937,'2017-10-08 05:00:27'),(8,13942,'2017-09-19 23:38:31'),(8,13979,'2017-10-08 05:00:26'),(8,13983,'2017-10-08 05:00:26'),(8,13995,'2017-10-08 05:00:25'),(8,14009,'2017-10-08 05:00:25'),(8,14017,'2017-10-01 05:00:24'),(8,14032,'2017-10-08 05:00:23'),(8,14035,'2017-10-08 05:00:22'),(8,14039,'2017-10-08 05:00:22'),(8,17630,'2017-10-08 05:00:21'),(8,17663,'2017-10-08 05:00:20'),(8,17829,'2017-10-08 05:00:19'),(8,17920,'2017-09-19 23:38:22'),(8,18096,'2017-10-08 05:00:18'),(8,18120,'2017-10-08 05:00:18'),(8,18129,'2017-10-08 05:00:17'),(8,18596,'2017-10-08 05:00:16'),(8,18621,'2017-10-08 05:00:16'),(8,18651,'2017-10-08 05:00:15'),(8,20084,'2017-10-08 05:00:14'),(8,24727,'2017-10-08 05:00:14'),(8,26160,'2017-10-08 05:00:13'),(8,26622,'2017-10-08 05:00:12'),(8,28270,'2017-10-08 05:00:11'),(8,29004,'2017-10-08 05:00:10'),(8,29653,'2017-10-08 05:00:09'),(8,34503,'2017-10-08 05:00:09'),(8,36588,'2017-10-08 05:00:08'),(8,36888,'2017-10-08 05:00:07'),(8,38123,'2017-10-08 05:00:07'),(8,48838,'2017-10-08 05:00:05'),(8,49801,'2017-10-08 05:00:04');
/*!40000 ALTER TABLE `PlaceType` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-09  3:48:56
