<?php

include('../mqtt-php/lib/Logging.php');
include('../mqtt-php/lib/phpMQTT_Extended.php');


$client_id = 'phpMQTT-server';
$cafile = '../mqtt-php/certs/ca.crt';

/*
* Argument parser from cli
*/
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
print_r($options);


$separe = implode($options);    //converto in stringa

$pieces = explode(":", $separe);   //separo la stringa usando  :


$input_array = array_chunk($pieces, 2, true);    //separo in due sottoarray

print_r(array_values($input_array));  //stampo solo per vedere la struttura

$server = $input_array[0][0];

$port = $input_array[0][1];

//$database = $options["database"];



/*
* create istance for connect
*/

$mqtt = new phpMQTT_Extended($server, $port, $client_id, $cafile, $options["logfile"], $options["user"], $options["pass"], $options["database"]);

if (isset($options["database"]) == FALSE) {
    print("non settata\n");
    //todo logger connessione
    //$mqtt->logger($topic, $msg);
    $topics['#'] = array('qos' => 0);
    //$mqtt->_debugMessage("Database argument not passed by CLI");

} else {
    echo "settata\n";
    $mqtt->connectDB($options["database"]);
    $topics['#'] = array('qos' => 0);
    //$db->writeDB();
    //$db->closeDB();

    if ($mqtt == FALSE) {
        echo "settata ma senza connessione\n";
        $topics['#'] = array('qos' => 0);
        
        //$mqtt->logger($topic, $msg);
    }
}


/*
if (isset($options["logfile"]) == FALSE) {
    print("non settata\n");
    
} else {
    echo "settata\n";
}
*/

//passo qua i valori e in caso l'handle della connessione ritorna false, faccio il log su testo

//$db->connect($options["database"]);



if (!$mqtt->connect(true, NULL, $options["user"], $options["pass"])) {
    exit(1);
}



$mqtt->subscribe($topics, 0);


while ($mqtt->proc()) {
}

$mqtt->close();


/*
* Function to log messages from topics
*/

/*
function logger($topic, $msg)
{
    $log = new Logging();
    $logpath = '../mqtt-php/log/logfile.txt';
    $log->lfile($logpath);
    $log->lwrite("topic:" . " " . $topic, "messaggio:" . " " . $msg);
    $log->lclose();
}
*/

/*
function db($dsn)
{

    $db = new DB();
    $db->dbConnect($dsn);
}
*/