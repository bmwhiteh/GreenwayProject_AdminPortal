<?PHP
function sendNewFeedback($location, $feedback){

        $fields = array(
            'app_id' => "7df26352-e23a-40db-9ce3-31c5e383bcf8",
            'include_email_tokens' => ["andreamoorman26@gmail.com", "viridiantrails@gmail.com"],
            'email_subject' => "New app feedback has been submitted!",
            'email_body' => "<html><body><h1>New app feedback has been submitted!<h1><hr/><p>Location: <strong> $location</strong></p><p>Feedback: <strong> $feedback</strong></p><p><small><a href='[unsubscribe_url]'>Unsubscribe</a></small></p></body></html>"
        );

    $fields = json_encode($fields);
    //print("\nJSON sent:\n");
    //print($fields);

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
    $return["allresponses"] = $response;

    $test = json_decode($return["allresponses"], true);
    
    curl_close($ch);

    return $response;
}
?>