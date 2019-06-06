<?php include "../Dashboard_Pages/navBar.php"; ?>
<?php
include("../MySQL_Connections/config.php");
   if(isset($_FILES['trailOverlay'])){
      $errors= array();
      $file_name = $_FILES['trailOverlay']['name'];
      $file_tmp =$_FILES['trailOverlay']['tmp_name'];
      $file_ext=strtolower(end(explode('.',$_FILES['trailOverlay']['name'])));
      
      $expensions= array("kml","kmz");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a KML or KMZ file.";
      }
      
      if(empty($errors)==true){
        $filePath = "Overlays/Trails/".$file_name;
        $date = date("Y/m/d H:i:s");
         move_uploaded_file($file_tmp, $filePath);
         
         $removeActiveSql = "UPDATE `trailOverlay` SET `active`='0' WHERE `active`= '1'";
         $removeResult = $conn->query($removeActiveSql) or die("Query 1 fail");
         
         $sql = "INSERT INTO `trailOverlay`(`filePath`, `fileName`, `dateUploaded`, `active`)
         VALUES('$filePath', '$file_name', '$date', '1')";
    
        $result = $conn->query($sql) or die("Queryfail");  
        
        
      }else{
        // print_r($errors);
      }
   }
?>
<!DOCTYPE html>

<html>
<head>
    <title>Manage Overlays</title>
    <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>
    <link rel="stylesheet" type="text/css" href="/css/managementPages.css"/>
    
    <link rel="stylesheet" href="../Push_Notifications/customBootstrap/css/bootstrap.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../Push_Notifications/customBootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../Push_Notifications/DataTables/datatables.js"></script>
    <link rel="stylesheet" type="text/css" href="../Push_Notifications/DataTables/datatables.css">
    <script>
        $(document).ready(function() {
            $('table.display').DataTable({
                "order": [[ 2, "desc" ]]
            });
            
        });
    </script>
    <script>
    
     function createTrailFriendlyBusiness(){
	var business =  document.getElementById('businessName').value;
    var address = document.getElementById('address').value;
    var city = document.getElementById('city').value;
    var zipCode = document.getElementById('zipCode').value;
    var bathrooms = document.getElementById('bathroomsAvailable').value;
    var waterRefill = document.getElementById('waterRefill').value;
    var bikeRepair = document.getElementById('bikeRepair').value;
    
$.ajax({
  url: "addNewTrailFriendlyBusiness.php",
  type: "post", //send it through get method
  data: { 
    business: business,
    address: address,
    city: city,
    zipCode: zipCode,
    bathrooms: bathrooms,
    waterRefill: waterRefill,
    bikeRepair: bikeRepair
  },
  success: function(response) {
      document.getElementById('myModal').style.display = "none";
  },
  
  statusCode: {
        500: function() {
          alert("Error: Email already in use.");
        }
      }
  
});
}
</script>
</head>

<body class="genericBody">

<div class="contentBox">
    
    <div class="employeeTables">
        <div class="currentEmployees">
            
        <div>
            <form style="float:right;" action="" method="POST" enctype="multipart/form-data">
                    <input type="file" name="trailOverlay" />
                    <button id="deleteBtn" type="submit">Add Trail Overlay</button>
                 </form>
            <div class="employeeHeader">
                <h2 style="min-width:20%;">Trail Overlays</h2>
                
            </div>
            
             <table class="display" cellspacing="0">
                <thead class="tableHeader">
                    <tr>
                        <th>Id</th>
                        <th>File Name</th>
                        <th>Date Uploaded</th>
                        <th>Active</th>
                     <!--   <th>Set Active</th>-->
                    </tr>
                </thead>
                <tfoot class="tableFooter">
                    <tr>
                        <th>Id</th>
                        <th>File Name</th>
                        <th>Date Uploaded</th>
                        <th>Active</th>
                     <!--   <th>Set Active</th>-->
                    </tr>
                </tfoot>
                <tbody>
                    <?php include "getTrailOverlays.php"?>
                </tbody>
            </table>
            
    <!--        <div class="employeeHeader">-->
    <!--            <h2 style="min-width:20%;">Trail Friendly Businesses</h2>-->
    <!--            <div class="employeeButtons">-->
    <!--               <button class="button" id="removeBtn" type="button">Remove Business</button>-->
    <!--                <button class="button" id="editBtn" type="button">Edit Business</button>-->
                    
    <!--                 <button class="button" id="addBtn" type="button">Add Business</button>-->
    <!--            </div>-->
    <!--        </div>-->
            
    <!--         <table class="display" cellspacing="0">-->
    <!--            <thead class="tableHeader">-->
    <!--                <tr>-->
    <!--                    <th>Id</th>-->
    <!--                    <th>Business</th>-->
    <!--                    <th>Address</th>-->
    <!--                    <th>Bathroom</th>-->
    <!--                    <th>Water Refill</th>-->
    <!--                    <th>Bike Repair</th>-->
    <!--                </tr>-->
    <!--            </thead>-->
    <!--            <tfoot class="tableFooter">-->
    <!--                <tr>-->
    <!--                    <th>Id</th>-->
    <!--                    <th>Business</th>-->
    <!--                    <th>Address</th>-->
    <!--                    <th>Bathroom</th>-->
    <!--                    <th>Water Refill</th>-->
    <!--                    <th>Bike Repair</th>-->
    <!--                </tr>-->
    <!--            </tfoot>-->
    <!--            <tbody>-->
    <!--                <?php include "getTrailFriendlyBusinesses.php"?>-->
    <!--            </tbody>-->
    <!--        </table>-->
    <!--</div>-->
        
    </div>
    
    <div>
             <!-- The Modal -->
        <div id="myModal" class="modal" style= "padding-top: 3% !important;">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="modal-title">Add New Trail Friendly Business</h3>
                <div class="modal-body">
                <form id="addUserForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Business Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="businessName" name="businessName" placeholder="Enter Business Name..."/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="address" name="address" placeholder="Enter Address..."/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">City</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="city" name="city" placeholder="Enter City..."/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Zip Code</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="zipCode" name="zipCode" placeholder="Enter Zip Code..."/>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-2 control-label" for="strNotificationType">Bathrooms Available?</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="bathroomsAvailable" name="bathroomsAvailable">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-2 control-label" for="strNotificationType">Water Refill Available?</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="waterRefill" name="waterRefill">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-2 control-label" for="strNotificationType">Bike Repair Services Available?</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="bikeRepair" name="bikeRepair">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                        </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" onClick="createTrailFriendlyBusiness()">Submit</button>
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
                console.log("In button click");
                modal.style.display = "block";
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
    </script>
    
</div>

</body>
</html>