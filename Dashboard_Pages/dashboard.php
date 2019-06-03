<!DOCTYPE html>

<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="/css/dashboardPages.css"/>
    <link rel="shortcut icon" href="../Dashboard_Pages/favicon.png" type="image/x-icon">
    <script src="../../js/jquery-3.2.1.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.3.0/firebase.js"></script>
    <!--<script rel="preload" as="script" src="../../Login_System/verifyFirebaseAuth.js"></script>-->
</head>
<script>
    function animationHover(element, animation){
    element = $(element);
    element.hover(
        function() {
            element.addClass('animated ' + animation);        
        },
        function(){
            //wait for animation to finish before removing classes
            window.setTimeout( function(){
                element.removeClass('animated ' + animation);
            }, 2000);         
        });
}

$(document).ready(function(){
    $('#quickStats1').each(function() {
        animationHover(this, 'rubberBand');
        console.log("In each");
    });

    $('#quickStats2').each(function() {
        animationHover(this, 'rubberBand');
    });
    
    $('#quickStats3').each(function() {
        animationHover(this, 'rubberBand');
    });
    
    $('#mapButton').each(function() {
        animationHover(this, 'pulse');
    });
    
});
</script>

<body class="genericBody">
<?php include "navBar.php"; ?>

<div class="contentBox">
    
    <div class="leftSide">
        <div class="topBox"><h3>Number of People on the Trail</h3>
            <h1><?php include "numCurrentUsers.php"?></h1>
            <div class="absolute">
                <img src=<?php echo $_COOKIE['userIcon']; ?> id="quickStats1"></img>
            </div>
        </div>
        
        <div class="midBox"><h3>Open Maintenance Tickets</h3>
            <h1><?php include "numOpenTickets.php"?></h1>
            <div class="absolute">
                <img src=<?php echo $_COOKIE['openTicketsIcon']; ?> id="quickStats2"></img>
            </div>
        </div>
        
        <div class="bottomBox"><h3>Tickets Closed This Week</h3>
            <h1><?php include "numClosedTickets.php" ?></h1>
            <div class="absolute">
                <img src=<?php echo $_COOKIE['closedTicketsIcon']; ?> id="quickStats3"></img>
            </div>
        </div>
    </div>
    
    <div class="map" id="map">
        <div class="mapContentTop">
            <div class="mapTitle">
                <b><text id="mapTitle">Usage Heat Map</text></b>
                <input type="button" id="mapButton" value="Display Open Tickets" onClick="initTicketMarkerMap();"></input>
            </div>
        </div>
        <div class="mapContentBottom">
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
                            url: "../Ticket_System_v2/ticket_table_header.php?ticketid=" + <?php echo $row['intTicketId']?> 
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