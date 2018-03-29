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
    
    //echo $data. "\n";
    
    //$data = '{"userId":"1096","changeField":"fullName","changeValue":"Greg Fitzgerald"}';
    
    if(isset($data)){
         //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
       
       if(isset($dataArray->userId)){
            $intUserId = $dataArray->userId;
            $intUserId = mysqli_real_escape_string($conn, $intUserId);

            $sqlGetUserData = "SELECT * FROM `users` WHERE intUserId ='".$intUserId."'";
            $resultGetUserData = $conn->query($sqlGetUserData); 
            
            //if the user has been found, we can start editing
            if($resultGetUserData->num_rows > 0){
                $userFromDB = $resultGetUserData->fetch_array(MYSQLI_ASSOC);
               
                $strFirstName = $userFromDB['strFirstName'];
                $strLastName = $userFromDB['strLastName'];
                $dtBirthdate = $userFromDB['dtBirthdate'];
                $intHeight = $userFromDB['intHeight']; 
                $intWeight = $userFromDB['intWeight'];
                $strGender = $userFromDB['strGender'];
                
                $changeField = $dataArray->changeField;
                $changeValue = $dataArray->changeValue;
                
                
                
                switch ($changeField) {
                    case "fullName":
                        $fullName = explode(' ',$changeValue);
                        $strFirstName = $fullName[0];
                        $strLastName = $fullName[1];
                        break;
                    case "intHeight":
                        $strHeightArray = explode(" ",$changeValue);
                        $intFeet = $strHeightArray[0];
                        $intInches = $strHeightArray[2];
                        $changeValue =  ($intFeet * 12) + $intInches;
                        break;
                    case "intWeight":
                        $strWeightArray = explode(" ",$changeValue);
                        $changeValue = $strWeightArray[0];
                        break;
                    default:
                        echo -1;//"Field Type is not handled.";
                }
                        
                //$sqlUpdateUserData = "UPDATE `users` SET `strFirstName`='".$strFirstName."',`strLastName`='".$strLastName."',`intWeight`='".$intWeight."',`intHeight`='".$intHeight."',`strGender`='".$strGender."',`dtBirthdate`='".$dtBirthdate."' WHERE intUserId = '".$intUserId."'";
                //$resultUpdateUserData = $conn->query($sqlUpdateUserData) or die("Could not update User.");
                
                if($changeField == "fullName"){
                    $sqlUpdateUserData = "UPDATE `users` SET `strFirstName`='$strFirstName', `strLastName` = '$strLastName' WHERE `intUserId` = '$intUserId'";
                    $resultUpdateUserData = $conn->query($sqlUpdateUserData) or die("Could not update User.");
                }else{
                    $sqlUpdateUserData = "UPDATE `users` SET `$changeField`='$changeValue' WHERE `intUserId` = '$intUserId'";
                    $resultUpdateUserData = $conn->query($sqlUpdateUserData) or die("Could not update User.");
                        /*echo $intWeight;
                        $sql = "INSERT INTO `databaseTests` (`dataSent`)
                                    VALUES ( '".$sqlUpdateUserData."' );";
                                    
                          $result = $conn->query($sql) or die($sql); */
                }
                

                echo 1;
               
            }else{
                echo -2;//"User Id not Found in Database.";
            }
                
            
       }else{
           echo -3;//"No User Id Found.";
       }
        
    }else{
        echo -4; //"Data Array not set.";
    }
    
?>