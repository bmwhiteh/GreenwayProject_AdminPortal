<?php 
include("../MySQL_Connections/config.php");

session_start();
$username = $_SESSION['user'];

$sql = "SELECT `securityQuestion2`FROM `employees`  where `strUsername` = '$username'";

$result = $conn->query($sql) or die("Query fail");

$row = $result->fetch_array(MYSQLI_ASSOC);
$active = $row['securityQuestion2'];

echo $active;
?>