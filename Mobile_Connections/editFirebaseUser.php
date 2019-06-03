<?php
    include("../MySQL_Connections/config.php");
   
    /*To avoid a CORS issue with Ionic include this check*/
    if(isset($_SERVER['HTTP_ORIGIN'])){
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); //what's this do?
    }
    
    /*This appears to be something included in the JSON*/
    if($_SERVER['REQUEST_METHOD']=='OPTIONS'){
        
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        
        exit(0);
    }
     
    //get the json data
    $data = file_get_contents("php://input");
   /*  $data = '
       {"userID":"SHEBe2yObJhPFxf1efaP6dcZ5pO2",
       "userBirthdate":"1993-01-01",
       "userHeight":0,
       "userWeight":50,
       "userGender":"O",
       "userLat":"38.58157",
       "userLng":"-121.4944"}
        ';
        */
    $sql = "INSERT INTO `databaseTests` (`dataSent`)
                VALUES ( '".$data."' );";
                
    $result = $conn->query($sql) or die("Query fail");  
    
    echo $data. "\n";

    //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $userId = $dataArray->userID;
        $userId = mysqli_real_escape_string($conn, $userId);
        
        $intHeight = $dataArray->userHeight;
        $intHeight = mysqli_real_escape_string($conn, $intHeight);
        
        $intWeight = $dataArray->userWeight;
        $intWeight = mysqli_real_escape_string($conn, $intWeight);
        
        $strGender = $dataArray->userGender;
        $strGender = mysqli_real_escape_string($conn, $strGender);

if($userId != ''){
    $sqlUpdateUserData = "UPDATE `firebaseusers` SET  
    `intHeight` = '$intHeight', `intWeight` = '$intWeight', `strGender` = '$strGender'
     WHERE `userId` = '$userId'";
    $resultUpdateUserData = $conn->query($sqlUpdateUserData) or die("Could not update User.");
    
    $result = $conn->query($sql);
}else{
    echo "No User Id";
}
?>