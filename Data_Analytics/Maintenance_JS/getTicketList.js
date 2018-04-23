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


	$.ajax({
		type: "POST",
		//input data type is a json message
		dataType: "json",
		url: "./Maintenance_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
		data: dataTicket,
		//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
		success: function(data) {
			
			//get the JSON
			var ticketsArray = JSON.parse(data["json"]);
			
			//Loop through each result from the json
			for(var i = 0; i < ticketsArray.length; i++){

				var ticketSlice = ticketsArray[i]["ticketType"];
				var ticket = ticketSlice.split(",");
			
				// get the results for the id, type, and date associated with each ticket
				var id  = parseFloat(ticket[0]);
				var type = ticket[1];
				var date = ticket[2];
				
				//Store the Ticket Id, Type, and Submit Date in Arrays
				ticketIdList[i] = id;
				ticketTypeList[i] = type;
				dtSubmittedList[i] = date;
				
			}	
			
			
			//Get the Element Id for the tbody that will contain the list
			var list = document.getElementById('employeeTicketList');                
			
			//for each ticket, create a table row
			for (var z=0; z<ticketIdList.length; z++){
				
				
				//Create a new table row
				var newRowItem = document.createElement('tr');  
				
				//Create a new table cell
				var newCellTicketId = document.createElement('td');
				
				//Create a new link element
				var newLinkTicketId = document.createElement('a');
				
				//Set the link element to the view ticket page of the ticket system
				newLinkTicketId.setAttribute('href', "../Ticket_System_v2/ticket_table_header.php?ticketid="+ticketIdList[z])
				
				//Create a new text Node to hold the ticket id
				var newTextTicketId = document.createTextNode('View Ticket '+ticketIdList[z]);
				
				//Append children so <td><a>Ticket ID</a></td>
				newLinkTicketId.appendChild(newTextTicketId);
				newCellTicketId.appendChild(newLinkTicketId);

				
				//Create a new table cell
				var newCellTicketType = document.createElement('td');
				
				//Create a new text Node to hold the ticket type
				var newTextTicketType = document.createTextNode(ticketTypeList[z]);
				
				//Append so <td>Ticket Type</td>
				newCellTicketType.appendChild(newTextTicketType);
				
				//Create a new table cell
				var newCellTicketDate = document.createElement('td');
				
				//Create a new text Node to hold the ticket date
				var newTextTicketDate = document.createTextNode(dtSubmittedList[z]);
				
				//Append so <td>Ticket Date</td>
				newCellTicketDate.appendChild(newTextTicketDate);
				
				//Append <tr><td><a>Ticket ID</a></td><td>Ticket Type</td><td>Ticket Date</td></tr>
				newRowItem.appendChild(newCellTicketId);
				newRowItem.appendChild(newCellTicketType);
				newRowItem.appendChild(newCellTicketDate);
				
				//Append to the body of the table to create a new row
				list.appendChild(newRowItem);
				
			}	
			
			
		}
		,
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Error: " + errorThrown); 
		} 

		
	}); 
	
	
   
}
    
