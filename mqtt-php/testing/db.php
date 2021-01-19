<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
define('SQLSETCONNECTOPTION',         1);
define('SQLSETSTMTOPTION',            2);
// these are the hard coded "names" as integers
// see defines in /usr/include/sqlext.h
define('SQL_AUTOCOMMIT',            102);
define('SQL_COLUMN_CASE_SENSITIVE',  12);
define('SQL_QUERY_TIMEOUT',           0);


$dsn      = 'LEOonline';
$database = 'MQTT';
$dbuser = '';
$dbpass = '';
$conn = odbc_connect("Dsn=$dsn;Database=$database", $dbuser, $dbpass);


// optional to demonstrate settings
odbc_setoption($conn,  SQLSETCONNECTOPTION, SQL_COLUMN_CASE_SENSITIVE, false);

$dql = "select cast(current_user as nvarchar(20))   as [CURRENT_USER],
            cast(db_name() as nvarchar(30))            as [CURRENT_DB],
            lower(cast(serverproperty('ServerName') as nvarchar(20)))  as [SERVERNAME],
            lower(cast(@@SERVICENAME as nvarchar(20))) as [SERVICENAME]";

$resource = odbc_exec($conn, $dql);
if (!$resource) {
   throw new Exception("ODBC exec of query returned false.");
}

$r = odbc_fetch_array($resource);
print "Connection okay!\n";
printf(
   "User: %s, DB: %s, Server: %s, Current Instance: %s\n",
   $r['CURRENT_USER'],
   $r['CURRENT_DB'],
   $r['SERVERNAME'],
   $r['SERVICENAME']
);
