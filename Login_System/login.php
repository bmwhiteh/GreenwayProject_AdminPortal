<?php

session_start();
include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

    $myusername = mysqli_real_escape_string($conn,$_POST['uname']);
    $mypassword = mysqli_real_escape_string($conn,$_POST['psw']);

    $sql = "SELECT intEmployeeID FROM employees WHERE strUsername = '$myusername' and strPassword = '$mypassword'";

    $result = mysqli_query($conn,$sql) or die("Query fail");
    echo $sql;
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $active = $row['active'];

    $count = mysqli_num_rows($result);
    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
       // session_register("myusername");
        $_SESSION['login_user'] = $myusername;
        header("location: /GreenwayProject_AdminPortal/Dashboard_Pages/dashboard.php");
    }else {
        $error = "Your Login Name or Password is invalid";
    }
}
?>