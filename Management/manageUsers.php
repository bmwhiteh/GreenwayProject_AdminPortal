<?php include "../Dashboard_Pages/navBar.php"; ?>

<!DOCTYPE html>

<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="/css/viridian.css"/>
    <link rel="stylesheet" type="text/css" href="/css/styles.css"/>
    
    <link rel="stylesheet" href="../Push_Notifications/customBootstrap/css/bootstrap.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="./customBootstrap/js/bootstrap.min.js"></script>
    <style>
       
         .employeeHeader{
            display:flex;
        }
        
        /*button{*/
        /*    margin-left:502px;*/
        /*    margin-top:4%;*/
        /*    padding: 1px 5px;*/
        /*}*/
        
        /* The Modal (background) */
        #addUserForm{
            display: block;
            margin-top: 0em;
            background-color: white;
            margin-left:0%;
            margin-right:0%;
        }
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 15%; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        
    </style>
    <script type="text/javascript" src="../Push_Notifications/DataTables/datatables.js"></script>
    <link rel="stylesheet" type="text/css" href="../Push_Notifications/DataTables/datatables.css"/>
    <script>
        $(document).ready(function() {
            $('table.display').DataTable({
            });
        } );
    </script>
</head>

<body class="genericBody">

<div class="contentBox">
    <div class="employeeTables">
        <div class="currentEmployees">
            <div class="employeeHeader">
                <h2>Manage Employees</h2>
                <button id="myBtn" type="button" style="width:20%; float:right;">Add Employee</button>
                <button id="editBtn" type="button" style="width:20%; float:right;">Edit Employee</button>
            </div>
            
    <div>
             <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="modal-title">Add New Employee</h3>
                <div class="modal-body">
                <form action="./addNewUser.php" method="get" id="addUserForm" class="form-horizontal" role="form">
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
                <form action="./addNewUser.php" method="get" id="addUserForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                        for="content">Select User to Edit</label>
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
                        
                        <div class="employeeDataToEdit" style="display: none;">
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
           /* 
            // Get the modal
            var modal = document.getElementById('editModal');

            // Get the button that opens the modal
            var btn = document.getElementById("editBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[1];

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
            }*/
        </script>
            <table id="" class="display" cellspacing="0" style="margin-top: 20px; padding:5px; margin-left:5%; ">
                <thead style="background-color: #448b41">
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Security Level</th>
                        <th>Lock/Unlock User</th>
                        <th>Deactivate User</th>
                    </tr>
                </thead>
                <tfoot style="background-color: #448b41">
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Security Level</th>
                        <th>Lock/Unlock User</th>
                        <th>Deactivate User</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php include "getCurrentUsers.php"?>
                </tbody>
            </table>
        </div>
        <div class='inactiveEmployees'>
            <h2>Inactive Employees</h2>
            <table id="" class="display" cellspacing="0" style="margin-top: 20px; padding:5px; margin-left:5%; width:80%;">
                <thead style="background-color: #448b41">
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Security Level</th>
                        <th>Reactivate User</th>
                    </tr>
                </thead>
                <tfoot style="background-color: #448b41">
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Security Level</th>
                        <th>Reactivate User</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php include "./getInactiveUsers.php"?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>