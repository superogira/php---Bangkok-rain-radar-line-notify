# php---Bangkok-rain-radar-line-notify

ดึงรูปปัจจุบันของเรดาร์น้ำฝนหนองแขม-หนอกจอก ส่งเข้า Line ด้วย Line Notify<br>
https://notify-bot.line.me/doc/en/

ถ้าต้องการดึงรูปจากเรดาร์อื่น ๆ ให้ไปดู Url ของรูปจากแต่ละเรดาร์ที่นี่<br>
https://weather.tmd.go.th/bma_nkm.php<br>
http://weather.bangkok.go.th/radar/RadarHighResolutionNk.aspx

รูปจะ Update ชั่วโมงละครั้ง ที่นาทีที่ 5 และวินาทีที่ 5 ของแต่ละชั่วโมง
ถ้าดึงรูปก่อนเวลา ก็จะได้รูปเรดาร์ฝนของชั่วโมงก่อนไป
เพราะฉนั้นแล้วควรเรียก Url ดึงรูปไปตอนนาทีที่ 6 เป็นต้นไป
