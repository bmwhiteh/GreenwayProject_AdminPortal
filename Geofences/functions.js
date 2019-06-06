//This initializes the map for the 'Add Ticket' Map
      function initialize() {
          console.log("In initalize");
        //Initialize the center of the map to IPFW's campus & zoomed in to view the road map layout
        var mapOptions = {
          center: new google.maps.LatLng(41.115618, -85.111250),
          zoom: 12,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        //Initialize the map to loading to its div element with the map options from above
        var map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
        
        //Initialize the map marker
        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(41.115618, -85.111250),
          draggable: true,
          icon: '../images/markerLogo.png',
          animation: google.maps.Animation.DROP,
          title: "Problem Location",
        });
        
        //Set the Map with it's Viridian Marker
        marker.setMap(map);
      
        //Allow the gps marker to be moved and save the new coords to gpsLat & gpsLong
        google.maps.event.addListener(marker, 'dragend', function (event) {
          document.getElementById("gpsLat").value = this.getPosition().lat();
          document.getElementById("gpsLong").value = this.getPosition().lng();
        });
      //Resize the map to fit in its box
      $('#myModal').on('shown.bs.modal', function() {
        
        //Get the center of the map before resizing it
        var currentCenter = map.getCenter(); 
        
        google.maps.event.trigger(map, "resize");
         
        // Re-set previous center
        map.setCenter(currentCenter);
      
        
      });
      }