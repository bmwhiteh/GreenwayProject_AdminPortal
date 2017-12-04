<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Forgot Password</title>

<!-- links to css -->
        <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
    </head>

    <body>
    <!-- includes Viridian Banner -->
    <div class="banner">
        <div class="logo">
            <img src="../images/ViridianBanner.png" width="100%" height="150px"/>
        </div>
    </div>

    <div class="password">
        <!-- executes reset.php upon submission -->
        <form  action="./reset.php" method="post">
            <!--The "New Password" field -->
            <label><b>New Password</b></label>
            <input type="text" name ="newPassword" placeholder="Enter Password" required>
            <br/>

            <!--The "confirm Password" field -->
            <label><b>Confirm Password</b></label>
            <input type="password" name ="confirmNewPassword" placeholder="Re-enter Password" required>
            <br/><br/>
            
            <!-- The button to reset password --> 
            <button id="loginButtons" type="submit" onClick="myFunction() "><b>Reset Password</b></button>
        </form>
    </div>

    </body>
</html>
