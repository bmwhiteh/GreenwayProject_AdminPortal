<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Forgot Password</title>

        <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
    </head>

    <body>
    <div class="banner">
        <div class="logo">
            <img src="../images/ViridianBanner.png" width="100%" height="150px"/>
        </div>
    </div>

    <div class="password">
        <form  action="./reset.php" method="post">
            <!--The "username" field -->
            <label><b>New Password</b></label>
            <input type="text" name ="newPassword" placeholder="Enter Password" required>
            <br/>

            <!--The "password" field -->
            <label><b>Confirm Password</b></label>
            <input type="password" name ="confirmNewPassword" placeholder="Re-enter Password" required>
            <br/><br/>
            <button id="loginButtons" type="submit" onClick="myFunction() "><b>Reset Password</b></button>
        </form>
    </div>

    </body>
</html>
