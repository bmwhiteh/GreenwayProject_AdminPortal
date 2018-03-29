<?php
//includes the database connection
include("../MySQL_Connections/config.php");

$oldPassword = mysqli_real_escape_string($conn,$_POST['password']);
$newPassword = mysqli_real_escape_string($conn,$_POST['newPassword']);
$myusername = $_COOKIE['user'];
$regex = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,12}^";
if (preg_match($regex, $newPassword)) {
    if ($oldPassword != ""){
    
        $sql = "SELECT strEncryptedPassword FROM employees WHERE strUsername = '$myusername'";
       
        $result = $conn->query($sql) or die("Query fail");
       
        $row = $result ->fetch_array(MYSQLI_ASSOC);
        $encryptedPassword = $row['strEncryptedPassword'];
                
        $match = password_verify($oldPassword, $encryptedPassword);
    
        if($match){
            $options = [
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
                                    
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, $options);
            //sql to update users password
            $sql = "UPDATE `employees` SET `strEncryptedPassword`= '$hashedPassword' WHERE `strUsername` = '$myusername'";
            //sql execution
            $result = $conn->query($sql) or die("Query fail");
            echo "1";
        }else{
            echo "0";
        }
    
    }
}else{
    echo "2";
}

?>               
