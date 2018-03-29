<?php 
include("../MySQL_Connections/config.php");

$userId = $_POST['id'];
$sql = "UPDATE `users` SET `bitSendPictures`= 0 WHERE `intUserId`= '$userId'";
echo $sql;
$result = $conn->query($sql) or die("Query fail");
header("location: ./manageUsers.php");
?>