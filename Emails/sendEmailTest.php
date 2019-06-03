<?PHP
//function sendMessage(){

    $fields = array(
        'app_id' => "7df26352-e23a-40db-9ce3-31c5e383bcf8",
        'include_email_tokens' => ["andreamoorman26@gmail.com","cghier@gmail.com"],
        'email_subject' => "Welcome to Cat Facts!",
        'email_body' => "<html><body><h1>Welcome to Viridian!<h1><h4>The official application of the City of Fort Wayne Trail Systems!</h4><hr/><p>Hi $firstName,</p><p>Your Viridian Admin Portal login information is below.</p><p>Username:<h5> $username</h5></p><p>Password:<h5> $password</h5></p><p><small><a href='[unsubscribe_url]'>Unsubscribe</a></small></p></body></html>"
        
    );

    $fields = json_encode($fields);
print("\nJSON sent:\n");
print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic NTcxMjE0NTgtYTE0Yy00YmFlLWEyNzktZjFhMDA1NGViODc4'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    echo $response;
    curl_close($ch);

//    return $response;
//}
/*
$response = sendMessage();
$return["allresponses"] = $response;

$test = json_decode($return["allresponses"], true);
echo "Recipients: " . $test['recipients'] . PHP_EOL;*/
?>