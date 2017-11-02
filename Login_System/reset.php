<?php
    include("../MySQL_Connections/config.php");
    
    session_start();
    $username = $_SESSION['user'];
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];
    
    if($newPassword == $confirmNewPassword){
        $sql = "UPDATE `employees` SET `strEncryptedPassword`= '$newPassword' WHERE `strUsername` = '$username'";
        $result = $conn->query($sql) or die("Query fail"); 
        header("location: ./login.html");
    }else{
        echo "Your passwords do not match!";
    }
    }
?>
   