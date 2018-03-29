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
    
   // echo $data. "\n";
    
    
    /*$data = '
       {
       "emailAddress":"email@email.com",
       "userPassword":"password"
      
       }
        ';
        */
    
    
    
    if(isset($data)){
                

        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
       
        if (isset($dataArray->emailAddress) && isset($dataArray->userPassword)){
            
            $strEmailAddress = $dataArray->emailAddress;
            $strPassword = $dataArray->userPassword;
            
            $strEmailAddress = mysqli_real_escape_string($conn, $strEmailAddress);
            $strPassword = mysqli_real_escape_string($conn, $strPassword);
            
            $sql = "SELECT * FROM users WHERE strEmailAddress = '$strEmailAddress'";
            //executes query
            $result = $conn->query($sql) or die("Query fail");
                
            //if a record was found, the email address is valid
            if($result->num_rows > 0){
                
                 
                $row = $result->fetch_array(MYSQLI_ASSOC);
                
                //check if they are active
                $active = $row['active'];
                
                //check if the account is currently locked
                $accountLocked = $row['accountLocked'];
        
                //user account is locked if $accountLocked > 4 (there will be 0-4 attempts given)
                if($accountLocked > 4){
                    echo -1;//"User Account is currently locked.";
                    
                }else{
                    $encryptedPassword = $row['strEncryptedPassword'];
                
                    $match = password_verify($strPassword, $encryptedPassword);
                
                    //the passwords match if $match is true
                    if($match){
                        $sqlResetAttempts = "UPDATE `users` SET `accountLocked` = '0' WHERE `strEmailAddress` = '".$strEmailAddress."'";
                        //executes query
                        $resultResetAttempts = $conn->query($sqlResetAttempts) or die("Query fail");
                        //echo "User Login Successful";
                        $myObj = (object)array(); // object(stdClass)
                        $myObj->userId = $row['intUserId'];
                        $myObj->firstName = $row['strFirstName'];
                        $myObj->lastName = $row['strLastName'];
                        $myObj->emailAddress = $row['strEmailAddress'];
                        $myObj->userBirthday = $row['dtBirthdate'];
                        
                        $heightTotalInches = $row['intHeight'];
                        $heightFt =  (int) ($heightTotalInches / 12);
                        $heightInches = $heightTotalInches - ($heightFt * 12);
                        
                        $myObj->userHeight = $heightFt . " Feet " . $heightInches . " Inches";
                        $myObj->userWeight = $row['intWeight'] . " Lbs";
                        $myObj->userGender = $row['strGender'];
                        
                        $myJSON = json_encode($myObj);
                        
                        echo $myJSON;
                    }else{
                        //echo "Passwords do not Match.";
                        
                        //increment the number of attempts the user has tried to guess their password
                        $sqlAddAttempts = "UPDATE `users` SET `accountLocked` = '".($accountLocked + 1)."' WHERE `strEmailAddress` = '".$strEmailAddress."'";
                        //executes query
                        $resultAddAttempts = $conn->query($sqlAddAttempts) or die("Query fail");
            
                        echo (5-($accountLocked + 1)); //"Attempts Left: "
            
                    }
                
                }
                
            }else{
                echo -2;//"User Account Not Found.";
            }

        }else{
            echo -3;//"dataArray not set";
        }
        
    }
?>
