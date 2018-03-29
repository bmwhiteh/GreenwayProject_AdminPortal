<?php
if (is_ajax()) {
     //make sure the data input includes that action value from the js
        if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
       
       //includes the database connection 
        include("../MySQL_Connections/config.php");
        //this returns a struct of input values sent by the form
         $return = $_POST;
         
        date_default_timezone_set('America/Indiana/Indianapolis');
        $offset =  date('Z') / 3600;
        $offsetString = (string) $offset;
        $hours = $offsetString[1];
        
         $startDate = $return['startDate'];
         $startTime = $return['startTime'];
         $combinedStart = date('Y-m-d H:i:s', strtotime("$startDate $startTime"));
         $combinedStart = new DateTime($combinedStart);
         $date = date_format($combinedStart,"Y-m-d H:i:s");
         $combinedStart=date("Y-m-d H:i:s", strtotime("$date + $hours hours"));
         $start = date_create("$combinedStart");
         $startDate = date_format($start,"Y-m-d");
         $startTime = date_format($start, "H:i:s");
         $endDate = $return['endDate'];
         $endTime = $return['endTime'];
         $combinedEnd = date('Y-m-d H:i:s', strtotime("$endDate $endTime"));
         $combinedEnd = new DateTime($combinedEnd);
         $date = date_format($combinedEnd,"Y-m-d H:i:s");
         $combinedEnd=date("Y-m-d H:i:s", strtotime("$date + $hours hours"));
         $end = date_create("$combinedEnd");
         $endDate = date_format($end,"Y-m-d");
         $endTime = date_format($end, "H:i:s");
         
        //this is the sql state that will go into the query
       // $sql = "SELECT `gpsLat`,`gpsLong` FROM `maintenancetickets` where (`dtSubmitted` > '". $startDate ."' and `dtSubmitted` < '". $endDate ."'
        //    or ( `dtSubmitted`= '". $startDate ."' and `time` > '". $startTime ."' ) or ( `dtSubmitted`= '". $endDate ."' and `time` < '". $endTime ."' )) and `gpsLat` != 0 and `gpsLong` != 0;";
        $sql = "SELECT `gpsLat`,`gpsLong` FROM `maintenancetickets` where `dtSubmitted` > '$startDate' and `dtSubmitted` < '$endDate' 
        or (`dtSubmitted`='$startDate' and `time` between '$startTime' and '$endTime') or (`dtSubmitted`='$endDate' and `time` between '$startTime' and '$endTime') and `gpsLat` != 0 and `gpsLong` != 0";
                $payLoad = json_encode(array($sql));
                $result = $conn->query($sql) or die($payLoad);
                $jsonReturnMessage = array();
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                  //add into the json as fields with subfields
                 
                 $location = array('gps point' => $row['gpsLat'] . "," . $row['gpsLong']);
                  
                  //add the gps location to te jsonReturnMessage
                  array_push($jsonReturnMessage, $location);
                }
                
       //return the encoded json
        $return["json"] = json_encode($jsonReturnMessage);
        echo json_encode($return);
        }
}    
    
    //Function to check if the request is an AJAX request
    function is_ajax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
  
?>

