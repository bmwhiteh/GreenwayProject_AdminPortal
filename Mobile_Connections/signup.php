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
    

    
    
   
    /*
    $data = '{
            "firstName":"Connor",
            "lastName":"Test",
            "emailAddress":"connor@gmail.com",
            "userPassword":"Connor",
            "userBirthdate":"1965-01-01",
            "userHeight":"6 Feet 4 Inches",
            "userWeight":"111 lbs",
            "userGender":"Male",
            "userLat":"41.104271598696336",
            "userLng":"-85.05888901298296"
        
    }'; */
    
    if(isset($data)){
                

        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $strFirstName = mysqli_real_escape_string($conn, $dataArray->firstName);
        $strLastName = mysqli_real_escape_string($conn, $dataArray->lastName);
        $strUsername = substr($strFirstName,0,1) . $strLastName;
       if(isset($dataArray->currentTime)){
            $phoneDateTime = $dataArray->currentTime; //example: 2018-02-19T18:13:19.952Z
            $dateStart= new DateTime($phoneDateTime); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $dtStartDate  =$dateStart->format('Y-m-d');
        
        }else{
            $dateStart = new DateTime('now'); 
            $dateStart->setTimeZone(new DateTimeZone('UTC'));
            $dtStartDate =$dateStart->format('Y-m-d');
        }
        $strEmailAddress = mysqli_real_escape_string($conn, $dataArray->emailAddress);
        
        $sqlCheckEmailAddress = "SELECT intUserId FROM `users` WHERE `strEmailAddress` = '$strEmailAddress'";
        $resultCheckEmailAddress  = $conn->query($sqlCheckEmailAddress );

        if ($resultCheckEmailAddress->num_rows > 0) {
                echo -2; //user already exists
                
        } else {
            
        
            $strUserPassword = mysqli_real_escape_string($conn, $dataArray->userPassword);
            $bitReceiveNotifications = $dataArray->bitNotifications;
            $bitSendPictures = 1;
            $bitActive = 0;
            $strGender = mysqli_real_escape_string($conn, $dataArray->userGender);
        
        
            $options = [    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),     ];
            $hashedPassword = password_hash($strUserPassword, PASSWORD_BCRYPT, $options);
    
            
            //birthdate sent as 
            $dtBirthDate = mysqli_real_escape_string($conn, $dataArray->userBirthdate);
            $intAge =  date("Y-m-d") - $dtBirthDate;
            
            //Height
            $strHeight = mysqli_real_escape_string($conn, $dataArray->userHeight); //comes in as "5 feet 11 inches"
            $strHeightArray = explode(" ",$strHeight);
            $intFeet = $strHeightArray[0];
            $intInches = $strHeightArray[2];
            $intHeight =  ($intFeet * 12) + $intInches;
            
            //Weight
            $strWeight = mysqli_real_escape_string($conn, $dataArray->userWeight); //comes in as 111lbs
            $strWeightArray = explode(" ",$strWeight);
            $intWeight = $strWeightArray[0];

            //$strLat = "38.58157";    
            $strLat = $dataArray->userLat;
            //$strLong = "-121.4944";     
            $strLong = $dataArray->userLng;
    
            
            $intZipCode = 0;
            // google map geocode api url
            $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$strLat,$strLong&key=AIzaSyBDPrizY3A8DH-BaSuHsSLy6-WObmEvAd4";
          
            // get the json response
            $resp_json = file_get_contents($url);
            
            // decode the json
            $resp = json_decode($resp_json, true);
     
            // response status will be 'OK', if able to geocode given address 
            if($resp['status']=='OK'){
                    $arrayLength = count($resp['results'][0]['address_components']);
                    $regex = "^\d{5}^";
                    for($i = 0; $i < $arrayLength; $i++){
                        $tempZip = $resp['results'][0]['address_components'][$i]['long_name'];
                        if (preg_match($regex, $tempZip)) {
                            $intZipCode = $tempZip;
                        }
                       // echo "iteration $i Zip Code: $intZipCode";
                    }
                     //echo $intZipCode;
            }
                    
       
            if(isset($strUserPassword)){
    
    
                if(isset($hashedPassword)){
    
                    $sqlAddUser = "INSERT INTO `users` (
                            `strFirstName`, 
                            `strLastName`, 
                            `strUsername`, 
                            `strEmailAddress`,
                            `strEncryptedPassword`,
                            `dtBirthdate`,
                            `intHeight`, 
                            `intWeight`,
                            `strGender`,
                            `strLat`,
                            `strLong`,
                            `dtStartDate`,
                            `intAge`, 
                            `bitSendPictures`,
                            `bitReceiveNotifications`,
                            `intZipCode`,
                            `active`
                        )
                        VALUES ( 
                            '".$strFirstName."' ,
                            '".$strLastName."',
                            '".$strUsername."',
                            '".$strEmailAddress."',
                            '".$hashedPassword."' ,
                            '".$dtBirthDate."',
                            '".$intHeight."', 
                            '".$intWeight."', 
                            '".$strGender."', 
                            '".$strLat."', 
                            '".$strLong."', 
                            '".$dtStartDate."',
                            '".$intAge."',
                            '".$bitSendPictures."',
                            '".$bitReceiveNotifications."',
                            '".$intZipCode."',
                            '".$bitActive."'
                        )";
                        
                        
                    $resultAddUser = $conn->query($sqlAddUser);
    
    
                    $passwordResult = "Password: " . $newPassword . " Encrypted Password: " . $hashedPassword;
                    
                    date_default_timezone_set('UTC');
                    $date = date('m/d/Y h:i:s a', time());
                    $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId` = '1'";
                    $result = $conn->query($sql);
        
    
                }
    
    
                //get the just created id
                $sqlGetResponse = "SELECT * FROM `users` ORDER BY intUserId desc LIMIT 0, 1 ";            
                $resultGetResponse = $conn->query($sqlGetResponse);
    
    
                if ($resultGetResponse->num_rows > 0) {
                    // output data of each row
                    while($row = $resultGetResponse->fetch_assoc()) {
                        echo $row["intUserId"];
                    }
                    
                } else {
                    echo -1;//"Could Not Create Account.";
                }
            }  
           
        }
    }
?>
