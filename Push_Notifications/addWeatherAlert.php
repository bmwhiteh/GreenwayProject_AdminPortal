<?php
include("../MySQL_Connections/config.php");
$json_string = file_get_contents('./weatherTest.json');

$data = json_decode($json_string, true); 

// first create a connection to your database
$mysqli = new mysqli('localhost', 'whitbm06', 'WebDev2017', 'viridian_capstone_project');

$sql = "SELECT * FROM `users` WHERE `bitReceiveNotifications` = 1";
    $result = $conn->query($sql) or die("Query fail");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $active = $row['active'];
    $usersReceivingNotifications =  $result->num_rows;
    
// this insert query defines the table, and columns you want to update
$query = <<<SQL
INSERT INTO `pushnotifications`(`intNotificationId`, `strNotificationType`, `strNotificationContent`, `dtSentToUsers`, `dtReceivedFromAPI`, `intUsersSentTo`, `strJSONMessage`)
VALUES (?,?,?,?,?,?,?)
SQL;

$stmt = $mysqli->prepare($query);

// for each of the 'rows' of data in the json we parsed, we will insert each value
// into it's corresponding column in the database, and we are doing this using prepared
// statements.
foreach ($data['alerts'] as $key => $value) {
    $stmt->bind_param(
        // the types of the data we are about to insert: s = string, i = int
        'issssis', 
        $a = '',
        $b = 'Severe Weather',
        $value['description'],
        $c = date("y-m-d"),
        $d = date("y-m-d"),
        $usersReceivingNotifications,
        $value['message']
    );

    $stmt->execute();
}

$stmt->close();

// close the connection to the database
$mysqli->close();