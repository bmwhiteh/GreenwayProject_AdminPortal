<?php
    include("../MySQL_Connections/config.php");
    
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        
    $firstName = $_GET['firstName'];
    $lastName = $_GET['lastName'];
    $email = $_GET['email'];
    $securityLevel = $_GET['intSecurityLevel'];
    echo $securityLevel;
    
    $usernameBase = $firstName[0].$lastName;
    echo $usernameBase;
    
    $sql = "SELECT * FROM `employees` WHERE `strUsernameBase` = '$usernameBase'";
    $result = $conn->query($sql) or die("Query fail1");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $countWithUsernameBase =  $result->num_rows;
     
     $usernameNumber = $countWithUsernameBase + 1;
     $username = $usernameBase.$usernameNumber;
     $username = strtolower($username);
     $usernameBase = strtolower($usernameBase);

    $randomPassword = substr(md5(rand()), 0, 7);
    echo $randomPassword;
    
    $options = [
        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
    ];
                                
    $hashedPassword = password_hash($randomPassword, PASSWORD_BCRYPT, $options);
     
    $sql = "INSERT INTO `employees` (`intEmployeeId`, `strFirstName`, `strLastName`,
    `strUsername`, `strUsernameBase`, `strEncryptedPassword`, `intSecurityLevel`,
    `strEmailAddress`, `securityQuestion1`, `securityQuestion1Answer`, 
    `securityQuestion2`, `securityQuestion2Answer`, `accountLocked`,
    `loginAttempts`, `securityQuestionAttempts`, `activeUser`, `firstAccess`) 
    VALUES ( '' , '$firstName', '$lastName' , '$username','$usernameBase',
    '$hashedPassword', '$securityLevel', '$email', '', '',
    '', '', 0, 0, 0, 1, 1)";

    $result = $conn->query($sql) or die("Query fail2");  
    
    $to      = $email;
    $subject = 'Your account has been created!';
    $message = 'Welcome to the Viridian Admin Portal!
                Your username is: '.$username.'
                Your temporary password is: '.$randomPassword;
    $headers = 'From: andreamoorman26@gmail.com' . "\r\n";

mail($to, $subject, $message, $headers);

   // header("location: /Management/manageUsers.php");
    }
?>
   