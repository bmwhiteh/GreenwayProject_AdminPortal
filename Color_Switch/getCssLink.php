<?php 
    include("../MySQL_Connections/config.php");
    
    $return = $_POST;
    
    //this is the color the user wants 
    $colorName = $return['action'];
    
    //use later: WHERE `name` = '. $colorName . '"
    $sql = "SELECT `colorCssLink` FROM `colorSchemes` WHERE `name` = 'Atlantean'";
    
    $result = $conn->query($sql) or die("Query fail");
        
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $link = $row['colorCssLink'];
    setcookie("colorCssLink", $link, time() + (86400 * 30), "/"); // 86400 = 1 day
    
    echo $link;

?>
