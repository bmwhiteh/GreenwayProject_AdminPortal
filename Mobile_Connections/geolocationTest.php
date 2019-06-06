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
    
    
    //   $data = 'Geolocation: {"location":[{"coords":{"speed":25.59,"longitude":
    //         -84.42680611282999,"floor":null,"latitude":40.43682100255083,
    //         "accuracy":5,"altitude_accuracy":4,"altitude":293.1,"heading":
    //             89.65000000000001},"extras":{},"is_moving":false,"event":"motionchange","odometer":868.2,"uuid":"BBE5865E-D736-4911-8406-3F8E91EAE40C",
    //             "activity":{"type":"in_vehicle","confidence":100},"battery":
    //                 {"level":0.53,"is_charging":false},"timestamp":
    //                     "2019-03-01T12:57:18.798Z"},{"coords":{"speed":25.55,
    //                     "longitude":-84.42650444813485,"floor":null,"latitude"
    //                     :40.43681731451343,"accuracy":5,"altitude_accuracy":4,
    //                     "altitude":292.9,"heading":90.34999999999999},"extras":
    //                         {},"is_moving":true,"event":"motionchange","odometer"
    //                         :0,"uuid":"D76F8368-4061-4F66-A5F4-CAC8129BBF5F",
    //                         "activity":{"type":"in_vehicle","confidence":100},
    //                         "battery":{"level":0.53,"is_charging":false},
    //             "timestamp":"2019-05-22T12:57:19.622Z"}],"device":
    //                 {"uuid":"32E4CD79-1B0F-4914-A259-E7F080B2DC05",
    //                 "manufacturer":"Apple","model":"iPhone8,1",
    //                 "framework":"Cordova","version":"10.3.3","platform":"iOS"}}';
    
                    
             
    //get the json data
    $data = file_get_contents("php://input");
     $data = strstr($data, '{"location"');
     $dataArray = json_decode($data, true);
      $sql = "INSERT INTO `databaseTests`(`dataSent`) VALUES ('hitting geolocationTest script fine')";
        $result = $conn->query($sql) or die("Query fail");  
        
        
       $sql = "INSERT INTO `databaseTests`(`dataSent`) VALUES ($data)";
        $result = $conn->query($sql) or die("Query fail");  
        
     $coordsArray = $dataArray['location'][0]['coords'];
     $geolocationArray = $dataArray['location'];
     $arrayLength = count($geolocationArray);
     $deviceUUID = $dataArray['device']['uuid'];
     
     for($i = 0; $i < $arrayLength; $i++){
         $coordsArray = $geolocationArray[$i]['coords'];
         $timeStamp = $geolocationArray[$i]['timestamp'];
         
        $longitude = $coordsArray['longitude'];
        $latitude =  $coordsArray['latitude'];
        
        $geolocationDateTime = new DateTime($timeStamp);
        $geolocationDateTime->setTimeZone(new DateTimeZone('UTC'));
        $geolocationDate =$geolocationDateTime->format('Y-m-d');
        $geolocationTime =$geolocationDateTime->format('H:i:s'); 
          
             $sql = "INSERT INTO `locationData` (
                         `gpsLat`, 
                         `gpsLong`,
                         `activityDate`,
                         `time`,
                         `intActivityId`
                      )
                      VALUES ( 
                         '$latitude' ,
                         '$longitude',
                         '$geolocationDate',
                         '$geolocationTime',
                         '$deviceUUID'
                      )";
                
         $result = $conn->query($sql) or die("Query fail");  
     }
     
     $sql2 = "SELECT * FROM `activities` WHERE `deviceId`='$deviceUUID' order by `id` desc limit 1";
     $result2 = $conn->query($sql2) or die("Query fail"); 
     $row = $result2->fetch_array(MYSQLI_ASSOC);
     $id = $row['id'];

  $sql3 = "UPDATE `locationData` SET `intActivityId`='$id' WHERE `intActivityId`='$deviceUUID'";
  $result3 = $conn->query($sql3) or die("Query fail");  
    
?>