<?php 
include("../MySQL_Connections/config.php");

$sql = "SELECT `intSevereWeatherAlertsSent`
  FROM `pushnotifications` where `strNotificationType` = 'Severe Weather'
 ORDER
    BY `intNotificationId` DESC
 LIMIT 1";

$result = $conn->query($sql) or die("Query fail");
    
$row = $result->fetch_array(MYSQLI_ASSOC);

$count =  $row['intSevereWeatherAlertsSent'];
echo $count;
?>