<?php
	if (is_ajax()) {

		//Establish a connection to the database
		include("../../MySQL_Connections/config.php");

		$return = $_POST;

		//determine which graph request the call was sent from
		$graphType = $return['action'];

		if($graphType == 'pie_chart'){

			//Distribution of Tickets (Pie Chart)
			$sql = "SELECT COUNT( intTicketId )  AS countTicketType, strTicketType\n"
			. "FROM maintenancetickets\n"
			. "LEFT JOIN tickettypes ON tickettypes.intTypeId =maintenancetickets.intTypeId WHERE strTicketType IS NOT NULL\n"
			. "GROUP BY maintenancetickets.intTypeId\n"
			. " LIMIT 0, 30 ";

		}
		else if($graphType == 'line_graph'){

			//Distribution of Ticket Types (Line Graph)
			$sql = "SELECT count(intTicketId) AS countTicketType, Month(dtSubmitted) as ticketMonth, strTicketType\n"
			. "FROM `maintenancetickets`\n"
			. "left join tickettypes on tickettypes.inttypeid = maintenancetickets.inttypeid\n"
			. "WHERE YEAR(dtSubmitted) = YEAR(CURDATE())\n"
			. "GROUP BY MONTH(dtSubmitted),maintenancetickets.inttypeid\n"
			. "LIMIT 0, 30\n"
			. "\n"
			. "";

		}
		else if($graphType == 'get_ticket_types'){

			//Obtain the Types of Tickets (used for line graph)
			$sql = "SELECT strTicketType\n"
			. "FROM `tickettypes`\n"
			. "LIMIT 0, 30\n"
			. "\n"
			. "";

		}
		else if($graphType == 'bar_chart'){

			//Open vs. Closed Tickets (Bar Graph)
			$sql = "SELECT Month(dtSubmitted) as dtMonth,\n"
			. "	(\n"
			. " select count(intTicketId) \n"
			. " from maintenancetickets \n"
			. " where dtClosed IS NULL and Month(dtSubmitted) Like dtMonth \n"
			. " ) as countOpenTickets, \n"
			. "	\n"
			. "	(\n"
			. " select count(intTicketId) \n"
			. " from maintenancetickets \n"
			. " where dtClosed IS NOT NULL and Month(dtSubmitted) Like dtMonth \n"
			. " ) as countClosedTickets\n"
			. "\n"
			. "	\n"
			. "FROM maintenancetickets mt\n"
			. "group by Month(dtSubmitted) LIMIT 0, 30 ";

		}
		else if($graphType == 'ticket_list'){
			$user = $_COOKIE['user']; 
			// Distribution of Tickets (Ticket List) using the user logged in
			$sql = "SELECT intTicketId, strTicketType, dtSubmitted\n"
			. "FROM `maintenancetickets`\n"
			. "LEFT JOIN tickettypes on tickettypes.inttypeid = maintenancetickets.inttypeid\n"
			. "WHERE strEmployeeAssigned = '". $user . "' and dtClosed is NULL";
		}

		$payLoad = json_encode(array($sql));
		$result = $conn->query($sql) or die($payLoad);

		$jsonReturnMessage = array();

		//parse the query results into returnable fields    
		while($row = $result->fetch_array(MYSQLI_ASSOC)){

			if($graphType == 'pie_chart'){

				//ticket type & count
				$slice = array('ticketType' => $row['strTicketType'] . "," . $row['countTicketType']);
				array_push($jsonReturnMessage, $slice);
				
			}
			else if($graphType == 'line_graph'){

				//ticket type, count, and month submitted
				$entry = array('ticketType' => $row['strTicketType'] . "," . $row['countTicketType'] . "," . $row['ticketMonth']);
				array_push($jsonReturnMessage, $entry);
				
			}
			else if($graphType == 'get_ticket_types'){

				//ticket type
				$entry = array('ticketType' => $row['strTicketType'] );
				array_push($jsonReturnMessage, $entry);

			} 
			else if($graphType == 'bar_chart'){

				//month, count of Open Tickets, count of Closed Tickets
				$entry = array('ticketType' => $row['dtMonth'] . "," . $row['countOpenTickets'] . "," . $row['countClosedTickets']);
				array_push($jsonReturnMessage, $entry);


			}
			else if($graphType == 'ticket_list'){

				//ticket id, ticket type, submitted date
				$entry = array('ticketType' => $row['intTicketId'] . "," . $row['strTicketType'] . "," . $row['dtSubmitted']);
				array_push($jsonReturnMessage, $entry);

			}
		}

		$return["json"] = json_encode($jsonReturnMessage);
		echo json_encode($return);

	}    

	//Function to check if the request is an AJAX request
	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}


?>

