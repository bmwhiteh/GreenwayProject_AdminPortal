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


          var name = "colorArray=";
          var colors = "";
          var decodedCookie = decodeURIComponent(document.cookie);
          var ca = decodedCookie.split(';');
          for(var i = 0; i <ca.length; i++) {
              var c = ca[i];
              while (c.charAt(0) == ' ') {
                  c = c.substring(1);
              }
              if (c.indexOf(name) == 0) {
                  colors =  c.substring(name.length, c.length);
              }
          }
          
                    var colorArray = colors.split(",");


			//set specific properties for the data in the chart
			var dataPreferences = {
				labels: pieTypeList,
				datasets: [{
					label: 'Ticket Distribution', 
					data: piePercentageList,
					backgroundColor: colorArray,
					borderColor: colorArray,
					borderWidth: 1
				}]
				
				
			};
          console.log(dataPreferences);

			
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