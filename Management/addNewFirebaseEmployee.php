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
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
     
    $displayName = $_POST['displayName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $securityLevel = $_POST['intSecurityLevel'];
    
   $auth->createUserWithEmailAndPassword($email, $password);
    $user = $auth->getUserByEmail($email);
    $userId = $user->uid;
    
    $properties = [
    'displayName' => $displayName
    ];
    
    $auth->updateUser($userId, $properties);
    //$auth->sendEmailVerification($userId);
 
  $user = $auth->getUserByEmail($email);
    $displayName = $user->displayName;
    
     $sql = "INSERT INTO `firebaseusers` (`userId`, `bitSendPics`, `accountLocked`, `active`, 
     `dtBirthdate`, `dtCreated`, `intZipCode`, `intWeight`,
     `intHeight`, `strGender`, `intSecurityLevel`, `loggedIntoAdmin`)
     VALUES ('$userId', 1 , 0, 0, '0000-00-00',CURDATE(), 0, 0,0, 'O', '$securityLevel', 0)";

     $result = $conn->query($sql) or die("Failed to add user");

     $date= new DateTime($phoneDateTime); 
     $date->setTimeZone(new DateTimeZone('UTC'));
     $dateReceived =$date->format('Y-m-d h:i:s a');
     
     $sqlTask = "UPDATE `tasks` SET `lastCompleted`= '$dateReceived' WHERE `taskId`= '2'";
    $resultTask = $conn->query($sqlTask) or die("Update fail");
    }
?>
   