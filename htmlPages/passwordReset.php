<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Forgot Password</title>

        <link rel="stylesheet" type="text/css" href="/GreenwayProject_AdminPortal/css/styles.css"/>
    </head>

    <script>
        function myFunction() {
            window.location.href = "/GreenwayProject_AdminPortal/htmlPages/login.html"
        }
    </script>

    <body>
    <div class="header">
        <!-- The logo that appears on the fixed header at the top of the page. -->
        <div class="logo">
            <h1>CoFW Trail Network Admin Portal</h1>
        </div>
    </div>

    <div class="password">
        <form>
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
