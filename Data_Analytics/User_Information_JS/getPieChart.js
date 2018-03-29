function getPieChart(){

	/*
	* Create a Pie Chart for Total Tickets
	*/

	//initialize the data variable
	var dataPie = {
		"action": "pie_chart"
	};
	
	//serialize the data as a JSON pack and include the other parameters of the form
	dataPie = $(this).serialize() + "&" + $.param(dataPie);
	
	//perform the ajax action to go run the php with the sql query in it
	$.ajax({
		type: "POST",
		//input data type is a json message
		dataType: "json",
		url: "./User_Information_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
		data: dataPie,
		//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
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
				
				var typeCount = parseFloat(ticket[0]);
				var typeName = ticket[1];

				total += typeCount;

				pieCountList.push(typeCount);
				pieTypeList.push(typeName);

			}

			var piePercentageList = [];
			var pieLabelList = [];

			for(var j= 0; j<pieCountList.length; j++){
				var count = pieCountList[j];
				//add the percentages into an array
				var value = ((count / total)*100).toFixed(1);
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