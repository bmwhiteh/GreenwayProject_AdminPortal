<!DOCTYPE html>

<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css"/>
    <link rel="stylesheet" type="text/css" href="/css/viridian.css"/>
</head>

<?php require_once("../Login_System/verifyAuth.php"); ?>
<body class="genericBody">

<?php include "navBar.php"; ?>
<div class="contentBox">
    
    <div class="leftSide" style="width: 10%;">
        <div class="topBox"><h3>Number of People on the Trail</h3>
        <span style="font-size: 28px; font-weight:bold; vertical-align:top;">0</span>
        <!-- <img src="../images/currentUserTest.png" height="35%" style="margin-left: 5%;  border: 2px solid black; vertical-align:text-top;"></img> -->
        </div>
        
        <div class="midBox"><h3>Open Tickets</h3>
            <h1 style="-webkit-margin-after: 0;"><?php include "numOpenTickets.php"?></h1>
           <!-- <img src="../images/openTicketTest.png" height="65%" style="margin-left:55%;"></img> -->
        </div>
        
        <div class="bottomBox"><h3>Tickets Closed This Week</h3>
            <h1 style="-webkit-margin-after: 0;"><?php include "numClosedTickets.php" ?></h1>
           <!--  <img src="../images/closedTicketTest.png" height="65%" style="margin-left:55%;"></img> -->
        </div>
    </div>
    
    <div class="map" id="map" style="background-color:rgba(51,51,51,.3); margin-right: 2%; width: 45%;">
        <div class="mapContentTop">
            <div class="mapTitle">
                <b><text id="mapTitle" style="font-size:1.17em; margin-left:2%;">Usage Heat Map</text></b>
                <input type="button" id="mapButton" value="Display Open Tickets" onClick="initTicketMarkerMap();" 
                style="float:right; margin-top:5px; margin-right:2%;"></input>
            </div>
        </div>
        <div class="mapContentBottom" style="height:350px; width:480px; margin:2% 2% 2% 2%;">
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
    <div class="twitter" style="width:25%;">
        <a class="twitter-timeline" data-width="400" data-height="385" href="https://twitter.com/FortWayneTrails">Tweets by @FortWayneTrails</a>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>

</body>
</html>