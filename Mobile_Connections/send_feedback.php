<!--- This is where the jsons will be sent--->
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
    
    echo $data. "\n";
    
     /*$data = '
       {
       "currentTime":1520965497444,
       "feedback":"Test Again With Time"
      
       }
        ';
        */


    //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $strFeedback = $dataArray->feedback;
        $strFeedback = mysqli_real_escape_string($conn, $strFeedback);
        
        if(isset($dataArray->currentTime)){
            $phoneDateTime = $dataArray->currentTime; //example: 2018-02-19T18:13:19.952Z
            $dateStart= new DateTime($phoneDateTime); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $dateReceived  =$dateStart->format('Y-m-d h:i:s a');
        
        }else{
            $dateStart = new DateTime('now'); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $dateReceived =$dateStart->format('Y-m-d h:i:s a');
        }

    $sql = "INSERT INTO `feedback` (
                        `strFeedback`, 
                        `strErrorLocation`, 
                        `dateReceived`, 
                        `bitResolved`
                    )
                    VALUES ( 
                        '$strFeedback' ,
                        'Mobile',
                        '$dateReceived',
                        '0'
                    )";
            
    $result = $conn->query($sql);
            
    $sqlTask = "UPDATE `tasks` SET `lastCompleted`= '$dateReceived' WHERE `taskId`= '9'";
    $resultTask = $conn->query($sqlTask) or die("Update fail");
    
?>