<!DOCTYPE html>

<html>
<head>
    <title>Home</title>
    <style>
        body{
            width: 100%;
            overflow: hidden;
            background-color: #1B371A ;
        }

        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
            display: -webkit-flex;
            display: flex;
        }
        .leftSide{
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            margin: 3% 1.5% 3% 3%
        }
        .map{
            -webkit-flex: 2;
            -ms-flex: 2;
            flex: 2;
            margin: 3% 1.5% 3% 1.5%;
        }

        .twitter{
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            margin: 3% 3% 3% 1.5%
        }
        .topBox{
            height: 30%;
            background-color: #448b41;
        }

        .midBox{
            height: 30%;
            margin-top: 5%;
            background-color: #55ad52;
        }

        .bottomBox{
            height: 30%;
            margin-top: 5%;
            background-color: #77be74;
        }

    </style>

</head>

<body>

    <?php include "navBar.html"; ?>
<div class="contentBox">
    <div class="leftSide">
        <div class="topBox"> Number of Current People on the Trail</div>
        <div class="midBox"> Number of Open Tickets </div>
        <div class="bottomBox"> Number of Tickets closed in the last 7 days</div>
    </div>
    <div class="map" id="map">
        <script>

            // This example requires the Visualization library. Include the libraries=visualization
            // parameter when you first load the API. For example:
            // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=visualization">

            var map, heatmap;

            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: {lat: 41.1178412, lng: -85.1082758}
                });

                heatmap = new google.maps.visualization.HeatmapLayer({
                    data: getPoints(),
                    map: map
                });
            }
            // Heatmap data: 500 Points
            function getPoints() {
                return [
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),
                    new google.maps.LatLng(41.1178412, -85.1082758),

                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),
                    new google.maps.LatLng(41.1198612, -85.1042738),

                    new google.maps.LatLng(41.1148612, -85.1042738),
                    new google.maps.LatLng(41.1148612, -85.1042738),
                    new google.maps.LatLng(41.1148612, -85.1042738),
                    new google.maps.LatLng(41.1148612, -85.1042738),
                    new google.maps.LatLng(41.1148612, -85.1042738),
                    new google.maps.LatLng(41.1148612, -85.1042738),
                    new google.maps.LatLng(41.1148612, -85.1042738),
                    new google.maps.LatLng(41.1148612, -85.1042738),
                    new google.maps.LatLng(41.1148612, -85.1042738),
                    new google.maps.LatLng(41.1148612, -85.1042738),
                    new google.maps.LatLng(41.1148612, -85.1042738)
                ];
            }
        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVZ9qSBrT-dnmrBaxkX2PzWbfmxv6xZgM&libraries=visualization&callback=initMap">
        </script>
         <!-- <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1VWuJk_bhXl0nF4ntCsIoyvBpDW0" width="520" height="385"></iframe> -->
    </div>
    <div class="twitter">
        <a class="twitter-timeline" data-width="400" data-height="385" href="https://twitter.com/FortWayneTrails">Tweets by @FortWayneTrails</a>
        <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>

</body>
</html>