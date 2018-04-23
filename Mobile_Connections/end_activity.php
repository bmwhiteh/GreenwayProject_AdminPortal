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
    $sql = "INSERT INTO `databaseTests` (`dataSent`)
                VALUES ( '".$data."' );";
                
    $result = $conn->query($sql) or die("Query fail");  
    
    //echo $data. "\n";
    
    
    if(isset($data)){
         $dataArray = json_decode($data);
        
        $timeTotalDuration = "00:00:01";
        $milesTotalDistance = 0.01;
        $calTotalCalories = 1;
        
        $intUserId = mysqli_real_escape_string($conn, $dataArray->userId);
        $intActivityId = mysqli_real_escape_string($conn, $dataArray->activityId);
        
        if(isset($dataArray->activityType)){
            $intActivityType = mysqli_real_escape_string($conn, $dataArray->activityType);
        }else{
            $intActivityType = 1; 
        }

       
            $dateStart = new DateTime('now'); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $endDate =$dateStart->format('Y-m-d');
            $endTime =$dateStart->format('H:i:s');   
        
        
        if(isset($dataArray->totalDuration)){
            $timeTotalDuration = mysqli_real_escape_string($conn, $dataArray->totalDuration);
        }
        
        if(isset($dataArray->totalDistance)){
            $milesTotalDistance = mysqli_real_escape_string($conn, $dataArray->totalDistance);
        }
        if(isset($dataArray->totalCalories)){
            $calTotalCalories = mysqli_real_escape_string($conn, $dataArray->totalCalories);
        }
        
        date_default_timezone_set('UTC');
        $date = date('m/d/Y h:i:s a', time());
                    
        if($intActivityType == 1){//running activity
            $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '4'";
            $result = $conn->query($sql) or die("Update fail");
            
            $getRunActivityCountSql = "SELECT * FROM `userActivities` WHERE `intUserId` = '$intUserId' && `intActivityType` = '1'";
            $getCountResults = $conn->query($getRunActivityCountSql);
            $count = $getCountResults->num_rows;
            
            if($count == 0){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `intUserId` = '$intUserId' && `intMedalId` = '1'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Starting Strong badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`intUserId`, `intMedalId`) VALUES ('$intUserId', '1')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
        }
        if($intActivityType == 2){//walking activity
            $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '3'";
            $result = $conn->query($sql) or die("Update fail");
            
            if($milesTotalDistance >= 2.0){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `intUserId` = '$intUserId' && `intMedalId` = '4'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Nomad badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`intUserId`, `intMedalId`) VALUES ('$intUserId', '4')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
            
            if($timeTotalDuration >= "02:00:00"){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `intUserId` = '$intUserId' && `intMedalId` = '3'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Stop and Smell the Roses badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`intUserId`, `intMedalId`) VALUES ('$intUserId', '3')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
            
            
            
        }
        if($intActivityType == 3){//biking activity
            $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '5'";
            $result = $conn->query($sql) or die("Update fail");
            
            if($timeTotalDuration >= "03:00:00"){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `intUserId` = '$intUserId' && `intMedalId` = '6'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn Wheels of Steel badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`intUserId`, `intMedalId`) VALUES ('$intUserId', '6')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
            
            $sumDistanceSql = "SELECT sum(`milesTotalDistance`) as sum_TotalDistance FROM `userActivities` WHERE `intUserId` = '$intUserId' && `intActivityType` = '3'";
            $sumDistanceResults = $conn->query($sumDistanceSql);
            $results = $sumDistanceResults->fetch_assoc();
            $sumDistance = $results['sum_TotalDistance'];
            
            if($sumDistance >= 25.0){
                //check if badge has been earned previously
                $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `intUserId` = '$intUserId' && `intMedalId` = '8'";
                $badgeCheckResults = $conn->query($badgeCheckSql);
                $badgeCount = $badgeCheckResults->num_rows;
            
                if($badgeCount == 0){
                    //earn The Long Haul badge
                    $addBadgeSql = "INSERT INTO `medalsEarned`(`intUserId`, `intMedalId`) VALUES ('$intUserId', '8')";
                    $addBadgeResult = $conn->query($addBadgeSql);
                }
            }
            
        }
        
        $numActivitiesSql = "SELECT intActivityId FROM `userActivities` WHERE `intUserId` = '$intUserId'";
        $numActivitiesResults = $conn->query($numActivitiesSql);
        $count = $numActivitiesResults->num_rows;
            
        if($count >= 100){
            //check if badge has been earned previously
            $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `intUserId` = '$intUserId' && `intMedalId` = '10'";
            $badgeCheckResults = $conn->query($badgeCheckSql);
            $badgeCount = $badgeCheckResults->num_rows;
        
            if($badgeCount == 0){
                //earn The Wayfinder badge
                $addBadgeSql = "INSERT INTO `medalsEarned`(`intUserId`, `intMedalId`) VALUES ('$intUserId', '10')";
                $addBadgeResult = $conn->query($addBadgeSql);
            }
        }
       
        $countActivitiesSql = "SELECT count(*) FROM `userActivities` 
            WHERE `startDate` >= DATE(NOW()) - INTERVAL 7 DAY
            GROUP BY DATE_FORMAT(`startDate`, '%w')";
        $countActivitiesResults = $conn->query($countActivitiesSql);
        $count = $countActivitiesResults->num_rows;
        
        if($count == 7){
            //check if badge has been earned previously
            $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `intUserId` = '$intUserId' && `intMedalId` = '5'";
            $badgeCheckResults = $conn->query($badgeCheckSql);
            $badgeCount = $badgeCheckResults->num_rows;
        
            if($badgeCount == 0){
                //earn The Trail Fanatic badge
                $addBadgeSql = "INSERT INTO `medalsEarned`(`intUserId`, `intMedalId`) VALUES ('$intUserId', '5')";
                $addBadgeResult = $conn->query($addBadgeSql);
            }
        }
        
       if(isset($intActivityId) && $intActivityId != ''){
            $sqlEndActivity = "UPDATE `userActivities` 
                                    SET `timeTotalDuration`='$timeTotalDuration', 
                                        `milesTotalDistance` ='$milesTotalDistance', 
                                        `calTotalCalories` = '$calTotalCalories',
                                        `endDate` = '$endDate', 
                                        `endTime`='$endTime',
                                        `intActivityType` = '$intActivityType'
                                WHERE `intActivityId`='$intActivityId'";
            $resultEndActivity = $conn->query($sqlEndActivity);
            
            //get the just created id
            $sqlGetResponse = "SELECT endDate, endTime FROM `userActivities` WHERE intActivityId = '$intActivityId'";            
            $resultGetResponse = $conn->query($sqlGetResponse);
    
    
            if ($resultGetResponse->num_rows > 0) {
                // output data of each row
                while($row = $resultGetResponse->fetch_assoc()) {
                    echo $row["intActivityId"];
                }
                
            } else {
                echo -1; //activity not ended
            }
        }
        
        if($calTotalCalories >= 500){
            //check if badge has been earned previously
            $badgeCheckSql = "SELECT * FROM `medalsEarned` WHERE `intUserId` = '$intUserId' && `intMedalId` = '11'";
            $badgeCheckResults = $conn->query($badgeCheckSql);
            $badgeCount = $badgeCheckResults->num_rows;
            
            if($badgeCount == 0){
                //earn Feel the Burn badge
                $addBadgeSql = "INSERT INTO `medalsEarned`(`intUserId`, `intMedalId`) VALUES ('$intUserId', '11')";
                $addBadgeResult = $conn->query($addBadgeSql);
            }
        }

       $sqlSetInactive = "UPDATE `users` SET `active`= '0' WHERE `intUserId` = '$intUserId'";
       $resultSetInactive = $conn->query($sqlSetInactive);
       
    }else{
        echo -2;
    }
 
 ?>