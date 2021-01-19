<?php

include('./lib/PHP_classlibdmf.inc.php');


class DB_connect
{
    public $connection;

    public function __construct($dsn)
    {

        $this->dsn = $dsn;
        $database = 'MQTT';
        $user = '';
        $pass = '';

        $connection = odbc_connect("Dsn=$dsn;Database=$database", $user, $pass);

        if ($connection == TRUE) {
            echo "connesso\n";
            
        } else {
            
        }
        

        $this->writeDB($connection);


        var_dump($connection);


        /*
        if (!$connection) {
            exit("Connection Failed - " . odbc_error() . ":" . odbc_errormsg() . "\n");
        } 
        */

        //altrimenti scrivi un log e ritorno tramite echo "connessione db fallita"
    }

    public function writeDB($connection)
    {

        $query = 'INSERT INTO tx_mqttlog (TX_DATA,TX_ORA,TX_C_SERVER,TOPIC,MESSAGGIO,F_LETTO,F_ANNULLATO)
        VALUES(?,?,?,?,?,?,?);';

        $data = ['12122020', '150322', '192.168.120.113', 'amm/commerciale', 'nuovabolla2', '0', '0'];


        $res = odbc_prepare($connection, $query);

        if (!$res) die("could not prepare statement " . $query);


        if (odbc_execute($res, $data)) {
            //$row = odbc_fetch_array($res);
            echo "execute query to DB successful !\n";
        } else {
            throw new Exception("ODBC exec of query returned false.");
        }


        var_dump($connection);
        $this->closeDB($connection);
    }


    public function closeDB($connection)
    {
        $close = odbc_close($connection);
        echo "connessione chiusa DB\n";
        
    }
}


    /*
$prep = odbc_prepare($connection,$query);


$resource = odbc_execute($connection);
if (!$resource) {
    throw new Exception("ODBC exec of query returned false.");
}

*/

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

    /*
function calculateDays($data)
{
    $data = '';
    $stringToTime = new classLIBDMF($data);
    $stringToTime->fint_libDMF_aammgg2N(2020,10,12);
    echo $stringToTime;
}
*/
