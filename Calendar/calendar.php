<?php
/**
 * Created by PhpStorm.
 * User: bmwhi
 * Date: 10/13/2017
 * Time: 9:50 PM
 */
 
     include("../Dashboard_Pages/navBar.php"); 
        require_once("../Login_System/verifyAuth.php"); 
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
              <link rel="stylesheet" type="text/css" href=<?php echo $_COOKIE['colorCssLink']; ?>>
        <script src='/Ticket_System_v2/functions.js'></script>

      <link rel="stylesheet" href="../Calendar/calendar.css">
        
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
                  },
                  eventLimit: true, // for all non-agenda views
                  views: {
                    agenda: {
                      eventLimit: 20// adjust to 6 only for agendaWeek/agendaDay
                    }
                  },
                   eventSources: [
                    
                    {
                    url: './get_tickets.php',
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
                    eventClick: function(calEvent, jsEvent, view) {
        
                      var title = calEvent.title;
                      if ((title).includes("Ticket")){
                        
                        PopupTicket(calEvent.id,calEvent.gpsLat, calEvent.gpsLong);
                        
                      } else{

                      alert('Event: ' + calEvent.title);
                      alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                      alert('View: ' + view.name);
                  
                      }
                    }
                  
                 
                })
            
            });


        </script>
        <style>
            
            
            

        
          #calendar {
            max-width: 900px;
          }


        </style>
    </head>

</html>



<!-- style="background-color: #1B371A;"-->
<body class="genericBody">

  
    <!---View Ticket Modal Window--->
    <div id="myTicket" class="modal" style="display:none;"></div>



    <div class="contentBox" style="display:block;">
      <br/><br/>
      <div style="border:2px solid grey; background-color:white; border-radius: 10px; width:20%; margin:auto; margin-left:5%; vertical-align:top; text-align:center; padding:20px;">
        <div style="font-size:24px;font-weight:bold; text-decoration:underline;margin-bottom:5px;">Calendar Options</div>
            <form method="post" name="ShowEvents">
                
                <div class="calendarOptions">
                <ul>
                  <li>
                    <input type="checkbox" name="includeTickets" id="includeTickets">
                    <label for="includeTickets">Maintenance Tickets</label>
                    <br/>
                    <ul class="subTypes">
                      <li>
                        <input type="checkbox" name="includeTicket_1" id="includeTicket_1">
                        <label for="includeTicket_1">High Water</label>
                    
                      </li>
                      <li>
                        <input type="checkbox" name="includeTicket_2" id="includeTicket_2">
                        <label for="includeTicket_2">Pothole</label>
                    
                      </li>
                      <li>
                        <input type="checkbox" name="includeTicket_3" id="includeTicket_3">
                        <label for="includeTicket_3">Tree/Branch</label>
                    
                      </li>
                      <li>
                        <input type="checkbox" name="includeTicket_4" id="includeTicket_4">
                        <label for="includeTicket_4">Trash Full</label>
                    
                      </li>
                      <li>
                        <input type="checkbox" name="includeTicket_5" id="includeTicket_5">
                        <label for="includeTicket_5">Litter</label>
                    
                      </li>
                      <li>
                        <input type="checkbox" name="includeTicket_6" id="includeTicket_6">
                        <label for="includeTicket_6">Overgrown Brush</label>
                    
                      </li>
                      <li>
                        <input type="checkbox" name="includeTicket_7" id="includeTicket_7">
                        <label for="includeTicket_7">Vandalism</label>
                    
                      </li>
                      <li>
                        <input type="checkbox" name="includeTicket_8" id="includeTicket_8">
                        <label for="includeTicket_8">Suspicious Persons</label>
                    
                      </li>
                      <li>
                        <input type="checkbox" name="includeTicket_9" id="includeTicket_9">
                        <label for="includeTicket_9">Other</label>
                    
                      </li>
                    </ul>
                  </li>
                  <li style="display: list-item;">
                    <input type="checkbox" name="includeNotifications" id="includeNotifications">
                    <label for="includeNotifications">Push Notifications</label>
                    <ul style="margin-left:15px;">
                      <li>
                        <input type="checkbox" name="includeLocalEvent" id="includeLocalEvent">
                        <label for="includeLocalEvent">Local Events</label>
                    
                      </li>
                      <li>
                        <input type="checkbox" name="includeClosures" id="includeClosures">
                        <label for="includeClosures">Closures</label>
                    
                      </li>
                    </ul>
                  </li>
                  <li style="display: list-item;">
                    <input type="checkbox" name="includeRangers" id="includeRangers">
                    <label for="includeRangers">Ranger Events</label>
                  </li>
                  <li style="display: list-item;">
                    <input type="checkbox" name="includePersonal" id="includePersonal">                
                    <label for="includePersonal">My Events</label>
                  </li>
                </ul>

                </div>

                

                

            </form>
            <br/>
            <form method="post">
              <button type="submit" name="addEvent">Add Event</button>
            </form>
        </div>
      <br/>
      <div style="margin:5%; width:90%;">
        <div id='calendar' style="background-color:white;z-index:5; "></div>
      </div>
    </div>
    
    
</body>



