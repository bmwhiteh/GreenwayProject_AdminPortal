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
    
   
    if(isset($data)){
        $dataArray = json_decode($data);
        $strUserId = mysqli_real_escape_string($conn, $dataArray->userID);
        
        $retrieveUserInfoSql = "SELECT `dtBirthdate`, `intZipCode`, `intWeight`, `intHeight`, `strGender`, `intSecurityLevel` FROM `firebaseusers` WHERE `userId` = '$strUserId'";
        $retrieveUserInfoResults = $conn->query($retrieveUserInfoSql) or die("Query Failed");
        $row = $retrieveUserInfoResults->fetch_array(MYSQLI_ASSOC);
        $count =  $retrieveUserInfoResults->num_rows;
        
        if($count == 1){
            $userInfoObj = (object)array();
                $userInfoObj->dtBirthdate = $row['dtBirthdate'];
                $userInfoObj->intZipCode = $row['intZipCode'];
                $userInfoObj->intWeight = $row['intWeight'];
                $userInfoObj->intHeight = $row['intHeight'];
                $userInfoObj->strGender = $row['strGender'];
                $userInfoObj->intSecurityLevel = $row['intSecurityLevel'];
         
            $userInfoJSON = json_encode($userInfoObj);
            echo $userInfoJSON;
        }else{
            echo "User Not Found";
        }
    }   
    
?>