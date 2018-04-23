<?php
include("../MySQL_Connections/config.php");

$currentDate = strftime('%F');
$sql = "SELECT * FROM `users` WHERE `dtBirthdate` = '$currentDate'";
$result = $conn->query($sql) or die("Query fail");
while($row = $result->fetch_array(MYSQLI_ASSOC)){
    $age = $row['intAge'] + 1;
    $id = $row['intUserId'];
    $sql = "UPDATE `users` SET `intAge`= $age WHERE `intUserId` = $id";
    $result2 = $conn->query($sql) or die("Query fail 2");
}

date_default_timezone_set('UTC');
$date = date('m/d/Y h:i:s a', time());

$sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '13'";
$result = $conn->query($sql) or die("Update fail");
?>
