<?php 
include("../MySQL_Connections/config.php");

$userId = $_POST['id'];
$sql = "UPDATE `firebaseusers` SET `bitSendPics`= 0 WHERE `userId`= '$userId'";
echo $sql;
$result = $conn->query($sql) or die("Query fail");
header("location: ./manageUsers.php");
?>