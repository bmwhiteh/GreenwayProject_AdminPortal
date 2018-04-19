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
        <script src='calendar_functions.js'></script>
        <script type="text/javascript" src="jQuery_PlugIn_MultiSelect/src/jquery.multi-select.js"></script>
                    
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
                $('#maintenance').multiSelect({
                  containerHTML: '<div class="multi-select-container">',
                  menuHTML: '<div class="multi-select-menu">',
                  buttonHTML: '<span class="multi-select-button">',
                  menuItemHTML: '<label class="multi-select-menuitem">',
                  activeClass: 'multi-select-container--open',
                  placeholderText: '-- Select --'
                });
                /*
                $('#notifications').multiSelect({
                  containerHTML: '<div class="multi-select-container">',
                  menuHTML: '<div class="multi-select-menu">',
                  buttonHTML: '<span class="multi-select-button">',
                  menuItemHTML: '<label class="multi-select-menuitem">',
                  activeClass: 'multi-select-container--open',
                  placeholderText: '-- Select --'
                });*/
            });
            
            
                    
        </script>
        <style>
            
            
          

        
          #calendar {
            max-width: 900px;
          }
          
          fieldset { 
            display: inline;
            margin-left: 2px;
            margin-right: 2px;
            padding-top: 0.35em;
            padding-bottom: 0.625em;
            padding-left: 0.75em;
            padding-right: 0.75em;
            vertical-align:top;
          }
          /*
.multi-select-container {
  display: inline-block;
  position: relative;
}

.multi-select-menu {
  position: absolute;
  left: 0;
  top: 0.8em;
  float: left;
  min-width: 100%;
  background: #fff;
  margin: 1em 0;
  padding: 0.4em 0;
  border: 1px solid #aaa;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
  display: none;
}

.multi-select-menu input {
  margin-right: 0.3em;
  vertical-align: 0.1em;
}

.multi-select-button {
  display: inline-block;
  font-size: 0.875em;
  padding: 0.2em 0.6em;
  max-width: 20em;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  vertical-align: -0.5em;
  background-color: #fff;
  border: 1px solid #aaa;
  border-radius: 4px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
  cursor: default;
}

.multi-select-button:after {
  content: "";
  display: inline-block;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 0.4em 0.4em 0 0.4em;
  border-color: #999 transparent transparent transparent;
  margin-left: 0.4em;
  vertical-align: 0.1em;
}

.multi-select-container--open .multi-select-menu { display: block; }

.multi-select-container--open .multi-select-button:after {
  border-width: 0 0.4em 0.4em 0.4em;
  border-color: transparent transparent #999 transparent;
}*/
        </style>
    </head>

</html>



<!-- style="background-color: #1B371A;"-->
<body class="genericBody">

  
    <!---View Ticket Modal Window--->
    <div id="myTicket" class="modal" style="display:none;">I'm Here</div>



    <div class="contentBox" style="display:block;">
      <br/><br/>
      <div style="border:2px solid grey; background-color:white; border-radius: 10px;  margin:auto; margin-left:5%; vertical-align:top; text-align:center; padding:20px;">
        <div style="font-size:24px;font-weight:bold; text-decoration:underline;margin-bottom:5px;">Calendar Options</div>
            <form method="post" name="ShowEvents">
                <span  style="width:40%;">
                  <fieldset>
                    
                    <legend>Select Ticket Types</legend>
                    <input type="checkbox" name="highwater" value="High Water">High Water
                    <input type="checkbox" name="pothole" value="Pothole">Pothole
                    <input type="checkbox" name="treebranch" value="Tree/Branch">Tree/Branch
                    <input type="checkbox" name="trashfull" value="Trash Full">Trash Full
                    <input type="checkbox" name="overgrownbrush" value="Overgrown Brush">Overgrown Brush<br/>
                    <input type="checkbox" name="vandalism" value="Vandalism">Vandalism
                    <input type="checkbox" name="suspiciouspersons" value="Suspicious Persons">Suspicious Persons
                    <input type="checkbox" name="other" value="Other">Other
                  </fieldset>
                </span>
                <span style="width:40%;">
                  <fieldset>
                  <legend>Select Notifications</legend>

                  <input type="checkbox" name="events" value="Events">Local Events
                  <input type="checkbox" name="closures" value="Closures">Trail Closures<br/>
                  <input type="checkbox" name="alerts" value="Alerts">Weather Alerts
                </fieldset>
                </span>
                <span style="width:40%;">
                  <fieldset>
                  <legend>Select Optional</legend>

                  <label for="includeRangers"> <input type="checkbox" name="includeRangers" id="includeRangers">Staff Events</label><br/>
                                       
                    <label for="includePersonal"><input type="checkbox" name="includePersonal" id="includePersonal"> My Events</label>
                    
                </fieldset>
                </span>
            </form>
     <!--          
                    <span style="font-size:16px;z-index:50;">Maintenance Tickets
                    
                
                        <select id="maintenance" name="maintenance" multiple>
                            <option value="High Water">High Water</option>
                            <option value="Pothole">Pothole</option>
                            <option value="Tree/Branch">Tree/Branch</option>
                            <option value="Trash Full">Trash Full</option>
                            <option value="Overgrown Brush">Overgrown Brush</option>
                            <option value="Vandalism">Vandalism</option>
                            <option value="Suspicious Persons">Suspicious Persons</option>
                            <option value="Other">Other</option>

                        </select></span>
                   <br/>
                       
                      
                     <span style="font-weight:bold; font-size:20px;">Push Notifications</span>
                        <select id="notifications" name="notifications" multiple>
                            <option value="Events">Local Events</option>
                            <option value="Closures">Trail Closures</option>
                            <option value="Alerts">Weather Alerts</option>
                        </select>
-->
                     
                   </td>
                   <td>
                      <div>
                           
                    </div>
                   </td>
                   <td>
                      <button type="submit" name="addEvent" onClick="AddEventModal();">Add Event</button>
                   </td>
                 </tr>
                 
                 
               </table>    
                    
                
                    
                
                  
                

            </form>
            
        </div>
      <br/>
      <div style="margin:5%; width:90%;">
        <div id='calendar' style="background-color:white;z-index:5; "></div>
      </div>
    </div>
    
    
</body>



