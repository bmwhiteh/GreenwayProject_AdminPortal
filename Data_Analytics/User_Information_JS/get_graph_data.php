<?php
if (is_ajax()) {

    include("../../MySQL_Connections/config.php");
     
    $return = $_POST;
         
    $graphType = $return['action'];
    
    if($graphType == 'pie_chart'){
     
        //Distribution of Tickets (Pie Chart)
       $sql = "SELECT\n"
        . " COUNT(*) AS countUsers,\n"
        . " CASE\n"
        . " WHEN TIMESTAMPDIFF(YEAR, dtBirthdate, CURDATE()) BETWEEN 10 AND 20 THEN '10-20'\n"
        . " WHEN TIMESTAMPDIFF(YEAR, dtBirthdate, CURDATE()) BETWEEN 21 AND 30 THEN '21-30'\n"
        . " WHEN TIMESTAMPDIFF(YEAR, dtBirthdate, CURDATE()) BETWEEN 31 AND 40 THEN '31-40'\n"
        . " WHEN TIMESTAMPDIFF(YEAR, dtBirthdate, CURDATE()) BETWEEN 41 AND 50 THEN '41-50'\n"
        . " WHEN TIMESTAMPDIFF(YEAR, dtBirthdate, CURDATE()) BETWEEN 51 AND 60 THEN '51-60'\n"
        . " WHEN TIMESTAMPDIFF(YEAR, dtBirthdate, CURDATE()) >=61 THEN '61+'\n"
        . " END AS ageband\n"
        . "FROM\n"
        . "firebaseusers\n"
        . "GROUP BY ageband";
    }
    
    else if($graphType == 'get_zipcodes'){
     
        //Distribution of Tickets (Line Graph)
        $sql = "SELECT DISTINCT intZipcode\n"
            . "FROM firebaseusers\n"
            . " LIMIT 0, 30 ";

    }
    else if($graphType == 'bar_graph'){
         $sql = "select count(userId) as countUsers, intZipCode\n"
            . "from firebaseusers\n"
            . "group by intZipCode\n"
            . " LIMIT 0, 30 ";

    }
    else if($graphType == 'radar'){
     
        //Distribution of Tickets (Radar)
       $sql = "SELECT count(userId) AS countUsers, strGender, Month(dtCreated) as Month\n"
            . "FROM firebaseusers \n"
            . "GROUP BY strGender, Month(dtCreated)\n"
            . " LIMIT 0, 30 ";


    }
   
    
    $payLoad = json_encode(array($sql));
    $result = $conn->query($sql) or die($payLoad);
    
    $jsonReturnMessage = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
      //add into the json as fields with subfields
     
        if($graphType == 'pie_chart'){
            $slice = array('ticketType' => $row['countUsers'] . "," . $row['ageband']);
      
            array_push($jsonReturnMessage, $slice);
        }
        else if($graphType == 'line_graph'){
            $entry = array('ticketType' => $row['strTicketType'] . "," . $row['countTicketType'] . "," . $row['ticketMonth']);
      
            array_push($jsonReturnMessage, $entry);
        }
        else if($graphType == 'get_zipcodes'){
            $entry = array('zipCode' => $row['intZipcode'] );
      
            array_push($jsonReturnMessage, $entry);
        } 
        else if($graphType == 'radar'){
            $entry = array('ticketType' => $row['countUsers'] . "," . $row['strGender'] . "," . $row['Month']);
      
            array_push($jsonReturnMessage, $entry);
        }
        else if($graphType == 'bar_graph'){
            $entry = array('zipList' => $row['intZipCode'] . "," . $row['countUsers'] );
            
            array_push($jsonReturnMessage, $entry);
            
            
        }
    }
   
    $return["json"] = json_encode($jsonReturnMessage);
    echo json_encode($return);
    
}    
    
    //Function to check if the request is an AJAX request
    function is_ajax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    
  
?>

