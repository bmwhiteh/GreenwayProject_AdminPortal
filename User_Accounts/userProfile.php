<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Dashboard_Pages/nav.css">
     <script src="../js/jquery-3.2.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
    transition: background-color .5s;
}

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 2;
    top: 0;
    right: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

#profileInfo {
    -webkit-margin-before: 0em;
    -webkit-margin-after: 0em;
}

#profileHeader{
    -webkit-margin-before: 0em;
    -webkit-margin-after: .40em;
    margin-left:23%;
}

#changePasswordInfo{
	-webkit-margin-before: 0em;
    -webkit-margin-after: .75em;
    margin-left:10%;
}

#changePasswordHeader{
    -webkit-margin-before: 0em;
    -webkit-margin-after: .75em;
    margin-left:10%;
}

.passwordChange{
	display: inline-block;
    background-color: #111111;
    margin-left: 20%;
    margin-right: 20%;
}

.securityQuestionChange{
	display: inline-block;
    background-color: #111111;
    margin-left: 10%;
    margin-right: 10%;
}
.passwordLabel{
	color: #818181;
}

#changePasswordButton {
    background-color: #8C8C8C;
    color: #333333;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

#button {
    background-color: #8C8C8C;
    color: #333333;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 80%;
    margin-left:10%;
}
#securityQuestion1, #securityQuestion2{
    width: 100%;
}
#main {
    transition: margin-left .5s;
    padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
    <script>
function openNav() {
    document.getElementById("mySidenav").style.width = "20%";
    document.getElementById("contentBox").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("contentBox").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
}

function openChangePassword() {
	document.getElementById("mySidenav2").style.width="20%";
	document.getElementById("contentBox").style.marginLeft="250x";
	document.body.style.backgroundColor="rgba(0,0,0,0.8)";
}
function closeChangePassword() {
    document.getElementById("mySidenav2").style.width = "0";
    document.getElementById("contentBox").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
}

function openChangeSecurityQuestions() {
	document.getElementById("mySidenav3").style.width="25%";
	document.getElementById("contentBox").style.marginLeft="250x";
	document.body.style.backgroundColor="rgba(0,0,0,0.8)";
}
function closeChangeSecurityQuestions() {
    document.getElementById("mySidenav3").style.width = "0";
    document.getElementById("contentBox").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
}

function validate(){
    var oldPassword = $("#oldPassword").val();
    
    var password1 = $("#password1").val();
    var password2 = $("#password2").val();
    if(password1 == password2) {
        var regex = new RegExp("^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,12}");
        var result = regex.test(password2);
        if(result){
         
         return true;
        }else{
            $("#invalid").text("Passwords must be 6-12 characters in length and contain an uppercase letter, a lowercase letter, and a number!");
            return false;
        }
    }
    else {
         $("#invalid").text("Passwords Do Not Match!");  
         return false;
    }
}
</script>

</head>
<body>
    
    <?php
		include("../MySQL_Connections/config.php");
		
	    $sql = "SELECT * FROM employees WHERE strUsername = '". $_COOKIE["user"] ."'";
		$result = $conn->query($sql) or die("Query fail");
		$row = $result->fetch_array(MYSQLI_ASSOC);
	?>
		
