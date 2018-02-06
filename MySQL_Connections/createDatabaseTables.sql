
/*pushNotifications_ReceivedBy has foreign keys in Users and pushNotifications*/
/*employees has foreign key in securityLevels*/
/*maintenanceTickets has foreign key in Users*/
DROP TABLE IF EXISTS Viridian_Capstone_Project.pushNotifications_ReceivedBy;
DROP TABLE IF EXISTS Viridian_Capstone_Project.employees;
DROP TABLE IF EXISTS Viridian_Capstone_Project.maintenanceTickets;

DROP TABLE IF EXISTS Viridian_Capstone_Project.Users;
DROP TABLE IF EXISTS Viridian_Capstone_Project.pushNotifications;
DROP TABLE IF EXISTS Viridian_Capstone_Project.securityLevels;


DROP DATABASE IF EXISTS Viridian_Capstone_Project;

/*Create the database for Viridian Admin Portal*/
CREATE DATABASE IF NOT EXISTS Viridian_Capstone_Project;

/*Tell MySQL to use Viridian_Capstone_Project*/
USE Viridian_Capstone_Project;

/*Create Users Table*/
CREATE TABLE  IF NOT EXISTS Users (
    intUserId int(5) NOT NULL,
    strUsername varchar(255), 
    strEncryptedPassword varchar(255),
    strEmailAddress varchar(255),
    strFirstName varchar(255),
    strLastName varchar(255),
    intAge int(2), /*2 Digits for Age*/
    intWeight int(3), /*3 Digits for Weight (whole numbers only)*/
    intHeight int(2), /*2 Digits for Height (must be saved in inches)*/
    strGender varchar(255),
    intActivityTrackedId int(5), /*Running Total of how many activities they've tracked*/
    intTicketsSubmittedId int(5), /*Running Total of how many tickets they've submitted*/
    bitSendPictures bit,
    bitReceiveNotifications bit,
    intZipCode int(5),
    dtStartDate date,
     PRIMARY KEY (intUserId)
);

/*Create Push Notifications Table*/
CREATE TABLE  IF NOT EXISTS pushNotifications(
	intNotificationId int(5) NOT NULL,
    strNotificationType varchar(255),
    strNotificationContent varchar(255),
    dtSentToUsers date,
    dtReceivedFromAPI date,
    intUsersSentTo int,
    strJSONMessage varchar(1000),
    PRIMARY KEY (intNotificationId)

);

/*Create Table to see what notifications were sent to what users*/
CREATE TABLE  IF NOT EXISTS pushNotifications_ReceivedBy(
	intIndex int(5) NOT NULL,    
    intNotificationId int(5),
    intUserId int(5),
    PRIMARY KEY (intIndex),
    FOREIGN KEY (intUserId) REFERENCES Users(intUserId),
    FOREIGN KEY (intNotificationId) REFERENCES pushNotifications(intNotificationId)
);

/*Create security Level Table*/
CREATE TABLE IF NOT EXISTS securityLevels(
	intSecurityLevelId int(5) NOT NULL,
	  strSecurityLevel varchar(10),
    strLevelDescription varchar(255),
    strSecurityTitle varchar(255),
    intEmployeeAssigned int(5),
    bitAssignTickets bit,
    bitCloseTickets bit,
    bitCreateTickets bit,
    PRIMARY KEY (intSecurityLevelId)
);

/*Create Employees Table*/
CREATE TABLE IF NOT EXISTS employees (
	intEmployeeId int(5) NOT NULL,
    strFirstName varchar(255),
    strLastName varchar(255),
    strUsername varchar(255),
    strEncryptedPassword varchar(255),
    intSecurityLevel int(5), /*level descriptions listed in dbo.security_levels*/
    strEmailAddress varchar(255),
    PRIMARY KEY (intEmployeeId),
    FOREIGN KEY (intSecurityLevel) REFERENCES securityLevels(intSecurityLevelId)
);




/*Create Tickets Table*/
CREATE TABLE IF NOT EXISTS maintenancetickets (
	intTicketId int NOT NULL,
    strTitle varchar(255),
    strType varchar(255),
    strDescription varchar(255),
    dtSubmitted date,
    dtClosed date,
    strImageFilePath varchar(255),
    bitUrgent bit,
    intUserId int,
    intEmployeeAssigned int,
    PRIMARY KEY (intTicketId),
    FOREIGN KEY (intUserId) REFERENCES Users(intUserId),
    FOREIGN KEY (intEmployeeAssigned) REFERENCES employees(intEmployeeId)

);

CREATE TABLE IF NOT EXISTS tickettypes (
  intTypeId int(11) NOT NULL,
  strTicketType varchar(255) DEFAULT NULL,
  strTicketDescription varchar(255) DEFAULT NULL,
  PRIMARY KEY (intTypeId)
);

CREATE TABLE IF NOT EXISTS TicketNotes(
    noteId int,
    intTicketId int ,
    comment varchar(256),
    PRIMARY KEY(noteId),
    FOREIGN KEY (intTicketId) REFERENCES maintenancetickets(intTicketId)
);