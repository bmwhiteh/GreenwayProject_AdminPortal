-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2018 at 10:59 PM
-- Server version: 5.5.57-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `viridian_capstone_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `colorSchemes`
--

CREATE TABLE IF NOT EXISTS `colorSchemes` (
  `colorId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `colorCssLink` varchar(100) CHARACTER SET utf8 NOT NULL,
  `bannerCssLink` varchar(100) CHARACTER SET utf8 NOT NULL,
  `active` tinyint(1) NOT NULL,
  `colorArray` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '#77be74',
  PRIMARY KEY (`colorId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `databaseTests`
--

CREATE TABLE IF NOT EXISTS `databaseTests` (
  `intIndex` int(11) NOT NULL AUTO_INCREMENT,
  `dataSent` longtext CHARACTER SET utf8 NOT NULL,
  `datetimeSent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`intIndex`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6954 ;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `intEmployeeId` int(5) NOT NULL AUTO_INCREMENT,
  `strFirstName` varchar(255) DEFAULT NULL,
  `strLastName` varchar(255) DEFAULT NULL,
  `strUsername` varchar(255) DEFAULT NULL,
  `strUsernameBase` varchar(30) NOT NULL,
  `strEncryptedPassword` varchar(255) DEFAULT NULL,
  `intSecurityLevel` int(5) DEFAULT NULL,
  `strEmailAddress` varchar(255) DEFAULT NULL,
  `securityQuestion1` text NOT NULL,
  `securityQuestion1Answer` varchar(100) NOT NULL,
  `securityQuestion2` text NOT NULL,
  `securityQuestion2Answer` varchar(100) NOT NULL,
  `accountLocked` tinyint(1) NOT NULL,
  `loginAttempts` int(11) NOT NULL,
  `securityQuestionAttempts` int(11) NOT NULL,
  `activeUser` tinyint(1) NOT NULL,
  `firstAccess` tinyint(1) NOT NULL,
  PRIMARY KEY (`intEmployeeId`),
  KEY `intSecurityLevel` (`intSecurityLevel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `intFeedbackId` int(11) NOT NULL AUTO_INCREMENT,
  `strFeedback` varchar(800) NOT NULL,
  `strErrorLocation` varchar(10) NOT NULL,
  `dateReceived` datetime NOT NULL,
  `bitResolved` tinyint(1) NOT NULL,
  PRIMARY KEY (`intFeedbackId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `locationData`
--

CREATE TABLE IF NOT EXISTS `locationData` (
  `intLocationId` int(11) NOT NULL AUTO_INCREMENT,
  `intActivityId` int(11) NOT NULL,
  `activityDate` date NOT NULL,
  `time` time NOT NULL,
  `gpsLat` float NOT NULL,
  `gpsLong` float NOT NULL,
  PRIMARY KEY (`intLocationId`),
  UNIQUE KEY `activityId` (`intLocationId`),
  KEY `activityId_2` (`intLocationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5498 ;

-- --------------------------------------------------------

--
-- Table structure for table `maintenancetickets`
--

CREATE TABLE IF NOT EXISTS `maintenancetickets` (
  `intTicketId` int(11) NOT NULL AUTO_INCREMENT,
  `strTitle` varchar(255) DEFAULT NULL,
  `intTypeId` int(5) DEFAULT '9',
  `strDescription` varchar(500) DEFAULT NULL,
  `dtSubmitted` date DEFAULT NULL,
  `dtClosed` date DEFAULT NULL,
  `dtEstFinish` date NOT NULL,
  `strImageFilePath` varchar(255) DEFAULT NULL,
  `bitUrgent` int(1) DEFAULT '0',
  `bitMobileDisplay` tinyint(1) NOT NULL DEFAULT '0',
  `intUserId` int(11) DEFAULT NULL,
  `intEmployeeAssigned` int(11) DEFAULT NULL,
  `gpsLat` float NOT NULL,
  `gpsLong` float NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`intTicketId`),
  KEY `intUserId` (`intUserId`),
  KEY `intEmployeeAssigned` (`intEmployeeAssigned`),
  KEY `intTicketId` (`intTicketId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=184 ;

-- --------------------------------------------------------

--
-- Table structure for table `medals`
--

CREATE TABLE IF NOT EXISTS `medals` (
  `intMedalId` int(11) NOT NULL AUTO_INCREMENT,
  `strMedalName` varchar(30) NOT NULL,
  PRIMARY KEY (`intMedalId`),
  KEY `intMedalId` (`intMedalId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `medalsEarned`
--

CREATE TABLE IF NOT EXISTS `medalsEarned` (
  `intEarnedId` int(11) NOT NULL AUTO_INCREMENT,
  `intUserId` int(11) NOT NULL,
  `intMedalId` int(11) NOT NULL,
  PRIMARY KEY (`intEarnedId`),
  KEY `intUserId` (`intUserId`),
  KEY `intMedalId` (`intMedalId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `pushnotifications`
--

CREATE TABLE IF NOT EXISTS `pushnotifications` (
  `intNotificationId` int(5) NOT NULL AUTO_INCREMENT,
  `oneSignalId` varchar(50) NOT NULL,
  `strNotificationType` varchar(255) DEFAULT NULL,
  `strNotificationContent` varchar(255) DEFAULT NULL,
  `dtSentToUsers` date DEFAULT NULL,
  `dtReceivedFromAPI` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `intSevereWeatherAlertsSent` int(11) DEFAULT NULL,
  `strJSONMessage` varchar(1000) DEFAULT NULL,
  `strDateTime` varchar(100) NOT NULL,
  PRIMARY KEY (`intNotificationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=198 ;

-- --------------------------------------------------------

--
-- Table structure for table `pushnotifications_receivedby`
--

CREATE TABLE IF NOT EXISTS `pushnotifications_receivedby` (
  `intIndex` int(5) NOT NULL,
  `intNotificationId` int(5) DEFAULT NULL,
  `intUserId` int(5) DEFAULT NULL,
  PRIMARY KEY (`intIndex`),
  KEY `intUserId` (`intUserId`),
  KEY `intNotificationId` (`intNotificationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `securitylevels`
--

CREATE TABLE IF NOT EXISTS `securitylevels` (
  `intSecurityLevelId` int(5) NOT NULL,
  `strLevelDescription` varchar(255) DEFAULT NULL,
  `strSecurityTitle` varchar(255) DEFAULT NULL,
  `intEmployeeAssigned` int(5) DEFAULT NULL,
  `bitManageTickets` tinyint(1) NOT NULL,
  `bitManageUsers` tinyint(1) DEFAULT NULL,
  `bitSendNotifications` tinyint(1) DEFAULT NULL,
  `strSecurityLevel` text NOT NULL,
  PRIMARY KEY (`intSecurityLevelId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `securityQuestions`
--

CREATE TABLE IF NOT EXISTS `securityQuestions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `TABLE 12`
--

CREATE TABLE IF NOT EXISTS `TABLE 12` (
  `lat` varchar(18) DEFAULT NULL,
  `lon` decimal(30,12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `taskId` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(50) CHARACTER SET utf16 NOT NULL,
  `lastCompleted` varchar(30) NOT NULL,
  PRIMARY KEY (`taskId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `ticketnotes`
--

CREATE TABLE IF NOT EXISTS `ticketnotes` (
  `noteId` int(11) NOT NULL AUTO_INCREMENT,
  `intTicketId` int(11) DEFAULT NULL,
  `comment` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `intEmployeeId` int(11) NOT NULL,
  `dateAdded` date NOT NULL,
  PRIMARY KEY (`noteId`),
  KEY `intTicketId` (`intTicketId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=212 ;

-- --------------------------------------------------------

--
-- Table structure for table `tickettypes`
--

CREATE TABLE IF NOT EXISTS `tickettypes` (
  `intTypeId` int(11) NOT NULL,
  `strTicketType` varchar(255) DEFAULT NULL,
  `strTicketDescription` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`intTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `userActivities`
--

CREATE TABLE IF NOT EXISTS `userActivities` (
  `intActivityId` int(11) NOT NULL AUTO_INCREMENT,
  `intUserId` int(11) NOT NULL,
  `intActivityType` int(11) NOT NULL DEFAULT '2',
  `timeTotalDuration` time NOT NULL,
  `milesTotalDistance` float NOT NULL,
  `calTotalCalories` int(11) NOT NULL,
  `startDate` date NOT NULL,
  `startTime` time NOT NULL,
  `endDate` date NOT NULL,
  `endTime` time NOT NULL,
  PRIMARY KEY (`intActivityId`),
  KEY `intUserId` (`intUserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=697 ;

-- --------------------------------------------------------

--
-- Table structure for table `userActivitiesType`
--

CREATE TABLE IF NOT EXISTS `userActivitiesType` (
  `intTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `strActivity` varchar(50) NOT NULL,
  PRIMARY KEY (`intTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `intUserId` int(5) NOT NULL AUTO_INCREMENT,
  `strUsername` varchar(255) DEFAULT NULL,
  `strEncryptedPassword` varchar(255) DEFAULT NULL,
  `strEmailAddress` varchar(255) DEFAULT NULL,
  `strFirstName` varchar(255) DEFAULT NULL,
  `strLastName` varchar(255) DEFAULT NULL,
  `intAge` int(2) DEFAULT NULL,
  `intWeight` int(3) DEFAULT NULL,
  `intHeight` int(2) DEFAULT NULL,
  `strGender` varchar(255) DEFAULT NULL,
  `bitSendPictures` bit(1) DEFAULT NULL,
  `bitReceiveNotifications` bit(1) DEFAULT NULL,
  `intZipCode` int(5) DEFAULT NULL,
  `dtStartDate` date DEFAULT NULL,
  `dtBirthdate` date NOT NULL,
  `strLong` decimal(11,7) DEFAULT NULL,
  `strLat` decimal(11,7) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `accountLocked` int(11) NOT NULL,
  `userAvatarFilePath` varchar(500) DEFAULT '/Mobile_Connections/Images_userAvatars/default_avatar.png',
  PRIMARY KEY (`intUserId`),
  KEY `intUserId` (`intUserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1189 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`intSecurityLevel`) REFERENCES `securitylevels` (`intSecurityLevelId`);

--
-- Constraints for table `maintenancetickets`
--
ALTER TABLE `maintenancetickets`
  ADD CONSTRAINT `maintenancetickets_ibfk_2` FOREIGN KEY (`intEmployeeAssigned`) REFERENCES `employees` (`intEmployeeId`),
  ADD CONSTRAINT `maintenancetickets_ibfk_3` FOREIGN KEY (`intUserId`) REFERENCES `users` (`intUserId`);

--
-- Constraints for table `medalsEarned`
--
ALTER TABLE `medalsEarned`
  ADD CONSTRAINT `medalid_fk` FOREIGN KEY (`intMedalId`) REFERENCES `medals` (`intMedalId`),
  ADD CONSTRAINT `userid_fk` FOREIGN KEY (`intUserId`) REFERENCES `users` (`intUserId`);

--
-- Constraints for table `pushnotifications_receivedby`
--
ALTER TABLE `pushnotifications_receivedby`
  ADD CONSTRAINT `pushnotifications_receivedby_ibfk_1` FOREIGN KEY (`intUserId`) REFERENCES `users` (`intUserId`),
  ADD CONSTRAINT `pushnotifications_receivedby_ibfk_2` FOREIGN KEY (`intNotificationId`) REFERENCES `pushnotifications` (`intNotificationId`);

--
-- Constraints for table `ticketnotes`
--
ALTER TABLE `ticketnotes`
  ADD CONSTRAINT `ticketnotes_ibfk_1` FOREIGN KEY (`intTicketId`) REFERENCES `maintenancetickets` (`intTicketId`);

--
-- Constraints for table `userActivities`
--
ALTER TABLE `userActivities`
  ADD CONSTRAINT `userActivities_ibfk_1` FOREIGN KEY (`intUserId`) REFERENCES `users` (`intUserId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
