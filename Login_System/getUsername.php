<?php

session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['uname'];
    $_SESSION['user'] = $username;
    header("location: ./securityQuestions.php");
    }
?>
   