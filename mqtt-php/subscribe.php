<?php

require('../mqtt-php/lib/phpMQTT.php');


$server = 'localhost';
$port = 8883;
$username = 'test';
$password = 'test';
$client_id = 'phpMQTT-subscriber';
$cafile = '../mqtt-php/certs/ca.crt';

$mqtt = new phpMQTT($server, $port, $client_id, $cafile);

if (!$mqtt->connect(true, NULL, $username, $password)) {
    exit(1);
}

$mqtt->debug = true;

$topics['test'] = array('qos' => 0, 'function' => 'procMsg');
$mqtt->subscribe($topics, 0);

while ($mqtt->proc()) {

}

$mqtt->close();

function procMsg($topic, $msg)
{
    echo 'Message Received: ' . date('r') . "\n";
    echo "Topic: {$topic}\n\n";
    echo "\t$msg\n\n";
}