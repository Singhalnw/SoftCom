<?php // callback.php

$access_token = 'kPSxCs1+RlRfJ0YLssvlvn5lTtrjYv5wl0jRhwEKHLmlSkinRSiSjdKVZOksFXDuYqn+uDUL0on7vbTdzcf77bDuDEMEXfH6T+EfcceaLz7CzKqLidYV74xip+ggv5RIR2ZElqcLxS3EDtKDOmgVyAdB04t89/1O/w1cDnyilFU=';
$channelSecret = '9954cf41a29434e6dbe4d03418393d57';
$pushID = 'U24df0d6973d5322790daf07a182332b2';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
// Loop through each event
foreach ($events['events'] as $event) {
// Reply only when message sent is in 'text' format
if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
// Get text sent
$text = $event['source']['userId'];
$stringText = $event['message']['text'];

// Get replyToken
$replyToken = $event['replyToken'];
// Build message to reply back
$messages = ['type' => 'text','text' => $text."\n Message: ".$stringText  ];
// Make a POST Request to Messaging API to reply to sender
$url = 'https://api.line.me/v2/bot/message/reply';


if($stringText == 'ข้อ id'){

    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($replyToken);
    $response = $bot->pushMessage($pushID, $textMessageBuilder);

    echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

}else{
    $data = [
        'messages' => [$messages],
        ];
}

$data = [
    'messages' => [$messages],
    
    ];



$post = json_encode($data);
$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);
echo $result . "\r\n";
}
}
}
echo "OK";
