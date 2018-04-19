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
-- Temporary view structure for view `viewMovieTheater`
--

DROP TABLE IF EXISTS `viewMovieTheater`;
/*!50001 DROP VIEW IF EXISTS `viewMovieTheater`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewMovieTheater` AS SELECT 
 1 AS `idEvent`,
 1 AS `deEvent`,
 1 AS `deDetail`,
 1 AS `dtFrom`,
 1 AS `dtUntil`,
 1 AS `idPlaceOwner`,
 1 AS `nrEdition`,
 1 AS `idType`,
 1 AS `deImg`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `viewCinemaPlaces`
--

DROP TABLE IF EXISTS `viewCinemaPlaces`;
/*!50001 DROP VIEW IF EXISTS `viewCinemaPlaces`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewCinemaPlaces` AS SELECT 
 1 AS `idPlace`,
 1 AS `nmPlace`,
 1 AS `nrPhone`,
 1 AS `deWebsite`,
 1 AS `deAddress`,
 1 AS `deLogo`,
 1 AS `dePlace`,
 1 AS `deEmail`,
 1 AS `lat`,
 1 AS `lng`,
 1 AS `cep`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `viewCinemaPlace`
--

DROP TABLE IF EXISTS `viewCinemaPlace`;
/*!50001 DROP VIEW IF EXISTS `viewCinemaPlace`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewCinemaPlace` AS SELECT 
 1 AS `idPlace`,
 1 AS `nmPlace`,
 1 AS `nrPhone`,
 1 AS `deWebsite`,
 1 AS `deAddress`,
 1 AS `deLogo`,
 1 AS `dePlace`,
 1 AS `deEmail`,
 1 AS `lat`,
 1 AS `lng`,
 1 AS `cep`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `viewEventPlaceType`
--

DROP TABLE IF EXISTS `viewEventPlaceType`;
/*!50001 DROP VIEW IF EXISTS `viewEventPlaceType`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewEventPlaceType` AS SELECT 
 1 AS `idPlace`,
 1 AS `nmPlace`,
 1 AS `nrPhone`,
 1 AS `deWebsite`,
 1 AS `deAddress`,
 1 AS `deLogo`,
 1 AS `deRecurring`,
 1 AS `dePlace`,
 1 AS `deEmail`,
 1 AS `nrLat`,
 1 AS `nrLng`,
 1 AS `nrCep`,
 1 AS `idPlaceBranch`,
 1 AS `idEvent`,
 1 AS `deImg`,
 1 AS `deEvent`,
 1 AS `deDetail`,
 1 AS `dtFrom`,
 1 AS `dtUntil`,
 1 AS `idPlaceOwner`,
 1 AS `nrEdition`,
 1 AS `idType`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_random_events`
--

DROP TABLE IF EXISTS `view_random_events`;
/*!50001 DROP VIEW IF EXISTS `view_random_events`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `view_random_events` AS SELECT 
 1 AS `idEvent`,
 1 AS `nmPlace`,
 1 AS `deEvent`,
 1 AS `dtFrom`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `viewCinemaIDS`
--

DROP TABLE IF EXISTS `viewCinemaIDS`;
/*!50001 DROP VIEW IF EXISTS `viewCinemaIDS`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewCinemaIDS` AS SELECT 
 1 AS `idPlaceOwner`,
 1 AS `dtUntil`,
 1 AS `dtFrom`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `viewEventPlaces`
--

DROP TABLE IF EXISTS `viewEventPlaces`;
/*!50001 DROP VIEW IF EXISTS `viewEventPlaces`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `viewEventPlaces` AS SELECT 
 1 AS `idPlace`,
 1 AS `nmPlace`,
 1 AS `nrPhone`,
 1 AS `deWebsite`,
 1 AS `deAddress`,
 1 AS `deLogo`,
 1 AS `dePlace`,
 1 AS `deEmail`,
 1 AS `Placecol`,
 1 AS `nrLat`,
 1 AS `nrLng`,
 1 AS `deRecurring`,
 1 AS `nrCep`,
 1 AS `idPlaceBranch`,
 1 AS `idEvent`,
 1 AS `deImg`,
 1 AS `deEvent`,
 1 AS `deDetail`,
 1 AS `dtFrom`,
 1 AS `dtUntil`,
 1 AS `idPlaceOwner`,
 1 AS `nrEdition`,
 1 AS `idType`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `viewMovieTheater`
--

/*!50001 DROP VIEW IF EXISTS `viewMovieTheater`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`remote`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `viewMovieTheater` AS select `a`.`idEvent` AS `idEvent`,`a`.`deEvent` AS `deEvent`,`a`.`deDetail` AS `deDetail`,`b`.`dtStart` AS `dtFrom`,`b`.`dtEnd` AS `dtUntil`,`b`.`fkPlace` AS `idPlaceOwner`,`a`.`nrEdition` AS `nrEdition`,`a`.`idType` AS `idType`,`a`.`deImg` AS `deImg` from (`Event` `a` left join `SubCategory` `b` on(((`a`.`idEvent` = `b`.`fkEvent`) and (`a`.`idType` = `b`.`fkType`)))) where ((`b`.`catInfo` = 'movie') and (`a`.`idType` = 3)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewCinemaPlaces`
--

/*!50001 DROP VIEW IF EXISTS `viewCinemaPlaces`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`remote`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `viewCinemaPlaces` AS select `Place`.`idPlace` AS `idPlace`,`Place`.`nmPlace` AS `nmPlace`,coalesce(`Place`.`nrPhone`,'N/A') AS `nrPhone`,coalesce(`Place`.`deWebsite`,'N/A') AS `deWebsite`,`Place`.`deAddress` AS `deAddress`,`Place`.`deLogo` AS `deLogo`,`Place`.`dePlace` AS `dePlace`,`Place`.`deEmail` AS `deEmail`,`Place`.`nrLat` AS `lat`,`Place`.`nrLng` AS `lng`,`Place`.`nrCep` AS `cep` from `Place` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewCinemaPlace`
--

/*!50001 DROP VIEW IF EXISTS `viewCinemaPlace`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`remote`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `viewCinemaPlace` AS select `Place`.`idPlace` AS `idPlace`,`Place`.`nmPlace` AS `nmPlace`,coalesce(`Place`.`nrPhone`,'N/A') AS `nrPhone`,coalesce(`Place`.`deWebsite`,'N/A') AS `deWebsite`,`Place`.`deAddress` AS `deAddress`,`Place`.`deLogo` AS `deLogo`,`Place`.`dePlace` AS `dePlace`,`Place`.`deEmail` AS `deEmail`,`Place`.`nrLat` AS `lat`,`Place`.`nrLng` AS `lng`,`Place`.`nrCep` AS `cep` from `Place` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewEventPlaceType`
--

/*!50001 DROP VIEW IF EXISTS `viewEventPlaceType`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`remote`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `viewEventPlaceType` AS select `a`.`idPlace` AS `idPlace`,upper(`a`.`nmPlace`) AS `nmPlace`,`a`.`nrPhone` AS `nrPhone`,coalesce(`a`.`deWebsite`,'#') AS `deWebsite`,`a`.`deAddress` AS `deAddress`,`a`.`deLogo` AS `deLogo`,`b`.`deRecurring` AS `deRecurring`,`a`.`dePlace` AS `dePlace`,`a`.`deEmail` AS `deEmail`,`a`.`nrLat` AS `nrLat`,`a`.`nrLng` AS `nrLng`,`a`.`nrCep` AS `nrCep`,`a`.`idPlaceBranch` AS `idPlaceBranch`,`b`.`idEvent` AS `idEvent`,`b`.`deImg` AS `deImg`,`b`.`deEvent` AS `deEvent`,`b`.`deDetail` AS `deDetail`,`b`.`dtFrom` AS `dtFrom`,`b`.`dtUntil` AS `dtUntil`,`b`.`idPlaceOwner` AS `idPlaceOwner`,`b`.`nrEdition` AS `nrEdition`,`c`.`fkType` AS `idType` from ((`Place` `a` left join `Event` `b` on((`a`.`idPlace` = `b`.`idPlaceOwner`))) left join `SubCategory` `c` on(((`c`.`fkPlace` = `a`.`idPlace`) and (`c`.`fkEvent` = `b`.`idEvent`)))) where ((`c`.`fkType` <> 3) and (`b`.`statusKO` = 'ON')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_random_events`
--

/*!50001 DROP VIEW IF EXISTS `view_random_events`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`remote`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `view_random_events` AS (select `viewEventPlaceType`.`idEvent` AS `idEvent`,`viewEventPlaceType`.`nmPlace` AS `nmPlace`,`viewEventPlaceType`.`deEvent` AS `deEvent`,`viewEventPlaceType`.`dtFrom` AS `dtFrom` from `viewEventPlaceType` where ((cast(`viewEventPlaceType`.`dtFrom` as date) >= (now() - interval 1 day)) and (cast(`viewEventPlaceType`.`dtUntil` as date) <= now())) order by rand() limit 4) union (select `viewEventPlaceType`.`idEvent` AS `idEvent`,`viewEventPlaceType`.`nmPlace` AS `nmPlace`,`viewEventPlaceType`.`deEvent` AS `deEvent`,`viewEventPlaceType`.`dtFrom` AS `dtFrom` from `viewEventPlaceType` where ((cast(`viewEventPlaceType`.`dtFrom` as date) >= now()) and (cast(`viewEventPlaceType`.`dtUntil` as date) <= (now() + interval 1 day))) order by rand() limit 4) union (select `viewEventPlaceType`.`idEvent` AS `idEvent`,`viewEventPlaceType`.`nmPlace` AS `nmPlace`,`viewEventPlaceType`.`deEvent` AS `deEvent`,`viewEventPlaceType`.`dtFrom` AS `dtFrom` from `viewEventPlaceType` where ((cast(`viewEventPlaceType`.`dtFrom` as date) >= (now() + interval 1 day)) and (cast(`viewEventPlaceType`.`dtUntil` as date) <= (now() + interval 2 day))) order by rand() limit 4) union (select `viewEventPlaceType`.`idEvent` AS `idEvent`,`viewEventPlaceType`.`nmPlace` AS `nmPlace`,`viewEventPlaceType`.`deEvent` AS `deEvent`,`viewEventPlaceType`.`dtFrom` AS `dtFrom` from `viewEventPlaceType` where ((cast(`viewEventPlaceType`.`dtFrom` as date) >= (now() + interval 2 day)) and (cast(`viewEventPlaceType`.`dtUntil` as date) <= (now() + interval 3 day))) order by rand() limit 4) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewCinemaIDS`
--

/*!50001 DROP VIEW IF EXISTS `viewCinemaIDS`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`remote`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `viewCinemaIDS` AS select `Event`.`idPlaceOwner` AS `idPlaceOwner`,`Event`.`dtUntil` AS `dtUntil`,`Event`.`dtFrom` AS `dtFrom` from `Event` where (`Event`.`idType` = 3) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewEventPlaces`
--

/*!50001 DROP VIEW IF EXISTS `viewEventPlaces`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `viewEventPlaces` AS select `a`.`idPlace` AS `idPlace`,upper(`a`.`nmPlace`) AS `nmPlace`,`a`.`nrPhone` AS `nrPhone`,coalesce(`a`.`deWebsite`,'#') AS `deWebsite`,`a`.`deAddress` AS `deAddress`,`a`.`deLogo` AS `deLogo`,`a`.`dePlace` AS `dePlace`,`a`.`deEmail` AS `deEmail`,`a`.`Placecol` AS `Placecol`,`a`.`nrLat` AS `nrLat`,`a`.`nrLng` AS `nrLng`,`b`.`deRecurring` AS `deRecurring`,`a`.`nrCep` AS `nrCep`,`a`.`idPlaceBranch` AS `idPlaceBranch`,`b`.`idEvent` AS `idEvent`,`b`.`deImg` AS `deImg`,`b`.`deEvent` AS `deEvent`,`b`.`deDetail` AS `deDetail`,`b`.`dtFrom` AS `dtFrom`,`b`.`dtUntil` AS `dtUntil`,`b`.`idPlaceOwner` AS `idPlaceOwner`,`b`.`nrEdition` AS `nrEdition`,`b`.`idType` AS `idType` from (`Place` `a` left join `Event` `b` on((`a`.`idPlace` = `b`.`idPlaceOwner`))) where ((`b`.`idType` <> 3) and (`b`.`statusKO` = 'ON')) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Dumping events for database 'guiafloripa_app'
--

--
-- Dumping routines for database 'guiafloripa_app'
--
/*!50003 DROP FUNCTION IF EXISTS `mask` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` FUNCTION `mask`(unformatted_value BIGINT, format_string CHAR(32)) RETURNS char(32) CHARSET latin1
    DETERMINISTIC
BEGIN
# Declare variables
DECLARE input_len TINYINT;
DECLARE output_len TINYINT;
DECLARE temp_char CHAR;

# Initialize variables
SET input_len = LENGTH(unformatted_value);
SET output_len = LENGTH(format_string);

# Construct formated string
WHILE ( output_len > 0 ) DO

SET temp_char = SUBSTR(format_string, output_len, 1);
IF ( temp_char = '#' ) THEN
IF ( input_len > 0 ) THEN
SET format_string = INSERT(format_string, output_len, 1, SUBSTR(unformatted_value, input_len, 1));
SET input_len = input_len - 1;
ELSE
SET format_string = INSERT(format_string, output_len, 1, '0');
END IF;
END IF;

SET output_len = output_len - 1;
END WHILE;

RETURN format_string;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `numbers_only` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`remote`@`%` FUNCTION `numbers_only`(in_string varchar(50)) RETURNS bigint(20)
    NO SQL
BEGIN
    DECLARE ctrNumber varchar(50);
    DECLARE finNumber varchar(50) default ' ';
    DECLARE sChar varchar(2);
    DECLARE inti BIGINT default 1;

    IF length(in_string) > 0 THEN    
        WHILE(inti <= length(in_string)) DO
            SET sChar= SUBSTRING(in_string,inti,1);
            SET ctrNumber= FIND_IN_SET(sChar,'0,1,2,3,4,5,6,7,8,9');

            IF ctrNumber > 0 THEN
               SET finNumber=CONCAT(finNumber,sChar);
            ELSE
               SET finNumber=CONCAT(finNumber,'');
            END IF;
            SET inti=inti+1;
        END WHILE;
        RETURN CAST(finNumber AS UNSIGNED) ;
    ELSE
        RETURN 0;
    END IF;

END ;;
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

-- Dump completed on 2018-04-19 17:12:34
