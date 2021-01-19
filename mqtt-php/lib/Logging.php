<?php


class Logging
{
    // declare log file and file pointer as private properties
    private $log_file, $fp;

    // set log file (path and name)
    public function lfile($path)
    {
        $this->log_file = $path;
    }

    // write message to the log file


    // close log file (it's always a good idea to close a file when you're done with it)
    public function lclose()
    {
        fclose($this->fp);
    }

    // open log file (private method)
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
}
