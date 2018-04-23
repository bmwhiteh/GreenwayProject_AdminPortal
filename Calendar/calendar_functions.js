

function ModalNotification(id){
    console.log("attempt to open");
    var notification_id = id;
  
    var getTicket = document.getElementById('myTicket');

    getTicket.className = 'modal';

    $(getTicket).load('modal_view_notification.php',{'notificationid':notification_id},function(responseTxt, statusTxt, xhr){
        
          if(statusTxt == "success")
            document.getElementById('myTicket').style.display="block";
            console.log("success");
          if(statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
            
        });

    

};

function ModalEvent(id){
    var event_id = id;
  
    var getTicket = document.getElementById('myTicket');

    $(getTicket).load('modal_view_event.php',{'event_id':event_id},function(responseTxt, statusTxt, xhr){
        
          if(statusTxt == "success")
            document.getElementById('myTicket').style.display="block";
            console.log("success");
          if(statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
            
        });

    

};



function AddEventModal(){
    console.log("event modal");
    var getTicket = document.getElementById('myTicket');

    $(getTicket).load('modal_add_my_event.php',function(responseTxt, statusTxt, xhr){
        
          if(statusTxt == "success")
            document.getElementById('myTicket').style.display="block";
          if(statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
            
        });

    

};

function AddTicketModal(){
    var getTicket = document.getElementById('myTicket');

    $(getTicket).load('../Ticket_System_v2/modal_add_ticket.php',function(responseTxt, statusTxt, xhr){
        openModal();
        initialize();
          if(statusTxt == "success")
            document.getElementById('myTicket').style.display="block";
          if(statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
            
        });

    

};

function CheckAllDay(){
    var status = document.getElementById('event_allday').checked;
    
    if(!status){
      document.getElementById('showTimes').style.display="";
    }else{
      document.getElementById('showTimes').style.display="none";
    }
};

