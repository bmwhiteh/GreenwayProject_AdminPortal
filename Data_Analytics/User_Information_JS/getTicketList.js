function getTicketList(){
    	
    	//initialize the data variable
		var dataTicket = {
			"action": "ticket_list"
		};
		
		var ticketIdList = [];
		var ticketTypeList = [];
		var dtSubmittedList =[];
		
		
		//serialize the data as a JSON pack and include the other parameters of the form
		dataTicket = $(this).serialize() + "&" + $.param(dataTicket);
		
		
		
		
		//perform the ajax action to go run the php with the sql query in it
		$.ajax({
			type: "POST",
			//input data type is a json message
			dataType: "json",
			url: "./User_Information_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
			data: dataTicket,
			//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
			success: function(data) {
	            //console.log(data);
	            //get the JSON
				var ticketsArray = JSON.parse(data["json"]);
			    //console.log(ticketsArray);
	
				//locate all results of the ticket type
				for(var i = 0; i < ticketsArray.length; i++){

					var ticketSlice = ticketsArray[i]["ticketType"];
					var ticket = ticketSlice.split(",");
				
					var id  = parseFloat(ticket[0]);
					var type = ticket[1];
					var date = ticket[2];
					
					
					//console.log("month:"+dtMonth + " open:"+countOpen + " close:"+countClosed);
					//place the count of each month in the bucket corresponding to the month
					
					
					ticketIdList[i] = id;
					ticketTypeList[i] = type;
					dtSubmittedList[i] = date;
					
				}	
				//console.log(ticketIdList);
				//console.log(ticketTypeList);
				//console.log(dtSubmittedList);

				
				// ADDING ITEMS TO START AND END OF LIST
				var list = document.getElementById('employeeTicketList');                
				
				for (var z=0; z<ticketIdList.length; z++){
					
					
					// ADD NEW ITEM TO END OF LIST
					var newRowItem = document.createElement('tr');  
					
					//Create the ticket id cell
					var newCellTicketId = document.createElement('td');
					var newLinkTicketId = document.createElement('a');
					newLinkTicketId.setAttribute('href', "https://virdian-admin-portal-whitbm06.c9users.io/Ticket_System/ticketInfo.php?ticketid="+ticketIdList[z])
					var newTextTicketId = document.createTextNode('View Ticket '+ticketIdList[z]);
					newLinkTicketId.appendChild(newTextTicketId);
					newCellTicketId.appendChild(newLinkTicketId);

					
					//Create the ticket type cell
					var newCellTicketType = document.createElement('td');
					var newTextTicketType = document.createTextNode(ticketTypeList[z]);
					newCellTicketType.appendChild(newTextTicketType);
					
					//create the ticket submitted date cell
					var newCellTicketDate = document.createElement('td');
					var newTextTicketDate = document.createTextNode(dtSubmittedList[z]);
					newCellTicketDate.appendChild(newTextTicketDate);
					
					            // Create text node
					newRowItem.appendChild(newCellTicketId);
					newRowItem.appendChild(newCellTicketType);
					newRowItem.appendChild(newCellTicketDate);
					
					list.appendChild(newRowItem);
					
				}	
					

				//console.log(list);

				
	
	
			
                


				
			}
			,
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				alert("Error: " + errorThrown); 
			}  
		}); 
    	
    	
       
    }
    
