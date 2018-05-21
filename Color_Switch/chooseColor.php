<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../Dashboard_Pages/nav.css">
    <link rel="stylesheet" type="text/css" href="../css/colorSwitching.css">
     <script src="../js/jquery-3.2.1.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
function openChangeColor() {
    document.getElementById("colorNav").style.width = "20%";
    document.getElementById("contentBox").style.marginLeft = "250px";
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeChangeColor() {
    document.getElementById("colorNav").style.width = "0";
    document.getElementById("contentBox").style.marginLeft= "0";
    document.body.style.backgroundColor = "white";
}

</script>

</head>
<body>
    
    <?php
		include("../MySQL_Connections/config.php");
		
	    $sql = "SELECT name FROM colorSchemes WHERE active = 1";
		$result = $conn->query($sql) or die("Query fail");
		$row = $result->fetch_array(MYSQLI_ASSOC);
	?>

<div id="colorNav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeChangeColor()">&times;</a>
            <img id="profileImage" src=<?php echo $_COOKIE['profileImage']; ?>></img>
            <a><h5 id="changeColorHeader">Change Color Scheme</h5></a>
            <a><h6 id="profileInfo">Your current color scheme is: <?php echo $row['name']?> </h6></a>
            <form class="colorChange" method="post" action="../Color_Switch/getColor.php">
            
            <select id="color" name="color"> 
              <option value="City">Kekionga</option>
              <option value="GoldCity">Golden Kekionga</option>
              <option value="Atlantean">Atlantean</option>
              <option value="Autumnal">Autumnal</option>
              <option value="Carmine">Carmine</option>
              <option value="Daybreak">Daybreak</option>
              <option value="Espresso">Espresso</option>
              <option value="Gunmetal">Gunmetal</option>
              <option value="High Roller">High Roller</option>
              <option value="Lemon Drop">Lemon Drop</option>
              <option value="Sakura">Sakura</option>
              <option value="Sangria">Sangria</option>
              <option value="Sapphire">Sapphire</option>
              <option value="Viridian">Viridian</option>
            </select>
            
            <!-- The button to reset Color --> 
            <button id="changeColorButton" name="changeColorButton" type="submit"><b>Change Color</b></button>
            <?php
                echo $error;
            ?>
        </form>
</div>

</body>
</html>