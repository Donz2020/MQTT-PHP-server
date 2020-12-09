<?php

require('../mqtt/lib/phpMQTT.php');

$servername = "localhost";
$port = 3306;
$username = "root";
$password = "root";
$dbname = "mqtt_connect";

$connection = new mysqli($servername, $username, $password, $dbname, $port);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}



//-----------------


$connection_string = 'DRIVER={SQL Server};SERVER=<servername>;DATABASE=<databasename>';

$user = 'username';
$pass = 'password';

$connection = odbc_connect($connection_string, $user, $pass);


