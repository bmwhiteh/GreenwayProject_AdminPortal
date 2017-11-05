<!DOCTYPE html>


<html>
<head>
    <title>Home</title>
    <style>
        body{
            width: 100%;
            background-color: #1B371A ;
        }

        .contentBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
        }
        div.dataTables_wrapper {
            margin-bottom: 3em;
        }
    </style>
    <script src="../js/jquery-3.2.1.min.js"></script>

   <link rel="stylesheet" type="text/css" href="DataTables/datatables.css"/>

    <script type="text/javascript" src="DataTables/datatables.js"></script>
    <script>
        $(document).ready(function() {
            $('table.display').DataTable();
        } );
    </script>
</head>

<body>

<?php include "../Dashboard_Pages/navBar.html"; ?>
<div class="contentBox">

    <h1 style="margin-bottom: 30px; margin-top:0px; color: white; vertical-aligh:middle; text-align: center;">Viridian Ticket System</h1>

    <div style="width:80%;margin:auto;">
    <table id="" class="display" cellspacing="0" width="80%"  style="margin-top: 20px;padding:5px;">
        <thead>
        <tr style="background-color: #448b41">
            <th>Ticket Id</th>
            <th>Title</th>
            <th>Type</th>
            <th>Created On</th>
            <th>View</th>
        </tr>
        </thead>
        <tfoot>
        <tr style="background-color: #448b41">
            <th>Ticket Id</th>
            <th>Title</th>
            <th>Type</th>
            <th>Created On</th>
            <th>View</th>
        </tr>
        </tfoot>
        <tbody>
        
        <tr>
            <td>99</td>
            <td>Group of Guys loitering</td>
            <td>8</td>
            <td>8-23-2017</td>
            <td><a href="ticketInfo.php?ticketid=9">View Ticket</a></td>
        </tr>
        <?php include "getTickets.php"?>
        </tbody>
    </table>
    
    
   
</div>

</body>
</html>

<script>

</script>