<?php
    include("../MySQL_Connections/config.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST['feedback'];
    $feedback = mysqli_real_escape_string($conn, $feedback);
    $errorLocation = $_POST['errorLocation'];
    $date = date("Y/m/d");
    $resolved = 0;
     
    $sql = "INSERT INTO `feedback`(`strFeedback`,
    `strErrorLocation`, `dateReceived`, `bitResolved`)
    VALUES ('$feedback', '$errorLocation', '$date', '$resolved')";

    $result = $conn->query($sql) or die("Query fail");  

    date_default_timezone_set('UTC');
    $date = date('m/d/Y h:i:s a', time());
    $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '9'";
    $result = $conn->query($sql) or die("Update fail");
    
    header("location: /Management/appFeedback.php");
    }
?>
   