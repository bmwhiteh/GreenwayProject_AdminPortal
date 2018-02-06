<?php
     //includes connection to the database
                include("../MySQL_Connections/config.php");
                //session_start();
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

                            //sql to update users password
                            $sql = "UPDATE `employees` SET `strEncryptedPassword`= '$hashedPassword' WHERE `strUsername` = '$username'";
                            //sql execution
                            $result = $conn->query($sql) or die("Query fail"); 
                            //redirect to dashboard
                            header("location: ../Dashboard_Pages/dashboard.php");
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
            
?>