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
    
    // $sql = "INSERT INTO `databaseTests` (`dataSent`)
    //             VALUES ( '".$data."' );";
                
    // $result = $conn->query($sql) or die("Query fail");  

     if(isset($data)){  
        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $userId = $dataArray->userID;

                $sqlSetActive = "UPDATE `firebaseusers` SET `active`= '0' WHERE `userId` = '$userId'";
                $resultSetActive = $conn->query($sqlSetActive) or die ("Sql error"); 
     }
    
?>