<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Dashboard_Pages/nav.css">
    <link rel="shortcut icon" href="../Dashboard_Pages/favicon.ico" type="image/x-icon">
</head>
<?php require_once("../Login_System/verifyAuth.php"); ?>
<body>
    <?php include "../User_Accounts/changePassword.php"?>
<div class="container">
<div class="logo">
    <img src="../images/ViridianBanner3.png" width="100%" height="150px"/>
</div>
<?php include "../User_Accounts/userProfile.php"; ?>

<div class="navigation">
    <nav>
        <ul >
            <li><a href="../Dashboard_Pages/dashboard.php">Home</a></li>

            <li class="dropdown">
                <a href="#" class="dropbtn">Heat Map</a>
                <div class="dropdown-content">
                    <a href="../Heat_Maps/user_activities.php">User Activities</a>
                    <a href="../Heat_Maps/ticket_density.php">Ticket Density</a>
                </div>
            </li>

            <li class="dropdown">
                <a href="#" class="dropbtn">Analytics</a>
                <div class="dropdown-content">
                    <a href="../Data_Analytics/tracked_activities.php">Tracked Activities</a>
                    <a href="../Data_Analytics/user_information.php">User Information</a>
                    <a href="../Data_Analytics/maintenance_information.php">Maintenance Tickets</a>
                </div>
            </li>

            <li class="dropdown">
                <a href="#" class="dropbtn">Tickets</a>
                <div class="dropdown-content">
                    <a href="../Ticket_System_v2/ticket_table_cards.php?tickets=open">Open Tickets</a>
                    <a href="../Ticket_System_v2/ticket_table_cards.php?tickets=closed">Closed Tickets</a>
                </div>
            </li>

            <li><a href="../Calendar/calendar.php">Calendar</a></li>
            <li><a href="../Push_Notifications/notifications.php">Push Notifications</a></li>
            <li><a href="../Scheduled_Tasks/tasks.php">Tasks</a></li>

            <li style="float:right"><a href="../Dashboard_Pages/logout.php">Log Out</a></li>
            <li style="float:right"><a onclick="openNav()">User Profile</a></li>
            
            <li style="float:right;"><a href="../Management/manageUsers.php" style="float:right">Manage Users</a></li>
           
        </ul>
    </nav>
</div>
</div>
</body>
</html>