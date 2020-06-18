<?php
//ใส่ Line Notify Token ที่ได้สร้างไว้ https://notify-bot.line.me/en/
$linenotifytoken = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

//รูปเรดาร์ฝนหนองแขม
$img1 ='http://weather.bangkok.go.th/FTPCustomer/radar/pics/nkradarh.jpg';
//รูปเรดาร์ฝนหนองจอก
$img2 ='http://weather.bangkok.go.th/FTPCustomer/radar/pics/radarh.jpg';

//Download ไฟล์จาก url
$downloadedFileContents = file_get_contents($img1);
//ตรวจสอบว่า Download ได้สำเร็จไหม
if($downloadedFileContents === false){
    throw new Exception('Failed to download file at: ' . $img1);
}
//ชื่อไฟล์ที่ Save
$fileName = 'rainradar1.jpg';
//เซฟไฟล์
$save = file_put_contents($fileName, $downloadedFileContents);
//ตรวจสอบว่า Save สำเร็จไหม
if($save === false){
    throw new Exception('Failed to save file to: ' , $fileName);
}

//Download ไฟล์จาก url
$downloadedFileContents = file_get_contents($img2);
//ตรวจสอบว่า Download ได้สำเร็จไหม
if($downloadedFileContents === false){
    throw new Exception('Failed to download file at: ' . $img1);
}
//ชื่อไฟล์ที่ Save
$fileName = 'rainradar2.jpg';
//เซฟไฟล์
$save = file_put_contents($fileName, $downloadedFileContents);
//ตรวจสอบว่า Save สำเร็จไหม
if($save === false){
    throw new Exception('Failed to save file to: ' , $fileName);
}

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
$message = "ภาพเรดาร์น้ำฝนล่าสุด จากสถานีเรดาร์หนองแขม";
$imageFile = new CurlFile('./rainradar1.jpg', 'image/jpg', 'rainradarline1.jpg');

$message_data = array(
	'message' => $message,
	'imageFile' => $imageFile
);
$result = send_notify_message($line_api, $access_token, $message_data);
echo '<pre>';
print_r($result);
echo '</pre>';

$message = "ภาพเรดาร์น้ำฝนล่าสุด จากสถานีเรดาร์หนองจอก";
$imageFile = new CurlFile('./rainradar2.jpg', 'image/jpg', 'rainradarline2.jpg');
$result = send_notify_message($line_api, $access_token, $message_data);
echo '<pre>';
print_r($result);
echo '</pre>';
?>
