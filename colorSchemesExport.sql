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
-- Table structure for table `colorSchemes`
--

DROP TABLE IF EXISTS `colorSchemes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colorSchemes` (
  `colorId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `colorCssLink` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bannerCssLink` varchar(100) CHARACTER SET utf8 NOT NULL,
  `currentUsersLink` varchar(50) NOT NULL,
  `openTicketsLink` varchar(50) NOT NULL,
  `closedTicketsLink` varchar(50) NOT NULL,
  `severeWeatherLink` varchar(50) NOT NULL,
  `calendarLink` varchar(50) NOT NULL,
  `alertsLink` varchar(50) NOT NULL,
  `profileLink` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `colorArray` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '#77be74',
  PRIMARY KEY (`colorId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colorSchemes`
--

LOCK TABLES `colorSchemes` WRITE;
/*!40000 ALTER TABLE `colorSchemes` DISABLE KEYS */;
INSERT INTO `colorSchemes` VALUES (1,'Viridian','/css/viridian.css','/images/ViridianBanner.png','/images/currentUsers.png','/images/openTickets.png','/images/closedTickets.png','/images/weatherAlerts.png','/images/scheduledNotifications.png','/images/alert.png','/images/viridianProfile.png',0,'#3c8e86,#a1d144,#625214,#753d8e,#db6f18,#62af3a,#ed3418,#9c4a5b,#758b74'),(2,'Atlantean','/css/atlantean.css','/images/AtlanteanBanner.png','/images/currentUsersDark.png','/images/openTicketsDark.png','/images/closedTicketsDark.png','/images/weatherAlertsDark.png','/images/scheduledNotificationsDark.png','/images/alertDark.png','/images/atlanteanProfile.png',0,'#0156d9,#d8e941,#3d4d3b,#5729a5,#ca6425,#38955e,#7f4d52,#9b276a,#667d84'),(3,'Carmine','/css/carmine.css','/images/CarmineBanner.png','/images/currentUsersDark.png','/images/openTicketsDark.png','/images/closedTicketsDark.png','/images/weatherAlertsDark.png','/images/scheduledNotificationsDark.png','/images/alertDark.png','/images/carmineProfile.png',0,'#3041c1,#ead633,#73330c,#8c108a,#ed5910,#739132,#b3312a,#ba1a57,#857170'),(4,'Daybreak','/css/daybreak.css','/images/DaybreakBanner.png','/images/currentUsers.png','/images/openTickets.png','/images/closedTickets.png','/images/weatherAlerts.png','/images/scheduledNotifications.png','/images/alert.png','/images/daybreakProfile.png',0,'#3448c8,#f9ec32,#7a3808,#941094,#f75e0d,#75a130,#fb2913,#c42252,#8f766e'),(5,'Sangria','/css/sangria.css','/images/SangriaBanner.png','/images/currentUsersDark.png','/images/openTicketsDark.png','/images/closedTicketsDark.png','/images/weatherAlertsDark.png','/images/scheduledNotificationsDark.png','/images/alertDark.png','/images/sangriaProfile.png',0,'#2a47d8,#f0e23a,#7a3a23,#8b0fa0,#f35d13,#729b3c,#eb2d22,#b82361,#887279'),(6,'Sapphire','/css/sapphire.css','/images/SapphireBanner.png','/images/currentUsersDark.png','/images/openTicketsDark.png','/images/closedTicketsDark.png','/images/weatherAlertsDark.png','/images/scheduledNotificationsDark.png','/images/alertDark.png','/images/sapphireProfile.png',0,'#094cf6,#d5e052,#57423d,#7a10b3,#ca623a,#579a60,#cb3740,#a52476,#6d7a93'),(7,'Autumnal','/css/autumnal.css','/images/AutumnalBanner.png','/images/currentUsersDark.png','/images/openTicketsDark.png','/images/closedTicketsDark.png','/images/weatherAlertsDark.png','/images/scheduledNotificationsDark.png','/images/alertDark.png','/images/autumnalProfile.png',0,'#4466c0,#f8ee32,#84520c,#9c2c8f,#ec8b1e,#84b031,#f93b16,#cb4251,#938970'),(8,'Espresso','/css/espresso.css','/images/EspressoBanner.png','/images/currentUsersDark.png','/images/openTicketsDark.png','/images/closedTicketsDark.png','/images/weatherAlertsDark.png','/images/scheduledNotificationsDark.png','/images/alertDark.png','/images/espressoProfile.png',0,'#305cd8,#ede540,#774714,#93279d,#dc7c38,#7baa3f,#e05a38,#c03562,#8c857b'),(9,'Gunmetal','/css/gunmetal.css','/images/GunmetalBanner.png','/images/currentUsersDark.png','/images/openTicketsDark.png','/images/closedTicketsDark.png','/images/weatherAlertsDark.png','/images/scheduledNotificationsDark.png','/images/alertDark.png','/images/gunmetalProfile.png',0,'#2e51d2,#dbd74a,#6c4a48,#830faa,#e06025,#69984e,#db3631,#a62f70,#7d7a83'),(10,'High Roller','/css/highRoller.css','/images/HighRollerBanner.png','/images/currentUsers.png','/images/openTickets.png','/images/closedTickets.png','/images/weatherAlerts.png','/images/scheduledNotifications.png','/images/alert.png','/images/highRollerProfile.png',0,'#356bf0,#fefd6e,#8c652e,#a440b1,#fda657,#8cc353,#fe5133,#d14e76,#a09f8e'),(11,'Lemon Drop','/css/lemonDrop.css','/images/LemonDropBanner.png','/images/currentUsers.png','/images/openTickets.png','/images/closedTickets.png','/images/weatherAlerts.png','/images/scheduledNotifications.png','/images/alert.png','/images/lemonDropProfile.png',0,'#416dca,#fef933,#8c5e0c,#a4388f,#fd9319,#85b932,#fe4316,#d14754,#999370'),(12,'Sakura','/css/sakura.css','/images/SakuraBanner.png','/images/currentUsersDark.png','/images/openTicketsDark.png','/images/closedTicketsDark.png','/images/weatherAlertsDark.png','/images/scheduledNotificationsDark.png','/images/alertDark.png','/images/sakuraProfile.png',0,'#423acc,#f4dd3c,#7f2e21,#9008a2,#f55a14,#76943e,#f02625,#c01763,#8b6d7d'),(13,'City','/css/city.css','/images/CityBanner2.png','/images/currentUsersDark.png','/images/openTicketsDark.png','/images/closedTicketsDark.png','/images/weatherAlertsDark.png','/images/scheduledNotificationsDark.png','/images/alertDark.png','/images/cityProfile.png',1,'#4867b9,#dcc238,#93651a,#9a318c,#ed7418,#84ac34,#f93316,#c43f55,#92886e'),(14,'GoldCity','/css/goldCity.css','/images/CityBanner.png','/images/currentUsersDark.png','/images/openTicketsDark.png','/images/closedTicketsDark.png','/images/weatherAlertsDark.png','/images/scheduledNotificationsDark.png','/images/alertDark.png','/images/cityProfile.png',0,'#013aa2,#cbd53a,#4c3216,#7208a2,#ca5619,#337044,#982b2d,#741f5c,#606c76');
/*!40000 ALTER TABLE `colorSchemes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-08  0:44:17
