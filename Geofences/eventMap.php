<?php include "../Dashboard_Pages/navBar.php"; ?>

<!DOCTYPE html>

<html>
<head>
    <title>Event Map</title>
    <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>
    <link rel="stylesheet" type="text/css" href="/css/managementPages.css"/>
    
    <link rel="stylesheet" href="../Push_Notifications/customBootstrap/css/bootstrap.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../Push_Notifications/customBootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../Push_Notifications/DataTables/datatables.js"></script>
    <link rel="stylesheet" type="text/css" href="../Push_Notifications/DataTables/datatables.css">
     <!---Javascript file to use Google Maps API--->
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVZ9qSBrT-dnmrBaxkX2PzWbfmxv6xZgM&v=3&libraries=visualization"></script>
    <script src=./functions.js></script>
    <script>
        $(document).ready(function() {
            $('table.display').DataTable({
            });
            
        });
        function validateRadius(event){
            var currentValue = document.getElementById('geofenceRadius').value;
            var x = event.charCode || event.keyCode;  // Get the Unicode value
            var y = String.fromCharCode(x);  // Convert the value into a character
            var radius = currentValue + y;
            if(radius < 200){
            console.log("Not over 200");
            document.getElementById('error').style.display = "inline";
            }else{
                console.log("Over 200");
                document.getElementById('error').style.display = "none";
            }
        }
    </script>
</head>

<body class="genericBody">

<div class="contentBox">
    
    <div class="employeeTables">
        <div class="currentEmployees">
            <div class="employeeHeader">
                <h2>Trail Events</h2>
                <div class="employeeButtons">
                    <button class="button" id="deleteBtn" type="button">Delete Event</button>
                    <button class="button" id="addBtn" type="button" onClick="initialize();">Add Event</button>
                </div>
            </div>
            
    <div>
             <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content"  style="width:70%;">
                <span class="close">&times;</span>
                <h3 class="modal-title">Add New Event</h3>
                <div class="modal-body">
                <form action="./addGeofence.php" method="post" class="form-horizontal" role="form"  enctype="multipart/form-data">
                
                <input type="hidden" name="strEmployeeUsername" value="<?php echo $_COOKIE['user']?>">
                
                <!---the ticket will be displayed at a initial gps point (such as their admin building) until the gps marker is moved--->
                <input type="hidden" name="gpsLat" id="gpsLat" value="41.115618">
                <input type="hidden" name="gpsLong" id="gpsLong" value="-85.111250">
    
    
                <div class="modal_view">
                    <span style="float: left; margin-left: 50px; margin-right: 50px; width: 30%;">
                        <!--Event Date-->
                        <div class="form-group">
                            <div class="col-sm-10">
        
                                <label for="eventDate" class="col-sm-2 control-label">Event Start Date</label>
                                <input type="date" id="eventDate" name="eventDate" class="form-control" />
                                
                            </div>
                        </div>
                        <!--Event Date-->
                        <div class="form-group">
                            <div class="col-sm-10">
        
                                <label for="eventDate" class="col-sm-2 control-label">Event End Date</label>
                                <input type="date" id="endDate" name="endDate" class="form-control" />
                                
                            </div>
                        </div>
                        <!--Event Description-->
                        <div class="form-group">
                            <div class="col-sm-10">
        
                                <label for="strDescription" class="col-sm-2 control-label">Event Description</label>
                                <textarea name="eventDescription" id="eventDescription" class="form-control" ></textarea>
                                
                            </div>
                        </div>
                        <!--Notification Text-->
                        <div class="form-group">
                            <div class="col-sm-10">
        
                                <label for="strTitle" class="col-sm-2 control-label">Notification Text</label>
                                <input type="text" id="strNotificationText" name="strNotificationText" class="form-control" />
                                
                            </div>
                        </div>
                        
                        <!--Geofence Radius-->
                        <div class="form-group">
                            <div class="col-sm-10">
        
                                <label for="geofenceRadius" class="col-sm-2 control-label">Geofence Radius (must be at least 200)</label>
                                <input type="number" id="geofenceRadius" name="geofenceRadius" class="form-control" onkeydown="validateRadius(event)" />
                                <p id="error" style="color:red; margin: 0; display: none;">Not greater than 200!</p>
                            </div>
                        </div>
                         
                         <!--Submit Button-->
                         <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" name="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                        
                    </span>
                
                    <!--Google Map to mark the ticket location-->
                    <span class="Modal_add_Map">
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                
                                <label for="mapCanvas" class="col-sm-2 control-label">Drag the Marker to Set the Event Location</label>
                                <div id="mapCanvas" class="mapCanvas" style="width: 500px; height: 400px;"></div>
                      
                           </div>
                        </div>
                        
                    </span>
                   
               </div>
               
               <br style="clear:both"/>
               
            </form>
                </div>
            </div>

        </div>
        
        
              <!-- The Modal -->
        <div id="deleteModal" class="modal">
            
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="modal-title">Delete Event</h3>
                <div class="modal-body">
                                <form action="./deleteGeofence.php" method="post" id="addUserForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                        for="content">Select Event to Delete</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="listOfEvents" name="listOfEvents">
                                    <?php 
                                        $today = new DateTime('now'); 
                                        $today->setTimeZone(new DateTimeZone('America/Indiana/Indianapolis'));
                                        $date =$today->format('Y-m-d');
                                        $time = $today->format('H:i:s');
                                        $sql = "SELECT * FROM `geofences` WHERE `dtEventDate` >= '$date' && `btActive` = '1'";
                                        $result = $conn->query($sql) or die("Query fail");
                                        while($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                                            <option value="<?php echo $row['intId']?>"><?php echo $row['strNotifText']?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <label  class="col-sm-2 control-label"
                                        for="content">Confirm Deletion</label>
                            <div class="col-sm-10">
                                    <input type="checkbox" id="confirm" name="confirm" onClick="enableSubmit(this)"/> 
                            
                            <script>$('#confirm').on('click', function(e){
    var sbmt = document.getElementById("deleteBtn2");
    var boxChecked = document.getElementById("confirm").checked;
    if (boxChecked == true)
    {
        sbmt.disabled = false;
    }
    else
    {
        sbmt.disabled = true;
    }
});
</script>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" id="deleteBtn2" class="btn btn-default" disabled>Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        
        
    </div>
    
     
    
    <script>
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the button that opens the modal
            var btn = document.getElementById("addBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal
            btn.onclick = function() {
                modal.style.display = "block";
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
          title: "Event Location",
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

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
            
            // Get the modal
            var deleteModal = document.getElementById('deleteModal');

            // Get the button that opens the modal
            var deleteBtn = document.getElementById("deleteBtn");

            // Get the <span> element that closes the modal
            var deleteSpan = document.getElementsByClassName("close")[1];

            // When the user clicks the button, open the modal
            deleteBtn.onclick = function() {
                deleteModal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            deleteSpan.onclick = function() {
                deleteModal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == deleteModal) {
                    deleteModal.style.display = "none";
                }
            }
            
    </script>
            
        <div>
            <table class="display" cellspacing="0">
                <thead class="tableHeader">
                    <tr>
                        <th>Event Start Date</th>
                        <th>Event End Date</th>
                        <th>Summary</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tfoot class="tableFooter">
                    <tr>
                        <th>Event Date</th>
                        <th>Event End Date</th>
                        <th>Summary</th>
                        <th>Description</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php include "getActiveGeofences.php"?>
                </tbody>
            </table>
            
    </div>
        
    </div>
</div>

</body>
</html>