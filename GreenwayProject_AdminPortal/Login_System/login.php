<?php

session_start();
include("../MySQL_Connections/config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    $myusername = $_POST['uname'];
    $mypassword = $_POST['psw'];

    $sql = "SELECT intEmployeeID FROM employees WHERE strUsername = '$myusername' and strEncryptedPassword = '$mypassword'";

    $result = $conn->query($sql) or die("Query fail");
    
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $active = $row['active'];

    $count =  $result->num_rows;
    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
       // session_register("myusername");
        $_SESSION['login_user'] = $myusername;
        header("location: /GreenwayProject_AdminPortal/Dashboard_Pages/dashboard.php");
    }else{
        $error = "Your Login Name or Password is invalid";
        echo $error;
    }
}
?>
