<?php

function sendNotification($device, $data){
    $data = array("to" => $device,
        "notification" => array( "title" => "Shareurcodes.com", "body" => "A Code Sharing Blog!","icon" => "http://157.245.209.209/favicon.ico", "click_action" => "http://shareurcodes.com"));
    $data_string = json_encode($data);
    echo "The Json Data : ".$data_string;
    $headers = array
    (
        'Authorization: key=' . env('FIREBASE_API_KEY'),
        'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, $data_string);
    $result = curl_exec($ch);
    curl_close ($ch);
}
