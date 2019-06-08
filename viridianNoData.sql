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
-- Table structure for table `CalendarEvents`
--

DROP TABLE IF EXISTS `CalendarEvents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CalendarEvents` (
  `intEventId` int(11) NOT NULL AUTO_INCREMENT,
  `strEventType` varchar(20) NOT NULL,
  `strEventTitle` varchar(200) CHARACTER SET utf8 NOT NULL,
  `strEventDescription` varchar(500) CHARACTER SET utf8 NOT NULL,
  `strEmployeeId` varchar(30) CHARACTER SET utf8 NOT NULL,
  `dtStartDate` datetime NOT NULL,
  `dtEndDate` datetime NOT NULL,
  `strEventColor` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`intEventId`),
  KEY `intEventId` (`intEventId`),
  KEY `strEmployeeId` (`strEmployeeId`),
  CONSTRAINT `FKUserId1` FOREIGN KEY (`strEmployeeId`) REFERENCES `firebaseusers` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ErrorReporting`
--

DROP TABLE IF EXISTS `ErrorReporting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ErrorReporting` (
  `intIndex` int(11) NOT NULL AUTO_INCREMENT,
  `strErrorActivity` varchar(1000) NOT NULL,
  `dtAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `occurenceLocation` varchar(255) NOT NULL,
  PRIMARY KEY (`intIndex`)
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(30) CHARACTER SET utf8 NOT NULL,
  `deviceId` varchar(50) NOT NULL,
  `intActivityType` int(11) NOT NULL DEFAULT '1',
  `timeTotalDuration` varchar(20) NOT NULL,
  `milesTotalDistance` float NOT NULL,
  `calTotalCalories` float NOT NULL,
  `averageSpeed` float NOT NULL,
  `startDate` date NOT NULL,
  `startTime` time NOT NULL,
  `endDate` date NOT NULL,
  `endTime` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `intActivityType` (`intActivityType`),
  CONSTRAINT `FKActivityType` FOREIGN KEY (`intActivityType`) REFERENCES `userActivitiesType` (`intTypeId`) ON UPDATE CASCADE,
  CONSTRAINT `FKUserId` FOREIGN KEY (`userId`) REFERENCES `firebaseusers` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `databaseTests`
--

