<?php 
include("../MySQL_Connections/config.php");

$employeeId = $_POST['listOfUsers'];

$sql = "UPDATE `maintenancetickets` SET `intEmployeeAssigned` = NULL 
WHERE `intEmployeeAssigned` = '$employeeId'";

$result = $conn->query($sql) or die("Query 2 fail");
   
$sql = "UPDATE `ticketnotes` SET intEmployeeId = NULL WHERE intEmployeeId = '$employeeId'";	
$result = $conn->query($sql) or die("Query 3 fail");
    
$sql = "DELETE FROM `employees` WHERE `intEmployeeId`= $employeeId";
$result = $conn->query($sql) or die("Query 4 fail");

header("location: ./manageEmployees.php");
?>