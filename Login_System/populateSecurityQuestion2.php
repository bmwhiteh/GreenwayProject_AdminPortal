<?php 
//includes database connection
include("../MySQL_Connections/config.php");

session_start();
//sets the username from the session user value
$username = $_SESSION['user'];

//sql to retrieve security question two
$sql = "SELECT `question` from securityQuestions where `id` = ( SELECT `securityQuestion2` FROM `employees` WHERE `strUsername`= '$username')";
//sql execution
$result = $conn->query($sql) or die("Query fail");

$row = $result->fetch_array(MYSQLI_ASSOC);
$active = $row['question'];
//displays question on page
echo $active;
?>