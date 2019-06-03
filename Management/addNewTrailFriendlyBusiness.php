<?php
    include("../MySQL_Connections/config.php");
    
//    if($_SERVER["REQUEST_METHOD"] == "POST") {
     
//     $business = $_POST['business'];
//     $address = $_POST['address'];
//     $city = $_POST['city'];
//     $zipCode = $_POST['zipCode'];
//     $bathrooms = $_POST['bathrooms'];
//     $waterRefill = $_POST['waterRefill'];
//     $bikeRepair = $_POST['bikeRepair'];
// $gpsLat =1;
// $gpsLong =2;

$business = 'test';
$address = '3295 State Route 219';
$bathrooms='1';
$waterRefill='1';
$bikeRepair = '0';
$zipCode = '45828';

     // google map geocode api url
                $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&postal_code=45828&key=AIzaSyBDPrizY3A8DH-BaSuHsSLy6-WObmEvAd4";
        
          //  $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=67.2,45.0&key=AIzaSyBDPrizY3A8DH-BaSuHsSLy6-WObmEvAd4";
                // get the json response
                $resp_json = file_get_contents($url);
                echo $resp_json;
                echo "yes";
                // decode the json
                $resp = json_decode($resp_json, true);
                echo $resp;
            if($resp_json == null){
                echo "NULL";
            }
                // response status will be 'OK', if able to geocode given address 
                echo $resp['status'];
                if($resp['status']=='OK'){
                    echo "in ok";
                        $arrayLength = count($resp['results'][0]['
                        ']);
                        $regex = "^\d{5}^";
                        for($i = 0; $i < $arrayLength; $i++){
                            $tempZip = $resp['results'][0]['address_components'][$i]['long_name'];
                            if (preg_match($regex, $tempZip)) {
                                $intZipCode = $tempZip;
                            }
                           // echo "iteration $i Zip Code: $intZipCode";
                        }
                         //echo $intZipCode;
                }else{
                    echo "In else";
                }
    
    //  $sql = "INSERT INTO `trailFriendlyBusinesses` (`businessName`, `address`, `gpsLat`, `gpsLong`, 
    //  `bathroom`, `waterRefill`, `bikeRepair`)
    //  VALUES ('$business', '$address' , '$gpsLat','$gpsLong' , '$bathrooms','$waterRefill', '$bikeRepair')";
//echo $sql;
    // $result = $conn->query($sql) or die("Failed to add business");

  // }
?>
   