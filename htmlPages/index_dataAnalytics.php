<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Analytics</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        /* Create three unequal columns that floats next to each other */
        .column {
            float: left;
            padding: 10px;
            height: auto; /* Should be removed. Only for demonstration */
        }

        /* Left column */
        .column.left {
            width: 20%;
            margin:0;
        }

        /* Middle column */
        .column.middle {
            width: 70%;
        }

        /* Right column */
        .column.right {
            width: 10%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Style the footer */
        .footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
        }

        /* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
        @media (max-width: 600px) {
            .column.side, .column.middle {
                width: 100%;
            }
        }

        GraphMenu ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        li a, .dropbtn {
            display: block;
            color: #000;
            padding: 8px 16px;
            text-decoration: none;
        }

        /* Change the link color on hover */
        li a:hover, .dropdown:hover .dropbtn{
            background-color: #555;
            color: white;
        }

        li.dropdown {
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {background-color: #f1f1f1}

        .dropdown:hover .dropdown-content {
            display: block;
        }

    </style>
</head>
<body>

<div class="header">
    <?php
        include("navbar.html");

    ?>
</div>

<br style="clear: both;">

<div class="row">
    <div class="column left" style="background-color:#aaa;">
        <h2>Choose a Graph: </h2>
        <div class="GraphMenu">
            <ul>
                <li class="dropdown">
                    <a href="#home" class="dropbtn" onclick="openGraphOptions('heat')">Heat Maps</a>
                    <div id="heat" class="dropdown-content">
                        <a href="#">Fitness Activities</a>
                        <a href="#">Maintenance</a>
                        <a href="#">Push Notifications</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#news" class="dropbtn" onclick="openGraphOptions('activity')">Tracked Activities</a>
                    <div id="activity" class="dropdown-content">
                        <a href="#">By Activities</a>
                        <a href="#">By Time of Day</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#contact" class="dropbtn" onclick="openGraphOptions('user')">User Information</a>
                    <div id="user" class="dropdown-content">
                        <a href="#">By Height</a>
                        <a href="#">By Weight</a>
                        <a href="#">By Gender</a>
                        <a href="#">By Age</a>
                        <a href="#">By Activities</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#about" class="dropbtn" onclick="openGraphOptions('ticket')">Maintenance Information</a>
                    <div id="ticket" class="dropdown-content">
                        <a href="#">By Ticket Type</a>
                        <a href="#">By Ticket Status</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="column middle" style="background-color:#bbb;">Graphs</div>
    <div class="column right" style="background-color:#ccc;">Extra Space</div>
</div>

<div class="footer">
    <p>Footer</p>
</div>

</body>
</html>

<script>
    function openGraphOptions(showType) {
        var x = document.getElementById(showType);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
            x.previousElementSibling.className += " w3-green";
        } else {
            x.className = x.className.replace(" w3-show", "");
            x.previousElementSibling.className =
                x.previousElementSibling.className.replace(" w3-green", "");
        }
    }
</script>