<!DOCTYPE html>

<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css"/>
    <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
    transition: background-color .5s;
}

.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    right: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidenav a:hover {
    color: #f1f1f1;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

#main {
    transition: margin-left .5s;
    padding: 16px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
</head>

<?php require_once("../Login_System/verifyAuth.php"); ?>
<body class="genericBody">

<?php include "../Dashboard_Pages/navBar.html"; ?>
<div class="contentBox">
    <?php include "../User_Accounts/test.php"; ?>
    <div class="leftSide">
        <div class="topBox"><h3>Number of People on the Trail</h3>
        <h1 style="-webkit-margin-after: 0; -webkit-margin-before: 0; width:50%;">0</h1>
        <img src="../images/currentUserTest.png" height="55%" style="margin-top: 5%; margin-left:55%;"></img>
        </div>
        
        <div class="midBox"><h3>Open Tickets</h3>
            <h1 style="-webkit-margin-after: 0;"><?php include "numOpenTickets.php"?></h1>
            <img src="../images/openTicketTest.png" height="65%" style="margin-left:55%;"></img>
        </div>
        
        <div class="bottomBox"><h3>Tickets Closed This Week</h3>
            <h1 style="-webkit-margin-after: 0;"><?php include "numClosedTickets.php" ?></h1>
            <img src="../images/closedTicketTest.png" height="65%" style="margin-left:55%;"></img>
        </div>
    </div>
    
    <div class="map" id="map" style="background-color:rgba(51,51,51,.3)">
        <div class="mapContentTop">
            <div class="mapTitle">
                <b><text id="mapTitle" style="font-size:1.17em; margin-left:2%;">Usage Heat Map</text></b>
                <input type="button" id="mapButton" value="Display Open Tickets" onClick="initTicketMarkerMap();" 
                style="float:right; margin-top:5px; margin-right:2%;"></input>
            </div>
        </div>
        <div class="mapContentBottom" style="height:90%; width:96%; margin:2% 2% 2% 2%;">
            <div class="mapView" id="mapView">
                <script>
                    var map, heatmap;
                    
                    function initMap(){
                        document.getElementById("mapButton").value="Display Open Ticket Map";
                        document.getElementById("mapButton").setAttribute("onClick", "javascript: initTicketMarkerMap();")
                        document.getElementById("mapTitle").innerHTML="Usage Heat Map";
                        map = new google.maps.Map(document.getElementById('mapView'),{
                        zoom: 10,
                        center: {lat:41.1178412, lng: -85.1082758}
                        });
                        
                        heatmap = new google.maps.visualization.HeatmapLayer({
                            data: getPoints(),
                            map: map
                        });
                    }
                    
                    //Heatmap data:
                    function getPoints() {
                        return [
                            <?php
                            include("../MySQL_Connections/config.php");
                
                            $sql = "SELECT `gpsLat`,`gpsLong` FROM `locationData` where datediff(`activityDate`, curDate()) >= -7";
                            $result = $conn->query($sql) or die("Query fail");
                            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                            ?>
                            new google.maps.LatLng(<?php echo $row['gpsLat']?>, <?php echo $row['gpsLong']?>),
        
                            <?php
                                }
                            ?> 
                        ];
                    }
                    
                    function initTicketMarkerMap() {
                        document.getElementById("mapButton").value="Display Usage Heat Map";
                        document.getElementById("mapButton").setAttribute("onClick", "javascript: initMap();")
                        document.getElementById("mapTitle").innerHTML="Open Tickets Map";
                        
                        var map = new google.maps.Map(document.getElementById('mapView'), {
                            zoom: 10,
                            center: {lat: 41.1178412, lng: -85.1082758}
                        });

                        <?php
                            include("../MySQL_Connections/config.php");
                    
                            $sql = "SELECT `intTicketId`,`gpsLat`,`gpsLong` FROM `maintenancetickets` where `dtClosed` is null";
                            $result = $conn->query($sql) or die("Query fail");
                            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                        ?>
                
                        var marker = new google.maps.Marker({
                            position:  new google.maps.LatLng(<?php echo $row['gpsLat']?>, <?php echo $row['gpsLong']?>),
                            map: map,
                            icon:'../images/markerLogo.png',
                            animation: google.maps.Animation.DROP,
                            title: 'Click marker to display Ticket ID #<?php echo $row['intTicketId']?>',
                            url: "https://virdian-admin-portal-whitbm06.c9users.io/Ticket_System_v2/ticket_info_single.php?ticketid=" + <?php echo $row['intTicketId']?> 
                        });
                        
                        google.maps.event.addListener(marker, 'click', function() {
                            window.location.href = this.url;
                        });
                        <?php
                                }
                        ?>
                    }
                </script>
                <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVZ9qSBrT-dnmrBaxkX2PzWbfmxv6xZgM&libraries=visualization&callback=initMap">
                </script>
            </div>
        </div>
    </div>
    <div class="twitter">
        <a class="twitter-timeline" data-width="400" data-height="385" href="https://twitter.com/FortWayneTrails">Tweets by @FortWayneTrails</a>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>

</body>
</html>