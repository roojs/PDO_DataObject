--TEST--
databaseStructure
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
$base_config = PDO_DataObject::config();



PDO_DataObject::config(
    array(
        'databases' => array(
            'mysql_somedb' => 'mysql://username:test@localhost:3344/somedb',
            'mysql_anotherdb' =>  'mysql://username:test@localhost:3344/anotherdb',
            
        ),
        'debug' => 1,
    )
);


// connect to a table that does not exist
try {
    $obj = new PDO_DataObject('mysql_somedb/do_not_exist');
} catch(Exception $e) {
   echo "Exception Thrown: ". $e->getMessage() ."\n";
}

echo "-- check invalid database --";

// reset the schema location.

$old = PDO_DataObject::config( 'schema_location' , '');
        

try {
    $obj = new PDO_DataObject('do_not_exist');
} catch(Exception $e) {
   echo "Exception Thrown: ". $e->getMessage() ."\n";
}
PDO_DataObject::config( 'schema_location' , $old);






?>
--EXPECT--
