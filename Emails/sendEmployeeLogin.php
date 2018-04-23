<?PHP
function sendLogin($email, $firstName, $username, $password){

    $fields = array(
        'app_id' => "eecf381c-62fd-4ac7-ac38-4496d79c71fb",
        'include_email_tokens' => [$email],
        'email_subject' => "Welcome to Viridian!",
        'email_body' => "<html><body><h1>Welcome to Viridian!<h1><h4>The official application of the City of Fort Wayne Trail Systems!</h4><hr/><p>Hi $firstName,</p><p>Your Viridian Admin Portal login information is below.</p><p>Username: <b> $username</b></p><p>Password: <b> $password</b></p><p><small><a href='[unsubscribe_url]'>Unsubscribe</a></small></p></body></html>"
        
    );

    $fields = json_encode($fields);
print("\nJSON sent:\n");
print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic YjQyMzY3NDQtOWE4NS00MDc1LWE1ZTMtZGExMjRkN2FhOThi'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    echo $response;
    curl_close($ch);

    return $response;
}
?>