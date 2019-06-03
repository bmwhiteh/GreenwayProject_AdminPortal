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

    //JSON must be decoded using PHP function
    $dataArray = json_decode($data);
    $message = $dataArray->notifMessage;
    $message = mysqli_real_escape_string($conn, $message);
    $date = $dataArray->date;
    $date = mysqli_real_escape_string($conn, $date);
    $time = $dataArray->time;
    $time = mysqli_real_escape_string($conn, $time);
    $type = $dataArray->notifType;
    $type = mysqli_real_escape_string($conn, $type);
    if ($type == 'Trail Closure') {
        $intType = 1;
    } else {
        $intType = 2;
    }
    
    function sendMessage($message, $sendDate, $sendTime, $type) {
        date_default_timezone_set('America/Indiana/Indianapolis');
        $utc_offset =  date('Z') / 3600;
        $offset = "UTC".$utc_offset."00";
        $sendDateTime = $sendDate. " ". $sendTime." " . $offset;
        $content = array("en" => $message);
        $header = array("en" => "New ". $type. "!");
        $fields = array(
            'app_id' => "7df26352-e23a-40db-9ce3-31c5e383bcf8",
            'included_segments' => array('All'),
            'large_icon' =>"ic_launcher_round.png",
            'headings' => $header,
            'contents' => $content,
            'send_after' => $sendDateTime
        );
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                    'Authorization: Basic NTcxMjE0NTgtYTE0Yy00YmFlLWEyNzktZjFhMDA1NGViODc4'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
        $response = curl_exec($ch);
        echo($response);
        curl_close($ch);
        return $response;
    }
    
    $response = sendMessage($message, $date, $time, $type);
    $return["allresponses"] = $response;
    $test = json_decode($response, true);
    $oneSignalId = $test['id'] . PHP_EOL;
    $sql = "INSERT INTO `pushnotifications` (`intNotificationId`, `oneSignalId`, `strNotificationType`, `intType`, `strNotificationContent`, `dtSentToUsers`, `dtReceivedFromAPI`, `time`, `intSevereWeatherAlertsSent`, `strJSONMessage`)
            VALUES ( '' , '".$oneSignalId."', '".$type."', $intType, ' '  , '".$date."' , NULL, '".$time."' , '0', '".$message."');";
    $result = $conn->query($sql) or die("Query fail 2");
    
    $date = new DateTime('now'); 
    $date->setTimeZone(new DateTimeZone('UTC'));
    $taskDate = $date->format('Y-m-d h:i:s a');
    
    $sql = "UPDATE `tasks` SET `lastCompleted`= '$taskDate' WHERE `taskId`= '12'";
    $result = $conn->query($sql) or die("Update fail");
?>