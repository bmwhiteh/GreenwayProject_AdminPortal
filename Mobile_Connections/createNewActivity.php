<?php
/*<!--- This is where the jsons will be sent--->*/

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
    
    
    $sql = "INSERT INTO `databaseTests` (`dataSent`)
                VALUES ( '".$data."' );";
                
    $result = $conn->query($sql) or die("Query fail"); 
    
/*    $data = 
        '{"userId":"4UM6AgUPuxgZwS3JaPkywSLVrE43","activityType":1,"duration":"00:00:02","distance":"0.00","calories":500.10631978356615,"startDateTime":"2019-04-02T01:51:21.006Z","endDateTime":"2019-04-02T01:51:24.778Z","deviceId":"35A8ECCF-7540-4CE7-AFF6-5A5F0197B0CE","averageSpeed":25.5}';
  */  
    //userID, activity type, time, distance in miles, calories burned, start date, start time, end date, end time
     if(isset($data)){     
        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $userId = $dataArray->userId;
        $intActivityType = $dataArray->activityType;
        $timeTotalDuration = $dataArray->duration;
        $milesTotalDistance = $dataArray->distance;
        $calTotalCalories = $dataArray->calories;
        $startDateTime = $dataArray->startDateTime; //will need converted to UTC & seperated into date & time variables 
        $endDateTime = $dataArray->endDateTime; //will need converted to UTC & seperated into date & time variables
        $deviceId = $dataArray->deviceId;
        $averageSpeed = $dataArray->averageSpeed;
        
        $startDateTime = new DateTime($startDateTime);
        $startDateTime->setTimeZone(new DateTimeZone('UTC'));
        $startDate =$startDateTime->format('Y-m-d');
        $startTime =$startDateTime->format('H:i:s'); 
     
        $endDateTime = new DateTime($endDateTime);
        $endDateTime->setTimeZone(new DateTimeZone('UTC'));
        $endDate = $endDateTime->format('Y-m-d');
        $endTime = $endDateTime->format('H:i:s');
            
            
        //store the new activity
        $sqlAddNewActivity = "INSERT INTO `activities`(`userId`,`deviceId`,`intActivityType`,`timeTotalDuration`,
        `milesTotalDistance`,`calTotalCalories`,`averageSpeed`,`startDate`, `startTime`,`endDate`,`endTime`) VALUES ('".$userId."','".$deviceId."','".$intActivityType."',
        '".$timeTotalDuration."','".$milesTotalDistance."','".$calTotalCalories."','".$averageSpeed."','".$startDate."','".$startTime."','".$endDate."','".$endTime."')";
        $resultAddNewActivity = $conn->query($sqlAddNewActivity);
        
        date_default_timezone_set('UTC');
        $date = date('m/d/Y h:i:s a', time());
        
        if($intActivityType == 1){//running activity
            $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '4'";
            $result = $conn->query($sql) or die("Update fail");
            
            $getRunActivityCountSql = "SELECT * FROM `activities` WHERE `strUserId` = '$userId' && `intActivityType` = '1'";
            $getCountResults = $conn->query($getRunActivityCountSql);
            $count = $getCountResults->num_rows;
            
            if($count == 0){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `strUserId` = '$userId' && `intMedalId` = '1'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Starting Strong badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`strUserId`, `intMedalId`) VALUES ('$userId', '1')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
            
            
            if($averageSpeed >= 7.0){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `strUserId` = '$userId' && `intMedalId` = '2'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Push It To the Limit badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`strUserId`, `intMedalId`) VALUES ('$userId', '2')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
        }
        
        
        if($intActivityType == 2){//walking activity
            $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '3'";
            $result = $conn->query($sql) or die("Update fail");
            
            if($milesTotalDistance >= 2.0){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `strUserId` = '$userId' && `intMedalId` = '4'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Nomad badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`strUserId`, `intMedalId`) VALUES ('$userId', '4')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
            
            if($timeTotalDuration >= "02:00:00"){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `strUserId` = '$userId' && `intMedalId` = '3'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Stop and Smell the Roses badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`strUserId`, `intMedalId`) VALUES ('$userId', '3')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
            
        }
        
        if($intActivityType == 3){//biking activity
            $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '5'";
            $result = $conn->query($sql) or die("Update fail");
            
            if($timeTotalDuration >= "03:00:00"){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `strUserId` = '$userId' && `intMedalId` = '6'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Wheels of Steel badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`strUserId`, `intMedalId`) VALUES ('$userId', '6')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
            
            if($averageSpeed >= 25.0){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `strUserId` = '$userId' && `intMedalId` = '7'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Push It To the Limit badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`strUserId`, `intMedalId`) VALUES ('$userId', '7')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
            
            
            $sumDistanceSql = "SELECT sum(`milesTotalDistance`) as sum_TotalDistance FROM `activities` WHERE `userId` = '$userId' && `intActivityType` = '3'";
           echo $sumDistanceSql;
            $sumDistanceResults = $conn->query($sumDistanceSql);
            $results = $sumDistanceResults->fetch_assoc();
            $sumDistance = $results['sum_TotalDistance'];
            
            if($sumDistance >= 25.0){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `strUserId` = '$userId' && `intMedalId` = '8'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn The Long Haul badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`strUserId`, `intMedalId`) VALUES ('$userId', '8')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
            
        }
        
        if($calTotalCalories >= 500.0){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `strUserId` = '$userId' && `intMedalId` = '11'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Feel the Burn badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`strUserId`, `intMedalId`) VALUES ('$userId', '11')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
        
        
        $countActivitiesSql = "SELECT count(*) FROM `activities` 
            WHERE `startDate` >= DATE(NOW()) - INTERVAL 7 DAY
            GROUP BY DATE_FORMAT(`startDate`, '%w')";
        $countActivitiesResults = $conn->query($countActivitiesSql);
        $count = $countActivitiesResults->num_rows;
        
        if($count == 7){
            //check if badge has been earned previously
            $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `strUserId` = '$userId' && `intMedalId` = '5'";
            $badgeCheckResults = $conn->query($badgeCheckSql);
            $badgeCount = $badgeCheckResults->num_rows;
        
            if($badgeCount == 0){
                //earn The Trail Fanatic badge
                $addBadgeSql = "INSERT INTO `medalsEarned`(`strUserId`, `intMedalId`) VALUES ('$userId', '5')";
                $addBadgeResult = $conn->query($addBadgeSql);
            }
        }
        
         $numActivitiesSql = "SELECT id FROM `activities` WHERE `userId` = '$userId'";
        $numActivitiesResults = $conn->query($numActivitiesSql);
        $count = $numActivitiesResults->num_rows;
            
        if($count >= 100){
            //check if badge has been earned previously
            $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `strUserId` = '$userId' && `intMedalId` = '10'";
            $badgeCheckResults = $conn->query($badgeCheckSql);
            $badgeCount = $badgeCheckResults->num_rows;
        
            if($badgeCount == 0){
                //earn The Wayfinder badge
                $addBadgeSql = "INSERT INTO `medalsEarned`(`strUserId`, `intMedalId`) VALUES ('$userId', '10')";
                $addBadgeResult = $conn->query($addBadgeSql);
            }
        }
        
        
        
        $sqlGetActivityID = "SELECT `id` FROM `activities` WHERE `userId`='$userId' order by `id` desc LIMIT 1";
        $resultGetActivityId = $conn->query($sqlGetActivityID);
        $row = $resultGetActivityId->fetch_array(MYSQLI_ASSOC);
        echo $row['id'];

     }
    
?>1