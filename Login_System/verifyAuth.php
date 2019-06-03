<?php
	include("../MySQL_Connections/config.php");
	
//sets a variable to the user Cookie
$cookie = $_COOKIE['user'];
//if the cookie does not exist, redirect to the login page 
if(!isset($cookie)){
		header("location: /Login_System/fireBaseLogin.html"); 
}else{
    $sql = "SELECT * FROM firebaseusers WHERE userId = '". $cookie ."'";
		$result = $conn->query($sql) or die("Query fail");
		$row = $result->fetch_array(MYSQLI_ASSOC);
		
		 $securityLevel = $row['intSecurityLevel'];
		  if($securityLevel == 4){
		     header("location: /Login_System/fireBaseLogin.html"); 
		 }
}
?>