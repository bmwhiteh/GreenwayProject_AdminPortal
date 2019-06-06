<?PHP
function sendMessage($message){
    $content = array(
        "en" => $message
        );
    $header = array(
        "en" => "Severe Weather Alert!"
        );

    $fields = array(
        'app_id' => "7df26352-e23a-40db-9ce3-31c5e383bcf8",
        'included_segments' => array('All'),
        'data' => array("foo" => "bar"),
        'large_icon' =>"ic_launcher_round.png",
        'headings' => $header,
        'contents' => $content
        
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
    curl_close($ch);

    return $response;
}
/*
$response = sendMessage();
$return["allresponses"] = $response;

$test = json_decode($return["allresponses"], true);
echo "Recipients: " . $test['recipients'] . PHP_EOL;*/
?>