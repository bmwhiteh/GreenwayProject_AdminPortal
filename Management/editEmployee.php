<?php

require '../Mobile_Connections/vendor/autoload.php';
    include("../MySQL_Connections/config.php");
    
    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;

    $serviceAccount = ServiceAccount::fromJsonFile('../Mobile_Connections/firebase-adminsdk.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
    $auth = $firebase->getAuth();

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $displayName = $_GET['displayName'];
   $email = $_GET['email'];
    $securityLevel = $_GET['intSecurityLevel2'];
   $userId = $_GET['userId'];
    $sql = "UPDATE `firebaseusers` SET `intSecurityLevel` = '$securityLevel'
    WHERE `userId`= '$userId'";
    
    $resultset = $conn->query($sql) or die("Query fail");
    
    $userProperties = [
            'displayName' => $displayName,
            'email' => $email
        ];
        
        $updatedUser = $auth->updateUser($userId, $userProperties);
    }

?>
