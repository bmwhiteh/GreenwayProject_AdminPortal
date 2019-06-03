<?php 
include("../MySQL_Connections/config.php");

$userId = $_POST['id'];
$sql = "UPDATE `firebaseusers` SET `bitSendPics`= 1 WHERE `userId`= '$userId'";

$result = $conn->query($sql) or die("Query fail");
header("location: ./manageUsers.php");
?>