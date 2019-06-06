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
        
        $notificationFeedSql = "SELECT `oneSignalId`, `intType`, `btHasPhoto`, `dtSentToUsers`,`strNotificationType`,`strJSONMessage` FROM `pushnotifications` ORDER BY `dtSentToUsers`  DESC LIMIT 50";
        $notificationFeedResults = $conn->query($notificationFeedSql);
        
        $notificationFeedObj = array(); // object(stdClass)
        while($row = $notificationFeedResults->fetch_array(MYSQLI_ASSOC)){
            $activityObj = (object)array();
            $activityObj->strType = $row['strNotificationType'];
            $activityObj->message = $row['strJSONMessage'];
            $iconURL = "https://virdian-admin-portal-whitbm06.c9users.io/Mobile_Connections/Images_notificationIcons/";
            $photoURL = "https://virdian-admin-portal-whitbm06.c9users.io/Mobile_Connections/Images_notificationPhotos/Default";
            $type = $row['intType'];
            $hasPhoto = $row['btHasPhoto'];
            $notificationID = $row['oneSignalId'];
            
            if ($type == 0) {
                $iconURL = $iconURL . "Other.png";
                $photoURL = $photoURL . "Other.jpg";
            } else if ($type == 1) {
                $iconURL = $iconURL . "ClosedTrail.png";
                $photoURL = $photoURL . "ClosedTrail.jpg";
            } else if ($type == 2) {
                $iconURL = $iconURL . "LocalEvent.png";
                $photoURL = $photoURL . "LocalEvent.jpg";
            } else {
                $iconURL = $iconURL . "SevereWeather.png";
                $photoURL = $photoURL . "SevereWeather.jpg";
            }
            
            if ($hasPhoto == 1) {
                $photoURL = "https://virdian-admin-portal-whitbm06.c9users.io/Mobile_Connections/Images_notificationPhotos/notificationPhoto_" . $notificationID . ".jpg";
            }
            
            $activityObj->intType = $type;
            $activityObj->iconURL = $iconURL;
            $activityObj->photoURL = $photoURL;
            $activityObj->notificationID = $notificationID;
            $activityObj->dateSent = $row['dtSentToUsers'];
        array_push($notificationFeedObj, $activityObj);
        }
        $notificationFeedJSON = json_encode($notificationFeedObj);
        echo $notificationFeedJSON;

?>