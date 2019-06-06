  
            var markers = [];
            var events = [];
            var popUpWindow;
            var submitted = false;
            var title;
            var count = 0;

            // initializes map
    
            function initialize() {
                var cent = {lat: 41.1178412, lng: -85.1092758};
                var map = new google.maps.Map(document.getElementById('map'), {
                   zoom: 10,
                   center: cent
                });
            
            
                var ex = document.getElementById('search');
                var searchBox = new google.maps.places.SearchBox(ex);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(ex);
                
                searchBox.addListener('places_changed', function(){
                    var places = searchBox.getPlaces();
                    if(places.length == 0){
                        return;
                    }
                    places.forEach(function(place){
                        if(!place.geometry){
                            console.log("Returned place contains no geometry");
                            return;
                        }
                    markers.push(addMarker(place.geometry.location, map));
                    });
                })
                
               
               

                // adds an event listener for when the user clicks on the map
                google.maps.event.addListener(map, 'click', function(event) {
                    addMarker(event.latLng, map);
                });
                

            }

            // function for adding marker to map
            function addMarker(location, map) {
                // adds marker to the map wherever the user clicked
                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    id: location,
                    icon: '../images/markerLogo.png'
                });
                
                markers.push(marker, 'null', 'null');
                
                var contentString = '<div>'+
                '<table>'+
                '<tr><td>Name of Event: </td><td><input type="text" value="" id="nameOfEvent"+count cols="20"></td></tr>'+
                '<tr><td>Description:</td><td><textarea rows="4" cols="18" id="desc"+count></textarea></td></tr>'+
                '<tr><td></td><td align="right"><button type="button" onclick="changeContent()">Submit</button></td></tr></table></div>'
                popUpWindow = new google.maps.InfoWindow({
                    content: contentString
                }); 
                
                marker.addListener('click', function(){
                    popUpWindow.open(map, marker);
                });
                
                marker.addListener('rightclick', function(){
                    removeMarker(marker, marker.id);
                });
                
                

                
            }
            
            function addMarkersToMap(){
                
            }
            
            function removeMarker(marker){
                if(submitted){
                    removeEvent(marker);
                }
                
                marker.setMap(null);
            }
            
            function changeContent(){
                submitted = true;
                title = document.getElementById('nameOfEvent').value;
                var name = document.getElementById('nameOfEvent').value;
                var description = document.getElementById('desc').value;
                popUpWindow.setContent('<div id="testDiv"><b>'+name+'</b></div>' + '<br>' + description);
                
                addEvent(name, description);
                count++;
                
            }
            

            
            function addEvent(n, d){
                select = document.getElementById('eventsList');
                
                events.push(n, d);
                var opt = document.createElement('option');
                opt.value = n;
                opt.innerHTML = n;
                select.appendChild(opt);
                
            }
           
            function removeEvent(marker){
                var e = title;
                var select = document.getElementById('eventsList');
                
                for(var i=0; i < select.length; i++){
                    if(select.options[i].value == e){
                        select.removeChild(select.options[i]);
                    }
                }
                
            }
            
        
            

            // loads map
            google.maps.event.addDomListener(window, 'load', initialize);
