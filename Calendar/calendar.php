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
     <link rel="stylesheet" href="../Calendar/calendar.css">
        <!---Bootrap for the Modals--->
      <link rel="stylesheet" href="/Ticket_System_v2/bootstrap.css">
      <script src="../Push_Notifications/customBootstrap/js/bootstrap.min.js"></script>
      
      <!---Javascript file to use Google Maps API--->
      <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVZ9qSBrT-dnmrBaxkX2PzWbfmxv6xZgM&v=3&libraries=visualization"></script>
      
      
        <script src='../Ticket_System_v2/functions.js'></script>
                <script src='../Calendar/calendar_functions.js'></script>

        <script type="text/javascript" src="jQuery_PlugIn_MultiSelect/src/jquery.multi-select.js"></script>
                    
      
        
        <script>
            var showThese = "";
            /*
              t1 = high water             t2 = pothole
              t3 = tree/branch            t4 = trash full
              t5 = overgrown brush        t6 = litter
              t7 = vandalism              t8 = suspicious persons
              t9 = other
            */
                          var curSource = new Array();
              var newSource = new Array(); 

            $(document).ready(function() {
               var filter_tickets = {t1: document.getElementById("t1").checked,
                          t2 : document.getElementById("t2").checked,
                          t3 : document.getElementById("t3").checked,
                          t4 : document.getElementById("t4").checked,
                          t5 : document.getElementById("t5").checked,
                          t6 : document.getElementById("t6").checked,
                          t7 : document.getElementById("t7").checked,
                          t8 : document.getElementById("t8").checked,
                          t9 : document.getElementById("t9").checked
                          };
                          
              /*
                n1 = local event
                n2 = trail closure
                n3 = severe weather
              */
              var filter_notifications = {
                n1 : document.getElementById("n1").checked,
                n2 : document.getElementById("n2").checked,
                n3 : document.getElementById("n3").checked
              }
              
              var filter_events = {
                e1 : document.getElementById("e1").checked
              }
              curSource[0] = { url: './get_tickets.php', type: 'POST', data: filter_tickets, error: function(){alert('There was an error while getting the events.');}};
              curSource[1] = { url: './get_notifications.php', type: 'POST', data: filter_notifications, error: function(){alert('There was an error while getting the events.');}};
              curSource[2] = { url: './get_events.php', type: 'POST',  data: filter_events, error: function(){alert('There was an error while getting the events.');}};
            
            
            
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
                    
                    curSource[0],
                    curSource[1],
                    curSource[2],

                    ], 
                    eventClick: function(calEvent, jsEvent, view) {
        
                      var title = calEvent.title;
                      if ((title).includes("Ticket")){
                        
                        openTicket(calEvent.id,calEvent.gpsLat, calEvent.gpsLong);

                      } else if((title).includes("Notification")){
                        ModalNotification(calEvent.id);
                      } else if((title).includes("Event")){
                        ModalEvent(calEvent.id);
                      } else{

                      alert('Event: ' + calEvent.title);
                      alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                      alert('View: ' + view.name);
                  
                      }
                    },
                    eventRender: function (event, element)
                    {
                        element.attr('href', '#');
                    }
                  
                 
                })
                $("#t1, #t2, #t3, #t4, #t5, #t6, #t7, #t8, #t9, #n1, #n2, #n3, #e1, #s1").change(function() {
                  
                    console.log("change?");
                    //tickets
                    var statuses_tickets = {t1: document.getElementById("t1").checked,
                          t2 : document.getElementById("t2").checked,
                          t3 : document.getElementById("t3").checked,
                          t4 : document.getElementById("t4").checked,
                          t5 : document.getElementById("t5").checked,
                          t6 : document.getElementById("t6").checked,
                          t7 : document.getElementById("t7").checked,
                          t8 : document.getElementById("t8").checked,
                          t9 : document.getElementById("t9").checked
                          };
                      
                    //notifications
                    var statuses_notifications = {
                      n1 : document.getElementById("n1").checked,
                      n2 : document.getElementById("n2").checked,
                      n3 : document.getElementById("n3").checked
                    }
                    //my events
                    var statuses_events = {
                      e1 : document.getElementById("e1").checked,
                    }
                    //staff events
                    var s1 = '&s1='+$('#s1').is(':checked');
                  
                    
                    //get current status of our filters into newSource
                    newSource[0] = { url: './get_tickets.php', type: 'POST', data: statuses_tickets, error: function(){alert('There was an error while getting the events.');}};
                    newSource[1] = { url: './get_notifications.php', type: 'POST', data: statuses_notifications, error: function(){alert('There was an error while getting the events.');}};
                    newSource[2] = { url: './get_events.php', type: 'POST',  data: statuses_events, error: function(){alert('There was an error while getting the events.');}};
                    
                    //remove the old eventSources (all the previous checks/notchecks)
                    $(calendarDiv).fullCalendar('removeEventSource', curSource[0]);
                    $(calendarDiv).fullCalendar('removeEventSource', curSource[1]);
                    $(calendarDiv).fullCalendar('removeEventSource', curSource[2]);

                    $(calendarDiv).fullCalendar('refetchEvents');
            
                    //attach the new eventSources (replace the checkboxes & refetch the evets)
                    $(calendarDiv).fullCalendar('addEventSource', newSource[0]);
                    $(calendarDiv).fullCalendar('addEventSource', newSource[1]);
                    $(calendarDiv).fullCalendar('addEventSource', newSource[2]);

                    $(calendarDiv).fullCalendar('refetchEvents');
            
                    curSource[0] = newSource[0];
                    curSource[1] = newSource[1];
                    curSource[2] = newSource[2];

                });
               
            });
            
                    
        </script>
        <style>
            
            
            
        .theBox{
            background-color: #8c8c8c;
            margin: 0px 100px 50px 100px;
            
            
        }

        
          #calendar {
            max-width:3000px;
          }
          
          fieldset { 
            display: inline;
            margin-left: 2px;
            margin-right: 2px;
            padding: 0.35em 0.75em 0.625em 0.75em;
            
            vertical-align:top;
          }

          .prettyButtons button{
            padding:5px;
            font-size:14px;
            height:30px;
            margin-bottom:5px;
          }
        </style>
    </head>

