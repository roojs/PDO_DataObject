--TEST--
databaseStructure - postgresql - real databases (not for final test pass)
--FILE--
<?php

die("DONE");

require_once 'includes/init.php';

$base_config = PDO_DataObject::config();
 
echo "\n\nREAL DATABASE CONNECT - NOT IN FINAL TEST (postgres)\n";

(new PDO_DataObject())->reset();

PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO',
        'databases' => array(
            'xtuple_db' => 'pgsql://admin:pass4xtuple@localhost/xtuplehk'
        ),
        'tables' => array(
            'accnt' => 'xtuple_db'
        ),
        'proxy' => true,
        'debug' => 0,
        
    )
);



$obj = new PDO_DataObject('accnt');
$obj->PDO();
print_r($obj->databaseStructure());

// fixme - we need to compare this to the output from DB_DataObject...

 
?>
--EXPECT--
DONE