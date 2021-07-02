<?php
include './vendor/autoload.php';
include './class.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$RainRadar = new RainRadarNotify($_ENV['LINE_TOKEN']);
$RainRadar->setImage('http://weather.bangkok.go.th/FTPCustomer/radar/pics/nkradarh.jpg', 'rainradar1.jpg', 'หนองแขม');
$RainRadar->setImage('http://weather.bangkok.go.th/FTPCustomer/radar/pics/radarh.jpg', 'rainradar2.jpg', 'หนองจอก');
$RainRadar->sendNotify();
