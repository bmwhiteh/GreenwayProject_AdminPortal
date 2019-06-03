<?php

 include("../MySQL_Connections/config.php");
 
 $displayName = $_GET['displayName'];
 $displayName = preg_replace("/[^a-zA-Z]/", " ", $displayName);
 setcookie("displayName", $displayName, time() + (86400 * 30), "/");

echo 1;                 
   ?>