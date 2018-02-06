<?php

//sets a variable to the user Cookie
$cookie = $_COOKIE['user'];
//if the cookie does not exist, redirect to the login page 
if(!isset($cookie)){
   header("location: /Login_System/login.php"); 
}
?>