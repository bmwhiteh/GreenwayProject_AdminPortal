<?php include "../Dashboard_Pages/navBar.php"; ?>

<!DOCTYPE html>

<html>
<head>
    <title>Tasks</title>
    <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>
    <link rel="stylesheet" type="text/css" href="/css/taskPages.css"/>
    
    <link rel="stylesheet" href="../Push_Notifications/customBootstrap/css/bootstrap.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../Push_Notifications/customBootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../Push_Notifications/DataTables/datatables.js"></script>
    <link rel="stylesheet" type="text/css" href="../Push_Notifications/DataTables/datatables.css">
    <script>
        $(document).ready(function() {
            $('table.display').DataTable({
                paging: false
            });
            
        });
    </script>
</head>

<body class="genericBody">

<div class="contentBox">
    
    <div class="tasks">
        <div class="tasksTable">
            <div class="employeeHeader">
                <h2>Tasks Ran</h2>
            </div>
            
        <div>
            <table class="display" cellspacing="0">
                <thead class="header">
                    <tr>
                        <th>Task Id</th>
                        <th>Task</th>
                        <th>Last Completed</th>
                    </tr>
                </thead>
                <tfoot class="footer">
                    <tr>
                        <th>Task Id</th>
                        <th>Task</th>
                        <th>Last Completed</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php include "getTasks.php"?>
                </tbody>
            </table>
            
            
    </div>
        
    </div>
</div>

</body>
</html>