<?php

include('../mqtt-php/lib/Logging.php');
include('../mqtt-php/lib/connectionLog.php');
//require('../mqtt-php/lib/phpMQTT.php');


$server = 'localhost';  //todo fare con this->
$port = 8883;
$username = 'test';
$password = 'test';
$client_id = 'phpMQTT-server';
$cafile = '../mqtt-php/certs/ca.crt';


$mqtt = new connectionLog($server, $port, $client_id, $cafile);


if (!$mqtt->connect(true, NULL, $username, $password)) {
    exit(1);
}


$topics['#'] = array('qos' => 0, 'function' => 'logger');
$mqtt->subscribe($topics, 0);


while ($mqtt->proc()) {
}


$mqtt->close();


function logger($topic, $msg)
{
    $log = new Logging();

    $log->lwrite("topic:" . " " . $topic, "messaggio:" . " " . $msg);
    $log->lclose();

}
