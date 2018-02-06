<!DOCTYPE html>
<html>

<head>
    <!--The title of the login page -->
    <title>Enter Username</title>

    <!--Links the CSS stylesheet to the login.html page -->
    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
</head>

<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //includes the database connection
    include("../MySQL_Connections/config.php");
    session_start();
        
    //gets username from user input
        $username = mysqli_real_escape_string($conn, $_POST['uname']);
        $sql = "SELECT * FROM `employees` WHERE `strUsername` = '$username'";
        //sql execution
            $result = $conn->query($sql) or die("Query fail");
            
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $active = $row['active'];
        
            $count =  $result->num_rows;
            if($count == 1) {
                $sql = "SELECT * FROM employees WHERE accountLocked = '1' and strUsername = '$username'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            //counts rows returned 
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $active = $row['active'];
        
            $lockedCount =  $result->num_rows;
                if($lockedCount == 0){
                        //sets session variable user
                        $_SESSION['user'] = $username;
                        //redirects to the securityQuestions page
                        header("location: ./securityQuestions.php");
                }else{
                    $error = "Your account has been locked.  Please contact Andrea or Bailey to unlock.";
                }
            }else{
                //displays error message
                $error = "No user with that name exists";
            }
    
}
?>
<!-- includes the Viridian Banner -->
<div class="banner">
    <div class="logo">
        <img src="../images/ViridianBanner2.png" width="100%" height="150px"/>
    </div>
</div>

<div class="username">
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <!--The "username" field -->
        <label><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" autocomplete="off" required>
        <br/>

        <!-- The "Submit" button -->
        <button id="loginButtons" type="submit"><b>Submit</b></button>
        <?php
            echo $error;
        ?>
        <br>

    </form>
</div>

</body>
</html>
