<?php


include ('../mqtt-php/lib/phpMQTT.php');

class connectionLog extends phpMQTT
{


    public function _debugMessage(string $message):void
    {

        $var = date('r: ') . $message . PHP_EOL;
        $myfile = fopen("D:\progetti_stage\mqtt-php\log\connectionlog.txt", "a") or die("Unable to open file!");
        fwrite($myfile,$var);
        fclose($myfile);

    }


}
