<?php 
include("../MySQL_Connections/config.php");

$username = $_GET['username'];
$sql = "UPDATE `employees` SET `accountLocked`= '0',`loginAttempts`= '0',
`securityQuestionAttempts`= '0', `activeUser`= '1'
WHERE `strUsername`= '$username'";

$result = $conn->query($sql) or die("Query fail");
header("location: ./manageUsers.php");
?>