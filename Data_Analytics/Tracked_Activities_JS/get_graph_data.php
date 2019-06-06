<?php
if (is_ajax()) {
    include("../../MySQL_Connections/config.php");
     
        $currentDate = date ("Y-m-d");
        //echo $currentDate;
        $dtMinus1Year = strtotime($currentDate.' -1 year');
        $dtMinus1Year = date("Y-m-d",$dtMinus1Year);
        //echo $dtMinus1Year;
        
        
       
       
            
    
       /*     
    //time spent on trails by month
        $sql = "SELECT sum(timeTotalDuration), month(startDate) FROM `activities` WHERE startDate >= $dtMinus1Year\n"
            . "GROUP BY Month(startDate)";
            
            
    //avg calories burned
        $sql = "SELECT avg(calTotalCalories), month(startDate) FROM `activities` WHERE startDate >= $dtMinus1Year\n"
            . "GROUP BY Month(startDate)";
            
    //Distribution of Activities (Pie Chart)
        
  
            
        $payLoad = json_encode(array($sql));
        $result = $conn->query($sql) or die($payLoad);
     //Activity Type versus month (Line Chart)
    
    //Activity Count versus Month (Radar Chart)
    
    */
     
     
    $return = $_POST;
         
    $graphType = $return['action'];
    
    if($graphType == 'pie_chart'){
        $sql = "SELECT count(id) as ActivityCount, strActivity as ActivityType FROM `activities`\n"
            . "LEFT JOIN userActivitiesType on userActivitiesType.intTypeId = activities.intActivityType\n"
            . " \n"
            . "WHERE startDate >= '$dtMinus1Year'\n"
            . " GROUP BY strActivity";
       /*avg dist traveled by month(Pie Chart)
        $sql = "SELECT avg(milesTotalDistance), month(startDate) FROM `activities` WHERE startDate >= $dtMinus1Year\n"
            . "GROUP BY Month(startDate)";
       */     

    }
    
    else if($graphType == 'line_graph'){
       //Tracked Activities by Day (Bar Chart)
        $sql = "SELECT count(id) as ActivityCount, strActivity as ActivityType, Weekday(startDate) as DayOfWeek\n"
            . "FROM `activities`\n"
            . "LEFT JOIN userActivitiesType on userActivitiesType.intTypeId = activities.intActivityType\n"
            . "WHERE startDate >= '$dtMinus1Year'\n"
            . "GROUP BY WeekDay(startDate), strActivity";
             
        
            

    }
    else if($graphType == 'activity_types'){
       //Tracked Activities by Day (Bar Chart)
        $sql = "SELECT * FROM `userActivitiesType` WHERE intTypeId != '4'";

    }
    else if($graphType == 'bar_graph'){
         
        # distance traveled by month      ()
        $sql = "SELECT sum(milesTotalDistance) as totalDistance, month(startDate) as MonthAsInt FROM `activities` WHERE startDate >= $dtMinus1Year\n"
            . "GROUP BY Month(startDate)";
       


        /*Layered Bar Graph
        $sql = "SELECT count(intActivityId) as ActivityCount, strActivity, Weekday(startDate) as DayOfWeek\n"
            . "FROM `activities`\n"
            . "LEFT JOIN activitiesType on activitiesType.intTypeId = activities.intActivityType\n"
            . "WHERE startDate >= \'2017-03-26\'\n"
            . "GROUP BY WeekDay(startDate), strActivity";*/
    }
    else if($graphType == 'radar'){
     
         # activities by month             (Radar Chart)
        $sql = "SELECT count(id) as ActivityCount, month(startDate) as ActivityDate, strActivity as ActivityType\n"
            . "FROM activities\n"
            . "LEFT JOIN userActivitiesType on userActivitiesType.intTypeId = activities.intActivityType\n"
            . "WHERE startDate >= '$dtMinus1Year'\n"
            . "GROUP BY month(startDate), strActivity";
    }
   
    
    $payLoad = json_encode(array($sql));
    $result = $conn->query($sql) or die($payLoad);
    
    $jsonReturnMessage = array();
    console.log($jsonReturnMessage);
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
      //add into the json as fields with subfields
     
        if($graphType == 'pie_chart'){
            $slice = array('Activities' => $row['ActivityCount'] . "," . $row['ActivityType']);
      
            array_push($jsonReturnMessage, $slice);
        }
        else if($graphType == 'line_graph'){
            $entry = array('ActivityPerWeekday' => $row['ActivityCount'] . "," . $row['ActivityType'] . "," . $row['DayOfWeek']);
      
            array_push($jsonReturnMessage, $entry);
        }
        else if($graphType == 'activity_types'){
            $entry = array('ActivityTypes' => $row['strActivity'] );
      
            array_push($jsonReturnMessage, $entry);
        } 
        else if($graphType == 'radar'){
            $entry = array('Activities' => $row['ActivityCount'] . "," . $row['ActivityDate'] . "," . $row['ActivityType']);
      
            array_push($jsonReturnMessage, $entry);
        }
        else if($graphType == 'bar_graph'){
            $entry = array('DistancePerMonth' => $row['totalDistance'] . "," . $row['MonthAsInt'] );
            
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

