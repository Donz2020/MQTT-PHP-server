<?php

include('../mqtt-php/lib/Logging.php');

require('../mqtt-php/lib/phpMQTT.php');


$server = 'localhost';     // change if necessary
$port = 8883;                     // change if necessary
$username = 'test';                   // set your username
$password = 'test';                   // set your password
$client_id = 'phpMQTT-publisher'; // make sure this is unique for connecting to server - you could use uniqid()
$cafile = '../mqtt-php/certs/ca.crt';


$mqtt = new mqtt\phpMQTT($server, $port, $client_id, $cafile);


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

/*
function procMsg($topic, $msg)
{
    echo 'Message Received: ' . date('r') . "\n";
    echo "Topic: {$topic}\n\n";
    echo "\t$msg\n\n";

}
*/