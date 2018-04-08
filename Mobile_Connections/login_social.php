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
    
    
      /*
    $data = '
       {
       "emailAddress":"brandon.young1@gmail.com",
       "action":"check",
       "from": "google"
      
       }
        ';
   
   */
    
    
    if(isset($data)){
                

        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
       
       //Check that we have an email address
        if (isset($dataArray->emailAddress) && $dataArray->emailAddress !=""){
            
            //check that we have an action
            if(isset($dataArray->action) && $dataArray->action != ""){
                
                $action = $dataArray->action;
                $strEmailAddress = $dataArray->emailAddress;
                $strEmailAddress = mysqli_real_escape_string($conn, $strEmailAddress);

                //Check for the email address
                $sqlCheckEmail = "SELECT userAvatarFilePath,intUserId,strFirstName,strLastName,strEmailAddress,dtBirthdate,intHeight,intWeight,strGender FROM users WHERE strEmailAddress = '$strEmailAddress'";
                $resultCheckEmail = $conn->query($sqlCheckEmail);
                    

                //If action is check, we just check the database for the email address
                if($action == "check"){
                    
                    
                    if($resultCheckEmail == TRUE && $resultCheckEmail->num_rows > 0){
                        
                        $row = $resultCheckEmail->fetch_array(MYSQLI_ASSOC);
                        
                        //If the result succeeded and found something
                        $actionReturned = "login";
                        
                        //encode the user avatar
                        $userAvatarFilePath = $row['userAvatarFilePath'];
                        $imgbinary = fread(fopen("..".$userAvatarFilePath, "r"), filesize("..".$userAvatarFilePath));
                        $userAvatar =  'data:image/png;base64,' . base64_encode($imgbinary);
 
                        //calculate the user height
                        $heightTotalInches = $row['intHeight'];
                        $heightFt =  (int) ($heightTotalInches / 12);
                        $heightInches = $heightTotalInches - ($heightFt * 12);
                        
                        //Set the array elements that will be used to create the json
                        $myObj = (object)array(); // object(stdClass)
                        $myObj->action = $actionReturned;
                        $myObj->userId = $row['intUserId'];
                        $myObj->firstName = $row['strFirstName'];
                        $myObj->lastName = $row['strLastName'];
                        $myObj->emailAddress = $row['strEmailAddress'];
                        $myObj->userBirthday = $row['dtBirthdate'];
                        $myObj->userHeight = $heightFt . " Feet " . $heightInches . " Inches";
                        $myObj->userWeight = $row['intWeight'] . " Lbs";
                        $myObj->userGender = $row['strGender'];
                        
                        $myJSON = json_encode($myObj);
                        $myJSONwithAvatar = substr($myJSON,0,strlen($myJSON)-1) . ',"userAvatar":"'. $userAvatar.'"}';
                        
                        echo $myJSONwithAvatar ;
                        

                    }elseif($resultCheckEmail == TRUE && $resultCheckEmail->num_rows <= 0){
                        
                        //If the result succeeded and didn't find anything
                        $actionReturned = "signup";
                        
                        //Set the array elements that will be used to create the json
                        $myObj = (object)array(); // object(stdClass)
                        $myObj->action = $actionReturned;
                        $myJSON = json_encode($myObj);
                        
                        echo $myJSONwithAvatar ;
                        
                        
                    }else{
                        echo -5; //sql statement failed
                    }
            
                    
                }else{
                    echo -4; //action was not a recognized value
                }
                
            }else{
                echo -3; //action not set
            }
        }else{
            echo -2; //email address not set
        }
    }else{
        echo -1; //data json not set
    }
?>
