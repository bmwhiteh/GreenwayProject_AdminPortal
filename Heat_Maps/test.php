<?php include("../MySQL_Connections/config.php");

        
$startDate = "03/21/2018";
$startTime = "12:01 AM";
$endDate = "03/20/2018";
$endTime = "01:59 AM";

  date_default_timezone_set('America/Indiana/Indianapolis');
        $offset =  date('Z') / 3600;
        $offsetString = (string) $offset;
        $hours = $offsetString[1];

        // $startDate = $return['startDate'];
         //$startTime = $return['startTime'];
         $combinedStart = date('Y-m-d H:i:s', strtotime("$startDate $startTime"));
         $combinedStart = new DateTime($combinedStart);
         $date = date_format($combinedStart,"Y-m-d H:i:s");
         $combinedStart=date("Y-m-d H:i:s", strtotime("$date + $hours hours"));
         $start = date_create("$combinedStart");
         $startDate = date_format($start,"Y-m-d");
         $startTime = date_format($start, "H:i:s");
         $combinedEnd = date('Y-m-d H:i:s', strtotime("$endDate $endTime"));
         $combinedEnd = new DateTime($combinedEnd);
         $date = date_format($combinedEnd,"Y-m-d H:i:s");
         $combinedEnd=date("Y-m-d H:i:s", strtotime("$date + $hours hours"));
         $end = date_create("$combinedEnd");
         $endDate = date_format($end,"Y-m-d");
         $endTime = date_format($end, "H:i:s");
         echo "Start Date: " . $startDate . "\n";
         echo "Start Time: " . $startTime . "\n";
         echo "End Date: " . $endDate . "\n";
         echo "End Time: " . $endTime . "\n";
         
         $sql = "SELECT `gpsLat`,`gpsLong` FROM `locationData` where `activityDate` > '". $startDate ."' and `activityDate` < '". $endDate ."'
            or ( `activityDate`= '". $startDate ."' and `time` > '". $startTime ."' ) or ( `activityDate`= '". $endDate ."' and `time` < '". $endTime ."' );";
         echo $sql;
         $payLoad = json_encode(array($sql));
                $result = $conn->query($sql) or die($payLoad);
                $jsonReturnMessage = array();
                $row = $result->fetch_array(MYSQLI_ASSOC) or die("sucks");
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                  //add into the json as fields with subfields
                 $location = array('gps point' => $row['gpsLat'] . "," . $row['gpsLong']);
                  
                  //push the gps location to jsonReturnMessage
                  array_push($jsonReturnMessage, $location);
                }
        
        
       //return the encoded json
        $return["json"] = json_encode($jsonReturnMessage);
       // echo json_encode($return);
// $combinedStart = date('Y-m-d H:i:s', strtotime("$startDate $startTime"));
// $combinedStart = new DateTime($combinedStart);
// $date = date_format($combinedStart,"m/d/Y H:i:s");
// date_default_timezone_set('America/Indiana/Indianapolis');
// $offset =  date('Z') / 3600;
// $offsetString = (string) $offset;
// $hours = $offsetString[1];
// $test=date("m/d/Y H:i:s", strtotime("$date + $hours hours"));
// echo gettype($test);
// $date=date_create("$test");
// echo date_format($date,"Y/m/d");
// echo gettype($date);
// echo $test;
?>