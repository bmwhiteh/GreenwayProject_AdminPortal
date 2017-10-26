DELETE FROM employees;
DELETE FROM maintenancetickets;
DELETE FROM pushnotifications;
DELETE FROM pushnotifications_receivedby;
DELETE FROM securitylevels;
DELETE FROM users;
DELETE FROM tickettypes;

/*Add Security Levels: must be added before employee entries for foreign key restraint*/
INSERT INTO securitylevels (intSecurityLevelId, strSecurityLevel, strSecurityTitle, strLevelDescription, bitAssignTickets, bitCloseTickets, bitCreateTickets)VALUES
(1, 	''Level 1'', 	''Administrator'', 	''Ability to add/remove portal users, edit customization, create/view/assign/edit all tickets'', 	1, 1, 1),
(2, 	''Level 2'', 	''Region Manager'', 	''Create/view/assign/edit all tickets, view all graphics, allow pictures sent by users'', 		1, 1, 1),
(3, 	''Level 3'', 	''Manager'', 			''Create/view/assign/edit all tickets, allow pictures sent by users, view region graphics'', 		1, 1, 1),
(4, 	''Level 4'', 	''Ranger'', 			''Create/view/edit all tickets'', 																1, 0, 1)
;

/*Add Employees*/
INSERT INTO employees (intEmployeeId, intSecurityLevel, strFirstName, strLastName, strEmailAddress, strUsername, strEncryptedPassword) VALUES
(1, 	1, 	''Admin'', 	''Admin'', 		''admin@admin.com'', 		''supadmin'', ''C@p$tone#''),
(2, 	2, 	''Bailey'', 	''Whitehill'', 	''bmwhiteh@gmail.com'', 	''bmwhiteh'', ''mypassword''),
(3, 	2, 	''Andrea'', 	''Moorman'', 		''email@gmail.com'', 		''amoorman'', ''password1''),
(4, 	3, 	''Connor'', 	''Julian'', 		''email@gmail.com'', 		''cjulian'', 	''password2''),
(5, 	3, 	''Brandon'', 	''Young'', 		''email@gmail.com'', 		''byoung'', 	''password4''),
(6, 	4, 	''Max'', 		''Fowler'', 		''email@gmail.com'', 		''mfowler'', 	''password3'')
;




/*Ticket Types*/
INSERT INTO `tickettypes` (`intTypeId`, `strTicketType`, `strTicketDescription`) VALUES
(1, 	''High Water'', 			''Flooding on Path''),
(2, 	''Pothole'', 				''Uneven or Broken Path''),
(3, 	''Tree/Branch'', 			''Branch/Tree blocking path''),
(4, 	''Trash Full'', 			''Trash can on path is full''),
(5, 	''Litter'', 				''There is litter on the path''),
(6, 	''Overgrown Brush'', 		''Foliage overhanging path''),
(7, 	''Vandalism'', 			''Something has been damaged by vandalism.''),
(8, 	''Suspicious Persons'', 	''There is a suspicious person on the path''),
(9, 	''Other'', 				''Anything not covered by other tickets'');



/*Users*/
INSERT INTO users (intUserId, strFirstName, strLastName, strUsername, strEncryptedPassword, strEmailAddress, intAge, intWeight,	intHeight, strGender, bitSendPictures, bitReceiveNotifications, intZipCode, dtStartDate)
VALUES
(1,		''Diane'',		''Davidson'',		''Ddavidson'',	''whK5ejze'',		''Ddavidson@gmail.com'',	45,	137,	69,	''Female'',	1,	0,	''46809'',	7/27/2017),
(2,		''Gwen'',			''Gray'',			''Ggray'',		''Dm4JVNmA'',		''Ggray@gmail.com'',		62,	189,	66,	''Female'',	1,	0,	''46805'',	8/5/2017),
(3,		''Clara'',		''Weber'',		''Cweber'',		''ftW79pyy'',		''Cweber@gmail.com'',		74,	160,	71,	''Female'',	1,	0,	''46819'',	8/9/2017),
(4,		''Kimberly'',		''Jensen'',		''KJensen'',		''aSv8qAXm'',		''KJensen@gmail.com'',	32,	184,	62,	''Female'',	1,	0,	''46801'',	8/18/2017),
(5,		''Sonja'',		''Higgins'',		''Shiggins'',		''NzzJeuKg'',		''Shiggins@gmail.com'',	68,	175,	76,	''Female'',	1,	0,	''46803'',	8/19/2017),
(6,		''Marcella'',		''Burton'',		''Mburton'',		''ckDYv2Tb'',		''Mburton@gmail.com'',	18,	227,	76,	''Female'',	1,	1,	''46802'',	8/23/2017),
(7,		''Orville'',		''Hart'',			''Ohart'',		''77NQWWjs'',		''Ohart@gmail.com'',		66,	222,	72,	''Male'',		1,	1,	''46815'',	9/6/2017),
(8,		''Sheldon'',		''Larson'',		''Slarson'',		''Sr4GK6aA'',		''Slarson@gmail.com'',	67,	199,	67,	''Male'',		1,	1,	''46804'',	9/7/2017),
(9,		''Stella'',		''Armstrong'',	''Sarmstrong'',	''QB6A5hjC'',		''Sarmstrong@gmail.com'',	58,	200,	69,	''Female'',	1,	1,	''46774'',	9/13/2017),
(10,	''Jose'',			''Adams'',		''Jadams'',		''CgUWRc65'',		''Jadams@gmail.com'',		21,	221,	60,	''Male'',		1,	1,	''46808'',	9/14/2017),
(11,	''Bradley'',		''Young'',		''Byoung'',		''WhQXzaeK'',		''Byoung@gmail.com'',		74,	175,	62,	''Male'',		1,	1,	''46845'',	9/17/2017),
(12,	''Kara'',			''Gardner'',		''Kgardner'',		''YrJLB9TZ'',		''Kgardner@gmail.com'',	67,	179,	65,	''Female'',	1,	1,	''46818'',	9/18/2017),
(13,	''Danny'',		''Mcdonald'',		''Dmcdonald'',	''5RPWxJ6z'',		''Dmcdonald@gmail.com'',	70,	223,	67,	''Male'',		0,	0,	''46825'',	9/23/2017),
(14,	''Isabel'',		''Ortiz'',		''Iortiz'',		''n82aXymV'',		''Iortiz@gmail.com'',		51,	170,	63,	''Female'',	0,	0,	''46816'',	9/28/2017),
(15,	''Deanna'',		''Davis'',		''Ddavis'',		''GFmfddgf'',		''Ddavis@gmail.com'',		16,	169,	66,	''Female'',	0,	0,	''46807'',	10/2/2017),
(16,	''Horace'',		''Cain'',			''Hcain'',		''j2qT2u8F'',		''Hcain@gmail.com'',		22,	238,	67,	''Male'',		0,	0,	''46815'',	10/11/2017),
(17,	''Jana'',			''Brady'',		''Jbrady'',		''RdjakUdh'',		''Jbrady@gmail.com'',		76,	222,	71,	''Female'',	0,	0,	''46835'',	10/12/2017),
(18,	''Darren'',		''Vasquez'',		''Dvasquez'',		''jjSsPshq'',		''Dvasquez@gmail.com'',	20,	139,	65,	''Male'',		0,	0,	''46850'',	10/22/2017),
(19,	''Alejandro'',	''Greer'',		''Agreer'',		''zK5V6XDa'',		''Agreer@gmail.com'',		79,	150,	72,	''Male'',		0,	0,	''46806'',	10/23/2017),
(20,	''Dennis'',		''Barnett'',		''Dbarnett'',		''2sa9Bgep'',		''Dbarnett@gmail.com'',	62,	158,	70,	''Male'',		0,	1,	''46802'',	10/30/2017),
(21,	''Wilbert'',		''Sparks'',		''Wsparks'',		''H3BFzwC8'',		''Wsparks@gmail.com'',	41,	211,	60,	''Male'',		0,	1,	''46815'',	11/2/2017),
(22,	''Ross'',			''Stokes'',		''Rstokes'',		''JUJ2qpdF'',		''Rstokes@gmail.com'',	41,	224,	70,	''Male'',		0,	1,	''46804'',	11/13/2017),
(23,	''Russell'',		''Mack'',			''Rmack'',		''BkR3zp4X'',		''Rmack@gmail.com'',		56,	128,	70,	''Male'',		0,	1,	''46774'',	11/16/2017),
(24,	''Andrew'',		''Osborne'',		''Aosborne'',		''E3aLkAgZ'',		''Aosborne@gmail.com'',	52,	204,	74,	''Male'',		0,	1,	''46808'',	12/6/2017),
(25,	''Leon'',			''Washington'',	''Kjensen'',		''5hAh2J95'',		''Kjensen@gmail.com'',	60,	131,	76,	''Male'',		0,	1,	''46845'',	12/21/2017)
;

/*Tickets*/
INSERT INTO maintenancetickets
(intTicketId, intUserId, intTypeId, bitUrgent, dtClosed, dtSubmitted, intEmployeeAssigned, strDescription, strImageFilePath, strTitle) VALUES
(1,	25,		6,	1,	8/14/2017,	8/1/2017,	6,	''Its grown so much this year that you cant see around it'', 	'''',		''The cherry tree is blocking the path''),
(2,	18,		3,	0,	8/16/2017,	8/2/2017,	5,	''You cant continue down the path'',							'''',		''A huge tree fell''),
(3,	4,		8,	1,	8/19/2017,	8/4/2017,	6,	''Ive seen someone following me on this section all week.'', 	'''',		''Same person all week''),
(4,	4,		7,	0,	8/21/2017,	8/6/2017,	2,	''It has someones initials and a heart'',						'''',		''Somebody spraypainted a bench''),
(5,	14,		6,	0,	8/23/2017,	8/7/2017,	6,	''I almost hit someone on my bike turning a corner'',			'''',		''Cut the bushes back!''),
(6,	3,		7,	1,	8/24/2017,	8/8/2017,	3,	''It has foul language'',										'''',		''Grafitti under the bridge''),
(7,	2,		5,	0,	8/27/2017,	8/9/2017,	2,	''I thought you patroled the paths'',							'''',		''There is litter everywhere''),
(8,	8,		3,	1,	8/28/2017,	8/20/2017,	4,	''Theres a huge tree in the way'',							'''',		''Tree blocking path''),
(9,	24,		8,	1,	9/7/2017,	8/21/2017,	4,	''I ran past them and got catcalls'',							'''',		''Group of guys loitering''),
(10, 15,	4,	0,	9/8/2017,	8/23/2017,	3,	''The squirrels are getting into the cans.'',					'''',		''The trash cans are full''),
(11, 9,		5,	0,	9/9/2017,	8/26/2017,	5,	''Please keep these paths clean'',							'''',		''This path is trashed''),
(12, 25,	4,	0,	9/12/2017,	9/7/2017,	3,	''These havent been cleaned in a month'',						'''',		''Do you ever empty these?''),
(13, 7,		8,	1,	9/13/2017,	9/8/2017,	5,	''It seems like someone set up camp in the woods next to the bridge, can someone check this out?'',	'''',		''Someone was living in the woods''),
(14, 7,		1,	0,	9/16/2017,	9/10/2017,	6,	''You need to block of the path'',							'''',		''The river is over the path''),
(15, 8,		1,	1,	9/17/2017,	9/14/2017,	2,	''Watch this area to make sure it stays safe'',				'''',		''There is flooding along the path''),
(16, 25,	6,	1,	9/22/2017,	9/17/2017,	4,	''The foliage is so low I have to duck on my bike'',			'''',		''I dont like running in the jungle''),
(17, 19,	5,	1,	9/24/2017,	9/24/2017,	2,	''There are beer cans and chip bags everywhere'',				'''',		''Somebody mustve had a party''),
(18, 1,		2,	1,	9/29/2017,	9/25/2017,	6,	''Almost broken my bike'', 									'''',		''Potholes everywhere!''),
(19, 11,	4,	0,	10/8/2017,	10/1/2017,	1,	''IT SMELLS AWFUL'',											'''',		''TOO MUCH TRASH''),
(20, 20,	5,	0,	10/10/2017,	10/5/2017,	2,	''The picnic tables are covered in trash'',					'''',		''Somebody didnt clean up their picnic''),
(21, 14,	4,	0,	10/16/2017,	10/8/2017,	4,	''The animals are getting into it'',							'''',		''The trash is overflowing''),
(22, 18,	6,	0,	10/17/2017,	10/12/2017,	5,	''I almost stepped in it'',									'''',		''Poison Ivy next to the path''),
(23, 15,	1,	0, 10/22/2017,	10/15/2017,	5,	''Close the path'',											'''',		''It rained so much theres a river dividing the path''),
(24, 13,	3,	1,	10/24/2017,	10/16/2017,	4,	''Its like walking on eggshells'',							'''',		''There are sticks everywhere''),
(25, 4,		6,	1,	10/31/2017,	10/25/2017,	1,	''I collided with someone when I turned a corner'',			'''',		''Theres brush blocking my line of sight''),
(26, 8,		2,	1,	10/20/2017,	10/14/2017,	6,	''This is ridiculous'',										'''',		''I sprained my ankle in a pothole''),
(27, 22,	8,	0,	10/29/2017,	10/15/2017,	6,	''He tried grabbing my kid as I was getting everyone in the car at the trailhead'', '''',''Older man tried to grab my kid''),
(28, 7,		5,	1,	10/30/2017,	10/23/2017,	2,	''It looks like a trash can spilled'',						'''',		''The storm threw trash everywhere''),
(29, 14,	7,	0,	8/3/2017,	8/1/2017,	2,	''The place is trashed'',										'''',		''Hooligans made a mess''),
(30, 19,	9,	1,	8/6/2017,	8/3/2017,	1,	''I saw a small dog on the path by itself but it wouldnt come to me.'',	'''',		''Stray Animal Spotted''),
(31, 18,	4,	0,	8/8/2017,	8/4/2017,	5,	''Did something die in here?'',								'''',		''The trash smells like dead animal''),
(32, 23,	7,	1,	8/10/2017,	8/7/2017,	4,	''Theres spray paint all of the map'',						'''',		''The maps have been vandalised''),
(33, 13,	2,	0,	8/18/2017,	8/9/2017,	2,	''I dont want to fall'',										'''',		''Fix the Potholes!''),
(34, 18,	8,	0,	8/20/2017,	8/10/2017,	5,	''He was acting weird and not going anywhere'',				'''',		''Guy loitering under the bridge''),
(35, 10,	7,	0,	8/28/2017,	8/11/2017,	5,	''Somebody broken it and its hanging at an odd angle'',		'''',		''The closed path marker is broken''),
(36, 4,		7,	0,	8/29/2017,	8/26/2017,	6,	''The railing is bent in a strange angle'',					'''',		''Messed up railing''),
(37, 21,	9,	0,	8/31/2017,	8/28/2017,	4,	''I saw a fox walking the path in the early morning hours'',	'''',		''Wild Animal Spotted''),
(38, 22,	8,	1,	9/3/2017,	9/2/2017,	3,	''He tried convincing me to come back with him'',				'''',		''Guy offered me candy''),
(39, 17,	1,	0,	9/7/2017,	9/5/2017,	1,	''Somebody could get swept away'',							'''',		''Too much water!''),
(40, 21,	9,	1,	9/8/2017,	9/8/2017,	4,	''SOMEBODY RODE PAST ME ON A MOTORCYCLE'',					'''',		''Motorcycle on path''),
(41, 24,	6,	1,	9/11/2017,	910/2017,	4,	''The leaves make the path slippery for riding my bike'',		'''',		''The brush is covering the path''),
(42, 1,		5,	1,	9/13/2017,	9/12/2017,	6,	''There are bees and beer cans on the tables'',				'''',		''The picnic area is very messy''),
(43, 3,		1,	1,	9/18/2017,	9/15/2017,	6,	''Why isnt the path closed for high water?'',					'''',		''Flooded Path not closed''),
(44, 21,	2,	1,	9/28/2017,	9/19/2017,	6,	''Please fix this soon'',										'''',		''The path is broken and unsafe''),
(45, 4,		9,	0,	10/1/2017,	9/23/2017,	4,	''It seemed like someone was trying to do a drug deal under the maplecrest bridge'',	'''',		''Possible Drug Deal''),
(46, 23,	2,	0,	10/3/2017,	9/28/2017,	2,	''The path is too bumpy'',									'''',		''I need a mountain bike for this!''),
(47, 23,	7,	1,	10/4/2017,	10/1/2017,	2,	''Its broken and tilted'', 									'''',		''Broken benches''),
(48, 18,	8,	0,	10/5/2017,	10/2/2017,	4,	''She wouldnt quit pestering me to go somewhere with her'',	'''',		''Random girl wouldnt leave me alone''),
(49, 9,		8,	0,	10/6/2017,	104/2017,	5,	''He seems to be living under the bridge'',					'''',		''There was a squatter near the path''),
(50, 12, 	8,	1,	10/10/2017,	10/11/2017,	4,	''I felt like I was being followed while riding my bike on the path'', '''',		''Someone was following me'')
