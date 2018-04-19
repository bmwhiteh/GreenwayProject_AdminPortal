<?php
	include("../MySQL_Connections/config.php");

	/*To avoid a CORS issue with Ionic include this check*/
	if(isset($_SERVER['HTTP_ORIGIN'])){
		header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		header("Access-Control-Allow-Credentials: true");
		header("Access-Control-Max-Age: 86400"); //what's this do?
	}

	/*This appears to be something included in the JSON*/
	if($_SERVER['REQUEST_METHOD']=='OPTIONS'){

		if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
			header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
		}

		if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
			header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		}

		exit(0);
	}

	//get the json data
	$data = file_get_contents("php://input");

	
	if(isset($data)){


		//JSON must be decoded using PHP function
		$dataArray = json_decode($data);
		
		//From is used to determine whether it is a google or facebook login
		$from = $dataArray->from;
		
		//We need to verify the auth token we've received
		if($from == "google"){

			//Check that we have an idToken
			if (isset($dataArray->idToken) && $dataArray->idToken !=""){

					//Get the Google Id Token that is used to verify a Google Authentication
					$id_token = $dataArray->idToken;

					//Check/Decode the id token to get the email address out of it (if valid)
					$url =  "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=".$id_token;
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
					'Authorization: Basic YjQyMzY3NDQtOWE4NS00MDc1LWE1ZTMtZGExMjRkN2FhOThi'));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, FALSE);
					curl_setopt($ch, CURLOPT_POST, TRUE);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
					$response = curl_exec($ch);
					curl_close($ch);

					$return["allresponses"] = $response;

					$test = json_decode($return["allresponses"], true);

					$strEmailAddress =  $test["email"];



			}else{
				echo -5; //idToken not set
			}
		}else if($from == "facebook"){
			//handle Facebook Authentication
		}else{
			echo -4; //from not set
		}

		//Now that we have verified the id token we can grab the user profile
		if(isset($strEmailAddress)){

			//Check for the email address
			$sqlCheckEmail = "SELECT intUserId FROM users WHERE strEmailAddress = '$strEmailAddress'";
			$resultCheckEmail = $conn->query($sqlCheckEmail);

			//If the email address is not in the database yet, we can sign them up!
			if($resultCheckEmail == TRUE && $resultCheckEmail->num_rows <= 0){

				//Get the First Name, Last Name, and Gender
				$strFirstName = mysqli_real_escape_string($conn, $dataArray->firstName);
				$strLastName = mysqli_real_escape_string($conn, $dataArray->lastName);
				$strGender = mysqli_real_escape_string($conn, $dataArray->userGender);

				$strUsername = substr($strFirstName,0,1) . $strLastName;

				//Set the Start Date to UTC using current Server time
				$dateStart = new DateTime('now'); 
				$dateStart->setTimeZone(new DateTimeZone('UTC'));
				$dtStartDate =$dateStart->format('Y-m-d');

				//allow user to send pictures until it is revoked
				$bitSendPictures = 1;
				$bitActive = 0;
				
				

				//Calculate the age based on the birthdate
				$dtBirthDate = mysqli_real_escape_string($conn, $dataArray->userBirthdate);
				$intAge =  date("Y-m-d") - $dtBirthDate;

				//Height - mobile sends it as a string to the connection
				$strHeight = mysqli_real_escape_string($conn, $dataArray->userHeight); //comes in as "5 feet 11 inches"
				$strHeightArray = explode(" ",$strHeight);
				$intFeet = $strHeightArray[0];
				$intInches = $strHeightArray[2];
				$intHeight =  ($intFeet * 12) + $intInches;

				//Weight - mobile sends it as a string to the connection
				$strWeight = mysqli_real_escape_string($conn, $dataArray->userWeight); //comes in as 111lbs
				$strWeightArray = explode(" ",$strWeight);
				$intWeight = $strWeightArray[0];

				//Get the current GPS coordinates in order to get the Zipcode
				$strLat = $dataArray->userLat;
				$strLong = $dataArray->userLng;

				//Calculate the zipcode off of the users current lat & long
				$intZipCode = 0;
				if($strLat != "" && $strLong !=""){
					
					// google map geocode api url
					$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$strLat,$strLong&key=AIzaSyBDPrizY3A8DH-BaSuHsSLy6-WObmEvAd4";

					// get the json response
					$resp_json = file_get_contents($url);

					// decode the json
					$resp = json_decode($resp_json, true);

					// response status will be 'OK', if able to geocode given address 
					if($resp['status']=='OK'){
						$arrayLength = count($resp['results'][0]['address_components']);
						$regex = "^\d{5}^";
						
						for($i = 0; $i < $arrayLength; $i++){
							
							$tempZip = $resp['results'][0]['address_components'][$i]['long_name'];
							
							if (preg_match($regex, $tempZip)) {
								$intZipCode = $tempZip;
							}
							
							// echo "iteration $i Zip Code: $intZipCode";
						}
						//echo $intZipCode;
					}
				}


				//we don't need to decode the image if the script fails prior to now
				$httpLink = $dataArray->userAvatar;
				

				//Add the User to the database once all information has been collected
				$sqlAddUser = "INSERT INTO `users` (
					`strFirstName`,                     `strLastName`, 
					`strUsername`,                      `strEmailAddress`,
					`strEncryptedPassword`,             `dtBirthdate`,
					`intHeight`,                        `intWeight`,
					`strGender`,                        `strLat`,
					`strLong`,                          `dtStartDate`,
					`intAge`,                           `bitSendPictures`,
					`intZipCode`,						`active`,   
					`userAvatarFilePath`
				)
				VALUES ( 
					'".$strFirstName."' ,               '".$strLastName."',
					'".$strUsername."',                 '".$strEmailAddress."',
					'".$hashedPassword."' ,             '".$dtBirthDate."',
					'".$intHeight."',                   '".$intWeight."', 
					'".$strGender."',                   '".$strLat."', 
					'".$strLong."',                     '".$dtStartDate."',
					'".$intAge."',                      '".$bitSendPictures."',
					'".$intZipCode."',					'".$bitActive."', 
					'".$httpLink."'
				)";


				$resultAddUser = $conn->query($sqlAddUser);

				//Check for the email address to get the user id
				$sqlCheckEmail = "SELECT intUserId FROM users WHERE strEmailAddress = '$strEmailAddress'";
				$resultGetResponse = $conn->query($sqlCheckEmail);


				if ($resultGetResponse->num_rows > 0) {
					// output data of each row
					while($row = $resultGetResponse->fetch_assoc()) {
						echo $row["intUserId"];
					}

				} else {
					echo -4;//"Could Not Create Account.";
				}
			}else{
				echo -3; //Could not run query OR found an existing Account
			}       
		}else{
			echo -2; //idToken could not be verified
		}

	}else{
		echo -1; //data json not set
	}
?>
