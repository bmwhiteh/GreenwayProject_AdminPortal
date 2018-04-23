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

                 $sqlStoreLocation = "INSERT INTO `ErrorReporting` (`strErrorActivity`, `occurenceLocation`)
                    VALUES ( '$combinedStart', 'LINE 24: filterTicketDensity.php' )";
            $resultStoreLocation = $conn->query($sqlStoreLocation); 
         $endDate = $return['endDate'];
         $endTime = $return['endTime'];
         $combinedEnd = date('Y-m-d H:i:s', strtotime("$endDate $endTime"));
         $combinedEnd = new DateTime($combinedEnd);
         $date = date_format($combinedEnd,"Y-m-d H:i:s");
         $combinedEnd=date("Y-m-d H:i:s", strtotime("$date + $hours hours"));
         
           $sqlStoreLocation = "INSERT INTO `ErrorReporting` (`strErrorActivity`, `occurenceLocation`)
                    VALUES ( '$combinedEnd', 'LINE 24: filterTicketDensity.php' )";
            $resultStoreLocation = $conn->query($sqlStoreLocation);
         
        $sql = "SELECT `gpsLat`,`gpsLong` FROM `maintenancetickets` WHERE (TIMESTAMP(`dtSubmitted`,`time`) BETWEEN '$combinedStart' AND '$combinedEnd') and `gpsLat` != 0 and `gpsLong` != 0";
       
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

