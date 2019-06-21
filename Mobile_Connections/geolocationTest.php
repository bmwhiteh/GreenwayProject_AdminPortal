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
    
    
//       $data = '{"location":[{"coords":{"speed":2.52,"longitude":-84.617125412353403,"floor":null,"latitude":40.480820434109447,"accuracy":4.7000000000000002,"altitude_accuracy":5.5999999999999996,"altitude":273.19999999999999,"heading":266.92000000000002},"extras":{},"is_moving":false,"event":"motionchange","odometer":6,"uuid":"3B2288F5-A854-460A-9F58-18218529F28F","activity":{"type":"in_vehicle","confidence":100},"battery":{"level":0.51999998092651367,"is_charging":false},"timestamp":"2019-06-15T03:43:08.792Z"},{"coords":{"speed":4.2800000000000002,"longitude":-84.618930949425121,"floor":null,"latitude":40.480889422043063,"accuracy":13.800000000000001,"altitude_accuracy":7.2000000000000002,"altitude":271.69999999999999,"heading":269.68000000000001},"extras":{},"is_moving":true,"event":"motionchange","odometer":159.30000000000001,"uuid":"EB1D29D4-9FFE-4FF6-B5F9-5D3DE4FA147A","activity":{"type":"in_vehicle","confidence":100},"battery":{"level":0.50999999046325684,"is_charging":false},"timestamp":"2019-06-15T03:43:38.617Z"},{"coords":{"speed":3.3199999999999998,"longitude":-84.619039613866775,"floor":null,"latitude":40.481067332053634,"accuracy":7.7000000000000002,"altitude_accuracy":6.5999999999999996,"altitude":272.10000000000002,"heading":359.56},"extras":{},"is_moving":true,"odometer":181.09999999999999,"uuid":"BCAB56C3-E50E-4D7A-AF9F-ADDEC3E6C2B4","activity":{"type":"in_vehicle","confidence":100},"battery":{"level":0.50999999046325684,"is_charging":false},"timestamp":"2019-06-15T03:43:48.000Z"},{"coords":{"speed":5.7999999999999998,"longitude":-84.619058148360509,"floor":null,"latitude":40.481302928879117,"accuracy":20.300000000000001,"altitude_accuracy":6.5999999999999996,"altitude":272.19999999999999,"heading":0.94999999999999996},"extras":{},"is_moving":true,"odometer":207.30000000000001,"uuid":"DB1769EA-3FDA-4F0D-8A18-9F2B02BE1E59","activity":{"type":"in_vehicle","confidence":100},"battery":{"level":0.50999999046325684,"is_charging":false},"timestamp":"2019-06-15T03:43:49.000Z"},{"coords":{"speed":8.7100000000000009,"longitude":-84.619053547046278,"floor":null,"latitude":40.481514088090087,"accuracy":7.7000000000000002,"altitude_accuracy":6.9000000000000004,"altitude":274,"heading":0.94999999999999996},"extras":{},"is_moving":true,"odometer":230.69999999999999,"uuid":"603A8B1E-847B-4C6D-85C6-7ECEB7A80C65","activity":{"type":"in_vehicle","confidence":100},"battery":{"level":0.50999999046325684,"is_charging":false},"timestamp":"2019-06-15T03:43:54.000Z"}],"device":{"uuid":"7F63E95C-16E3-4905-9DAD-7BBD2512A73B","manufacturer":"Apple","model":"iPhone11,8","framework":"Cordova","version":"12.2","platform":"iOS"}}';
    
                    
             
    //get the json data
    $data = file_get_contents("php://input");
     $data = strstr($data, '{"location"');
     $dataArray = json_decode($data, true);
      $sql = "INSERT INTO `databaseTests`(`dataSent`) VALUES ('hitting geolocationTest script fine')";
        $result = $conn->query($sql) or die("Query fail 1");  
        
        
       $sql = "INSERT INTO `databaseTests`(`dataSent`) VALUES ('$data')";
        $result = $conn->query($sql) or die("Query fail 2");  
        
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