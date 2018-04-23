<?php
include("../MySQL_Connections/config.php");
include("../Push_Notifications/sendNotifications.php");
$json_string = file_get_contents('http://api.wunderground.com/api/c6db81b4b23e7f0e/alerts/q/IN/Fort_Wayne.json');
//$json_string = file_get_contents('./weatherTest.json');
$data = json_decode($json_string, true);

// first create a connection to your database
date_default_timezone_set('UTC');
$date = date('m/d/Y h:i:s a', time());
$sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '10'";
$result = $conn->query($sql) or die("Update fail");

// for each of the 'rows' of data in the json we parsed, we will insert each value
// into it's corresponding column in the database
foreach ($data['alerts'] as $key => $value) {
    $description = $value['description'];
    $date = $value['date'];
    $sql = "SELECT * FROM `pushnotifications` WHERE `strNotificationContent`= '$description' && `strDateTime`= '$date'";
    $result = $conn->query($sql) or die("Query fail");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $count =  $result->num_rows;
    if($count == 0){
        $response =sendMessage($value['message']);
        $return["allresponses"] = $response;

        $test = json_decode($return["allresponses"], true);
        echo "Recipients: " . $test['recipients'] . PHP_EOL;
        $usersReceivingNotifications = $test['recipients'] . PHP_EOL;
        $oneSignalId = $test['id'] . PHP_EOL;

        $date = $value['date'];
        $description = $value['description'];
        $message =  $value['message'];
        $dt = date("y-m-d");
        $addNotificationSql = "INSERT INTO `pushnotifications`(`oneSignalId`, `strNotificationType`, `strNotificationContent`, `dtSentToUsers`, `dtReceivedFromAPI`, `strDateTime` ,`intSevereWeatherAlertsSent`, `strJSONMessage`)
        VALUES ('$oneSignalId','Severe Weather','$description','$dt','$dt','$date',$usersReceivingNotifications,'$message')";
        $addNotificationResult = $conn->query($addNotificationSql) or die("Insert fail");

        date_default_timezone_set('UTC');
        $date = date('m/d/Y h:i:s a', time());

        $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '11'";
        $result = $conn->query($sql) or die("Update fail");

    }
}

// close the connection to the database
$conn->close();
?>