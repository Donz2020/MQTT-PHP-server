<?php

include('../mqtt-php/lib/Logging.php');
include('../mqtt-php/lib/connectionLog.php');
//require('../mqtt-php/lib/phpMQTT.php');


//$server = readline("Enter server address:");  //todo fare con $this->server = $server per passare argomenti dalla cli
//$port = 8883;
//$username = 'test';
//$password = 'test';
$client_id = 'phpMQTT-server';
$cafile = '../mqtt-php/certs/ca.crt';


$shortopts = "";
$shortopts .= "s:";  // Required value   //todo per connect al server con indirizzo e porta
$shortopts .= "l:"; // required value  //todo per impostare path file di log
$shortopts .= "u:";
$shortopts .= "p:";
$shortopts .= "d:";                     //todo per impostare connessione al db prendendo i dati di auth dalla tabella
$shortopts .= "abc"; // These options do not accept values


$longopts = array(
    "server:",     // Required value
    "logfile:",    // Optional value
    "user:",
    "pass:",
    "database:",        // No value
    "opt",           // No value
);


$options = getopt($shortopts, $longopts);

print_r(array_values($options));


$separe = implode($options);    //converto in stringa

$pieces = explode(":", $separe);   //separo la stringa usando  :


$input_array = array_chunk($pieces, 2, true);    //separo in due sottoarray

print_r(array_values($input_array));  //stampo solo per vedere la struttura

$server = $input_array[0][0];

$port = $input_array[0][1];


//$mqtt = new connectionLog($server ,$port, $client_id, $cafile);




$mqtt = new connectionLog($options["server"], $port, $client_id, $cafile, $options["logfile"], $options["user"], $options["pass"],$options["database"]);   //todo aggiungere comandi dal broker


if (!$mqtt->connect(true, NULL, $options["user"], $options["pass"])) {
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
    $logpath = '../mqtt-php/log/logfile.txt';  //todo var del log a scelta come parametro cli
    $log->lfile($logpath);
    $log->lwrite("topic:" . " " . $topic, "messaggio:" . " " . $msg);
    $log->lclose();

}
