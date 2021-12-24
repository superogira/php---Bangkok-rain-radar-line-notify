# php---Bangkok-rain-radar-line-notify

### Installation
1. ติดตั้ง [composer](https://getcomposer.org/)
2. ```git clone https://github.com/superogira/php---Bangkok-rain-radar-line-notify.git```
3. เข้าไปในโฟลเดอร์ พิมพ์ ```composer install```
4. สร้าง [Line Notify Token](https://notify-bot.line.me/)
5. แก้ไข Line Notify Token ในไฟล์ .env
   
### Usage

```php
<?php
  // import ไฟล์ RainRadar.php
  include './RainRadar.php';

  // สร้าง object RainRadarNotify
  $RainRadar = new RainRadarNotify()

  // ตั้งค่า path สำหรับเก็บรูป
  // Default จะเป็น  ./images/
  $RainRadar->setImagePath('./folderName/');

  // เพิ่มรูป 
  // ถ้าต้องการดึงรูปจากเรดาร์อื่น ๆ ให้ไปดู Url ของรูปจากแต่ละเรดาร์ที่นี่
  // https://weather.tmd.go.th/bma_nkm.php
  // http://weather.bangkok.go.th/radar/RadarHighResolutionNk.aspx
  $RainRadar->addImage('ลิงก์รูป1', 'ชื่อรูป1.jpg', 'ชื่อสถานที่1');
  $RainRadar->addImage('ลิงก์รูป2', 'ชื่อรูป2.jpg', 'ชื่อสถานที่2');

  // เรียกดูรายชื่อรูป
  $RainRadar->getImages();

  // สง Line Notify
  $RainRadar->sendNotify();
?>
```

เอาไปใช้คู่กับ Arduino ก็ได้ - [ESP8266---Rain-detect-and-Notify](https://github.com/superogira/ESP8266---Rain-detect-and-Notify-with-rain-radar-map.)



