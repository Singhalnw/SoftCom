<?php

$access_token = 'kPSxCs1+RlRfJ0YLssvlvn5lTtrjYv5wl0jRhwEKHLmlSkinRSiSjdKVZOksFXDuYqn+uDUL0on7vbTdzcf77bDuDEMEXfH6T+EfcceaLz7CzKqLidYV74xip+ggv5RIR2ZElqcLxS3EDtKDOmgVyAdB04t89/1O/w1cDnyilFU=';
$channelSecret = '9954cf41a29434e6dbe4d03418393d57';
$pushID = 'U24df0d6973d5322790daf07a182332b2';
$httpClient = new CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
$textMessageBuilder = new TextMessageBuilder('hello world');
$response = $bot->pushMessage($pushID, $textMessageBuilder);
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
