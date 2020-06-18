<?php
//ใส่ Line Notify Token ที่ได้สร้างไว้ https://notify-bot.line.me/en/
$linenotifytoken = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

//URL รูปเรดาร์ฝนหนองแขม
$img1 ='http://weather.bangkok.go.th/FTPCustomer/radar/pics/nkradarh.jpg';
//ชื่อไฟล์ที่จะ Save ตอนโหลดมาเก็บไว้ก่อนส่ง
$fileName1 = 'rainradar1.jpg';
//URL รูปเรดาร์ฝนหนองจอก 
$img2 ='http://weather.bangkok.go.th/FTPCustomer/radar/pics/radarh.jpg';
//ชื่อไฟล์ที่จะ Save ตอนโหลดมาเก็บไว้ก่อนส่ง
$fileName2 = 'rainradar2.jpg';

/*---------------------- ระบบ Download รูปล่าสุดมาเก็บไว้ก่อนจะอัพโหลดส่งไปเข้า Line
(เนื่องด้วยถ้าเอา URL ให้ Line ดึงไปตรง ๆ เลย รูปเรดาร์จะเป็นรูปเก่า ไม่อัพเดตล่าสุด) ----------------------*/
function download_rain_radar_image($url, $filename){
   //Download ไฟล์จาก url
	$downloadedFileContents = file_get_contents($url);
	//ชื่อไฟล์ที่ Save
	$fileName = $filename;
	//เซฟไฟล์
	$save = file_put_contents($fileName, $downloadedFileContents);
}

//ทำการ Download และ Save รูป
download_rain_radar_image ($img1,$fileName1);
download_rain_radar_image ($img2,$fileName2);

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

/*---------------------- ระบบเรียกตัวแปร และเรียกระบบส่งข้อความและรูป Line Notify ----------------------*/
function notify_data($access_token, $filename, $message){
	$line_api = 'https://notify-api.line.me/api/notify';
	
	$imageFile = new CurlFile('./'.$filename, 'image/jpg', $filename.'.jpg');
	$message_data = array(
		'message' => $message,
		'imageFile' => $imageFile
	);
	$result = send_notify_message($line_api, $access_token, $message_data);
	echo '<pre>';
	print_r($result);
	echo '</pre>';
}

$message = "ภาพเรดาร์น้ำฝนล่าสุด จากสถานีเรดาร์หนองแขม";
notify_data($linenotifytoken, $fileName1, $message);
$message = "ภาพเรดาร์น้ำฝนล่าสุด จากสถานีเรดาร์หนองจอก";
notify_data($linenotifytoken, $fileName2, $message);
?>
