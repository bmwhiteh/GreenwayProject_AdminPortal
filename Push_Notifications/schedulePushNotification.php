<?php
    include("../MySQL_Connections/config.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
     //date_default_timezone_set('America/Indiana/Indianapolis');    
    $message = $_POST['message'];
    $date = $_POST['dtSend'];
    $time = $_POST['timeSend'];
    $type = $_POST['strNotificationType'];
    
   /* $sql = "SELECT * FROM `users` WHERE `bitReceiveNotifications` = 1";
    $result = $conn->query($sql) or die("Query fail");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $active = $row['active'];
    $usersReceivingNotifications =  $result->num_rows;*/
    
    /*$test = json_decode($return["allresponses"], true);
    echo "Recipients: " . $test['recipients'] . PHP_EOL;
    $usersReceivingNotifications = $test['recipients'] . PHP_EOL;*/
    
    function sendMessage($message, $sendDate, $sendTime, $type){
    date_default_timezone_set('America/Indiana/Indianapolis');
    $utc_offset =  date('Z') / 3600;
    $offset = "UTC".$utc_offset."00";
    $sendDateTime = $sendDate. " ". $sendTime." " . $offset;
    $content = array(
        "en" => $message
        );
    $header = array(
        "en" => "New ". $type. "!"
        );

    $fields = array(
        'app_id' => "eecf381c-62fd-4ac7-ac38-4496d79c71fb",
        'included_segments' => array('All'),
        'data' => array("foo" => "bar"),
        'large_icon' =>"ic_launcher_round.png",
        'headings' => $header,
        'contents' => $content,
        'send_after' => $sendDateTime
    );

    $fields = json_encode($fields);
print("\nJSON sent:\n");
print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic YjQyMzY3NDQtOWE4NS00MDc1LWE1ZTMtZGExMjRkN2FhOThi'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

 //   sendMessage($message, $date, $time, $type);
   $response = sendMessage($message, $date, $time);
    $return["allresponses"] = $response;

$test = json_decode($return["allresponses"], true);
$oneSignalId = $test['id'] . PHP_EOL;

$sql = "INSERT INTO `pushnotifications` (`intNotificationId`, `oneSignalId`, `strNotificationType`, `strNotificationContent`, `dtSentToUsers`, `dtReceivedFromAPI`, `time`, `intSevereWeatherAlertsSent`, `strJSONMessage`)
    VALUES ( '' , '".$oneSignalId."', '".$type."', ' '  , '".$date."' , NULL, '".$time."' , '0', '".$message."');";
    $result = $conn->query($sql) or die("Query fail 2");  
    
    //date_default_timezone_set('America/Indiana/Indianapolis');
   $taskDate = date('Y-m-d h:i:s a');
    
    $sql = "UPDATE `tasks` SET `lastCompleted`= '$taskDate' WHERE `taskId`= '12'";
    $result = $conn->query($sql) or die("Update fail");
    header("location: /Push_Notifications/notifications.php");
    }
?>
   