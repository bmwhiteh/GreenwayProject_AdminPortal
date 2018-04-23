<?PHP
function sendNewProblem($title, $type, $description, $urgent){

    if($urgent == 0){
        $fields = array(
            'app_id' => "eecf381c-62fd-4ac7-ac38-4496d79c71fb",
            'include_email_tokens' => ["andreamoorman26@gmail.com"],
            'email_subject' => "A new trail problem has been submitted!",
            'email_body' => "<html><body><h1>A new problem has been submitted for review!<h1><hr/><p>Title: <strong> $title</strong></p><p>Type: <strong> $type</strong></p><p>Description: <strong> $description</strong></p><p><small><a href='[unsubscribe_url]'>Unsubscribe</a></small></p></body></html>"
        );
    }else if($urgent == 1){
        $fields = array(
            'app_id' => "eecf381c-62fd-4ac7-ac38-4496d79c71fb",
            'include_email_tokens' => ["andreamoorman26@gmail.com"],
            'email_subject' => "A new urgent trail problem has been submitted!",
            'email_body' => "<html><body><h1>A new <strong>urgent</strong> problem has been submitted for review!<h1><hr/><p>Title: <strong> $title</strong></p><p>Type: <strong> $type</strong></p><p>Description: <strong> $description</strong></p><p><small><a href='[unsubscribe_url]'>Unsubscribe</a></small></p></body></html>"
        );
    }

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
    $return["allresponses"] = $response;

    $test = json_decode($return["allresponses"], true);
    
    curl_close($ch);

    return $response;
}
?>