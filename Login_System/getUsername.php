<?php

//includes the database connection
include("../MySQL_Connections/config.php");
session_start();

//checks to verify that a post occurred
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    
//gets username from user input
    $username = mysqli_real_escape_string($conn, $_POST['uname']);
//sets session variable user
    $_SESSION['user'] = $username;
//redirects to the securityQuestions page
    header("location: ./securityQuestions.php");
    }
?>
   