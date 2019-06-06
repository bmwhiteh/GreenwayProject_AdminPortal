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
    
    //get the json data
    $data = file_get_contents("php://input");
    if (isset($data)) {
        $dataArray = json_decode($data);
        $strUserId = mysqli_real_escape_string($conn, $dataArray->userID);
        $trailId = mysqli_real_escape_string($conn, $dataArray->trailID);
        
        $userRatingSql = "SELECT `rating` FROM `trailRatings` WHERE `userId` = '$strUserId' AND `trailId` = '$trailId'";
        $userRatingResults = $conn->query($userRatingSql) or die("Query Failed");
        $row = $userRatingResults->fetch_array(MYSQLI_ASSOC);
        $count =  $userRatingResults->num_rows;
        $userRatingObj = (object)array();
        if ($count == 1) {
            $userRatingObj->rating = $row['rating'];
        } else {
            $userRatingObj->rating = 0;
        }
        $userRatingJSON = json_encode($userRatingObj);
        echo $userRatingJSON;
    }
?>