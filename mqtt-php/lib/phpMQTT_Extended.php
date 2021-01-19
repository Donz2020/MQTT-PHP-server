<?php

include(__DIR__ . '/phpMQTT.php');

class phpMQTT_Extended extends phpMQTT

{

    public function __construct($address, $port, $clientid, $cafile, $logfile, $user, $pass, $database = null)
    {
        $this->broker($address, $port, $clientid, $cafile, $logfile, $user, $pass, $database);
        $this->logfile = $logfile;
        $this->user = $user;
        $this->pass = $pass;
        $this->database = $database;
        $this->address = $address;
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
        echo "timestamp :" . $timestamp;
        $lData = ($timestamp / 86400) +  719529;
        //$GLOBALS['sHlibMath']->fbool_libMATH_Arrotonda($lData, 1, LIBMATH_ARROT_INTERO, LIBMATH_ARROT_GIUSTO);
        return ($lData);
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



        $val = $this->extractDateTime();
        print ($val) . "\n";

        $val2 = $this->substrDate();
        print ($val2) . "\n";

        $val3 = $this->substrTime();
        print ($val3) . "\n";

        $val4 = $this->substrDateD();
        print ($val4) . "\n";

        $val5 = $this->substrDateM();
        print ($val5) . "\n";

        $val6 = $this->substrDateY();
        print ($val6) . "\n";

        $val7 = $this->substrTimeH();
        print ($val7) . "\n";

        $val8 = $this->substrTimeM();
        print ($val8) . "\n";

        $val9 = $this->substrTimeS();
        print ($val9) . "\n";

        $val10 = $this->extractIpAddress();
        print ($val10) . "\n";
        /*
        $val11 = $this->extractTopic();
        print ($val11) . "\n";

        $val12 = $this->extractMessage();
        print ($val12) . "\n";
*/
        return $arrMsg;
    }


    public function substrDate()
    {
        $date = $this->extractDateTime();
        $days = substr($date, 0, -10);

        return $days;
    }

    public function substrDateD()
    {
        $date = $this->extractDateTime();
        $day = substr($date, 0, -16);

        return $day;
    }

    public function substrDateM()
    {
        $date = $this->extractDateTime();
        $month = substr($date, 3, -13);

        return $month;
    }

    public function substrDateY()
    {
        $date = $this->extractDateTime();
        $year = substr($date, 6, -10);

        return $year;
    }


    public function substrTime()
    {
        $time = $this->extractDateTime();
        $hours = substr($time, 9, -1);

        return $hours;
    }


    public function substrTimeH()
    {
        $time = $this->extractDateTime();
        $hour = substr($time, 9, -7);

        return $hour;
    }

    public function substrTimeM()
    {
        $time = $this->extractDateTime();
        $minute = substr($time, 12, -4);

        return $minute;
    }

    public function substrTimeS()
    {
        $time = $this->extractDateTime();
        $second = substr($time, 15, -1);

        return $second;
    }

    public function extractIpAddress()
    {
        $address = $this->address;
        return $address;
    }



    public function extractDateTime()
    {
        $path = "../mqtt-php/log/messageLog.txt";
        $data = file($path);
        $readLines = max(0, count($data) - 1);

        if ($readLines > 0) {
            for ($i = $readLines; $i < count($data); $i++) {

                $date = substr($data[$i], 0, -48);
                //$time = substr($data[$i], 9, -48);

                //$array = $date;

                //$string = implode($array);
                //print_r(array_values($array));
            }
            return $date;
        }
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

                    //call_user_func($top['function'], $topic, $msg);

                }
            } else {
                $this->_errorMessage('Message received on topic ' . $topic . ' but function is not callable.');
            }
        }


        if ($found === false) {
            $this->_debugMessage('msg received but no match in subscriptions');
        }

        return $found;
    }



    public function connectDB($dsn)
    {
        $this->dsn = $dsn;
        $database = 'MQTT';
        $user = '';
        $pass = '';

        $connection = odbc_connect("Dsn=$dsn;Database=$database", $user, $pass);

        if ($connection == true) {
            //echo "connesso\n";
            $this->_debugMessage("Connected to DB");
        } else {
            $this->_debugMessage("Failed to connect to DB");
        }


        $this->writeDB($connection);


        var_dump($connection);
    }



    public function writeDB($connection)
    {

        $query = 'INSERT INTO tx_mqttlog (TX_DATA,TX_ORA,TX_C_SERVER,TOPIC,MESSAGGIO,F_LETTO,F_ANNULLATO)
        VALUES(?,?,?,?,?,?,?);';

        $data = ['12122020', '150322', '192.168.120.113', 'amm/commerciale', 'nuovabolla2', '0', '0'];

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
    }
}