-- MySQL dump 10.13  Distrib 5.5.57, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: viridian_capstone_project
-- ------------------------------------------------------
-- Server version	5.5.57-0ubuntu0.14.04.1

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
-- Table structure for table `securitylevels`
--

DROP TABLE IF EXISTS `securitylevels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `securitylevels` (
  `intSecurityLevelId` int(5) NOT NULL,
  `strLevelDescription` varchar(255) DEFAULT NULL,
  `strSecurityTitle` varchar(255) DEFAULT NULL,
  `bitManageTickets` tinyint(1) NOT NULL,
  `bitManageUsers` tinyint(1) DEFAULT NULL,
  `bitSendNotifications` tinyint(1) DEFAULT NULL,
  `strSecurityLevel` text NOT NULL,
  PRIMARY KEY (`intSecurityLevelId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `securitylevels`
--

LOCK TABLES `securitylevels` WRITE;
/*!40000 ALTER TABLE `securitylevels` DISABLE KEYS */;
INSERT INTO `securitylevels` VALUES (1,'Ability to add/remove portal users, edit customization, create/view/assign/edit all tickets','Administrator',1,1,1,'Level 1'),(2,'Create/view/assign/edit all tickets, allow pictures sent by users, view region graphics','Manager',1,0,1,'Level 2'),(3,'Create/view/edit all tickets','Ranger',1,0,0,'Level 3'),(4,'Access mobile app','Mobile',0,0,0,'Level 4');
/*!40000 ALTER TABLE `securitylevels` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-08  0:57:46
