<?php
/**
 * Created by PhpStorm.
 * User: bmwhi
 * Date: 10/13/2017
 * Time: 9:50 PM
 */
?>
<!DOCTYPE html>

<html>
    <head>
        <title>Calendar</title>
        <link rel='stylesheet' href='fullcalendar-3.6.1/fullcalendar.css' />
        <script src='fullcalendar-3.6.1/lib/jquery.min.js'></script>
        <script src='fullcalendar-3.6.1/lib/moment.min.js'></script>
        <script src='fullcalendar-3.6.1/fullcalendar.js'></script>
        <script>
            $(document).ready(function() {

                // page is now ready, initialize the calendar...

                $('#calendar').fullCalendar({
                    // put your options and callbacks here
                })

            });
        </script>
        <style>
            .contentBox{
                background-color: #8c8c8c;
                margin: 0px 100px 50px 100px;
            }
        </style>
    </head>

</html>




<body style="background-color: #1B371A;">
    <?php include "../Dashboard_Pages/navBar.html"; ?>

    <div class="contentBox">
        <div id='calendar'></div>
    </div>
</body>



