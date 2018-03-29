function getRadarGraph(){
    	
    	//initialize the data variable
		var data = {
			"action": "radar"
		};
		
		var activityRun = [0,0,0,0,0,0,0,0,0,0,0,0];
		var activityWalk =   [0,0,0,0,0,0,0,0,0,0,0,0];
		var activityBike =   [0,0,0,0,0,0,0,0,0,0,0,0];

		
		//serialize the data as a JSON pack and include the other parameters of the form
		data = $(this).serialize() + "&" + $.param(data);
		
		//perform the ajax action to go run the php with the sql query in it
		$.ajax({
			type: "POST",
			//input data type is a json message
			dataType: "json",
			url: "./Tracked_Activities_JS/get_graph_data.php", //Relative or absolute path to filterUserActivity.php file
			data: data,
			//if the ajax successfully returns, this is what should be displayed and be what needs to change for your points
			success: function(data) {

				//get the JSON
				var activityArray = JSON.parse(data["json"]);
				
				//locate all results of the ticket type
				for(var i = 0; i < activityArray.length; i++){

					var activitySlice = activityArray[i]["Activities"];
					var activity = activitySlice.split(",");
				
					var countUsers  = parseFloat(activity[0]);
					var activityType = activity[2];
					var dtMonth = parseFloat(activity[1]);
					
					
					//console.log("month:"+dtMonth + " open:"+countOpen + " close:"+countClosed);
					//place the count of each month in the bucket corresponding to the month
					
					if(activityType == 'RUN'){
						activityRun[dtMonth-1] = countUsers;
					}else if(activityType == 'BIKE'){
						activityBike[dtMonth-1] = countUsers;
					}else{
						activityWalk[dtMonth-1] = countUsers;
					}
				}	
				//console.log(usersFemale);
				//console.log(usersMale);

				
				
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
			
	




				var radar_dataPreferences = {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
	    					label: "Run",
	    					backgroundColor:colorArray[0] ,
							borderColor: colorArray[0],
	    					data: activityRun
						},
						{
							label: "Bike",
							backgroundColor: colorArray[1] ,
							borderColor: colorArray[1],
							data: activityBike
						},
						{
							label: "Walk",
							backgroundColor: colorArray[2] ,
							borderColor: colorArray[2],
							data: activityWalk
						}
	    				]
				};
	
	
				//console.log(openTicketsPerMonth);

                var radar_optionPreferences = {
                 
				    scale: {
				        // Hides the scale
				        display: true
				    }

					
            	};
                


				var ctx = document.getElementById("myRadarGraph");
				var myRadarGraph = new Chart(ctx, {
				    type: 'radar',
				    data: radar_dataPreferences,
				    options: radar_optionPreferences
				});
			}
			,
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
				alert("Error: " + errorThrown); 
			}  
		}); 
    	
    	
       
    }
    
