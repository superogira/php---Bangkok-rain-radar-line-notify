<?php
include './vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class RainRadarNotify
{
    private $lineAPI = 'https://notify-api.line.me/api/notify';
    private $lineToken;
    private $imagePath = './images/';
    private $images = array();
    private $client;

    public function __construct()
    {
        $this->lineToken = $_ENV['LINE_TOKEN'];
        $this->client = new \GuzzleHttp\Client();
    }

    public function setImagePath($path)
    {
        $this->imagePath = $path;
    }

    public function getImages()
    {
        return json_encode($this->images);
    }

    public function addImage($url, $filename, $message)
    {
        $content = file_get_contents($url);

        file_put_contents($this->imagePath . $filename, $content);

        array_push($this->images, [$filename, $message]);
    }

    public function sendNotify()
    {
        foreach ($this->images as $image) {
            try {
                $response = $this->client->request('POST', $this->lineAPI, [
                    'multipart' => [
                        [
                            'name' => 'message',
                            'contents' => 'ภาพเรดาร์น้ำฝนล่าสุด จากสถานีเรดาร์' . $image[1],
                        ],
                        [
                            'name' => 'imageFile',
                            'contents' => fopen($this->imagePath . $image[0], 'r'),
                        ],
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->lineToken,
                    ],
                ]);

                echo $response->getBody();
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
    }
}
