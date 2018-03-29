<?php 

include("../MySQL_Connections/config.php");
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        
    $message = $_GET['message'];
    $date = $_GET['dtSend'];
    $type = $_GET['strNotificationType'];
    
    $sql = "SELECT * FROM `users` WHERE `bitReceiveNotifications` = 1";
    $result = $conn->query($sql) or die("Query fail");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $active = $row['active'];
    $usersReceivingNotifications =  $result->num_rows;
     
    $sql = "INSERT INTO `pushnotifications` (`intNotificationId`, `strNotificationType`, `strNotificationContent`, `dtSentToUsers`, `dtReceivedFromAPI`, `intUsersSentTo`, `strJSONMessage`)
    VALUES ( '' , '".$type."', ' '  , '".$date."' , NULL, '".$usersReceivingNotifications."', '".$message."');";

    $result = $conn->query($sql) or die("Query fail");  
    header("location: /Push_Notifications/notifications.php");
    }

?>