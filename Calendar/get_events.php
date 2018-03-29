<?php 
    try{
       include("../MySQL_Connections/config.php");

    $startDate = $_POST["start"];
    //$startDate = '2018-01-01';

    $sqlTickets = "SELECT intTicketId, dtEstFinish\n"
    . "FROM `maintenancetickets`\n"
    . "where dtEstFinish > '".$startDate."' and dtClosed IS NULL\n"
    . "";

    $resultTickets = $conn->query($sqlTickets) or die("Query fail");



    /*
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
    */
    $ticketArray = array();
    
    while($row = $resultTickets->fetch_array(MYSQLI_ASSOC)){ 
        $ticket = array();
        $ticket['id'] = $row['intTicketId'];
        $ticket['title'] = "Ticket #" . $row['intTicketId'];
        $ticket['start'] = $row['dtEstFinish'];
        $ticket['allDay'] = false;
        $ticket['backgroundColor'] = 'green';
        $ticket['textColor'] = 'white';
        
        array_push($ticketArray, $ticket);
    }

    echo json_encode($ticketArray);
    } catch (PDOException $ticket){
        echo $ticket->getMessage();
    }
?>