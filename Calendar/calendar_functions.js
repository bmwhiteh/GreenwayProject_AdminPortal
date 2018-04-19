///Open the View Ticket Modal

function ModalNotification(id){
    console.log("attempt to open");
    var notification_id = id;
  
    var getTicket = document.getElementById('myTicket');

    $(getTicket).load('modal_view_notification.php',{'notificationid':notification_id},function(responseTxt, statusTxt, xhr){
        
          if(statusTxt == "success")
            document.getElementById('myTicket').style.display="block";
            console.log("success");
          if(statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
            
        });

    

};

// When the user clicks on the (x), close the ticket modal
function closeNotification() {
  document.getElementById('myTicket').style.display = "none";
}

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



function CheckAllDay(){
    var status = document.getElementById('event_allday').checked;
    
    if(!status){
      document.getElementById('showTimes').style.display="";
    }else{
      document.getElementById('showTimes').style.display="none";
    }
};

function addMyEvent(){
  
}