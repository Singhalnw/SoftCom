<?php // callback.php

require "vendor/autoload.php";//เรียกใช้ไฟล์จาก api

$access_token = 'Token ได้จาก Line Devloper';
$channelSecret = 'Channel secret ได้จาก Line Devloper';
$pushID = 'UserID ของคนที่จะส่ง';
$content = file_get_contents('php://input');
$events = json_decode($content, true); //แปลงค่าที่ส่งมาเป็น json

if (!is_null($events['events'])) //ถ้ามีข้อมูลให้เข้าทำงาน
{

    foreach ($events['events'] as $event)
    {
        //เมื่อมี event เมื่อมี user แอดเพื่อนจะสั่งให้ bot ส่ง id ของ user คนนั้นออกมา (เราจะทำมาเพื่อไว้สำหรับแจ้งเตือนสำหรับ user นั้นๆ)
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
