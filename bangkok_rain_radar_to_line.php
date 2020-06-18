<?php
//ใส่ Line Notify Token ที่ได้สร้างไว้ https://notify-bot.line.me/en/
$linenotifytoken = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

/*---------------------- ระบบส่งข้อความและรูป Line Notify ----------------------*/
function send_notify_message($line_api, $access_token, $message_data){
   $headers = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer '.$access_token );

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $line_api);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $message_data);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $result = curl_exec($ch);
   // Check Error
   if(curl_error($ch))
   {
      $return_array = array( 'status' => '000: send fail', 'message' => curl_error($ch) );
   }
   else
   {
      $return_array = json_decode($result, true);
   }
   curl_close($ch);
return $return_array;
}

/*---------------------- เรียกตัวแปรกับระบบส่งข้อความและรูป Line Notify ----------------------*/
$line_api = 'https://notify-api.line.me/api/notify';
$access_token = $linenotifytoken;
    
//ส่งรูปเรดาร์ฝน
$image_thumbnail_url = 'http://localhost';  // max size 240x240px JPEG
$message = "ภาพเรดาร์น้ำฝนล่าสุด จากสถานีเรดาร์หนองแขม";
$image_fullsize_url = 'http://weather.bangkok.go.th/FTPCustomer/radar/pics/nkradarh.jpg';
$message_data = array(
	'imageThumbnail' => $image_thumbnail_url,
	'imageFullsize' => $image_fullsize_url,
	'message' => $message
);
$result = send_notify_message($line_api, $access_token, $message_data);
echo '<pre>';
print_r($result);
echo '</pre>';

$message = "ภาพเรดาร์น้ำฝนล่าสุด จากสถานีเรดาร์หนองจอก";
$image_fullsize_url = 'http://weather.bangkok.go.th/FTPCustomer/radar/pics/radarh.jpg';
$result = send_notify_message($line_api, $access_token, $message_data);
echo '<pre>';
print_r($result);
echo '</pre>';
?>
