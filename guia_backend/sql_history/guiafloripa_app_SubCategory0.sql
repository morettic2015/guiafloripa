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
-- Table structure for table `SubCategory`
--

DROP TABLE IF EXISTS `SubCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SubCategory` (
  `fkPlace` int(11) NOT NULL,
  `fkType` int(11) NOT NULL,
  `fkEvent` int(11) NOT NULL,
  `catInfo` enum('movie','cat') NOT NULL DEFAULT 'cat',
  `dtStart` datetime DEFAULT NULL,
  `dtEnd` datetime DEFAULT NULL,
  PRIMARY KEY (`fkPlace`,`fkType`,`fkEvent`),
  KEY `pkCate` (`fkPlace`,`fkType`,`fkEvent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Sub category for Events and Cinema MOvie Theaters';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SubCategory`
--

LOCK TABLES `SubCategory` WRITE;
/*!40000 ALTER TABLE `SubCategory` DISABLE KEYS */;
INSERT INTO `SubCategory` VALUES (10660,7,38479,'cat',NULL,NULL),(10660,7,47309,'cat','2017-10-06 22:00:00','2017-10-06 23:30:00'),(10660,7,47782,'cat','2017-10-07 22:00:00','2017-10-07 23:30:00'),(10676,7,47244,'cat','2017-10-09 17:00:00','2017-10-09 23:00:00'),(10676,7,47245,'cat','2017-10-03 17:30:00','2017-10-03 23:30:00'),(10676,7,47820,'cat','2017-10-07 11:30:00','2017-10-07 23:30:00'),(10676,7,48140,'cat','2017-10-05 17:30:00','2017-10-05 23:00:00'),(10676,7,48143,'cat','2017-10-06 17:00:00','2017-10-06 23:00:00'),(10676,7,49384,'cat','2017-10-04 17:30:00','2017-10-04 19:00:00'),(10783,7,35453,'cat','2017-10-03 22:00:00','2017-10-03 23:30:00'),(10783,7,49388,'cat','2017-10-07 22:00:00','2017-10-07 23:30:00'),(10783,7,51405,'cat','2017-10-08 21:00:00','2017-10-08 23:30:00'),(10783,7,52007,'cat',NULL,NULL),(10799,7,52141,'cat',NULL,NULL),(11511,4,46719,'cat',NULL,NULL),(11511,4,47290,'cat','2017-10-07 09:00:00','2017-10-07 17:00:00'),(11511,4,51965,'cat','2017-10-06 19:00:00','2017-10-07 18:00:00'),(12242,7,47914,'cat',NULL,NULL),(12257,7,43241,'cat','2017-10-05 19:00:00','2017-10-05 23:30:00'),(12257,7,45863,'cat','2017-10-09 19:00:00','2017-10-09 23:30:00'),(12257,7,46672,'cat','2017-10-04 19:00:00','2017-10-04 23:30:00'),(12257,7,47824,'cat','2017-10-06 19:00:00','2017-10-06 23:30:00'),(12257,7,47827,'cat','2017-10-08 19:00:00','2017-10-08 23:30:00'),(12257,7,52001,'cat',NULL,NULL),(12257,7,52283,'cat','2017-10-03 19:00:00','2017-10-03 23:30:00'),(12257,7,52287,'cat','2017-10-07 19:00:00','2017-10-07 23:30:00'),(12280,7,47893,'cat','2017-10-03 19:30:00','2017-10-03 23:30:00'),(12280,7,47895,'cat','2017-10-04 19:30:00','2017-10-04 23:30:00'),(12280,7,47897,'cat','2017-10-05 19:30:00','2017-10-05 23:30:00'),(12280,7,47900,'cat','2017-10-06 19:30:00','2017-10-06 23:30:00'),(12280,7,47902,'cat','2017-10-07 19:30:00','2017-10-07 23:30:00'),(12280,7,47905,'cat','2017-10-09 19:00:00','2017-10-09 23:30:00'),(12534,7,52113,'cat',NULL,NULL),(12534,7,52195,'cat',NULL,NULL),(13532,3,2096,'movie','2017-06-02 00:00:00','2017-06-03 00:00:00'),(13532,3,2151,'movie','2017-08-02 00:00:00','2017-08-23 00:00:00'),(13532,3,2152,'movie','2017-08-02 00:00:00','2017-08-29 00:00:00'),(13532,3,2161,'movie','2017-08-16 00:00:00','2017-09-06 00:00:00'),(13532,3,2162,'movie','2017-08-16 00:00:00','2017-08-29 00:00:00'),(13532,3,2163,'movie','2017-08-16 00:00:00','2017-08-29 00:00:00'),(13532,3,2165,'movie','2017-08-15 00:00:00','2017-08-23 00:00:00'),(13532,3,2169,'movie','2017-08-22 00:00:00','2017-09-05 00:00:00'),(13532,3,2179,'movie','2017-08-30 00:00:00','2017-09-13 00:00:00'),(13532,3,2181,'movie','2017-08-31 00:00:00','2017-09-13 00:00:00'),(13532,3,2183,'movie','2017-08-28 00:00:00','2017-10-04 00:00:00'),(13532,3,2185,'movie','2017-08-30 00:00:00','2017-09-13 00:00:00'),(13532,3,2189,'movie','2017-09-06 00:00:00','2017-10-04 00:00:00'),(13532,3,2191,'movie','2017-09-06 00:00:00','2017-10-04 00:00:00'),(13532,3,2193,'movie','2017-09-06 00:00:00','2017-09-20 00:00:00'),(13532,3,2197,'movie','2017-09-06 00:00:00','2017-09-20 00:00:00'),(13532,3,2203,'movie','2017-09-12 00:00:00','2017-10-04 00:00:00'),(13532,3,2205,'movie','2017-09-12 00:00:00','2017-09-20 00:00:00'),(13532,3,2211,'movie','2017-09-12 00:00:00','2017-09-20 00:00:00'),(13532,3,2213,'movie','2017-09-26 00:00:00','2017-10-04 00:00:00'),(13532,3,2215,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(13532,3,2223,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(13532,3,2225,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(13532,3,2227,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(13532,3,2255,'movie','2017-10-04 00:00:00','2017-10-11 00:00:00'),(13532,3,2257,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(13532,3,2261,'movie','2017-10-04 00:00:00','2017-10-11 00:00:00'),(13532,3,2263,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(13533,3,2117,'movie','2017-06-07 00:00:00','2017-07-12 00:00:00'),(13533,3,2136,'movie','2017-07-11 00:00:00','2017-08-09 00:00:00'),(13533,3,2154,'movie','2017-08-08 00:00:00','2017-09-06 00:00:00'),(13533,3,2155,'movie','2017-08-08 00:00:00','2017-08-23 00:00:00'),(13533,3,2157,'movie','2017-08-08 00:00:00','2017-08-30 00:00:00'),(13533,3,2161,'movie','2017-08-15 00:00:00','2017-09-13 00:00:00'),(13533,3,2169,'movie','2017-08-22 00:00:00','2017-09-06 00:00:00'),(13533,3,2171,'movie','2017-08-22 00:00:00','2017-09-20 00:00:00'),(13533,3,2173,'movie','2017-08-22 00:00:00','2017-09-06 00:00:00'),(13533,3,2179,'movie','2017-08-30 00:00:00','2017-09-13 00:00:00'),(13533,3,2181,'movie','2017-08-30 00:00:00','2017-09-20 00:00:00'),(13533,3,2183,'movie','2017-08-30 00:00:00','2017-10-01 00:00:00'),(13533,3,2185,'movie','2017-08-30 00:00:00','2017-09-20 00:00:00'),(13533,3,2189,'movie','2017-09-06 00:00:00','2017-10-12 00:00:00'),(13533,3,2191,'movie','2017-09-06 00:00:00','2017-10-11 00:00:00'),(13533,3,2193,'movie','2017-09-06 00:00:00','2017-10-01 00:00:00'),(13533,3,2195,'movie','2017-09-06 00:00:00','2017-09-20 00:00:00'),(13533,3,2203,'movie','2017-09-12 00:00:00','2017-10-04 00:00:00'),(13533,3,2205,'movie','2017-09-12 00:00:00','2017-09-20 00:00:00'),(13533,3,2207,'movie','2017-09-12 00:00:00','2017-09-20 00:00:00'),(13533,3,2209,'movie','2017-09-12 00:00:00','2017-09-27 00:00:00'),(13533,3,2213,'movie','2017-09-18 00:00:00','2017-10-11 00:00:00'),(13533,3,2215,'movie','2017-09-18 00:00:00','2017-10-04 00:00:00'),(13533,3,2217,'movie','2017-09-18 00:00:00','2017-09-27 00:00:00'),(13533,3,2223,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(13533,3,2225,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(13533,3,2229,'movie','2017-09-26 00:00:00','2017-10-04 00:00:00'),(13533,3,2255,'movie','2017-10-04 00:00:00','2017-10-11 00:00:00'),(13533,3,2257,'movie','2017-10-04 00:00:00','2017-10-11 00:00:00'),(13533,3,2261,'movie','2017-10-04 00:00:00','2017-10-11 00:00:00'),(13533,3,2263,'movie','2017-10-04 00:00:00','2017-10-11 00:00:00'),(13533,3,2267,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(13534,3,2096,'movie','2017-06-02 00:00:00','2017-06-03 00:00:00'),(13534,3,2158,'movie','2017-08-08 00:00:00','2017-09-06 00:00:00'),(13534,3,2161,'movie','2017-08-14 00:00:00','2017-09-17 00:00:00'),(13534,3,2169,'movie','2017-08-22 00:00:00','2017-09-13 00:00:00'),(13534,3,2181,'movie','2017-08-30 00:00:00','2017-09-13 00:00:00'),(13534,3,2183,'movie','2017-08-30 00:00:00','2017-10-04 00:00:00'),(13534,3,2185,'movie','2017-08-30 00:00:00','2017-09-26 00:00:00'),(13534,3,2189,'movie','2017-09-06 00:00:00','2017-10-04 00:00:00'),(13534,3,2191,'movie','2017-09-06 00:00:00','2017-10-11 00:00:00'),(13534,3,2193,'movie','2017-09-07 00:00:00','2017-09-27 00:00:00'),(13534,3,2203,'movie','2017-09-12 00:00:00','2017-10-04 00:00:00'),(13534,3,2205,'movie','2017-09-12 00:00:00','2017-09-20 00:00:00'),(13534,3,2207,'movie','2017-09-12 00:00:00','2017-10-01 00:00:00'),(13534,3,2213,'movie','2017-09-20 00:00:00','2017-10-04 00:00:00'),(13534,3,2215,'movie','2017-09-20 00:00:00','2017-10-11 00:00:00'),(13534,3,2217,'movie','2017-09-20 00:00:00','2017-10-04 00:00:00'),(13534,3,2223,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(13534,3,2225,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(13534,3,2227,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(13534,3,2255,'movie','2017-10-04 00:00:00','2017-10-11 00:00:00'),(13534,3,2257,'movie','2017-10-04 00:00:00','2017-10-11 00:00:00'),(13534,3,2261,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(13534,3,2263,'movie','2017-10-04 00:00:00','2017-10-11 00:00:00'),(13534,3,2273,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(13544,2,52127,'cat','2017-10-12 16:00:00','2017-10-12 18:00:00'),(13544,7,47691,'cat',NULL,NULL),(13544,7,52115,'cat',NULL,NULL),(13544,7,52509,'cat','2017-10-13 21:00:00','2017-10-13 23:00:00'),(13544,7,52513,'cat','2017-10-14 21:00:00','2017-10-14 23:00:00'),(13544,9,52115,'cat',NULL,NULL),(14301,7,47952,'cat','2017-10-04 17:00:00','2017-10-04 23:30:00'),(14325,7,31770,'cat','2017-10-05 20:00:00','2017-10-05 23:30:00'),(14325,7,45777,'cat',NULL,NULL),(14325,7,49386,'cat','2017-10-06 19:00:00','2017-10-06 23:30:00'),(14325,7,49833,'cat','2017-10-07 19:00:00','2017-10-07 23:30:00'),(14325,7,52289,'cat','2017-10-04 19:00:00','2017-10-04 23:30:00'),(14342,7,46484,'cat','2017-10-05 21:00:00','2017-10-05 23:30:00'),(14342,7,46485,'cat','2017-10-06 21:00:00','2017-10-06 23:30:00'),(14342,7,46919,'cat',NULL,NULL),(14342,7,48148,'cat','2017-10-07 22:00:00','2017-10-07 23:30:00'),(14344,7,47383,'cat','2017-10-09 22:00:00','2017-10-09 23:30:00'),(14344,7,47618,'cat','2017-10-07 22:00:00','2017-10-07 23:30:00'),(14344,7,48916,'cat','2017-10-06 22:00:00','2017-10-06 23:30:00'),(14344,7,52003,'cat',NULL,NULL),(14344,7,52005,'cat','2017-10-02 22:00:00','2017-10-02 23:30:00'),(14762,4,51653,'cat','2017-10-05 19:30:00','2017-10-05 21:00:00'),(14762,6,51653,'cat','2017-10-05 19:30:00','2017-10-05 21:00:00'),(14762,9,51653,'cat','2017-10-05 19:30:00','2017-10-05 21:00:00'),(16319,1,1342,'cat',NULL,NULL),(16319,3,44,'movie','2017-07-18 00:00:00','2017-07-22 00:00:00'),(16319,3,45,'movie','2017-08-03 00:00:00','2017-08-06 00:00:00'),(16319,3,47,'movie','2017-08-02 00:00:00','2017-08-05 00:00:00'),(16319,3,51,'movie','2017-07-18 00:00:00','2017-07-23 00:00:00'),(16319,3,52,'movie','2017-07-27 00:00:00','2017-07-29 00:00:00'),(16319,3,53,'movie','2017-05-21 00:00:00','2017-05-27 00:00:00'),(16319,3,882,'movie','2017-06-01 00:00:00','2017-06-02 00:00:00'),(16319,3,1307,'movie','2017-08-27 00:00:00','2017-09-02 00:00:00'),(16319,3,1342,'movie','2017-06-01 00:00:00','2017-06-01 00:00:00'),(16319,3,1418,'movie','2017-08-16 00:00:00','2017-09-01 00:00:00'),(16319,3,1627,'movie','2017-08-03 00:00:00','2017-08-31 00:00:00'),(16319,3,1669,'movie','2017-08-10 00:00:00','2017-08-11 00:00:00'),(16319,3,1807,'movie','2017-08-10 00:00:00','2017-08-12 00:00:00'),(16319,3,1834,'movie','2017-08-27 00:00:00','2017-09-03 00:00:00'),(16319,3,2015,'movie','2017-04-20 00:00:00','2017-04-22 00:00:00'),(16319,3,2037,'movie','2017-05-03 00:00:00','2017-05-04 00:00:00'),(16319,3,2039,'movie','2017-05-03 00:00:00','2017-05-05 00:00:00'),(16319,3,2071,'movie','2017-08-10 00:00:00','2017-08-13 00:00:00'),(16319,3,2135,'movie','2017-07-05 00:00:00','2017-07-08 00:00:00'),(16319,3,2271,'movie','2017-10-04 00:00:00','2017-10-08 00:00:00'),(16320,3,2161,'movie','2017-08-14 00:00:00','2017-09-27 00:00:00'),(16320,3,2171,'movie','2017-08-22 00:00:00','2017-09-13 00:00:00'),(16320,3,2181,'movie','2017-08-30 00:00:00','2017-09-13 00:00:00'),(16320,3,2183,'movie','2017-08-30 00:00:00','2017-10-01 00:00:00'),(16320,3,2189,'movie','2017-08-06 00:00:00','2017-10-04 00:00:00'),(16320,3,2191,'movie','2017-09-06 00:00:00','2017-10-12 00:00:00'),(16320,3,2193,'movie','2017-09-06 00:00:00','2017-09-27 00:00:00'),(16320,3,2203,'movie','2017-09-12 00:00:00','2017-10-04 00:00:00'),(16320,3,2205,'movie','2017-09-12 00:00:00','2017-09-20 00:00:00'),(16320,3,2207,'movie','2017-09-12 00:00:00','2017-09-20 00:00:00'),(16320,3,2209,'movie','2017-09-18 00:00:00','2017-09-27 00:00:00'),(16320,3,2213,'movie','2017-09-18 00:00:00','2017-10-12 00:00:00'),(16320,3,2215,'movie','2017-09-18 00:00:00','2017-10-04 00:00:00'),(16320,3,2217,'movie','2017-09-18 00:00:00','2017-09-27 00:00:00'),(16320,3,2223,'movie','2017-09-27 00:00:00','2017-10-12 00:00:00'),(16320,3,2225,'movie','2017-09-27 00:00:00','2017-10-12 00:00:00'),(16320,3,2227,'movie','2017-09-27 00:00:00','2017-10-04 00:00:00'),(16320,3,2255,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(16320,3,2257,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(16320,3,2261,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(16320,3,2263,'movie','2017-10-04 00:00:00','2017-10-11 00:00:00'),(16320,3,2267,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(16320,3,2269,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(16322,3,2161,'movie','2017-08-14 00:00:00','2017-09-20 00:00:00'),(16322,3,2171,'movie','2017-08-23 00:00:00','2017-09-13 00:00:00'),(16322,3,2183,'movie','2017-08-30 00:00:00','2017-10-11 00:00:00'),(16322,3,2189,'movie','2017-09-06 00:00:00','2017-09-27 00:00:00'),(16322,3,2191,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(16322,3,2193,'movie','2017-09-06 00:00:00','2017-09-27 00:00:00'),(16322,3,2203,'movie','2017-09-11 00:00:00','2017-10-04 00:00:00'),(16322,3,2205,'movie','2017-09-12 00:00:00','2017-09-27 00:00:00'),(16322,3,2207,'movie','2017-09-12 00:00:00','2017-10-04 00:00:00'),(16322,3,2213,'movie','2017-09-18 00:00:00','2017-10-04 00:00:00'),(16322,3,2215,'movie','2017-09-18 00:00:00','2017-10-11 00:00:00'),(16322,3,2223,'movie','2017-09-27 00:00:00','2017-10-04 00:00:00'),(16322,3,2225,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(16322,3,2255,'movie','2017-10-03 00:00:00','2017-10-07 00:00:00'),(16322,3,2257,'movie','2017-10-03 00:00:00','2017-10-08 00:00:00'),(16322,3,2261,'movie','2017-10-03 00:00:00','2017-10-17 00:00:00'),(16322,3,2263,'movie','2017-10-03 00:00:00','2017-10-12 00:00:00'),(16323,3,2140,'movie','2017-08-22 00:00:00','2017-08-30 00:00:00'),(16323,3,2154,'movie','2017-08-07 00:00:00','2017-08-23 00:00:00'),(16323,3,2161,'movie','2017-08-15 00:00:00','2017-09-20 00:00:00'),(16323,3,2171,'movie','2017-08-22 00:00:00','2017-09-13 00:00:00'),(16323,3,2183,'movie','2017-08-30 00:00:00','2017-10-11 00:00:00'),(16323,3,2189,'movie','2017-09-06 00:00:00','2017-09-27 00:00:00'),(16323,3,2191,'movie','2017-09-06 00:00:00','2017-10-11 00:00:00'),(16323,3,2193,'movie','2017-09-06 00:00:00','2017-09-27 00:00:00'),(16323,3,2203,'movie','2017-09-12 00:00:00','2017-09-27 00:00:00'),(16323,3,2207,'movie','2017-09-12 00:00:00','2017-10-04 00:00:00'),(16323,3,2209,'movie','2017-09-20 00:00:00','2017-09-27 00:00:00'),(16323,3,2215,'movie','2017-09-26 00:00:00','2017-10-04 00:00:00'),(16323,3,2225,'movie','2017-09-26 00:00:00','2017-10-11 00:00:00'),(16323,3,2255,'movie','2017-10-03 00:00:00','2017-10-12 00:00:00'),(16323,3,2257,'movie','2017-10-03 00:00:00','2017-10-12 00:00:00'),(16323,3,2261,'movie','2017-10-03 00:00:00','2017-10-12 00:00:00'),(16323,3,2263,'movie','2017-10-03 00:00:00','2017-10-12 00:00:00'),(16323,3,2265,'movie','2017-10-03 00:00:00','2017-10-12 00:00:00'),(16335,3,680,'movie','2015-02-20 00:00:00','2015-02-24 00:00:00'),(16335,3,684,'movie','2015-02-20 00:00:00','2015-02-28 00:00:00'),(16335,3,687,'movie','2015-02-20 00:00:00','2015-03-01 00:00:00'),(16335,7,52403,'cat','2017-10-06 20:00:00','2017-10-06 22:00:00'),(16491,2,52519,'cat','2017-10-14 16:00:00','2017-10-14 18:00:00'),(16491,2,52523,'cat','2017-10-15 16:00:00','2017-10-15 18:00:00'),(16491,3,52,'movie','2017-06-30 00:00:00','2017-07-09 00:00:00'),(16491,7,52459,'cat','2017-10-11 20:30:00','2017-10-11 22:00:00'),(16537,7,49558,'cat','2017-10-12 22:00:00','2017-10-12 23:30:00'),(16537,7,51123,'cat',NULL,NULL),(16638,7,52013,'cat',NULL,NULL),(16638,7,52303,'cat','2017-10-07 23:00:00','2017-10-07 23:30:00'),(16641,7,52111,'cat','2017-10-11 23:00:00','2017-10-11 23:30:00'),(16760,2,47371,'cat','2017-10-12 17:00:00','2017-10-12 18:30:00'),(16760,7,52309,'cat','2017-10-14 21:00:00','2017-10-14 23:30:00'),(16905,2,52193,'cat',NULL,NULL),(17017,3,2095,'movie','2017-06-02 00:00:00','2017-07-05 00:00:00'),(17017,3,2101,'movie','2017-07-25 00:00:00','2017-08-16 00:00:00'),(17017,3,2104,'movie','2017-08-30 00:00:00','2017-09-06 00:00:00'),(17017,3,2105,'movie','2017-09-12 00:00:00','2017-10-04 00:00:00'),(17017,3,2107,'movie','2017-08-31 00:00:00','2017-09-20 00:00:00'),(17017,3,2111,'movie','2017-06-08 00:00:00','2017-08-23 00:00:00'),(17017,3,2130,'movie','2017-06-28 00:00:00','2017-07-12 00:00:00'),(17017,3,2146,'movie','2017-07-21 00:00:00','2017-09-20 00:00:00'),(17017,3,2147,'movie','2017-09-06 00:00:00','2017-09-13 00:00:00'),(17017,3,2149,'movie','2017-07-25 00:00:00','2017-08-09 00:00:00'),(17017,3,2150,'movie','2017-07-25 00:00:00','2017-08-16 00:00:00'),(17017,3,2152,'movie','2017-08-23 00:00:00','2017-09-20 00:00:00'),(17017,3,2153,'movie','2017-08-02 00:00:00','2017-08-23 00:00:00'),(17017,3,2157,'movie','2017-09-26 00:00:00','2017-10-04 00:00:00'),(17017,3,2159,'movie','2017-08-08 00:00:00','2017-08-16 00:00:00'),(17017,3,2160,'movie','2017-08-10 00:00:00','2017-08-30 00:00:00'),(17017,3,2165,'movie','2017-08-20 00:00:00','2017-09-27 00:00:00'),(17017,3,2166,'movie','2017-08-16 00:00:00','2017-08-23 00:00:00'),(17017,3,2167,'movie','2017-08-18 00:00:00','2017-08-30 00:00:00'),(17017,3,2177,'movie','2017-08-23 00:00:00','2017-09-13 00:00:00'),(17017,3,2185,'movie','2017-09-20 00:00:00','2017-10-04 00:00:00'),(17017,3,2187,'movie','2017-08-31 00:00:00','2017-09-06 00:00:00'),(17017,3,2197,'movie','2017-09-12 00:00:00','2017-09-20 00:00:00'),(17017,3,2201,'movie','2017-09-06 00:00:00','2017-09-13 00:00:00'),(17017,3,2219,'movie','2017-09-20 00:00:00','2017-09-27 00:00:00'),(17017,3,2221,'movie','2017-09-20 00:00:00','2017-10-04 00:00:00'),(17017,3,2293,'movie','2017-10-05 00:00:00','2017-10-11 00:00:00'),(17017,3,2295,'movie','2017-10-05 00:00:00','2017-10-12 00:00:00'),(17017,3,2297,'movie','2017-10-05 00:00:00','2017-10-12 00:00:00'),(17017,3,2299,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(17017,3,2301,'movie','2017-10-06 00:00:00','2017-10-12 00:00:00'),(17017,3,2303,'movie','2017-10-04 00:00:00','2017-10-12 00:00:00'),(17017,3,2305,'movie','2017-10-06 00:00:00','2017-10-12 00:00:00'),(17586,7,47985,'cat','2017-10-07 21:00:00','2017-10-07 23:30:00'),(17596,3,542,'movie','2014-11-18 00:00:00','2014-11-20 00:00:00'),(17596,3,547,'movie','2014-11-20 00:00:00','2014-11-21 00:00:00'),(17603,6,51767,'cat','2017-10-14 09:30:00','2017-10-14 17:30:00'),(18186,7,51987,'cat','2017-10-05 19:00:00','2017-10-05 23:30:00'),(18304,7,47944,'cat','2017-10-05 18:30:00','2017-10-05 23:30:00'),(18361,3,41,'movie','2017-07-06 00:00:00','2017-09-26 00:00:00'),(18361,3,42,'movie','2017-06-12 00:00:00','2017-09-29 00:00:00'),(18361,3,47,'movie','2017-08-14 00:00:00','2017-09-08 00:00:00'),(18361,3,49,'movie','2017-05-21 00:00:00','2017-05-22 00:00:00'),(18361,3,50,'movie','2017-05-21 00:00:00','2017-05-23 00:00:00'),(18361,3,54,'movie','2017-07-12 00:00:00','2017-08-11 00:00:00'),(18361,3,116,'movie','2017-10-05 00:00:00','2017-10-29 00:00:00'),(18361,3,121,'movie','2017-07-11 00:00:00','2017-07-11 00:00:00'),(18361,3,894,'movie','2017-05-29 00:00:00','2017-05-29 00:00:00'),(18361,3,1047,'movie','2017-09-19 00:00:00','2017-09-20 00:00:00'),(18361,3,2075,'movie','2017-05-29 00:00:00','2017-05-29 00:00:00'),(18361,3,2076,'movie','2017-05-30 00:00:00','2017-05-30 00:00:00'),(18361,3,2078,'movie','2017-05-30 00:00:00','2017-05-31 00:00:00'),(18361,3,2080,'movie','2017-05-29 00:00:00','2017-06-01 00:00:00'),(18361,3,2081,'movie','2017-05-30 00:00:00','2017-06-01 00:00:00'),(18361,3,2082,'movie','2017-05-30 00:00:00','2017-06-02 00:00:00'),(18361,3,2083,'movie','2017-05-30 00:00:00','2017-06-02 00:00:00'),(18361,3,2087,'movie','2017-05-30 00:00:00','2017-06-03 00:00:00'),(18361,3,2231,'movie','2017-09-28 00:00:00','2017-10-02 00:00:00'),(18361,3,2233,'movie','2017-09-28 00:00:00','2017-10-03 00:00:00'),(18361,3,2235,'movie','2017-09-28 00:00:00','2017-10-05 00:00:00'),(18361,3,2237,'movie','2017-09-29 00:00:00','2017-10-05 00:00:00'),(18361,3,2239,'movie','2017-09-29 00:00:00','2017-10-06 00:00:00'),(18361,3,2241,'movie','2017-09-29 00:00:00','2017-10-09 00:00:00'),(18361,3,2243,'movie','2017-09-29 00:00:00','2017-10-10 00:00:00'),(18361,3,2245,'movie','2017-09-29 00:00:00','2017-10-11 00:00:00'),(18361,3,2247,'movie','2017-09-29 00:00:00','2017-10-13 00:00:00'),(18361,3,2249,'movie','2017-09-29 00:00:00','2017-10-16 00:00:00'),(18361,3,2259,'movie','2017-10-03 00:00:00','2017-10-18 00:00:00'),(18361,3,2275,'movie','2017-10-05 00:00:00','2017-10-18 00:00:00'),(18361,3,2277,'movie','2017-10-05 00:00:00','2017-10-26 00:00:00'),(18361,3,2279,'movie','2017-10-05 00:00:00','2017-10-19 00:00:00'),(18361,3,2281,'movie','2017-10-05 00:00:00','2017-10-19 00:00:00'),(18361,3,2283,'movie','2017-10-05 00:00:00','2017-10-20 00:00:00'),(18361,3,2285,'movie','2017-10-05 00:00:00','2017-10-20 00:00:00'),(18361,3,2287,'movie',NULL,NULL),(18361,3,2291,'movie','2017-10-05 00:00:00','2017-10-31 00:00:00'),(19163,9,51989,'cat',NULL,NULL),(20743,7,34100,'cat','2017-10-06 22:00:00','2017-10-06 23:30:00'),(20743,7,34574,'cat',NULL,NULL),(20743,7,43684,'cat','2017-10-07 22:30:00','2017-10-07 23:30:00'),(21041,7,52533,'cat','2017-10-06 20:30:00','2017-10-06 22:00:00'),(21604,3,549,'movie','2014-11-18 00:00:00','2014-11-21 00:00:00'),(29529,2,52059,'cat','2017-10-12 15:30:00','2017-10-12 21:30:00'),(29529,6,52059,'cat','2017-10-12 15:30:00','2017-10-12 21:30:00'),(30997,4,48864,'cat','2017-10-07 11:00:00','2017-10-08 19:30:00'),(30997,6,48864,'cat','2017-10-07 11:00:00','2017-10-08 19:30:00'),(35162,3,930,'movie','2015-06-16 00:00:00','2015-06-19 00:00:00'),(38642,7,52203,'cat','2017-10-03 20:00:00','2017-10-03 23:30:00'),(39292,3,1330,'movie','2017-05-22 00:00:00','2017-05-25 00:00:00'),(43141,2,49185,'cat','2017-10-07 11:00:00','2017-10-07 19:00:00'),(43141,6,49185,'cat','2017-10-07 11:00:00','2017-10-07 19:00:00'),(43141,9,49185,'cat','2017-10-07 11:00:00','2017-10-07 19:00:00'),(47766,3,55,'movie','2017-08-03 00:00:00','2017-08-19 00:00:00'),(47766,3,67,'movie','2017-08-02 00:00:00','2017-08-19 00:00:00'),(48395,6,52189,'cat','2017-10-07 09:00:00','2017-10-08 17:00:00'),(48395,9,52189,'cat','2017-10-07 09:00:00','2017-10-08 17:00:00'),(48583,7,52131,'cat','2017-10-07 14:00:00','2017-10-07 23:30:00'),(52211,7,52213,'cat','2017-10-06 20:30:00','2017-10-06 23:30:00'),(52277,2,52179,'cat',NULL,NULL),(52277,9,52179,'cat',NULL,NULL);
/*!40000 ALTER TABLE `SubCategory` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-09  3:48:44
