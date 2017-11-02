<!DOCTYPE html>
<html>

<head>
    <!--The title of the login page -->
    <title>Security Questions</title>

    <!--Links the CSS stylesheet to the login.html page -->
    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
    <link rel="stylesheet" type="text/css" href="../css/viridian.css"/>
</head>

<body>
<div class="banner">
    <div class="logo">
        <img src="../images/ViridianBanner.png" width="100%" height="150px"/>
    </div>
</div>

<div class="security">
    <form action="./verifySecurityAnswers.php" method="post">
        <label><b><?php include "populateSecurityQuestion1.php"?></b></label>
        <input type="text" name="answer1" placeholder="Enter Response" required>
        <br/>

        <label><b><?php include "populateSecurityQuestion2.php"?></b></label>
        <input type="text" name="answer2" placeholder="Enter Response" required>
        <br/>

        <!-- The "Submit" button -->
        <button id="loginButtons" type="submit" onClick="myFunction() "><b>Submit</b></button>
        <br>
    </form>
</div>

</body>
</html>