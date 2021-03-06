<?php 

require "vendor/autoload.php"; //เรียกใช้งานไฟล์ sdk

$access_token = 'atK53EyYXAxbjRAhYtx3nRpL+CfSoBi6vIvIaube7fvxZ7gQHSGqjk3d1v5B/4yuYqn+uDUL0on7vbTdzcf77bDuDEMEXfH6T+EfcceaLz6oxxSHkX/BjzSpAx8+j2rfA+4XXwQ+nljsU8X16ZJL3gdB04t89/1O/w1cDnyilFU=';
$channelSecret = '9954cf41a29434e6dbe4d03418393d57';
//$pushID = 'U24df0d6973d5322790daf07a182332b2';
$content = file_get_contents('php://input');
$events = json_decode($content, true); //แปลงเป็น json

if (!is_null($events['events'])) 
{

    foreach ($events['events'] as $event) 
    {
        //ตรวจสอบ event ว่าเป็น message หรือไม่
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') 
        {
            //GET UserID ที่จะส่ง
            $text = $event['source']['type'];
            //ข้อความที่ส่ง
            $stringText = $event['message']['text'];
            //GET Token
            $replyToken = $event['replyToken'];
            //$messages = ['type' => 'text','text' => $stringText ];

            // Url ที่จะใช้ติดต่อ
            $url = 'https://api.line.me/v2/bot/message/reply';

            //Token ข้อผู้ใช้งาน
            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
            //ChannelSecret ข้อผู้ใช้งาน
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
            //ข้อความที่ต้องการส่งไปยังผู้อื่น
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text);
            //ทำการส่งข้อความไปยัง UserID ที่กำหนด
            $response = $bot->pushMessage("U24df0d6973d5322790daf07a182332b2", $textMessageBuilder);

            //echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
            
            $headers = array('Content-Type: application/json',
            'Authorization: Bearer ' . $access_token); //ส่ง Token

            //เปิดการทำงานและกำหนด Url ที่ต้องการส่ง
            $ch = curl_init($url); 

            //กำหนดคำขอเป็น POST
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            //ตั้งค่า RETURNTRANSFER เป็น true
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //ส่งข้อมูล
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            //กำหนด http header
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            //โหลดหน้าเว็บและแสดงผลลัพธ์
            $result = curl_exec($ch);
            //สิ้นสุดการใช้ curl
            curl_close($ch);
            //echo $result . "\r\n";
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
