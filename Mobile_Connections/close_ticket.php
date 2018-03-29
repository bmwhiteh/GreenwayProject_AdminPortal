<?php
    include("../MySQL_Connections/config.php");
   
    /*To avoid a CORS issue with Ionic include this check*/
    if(isset($_SERVER['HTTP_ORIGIN'])){
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); //what's this do
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
    
   /*  $data = '
       {
       "userId":3,
       "ticketId":91,
       "note":"Test note"
      
       }
        ';
     */
     
        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $employeeId = $dataArray->userId;
        $ticketId = $dataArray->ticketId;
        
        if(isset($dataArray->currentTime)){
            $phoneDateTime = $dataArray->currentTime; //example: 2018-02-19T18:13:19.952Z
            $dateStart= new DateTime($phoneDateTime); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $date  =$dateStart->format('Y-m-d');
        
        }else{
            $dateStart = new DateTime('now'); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $date =$dateStart->format('Y-m-d');
        }
        
        //update ticket in mainetnancetickets
       $sqlClose = "UPDATE `maintenancetickets` SET `dtClosed` = '". $date ."' WHERE `intTicketId` = '".$ticketId."'";
       $conn->query($sqlClose)  or die("Update dtClosed FAIL  $id");
       
       echo $sqlClose;
        //insert note into the database
    $sqlAddNote = "INSERT INTO ticketnotes (intTicketId, intEmployeeId, dateAdded, comment) 
    VALUES('$ticketId','3','$date', 'Ticket Closed.')";
    echo $sqlAddNote;
    $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
    ?>