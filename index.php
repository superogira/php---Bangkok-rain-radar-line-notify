<?php
include './RainRadar.php';

$RainRadar = new RainRadarNotify();
$RainRadar->addImage('http://weather.bangkok.go.th/FTPCustomer/radar/pics/nkradarh.jpg', 'rainradar1.jpg', 'หนองแขม');
$RainRadar->addImage('http://weather.bangkok.go.th/FTPCustomer/radar/pics/radarh.jpg', 'rainradar2.jpg', 'หนองจอก');
$RainRadar->sendNotify();
