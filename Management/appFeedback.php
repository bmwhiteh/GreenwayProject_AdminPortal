<?php include "../Dashboard_Pages/navBar.php"; ?>

<!DOCTYPE html>

<html>
<head>
    <title>App Issues</title>
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
            
        });
    </script>
</head>

<body class="genericBody">

<div class="contentBox">
    
    <div class="employeeTables">
        <div class="currentEmployees">
            <div class="employeeHeader">
                <h2>Unresolved Issues</h2>
                <div class="employeeButtons">
                    <button class="button" id="addBtn" type="button">Add Feedback</button>
                </div>
            </div>
            
    <div>
             <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3 class="modal-title">Add New Feedback</h3>
                <div class="modal-body">
                <form action="./addNewFeedback.php" method="post" id="addUserForm" class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-sm-2 control-label"
                                    for="content">Feedback</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                       id="content" name="feedback" placeholder="Enter Feedback..."/>
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-2 control-label" for="strErrorLocation">Error Location</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="strErrorLocation" name="errorLocation">
                                        <option value="Mobile">Mobile</option>
                                        <option value="Web">Web</option>
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
    </script>
            
        <div>
            <table class="display" cellspacing="0">
                <thead class="tableHeader">
                    <tr>
                        <th>Id</th>
                        <th>Date Received</th>
                        <th>Error Location</th>
                        <th>Feedback</th>
                        <th>Mark Resolved</th>
                    </tr>
                </thead>
                <tfoot class="tableFooter">
                    <tr>
                        <th>Id</th>
                        <th>Date Received</th>
                        <th>Error Location</th>
                        <th>Feedback</th>
                        <th>Mark Resolved</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php include "getUnresolvedFeedback.php"?>
                </tbody>
            </table>
            
            <div class="employeeHeader">
                <h2>Resolved Issues</h2>
            </div>
            
             <table class="display" cellspacing="0">
                <thead class="tableHeader">
                    <tr>
                        <th>Id</th>
                        <th>Date Received</th>
                        <th>Error Location</th>
                        <th>Feedback</th>
                        <th>Mark Unresolved</th>
                    </tr>
                </thead>
                <tfoot class="tableFooter">
                    <tr>
                        <th>Id</th>
                        <th>Date Received</th>
                        <th>Error Location</th>
                        <th>Feedback</th>
                        <th>Mark Unresolved</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php include "getResolvedFeedback.php"?>
                </tbody>
            </table>
    </div>
        
    </div>
</div>

</body>
</html>