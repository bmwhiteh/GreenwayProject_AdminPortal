<?php 
    include("../MySQL_Connections/config.php");
    
    $notificationId = $_POST['listOfNotifications'];
    $id = $_POST['notificationId'];
    
    $sql = "SELECT * FROM `pushnotifications` WHERE `intNotificationId` = '$notificationId'";
    $result = $conn->query($sql) or die("Query fail");
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $oneSignalId = $row['oneSignalId'];
    $oneSignalId = trim($oneSignalId);
  
    $ch = curl_init();
    $httpHeader = array(
          'Authorization: Basic YjQyMzY3NDQtOWE4NS00MDc1LWE1ZTMtZGExMjRkN2FhOThi'
        );
    $url = "https://onesignal.com/api/v1/notifications/" . $oneSignalId. "?app_id=eecf381c-62fd-4ac7-ac38-4496d79c71fb";

    $options = array (
      CURLOPT_URL => $url,
      CURLOPT_HTTPHEADER => $httpHeader,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_CUSTOMREQUEST => "DELETE",
      CURLOPT_SSL_VERIFYPEER => FALSE
    );
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    echo $response;
    curl_close($ch);
    
    header("location: ./notifications.php");
    
    $sql = "DELETE FROM `pushnotifications` WHERE `intNotificationId` = '$notificationId'";
    $result = $conn->query($sql) or die("Query fail");
?>