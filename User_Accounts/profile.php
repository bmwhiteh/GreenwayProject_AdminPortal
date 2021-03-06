<!DOCTYPE html>
<html>
	<head>
		<title>Profile Page</title>
		<style>
			.contentBox{
				background-color: #8c8c8c;
				margin: 0px 100px 50px 100px;
				padding:10px;
			}

			h1 {
				color: #000;
				font-size: 24px;
				font-weight: 400;
				text-align: center;
				margin-top: 20px;
			}
			
			#usersInfo{
				text-align:center;
				float:left;
				width:50%;
			}
			
			#wrapper{
				border: 1px solid black;
				border-radius:20px;
				background-color:white;
				height:100%;
			}
			
			#permission{
				text-align:center;
			}
			
			body {
				background-color: #1B371A ;

			}
			
			input{
				width:30%;
			}

		</style>
	</head>
	<body>

		<!--Include User Verification & Navigation Bar-->
		<?php require_once("../Login_System/verifyAuth.php"); ?>
		<?php include "../Dashboard_Pages/navBar.php"; ?>


		<!--Grab User information from the database-->
		<?php
			include("../MySQL_Connections/config.php");
			
			
			$sql = "SELECT * FROM employees WHERE strUsername = '". $_COOKIE["user"] ."'";
			$result = $conn->query($sql) or die("Query fail");
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
		?>
		 

		<div class="contentBox">

			<!--Page Header-->
			<h1 style="margin-bottom: 30px; margin-top:0px; color: white; vertical-aligh:middle; text-align: center;">User Profile</h1>
			
			
			<div id="wrapper">
			
				<div  id="usersInfo">
				
					<!--Name, Security Level, Email-->
					<p>Name: <?php echo $row['strFirstName'] . " " . $row['strLastName']?></p>
					<p>Security Level: 
							<?php 
								$level = $row['intSecurityLevel'];
								$sql = "SELECT strSecurityTitle FROM securitylevels WHERE intSecurityLevelId = $level";
								$result = $conn->query($sql) or die("Query fail");
								$findSecurity = $result->fetch_array(MYSQLI_ASSOC);
								$SecurityTitle = $findSecurity['strSecurityTitle'];
								echo $SecurityTitle;?></p>
					<p>Email: <?php echo $row['strEmailAddress']?></p>
					
					<!--Ability to change Password or Request Permissions-->
					<button type="button">Change Password</button><br><br>
					<button type="button">Request Permissions</button>

					
				</div>
				
				<!--Detail User's permissions-->
				<div  id="permission">
				
					<p><u>Permissions</u></p>
					<p>Create New Tickets?: Yes</p>
					<p>Close Tickets?: Yes</p>
					<p>Manage Users?: No</p>
					<p>Send Notifications? No</p>
					
				</div>
				
				
			</div>
			
			
		</div>


			  
		<?php
			}
		?>

	</body>
</html>

