<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../fonts/style.css">
    <link rel="stylesheet" type="text/css" href="../Dashboard_Pages/nav.css">
    <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>
    <link rel="shortcut icon" href="../Dashboard_Pages/favicon.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    
</head>
<?php require_once("../Login_System/verifyAuth.php"); ?>

<body>
<div class="container">
<div class="logo">
    <img src=<?php echo $_COOKIE['bannerLink']; ?> width="100%" height="100%"/>
</div>

<div class="navigation">
     <?php 
    include("../MySQL_Connections/config.php");
    include "../User_Accounts/userProfile.php";  
    include "../Color_Switch/chooseColor.php";
?>
    <nav>
        <ul>
            <li><a href="../Dashboard_Pages/dashboard.php" class="navBar">Home</a></li>

            <li class="dropdown" class="navBar">
                <a href="#" class="dropbtn">Heat Map</a>
                <div class="dropdown-content">
                    <a href="../Heat_Maps/user_activities.php" class="navBar">User Activities</a>
                    <a href="../Heat_Maps/ticket_density.php" class="navBar">Ticket Density</a>
                </div>
            </li>

            <li class="dropdown" class="navBar">
                <a href="#" class="dropbtn">Analytics</a>
                <div class="dropdown-content">
                    <a href="../Data_Analytics/tracked_activities.php" class="navBar">Tracked Activities</a>
                    <a href="../Data_Analytics/user_information.php" class="navBar">User Information</a>
                    <a href="../Data_Analytics/maintenance_information.php" class="navBar">Maintenance Tickets</a>
                    <a href="../Data_Analytics/medalRack.php" class="navBar">Medal Rack</a>
                </div>
            </li>

            <li class="dropdown" class="navBar">
                <a href="#" class="dropbtn">Tickets</a>
                <div class="dropdown-content">
                    <a href="../Ticket_System_v2/ticket_table_header.php" class="navBar">View Tickets</a>
                    <a href="../Ticket_System_v2/ticket_assignments.php" class="navBar">Assign Tickets</a>

                </div>
            </li>

            <li><a href="../Calendar/calendar.php" class="navBar">Calendar</a></li>
            <li><a href="../Push_Notifications/notifications.php" class="navBar">Push Notifications</a></li>
            <li><a href="../Scheduled_Tasks/tasks.php" class="navBar">Tasks</a></li>

            <li style="float:right"><a href="../Dashboard_Pages/logout.php" class="navBar">Log Out</a></li>
            <li style="float:right"><a onclick="openNav()" class="navBar">User Profile</a></li>
            
            <?php 
            $user = $_COOKIE['user'];
            $sql = "SELECT * FROM `employees` WHERE `intSecurityLevel` = 1 && `strUsername` = '$user'";
            $result = $conn->query($sql) or die("Query fail");
    
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $count =  $result->num_rows;
            if($count == 1){
            ?>
            
            <li class="dropdown" style="float:right;" class="navBar">
                <a href="#" class="dropbtn">Management</a>
                <div class="dropdown-content">
                    <a href="../Management/manageEmployees.php" class="navBar">Manage Employees</a>
                    <a href="../Management/manageUsers.php" class="navBar">Manage Users</a>
                    <a href="../Management/appFeedback.php" class="navBar">App Feedback</a>
                    <a onclick="openChangeColor()" class="navBar">Change Color Scheme</a>
                </div>
            </li>
            <?php 
            }
            ?>
        </ul>
    </nav>
   
</div>
</div>
</body>
</html>