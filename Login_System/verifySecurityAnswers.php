<?php

//include connection to database 
include("../MySQL_Connections/config.php");

session_start();
//sets the username variable to the session user value
$username = $_SESSION['user'];

//checks if a post occurs
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    $answer1 = mysqli_real_escape_string($conn, $_POST['answer1']);
    $answer2 = mysqli_real_escape_string($conn, $_POST['answer2']);

//sql to verify security answers from user input
    $sql = "SELECT * FROM `employees` WHERE `strUsername` = '$username' && `securityQuestion1Answer`= '$answer1' && `securityQuestion2Answer` = '$answer2'";
//sql execution
    $result = $conn->query($sql) or die("Query fail");
    
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $active = $row['active'];

    $count =  $result->num_rows;

    if($count == 1) {
        //if security answers match, redirect to the passwordReset.php
        header("location: ./passwordReset.php");
    }else{
        //displays error message and redirects to the securityQuestions.php
        $error = "Your answers are incorrect";
        echo "<script type='text/javascript'>alert('$error');</script>";
        header( "refresh:.000001 ;url=securityQuestions.php" );
    }
}

?>