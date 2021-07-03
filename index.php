<?php
include './class.php';

$RainRadar = new RainRadarNotify();
$RainRadar->setImage('http://weather.bangkok.go.th/FTPCustomer/radar/pics/nkradarh.jpg', 'rainradar1.jpg', 'หนองแขม');
$RainRadar->setImage('http://weather.bangkok.go.th/FTPCustomer/radar/pics/radarh.jpg', 'rainradar2.jpg', 'หนองจอก');
$RainRadar->sendNotify();
