--TEST--
databaseStructure - error checking
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
        'debug' => 0,
    )
);


// connect to a table that does not exist
try {
    $obj = new PDO_DataObject('mysql_somedb/do_not_exist');
} catch(Exception $e) {
   echo "no such table - Exception Thrown: ". $e->getMessage() ."\n";
}

echo "-- check invalid database --\n\n";

// reset the schema location.

$old = PDO_DataObject::config( 'schema_location' , '');
        

try {
    $obj = new PDO_DataObject('do_not_exist');
} catch(Exception $e) {
   echo "no such table - no schema -  Exception Thrown: ". $e->getMessage() ."\n";
}
PDO_DataObject::config( 'schema_location' , $old);
PDO_DataObject::reset();


echo "-- check invalid table on proxy --\n\n";

// ?? any other connection error conditions.?
// proxy on database that does not exist..
PDO_DataObject::config( 'proxy' , true);

try {
    $obj = new PDO_DataObject('mysql_somedb/do_not_exist');
} catch(Exception $e) {
   echo "proxy - no such table - Exception Thrown: ". $e->getMessage() ."\n";
}


try {
    $obj = new PDO_DataObject('do_not_exist/do_not_exist');
} catch(Exception $e) {
   echo "proxy - no such db -  Exception Thrown: ". $e->getMessage() ."\n";
}







?>
--EXPECT--
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
no such table - Exception Thrown: Could not find INI values for database=mysql_somedb and table=do_not_exist
-- check invalid database --

__construct==["mysql:dbname=testdb;host=localhost","user","pass",[]]
no such table - no schema -  Exception Thrown: Fake connection failed to non-existant database
-- check invalid table on proxy --

__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
QUERY: 9c36cac1372650b703400c60dd29042c
QUERY: f77e1669034239c845220bf51ee0a9f2
proxy - no such table - Exception Thrown: Could not find INI values for database=mysql_somedb and table=do_not_exist
__construct==["mysql:dbname=testdb;host=localhost","user","pass",[]]
proxy - no such db -  Exception Thrown: Fake connection failed to non-existant database