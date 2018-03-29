<!DOCTYPE html>
<html>
    <head>
        <title>Ticket Density Heat Map</title>
    <link rel="stylesheet" type="text/css" href="/css/heatMaps.css"/>
    <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>
    <link rel="shortcut icon" href="../Dashboard_Pages/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVZ9qSBrT-dnmrBaxkX2PzWbfmxv6xZgM&v=3&sensor=true&libraries=visualization"></script>
        <script type="text/javascript">
            //initialize the function to listen for the submit button
            $("document").ready(function(){
                
                //when the submit button is clicked ("submitted"), begin the JS/Ajax script
                $(".js-ajax-php-json").submit(function(){
                    
                    //initialize the data variable
                    var data = {
                     "action": "points"
                    };
                    

                    //serialize the data as a JSON pack and include the other parameters of the form
                    data = $(this).serialize() + "&" + $.param(data);
                    //perform the ajax action to go run the php with the sql query in it
                    $.ajax({
                        type: "POST",
                        //input data type is a json message
                        dataType: "json",
                        url: "./filterTicketDensity.php", //Relative or absolute path to filterUserActivity.php file
                        data: data,
                        //if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
                        success: function(data) {
                            console.log(data[0]);
                            var gpsArray = JSON.parse(data["json"]);
                            var gpsList = [];
                            var i = 0;
                            for(i = 0; i < gpsArray.length; i++){
                                var gpsString = gpsArray[i]["gps point"];
                                //console.log(gpsString);
                                var gpsSplit = gpsString.split(",");
                                var latLongPt=new google.maps.LatLng(parseFloat(gpsSplit[0]), parseFloat(gpsSplit[1]));
                                console.log(latLongPt.lat());
                                gpsList.push(latLongPt);
                            }
                            
                           console.log(gpsList);
                           
                           //populates the heatmap to display
                           initMap(gpsList);
                          
                     
                        }
                        ,
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                            alert("Error: " + errorThrown); 
                        }   
                    });
                    return false;
                    
                });
                
            //creates the map and heatmap layer using the gps points
            function initMap(gpsList) {
                var map, heatmap;
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: {lat: 41.1178412, lng: -85.1082758}
                });

                heatmap = new google.maps.visualization.HeatmapLayer({
                    data: gpsList,
                    map: map
                });
            }
            
            });
      
        </script>
    </head>
    
    <body class="genericBody">
        
    <!-- includes the authentication that a user is logged in and the navBar -->
    <?php require_once("../Login_System/verifyAuth.php"); ?>
    <?php include "../Dashboard_Pages/navBar.php"; ?>
        <div class="contentBox">
            <div class="title">
                <h3 id="mapHeader">Ticket Density Heat Map</h3>
                <div class="filterForm">
                    <!---This is the form that will allow them to filter the Heat Map--->
                    <form action="ticket_density.php" class="js-ajax-php-json" method="post" accept-charset="utf-8">
                        <label for="startDate">Start Date:</label><input id="startDate" name="startDate" type="date"/>
                            <br><br>
                            <label for="startTime">Start Time:</label><input id="startTime" name="startTime" type="time"/>
                            <br><br>
                            <label for="endDate">End Date:    </label><input id="endDate" name="endDate" type="date"/>
                            <br><br>
                            <label for="endTime">End Time: </label><input id="endTime" name="endTime" type="time"/>
                            <button id="filter" type="submit" method="post"><b>Load Filtered Heatmap</b></button>
                    </form>
                </div>
                
            </div>
        
            <div class="map" id="map">
                <!--Displays an initial blank google map -->
                <script>
                var map;
                map = new google.maps.Map(document.getElementById('map'),{
                    zoom:10,
                    center: {lat: 41.1178412, lng: -85.1082758}
                });
                </script>
        </div>
    </body>
</html>
    
