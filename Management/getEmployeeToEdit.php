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
    
    $userId = $_POST['id'];
    
    $employeesSql = "SELECT * FROM `firebaseusers` WHERE `userId` = '$userId' ";
    $employeesResults = $conn->query($employeesSql);
    $employeesObj = array();
    while ($row = $employeesResults->fetch_array(MYSQLI_ASSOC)) {
        $user = $auth->getUser($row['userId']);
       // $employeeObj = $user;
        $employeeObj = array($user->displayName, $user->email, $row['intSecurityLevel']);
    }       
    echo json_encode($employeeObj);      
               
?>