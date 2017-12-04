<?php

session_start();
//includes the database connection
include("../MySQL_Connections/config.php");

//checks if a post occurred
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form

//gets the username and password from user input
    $myusername = mysqli_real_escape_string($conn, $_POST['uname']);
    $mypassword = mysqli_real_escape_string($conn, $_POST['psw']);

//sql to check if username and password match
    $sql = "SELECT intEmployeeID FROM employees WHERE strUsername = '$myusername' and strEncryptedPassword = '$mypassword'";

//executs query
    $result = $conn->query($sql) or die("Query fail");
//counts rows returned 
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $active = $row['active'];

    $count =  $result->num_rows;
    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
        $_SESSION["authenticated"] = true;
        //sets cookie
        setcookie("user", $myusername, time() + (86400 * 30), "/"); // 86400 = 1 day
        //redirects to dashboard
        header("location: ../Dashboard_Pages/dashboard.php");
    }else{
        //provides error message and redirects to login page
        $error = "Your Login Name or Password is invalid";
        echo "<script type='text/javascript'>alert('$error');</script>";
        header( "refresh:0 ;url=login.html" );
    }
}
?>
