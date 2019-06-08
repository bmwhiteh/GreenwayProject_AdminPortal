<?php
    include("../MySQL_Connections/config.php");
    echo "Test";
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
   $data =file_get_contents("php://input");
    
      
    //get the json data
    $data = file_get_contents("php://input");
        $sql = "INSERT INTO `databaseTests` (`dataSent`)
                VALUES ( '".$data."' );";
                
    $result = $conn->query($sql) or die("Query fail");  
    
   
 
    
    
    //$data = '{"emailAddress":"TimmyMan3@gmail.com"}';
    $data = '{"firstName":"andrea","lastName":"test","emailAddress":"andrea@test.com","userPassword":"Test123!","userBirthdate":"1988-01-01","userHeight":"","userWeight":"150 lbs","userGender":"","userAvatar":"","userLat":"40.4800608","userLng":"-84.6755536","userId":""}';
    if(isset($data)){
                

        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        
        $strEmailAddress = mysqli_real_escape_string($conn, $dataArray->emailAddress);
        
        
        
        
        $sqlCheckEmailAddress = "SELECT intUserId FROM `users` WHERE `strEmailAddress` = '$strEmailAddress' and `strEmailAddress` IS NOT NULL";
        $resultCheckEmailAddress  = $conn->query($sqlCheckEmailAddress );

        if ($resultCheckEmailAddress->num_rows > 0) {
                echo -2; //user already exists
                
        } else {
            
        
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
        
            $strUserPassword = mysqli_real_escape_string($conn, $dataArray->userPassword);
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
            if($strLat != "" && $strLong !=""){
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
            }
       
            if(isset($strUserPassword)){
    
    
                if(isset($hashedPassword)){
    
                    //we don't need to decode the image if the script fails prior to now
                    $encoded_img = $dataArray->userAvatar;
                    $strImageFilePath = "/Mobile_Connections/Images_userAvatars/default_avatar.png"; //File Path: /Mobile_Connections/Images_userAvatars/
                    if($encoded_img != ''){
                        $type = "png";
                        
                        list($header, $imageBase64) = explode(',', $encoded_img); //notData=data:image/png;base64, imageBase64=image
                        list($fullImageType, ) = explode(';', $header); //fullImageType = remove base64
                        list(, $type ) = explode('/', $fullImageType); //type = get png/jpg/gif
            
            
                        //data:image/png;base64,
            if (preg_match('/^data:image\/png;base64/', $header)||preg_match('/^data:image\/\*;charset=utf-8;base64/', $header)) {
                            
                        
                            if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png', '*'])) {
                                //throw new \Exception('invalid image type');
                            } else{
                              // echo -1; // echo "image is of allowed type.\n\n";
                            }
                        
                            $imageBase64 = base64_decode($imageBase64);
                        
                            if ($imageBase64 == false) {
                               //it's an ongoing activity, just track location
                                $sqlStoreLocation = "INSERT INTO `ErrorReporting` (`strErrorActivity`, `occurenceLocation`)
                                        VALUES ( '$data', 'signup.php: LINE 1274  )";
                                $resultStoreLocation = $conn->query($sqlStoreLocation);
                               // echo -2; //"User Id not set";
                            } else{
                                //echo -2;//echo "image was successfully decoded.\n\n";
                            }
                        
                            //get the next ticket id from the table to use to save the image
                            $sqlGetNextIndex = "SELECT intUserId FROM users ORDER BY intUserId DESC LIMIT 0,1";
                            $resultGetNextIndex = $conn->query($sqlGetNextIndex) or die("Could Not Get Most Recent User Index.");  
                            $row = $resultGetNextIndex->fetch_array(MYSQLI_ASSOC);
                            $nextUserId = $row['intUserId'] + 1;
                            
                               
                            $imageObject = imagecreatefromstring($imageBase64);
                              
                            
                            //Set the dimensions we need to save it as
                            $max_width_avatar = 300;
                            $max_height_avatar = 300;
                            
                            
                            //Caculate the new dimension
                            $original_width = imagesx($imageObject);
                            $original_height = imagesy($imageObject);
                            
                            $scale_avatar = min($max_width_avatar/$original_width, $max_height_avatar/$original_height);
                            $new_width_avatar = ceil($scale_avatar*$original_width); 
                            $new_height_avatar= ceil($scale_avatar*$original_height);
                            
                            //Create new empty image
                            $new_image_avatar = imagecreatetruecolor($new_width_avatar, $new_height_avatar);
                            
                            // Resample old into new
                            $resample_avatar = imagecopyresampled($new_image_avatar, $imageObject, 0, 0, 0, 0, $new_width_avatar, $new_height_avatar, $original_width, $original_height);
                           
                            //this will be the name and location of the saved image
                            $target_file_avatar = "../Mobile_Connections/Images_userAvatars/userAvatar_".$nextUserId.".jpg";
                            
                            
                            // Catch the image data
                            header('Content-Type: image/jpeg');
                
                            $save_image_avatar = imagejpeg($new_image_avatar, $target_file_avatar);
                
                            $strImageFilePath = "/Mobile_Connections/Images_userAvatars/userAvatar_".$nextUserId.".jpg";
                            // Destroy resources
                            imagedestroy($new_image_avatar);
                //Delete the temp file
            
                        
                            
                            
                            
                        } else {
                            $strImageFilePath = '/Mobile_Connections/Images_userAvatars/default_avatar.jpg';
                        }
            
                    }else{
                        $strImageFilePath = '/Mobile_Connections/Images_userAvatars/default_avatar.jpg';
                        //no image submitted
                    }
        //echo $strImageFilePath;
    
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
                            `active`,
                            `userAvatarFilePath`
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
                            '".$bitActive."',
                            '".$strImageFilePath."'
                        )";
                        echo $sqlAddUser;
                        
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
