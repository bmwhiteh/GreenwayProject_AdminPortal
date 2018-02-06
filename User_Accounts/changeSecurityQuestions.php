<?php
    //includes connection to the database
    include("../MySQL_Connections/config.php");
    //sets the username from the session user value
    session_start();
    $username = $_COOKIE['user'];
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $id1 = $_POST['securityQuestion1'];
        $answer1 = $_POST['answer1'];
        $id2 = $_POST['securityQuestion2'];
        $answer2 = $_POST['answer2'];
        
        $sql = "UPDATE `employees` SET `securityQuestion1`= '$id1',`securityQuestion1Answer`= '$answer1',
        `securityQuestion2`= '$id2', `securityQuestion2Answer`= '$answer2' WHERE `strUsername` = '$username'";
        //sql execution
        $result = $conn->query($sql) or die("Query fail");
        echo $sql;
        //redirect to dashboard
        header("location: ../Dashboard_Pages/dashboard.php");
    }
?>