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
            </div>
            
            <table class="display" cellspacing="0">
                <thead class="tableHeader">
                    <tr>
                        <th>Username</th>
                        <th>Email Address</th>
                        <th>Send Pictures</th>
                    </tr>
                </thead>
                <tfoot class="tableFooter">
                    <tr>
                        <th>Username</th>
                        <th>Email Address</th>
                        <th>Send Pictures</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php include "getFirebaseUsers.php"?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>

</body>
</html>