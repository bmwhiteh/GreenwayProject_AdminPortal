<?PHP
function sendNewAssignmentEmail($email, $ticketCount, $urgentCount){

    if($ticketCount == 1){
        if($urgentCount == 0){
            $fields = array(
            'app_id' => "eecf381c-62fd-4ac7-ac38-4496d79c71fb",
            'include_email_tokens' => [$email],
            'email_subject' => "You've been assigned a new trail problem!",
            'email_body' => "<html><body><h3>You have been assigned $ticketCount new ticket!<h3><hr/><small><a href='[unsubscribe_url]'>Unsubscribe</a></small></p></body></html>"
            );
        }else{
            $fields = array(
            'app_id' => "eecf381c-62fd-4ac7-ac38-4496d79c71fb",
            'include_email_tokens' => [$email],
            'email_subject' => "You've been assigned a new trail problem!",
            'email_body' => "<html><body><h3>You have been assigned $ticketCount new urgent ticket!<h3><hr/><small><a href='[unsubscribe_url]'>Unsubscribe</a></small></p></body></html>"
            );
        }
    }else if($ticketCount > 1){
        if($urgentCount == 0){
            $fields = array(
            'app_id' => "eecf381c-62fd-4ac7-ac38-4496d79c71fb",
            'include_email_tokens' => [$email],
            'email_subject' => "You've been assigned new trail problems!",
            'email_body' => "<html><body><h3>You have been assigned $ticketCount new tickets!<h3><hr/><small><a href='[unsubscribe_url]'>Unsubscribe</a></small></p></body></html>"
            );
        }else{
            $fields = array(
            'app_id' => "eecf381c-62fd-4ac7-ac38-4496d79c71fb",
            'include_email_tokens' => [$email],
            'email_subject' => "You've been assigned new trail problems!",
            'email_body' => "<html><body><h3>You have been assigned $ticketCount new tickets! $urgentCount tickets are urgent!<h3><hr/><small><a href='[unsubscribe_url]'>Unsubscribe</a></small></p></body></html>"
            );
        }
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