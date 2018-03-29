<?php
include("../MySQL_Connections/config.php");
include("../Push_Notifications/sendNotifications.php");
//$json_string = file_get_contents('http://api.wunderground.com/api/c6db81b4b23e7f0e/alerts/q/IN/Fort_Wayne.json');
$json_string = file_get_contents('./weatherTest.json');
$data = json_decode($json_string, true); 

// first create a connection to your database
$mysqli = new mysqli('localhost', 'whitbm06', 'WebDev2017', 'viridian_capstone_project');

date_default_timezone_set('UTC');
$date = date('m/d/Y h:i:s a', time());
$sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '10'";
$result = $conn->query($sql) or die("Update fail");

/*$sql = "SELECT * FROM `users` WHERE `bitReceiveNotifications` = 1";
    $result = $conn->query($sql) or die("Query fail");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $active = $row['active'];
    $usersReceivingNotifications =  $result->num_rows;*/
    
// this insert query defines the table, and columns you want to update
$query = <<<SQL
INSERT INTO `pushnotifications`(`intNotificationId`, `strNotificationType`, `strNotificationContent`, `dtSentToUsers`, `dtReceivedFromAPI`, `strDateTime` ,`intSevereWeatherAlertsSent`, `strJSONMessage`)
VALUES (?,?,?,?,?,?,?,?)
SQL;

$stmt = $mysqli->prepare($query);

// for each of the 'rows' of data in the json we parsed, we will insert each value
// into it's corresponding column in the database, and we are doing this using prepared
// statements.
foreach ($data['alerts'] as $key => $value) {
    $description = $value['description'];
    $date = $value['date'];
    $sql = "SELECT * FROM `pushnotifications` WHERE `strNotificationContent`= '$description' && `strDateTime`= '$date'";
    $result = $conn->query($sql) or die("Query fail");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $count =  $result->num_rows;
    
    $response =sendMessage($value['message']);
        $return["allresponses"] = $response;

$test = json_decode($return["allresponses"], true);
echo "Recipients: " . $test['recipients'] . PHP_EOL;
$usersReceivingNotifications = $test['recipients'] . PHP_EOL;

    if($count == 0){
        $stmt->bind_param(
            // the types of the data we are about to insert: s = string, i = int
            'isssssis', 
            $a = '',
            $b = 'Severe Weather',
            $value['description'],
            $c = date("y-m-d"),
            $d = date("y-m-d"),
            $value['date'],
            $usersReceivingNotifications,
            $value['message']
        );
    
        $stmt->execute();
        
        date_default_timezone_set('UTC');
    $date = date('m/d/Y h:i:s a', time());
    
    $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '11'";
    $result = $conn->query($sql) or die("Update fail");
    
    }
}

$stmt->close();

// close the connection to the database
$mysqli->close();

//sendMessage($value['message']);
?>