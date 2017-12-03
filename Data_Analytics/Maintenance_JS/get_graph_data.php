<?php
if (is_ajax()) {

    include("../../MySQL_Connections/config.php");
     
    $return = $_POST;
         
    $graphType = $return['action'];
    
    if($graphType == 'pie_chart'){
     
        //Distribution of Tickets (Pie Chart)
        $sql = "SELECT COUNT( intTicketId )  AS countTicketType, strTicketType\n"
                . "FROM maintenancetickets\n"
                . "LEFT JOIN tickettypes ON tickettypes.intTypeId =maintenancetickets.intTypeId\n"
                . "GROUP BY maintenancetickets.intTypeId\n"
                . " LIMIT 0, 30 ";
    }
    else if($graphType == 'line_graph'){
     
        //Distribution of Tickets (Line Graph)
        $sql = "SELECT count(intTicketId) AS countTicketType, Month(dtSubmitted) as ticketMonth, strTicketType\n"
            . "FROM `maintenancetickets`\n"
            . "left join tickettypes on tickettypes.inttypeid = maintenancetickets.inttypeid\n"
            . "WHERE YEAR(dtSubmitted) = YEAR(CURDATE())\n"
            . "GROUP BY MONTH(dtSubmitted),maintenancetickets.inttypeid\n"
            . "LIMIT 0, 30\n"
            . "\n"
            . "";

    }
    else if($graphType == 'get_ticket_types'){
     
        //Distribution of Tickets (Line Graph)
        $sql = "SELECT strTicketType\n"
            . "FROM `tickettypes`\n"
            . "LIMIT 0, 30\n"
            . "\n"
            . "";

    }
    else if($graphType == 'bar_chart'){
     
        //Distribution of Tickets (Bar Graph)
       $sql = "SELECT Month(dtSubmitted) as dtMonth,\n"
            . "	(\n"
            . " select count(intTicketId) \n"
            . " from maintenancetickets \n"
            . " where dtClosed IS NULL and Month(dtSubmitted) Like dtMonth \n"
            . " ) as countOpenTickets, \n"
            . "	\n"
            . "	(\n"
            . " select count(intTicketId) \n"
            . " from maintenancetickets \n"
            . " where dtClosed IS NOT NULL and Month(dtSubmitted) Like dtMonth \n"
            . " ) as countClosedTickets\n"
            . "\n"
            . "	\n"
            . "FROM maintenancetickets mt\n"
            . "group by Month(dtSubmitted) LIMIT 0, 30 ";


    }
    else if($graphType == 'ticket_list'){
     
       // Distribution of Tickets (Ticket List) using the user logged in
    /* $sql = "SELECT intTicketId, strTicketType, dtSubmitted\n"
    . "FROM `maintenancetickets`\n"
    . "LEFT JOIN tickettypes on tickettypes.inttypeid = maintenancetickets.inttypeid\n"
    . "LEFT JOIN employees on employees.intEmployeeId = maintenancetickets.intemployeeassigned\n"
    . "WHERE strUsername ='\n"
    . $_Cookie["user"] . "'";*/
    
    $sql = "SELECT intTicketId, strTicketType, dtSubmitted\n"
    . "FROM `maintenancetickets`\n"
    . "LEFT JOIN tickettypes on tickettypes.inttypeid = maintenancetickets.inttypeid\n"
    . "LEFT JOIN employees on employees.intEmployeeId = maintenancetickets.intemployeeassigned\n"
    . "WHERE strUsername = 'bmwhiteh'";

    
        
    }
    
    $payLoad = json_encode(array($sql));
    $result = $conn->query($sql) or die($payLoad);
    
    $jsonReturnMessage = array();
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
      //add into the json as fields with subfields
     
        if($graphType == 'pie_chart'){
            $slice = array('ticketType' => $row['strTicketType'] . "," . $row['countTicketType']);
      
            array_push($jsonReturnMessage, $slice);
        }
        else if($graphType == 'line_graph'){
            $entry = array('ticketType' => $row['strTicketType'] . "," . $row['countTicketType'] . "," . $row['ticketMonth']);
      
            array_push($jsonReturnMessage, $entry);
        }
        else if($graphType == 'get_ticket_types'){
            $entry = array('ticketType' => $row['strTicketType'] );
      
            array_push($jsonReturnMessage, $entry);
        } 
        else if($graphType == 'bar_chart'){
            $entry = array('ticketType' => $row['dtMonth'] . "," . $row['countOpenTickets'] . "," . $row['countClosedTickets']);
      
            array_push($jsonReturnMessage, $entry);
        }
        else if($graphType == 'ticket_list'){
            $entry = array('ticketType' => $row['intTicketId'] . "," . $row['strTicketType'] . "," . $row['dtSubmitted']);
            
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

