<?php

include('../mqtt-php/lib/Logging.php');
include('../mqtt-php/lib/connectionLog.php');
//require('../mqtt-php/lib/phpMQTT.php');


$server = 'localhost';
$port = 8883;
$username = 'test';
$password = 'test';
$client_id = 'phpMQTT-server';
$cafile = '../mqtt-php/certs/ca.crt';
$message = "Starting...";

$mqtt = new connectionLog($server,$port,$client_id,$cafile);
$mqtt->_debugMessage($message);

$rp = new ReflectionProperty('connectionLog', '_debugMessage');
$rp->setAccessible(true);
echo $rp->getValue();


//$log = new connectionLog();
//$log->_debugMessage();


//$log = new connectionLog($server, $port, $client_id, $cafile);
//$log->_debugMessage($server);


/*
$myfile = fopen(".\log\connectionlog.txt", "a") or die("Unable to open file!");
$txt = "[" . date("D Y-m-d h:i:s A") . "] [server " . $server.":".$port . "] [message " . $server . "]\n";
fwrite($myfile, $txt);
fclose($myfile);
*/


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
function help(): void
{
    printf("Normal scan: ./find --word|-w -- path|-p \n");
    printf("Report Generation: ./find -- word|-w  -- path|-p  --output|-o \n");
    printf("File ignore: -- exclude|-e  (For more exclusion syntax: -e txt_pdf\n");
    printf("Verbose: -- verbose|-v\n");
    printf("Report's Analysis: ./find -- report  -- show  (if n omitted, n = 1)\n");
    printf("Print all locations where the word  occurs in the  file:\nfind -- report|-r  -- show  -- file <path/to/file>\n");
}
*/


/*
function procMsg($topic, $msg)
{
    echo 'Message Received: ' . date('r') . "\n";
    echo "Topic: {$topic}\n\n";
    echo "\t$msg\n\n";

}
*/