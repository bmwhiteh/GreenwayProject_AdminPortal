<?php 
include("../MySQL_Connections/config.php");

$userId = $_POST['id'];
$sql = "UPDATE `users` SET `bitSendPictures`= 1 WHERE `intUserId`= '$userId'";

$result = $conn->query($sql) or die("Query fail");
header("location: ./manageUsers.php");
?>