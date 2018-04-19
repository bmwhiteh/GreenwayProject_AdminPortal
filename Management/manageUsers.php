<?php include "../Dashboard_Pages/navBar.php"; ?>

<!DOCTYPE html>

<html>
<head>
    <title>Manage Users</title>
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
                        $("#employeeDataToEdit").show();
                        $("#firstName").val(employeeData.strFirstName);
                        $("#lastName").val(employeeData.strLastName);
                        $("#email").val(employeeData.strEmailAddress);
                        $("#intSecurityLevel").val(employeeData.intSecurityLevel);
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
</head>

<body class="genericBody">

<div class="contentBox">
    
    <div class="employeeTables">
        <div class="currentEmployees">
            <div class="employeeHeader">
                <h2>Manage Users</h2>
              <!--  <button id="myBtn" type="button" style="width:20%; float:right;">Add Employee</button>
                <button id="editBtn" type="button" style="width:20%; float:right;">Edit Employee</button>
                <button id="deleteBtn" type="button" style="width:20%; float:right;">Delete Employee</button>-->
            </div>
            
    <div>
             <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="modal-title">Add New Employee</h3>
                <div class="modal-body">
                <form action="./addNewEmployee.php" method="get" id="addUserForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">First Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="content" name="firstName" placeholder="Enter First Name..."/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Last Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="content" name="lastName" placeholder="Enter Last Name..."/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Email Address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="content" name="email" placeholder="Enter Email Address..."/>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-2 control-label" for="strNotificationType">Security Level</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="strNotificationType" name="intSecurityLevel">
                                        <option value="1">Administrator</option>
                                        <option value="2">Manager</option>
                                        <option value="3">Ranger</option>
                                    </select>
                                </div>
                        </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Submit</button>
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
                <form action="./editEmployee.php" method="post" id="addUserForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                        for="content">Select Employee to Edit</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="listOfUsers" name="listOfUsers">
                                    <?php 
                                        $sql = "SELECT * FROM `employees`";
                                        $result = $conn->query($sql) or die("Query fail");
                                        while($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                                            <option value="<?php echo $row['intEmployeeId']?>"><?php echo $row['strUsername']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="employeeDataToEdit">
                                    <div class="form-group">
                                <label  class="col-sm-2 control-label"
                                        for="content">First Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                           id="firstName" name="firstName"
                                           placeholder="Enter First Name..." value="<?php echo $row['strFirstName']?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label"
                                        for="content">Last Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                           id="lastName" name="lastName" placeholder="Enter Last Name..."/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-2 control-label"
                                        for="content">Email Address</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                           id="email" name="email" placeholder="Enter Email Address..."/>
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
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
    
                    </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <div>
        
              <!-- The Delete Modal -->
        <div id="deleteModal" class="modal">

            <!-- Delete Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="modal-title">Delete Employee</h3>
                <div class="modal-body">
                <form action="./deleteEmployee.php" method="post" id="addUserForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                        for="content">Select Employee to Delete</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="listOfUsers" name="listOfUsers">
                                    <?php 
                                        $sql = "SELECT * FROM `employees`";
                                        $result = $conn->query($sql) or die("Query fail");
                                        while($row = $result->fetch_array(MYSQLI_ASSOC)) { ?>
                                            <option value="<?php echo $row['intEmployeeId']?>"><?php echo $row['strUsername']?></option>
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
    </div>
        <script>
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

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
            
            // Get the modal
            var deleteModal = document.getElementById('deleteModal');

            // Get the button that opens the modal
            var deleteBtn = document.getElementById("deleteBtn");

            // Get the <span> element that closes the modal
            var deleteSpan = document.getElementsByClassName("close")[2];

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
            <table class="display" cellspacing="0">
                <thead class="tableHeader">
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Send Pictures</th>
                    </tr>
                </thead>
                <tfoot class="tableFooter">
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Send Pictures</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php include "getCurrentUsers.php"?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>

</body>
</html>