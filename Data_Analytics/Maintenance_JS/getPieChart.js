function getPieChart(){

	//initialize the data variable
	var dataPie = {
		"action": "pie_chart"
	};
	
	//serialize the data as a JSON pack and include the other parameters of the form
	dataPie = $(this).serialize() + "&" + $.param(dataPie);
	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "./Maintenance_JS/get_graph_data.php", 
		data: dataPie,
		success: function(dataPie) {

			//get the JSON
			var ticketsArray = JSON.parse(dataPie["json"]);
			
			var pieCountList = [];
			var pieTypeList = [];
			var i = 0;
			var total = 0;
			
			//go through the array to get the name & counts
			for(i = 0; i < ticketsArray.length; i++){

				var ticketSlice = ticketsArray[i]["ticketType"];
				var ticket = ticketSlice.split(",");
				var typeName = ticket[0];
				var typeCount = parseFloat(ticket[1]);

				//add the count to a total in order to show percentages on the chart
				total += typeCount;

				//add the count & name to the end of the array
				pieCountList.push(typeCount);
				pieTypeList.push(typeName);

				
			}

			var piePercentageList = [];
			var pieLabelList = [];

			//For each count in the pieCountList, we need to determine the percentage
			for(var j= 0; j<pieCountList.length; j++){
				
				//get a ticket count
				var count = pieCountList[j];
				
				//add the percentages into an array
				var value = ((count / total)*100).toFixed(1);
				
				//store the calculated percentage
				piePercentageList.push(value) ;
				pieLabelList.push(String(Math.round(value)) + "%");

			}


			//set specific properties for the data in the chart
			var dataPreferences = {
				labels: pieTypeList,
				datasets: [{
					label: 'Ticket Distribution', 
					data: piePercentageList,
					backgroundColor: [
						'rgba(64, 186, 64, 1)',
						'rgba(59, 171, 59, 1)',
						'rgba(54, 156, 54, 1)',
						'rgba(49, 142, 49, 1)',
						'rgba(44, 127, 44, 1)',
						'rgba(39, 113, 39, 1)',
						'rgba(34, 98,  34, 1)',
						'rgba(29, 83, 29, 1)',
						'rgba(24, 69, 24, 1)'
					],
					borderColor: [
						'rgba(232, 232, 232, 1)',
						'rgba(232, 232, 232, 1)',
						'rgba(232, 232, 232, 1)',
						'rgba(232, 232, 232, 1)',
						'rgba(232, 232, 232, 1)',
						'rgba(232, 232, 232, 1)',
						'rgba(232, 232, 232, 1)',
						'rgba(232, 232, 232, 1)',
						'rgba(232, 232, 232, 1)',
					],
					borderWidth: 1
				}]
				
				
			};

			
			//Create the Pie Chart
			var pie_ctx = document.getElementById("myPieChart");
			var myPieChart = new Chart(pie_ctx,{
				type: 'pie',
				data: dataPreferences
			});
			
			
		}
		,
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			alert("Error: " + errorThrown); 
		}

		
	}); 

	
}