function getBarChart(){
    	
	//initialize the data variable
	var data = {
		"action": "bar_chart"
	};
	
	//initialize the arrays to avoid errors
	var openTicketsPerMonth = [0,0,0,0,0,0,0,0,0,0,0,0];
	var closedTicketsPerMonth = [0,0,0,0,0,0,0,0,0,0,0,0];
	
	
	//serialize the data as a JSON pack and include the other parameters of the form
	data = $(this).serialize() + "&" + $.param(data);
	
	//perform the ajax action to go run the php with the sql query in it
	$.ajax({
		type: "POST",
		//input data type is a json message
		dataType: "json",
		url: "./Maintenance_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
		data: data,
		//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
		success: function(data) {

			//get the JSON
			var ticketsArray = JSON.parse(data["json"]);
			
			//locate all results of the ticket type
			for(var i = 0; i < ticketsArray.length; i++){
				
				//get the results from an element in the array
				var ticketSlice = ticketsArray[i]["ticketType"];
				var ticket = ticketSlice.split(",");
			
				//get the individual values from the result
				var dtMonth  = parseFloat(ticket[0]);
				var countOpen = parseFloat(ticket[1]);
				var countClosed = parseFloat(ticket[2]);
				
				//assign the counts to the proper array
				openTicketsPerMonth[dtMonth-1] = countOpen;
				closedTicketsPerMonth[dtMonth-1] = countClosed;
			}
			
			
			//set the properties for the Bars 
			var dataPreferences = {
				labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				datasets: [
					{
						label: "Open Tickets",
						backgroundColor: "rgba(49, 142, 49, 1)",
						data: openTicketsPerMonth
					},
					{
						label: "Closed Tickets",
						backgroundColor: "rgba(29, 83, 29, 1)",
						data: closedTicketsPerMonth
					}
				]
			};


			//set the general settings for the chart
			var optionPreferences = {
			  scales: {
					xAxes: [{
						gridLines: {
							offsetGridLines: true
						}
					}]
				}
				
			};
			

			//Create the chart and store it in the proper canvas element on the page
			var ctx = document.getElementById("myBarChart");
			var myBarChart = new Chart(ctx, {
				type: 'bar',
				data: dataPreferences,
				options: optionPreferences
			});
			
			
		}
		,
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Error: " + errorThrown); 
		}  
		
		
	}); 
	
   
}
    
