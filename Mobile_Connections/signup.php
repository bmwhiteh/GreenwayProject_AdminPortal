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
    /*$data = file_get_contents("php://input");
    
    $sql = "INSERT INTO `databaseTests` (`dataSent`)
                VALUES ( '".$data."' );";
                
      $result = $conn->query($sql) or die("Query fail");  
    
    echo $data. "\n";*/
    
    
    $data = '
       {
       "firstName":"Connor",
       "lastName":"Julian",
       "emailAddress":"julicm01@students.ipfw.edu",
       "userPassword":"Sheamitch1",
       "userPasswordConfirm":"Sheamitch1",
       "userBirthdate":"1968-01-01",
       "userHeightFeet":"",
       "userWeight":""
           
       }
        ';


    
    if(isset($data)){
                

        //JSON must be decoded using PHP function
        $dataArray = json_decode($data);
        $strFirstName = $dataArray->firstName;
        $strLastName = $dataArray->lastName;
        $strUsername = substr($strFirstName,0,1) . $strLastName;
        
        $strEmailAddress = $dataArray->emailAddress;
        $strUserPassword = $dataArray->userPassword;
        $strUserConfirmPassword = $dataArray->userPasswordConfirm;
        
        
        //sets values of newPassword and confirmNewPassword from user input   
        $newPassword = mysqli_real_escape_string($conn, $strUserPassword);
        $confirmNewPassword = mysqli_real_escape_string($conn, $strUserConfirmPassword );
        
        //regex to force passwords to have an uppercase letter,a lowercase letter, and a number
        //regex also forces password to be 6-12 characters long
        $regex = "^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).{6,12}^";
        if (preg_match($regex, $newPassword)) {
            
            //checks if values match
            if($newPassword == $confirmNewPassword){
                
                $options = [
                    'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                ];
                    
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, $options);

                
            }else{
                //displays error message and redirects to passwordReset page
                echo "Your passwords do not match!";
               
            }
        } else {
            // If preg_match() returns false, then the regex does not
            // match the string
            echo "Passwords must be 6-12 characters in length and 
            contain an uppercase letter, a lowercase letter, and a number.";
        }
        
        //birthdate sent as 
        $dtBirthDate = $dataArray->userBirthdate;
        
        
        //may need to convert or calculate these
        $intHeight = $dataArray->userHeight;
        $intWeight = $dataArray->userWeight;
        
        
        
        
        
        $strGender = "F";           //$strGender = $dataArray->userGender;
        $strLat = "1.9285435";      //$strLat = $dataArray->userLat;
        $strLong = "180.02342";     //$strLong = $dataArray->userLng;
    

        if(isset($hashedPassword)){
            /*$sql = "INSERT INTO `users` (`strFirstName`, `strLastName`, `strEmailAddress`, `strEncryptedPassword`, `dtBirthdate`, `intHeight`, `intWeight`, `strGender`, `strLat`, `strLong`)
                    VALUES ( '".$strFirstName."' , '".$strLastName."', '".$strEmailAddress."', '".$hashedPassword."' , '".$dtBirthDate."', '".$intHeight."', '".$intWeight."', '".$strGender."', '".$strLat."', '".$strLong."');";
            
            
            
            $result = $conn->query($sql) or die("Query fail");  */
            echo hello;
            
            //what needs to be sent back
        }
    }
?>
