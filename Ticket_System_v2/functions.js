        

      //Open the Add Ticket Modal
      function openModal(){
        document.getElementById("myModal").style.display="block";
      }
      
      ///Open the View Ticket Modal
      function openTicket(ticket, gpsLat, gpsLong){
        var ticketid = ticket;
        var gpsLat = gpsLat;
        var gpsLong = gpsLong;
        var getTicket = document.getElementById('myTicket');
                    $(".txtLoading").fadeOut("slow");

        /* 
        *  In order to get the proper ticket information to load into the ticket modal, 
        *  we pass the ticket id into the modal view page (using .load) where the database is queried 
        *  with that ticket id and then the div "myTicket" on this screen is populated 
        *  with the results of the modal_view_ticket.php file contents
        */
        $(getTicket).load('/Ticket_System_v2/modal_view_ticket.php',{'ticketid':ticketid},function(responseTxt, statusTxt, xhr){
        
          if(statusTxt == "success")
            document.getElementById('myTicket').style.display="block";
            getMapForTicket(ticketid,gpsLat,gpsLong);

            //console.log("success");
          if(statusTxt == "error")
            alert("Error: " + xhr.status + ": " + xhr.statusText);
            
        });
        
        

        
      };
      
      
      function AddNotesTicket(ticket){
      
       if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        xmlhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
              $("txtLoading").fadeOut("slow");
                //alert("success");
                //document.getElementById("TicketTable").innerHTML = this.responseText;

            }else if (this.readyState == 4 && this.status != 200) {
                               alert("false");

                //document.getElementById("TicketTable").innerHTML = "There was a problem loading the tickets.";
            }


        }
        
        var ticketid = ticket;
        var employee = document.getElementById("strEmployeeUsername").value;
        var date = document.getElementById("date").value;
        var comment = document.getElementById("strComment").value;

        xmlhttp.open("POST","action_add_note.php?ticketid="+ticketid+"&employee="+employee+"&date="+date+"&comment="+comment,true);
                    $(".txtLoading").fadeOut("slow");

        xmlhttp.send();
        
        closeTicket();
        
      };
      
      function ReopenTicket(ticket){
      
       if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        xmlhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
              $("txtLoading").fadeOut("slow");

                //document.getElementById("TicketTable").innerHTML = this.responseText;

            }else if (this.readyState == 4 && this.status != 200) {
                //document.getElementById("TicketTable").innerHTML = "There was a problem loading the tickets.";
            }
                                                  $("txtLoading").fadeOut("slow");


        }

        xmlhttp.open("GET","action_reopen_ticket.php?ticketid="+ticket,true);
                    $(".txtLoading").fadeOut("slow");

        xmlhttp.send();
        
        
      };
      
      
      
      // When the user clicks on the (x), close the ticket modal
      function closeTicket(id) {
        document.getElementById(id).style.display = "none";


      }
      
      // When the user clicks anywhere outside of the modal, close it
      window.onclick = function(event) {
        
        if (event.target ==   document.getElementById('myTicket')) {
          
          document.getElementById('myTicket').style.display = "none";
        }else if (event.target ==   document.getElementById('myModal')) {
          document.getElementById('myModal').style.display = "none";

        }else if (event.target ==   document.getElementById('myNotificationView')) {
          document.getElementById('myNotificationView').style.display = "none";

        }
      
      }
      
      //This initializes the map for the 'Add Ticket' Map
      function initialize() {
        //Initialize the center of the map to IPFW's campus & zoomed in to view the road map layout
        var mapOptions = {
          center: new google.maps.LatLng(41.115618, -85.111250),
          zoom: 12,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
        //Initialize the map to loading to its div element with the map options from above
        var map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
        
        //Initialize the map marker
        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(41.115618, -85.111250),
          draggable: true,
          icon: '../images/markerLogo.png',
          animation: google.maps.Animation.DROP,
          title: "Problem Location",
        });
        
        //Set the Map with it's Viridian Marker
        marker.setMap(map);
      
        //Allow the gps marker to be moved and save the new coords to gpsLat & gpsLong
        google.maps.event.addListener(marker, 'dragend', function (event) {
          document.getElementById("gpsLat").value = this.getPosition().lat();
          document.getElementById("gpsLong").value = this.getPosition().lng();
        });
      //Resize the map to fit in its box
      $('#myModal').on('shown.bs.modal', function() {
        
        //Get the center of the map before resizing it
        var currentCenter = map.getCenter(); 
        
        google.maps.event.trigger(map, "resize");
         
        // Re-set previous center
        map.setCenter(currentCenter);
      
        
      });
      }
      
      
      
    
      
      //This initializes the map for the 'Add Ticket' Map
      function getMapForTicket(id,gpsLat,gpsLong) {

        
        //Initialize the center of the map to IPFW's campus & zoomed in to view the road map layout
        //console.log("ticket: "+id+" lat: "+gpsLat+" lng:"+gpsLong);
        var gpsLat = gpsLat;
        var gpsLong = gpsLong;
        var ticketid = id;
                            console.log("ticket "+ticketid+","+ gpsLat+","+ gpsLong);

        var mapOptions = {
          center: new google.maps.LatLng(gpsLat, gpsLong),
          zoom: 12,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        //Initialize the map to loading to its div element with the map options from above
        var map_view = new google.maps.Map(document.getElementById("mapBucket"), mapOptions);

        //Initialize the map marker
        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(gpsLat, gpsLong),
          icon: '../images/markerLogo.png',
          animation: google.maps.Animation.DROP,
          title: "Ticket "+ticketid,
          map: map_view
        });
        
      //Resize the map to fit in its box
            $('#myTicketView').on('shown.bs.modal', function() {
              //console.log("end");
      
              //Get the center of the map before resizing it
              var currentCenter = map_view.getCenter(); 
              
              google.maps.event.trigger(map_view, "resize");
               
              // Re-set previous center
              map_view.setCenter(currentCenter);
              //console.log("Here!");
              
            });
            
      }
      
      
      
      function FilterResults(page, assigned){
  
         var status = document.getElementById("statOpenClosed").value;
          var tableView = document.getElementById("tableView").checked;
          var ticketView = "cards";
          var today = new Date();
          var assignedEmployee = assigned;

          var userOnly = document.getElementById("ShowUserTickets").checked;
          if(userOnly == true){
            assignedEmployee = assigned;

          }else{
            assignedEmployee = 'all';

          }
          
          
          
          var cookie_expire = new Date();
          cookie_expire.setDate(today.getDate()+1);
          //console.log(page);
          
          document.cookie = "page_number = "+ page+"; expires "+cookie_expire+"; path=/"; // 86400 = 1 day

          document.cookie = "ticket_status = " + status+"; expires "+cookie_expire+"; path=/"; // 86400 = 1 day
          
          
          if(tableView){
            ticketView = "table";
            document.cookie = "page_view = "+ ticketView+"; expires "+cookie_expire+"; path=/"; // 86400 = 1 day

            document.getElementById("viewTable").style = 'border: 2px solid white;border-radius: 5px;vertical-align:middle; width:30px; height:30px;padding:5px;';
            document.getElementById("viewCards").style = 'background-color:white; border: none;border-radius: 0px;vertical-align:middle; width:30px; height:30px;padding:5px;';
            document.getElementById("viewTable").className= "ticketLayout";


          }else{
            document.cookie = "page_view = "+ ticketView+"; expires "+cookie_expire+"; path=/"; // 86400 = 1 day

              document.getElementById("viewCards").style = 'border: 2px solid white;border-radius: 5px;vertical-align:middle; width:30px; height:30px;padding:5px;';
              document.getElementById("viewCards").className= "ticketLayout";

              document.getElementById("viewTable").style = 'background-color:white; border: none;border-radius: 0px;vertical-align:middle; width:30px; height:30px;padding:5px';
              
          }
          
          var page_view = "card";
          var name = "page_view=";
          
          var page_number = "1";
          var name2 = "page_number=";
          
          var ticket_status = "open";
          var name3 = "ticket_status";
          
          var decodedCookie = decodeURIComponent(document.cookie);
          var ca = decodedCookie.split(';');
          for(var i = 0; i <ca.length; i++) {
              var c = ca[i];
              while (c.charAt(0) == ' ') {
                  c = c.substring(1);
              }
              if (c.indexOf(name) == 0) {
                  page_view =  c.substring(name.length, c.length);
              }else if(c.indexOf(name2)==0){
                  page =  c.substring(name2.length, c.length);

              }
              else if(c.indexOf(name3)==0){
                  ticket_status =  c.substring(name3.length, c.length);

              }
          }

          
          
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
           var xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
          var  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        xmlhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                                                    $("txtLoading").fadeOut("slow");

                document.getElementById("TicketTable").innerHTML = this.responseText;

            }else if (this.readyState == 4 && this.status != 200) {
                document.getElementById("TicketTable").innerHTML = "There was a problem loading the tickets.";
            }
                                                  $("txtLoading").fadeOut("slow");


        }

        xmlhttp.open("GET","get_ticket_"+page_view+".php?status="+ticket_status+"&pageno="+page+"&view="+page_view+"&assigned="+assignedEmployee,true);
                    $(".txtLoading").fadeOut("slow");

        xmlhttp.send();
      }
      
      //source: W3Schools
      function sortTable(n) {
          var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
          table = document.getElementById("ticketTable");
          switching = true;
          //Set the sorting direction to ascending:
          dir = "asc"; 
          /*Make a loop that will continue until
          no switching has been done:*/
          while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("tr");
            /*Loop through all table rows (except the
            first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
              //start by saying there should be no switching:
              shouldSwitch = false;
              /*Get the two elements you want to compare,
              one from current row and one from the next:*/
              x = rows[i].getElementsByTagName("td")[n];
              y = rows[i + 1].getElementsByTagName("td")[n];
              /*check if the two rows should switch place,
              based on the direction, asc or desc:*/
              if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                  //if so, mark as a switch and break the loop:
                  shouldSwitch= true;
                  break;
                }
              } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                  //if so, mark as a switch and break the loop:
                  shouldSwitch= true;
                  break;
                }
              }
            }
            if (shouldSwitch) {
              /*If a switch has been marked, make the switch
              and mark that a switch has been done:*/
              rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
              switching = true;
              //Each time a switch is done, increase this count by 1:
              switchcount ++;      
            } else {
              /*If no switching has been done AND the direction is "asc",
              set the direction to "desc" and run the while loop again.*/
              if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                
                switching = true;
              }
            }
        }
    }
    
    

    
    function ShowImagePopup(id){
        var popup = document.getElementById("ticketPopup_"+id);
        popup.classList.toggle("show");
       // popup.style.visibility = "visible";
    }
    
    function HideImagePopup(id) {
        var popup = document.getElementById("ticketPopup_"+id);
        popup.classList.toggle("hide");
        console.log("In hide");

    }
    
    function ReassignTicket(id){
        var new_employee = document.getElementById("assignedEmployee").value;
        var tickets = [id];
        var params = "assign="+tickets+"&assignedEmployee="+new_employee;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {

            if (this.readyState == 4 && this.status == 200) {
                $("txtLoading").fadeOut("slow");
            }else if (this.readyState == 4 && this.status != 200) {
               alert("Did not work");
            }
            $("txtLoading").fadeOut("slow");
        }
        
        xmlhttp.open("POST","action_assign_ticket.php",true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                    $(".txtLoading").fadeOut("slow");

        xmlhttp.send(params);
        
    }
    