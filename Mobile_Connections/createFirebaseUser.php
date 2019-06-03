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
                VALUES ( 'Create New Firebase User json: ".$data."' );";
                
    $result = $conn->query($sql) or die("Query fail");  
    
    echo $data. "\n";
     
  
       

    //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $userId = $dataArray->userID;
        $userId = mysqli_real_escape_string($conn, $userId);
        
        $dtBirthdate = $dataArray->userBirthdate;
        $dtBirthdate = mysqli_real_escape_string($conn, $dtBirthdate);
        
        $intHeight = $dataArray->userHeight;
        $intHeight = mysqli_real_escape_string($conn, $intHeight);
        
        $intWeight = $dataArray->userWeight;
        $intWeight = mysqli_real_escape_string($conn, $intWeight);
        
        $strGender = $dataArray->userGender;
        $strGender = mysqli_real_escape_string($conn, $strGender);
        
        //$strLat = "38.58157";    
        $strLat = $dataArray->userLat;
        //$strLong = "-121.4944";     
        $strLong = $dataArray->userLng;
    
            
            $intZipCode = 0;
            if($strLat != "" && $strLong !=""){
                // google map geocode api url
                $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$strLat,$strLong&key=AIzaSyBDPrizY3A8DH-BaSuHsSLy6-WObmEvAd4";
              
                // get the json response
                $resp_json = file_get_contents($url);
                
                // decode the json
                $resp = json_decode($resp_json, true);
         
                // response status will be 'OK', if able to geocode given address 
                if($resp['status']=='OK'){
                        $arrayLength = count($resp['results'][0]['address_components']);
                        $regex = "^\d{5}^";
                        for($i = 0; $i < $arrayLength; $i++){
                            $tempZip = $resp['results'][0]['address_components'][$i]['long_name'];
                            if (preg_match($regex, $tempZip)) {
                                $intZipCode = $tempZip;
                            }
                           // echo "iteration $i Zip Code: $intZipCode";
                        }
                         //echo $intZipCode;
                }
            }
        
        if(isset($dataArray->currentTime)){
            $phoneDateTime = $dataArray->currentTime; //example: 2018-02-19T18:13:19.952Z
            $dateStart= new DateTime($phoneDateTime); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $dateReceived  =$dateStart->format('Y-m-d');
            $taskDateReceived =$dateStart->format('Y-m-d h:i:s a');
        
        }else{
            $dateStart = new DateTime('now'); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $dateReceived =$dateStart->format('Y-m-d');
            $taskDateReceived =$dateStart->format('Y-m-d h:i:s a');
        }

if($userId != ''){
    $sql = "INSERT INTO `firebaseusers` (
                        `userId`, 
                        `dtBirthdate`,
                        `dtCreated`,
                        `intHeight`, 
                        `intWeight`,
                        `strGender`,
                        `intZipCode`
                    )
                    VALUES ( 
                        '$userId' ,
                        '$dtBirthdate',
                        '$dateReceived',
                        '$intHeight',
                        '$intWeight',
                        '$strGender',
                        '$intZipCode'
                    )";
                    
            
    $result = $conn->query($sql);
    
    $sqlTask = "UPDATE `tasks` SET `lastCompleted`= '$taskDateReceived' WHERE `taskId`= '1'";
    $resultTask = $conn->query($sqlTask) or die("Update fail");
}
?>