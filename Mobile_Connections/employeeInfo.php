<?php
    require 'vendor/autoload.php';
    include("../MySQL_Connections/config.php");
    /*To avoid a CORS issue with Ionic include this check*/
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); //what's this do?
    }
    /*This appears to be something included in the JSON*/
    if ($_SERVER['REQUEST_METHOD']=='OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        exit(0);
    }
    
    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;

    $serviceAccount = ServiceAccount::fromJsonFile('firebase-adminsdk.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
    $auth = $firebase->getAuth();
    
    $employeesSql = "SELECT `userId` FROM `firebaseusers` WHERE `intSecurityLevel` < 4";
    $employeesResults = $conn->query($employeesSql);
    $employeesObj = array();
    while ($row = $employeesResults->fetch_array(MYSQLI_ASSOC)) {
        $user = $auth->getUser($row['userId']);
        
        
        $employee = (object)array();
        $employee->userID = $row['userId'];
        $employee->userName = $user->displayName;
        array_push($employeesObj, $employee);
    }
    echo json_encode($employeesObj);
?>