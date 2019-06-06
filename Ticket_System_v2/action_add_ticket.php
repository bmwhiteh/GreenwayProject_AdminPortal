<?php
    /*
    *   author: Bailey Whitehill
    *   description: backend database connection to add a ticket using the modal on the admin portal 
    *                (instead of the mobile connection).
    *               
    */

    //this is the database connection
    include("../MySQL_Connections/config.php");
    include("../Emails/newProblemEmail.php");

    //the database insert is auto-incremented but in order to number the image with the ticket id, we find the next available id and use that
    $sqlGetNextIndex = "SELECT intTicketId FROM maintenancetickets ORDER BY intTicketId DESC LIMIT 0,1";
    $resultGetNextIndex = $conn->query($sqlGetNextIndex) or die("Could Not Get Most Recent Ticket Index.");  
    $row = $resultGetNextIndex->fetch_array(MYSQLI_ASSOC);
    $nextTicketId = $row['intTicketId'] + 1;
      
      
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        
         
        /*
        *   If the employee uploads an image to accompany the ticket, 
        *    we need to save it & its new location, to the server & database
        */
        
        //Path to the image directory
        $target_dir = "../Ticket_System_v2/Submitted_Images/";
        
        //this will be the name and location of the saved image
        $target_file = $target_dir . "ticketid_".$nextTicketId.".jpg";
        
        $uploadOk = 1;
        $imageFileType = "jpg";
        
        //if image upload fails (or an image doesn't exist), it will say so and not include the file path in the database insert
        $strImageFilePath = ""; 
        
        /*
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])){
            var_dump($_FILES);
            $check = getimagesize($_FILES["strImageFilePath"]["name"]);
            if($check !== false) {
                
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
                
            } else {
                
                echo "File is not an image.";
                $uploadOk = 0;
                
            }
        }
        
        
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        
        
        // Check file size
        if ($_FILES["strImageFilePath"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
         */   
            if(! isset($_FILES["strImageFilePath"]) || ! is_uploaded_file($_FILES["strImageFilePath"]["tmp_name"])) {
                exit('There was no file uploaded.');
            }
            
            if($_FILES["strImageFilePath"]["error"] !== UPLOAD_ERR_OK){
                exit('Upload Failed. Error Code: ' . $_FILES["strImageFilePath"]["error"]);
            }
            
            switch(strtolower($_FILES["strImageFilePath"]["type"])){
                case 'image/jpeg':
                    $imageObject = imagecreatefromjpeg($_FILES["strImageFilePath"]["tmp_name"]);
                    break;
                case 'image/png':
                    $imageObject = imagecreatefrompng($_FILES["strImageFilePath"]["tmp_name"]);
                    break;
                case 'image/gif':
                    $imageObject = imagecreatefromgif($_FILES["strImageFilePath"]["tmp_name"]);
                    break;
                default:
                        exit('Unsupported type: '.$_FILES["strImageFilePath"]["type"]);
            }
            
            # Get exif information
            $exif = exif_read_data($_FILES["strImageFilePath"]["tmp_name"]);

            # Get orientation
            $orientation = $exif['Orientation'];
            
            # Manipulate image
            switch ($orientation) {
                case 2:
                    imageflip($imageObject, IMG_FLIP_HORIZONTAL);
                    break;
                case 3:
                    $imageObject = imagerotate($imageObject, 180, 0);
                    break;
                case 4:
                    imageflip($imageObject, IMG_FLIP_VERTICAL);
                    break;
                case 5:
                    $imageObject = imagerotate($imageObject, -90, 0);
                    imageflip($imageObject, IMG_FLIP_HORIZONTAL);
                    break;
                case 6:
                    $imageObject = imagerotate($imageObject, -90, 0);
                    break;
                case 7:
                    $imageObject = imagerotate($imageObject, 90, 0);
                    imageflip($imageObject, IMG_FLIP_HORIZONTAL);
                    break;
                case 8:
                    $imageObject = imagerotate($imageObject, 90, 0); 
                    break;
            }


            
            //Set the dimensions we need to save it as
            $max_width_card = 200;
            $max_height_card = 200;
            
            $max_width_view = 300;
            $max_height_view = 300;
            
            //Caculate the new dimension
            $original_width = imagesx($imageObject);
            $original_height = imagesy($imageObject);
            
            $scale_card = min($max_width_card/$original_width, $max_height_card/$original_height);
            $new_width_card = ceil($scale_card*$original_width); echo $original_width. "=>".$new_width_card;
            $new_height_card= ceil($scale_card*$original_height);echo $original_height. "=>".$new_height_card;
            
            $scale_view = min($max_width_view/$original_width, $max_height_view/$original_height);
            $new_width_view = ceil($scale_view*$original_width);
            $new_height_view = ceil($scale_view*$original_height);
            
            //Create new empty image
            $new_image_card = imagecreatetruecolor($new_width_card, $new_height_card);
            $new_image_view = imagecreatetruecolor($new_width_view, $new_height_view);
            
            // Resample old into new
            imagecopyresampled($new_image_card, $imageObject, 0, 0, 0, 0, $new_width_card, $new_height_card, $original_width, $original_height);
            imagecopyresampled($new_image_view, $imageObject, 0, 0, 0, 0, $new_width_view, $new_height_view, $original_width, $original_height);

            //this will be the name and location of the saved image
            $target_file_card = "../Ticket_System_v2/Images_cardSize/" . "ticketid_".$nextTicketId.".jpg";
            $target_file_view = "../Ticket_System_v2/Images_ticketSize/" . "ticketid_".$nextTicketId.".jpg";

            
            // Catch the image data
            header('Content-Type: image/jpeg');

            imagejpeg($new_image_card, $target_file_card);

            imagejpeg($new_image_view, $target_file_view);
            $strImageFilePath = "ticketid_".$nextTicketId.".jpg";
            // Destroy resources
            imagedestroy($new_image_card);
            imagedestroy($new_image_view);
