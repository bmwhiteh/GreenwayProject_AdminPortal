<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Dashboard_Pages/nav.css">
    <link rel="stylesheet" type="text/css" href="../css/userProfilePages.css">
     <script src="../js/jquery-3.2.1.min.js"></script>
      <script src="https://www.gstatic.com/firebasejs/5.3.0/firebase.js"></script>
     <script src="https://cdn.firebase.com/libs/firebaseui/3.2.0/firebaseui.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<script>
         // Initialize Firebase
  var config = {
    apiKey: "AIzaSyD2MKXo--r3wLd-YlpvuAre93fiw154Ukc",
    authDomain: "greenwaytest-aeb36.firebaseapp.com",
    databaseURL: "https://greenwaytest-aeb36.firebaseio.com",
    projectId: "greenwaytest-aeb36",
    storageBucket: "greenwaytest-aeb36.appspot.com",
    messagingSenderId: "726052510477"
  };
  firebase.initializeApp(config);
  
function getUser(){
  
  var authenticator = firebase.auth();
  authenticator.onAuthStateChanged(function(user) {
  if (user) {
    // User is signed in.
    console.log("Firebase User: " + authenticator.currentUser.displayName);
    
      $.ajax({
  url: "/User_Accounts/setDisplayName.php",
  type: "get", //send it through get method
  data: { 
    displayName: authenticator.currentUser.displayName
  },
  success: function(response) {
  	console.log("Success");
  },
  error: function(xhr) {
  	console.log(xhr);
  }
});

    document.getElementById("userName").innerHTML = "Name: " + authenticator.currentUser.displayName;
     document.getElementById("userEmail").innerHTML = "Email: " + authenticator.currentUser.email;
  } else {
    // No user is signed in.
    console.log("NO user");
  }
});
   
}

function sendReset(){
	    var auth = firebase.auth();
	    var emailAddress =  auth.currentUser.email;
	    auth.sendPasswordResetEmail(emailAddress).then(function() {
	      // Email sent. 
	      console.log("Email Sent");
	    }).catch(function(error) {
	      // An error happened.
	      var errorCode = error.code;
		  var errorMessage = error.message;
		  if (errorCode === 'auth/invalid-email') {
		    alert('Invalid email.');
		  } else if(errorCode === 'auth/user-not-found'){
		  	alert('User not found');
		  }else if (errorCode === 'auth/missing-android-pkg-name') {
		  	alert('Missing Android Package Name');
		  } else if (errorCode === 'auth/missing-continue-uri') {
		  	alert('Missing Continue URI');
		  }else if (errorCode === 'auth/missing-ios-bundle-id') {
		  	alert('Missing IOS bundle ID')
		  }else if (errorCode === 'auth/invalid-continue-uri') {
		  	alert('Invalid Continue URI')
		  }else if (errorCode === 'auth/unauthorized-continue-uri') {
		  	alert('Unauthorized Continue URI')
		  }else {
		    alert("We're sorry. There was an issue resetting your password.  Our team of highly trained monkeys has been dispatched to deal with this issue.");
		  }
	      
	      
	    });
	    
	    document.getElementById("resetMessage").innerHTML = "Password reset sent to email.";
	}


function openNav() {
    getUser();
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

$(document).ready(function(){
    $("#changePasswordButton").click(function(){
        var password1 = $("#password1").val().trim();
        var password2 = $("#password2").val().trim();
        if(password1 == password2) {
                var oldPassword = $("#oldPassword").val().trim();
                var newPassword = password1;
                if( oldPassword != "" ){
                     $.ajax({
                        url:'../User_Accounts/verifyCorrectPassword.php',
                        type:'post',
                        data:{password:oldPassword, newPassword:newPassword},
                        success:function(response){
                            console.log(response);
                            var msg = "";
                                    if(response== 0){
                                        msg="The password is invalid!";
                                    }
                                    
                                    if(response == 2){
                                        msg = "Passwords must be 6-12 characters in length and contain an uppercase letter, a lowercase letter, and a number!";
                                    }
                                    
                                    if(response == 1){
                                        msg = "Password has been changed!";
                                    }
                    
                            $("#invalid").html(msg);
                        }
                    });
                }
                return true;
        }
        else {
             $("#invalid").text("Passwords Do Not Match!");  
             return false;
        }
        
    });
});

</script>

</head>
<body>
    
    <?php
		include("../MySQL_Connections/config.php");
	    $sql = "SELECT * FROM firebaseusers WHERE userId = '". $_COOKIE["user"] ."'";
		$result = $conn->query($sql) or die("Query fail");
		$row = $result->fetch_array(MYSQLI_ASSOC);
	?>
	
<div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <img id="profileImage" src=<?php echo $_COOKIE['profileImage']; ?>></img>
            <a><h5 id="profileHeader">User Profile</h5></a>
            <a><h6 class="profileInfo" id="userName"></h6></a>
            <a><h6 class="profileInfo">Security Level: 
				<?php 
				    $level = $row['intSecurityLevel'];
				    $sql = "SELECT strSecurityTitle,bitManageTickets, bitManageUsers, bitSendNotifications FROM securitylevels WHERE intSecurityLevelId = $level";
					$result = $conn->query($sql) or die("Query fail");
					$findSecurity = $result->fetch_array(MYSQLI_ASSOC);
					$SecurityTitle = $findSecurity['strSecurityTitle'];
					echo $SecurityTitle;?>
			</h6></a>
			<a><h6 class="profileInfo" id="userEmail"></h6></a>
			
		    <!--	<button type="button">Change Password</button> -->
			<?php
			   if($findSecurity['bitManageTickets']==1){
			       $manageTickets = "Yes";
			   }else{
			       $manageTickets = "No";
			   }
			   
			   if($findSecurity['bitManageUsers']==1){
			       $manageEmployees = "Yes";
			   }else{
			       $manageEmployees = "No";
			   }
			   
			   if($findSecurity['bitSendNotifications']==1){
			       $sendNotifications = "Yes";
			   }else{
			       $sendNotifications = "No";
			   }
			?>
			<a><h5 id="profileHeader">Permissions</h5></a>
			<a><h6 class="profileInfo">Manage Tickets?: <?php echo $manageTickets;?></h6></a>
			<a><h6 class="profileInfo">Manage Users?: <?php echo $manageEmployees;?></h6></a>
			<a><h6 class="profileInfo">Send Notifications?: <?php echo $sendNotifications?></h6></a>
			<button id="button" type="button" onClick="sendReset() "><b>Reset Password</b></button>
			<div id="resetMessage"><span id = "invalid"></span></div>
          
          
</div>

<div id="mySidenav2" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeChangePassword()">&times;</a>
            <img id="profileImage" src=<?php echo $_COOKIE['profileImage']; ?>></img>
            <a><h5 id="changePasswordHeader">Change Password</h5></a>
            
            <form class="passwordChange" method="post">
            
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
            
            <div id="errorMessages"><span id = "invalid"></span></div>
            <!-- The button to reset password --> 
            <button id="changePasswordButton" name="changePasswordButton" type="button"><b>Reset Password</b></button>
            <?php
                echo $error;
            ?>
        </form>
</div>

</div>
</body>
</html>