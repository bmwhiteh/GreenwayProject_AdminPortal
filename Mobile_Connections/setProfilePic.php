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
   /*  $data = '
       {"userID":"SHEBe2yObJhPFxf1efaP6dcZ5pO2",
       "userBirthdate":"1993-01-01",
       "userHeight":0,
       "userWeight":50,
       "userGender":"O",
       "userLat":"38.58157",
       "userLng":"-121.4944"}
        ';
        */
    $sql = "INSERT INTO `databaseTests` (`dataSent`)
                VALUES ( '".$data."' );";
                
    $result = $conn->query($sql) or die("Query fail");  
    
    //echo $data. "\n";
     
  
       

    //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $userId = $dataArray->userID;
        $userId = mysqli_real_escape_string($conn, $userId);
        
         //we don't need to decode the image if the script fails prior to now
                    $encoded_img = $dataArray->avatar;
                    $strImageFilePath = "/Mobile_Connections/Images_userAvatars/default_avatar.jpg"; //File Path: /Mobile_Connections/Images_userAvatars/
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
                                        VALUES ( '$data', 'signup.php: LINE 1274'  )";
                                $resultStoreLocation = $conn->query($sqlStoreLocation);
                               // echo -2; //"User Id not set";
                            } else{
                                //echo -2;//echo "image was successfully decoded.\n\n";
                            }
                               
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
                            $target_file_avatar = "../Mobile_Connections/Images_userAvatars/userAvatar_".$userId.".jpg";
                            
                            
                            // Catch the image data
                            header('Content-Type: image/jpeg');
                
                            $save_image_avatar = imagejpeg($new_image_avatar, $target_file_avatar);
                
                            $strImageFilePath = "Images_userAvatars/userAvatar_".$userId.".jpg";
                            // Destroy resources
                            imagedestroy($new_image_avatar);
                //Delete the temp file
                
                        }
                    }
                    
    echo $strImageFilePath;
?>