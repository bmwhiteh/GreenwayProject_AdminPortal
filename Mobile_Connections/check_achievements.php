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
                VALUES ( 'Check Achievements ".$data."' );";
                
      $result = $conn->query($sql) or die("Query fail");  
    
   // echo $data. "\n";
        
    //$data = '{"userId":"1215"}';
    
    
    if(isset($data)){
                

        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
       
        if (isset($dataArray->userId)){
            
            $intUserId = $dataArray->userId;
            $intUserId = mysqli_real_escape_string($conn, $intUserId);
            
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '1'";
            
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $startingStrongEarned =  $result->num_rows;
        
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '2'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $pushItEarned =  $result->num_rows;
            
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '3'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $stopSmellRosesEarned =  $result->num_rows;
            
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '4'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $nomadEarned =  $result->num_rows;
            
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '5'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $trailFanaticEarned =  $result->num_rows;
            
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '6'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $wheelsOfSteelEarned =  $result->num_rows;
            
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '7'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $burningRubberEarned =  $result->num_rows;
            
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '8'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $longHaulEarned =  $result->num_rows;
            
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '9'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $neighborhoodWatchEarned =  $result->num_rows;
            
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '10'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $wayfinderEarned =  $result->num_rows;
            
            $sql = "SELECT intEarnedId FROM medalsEarned WHERE intUserId = '$intUserId' && intMedalId = '11'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
            $feelBurnEarned =  $result->num_rows;
            
            $myObj = (object)array(); // object(stdClass)
            $myObj->startingStrong = $startingStrongEarned;
            $myObj->pushIt = $pushItEarned;
            $myObj->stopSmellRoses = $stopSmellRosesEarned;
            $myObj->nomad = $nomadEarned;
            $myObj->trailFanatic = $trailFanaticEarned;
            $myObj->wheelsOfSteel = $wheelsOfSteelEarned;
            $myObj->burningRubber = $burningRubberEarned;
            $myObj->longHaul = $longHaulEarned;
            $myObj->neighborhoodWatch = $neighborhoodWatchEarned;
            $myObj->wayfinder = $wayfinderEarned;
            $myObj->feelBurn = $feelBurnEarned;
            
            $myJSON = json_encode($myObj);
                        
            echo $myJSON;
        }else{
            echo -1; //intUserId not sent
        }
    }
?>
