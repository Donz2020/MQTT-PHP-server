<?php

include('./lib/PHP_classlibdmf.php');

$dsn = "LEOonline";
$database = 'MQTT';
$user = '';
$pass = '';

$connection = odbc_connect("Dsn=$dsn;Database=$database", $user, $pass);


$dql = "INSERT INTO tx_mqttlog (TX_DATA,TX_ORA,TX_C_SERVER,TOPIC,MESSAGGIO,F_LETTO,F_ANNULLATO)
VALUES ('12122020','150322','192.168.120.113','amm/commerciale','nuovabolla2','0','0');";


$resource = odbc_exec($connection, $dql);
if (!$resource) {
    throw new Exception("ODBC exec of query returned false.");
}

//$r = odbc_fetch_array($resource);
/*
print "Connection okay!\n";

$date = "3 October 2005";
echo(strtotime($date));
*/

/*
$time_input = strtotime("2011/05/21");  
$date_input = getDate($time_input);  
print_r($date_input); 
*/

function calculateDays($data)
{
    $data = '';
    $stringToTime = new classLIBDMF($data);
    $stringToTime->fint_libDMF_aammgg2N(2020,10,12);
    echo $stringToTime;
}

