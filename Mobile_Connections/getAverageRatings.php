<?php
    include("../MySQL_Connections/config.php");
   
    /*To avoid a CORS issue with Ionic include this check*/
    if(isset($_SERVER['HTTP_ORIGIN'])){
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); //what's this do?
    }
    
    /*This appears to be something included in the JSON*/
    if($_SERVER['REQUEST_METHOD']=='OPTIONS'){
        
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        
        exit(0);
    }
        
    $averageRatingSql = "SELECT `trailId`, AVG(`rating`) AS `average` FROM `trailRatings` group by `trailId`";
    $averageRatingResults = $conn->query($averageRatingSql) or die("Query Failed");
    $averageRatingResultsObj = array();
    while($row = $averageRatingResults->fetch_array(MYSQLI_ASSOC)) {
        $averageRatingObj = (object)array();
        $averageRatingObj->trailID = $row['trailId'];
        $averageRatingObj->average = $row['average'];
        array_push($averageRatingResultsObj, $averageRatingObj);
    }
    $averageRatingJSON = json_encode($averageRatingResultsObj);
    echo $averageRatingJSON;
?>