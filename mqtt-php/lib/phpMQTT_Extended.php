<?php

include(__DIR__ . '/phpMQTT.php');

class phpMQTT_Extended extends phpMQTT

{

    public $topic;
    public $msg;


    public function __construct($address, $port, $clientid, $cafile, $logfile, $user, $pass, $database = null)
    {
        $this->broker($address, $port, $clientid, $cafile, $logfile, $user, $pass, $database);
        $this->logfile = $logfile;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
        $this->address = $address;
        
        //echo $database;
    }

    protected function _debugMessage(string $message): void
    {

        echo date('r: ') . $message . PHP_EOL;
        $var = date('r: ') . $message . PHP_EOL;
        $filename = $this->logfile;
        $myfile = fopen("C:/Users/stage/Downloads/mqtt-php/log/" . $filename, "a") or print("Unable to open file!");
        fwrite($myfile, $var);
        fclose($myfile);
    }


    function fint_libDMF_aammgg2N($sYear, $sMonth, $sDay)
    {
        $timestamp = mktime(0, 0, 0, $sMonth, $sDay, $sYear);
        //echo "timestamp :" . $timestamp;
        $lData = ($timestamp / 86400) +  719529;
        //$GLOBALS['sHlibMath']->fbool_libMATH_Arrotonda($lData, 1, LIBMATH_ARROT_INTERO, LIBMATH_ARROT_GIUSTO);
        return ($lData);
    }

    function fint_libDMF_hhmmss2N($sHour, $sMinute, $sSecond)
    {
        $lOra = ($sHour * 3600) + ($sMinute * 60) + $sSecond + 1;
        return ($lOra);
    }

    
    public function logger($topic, $msg)
    {
        $log = new Logging_Extended();

        $address = $this->address;
        $logpath = '../mqtt-php/log/messageLog.txt';
        $log->lfile($logpath);
        $log->lwrite("topic:" . " " . $topic, "messaggio:" . " " . $msg, $address);
        $log->lclose();


        $arrMsg = array($topic, $msg);
        print_r(array_values($arrMsg));


        $val = $this->extractIpAddress();
        print ($val) . "\n";


        $val2 = array($this->getGiorni(), $this->getSecondi());
        print_r(array_values($val2)) . "\n";

        return $arrMsg;
    }

    public function getGiorni()
    {
        $year = @date('y');
        $month =  @date('m');
        $day =  @date('d');

        $giorni = $this->fint_libDMF_aammgg2N($year, $month, $day);

        return $giorni;
    }

    public function getSecondi()
    {
        $hour = @date('H');
        $minute = @date('i');
        $second = @date('s');

        $secondi = $this->fint_libDMF_hhmmss2N($hour, $minute, $second);

        return $secondi;
    }

    public function extractIpAddress()
    {
        $address = $this->address;
        return $address;
    }


    public function message($msg)
    {
        $tlen = (ord($msg[0]) << 8) + ord($msg[1]);
        $topic = substr($msg, 2, $tlen);
        $msg = substr($msg, ($tlen + 2));
        $found = false;
        foreach ($this->topics as $key => $top) {
            if (preg_match(
                '/^' . str_replace(
                    '#',
                    '.*',
                    str_replace(
                        '+',
                        "[^\/]*",
                        str_replace(
                            '/',
                            "\/",
                            str_replace(
                                '$',
                                '\$',
                                $key
                            )
                        )
                    )
                ) . '$/',
                $topic
            )) {

                if (method_exists('phpMQTT_Extended', 'logger')) {

                    $this->logger($topic, $msg);
                    $this->connectDB($this->database);

                    //call_user_func($top['function'], $topic, $msg);
                }
            } else {
                $this->_errorMessage('Message received on topic ' . $topic . ' but function is not callable.');
            }
        }


        if ($found === false) {
            $this->_debugMessage('msg received but no match in subscriptions');
        }

        echo $msg;
        echo $topic;
        return $found;
    }



    public function connectDB($dsn)
    {
        //$this->database = $dsn;
        $this->dsn = $dsn;
        $database = 'MQTT';
        $user = '';
        $pass = '';

        $connection = odbc_connect("Dsn=$dsn;Database=$database", $user, $pass);

        if ($connection == true) {
            //echo "connesso\n";
            $this->_debugMessage("Connected to DB");
            $this->writeDB($connection);
        } else {
            $this->_debugMessage("Failed to connect to DB");
        }


        var_dump($connection);
    }



    public function writeDB($connection)
    {

        $query = 'INSERT INTO tx_mqttlog (TX_DATA,TX_ORA,TX_C_SERVER,TOPIC,MESSAGGIO,F_LETTO,F_ANNULLATO)
        VALUES(?,?,?,?,?,?,?);';

        $data = [$this->getGiorni(), $this->getSecondi(), $this->extractIpAddress(), 'amm/commerciale', 'nuovabolla2', '0', '0'];

        //$data = ['$data', '$ora', '$server', '$topic', '$messaggio', '$letto', '$annullato'];


        $res = odbc_prepare($connection, $query);

        if (!$res) die("could not prepare statement " . $query);



        if (odbc_execute($res, $data)) {
            //$row = odbc_fetch_array($res);
            //echo "execute query to DB successful !\n";
            $this->_debugMessage("execute query to DB successful");
        } else {
            throw new Exception("ODBC exec of query returned false.");
            $this->_debugMessage("ODBC exec of query returned false.");
        }


        var_dump($connection);
        //$this->closeDB($connection); 
    }


    public function closeDB($connection)
    {
        $close = odbc_close($connection);
        echo "connessione chiusa DB\n";
        $this->_debugMessage("Disconnected from DB");
        return $close;
    }
}
