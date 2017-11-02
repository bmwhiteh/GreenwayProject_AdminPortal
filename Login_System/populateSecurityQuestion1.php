<?php 
include("../MySQL_Connections/config.php");

session_start();
$username = $_SESSION['user'];

$sql = "SELECT `securityQuestion1`FROM `employees`  where `strUsername` = '$username'";

$result = $conn->query($sql) or die("Query fail");

$row = $result->fetch_array(MYSQLI_ASSOC);
$active = $row['securityQuestion1'];

echo $active;
?>