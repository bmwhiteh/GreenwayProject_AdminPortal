<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Account Setup</title>

<!-- links to css -->
        <link rel="stylesheet" type="text/css" href="../css/loginSystem.css"/>
        <link rel="shortcut icon" href="../Dashboard_Pages/favicon.png" type="image/x-icon">
    </head>

    <body>
         <?php
		    include("../MySQL_Connections/config.php");
	    ?>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //includes connection to the database
                include("../MySQL_Connections/config.php");
                
                session_start();
                //sets the username from the session user value
                $username = $_COOKIE['user'];
                
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
                            $id1 = mysqli_real_escape_string($conn, $_POST['securityQuestion1']);
                            $answer1 = mysqli_real_escape_string($conn, $_POST['answer1']);
                            $hashedanswer1 = password_hash($answer1, PASSWORD_BCRYPT, $options);
                            $id2 = mysqli_real_escape_string($conn, $_POST['securityQuestion2']);
                            $answer2 = mysqli_real_escape_string($conn, $_POST['answer2']);
                            $hashedanswer2 = password_hash($answer2, PASSWORD_BCRYPT, $options);
        
                            //sql to update users password
                            $sql = "UPDATE `employees` SET `strEncryptedPassword`= 
                            '$hashedPassword',`securityQuestion1`= '$id1',
                            `securityQuestion1Answer`= '$hashedanswer1',
                            `securityQuestion2`= '$id2', 
                            `securityQuestion2Answer`= '$hashedanswer2',  `firstAccess` ='0'
                             WHERE `strUsername` = '$username'";
                             echo $sql;
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

    <div class="accountSetup">
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <!--The "New Password" field -->
            <label><b>New Password</b></label>
            <input type="password" name ="newPassword" placeholder="Enter Password" maxlength="12" autocomplete="off" required>
            <br/>

            <!--The "confirm Password" field -->
            <label><b>Confirm Password</b></label>
            <input type="password" name ="confirmNewPassword" placeholder="Re-enter Password" maxlength="12" autocomplete="off" required>
            <br/>
            
             <label class="passwordLabel"><b>Security Question 1</b></label>
             <br>
             <select name="securityQuestion1" id="securityQuestion1">
                 <?php 
                    $sql = "SELECT `id`,`question` FROM `securityQuestions` WHERE `id` < 5 ";
                    //sql execution
                    $result = $conn->query($sql) or die("Query fail"); 
                
                    while($row = $result->fetch_array(MYSQLI_ASSOC)){
                        echo "<option value=".$row['id'].">" . $row['question'] . "</option>";
                    }
                ?>
             </select>
             <input type="text" name ="answer1" placeholder="Enter Answer"  autocomplete="off" required>
            
            <label class="passwordLabel"><b>Security Question 2</b></label>
             <br>
             <select name="securityQuestion2" id="securityQuestion12">
                <?php 
                    $sql = "SELECT `id`,`question` FROM `securityQuestions` WHERE `id` > 4";
                    //sql execution
                    $result = $conn->query($sql) or die("Query fail"); 
                
                    while($row = $result->fetch_array(MYSQLI_ASSOC)){
                        echo "<option value=".$row['id'].">" . $row['question'] . "</option>";
                    }
                ?>
             </select>
             <input type="text" name ="answer2" placeholder="Enter Answer"  autocomplete="off" required>
            <!-- The button to reset password --> 
            <button id="loginButtons" type="submit"><b>Setup Account</b></button>
            <?php
                echo $error;
            ?>
        </form>
    </div>

    </body>
</html>