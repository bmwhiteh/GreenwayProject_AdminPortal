<!DOCTYPE html>
<html>

<head>
    <!--The title of the login page -->
    <title>About Viridian</title>

    <!--Links the CSS stylesheet to the login.html page -->
    <link rel="stylesheet" type="text/css" href="../css/loginSystem.css"/>
    <link rel="shortcut icon" href="../Dashboard_Pages/favicon.png" type="image/x-icon">
</head>

<script>
    function myFunction() {
        window.location.href = "../Login_System/login.php"
    }
</script>

<body>
    <!--includes the Viridian Banner -->
<div class="banner">
    <div class="logo">
        <img src="../images/ViridianBanner.png" width="100%"; height="150px"/>
    </div>
</div>

<!-- includes information about the project -->
<div class="about">
    <h2>Welcome to the Viridian Admin Portal!</h2>
    <h3>What is Viridian?</h3>
    <p class="info">This project was developed over the course of three years by students 
    in the Computer Science Department at Indiana University-Purdue University, 
    Fort Wayne (IPFW) as part of their Senior Capstone course. Viridian is a
    Mobile App and Admin Portal project sponsored by the City of Fort Wayne.
    The goal of Viridian is to provide an easy-to-use application that allows 
    monitoring of trail system usage in the River Greenway Trail System. This
    monitoring system allows the City to promote sections of the trails that
    are less commonly used and make improvements to trails based on the data 
    collected.  
    </p>
    <h3>How can I participate?</h3>
    <p class="info">Viridian is used by two types of users:  <ul><li>General Public - 
    The Viridian mobile application is used by the general public. This app is
    accessible via both iOS and Android devices. It is a completely free fitness
    and activity tracker with maps specific to the River Greenway Trail System. 
    Users can track fitness activities, such as walking, running, or biking.
    Users can submit maintenance requests via the app to alert the City of trail
    issues. Earning achievements unlocks special surprises! Download Viridian 
    from your phone or tablet via the App Store.</li>
     <br><li>City of Fort Wayne Representatives - The Viridian Admin Portal is
     used by City officials to view usage analytics on the River Greenway Trail
     System. It is also equipped with an advanced ticket management system that 
     allows the City of Fort Wayne to organize and complete maintenance tasks 
     along the trail system in a quick and timely fashion. </li></ul></p>

    <!--returns to the login page upon clicking the button -->
    <button id="loginButtons" type="returnToLogin" onClick="myFunction() "><b>Return to Login</b></button>
</div>

</body>
</html>
