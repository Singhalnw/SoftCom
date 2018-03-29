<?php // callback.php

require "vendor/autoload.php";

$access_token = 'kPSxCs1+RlRfJ0YLssvlvn5lTtrjYv5wl0jRhwEKHLmlSkinRSiSjdKVZOksFXDuYqn+uDUL0on7vbTdzcf77bDuDEMEXfH6T+EfcceaLz7CzKqLidYV74xip+ggv5RIR2ZElqcLxS3EDtKDOmgVyAdB04t89/1O/w1cDnyilFU=';
$channelSecret = '9954cf41a29434e6dbe4d03418393d57';
$pushID = 'U24df0d6973d5322790daf07a182332b2';
$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) 
{

    foreach ($events['events'] as $event) 
    {
        for(int i = 0; i <= 10; i++)
        {
            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("999999999999");
            $response = $bot->pushMessage($pushID, $textMessageBuilder);

            echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

            if ($event['type'] == 'message' && $event['message']['type'] == 'text') 
        }

        
        {

            $text = $event['source']['userId'];
            $stringText = $event['message']['text'];
            $replyToken = $event['replyToken'];
            $messages = ['type' => 'text','text' => $stringText ];
            $url = 'https://api.line.me/v2/bot/message/reply';


            if($stringText == 'ขอ id')
            {

                $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
                $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

                $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
                $response = $bot->pushMessage($pushID, $textMessageBuilder);

                echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

            }
            else
            {
                
            }


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



        if ($event['type'] == 'follow') 
        {
            $text = $event['source']['userId'];
            $pushID = $text;
            $replyToken = $event['replyToken'];
            $messages = ['type' => 'text','text' => "ID ที่ได้ทำการเพิ่มเข้ามา: ".$text  ];
            $url = 'https://api.line.me/v2/bot/message/reply';

            $data = [
                'replyToken' => $replyToken,
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