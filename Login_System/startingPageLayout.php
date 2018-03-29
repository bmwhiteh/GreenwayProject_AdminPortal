<!DOCTYPE html>

<html>
<head>
    <title>Home</title>
        <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>
        <link rel="stylesheet" type="text/css" href="/css/styles.css"/>
        
        <script src="https://code.jquery.com/jquery-1.11.0.min.js" /></script>
        <script src = "../js/changeColorScheme.js"></script>
        

</head>

<body class="genericBody">
<?php include "../Dashboard_Pages/navBarColorTest.php"; ?>
<div class="contentBox">

<h2>Content Here</h2>
<br/><br/>
<form method="get" action="../Color_Switch/getColor.php">
<select id="color" name="color"> 
  <option value="Viridian">Viridian</option>
  <option value="Atlantean">Atlantean</option>
  <option value="Carmine">Carmine</option>
  <option value="Daybreak">Daybreak</option>
  <option value="Sapphire">Sapphire</option>
  <option value="Sangria">Sangria</option>
</select>
<button type="submit">Save Color Change!</button>
</form>
  


</div>
</div>
</body>
</html>