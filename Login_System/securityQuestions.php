<!DOCTYPE html>
<html>

<head>
    <!--The title of the login page -->
    <title>Security Questions</title>

    <!--Links the CSS stylesheet to the login.html page -->
    <link rel="stylesheet" type="text/css" href="../css/loginSystem.css"/>
    <link rel="shortcut icon" href="../Dashboard_Pages/favicon.ico" type="image/x-icon">
</head>

<body>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //include connection to database 
    include("../MySQL_Connections/config.php");
    
    session_start();
    //sets the username variable to the session user value
    $username = $_SESSION['user'];
    
    //checks if a post occurs
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form
        $answer1 = mysqli_real_escape_string($conn, $_POST['answer1']);
        $answer2 = mysqli_real_escape_string($conn, $_POST['answer2']);

            $sql = "SELECT * FROM employees WHERE accountLocked = '1' and strUsername = '$username'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            //counts rows returned 
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $active = $row['active'];
        
            $lockedCount =  $result->num_rows;
            if($lockedCount == 0){
                //sql to verify security answers from user input
                $sql = "SELECT * FROM `employees` WHERE `strUsername` = '$username' && `securityQuestion1Answer`= '$answer1' && `securityQuestion2Answer` = '$answer2'";
                //sql execution
                $result = $conn->query($sql) or die("Query fail");
                
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $active = $row['active'];
            
                $count =  $result->num_rows;
                if($count == 1) { //security questions are correct
                    $sql = "UPDATE `employees` SET `securityQuestionAttempts` = '0' WHERE `strUsername` = '$username'";
                    //sql execution
                    $result = $conn->query($sql) or die("Query fail");
                    //if security answers match, redirect to the passwordReset.php
                    header("location: ./passwordReset.php");
                }else{
                    $sql = "SELECT `securityQuestionAttempts` FROM employees WHERE strUsername = '$username'";
                    //sql execution
                    $result = $conn->query($sql) or die("Query fail");
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $attempts = $row['securityQuestionAttempts'];
                    $newAttemptNumber = $attempts + 1;
                    $sql = "UPDATE `employees` SET `securityQuestionAttempts`= '$newAttemptNumber' WHERE `strUsername` = '$username'";
                    //sql execution
                    $result = $conn->query($sql) or die("Query fail");
                    
                    if($newAttemptNumber == 5){
                       $sql = "UPDATE `employees` SET `accountLocked`= '1' WHERE `strUsername` = '$username'";
                        //sql execution
                        $result = $conn->query($sql) or die("Query fail"); 
                    }
            
                    //displays error message and redirects to the securityQuestions.php
                    $error = "Your answers are incorrect";
                }
            }else{
                $error = "Your account has been locked.  Please contact an administrator to unlock.";
            }
        
    }
}
?>
    <!--includes Viridian Banner --> 
<div class="banner">
    <div class="logo">
        <img src="../images/ViridianBanner.png" width="100%" height="150px"/>
    </div>
</div>

<div class="security">
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label><b><?php include "populateSecurityQuestion1.php"?></b></label>
        <input type="text" name="answer1" placeholder="Enter Response"  autocomplete="off" required>
        <br/>

        <label><b><?php include "populateSecurityQuestion2.php"?></b></label>
        <input type="text" name="answer2" placeholder="Enter Response"  autocomplete="off" required>
        <br/>

        <!-- The "Submit" button -->
        <button id="loginButtons" type="submit" onClick="myFunction() "><b>Submit</b></button>
           <?php
                echo $error;
            ?>
        <br>
    </form>
</div>

</body>
</html>