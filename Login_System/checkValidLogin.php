<?php

 include("../MySQL_Connections/config.php");
 
 $userId = $_GET['userId'];
 setcookie("user", $userId, time() + (86400 * 30), "/");

$sql = "SELECT * FROM firebaseusers WHERE userId = '". $_COOKIE['user'] ."'";
		$result = $conn->query($sql) or die("Query fail");
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
		 $securityLevel = $row['intSecurityLevel'];
		 
		 
		  if($securityLevel == 4){
		     echo 0;
		 }else{
		     $sql = "SELECT * FROM `colorSchemes` WHERE `active` = '1'";
                    $result = $conn->query($sql) or die("Query fail");
                        
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $cssLink = $row['colorCssLink'];
                    $bannerLink = $row['bannerCssLink'];
                    $colorArray = $row['colorArray'];
                    $userIcon = $row['currentUsersLink'];
                    $openTicketsIcon = $row['openTicketsLink'];
                    $closedTicketsIcon = $row['closedTicketsLink'];
                    $severeWeatherIcon = $row['severeWeatherLink'];
                    $calendarIcon = $row['calendarLink'];
                    $alertsIcon = $row['alertsLink'];
                    $profileImage = $row['profileLink'];

                    setcookie("colorCssLink", $cssLink, time() + (86400 * 30), "/"); // 86400 = 1 day
                    setcookie("bannerLink", $bannerLink, time() + (86400 *30), "/"); // 86400 = 1 day
                    setcookie("colorArray", $colorArray, time() + (86400 *30), "/"); // 86400 = 1 day
                    setcookie("userIcon", $userIcon, time() + (86400 *30), "/"); // 86400 = 1 day
                    setcookie("openTicketsIcon", $openTicketsIcon, time() + (86400 *30), "/"); // 86400 = 1 day
                    setcookie("closedTicketsIcon", $closedTicketsIcon, time() + (86400 *30), "/"); // 86400 = 1 day
                    setcookie("severeWeatherIcon", $severeWeatherIcon, time() + (86400 *30), "/"); // 86400 = 1 day
                    setcookie("calendarIcon", $calendarIcon, time() + (86400 *30), "/"); // 86400 = 1 day
                    setcookie("alertsIcon", $alertsIcon, time() + (86400 *30), "/"); // 86400 = 1 day
                    setcookie("profileImage", $profileImage, time() + (86400 *30), "/"); //86400 = 1 day
                    

echo 1;                 
		 }
   ?>