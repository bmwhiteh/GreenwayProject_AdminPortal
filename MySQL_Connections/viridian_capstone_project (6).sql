-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2018 at 11:03 PM
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

--
-- Dumping data for table `colorSchemes`
--

INSERT INTO `colorSchemes` (`colorId`, `name`, `colorCssLink`, `bannerCssLink`, `active`, `colorArray`) VALUES
(1, 'Viridian', '/css/viridian.css', '/images/ViridianBanner.png', 1, '#75BBB8,#107A76,#443020,#C8681B,#432021,#3DB737,#FD9EA1,#C61A1F,#FFCA9F'),
(2, 'Atlantean', '/css/atlantean.css', '/images/AtlanteanBanner.png', 0, '#77be74'),
(3, 'Carmine', '/css/carmine.css', '/images/CarmineBanner.png', 0, '#77be74'),
(4, 'Daybreak', '/css/daybreak.css', '/images/DaybreakBanner.png', 0, '#77be74'),
(5, 'Sangria', '/css/sangria.css', '/images/SangriaBanner.png', 0, '#77be74'),
(6, 'Sapphire', '/css/sapphire.css', '/images/SapphireBanner.png', 0, '#77be74');

--
-- Dumping data for table `medals`
--

INSERT INTO `medals` (`intMedalId`, `strMedalName`) VALUES
(1, 'Starting Strong'),
(2, 'Push It to the Limit'),
(3, 'Stop and Smell the Roses'),
(4, 'Nomad'),
(5, 'Trail Fanatic'),
(6, 'Wheels of Steel'),
(7, 'Burning Rubber '),
(8, 'The Long Haul'),
(9, 'Neighborhood Watch'),
(10, 'Wayfinder'),
(11, 'Feel the Burn');

--
-- Dumping data for table `securitylevels`
--

INSERT INTO `securitylevels` (`intSecurityLevelId`, `strLevelDescription`, `strSecurityTitle`, `intEmployeeAssigned`, `bitManageTickets`, `bitManageUsers`, `bitSendNotifications`, `strSecurityLevel`) VALUES
(1, 'Ability to add/remove portal users, edit customization, create/view/assign/edit all tickets', 'Administrator', NULL, 1, 1, 1, 'Level 1'),
(2, 'Create/view/assign/edit all tickets, allow pictures sent by users, view region graphics', 'Manager', NULL, 1, 0, 1, 'Level 2'),
(3, 'Create/view/edit all tickets', 'Ranger', NULL, 1, 0, 0, 'Level 3');

--
-- Dumping data for table `securityQuestions`
--

INSERT INTO `securityQuestions` (`id`, `question`) VALUES
(1, 'What was the name of your childhood pet?'),
(2, 'What is your mother''s maiden name?'),
(3, 'What city were you born in?'),
(4, 'Where did you graduate high school?'),
(5, 'What is the name of the first person you kissed?'),
(6, 'What was the name of your elementary school?'),
(7, 'In what city does your nearest sibling live?'),
(8, 'What is your middle name?');

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`taskId`, `task`, `lastCompleted`) VALUES
(1, 'Mobile Account Created', '04/06/2018 12:11:36 am'),
(2, 'Admin Portal Account Created', '04/03/2018 07:24:36 pm'),
(3, 'Walking Activity Tracked', '04/08/2018 12:11:10 am'),
(4, 'Running Activity Tracked', '04/06/2018 10:58:35 am'),
(5, 'Biking Activity Tracked', '04/05/2018 10:33:15 pm'),
(6, 'Maintenance Ticket Submitted', '04/06/2018 12:33:05 am'),
(7, 'Maintenance Ticket Assigned', '04/03/2018 07:17:02 pm'),
(8, 'Maintenance Ticket Closed', '04/03/2018 07:10:31 pm'),
(9, 'App Feedback Submitted', '2018-04-06 12:40:14 am'),
(10, 'Check for New Weather Alerts', '04/03/2018 10:38:30 pm'),
(11, 'Weather Notification Sent', '04/03/2018 10:38:30 pm'),
(12, 'Notification Scheduled', '2018-04-03 09:32:23 pm'),
(13, 'Update Birthdays', '03/10/2018 04:11:46 am');

--
-- Dumping data for table `tickettypes`
--

INSERT INTO `tickettypes` (`intTypeId`, `strTicketType`, `strTicketDescription`) VALUES
(1, 'High Water', 'Flooding on Path'),
(2, 'Pothole', 'Uneven or Broken Path'),
(3, 'Tree/Branch', 'Branch/Tree blocking path'),
(4, 'Trash Full', 'Trash can on path is full'),
(5, 'Litter', 'There is litter on the path'),
(6, 'Overgrown Brush', 'Foliage overhanging path'),
(7, 'Vandalism', 'Something has been damaged by vandalism.'),
(8, 'Suspicious Persons', 'There is a suspicious person on the path'),
(9, 'Other', 'Anything not covered by other tickets');

--
-- Dumping data for table `userActivitiesType`
--

INSERT INTO `userActivitiesType` (`intTypeId`, `strActivity`) VALUES
(1, 'RUN'),
(2, 'WALK'),
(3, 'BIKE'),
(4, 'JOG');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
