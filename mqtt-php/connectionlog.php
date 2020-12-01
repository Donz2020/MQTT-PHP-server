<?php

$dataToLog = array(
    date("Y-m-d H:i:s"),
    $_SERVER['REMOTE_ADDR'],
    'Clicked on item 4',
    'Number of items in cart is 2'
);

//Turn array into a delimited string using
//the implode function
$data = implode(" - ", $dataToLog);

//Add a newline onto the end.
$data .= PHP_EOL;

//The name of your log file.
//Modify this and add a full path if you want to log it in
//a specific directory.
$pathToFile = '.\log\connectionlog.log';

//Log the data to your file using file_put_contents.
file_put_contents($pathToFile, $data, FILE_APPEND);