DROP TABLE IF EXISTS `databaseTests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `databaseTests` (
  `intIndex` int(11) NOT NULL AUTO_INCREMENT,
  `dataSent` longtext CHARACTER SET utf8 NOT NULL,
  `datetimeSent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`intIndex`)
) ENGINE=InnoDB AUTO_INCREMENT=21045 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feedback` (
  `intFeedbackId` int(11) NOT NULL AUTO_INCREMENT,
  `strFeedback` varchar(800) NOT NULL,
  `strErrorLocation` varchar(10) NOT NULL,
  `dateReceived` datetime NOT NULL,
  `bitResolved` tinyint(1) NOT NULL,
  PRIMARY KEY (`intFeedbackId`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `firebaseusers`
--

DROP TABLE IF EXISTS `firebaseusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `firebaseusers` (
  `userId` varchar(30) CHARACTER SET utf8 NOT NULL,
  `bitSendPics` tinyint(1) NOT NULL DEFAULT '1',
  `accountLocked` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `dtBirthdate` date NOT NULL,
  `dtCreated` date NOT NULL,
  `intZipCode` int(11) NOT NULL DEFAULT '0',
  `intWeight` int(11) NOT NULL DEFAULT '0',
  `intHeight` int(11) NOT NULL DEFAULT '0',
  `strGender` char(1) NOT NULL DEFAULT 'O',
  `intSecurityLevel` int(5) NOT NULL DEFAULT '4',
  `loggedIntoAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `intColorScheme` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`userId`),
  KEY `intColorScheme` (`intColorScheme`),
  KEY `intSecurityLevel` (`intSecurityLevel`),
  CONSTRAINT `FKColorScheme` FOREIGN KEY (`intColorScheme`) REFERENCES `colorSchemes` (`colorId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FKSecurityLevel` FOREIGN KEY (`intSecurityLevel`) REFERENCES `securitylevels` (`intSecurityLevelId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `geofences`
--

DROP TABLE IF EXISTS `geofences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `geofences` (
  `intId` int(11) NOT NULL AUTO_INCREMENT,
  `strName` varchar(50) NOT NULL COMMENT 'Identifies geofence on mobile',
  `btActive` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 - Active; 0 - Inactive',
  `intMeterRadius` int(11) NOT NULL COMMENT 'Must be at least 200',
  `dblLatitude` double NOT NULL,
  `dblLongitude` double NOT NULL,
  `dtCreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `strNotifText` varchar(500) NOT NULL COMMENT 'To be shown in notification',
  `strDescription` varchar(500) NOT NULL COMMENT 'Displays event description on mobile',
  `dtEventDate` date NOT NULL COMMENT 'First day of event',
  `dtEndDate` date NOT NULL,
  PRIMARY KEY (`intId`),
  UNIQUE KEY `strName` (`strName`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `locationData`
--

DROP TABLE IF EXISTS `locationData`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locationData` (
  `intLocationId` int(11) NOT NULL AUTO_INCREMENT,
  `intActivityId` varchar(255) CHARACTER SET utf8 NOT NULL,
  `activityDate` date NOT NULL,
  `time` time NOT NULL,
  `gpsLat` float NOT NULL,
  `gpsLong` float NOT NULL,
  PRIMARY KEY (`intLocationId`),
  UNIQUE KEY `activityId` (`intLocationId`),
  KEY `activityId_2` (`intLocationId`)
) ENGINE=InnoDB AUTO_INCREMENT=6765 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `maintenancetickets`
--

DROP TABLE IF EXISTS `maintenancetickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maintenancetickets` (
  `intTicketId` int(11) NOT NULL AUTO_INCREMENT,
  `strTitle` varchar(255) DEFAULT NULL,
  `intTypeId` int(5) NOT NULL DEFAULT '9',
  `strDescription` varchar(500) DEFAULT NULL,
  `dtSubmitted` date DEFAULT NULL,
  `dtClosed` date DEFAULT NULL,
  `dtEstFinish` date NOT NULL,
  `strImageFilePath` varchar(255) DEFAULT NULL,
  `bitUrgent` int(1) DEFAULT '0',
  `bitMobileDisplay` tinyint(1) NOT NULL DEFAULT '0',
  `strUserId` varchar(30) DEFAULT NULL,
  `strEmployeeAssigned` varchar(30) DEFAULT NULL,
  `strEmployeeName` varchar(50) DEFAULT NULL,
  `gpsLat` float NOT NULL,
  `gpsLong` float NOT NULL,
  `time` time NOT NULL,
  `geofenceId` int(11) DEFAULT NULL,
  PRIMARY KEY (`intTicketId`),
  KEY `intUserId` (`strUserId`),
  KEY `intEmployeeAssigned` (`strEmployeeAssigned`),
  KEY `intTicketId` (`intTicketId`),
  KEY `intTypeId` (`intTypeId`),
  KEY `geofenceId` (`geofenceId`),
  CONSTRAINT `FKGeofenceId` FOREIGN KEY (`geofenceId`) REFERENCES `geofences` (`intId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FKTicketEmployee` FOREIGN KEY (`strEmployeeAssigned`) REFERENCES `firebaseusers` (`userId`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FKTicketType` FOREIGN KEY (`intTypeId`) REFERENCES `tickettypes` (`intTypeId`) ON UPDATE CASCADE,
  CONSTRAINT `FKTicketUserId` FOREIGN KEY (`strUserId`) REFERENCES `firebaseusers` (`userId`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=285 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `medals`
--

DROP TABLE IF EXISTS `medals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medals` (
  `intMedalId` int(11) NOT NULL AUTO_INCREMENT,
  `strMedalName` varchar(30) NOT NULL,
  PRIMARY KEY (`intMedalId`),
  KEY `intMedalId` (`intMedalId`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `medalsEarned`
--

DROP TABLE IF EXISTS `medalsEarned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medalsEarned` (
  `intEarnedId` int(11) NOT NULL AUTO_INCREMENT,
  `strUserId` varchar(30) CHARACTER SET utf8 NOT NULL,
  `intMedalId` int(11) NOT NULL,
  PRIMARY KEY (`intEarnedId`),
  KEY `intUserId` (`strUserId`),
  KEY `intMedalId` (`intMedalId`),
  CONSTRAINT `FKMedalUserId` FOREIGN KEY (`strUserId`) REFERENCES `firebaseusers` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `medalid_fk` FOREIGN KEY (`intMedalId`) REFERENCES `medals` (`intMedalId`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pushnotifications`
--

DROP TABLE IF EXISTS `pushnotifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pushnotifications` (
  `intNotificationId` int(5) NOT NULL AUTO_INCREMENT,
  `oneSignalId` varchar(50) NOT NULL,
  `strNotificationType` varchar(255) DEFAULT NULL,
  `intType` int(1) NOT NULL,
  `strNotificationContent` varchar(255) DEFAULT NULL,
  `dtSentToUsers` date DEFAULT NULL,
  `dtReceivedFromAPI` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `intSevereWeatherAlertsSent` int(11) DEFAULT NULL,
  `strJSONMessage` varchar(1000) DEFAULT NULL,
  `strDateTime` varchar(100) NOT NULL,
  `btHasPhoto` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`intNotificationId`)
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `taskId` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(50) CHARACTER SET utf16 NOT NULL,
  `lastCompleted` varchar(30) NOT NULL,
  PRIMARY KEY (`taskId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ticketnotes`
--

DROP TABLE IF EXISTS `ticketnotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ticketnotes` (
  `noteId` int(11) NOT NULL AUTO_INCREMENT,
  `intTicketId` int(11) DEFAULT NULL,
  `comment` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `strUserId` varchar(30) CHARACTER SET utf8 NOT NULL,
  `strEmployeeName` varchar(50) CHARACTER SET utf8 NOT NULL,
  `dateAdded` date NOT NULL,
  PRIMARY KEY (`noteId`),
  KEY `ticketnotes_ibfk_1` (`intTicketId`),
  KEY `strUserId` (`strUserId`),
  CONSTRAINT `FKNotesUserId` FOREIGN KEY (`strUserId`) REFERENCES `firebaseusers` (`userId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `ticketnotes_ibfk_1` FOREIGN KEY (`intTicketId`) REFERENCES `maintenancetickets` (`intTicketId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=706 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tickettypes`
--

DROP TABLE IF EXISTS `tickettypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickettypes` (
  `intTypeId` int(11) NOT NULL,
  `strTicketType` varchar(255) DEFAULT NULL,
  `strTicketDescription` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`intTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trailFriendlyBusinesses`
--

DROP TABLE IF EXISTS `trailFriendlyBusinesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trailFriendlyBusinesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `businessName` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `gpsLat` double NOT NULL,
  `gpsLong` double NOT NULL,
  `bathroom` tinyint(1) NOT NULL,
  `waterRefill` tinyint(1) NOT NULL,
  `bikeRepair` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trailOverlay`
--

DROP TABLE IF EXISTS `trailOverlay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trailOverlay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filePath` varchar(100) NOT NULL,
  `fileName` varchar(100) NOT NULL,
  `dateUploaded` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trailRatings`
--

DROP TABLE IF EXISTS `trailRatings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trailRatings` (
  `trailId` int(4) NOT NULL,
  `userId` varchar(30) CHARACTER SET utf8 NOT NULL,
  `rating` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trailId`,`userId`),
  KEY `userId` (`userId`),
  CONSTRAINT `FK1` FOREIGN KEY (`userId`) REFERENCES `firebaseusers` (`userId`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FKTrailRating` FOREIGN KEY (`trailId`) REFERENCES `trailSections` (`trailId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trailReviews`
--

DROP TABLE IF EXISTS `trailReviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trailReviews` (
  `reviewId` int(4) NOT NULL AUTO_INCREMENT,
  `trailId` int(4) NOT NULL,
  `review` varchar(1000) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`reviewId`),
  KEY `trailId` (`trailId`),
  CONSTRAINT `FKTrailReview` FOREIGN KEY (`trailId`) REFERENCES `trailSections` (`trailId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trailSections`
--

DROP TABLE IF EXISTS `trailSections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trailSections` (
  `trailId` int(11) NOT NULL AUTO_INCREMENT,
  `trailName` varchar(50) NOT NULL,
  PRIMARY KEY (`trailId`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `userActivitiesType`
--

DROP TABLE IF EXISTS `userActivitiesType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userActivitiesType` (
  `intTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `strActivity` varchar(50) NOT NULL,
  PRIMARY KEY (`intTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-05 22:08:41
