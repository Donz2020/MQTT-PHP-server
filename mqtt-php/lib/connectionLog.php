<?php

include(__DIR__ . '/phpMQTT.php');

class connectionLog extends phpMQTT

{
    public function __construct($address, $port, $clientid, $cafile, $logfile, $user, $pass, $database = null)
    {
        $this->broker($address, $port, $clientid, $cafile, $logfile, $user, $pass, $database);
        $this->logfile = $logfile;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
    }




    protected function _debugMessage(string $message): void
    {

        echo date('r: ') . $message . PHP_EOL;
        $var = date('r: ') . $message . PHP_EOL;
        $filename = $this->logfile;
        $myfile = fopen("D:/progetti_stage/mqtt-php/log/" .$filename, "a") or die("Unable to open file!");
        fwrite($myfile, $var);
        fclose($myfile);


    }

}
