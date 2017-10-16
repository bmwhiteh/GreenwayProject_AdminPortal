<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Forgot Password</title>

        <link rel="stylesheet" type="text/css" href="/GreenwayProject_AdminPortal/css/styles.css"/>
    </head>

    <body>
    <div class="container">
        <div class="logo">
            <img src="../images/ViridianBanner.png" width="100%" height="100px"/>
        </div>
    </div>

    <div class="password">
        <form  action="/GreenwayProject_AdminPortal/Login_System/login.html" method="get">
            <!--The "username" field -->
            <label><b>New Password</b></label>
            <input type="text" placeholder="Enter Password" required>
            <br/>

            <!--The "password" field -->
            <label><b>Confirm Password</b></label>
            <input type="password" placeholder="Re-enter Password" required>
            <br/><br/>
            <button type="submit" onClick="myFunction() "><b>Reset Password</b></button>
        </form>
    </div>

    </body>
</html>
