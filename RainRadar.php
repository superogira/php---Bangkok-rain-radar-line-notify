<?php
include './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class RainRadarNotify {
  private $lineAPI = 'https://notify-api.line.me/api/notify';
  private $lineToken;
  private $header;
  private $imagePath = './images/';
  private $images = array();

  function __construct() {
    $this->lineToken = $_ENV['LINE_TOKEN'];
    $this->header = array('Method: POST', 'Content-type: multipart/form-data', 'Authorization: Bearer ' . $this->lineToken);
  }

  public function setImagePath($path) {
    $this->imagePath = $path;
  }

  public function getImages() {
    return json_encode($this->images);
  }

  public function setImage($url, $filename, $message) {
    $content = file_get_contents($url);

    file_put_contents($this->imagePath . $filename, $content);

    array_push($this->images, [$filename, $message]);
  }

  public function sendNotify() {

    foreach ($this->images as $image) {
      $imageFile = new CurlFile($this->imagePath . $image[0], 'image/jpg', $image[0] . '.jpg');
      $data = array(
        'message' => 'ภาพเรดาร์น้ำฝนล่าสุด จากสถานีเรดาร์' . $image[1],
        'imageFile' => $imageFile
      );

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->lineAPI);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $result = curl_exec($ch);

      if (curl_error($ch)) {
        $response = array('status' => '000: send fail', 'message' => curl_error($ch));
      } else {
        $response = json_decode($result, true);
      }

      curl_close($ch);
    }

    return print_r(json_encode($response));
  }
}
