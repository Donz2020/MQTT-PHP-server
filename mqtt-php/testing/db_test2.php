<?php

$dsn ="odbc:LEOonline";

// Random list of strings for name searches.
// Could be full alphabet
$firstNames = array(
  array("tp"=>"a%"),
  array("tp"=>"e%"),
  array("tp"=>"i%"),
  array("tp"=>"o%"),
  array("tp"=>"")
);

try {
    // Connect to the data source
    $dbh = new PDO($dsn);

    // Prepare the statement with 2 Select statements.
    // Note the first SELECT uses the array key 'fn' as the select criteria
    // in the PDO form ':fn'.
    $stmt = $dbh->prepare('SELECT * FROM tx_mqttlog
                           WHERE TOPIC == amm LIKE :tp;');

    // Execute the prepared statement for each name in the array
    foreach($firstNames as $name) {
        print_r( array_values($name));

        $stmt->execute($name);

        // Print results for each rowset returned. We will get 1 rowset for
        // each SELECT. The first will be any records found (which may be empty)
        // and the second with be a count of the records returned by the first
        // (which may be zero). Note this relies on SQL Server returning this
        // value after a SELECT.
        do {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $rst)
            {
                // These keys will exists if this rowset is a record
                if (array_key_exists('TOPIC', $rst)) printf ("\n %d",     $rst['TOPIC']);


                // This key will exist if this rowset is the record count set
                if (array_key_exists('Rows', $rst)) printf ("\n Records Found : %d\n",$rst['Rows']);
            }
        } while ($stmt->nextRowset());
    }

    // Close statement and data base connection
    $stmt = NULL;
    $dbh = NULL;
}

catch(PDOException $e) {
    echo $e->getMessage();
}