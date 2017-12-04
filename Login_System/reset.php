<?php
//includes connection to the database
    include("../MySQL_Connections/config.php");
    
    session_start();
    //sets the username from the session user value
    $username = $_SESSION['user'];
    
    //checks if a post has occurred
    if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //sets values of newPassword and confirmNewPassword from user input   
    $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
    $confirmNewPassword = mysqli_real_escape_string($conn, $_POST['confirmNewPassword']);
    
    //checks if values match
    if($newPassword == $confirmNewPassword){
        //sql to update users password
        $sql = "UPDATE `employees` SET `strEncryptedPassword`= '$newPassword' WHERE `strUsername` = '$username'";
        //sql execution
        $result = $conn->query($sql) or die("Query fail"); 
        //redirect to login
        header("location: ./login.html");
    }else{
        //displays error message and redirects to passwordReset page
        $error = "Your passwords do not match!";
        echo "<script type='text/javascript'>alert('$error');</script>";
        header( "refresh:.000000001 ;url=passwordReset.php" );
    }
    }
?>
   