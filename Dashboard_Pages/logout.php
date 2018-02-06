<?php

// setcookie("user", "", 1 , $path);
 setcookie('user', '', time() - 3600, "/");
 session_destroy();
 header("location: ../Login_System/login.php");
?>