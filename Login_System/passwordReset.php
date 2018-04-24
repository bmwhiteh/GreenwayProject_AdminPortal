<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Forgot Password</title>

<!-- links to css -->
        <link rel="stylesheet" type="text/css" href="../css/loginSystem.css"/>
        <link rel="shortcut icon" href="../Dashboard_Pages/favicon.png" type="image/x-icon">
    </head>

    <body>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //includes connection to the database
                include("../MySQL_Connections/config.php");
                
                session_start();
                //sets the username from the session user value
                $username = $_SESSION['user'];
                
                //checks if a post has occurred
                if($_SERVER["REQUEST_METHOD"] == "POST") {
                
                //sets values of newPassword and confirmNewPassword from user input   
                $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
                $confirmNewPassword = mysqli_real_escape_string($conn, $_POST['confirmNewPassword']);
                
                //regex to force passwords to have an uppercase letter,a lowercase letter, and a number
                //regex also forces password to be 6-12 characters long
                $regex = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,12}^";
                    if (preg_match($regex, $newPassword)) {
                                 //checks if values match
                        if($newPassword == $confirmNewPassword){
                                $options = [
                                    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                                ];
                                
                            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, $options);

                            //sql to update users password
                            $sql = "UPDATE `employees` SET `strEncryptedPassword`= '$hashedPassword' WHERE `strUsername` = '$username'";
                            //sql execution
                            $result = $conn->query($sql) or die("Query fail"); 
                            //redirect to login
                            header("location: ./login.php");
                        }else{
                            //displays error message and redirects to passwordReset page
                            $error = "Your passwords do not match!";
                        }
                    } else {
                        // If preg_match() returns false, then the regex does not
                        // match the string
                        $error = "Passwords must be 6-12 characters in length and 
                        contain an uppercase letter, a lowercase letter, and a number.";
                    }
               
                }
            }
        ?>
        
    <!-- includes Viridian Banner -->
    <div class="banner">
        <div class="logo">
            <img src="../images/ViridianBanner.png" width="100%" height="150px"/>
        </div>
    </div>

    <div class="password">
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <!--The "New Password" field -->
            <label><b>New Password</b></label>
            <input type="password" name ="newPassword" placeholder="Enter Password" maxlength="12" autocomplete="off" required>
            <br/>

            <!--The "confirm Password" field -->
            <label><b>Confirm Password</b></label>
            <input type="password" name ="confirmNewPassword" placeholder="Re-enter Password" maxlength="12" autocomplete="off" required>
            <br/><br/>
            
            <!-- The button to reset password --> 
            <button id="loginButtons" type="submit" onClick="myFunction() "><b>Reset Password</b></button>
            <?php
                echo $error;
            ?>
        </form>
    </div>

    </body>
</html>
