<?php
if (is_ajax()) {
     //make sure the data input includes that action value from the js
        if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
        
        //include the database connection
        include("../MySQL_Connections/config.php");
        //this returns a struct of input values sent by the form
         $return = $_POST;
         
         $startDate = $return['startDate'];
         $startTime = $return['startTime'];
         $endDate = $return['endDate'];
         $endTime = $return['endTime'];
         
        //this is the sql state that will go into the query
        $sql = "SELECT `gpsLat`,`gpsLong` FROM `locationData` where `activityDate` > '". $startDate ."' and `activityDate` < '". $endDate ."'
            or ( `activityDate`= '". $startDate ."' and `time` > '". $startTime ."' ) or ( `activityDate`= '". $endDate ."' and `time` < '". $endTime ."' );";
            
                $payLoad = json_encode(array($sql));
                $result = $conn->query($sql) or die($payLoad);
                $jsonReturnMessage = array();
                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                  //add into the json as fields with subfields
                 
                 $location = array('gps point' => $row['gpsLat'] . "," . $row['gpsLong']);
                  
                  //push the gps location to jsonReturnMessage
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

