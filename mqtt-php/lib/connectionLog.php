<?php

include(__DIR__ . '/phpMQTT.php');

class connectionLog extends phpMQTT

{


    public function __construct($address, $port, $clientid, $cafile = null)
    {


        $this->broker($address, $port, $clientid, $cafile);
    }

    public function broker($address, $port, $clientid, $cafile = null): void
    {


        $this->address = $address;
        $this->port = $port;
        $this->clientid = $clientid;
        $this->cafile = $cafile;
    }

    protected function _debugMessage(string $message): void
    {
        echo date('r: ') . $message . PHP_EOL;
        $var = date('r: ') . $message . PHP_EOL;
        $myfile = fopen("D:\progetti_stage\mqtt-php\log\connectionlog.txt", "a") or die("Unable to open file!");
        fwrite($myfile, $var);
        fclose($myfile);


    }

}
