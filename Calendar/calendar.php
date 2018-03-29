<?php
/**
 * Created by PhpStorm.
 * User: bmwhi
 * Date: 10/13/2017
 * Time: 9:50 PM
 */
 
include "../Dashboard_Pages/navBar.php";

?>
<!DOCTYPE html>

<html>
    <head>
        <title>Calendar</title>
        <meta charset="utf-8">
        <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
        <script src='fullcalendar/lib/jquery.min.js'></script>
        <script src='fullcalendar/lib/moment.min.js'></script>
        <script src='fullcalendar/fullcalendar.js'></script>
        <script>
            var showThese = "";
            
            

            $(function() {
            
            
            
              // page is now ready, initialize the calendar...
              var calendarDiv = document.getElementById('calendar');
              $(calendarDiv).fullCalendar({
                  
                  header: {
                    left: 'prev,next today myCustomButton',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                  }
                  , eventSources: [
                    
                    {
                    url: './get_events.php',
                    type: 'POST',
                    error: function(){
                      alert('There was an error while getting the events.');
                    }
                  },
                  {
                    url: './get_notifications.php',
                    type: 'POST',
                    error: function(){
                      alert('There was an error while getting the notifications.');
                    }
                  },
                    
                    ], 
                 
                })
            
            });


        </script>
        <style>
            .theBox{
                background-color: #8c8c8c;
                margin: 0px 100px 50px 100px;
          
            }
            
            

        
          #calendar {
            max-width: 900px;
          }


        </style>
    </head>

</html>



<!-- style="background-color: #1B371A;"-->
<body style="background-color: #1B371A;">

    <div class="theBox">
      <br/><br/>
      <div style="border:2px solid grey; background-color:white; border-radius: 10px; width:50%; margin:auto; vertical-align:top; text-align:center;">
        <div style="font-size:20px;font-weight:bold; text-decoration:underline;margin-bottom:5px;">Calendar Options</div>
            <form method="post" name="ShowEvents">
                Include: 
                <input type="checkbox" name="includeTickets" id="includeTickets">
                <label for="includeTickets">Maintenance Tickets</label>

                <input type="checkbox" name="includeNotifications" id="includeNotifications">
                <label for="includeNotifications">Push Notifications</label>

                <input type="checkbox" name="includeRangers" id="includeRangers">
                <label for="includeRangers">Ranger Events</label>

                <input type="checkbox" name="includePersonal" id="includePersonal">                
                <label for="includePersonal">My Events</label>

            </form>
        </div>
      
      <div style="padding:30px 125px;">
        <div id='calendar' style="background-color:white;z-index:5; "></div>
      </div>
    </div>
    
    
</body>