//Delete the temp file
            @unlink($_FILES["strImageFilePath"]["tmp_name"]);
            
            /*
            //attempt to move the file from its temp directory to the image directory
            if (move_uploaded_file($_FILES["strImageFilePath"]["tmp_name"], $target_file)) {
            
                echo "The file ". basename( $_FILES["strImageFilePath"]["name"]). " has been uploaded.";
                $strImageFilePath = "Submitted_Images/ticketid_".$nextTicketId.".jpg";
            
                
            } else {
                
                echo $_FILES["strImageFilePath"]["tmp_name"] . "he";
                echo "Sorry, there was an error uploading your file.";
                
            }*/
        //}
        /*
        *    now that we've dealt with the image, we now deal with the rest of the info
        */
        
        
        $intUserId = $_POST['intUserId'];
        $dtSubmitted = $_POST['dtSubmitted'];
        $dtEstFinish = date('Y-m-d', strtotime($dtSubmitted. ' + 14 days'));
        $strTime = $_POST['strTime'];
        $strTitle = $_POST['strTitle'];
        $strDescription = $_POST['strDescription'];
        $intTypeId = $_POST['intTypeId'];
        $bitUrgent = $_POST['bitUrgent'];
        $returnToPreviousPage = $_POST['currentPage'];
        $gpsLat  = $_POST['gpsLat'];
        $gpsLong = $_POST['gpsLong'];

        //if the title is more than 255 characters, cut it off
        if( strlen($strTitle)>255){
            $strTitle = substr($strTitle, 255);
            $strTitle = mysqli_real_escape_string($conn, $strTitle);
        }
        
        //If the description is more than 500 characters, cut it off
        if( strlen($strDescription)>500){
            $strDescription = substr($strDescription, 500);
            $strDescription = mysqli_real_escape_string($conn, $strDescription);

        }
        
        if($bitUrgent == 'on'){
            $bitUrgent = '1';
        }else{
            $bitUrgent = '0';

        }

        /*
        *   Add the Ticket to the MaintenanceTickets database with all needed fields. If a field is not set, it will appear as ''
        */
        $user = $_COOKIE['user'];
        $sql = "INSERT INTO `maintenancetickets` (strUserId, dtSubmitted, dtEstFinish, time, strTitle, strDescription, strImageFilePath, intTypeId, bitUrgent, gpsLat, gpsLong) 
        VALUES('$user', '$dtSubmitted','$dtEstFinish','$strTime', '$strTitle','$strDescription','$strImageFilePath','$intTypeId','$bitUrgent', '$gpsLat', '$gpsLong')";
        $result = $conn->query($sql) or die("Could Not Add Ticket To Database. Sql Attempted:".$sql."\n");  
        
        $ticketTypeSql = "SELECT * FROM `tickettypes` WHERE `intTypeId` = '$intTypeId'";
        $type = $conn->query($sql) or die ("Could not retrieve ticket type");
        sendNewProblem($strTitle, $type, $strDescription, $bitUrgent);
        
        
        
        /*
        *   Because the maintenancetickets table requires a user id, we set the employeeId in the 
        *   ticket to a default value (since employees don't have user ids) and add a note to the ticket to record who created the ticket.
        */
        
         
        $addDate = $_POST["date"];
        $addDate = mysqli_real_escape_string($conn, $addDate);
        
        $fullComment = $_POST["comment"];
        $fullComment = mysqli_real_escape_string($conn, $fullComment);
    
        //Add the note to the database
        $displayName = $_COOKIE['displayName'];
        $sqlAddNote = "INSERT INTO ticketnotes (intTicketId, strUserId, strEmployeeName, dateAdded, comment) 
        VALUES('$nextTicketId','$user','$displayName','$dtSubmitted', 'Added maintenance ticket to records.')";
        $resultAddNote = $conn->query($sqlAddNote) or die("Add note fail. $sqlAddNote");
        
        //add information for tasks page into database
        date_default_timezone_set('UTC');
        $date = date('m/d/Y h:i:s a', time());
        $sql = "UPDATE `tasks` SET `lastCompleted`= '$date' WHERE `taskId`= '6'";
        $result = $conn->query($sql) or die("Update fail");
        
        //redirect to the previous page
        header("location: /Ticket_System_v2/".$returnToPreviousPage);
        
        

    }
?>