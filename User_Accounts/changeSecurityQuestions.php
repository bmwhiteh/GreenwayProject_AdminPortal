<?php
    //includes connection to the database
    include("../MySQL_Connections/config.php");
    //sets the username from the session user value
    session_start();
    $username = $_COOKIE['user'];
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $options = [
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
                                
        $id1 = $_POST['securityQuestion1'];
        $answer1 = $_POST['answer1'];
        $hashedanswer1 = password_hash($answer1, PASSWORD_BCRYPT, $options);
        $id2 = $_POST['securityQuestion2'];
        $answer2 = $_POST['answer2'];
        $hashedanswer2 = password_hash($answer2, PASSWORD_BCRYPT, $options);
        
        $sql = "UPDATE `employees` SET `securityQuestion1`= '$id1',`securityQuestion1Answer`= '$answer1',
        `securityQuestion2`= '$id2', `securityQuestion2Answer`= '$answer2' WHERE `strUsername` = '$username'";
        $sql = "UPDATE `employees` SET `securityQuestion1`= '$id1',`securityQuestion1Answer`= '$hashedanswer1',
        `securityQuestion2`= '$id2', `securityQuestion2Answer`= '$hashedanswer2' WHERE `strUsername` = '$username'";
        //sql execution
        $result = $conn->query($sql) or die("Query fail");
        echo $sql;
        //redirect to dashboard
        header("location: ../Dashboard_Pages/dashboard.php");
    }
?>