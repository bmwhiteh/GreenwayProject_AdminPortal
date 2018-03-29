<?php
include("../MySQL_Connections/config.php");
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $securityLevel = $_POST['intSecurityLevel'];
    $employeeId = $_POST['listOfUsers'];
    
    $sql = "UPDATE `employees` SET `strFirstName`= '$firstName',`strLastName`= 
    '$lastName',`strEmailAddress`= '$email', `intSecurityLevel` = '$securityLevel'
    WHERE `intEmployeeId`= '$employeeId'";
    
    $resultset = $conn->query($sql) or die("Query fail");
    header("location: ../Management/manageEmployees.php");
}
?>