<div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <img src="../images/profileImage2.png" height="25%" style="margin-left:20%;"></img>
            <a><h5 id="profileHeader">User Profile</h5></a>
            <a><h6 id="profileInfo">Name: <?php echo $row['strFirstName'] . " " . $row['strLastName']?></h6></a>
            <a><h6 id="profileInfo">Security Level: 
				<?php 
				    $level = $row['intSecurityLevel'];
				    $sql = "SELECT strSecurityTitle,bitManageTickets, bitManageUsers, bitSendNotifications FROM securitylevels WHERE intSecurityLevelId = $level";
					$result = $conn->query($sql) or die("Query fail");
					$findSecurity = $result->fetch_array(MYSQLI_ASSOC);
					$SecurityTitle = $findSecurity['strSecurityTitle'];
					echo $SecurityTitle;?>
			</h6></a>
			<a><h6 id="profileInfo">Email: <?php echo $row['strEmailAddress']?></h6></a>
			
		    <!--	<button type="button">Change Password</button> -->
			<?php
			   if($findSecurity['bitManageTickets']==1){
			       $manageTickets = "Yes";
			   }else{
			       $manageTickets = "No";
			   }
			   
			   if($findSecurity['bitManageUsers']==1){
			       $manageUsers = "Yes";
			   }else{
			       $manageUsers = "No";
			   }
			   
			   if($findSecurity['bitSendNotifications']==1){
			       $sendNotifications = "Yes";
			   }else{
			       $sendNotifications = "No";
			   }
			?>
			<a><h5 id="profileHeader">Permissions</h5></a>
			<a><h6 id="profileInfo">Manage Tickets?: <?php echo $manageTickets;?></h6></a>
			<a><h6 id="profileInfo">Manage Users?: <?php echo $manageUsers;?></h6></a>
			<a><h6 id="profileInfo">Send Notifications?: <?php echo $sendNotifications?></h6></a>
			<button id="button" type="button" onClick="openChangePassword() "><b>Reset Password</b></button>
			<button id="button" type="button" onClick="openChangeSecurityQuestions() "><b>Change Security Questions</b></button>
          
          
</div>

<div id="mySidenav2" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeChangePassword()">&times;</a>
            <img src="../images/profileImage2.png" height="25%" style="margin-left:20%;"></img>
            <a><h5 id="changePasswordHeader">Change Password</h5></a>
            
            <form class="passwordChange" method="post" action="../User_Accounts/changePassword.php" onSubmit="return validate()">
            
            <!--The "Old Password" field -->
            <label class="passwordLabel"><b>Old Password</b></label>
            <input type="password" id="oldPassword" name ="oldPassword" placeholder="Enter Old Password"  autocomplete="off" required>
            <br/>
            
            
            <!--The "New Password" field -->
            <label class="passwordLabel"><b>New Password</b></label>
            <input type="password" id="password1" name ="newPassword" placeholder="Enter Password" maxlength="12" autocomplete="off" required>
            <br/>

            <!--The "confirm Password" field -->
            <label class="passwordLabel"><b>Confirm Password</b></label>
            <input type="password" id="password2" name ="confirmNewPassword" placeholder="Re-enter Password" maxlength="12" autocomplete="off" required>
            <br/>
            
            <div id="invalid" style="color: white"></div>
            <!-- The button to reset password --> 
            <button id="changePasswordButton" type="submit"><b>Reset Password</b></button>
            <?php
                echo $error;
            ?>
        </form>
</div>

<div id="mySidenav3" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeChangeSecurityQuestions()">&times;</a>
            <img src="../images/profileImage2.png" height="25%" style="margin-left:25%;"></img>
            <a><h5 id="changePasswordHeader">Change Security Questions</h5></a>
            
            <form class="securityQuestionChange" method="post" action="../User_Accounts/changeSecurityQuestions.php">
            <!--The "Security Question 1" field -->
            <label class="passwordLabel"><b>Security Question 1</b></label>
            <select name="securityQuestion1" id="securityQuestion1">
                <?php 
                    $sql = "SELECT `id`,`question` FROM `securityQuestions` WHERE `id` < 5 ";
                    //sql execution
                    $result = $conn->query($sql) or die("Query fail"); 
                
               while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    echo "<option value=".$row['id'].">" . $row['question'] . "</option>";
                }
                ?>
            </select>
            <input type="text" name ="answer1" placeholder="Enter Answer"  autocomplete="off" required>
            <br/>
            
            <!--The "Security Question 2" field -->
            <label class="passwordLabel"><b>Security Question 2</b></label>
            <select name="securityQuestion2" id="securityQuestion2">
                <?php 
                    $sql = "SELECT  `id`,`question` FROM `securityQuestions` WHERE `id` > 4";
                    //sql execution
                    $result = $conn->query($sql) or die("Query fail"); 
                
               while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    echo "<option value=".$row['id'].">" . $row['question'] . "</option>";
                }
                ?>
            </select>
            <input type="text" name ="answer2" placeholder="Enter Password"  autocomplete="off" required>
            <br/>
            
            <!-- The button to reset password --> 
            <button id="changePasswordButton" type="submit"><b>Change Security Questions</b></button>
            <?php
                echo $error;
            ?>
        </form>
</div>
</body>
</html>