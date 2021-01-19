<?php

include(__DIR__ . '/Logging.php');


class Logging_Extended extends Logging
{

    private $log_file, $fp;

    // set log file (path and name)
    public function lfile($path)
    {
        $this->log_file = $path;
    }

    public function lwrite($topic, $message, $address)
    {

        // if file pointer doesn't exist, then open log file
        if (!is_resource($this->fp)) {
            $this->lopen();
        };

        //var_dump($server);


        // define current time and suppress E_WARNING if using the system TZ settings
        // (don't forget to set the INI setting date.timezone)

        //$time = @date('d/m/y H:i:s');

        $date = @date('d/m/y');
        $time = @date('H:i:s');

        echo $date."\n";
        echo $time."\n";

        // write current time, script name and message to the log file
        fwrite($this->fp, "$date $time ($address) $topic $message" . PHP_EOL);
    }


    private function lopen()
    {
        // in case of Windows set default log file
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $log_file_default = 'c:/php/logfile.txt';
        } // set default log file for Linux and other systems
        else {
            $log_file_default = '/tmp/logfile.txt';
        }
        // define log file from lfile method or use previously set default
        $lfile = $this->log_file ? $this->log_file : $log_file_default;
        // open log file for writing only and place file pointer at the end of the file
        // (if the file does not exist, try to create it)
        $this->fp = fopen($lfile, 'a') or exit("Can't open $lfile!");
    }

    public function lclose()
    {
        fclose($this->fp);
    }
}