</html>



<!-- style="background-color: #1B371A;"-->
<body class="genericBody">

  
    


    <div class="contentBox" >
                <div class="theBox">
     
                  <div id="txtLoading" class="txtLoading" style="display:none;"></div>

         <!---View Ticket Modal Window--->
    <div id="myTicket" class="modal" style="display:none;">I'm Here</div>

      <br/><br/>
      <div style="border:2px solid grey; background-color:white; border-radius: 10px; margin:0% 5% 0% 5%; vertical-align:top; text-align:center;padding-bottom:1%;padding-top:2%;">
        <div style="font-size:24px;font-weight:bold; text-decoration:underline;margin-bottom:5px;">Calendar Options</div>
            <form method="post" name="ShowEvents">
                <ul style="margin-left:5%;width:85vm;font-size:14px;">
                  <li>
                    <fieldset>
                    
                    <legend>Select Ticket Types</legend>
                    <input type="checkbox" id="t1" name="highwater" value="High Water" checked="checked">High Water
                    <input type="checkbox" id="t2" name="pothole" value="Pothole" checked="checked">Pothole
                    <input type="checkbox" id="t3" name="treebranch" value="Tree/Branch" checked="checked">Tree/Branch
                    <input type="checkbox" id="t4" name="trashfull" value="Trash Full" checked="checked">Trash Full<br/>
                    <input type="checkbox" id="t5" name="overgrownbrush" value="Overgrown Brush" checked="checked">Overgrown Brush
                    <input type="checkbox" id="t6" name="litter" value="Litter" checked="checked">Litter
                    <input type="checkbox" id="t7" name="vandalism" value="Vandalism" checked="checked">Vandalism
                    <input type="checkbox" id="t8" name="suspiciouspersons" value="Suspicious Persons" checked="checked">Suspicious Persons
                    <input type="checkbox" id="t9" name="other" value="Other" checked="checked">Other
                  </fieldset>
                  </li>
                  <li>
                    <fieldset>
                  <legend>Select Notifications</legend>

                  <input type="checkbox" id="n1" name="events" value="Events" checked="checked">Local Events
                  <input type="checkbox" id="n2" name="closures" value="Closures" checked="checked">Trail Closures<br/>
                  <input type="checkbox" id="n3" name="alerts" value="Alerts" checked="checked">Weather Alerts
                </fieldset>
                  </li>
                  <li>
                    <fieldset>
                  <legend>Select Optional</legend>

                  <!---<label for="includeRangers"> <input type="checkbox" name="includeRangers" id="includeRangers">Staff Events</label><br/>--->
                                       
                    <label for="includePersonal"><input type="checkbox" name="includePersonal" id="e1" checked="checked"> My Events</label>
                    
                </fieldset>
                  </li>
                  <li class="prettyButtons">
                    <button type="button" name="addEvent" onClick="AddTicketModal();">Add Maintenance Ticket</button>
                    <br/>
                    <button type="button" name="addEvent" onClick="AddEventModal();">Add My Event</button>
                    <!---<button type="button" name="addEvent" onClick="AddNotificationModal();">Add Push Notification</button><br/>
                          <button type="button" name="addEvent" onClick="AddStaffModal();">Add Staff Event</button>--->

                  </li>
                </ul>
                  
                
            </form>
           
        </div>
      
      <br/>
      <div style="margin:0% 5% 5% 5%; width:90%;">
        <div id='calendar' style="background-color:white;z-index:5; "></div>
      </div>
    </div>
   
    </div>
</body>



