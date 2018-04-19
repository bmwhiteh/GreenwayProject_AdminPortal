<?php 
    /*
    *   Author: Bailey Whitehill
    *   Description: This will provide all of the ticket information in a popup rather than 
                    requiring the user to navigate to a different screen
    *
    */

        include("../MySQL_Connections/config.php");
         
    

?>

    <!-- Modal content -->
    <div id="myNotificationView" class="modal-content" style="margin-top:5%;">
        
        
        <span id="closeNotification" class="close" onClick="closeNotification();">&times;</span>
        
        
        <h1 class="modal-title" style="margin-top:0px; vertical-align:middle; text-align: center;" id="MapTicketId">Add A New Personal Event</h1>
         <!---
        All of the Available values that can be sent back in the json
        "id":               String/Integer. Optional Uniquely identifies the given event. Different instances of repeating events should all have the same id.
        "title":            String. Required. The text on an event's element
        "allDay":           true or false. Optional. Whether an event occurs at a specific time-of-day. This property affects whether an event's time is shown. Also, in the agenda views, determines if it is displayed in the "all-day" section. If this value is not explicitly specified, allDayDefault will be used if it is defined. If all else fails, FullCalendar will try to guess. If either the start or end value has a "T" as part of the ISO8601 date string, allDay will become false. Otherwise, it will be true. Don't include quotes around your true/false. This value is a boolean, not a string!
        "start":            The date/time an event begins. Required. A Moment-ish input, like an ISO8601 string. Throughout the API this will become a real Moment object.
        "end":              The exclusive date/time an event ends. Optional. A Moment-ish input, like an ISO8601 string. Throughout the API this will become a real Moment object. It is the moment immediately after the event has ended. For example, if the last full day of an event is Thursday, the exclusive end of the event will be 00:00:00 on Friday!
        "url":              String. Optional. A URL that will be visited when this event is clicked by the user. For more information on controlling this behavior, see the eventClick callback.
        "className":        String/Array. Optional. A CSS class (or array of classes) that will be attached to this event's element.
        "editable":         true or false. Optional. Overrides the master editable option for this single event.
        "startEditable":    true or false. Optional. Overrides the master eventStartEditable option for this single event.
        "durationEditable": true or false. Optional. Overrides the master eventDurationEditable option for this single event.
        "resourceEditable": true or false. Optional. Overrides the master eventResourceEditable option for this single event.
        "rendering":        Allows alternate rendering of the event, like background events. Can be empty, "background", or "inverse-background"
        "overlap":          true or false. Optional. Overrides the master eventOverlap option for this single event. If false, prevents this event from being dragged/resized over other events. Also prevents other events from being dragged/resized over this event.
        "constraint":       an event ID, "businessHours", object. Optional. Overrides the master eventConstraint option for this single event.
        "source":           Event Source Object. Automatically populated. A reference to the event source that this event came from.
        "color":            Sets an event's background and border color just like the calendar-wide eventColor option.
        "backgroundColor":  Sets an event's background color just like the calendar-wide eventBackgroundColor option.
        "borderColor":      Sets an event's border color just like the the calendar-wide eventBorderColor option.
        "textColor":        Sets an event's text color just like the calendar-wide eventTextColor option."
    */--->
            
        <div class="modal-body">
        
           <form class="my_event_form">
               
                    
                    <label for="event_title">Event Title:</label><br/> <input type="text" name="event_title" id="event_title"/><br/><br/>
                    <table>
                        <tr>
                            <td>
                                <label for="event_start">Start Date:</label><br/> <input type="date" name="event_start" id="event_start"/>
                            </td>
                            <td>
                                 <p>until</p>
                            </td>
                            <td>
                                <label for="event_end">End Date:</label><br/> <input type="date" name="event_end" id="event_end"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <label for="event_allday">All Day?</label><input type="checkbox" name="event_allday" id="event_allday" onChange="CheckAllDay();" checked="checked"/>
                            </td>
                        </tr>
                        <tr id="showTimes" style="display:none;">
                            
                            <td>
                                <label for="time_start">Start Time:</label><br/> <input type="time" name="time_start" id="time_start"/>
                            </td>
                            <td>
                                 <p>until</p>
                            </td>
                            <td>
                                <label for="time_end">End Time:</label><br/> <input type="time" name="time_end" id="time_end"/>
                            </td>
                        </tr>
                        
                    </table>
                    <br/>
                    <label for="event_description">Description:</label><br/><textarea name="event_description" id="event_description"></textarea><br/>
                    <table>
                        <tr>
                            <td>
                                <label for="event_color">Pick a Color:
                                    <ul>
                                        <?php
                                            $colors = array("#e6194b", "#3cb44b", "#ffe119", "#0082c8","#f58231","#911eb4","#46f0f0","#f032e6","#d2f53c","#fabebe","#008080","#e6beff","#aa6e28","#fffac8","#800000","#aaffc3","#808000","#ffd8b1","#000080","#808080"); 
                
                                            foreach ($colors as $value) {
                                        ?>
                                        <li>
                                            <label class="container-calendar">
                                              <input type="radio" name="color_choice" value="<?php echo $value;?>">
                                              <span class="checkmark"  style="background-color:<?php echo $value;?>;"></span>
                                            </label>
                                        </li>
                                        <?php    }
                                        ?>
                                    </ul>
                                </label>
                            </td>
                        </tr>
                    </table>
                    

                  <button type="button" name="addMyEvent" onClick="addMyEvent();">Add My Event</button>
        
               
           </form>
            
    
        </div>
    
    </div>