<?php
/*<!--- This is where the jsons will be sent--->*/

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
    
    
    $sql = "INSERT INTO `databaseTests` (`dataSent`)
                VALUES ( '".$data."' );";
                
    $result = $conn->query($sql) or die("Query fail");  
    
  /*  $data = 
        '{
            "userId":"1148",
            "activityId": "",
            "currentTime":"2018-02-19T18:13:19.952Z"
        
        }';*/
    //echo $data;
    
     if(isset($data)){     
        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $intUserId = $dataArray->userId;
        $intActivityId = $dataArray->activityId;
        if(isset($dataArray->currentTime)){
            $phoneDateTime = $dataArray->currentTime; //example: 2018-02-19T18:13:19.952Z
            $dateStart = new DateTime($phoneDateTime); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $startDate =$dateStart->format('Y-m-d');
            $startTime =$dateStart->format('H:i:s');    
        
        }else{
            
            $dateStart = new DateTime('now'); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $startDate =$dateStart->format('Y-m-d');
            $startTime =$dateStart->format('H:i:s');    
           
        }
        
        if((($intActivityId == NULL)||($intActivityId == ''))&&isset($intUserId)){
            //it's a new activity
            
            //store the new activity
            $sqlAddNewActivity = "INSERT INTO `userActivities`(`intUserId`, `startDate`, `startTime`) VALUES ('".$intUserId."','".$startDate."','".$startTime."')";
            $resultAddNewActivity = $conn->query($sqlAddNewActivity);

            if($resultAddNewActivity == TRUE){

                //get the just created id
                $sqlGetResponse = "SELECT intActivityId FROM `userActivities` ORDER BY intActivityId desc LIMIT 0, 1 ";            
                $resultGetResponse = $conn->query($sqlGetResponse);
    
                 if ($resultGetResponse->num_rows > 0) {
                    // output data of each row
                    while($row = $resultGetResponse->fetch_assoc()) {
                        $newActivityId = $row["intActivityId"];
                        //echo $row["intActivityId"];
                    }
                } else {
                    //echo -1;
                }
            }else{
                echo -6; //Activity was not created
            }
          
            if(isset($newActivityId)){
                $intActivityId = $newActivityId;
                
                $sqlSetActive = "UPDATE `users` SET `active`= '1' WHERE `intUserId` = '$intUserId'";
                $resultSetActive = $conn->query($sqlSetActive); 
                echo $intActivityId;
                
                
            }else{
                //echo -1; //"No Activity Id.";
            }
        }

     }
    
?>