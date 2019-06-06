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

    //JSON must be decoded using PHP function
    $dataArray = json_decode($data);
    $userId = $dataArray->userID;
    $userId = mysqli_real_escape_string($conn, $userId);
    $trailId = $dataArray->trailID;
    $trailId = mysqli_real_escape_string($conn, $trailId);
    $rating = $dataArray->rating;
    $rating = mysqli_real_escape_string($conn, $rating);
    $userRatingSql = "SELECT `rating` FROM `trailRatings` WHERE `userId` = '$userId' AND `trailId` = '$trailId'";
    $userRatingResults = $conn->query($userRatingSql) or die("Query Failed");
    $row = $userRatingResults->fetch_array(MYSQLI_ASSOC);
    $count =  $userRatingResults->num_rows;
    $userRatingObj = (object)array();
    if ($count == 1) {
        //User has rated this trail before, just update the rating
        $userRatingSql = "UPDATE `trailRatings` SET `rating` = '$rating' WHERE `userId` = '$userId' AND `trailId` = '$trailId'";
    } else {
        //New rating for this trail & user, create a new row
        $userRatingSql = "INSERT INTO `trailRatings` VALUES ('$trailId', '$userId', '$rating')";
    }
    $result = $conn->query($userRatingSql);
    $return = (object)array();
    $return->SQL = $userRatingSql;
    $return->SQLResult = $result;
    echo json_encode($return);
?>