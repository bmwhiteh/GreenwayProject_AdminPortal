<!DOCTYPE html>
<html>

<head>
    <!--The title of the login page -->
    <title>About</title>

    <!--Links the CSS stylesheet to the login.html page -->
    <link rel="stylesheet" type="text/css" href="/GreenwayProject_AdminPortal/css/styles.css"/>
</head>

<script>
    function myFunction() {
        window.location.href = "/GreenwayProject_AdminPortal/htmlPages/login.html"
    }
</script>

<body>
<div class="container">
    <div class="logo">
        <img src="../images/Viridian Banner.png" width="100%" height="300px"/>
    </div>
</div>

<div class="about">
    <h2>Welcome!</h2>
    <h3>We bet you're wondering what this page is...</h3>
    <p>This is the City of Fort Wayne Trail Network Admin Portal.
        This project has currently been a three year senior capstone project at IPFW,
        with each team expanding upon the previous team's successes.
        Currently, we are in Year Three of the Project.  This website was created as
        a way to display information to the city about the River Greenway.
        It provides information on what sections of the trail are most used, as
        well as what types of activities people are using the trails for.  It also
        has an advanced ticket tracking system that allows the City of Fort Wayne to
        organize and complete maintenance tasks along the trail system in a quick
        and timely fashion.
    </p>
    <h3>Cool! How can I participate?</h3>
    <p>Unfortunately, this website can only be accessed by the City of Fort Wayne.
        However, if you would like to support our project, download the associated app,
        <b>TrailLinxs</b>.  <b>TrailLinxs</b> is a fitness and activity tracker specific to the River Greenway
        trail system. And the best part?  &nbsp &nbsp  <i><b><u> It's completely free!</u></b></i> </p>

    <button type="returnToLogin" onClick="myFunction() "><b>Return to Login</b></button>
</div>

</body>
</html>
