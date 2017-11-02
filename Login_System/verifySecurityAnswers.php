<?php

include("../MySQL_Connections/config.php");

session_start();
$username = $_SESSION['user'];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    $answer1 = $_POST['answer1'];
    $answer2 = $_POST['answer2'];

    echo $answer1;
    echo $answer2;
    $sql = "SELECT * FROM `employees` WHERE `strUsername` = '$username' && `securityQuestion1Answer`= '$answer1' && `securityQuestion2Answer` = '$answer2'";

    $result = $conn->query($sql) or die("Query fail");
    
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $active = $row['active'];

    $count =  $result->num_rows;
    echo $count;
    if($count == 1) {
        header("location: ./passwordReset.php");
    }else{
        $error = "Your answers are incorrect";
        echo $error;
    }
}

?>