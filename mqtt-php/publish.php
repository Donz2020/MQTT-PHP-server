<?php

require('../mqtt-php/lib/phpMQTT.php');


$server = 'localhost';
$port = 8883;
$username = 'test';
$password = 'test';
$client_id = 'phpMQTT-publisher';
$cafile = '../mqtt-php/certs/ca.crt';

$mqtt = new phpMQTT($server, $port, $client_id, $cafile);

if ($mqtt->connect(true, NULL, $username, $password)) {
    $mqtt->publish('test', 'Hello World! at ' . date('r'), 0, false);
    $mqtt->close();
} else {
    echo "Time out!\n";
}

