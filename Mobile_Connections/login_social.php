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
       "from":"google",
       "idToken":"eyJhbGciOiJSUzI1NiIsImtpZCI6IjNiNTQ3ODg2ZmY4NWEzNDI4ZGY0ZjYxZGI3M2MxYzIzOTgyYTkyOGUifQ.eyJhenAiOiI0MDc0MTIzMTg5MTgtajl0NnQydWhnZG8yaXY4dTk4bWNlbW9zOWNlY2pwcWkuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiI0MDc0MTIzMTg5MTgtajl0NnQydWhnZG8yaXY4dTk4bWNlbW9zOWNlY2pwcWkuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMTc5OTE1NTk4NDI0NTE4NTIxNDMiLCJlbWFpbCI6ImJyYW5kb24ueW91bmcxQGdtYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjp0cnVlLCJhdF9oYXNoIjoiZVNDSHVIRnhCQUNzblhlTGFlZm9OQSIsImV4cCI6MTUyMzM5NjUxMSwiaXNzIjoiaHR0cHM6Ly9hY2NvdW50cy5nb29nbGUuY29tIiwiaWF0IjoxNTIzMzkyOTExfQ.BDPjkYFd5o4innqHuhxk2tTA2zJEAoVeYB8hBvn_vA4TCeUtqltbB9vvcd-CQ37DCbFUJL5jRc_Hq_DcTRkBxKHzue7m_uYP79ETqF5XbmdouCBq-Jv4qnZJTIeSDzZ8d6Lm_BPVuuzAk_NflgIwfZQssgvYNGF17O8x3v0y8lMlY3kXeYPmXk5GGUJTURHSIIGVRtCwWOQYu_CjFgb2CAtLo6OSl5kih6YnsZzskCKy4-4JDcy2gy1DWETXYBerd6Ux_HRQmZ7zIBqwB0n60LLxCRQQ1yJWFW6lA9C6rmIOwZW430VlPhlC1MTiNOXsA7A33kW7KCGniw7zQmiYLg"
      
       }
        ';
   */
   
    
    
    if(isset($data)){
                

        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
       $from = $dataArray->from;
       if($from == "google"){
           
             //Check that we have an idToken
            if (isset($dataArray->idToken) && $dataArray->idToken !=""){
                
                $id_token = $dataArray->idToken;
                /*
                //Follow the Google Authentication: https://developers.google.com/identity/sign-in/web/backend-auth
                require_once 'vendor/autoload.php';

                // Get $id_token via HTTPS POST.
                $CLIENT_ID = "407412318918-e4mig3cqfrsb1j80goqnltu7jigitako.apps.googleusercontent.com";
                
                $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
                var_dump($client);
                $payload = $client->verifyIdToken($id_token);
                echo $payload . "=payload";
                if ($payload) {
                  $userid = $payload['sub'];
                  $strEmailAddress = $userid['email']; //Get the Email Address
                  //I can also get other information that would update our profile on the user
                } else {
                  echo -6; // Invalid ID token
                }
                
                */

                $url =  "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=".$id_token;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic YjQyMzY3NDQtOWE4NS00MDc1LWE1ZTMtZGExMjRkN2FhOThi'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                $response = curl_exec($ch);
                curl_close($ch);
                
                //echo $response;
                $return["allresponses"] = $response;

                $test = json_decode($return["allresponses"], true);
                //var_dump($test);
                
                $strEmailAddress =  $test["email"];
                
                

            }else{
                echo -5; //idToken not set
            }
       }else if($from == "facebook"){
           //handle Facebook Authentication
       }else{
           echo -4; //from not set
       }
       
       //Now that we have verified the id token we can grab the user profile
       if(isset($strEmailAddress)){
           
            //Check for the email address
            $sqlCheckEmail = "SELECT userAvatarFilePath,intUserId,strFirstName,strLastName,strEmailAddress,dtBirthdate,intHeight,intWeight,strGender \n".
            "FROM users WHERE strEmailAddress = '$strEmailAddress'";
            $resultCheckEmail = $conn->query($sqlCheckEmail);
                    
            if($resultCheckEmail == TRUE && $resultCheckEmail->num_rows > 0){
                
                
                $row = $resultCheckEmail->fetch_array(MYSQLI_ASSOC);
                
                 
                //encode the user avatar
               $userAvatarFilePath = $row['userAvatarFilePath'];
                //$imgbinary = fread(fopen("..".$userAvatarFilePath, "r"), filesize("..".$userAvatarFilePath));
                //$userAvatar =  'data:image/png;base64,' . base64_encode($imgbinary);
    
                //calculate the user height
                $heightTotalInches = $row['intHeight'];
                $heightFt =  (int) ($heightTotalInches / 12);
                $heightInches = $heightTotalInches - ($heightFt * 12);
                
                $actionReturned = "login";
                
                //Set the array elements that will be used to create the json
                $myObj = (object)array(); // object(stdClass)
                $myObj->action = $actionReturned;
                $myObj->userId = $row['intUserId'];
                $myObj->firstName = $row['strFirstName'];
                $myObj->lastName = $row['strLastName'];
                $myObj->emailAddress = $row['strEmailAddress'];
                $myObj->userBirthdate = $row['dtBirthdate'];
                $myObj->userHeight = $heightFt . " Feet " . $heightInches . " Inches";
                $myObj->userWeight = $row['intWeight'] . " Lbs";
                $myObj->userGender = $row['strGender'];
                
                $myJSON = json_encode($myObj);
                $myJSONwithAvatar = substr($myJSON,0,strlen($myJSON)-1) . ',"userAvatar":"'. $userAvatar.'"}';
                
                echo $myJSONwithAvatar ;
                //echo $myJSON;
                
                
    
            }else{
                echo -3; //sql statement failed
            }       
       }else{
           echo -2; //idToken could not be verified
       }
       
    }else{
        echo -1; //data json not set
    }
?>
