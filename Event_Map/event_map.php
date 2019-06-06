<!DOCTYPE html>
<html>
    <head>
        <title>Event Map</title>
     
            <link rel="stylesheet" type="text/css" href="/css/eventMap.css"/>
            <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>
            <link rel="shortcut icon" href="../Dashboard_Pages/favicon.png" type="image/x-icon">
        
            <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVZ9qSBrT-dnmrBaxkX2PzWbfmxv6xZgM&v=3&libraries=places"></script>
            <script type="text/javascript" src="events.js"></script>
     
    </head>
    
    <!-- body of the page -->
    
    <body class='genericBody'>
        <!-- Checks log in credentials and includes navigation bar at the top. -->
  	    <?php require_once("../Login_System/verifyAuth.php"); ?>
  	    <?php include "../Dashboard_Pages/navBar.php"; ?>
  	
  	    <div class='contentBox'>
  	        <div id='sidePanel' class='sidePanel'>
                <select name="events" size='10' id='eventsList' class='eventsList'>
             
                </select>
  	        </div>
  	      
            <input id='search' type='text' placeholder='Search Box' style='width: 400px; height: 25px; margin-top: 2%;'>
            <div class='map' id='map'></div>
        </div>
    </body>
</html>

<style>
    #sidePanel.sidePanel{
        border: thin solid black;
        margin-top: 5%;
        margin-bottom: 5%;
        margin-left: 1%;
        width: 300px;
        background-color: #58bdf4;
    }

    #eventsHeader.eventsHeader{
        background-color: red;
    
    }
    
    #eventsList.eventsList{
        width: 96%;
        height: 98%;
        margin-left: 2%;
        margin-top: 1%;
        margin-bottom: 1%;
        font-size: 16px;
    }
    
</style>