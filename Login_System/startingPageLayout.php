<!DOCTYPE html>

<html>
<head>
    <title>Home</title>
    <!-- <link rel="stylesheet" type="text/css" href="/css/viridian.css"/> -->
        <link rel="stylesheet" type="text/css" href="/css/styles.css"/>
        
        <script src="https://code.jquery.com/jquery-1.11.0.min.js" /></script>
        <script src = "../js/changeColorScheme.js"></script>
        

</head>

<body class="genericBody" onload="changeCSS();">
<?php include "../Dashboard_Pages/navBarColorTest.html"; ?>
<div class="contentBox">

<h2>Content Here</h2>
<br/><br/>
<form method="get" action="../Color_Switch/updateColorScheme.php">
<select>
  <option value="Viridian">Viridian</option>
  <option value="Atlantean">Atlantean</option>
  <option value="Carmine">Carmine</option>
  <option value="Daybreak">Daybreak</option>
  <option value="Sapphire">Sapphire</option>
  <option value="Sangria">Sangria</option>
</select>
<button type="button">Save Color Change!</button>
</form>
  


</div>
</div>
</body>
</html>