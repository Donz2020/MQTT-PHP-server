<?php

//include('./lib/PHP_classlibdmf.inc.php');



$data = ['12122020', '150322', '192.168.120.113', 'amm/commerciale', 'nuovabolla2', '0', '0'];

$stringa = '[23/Dec/2020:12:29:33] (server) topic: home/garden/fountain messaggio: iiiii';


//todo scomporre data e ora , e contare la data dall'anno 0 , e l'ora dal giorno 0





//$date = new classLIBDMF($year);

/*
function convert()
{

    $year = 2018;
    $month = 12;
    $day = 7;

    $date = new classLIBDMF($year);

    $date->fint_libDMF_aammgg2N($year, $month, $day);
}

$date = convert();

var_dump($date);
*/

//todo fare array associativo per i mesi (es. 1=>Gen , 2=>Feb)
$year = 2021;
$month = 1;
$day = 15;

$giorni = fint_libDMF_aammgg2N($year, $month, $day);

echo "\ngiorni passati dall'anno 0 :" . " " . $giorni;



function fint_libDMF_aammgg2N($sYear, $sMonth, $sDay)
{
    $timestamp = mktime(0, 0, 0, $sMonth, $sDay, $sYear);
    echo "timestamp :" . $timestamp;
    $lData = ($timestamp / 86400) +  719529;
    //$GLOBALS['sHlibMath']->fbool_libMATH_Arrotonda($lData, 1, LIBMATH_ARROT_INTERO, LIBMATH_ARROT_GIUSTO);
    return ($lData);
}


$hour = 18;
$minute = 12;
$second = 9;

$secondi = fint_libDMF_hhmmss2N($hour, $minute, $second);


echo "\nsecondi dalla mezzanotte :" . " " . $secondi;




function fint_libDMF_hhmmss2N($sHour, $sMinute, $sSecond)
{
    $lOra = ($sHour * 3600) + ($sMinute * 60) + $sSecond + 1;
    return ($lOra);
}



//private $stMonthLabel = array(1=>"January", 2=>"February", 3=>"March", 4=>"April", 5=>"May", 6=>"June", 7=>"July", 8=>"August", 9=>"September", 10=>"October", 11=>"November", 12=>"December"));
