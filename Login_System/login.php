<!DOCTYPE html>
<html>

<head>
    <!--The title of the login page -->
    <title>Viridian Admin Portal</title>

    <!--Links the CSS stylesheet to the login.html page -->
    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
</head>

<body>
    <?php
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $error = "";
 session_start();
//includes the database connection
include("../MySQL_Connections/config.php");

//gets the username and password from user input
    $myusername = mysqli_real_escape_string($conn, $_POST['uname']);
    $mypassword = mysqli_real_escape_string($conn, $_POST['psw']);
    
        $sql = "SELECT * FROM employees WHERE accountLocked = '1' and strUsername = '$myusername'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            //counts rows returned 
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $active = $row['active'];
        
            $lockedCount =  $result->num_rows;
        if($lockedCount == 0){
            $sql = "SELECT strEncryptedPassword FROM employees WHERE strUsername = '$myusername'";
            $result = $conn->query($sql) or die("Query fail");
            $row = $result ->fetch_array(MYSQLI_ASSOC);
            $encryptedPassword = $row['strEncryptedPassword'];
            
            $match = password_verify($mypassword, $encryptedPassword);
            $count = 0;
            if($match){
        //sql to check if username and encrypted password match
            $sql = "SELECT intEmployeeID FROM employees WHERE strUsername = '$myusername' and strEncryptedPassword = '$encryptedPassword'";
        
        //executes query
            $result = $conn->query($sql) or die("Query fail");
        //counts rows returned 
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $active = $row['active'];
        
            $count =  $result->num_rows;
            // If result matched $myusername and $mypassword, table row must be 1 row
        }
            if($count == 1) {
                    $sql = "SELECT firstAccess FROM employees WHERE strUsername= '$myusername'";
                    $result = $conn->query($sql) or die("Query fail");
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    if($row['firstAccess'] == 0){
                    $sql = "UPDATE `employees` SET `loginAttempts` = '0',`securityQuestionAttempts` = '0' WHERE `strUsername` = '$myusername'";
                    //sql execution
                    $result = $conn->query($sql) or die("Query fail");
                    $_SESSION["authenticated"] = true;
                    //sets cookie
                    setcookie("user", $myusername, time() + (86400 * 30), "/"); // 86400 = 1 day
                    setcookie("encryptedPassword" , $encryptedPassword,  time() + (86400 * 30), "/");
                    //redirects to dashboard
                    header("location: ../Dashboard_Pages/dashboard.php");
                }else{
                    $_SESSION["authenticated"] = true;
                    //sets cookie
                    setcookie("user", $myusername, time() + (86400 * 30), "/"); // 86400 = 1 day
                    header("location: ./accountSetup.php");
                }
            }else{
                $sql = "SELECT `loginAttempts` FROM employees WHERE strUsername = '$myusername'";
                //sql execution
                $result = $conn->query($sql) or die("Query fail");
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $attempts = $row['loginAttempts'];
                $newAttemptNumber = $attempts + 1;
                $sql = "UPDATE `employees` SET `loginAttempts`= '$newAttemptNumber' WHERE `strUsername` = '$myusername'";
                //sql execution
                $result = $conn->query($sql) or die("Query fail");
                if($newAttemptNumber == 5){
                   $sql = "UPDATE `employees` SET `accountLocked`= '1' WHERE `strUsername` = '$myusername'";
                //sql execution
                $result = $conn->query($sql) or die("Query fail"); 
                }
                //provides error message and redirects to login page
                $error = "Your Username or Password is invalid";
            }
        }else{
            $error = "Your account has been locked.  Please contact Andrea or Bailey to unlock.";
        }

 }
?>

<!-- includes the Viridian Banner -->
<div class="banner">
    <div class="logo">
        <img src="../images/ViridianBanner2.png" width="100%" height="150px"/>
    </div>
</div>

<div class="login">

    <!-- The login form
    action: links the php code to validate the user and login to the system
    -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 

        <!--The "username" field -->
        <label><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" style="backgound-color:gray"  autocomplete="off" required>
        <br/>

        <!--The "password" field -->
        <label><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" style="backgound-color:gray"  autocomplete="off" required>
        <br/><br/>

        <!-- The "Submit" button -->
        <button id="loginButtons" type="submit"><b>Login</b></button>
        <?php
            echo $error;
        ?>
        <br>
        <br>
        <div>
            <!-- redirects to the forgot password functionality -->
            <a href="./enterUsername.php">Forgot Password? </a>
            <br> <br>
            <!-- redirects to the about Project page -->
            <a href="./aboutProject.php">What is this page?</a>
        </div>

    </form>
</div>

</body>
</html>
