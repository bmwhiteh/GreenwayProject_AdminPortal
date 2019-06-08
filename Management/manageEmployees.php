<?php include "../Dashboard_Pages/navBar.php"; 
require '../Mobile_Connections/vendor/autoload.php';
    include("../MySQL_Connections/config.php");
    
    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;

    $serviceAccount = ServiceAccount::fromJsonFile('../Mobile_Connections/firebase-adminsdk.json');
    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->create();
    $auth = $firebase->getAuth();
    ?>

<!DOCTYPE html>

<html>
<head>
    <title>Manage Employees</title>
    <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>
    <link rel="stylesheet" type="text/css" href="/css/managementPages.css"/>
    
    <link rel="stylesheet" href="../Push_Notifications/customBootstrap/css/bootstrap.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="./customBootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../Push_Notifications/DataTables/datatables.js"></script>
    <link rel="stylesheet" type="text/css" href="../Push_Notifications/DataTables/datatables.css">
    <script>
        $(document).ready(function() {
            $('table.display').DataTable({
            });
            
            $("#listOfUsers").change(function() {
                var id = $(this).find(":selected").val();
                $.ajax({
                    url: '../Management/getEmployeeToEdit.php',
                    type:'post',
                    dataType: "json",
                    data:{id:id},
                    cache: false,
                    success: function(employeeData) {
                    if(employeeData) {
                        console.log(employeeData);
                        $("#employeeDataToEdit").show();
                        $("#displayName").val(employeeData[0]);
                        $("#firebaseEmail2").val(employeeData[1]);
                        //     $("#intSecurityLevel option[value='1']").removeAttr("selected");
                        //     $("#intSecurityLevel option[value='2']").removeAttr("selected");
                        //     $("#intSecurityLevel option[value='3']").removeAttr("selected");
                        //     $("#intSecurityLevel option[value='4']").removeAttr("selected");
                         $("#intSecurityLevel2").val(employeeData[2]);
                     
                    } else {
                        console.log("In ajax else");
                    }
                    },
                    error: function(xhr){
                            console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
                        }
                });
                })
});
    </script>
    <script>
    function makePassword() {
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 7; i++){
    text += possible.charAt(Math.floor(Math.random() * possible.length));
}
    text = text + "!";
  return text;
}
    function createFirebaseAccount(){
	var email =  document.getElementById('firebaseEmail').value;
    var password = makePassword();
    var intSecurityLevel = document.getElementById('intSecurityLevel').value;
    var displayName = document.getElementById('displayNameInput').value;

$.ajax({
  url: "addNewFirebaseEmployee.php",
  type: "post", //send it through get method
  data: { 
    displayName: displayName,
    email: email,
    password: password,
    intSecurityLevel: intSecurityLevel
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

function editAccount(){
	var email =  document.getElementById('firebaseEmail2').value;
    var intSecurityLevel2 = document.getElementById('intSecurityLevel2').value;
    var displayName = document.getElementById('displayName').value;
    var userId = document.getElementById('listOfUsers').value;
    $.ajax({
      url: "editEmployee.php",
      type: "get", //send it through get method
      data: { 
        displayName: displayName,
        email: email,
        intSecurityLevel2: intSecurityLevel2,
        userId: userId
      },
      success: function(response) {
          document.getElementById('editModal').style.display = "none";
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
            <div class="employeeHeader">
                <h2>Manage Employees</h2>
                <div class="employeeButtons">
                    <button class="button" id="addBtn" type="button">Add Employee</button>
                    <button class="button" id="editBtn" type="button">Edit Employee</button>
                </div>
            </div>
            
    <div>
             <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="modal-title">Add New Employee</h3>
                <div class="modal-body">
                <form id="addUserForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Display Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="displayNameInput" name="displayName" placeholder="Enter Display Name..."/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Email Address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="firebaseEmail" name="email" placeholder="Enter Email Address..."/>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-2 control-label" for="strNotificationType">Security Level</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="intSecurityLevel" name="intSecurityLevel">
                                        <option value="1">Administrator</option>
                                        <option value="2">Manager</option>
                                        <option value="3">Ranger</option>
                                    </select>
                                </div>
                        </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" class="btn btn-default" onClick="createFirebaseAccount()">Submit</button>
                        </div>
                    </div>

                </form>
                </div>
            </div>

        </div>
        
        
    </div>
    
    <div>
        
              <!-- The Edit Modal -->
        <div id="editModal" class="modal">

            <!-- Edit Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="modal-title">Edit Employee</h3>
                <div class="modal-body">
                    <form id="editUserForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                        for="content">Select Employee to Edit</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="listOfUsers" name="listOfUsers">
                                    <?php 
                                        $sql = "SELECT * FROM `firebaseusers` WHERE `intSecurityLevel` < 4 ";
                                        $result = $conn->query($sql) or die("Query fail");
                                        while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                                             $user = $auth->getUser($row['userId']);
                                    ?>
                                            <option value="<?php echo $user->uid;?>"><?php echo $user->displayName;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="employeeDataToEdit">
                                    <div class="form-group">
                                <label  class="col-sm-2 control-label"
                                        for="content">Display Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                           id="displayName" name="displayName"
                                           placeholder="Enter Display Name..." value=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label"
                                        for="content">Email Address</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                           id="firebaseEmail2" name="email" placeholder="Enter Email Address..."/>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 control-label" for="strNotificationType">Security Level</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="intSecurityLevel2" name="intSecurityLevel2">
                                            <option value="1">Administrator</option>
                                            <option value="2">Manager</option>
                                            <option value="3">Ranger</option>
                                            <option value="4">Mobile</option>
                                        </select>
                                    </div>
                            </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-default" onClick="editAccount()">Submit</button>
                            </div>
                        </div>
    
                    </form>
                    </div>
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
            var editModal = document.getElementById('editModal');

            // Get the button that opens the modal
            var editBtn = document.getElementById("editBtn");

            // Get the <span> element that closes the modal
            var editSpan = document.getElementsByClassName("close")[1];

            // When the user clicks the button, open the modal
            editBtn.onclick = function() {
                editModal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            editSpan.onclick = function() {
                editModal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == editModal) {
                    editModal.style.display = "none";
                }
            }
            
        </script>
            <table class="display" cellspacing="0">
                <thead class="tableHeader">
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Security Level</th>
                    </tr>
                </thead>
                <tfoot class="tableFooter">
                    <tr>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Security Level</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php include "getFirebaseEmployee.php"?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>

</body>
</html>