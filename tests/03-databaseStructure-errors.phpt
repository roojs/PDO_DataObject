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

echo "-- check invalid database --\n\n";

// reset the schema location.

$old = PDO_DataObject::config( 'schema_location' , '');
        

try {
    $obj = new PDO_DataObject('do_not_exist');
} catch(Exception $e) {
   echo "Exception Thrown: ". $e->getMessage() ."\n";
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
   echo "Exception Thrown: ". $e->getMessage() ."\n";
}


try {
    $obj = new PDO_DataObject('do_not_exist/do_not_exist');
} catch(Exception $e) {
   echo "Exception Thrown: ". $e->getMessage() ."\n";
}



?>
--EXPECT--
PDO_DataObject   : __construct       : ["mysql_somedb\/do_not_exist"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_somedb') : config[databases][mysql_somedb] in options
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : ERROR       : Could not find INI values for database=mysql_somedb and table=do_not_exist
Exception Thrown: Could not find INI values for database=mysql_somedb and table=do_not_exist
-- check invalid database --

PDO_DataObject   : __construct       : ["do_not_exist"]
PDO_DataObject   : databaseStructure       : CALL:[]
__construct==["mysql:dbname=testdb;host=localhost","user","pass",[]]
Exception Thrown: Fake connection failed to non-existant database
-- check invalid table on proxy --

PDO_DataObject   : __construct       : ["mysql_somedb\/do_not_exist"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_somedb') : config[databases][mysql_somedb] in options
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_somedb') : config[databases][mysql_somedb] in options
PDO_DataObject   : databaseStructureProxy       : calling Get list of tablesdatabaseStructure called with args for database = mysql_somedb
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : getListOf       : tables
PDO_DataObject   : getListOf       : SHOW TABLES
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : QUERY       : 9c36cac1372650b703400c60dd29042c : SHOW TABLES
getAttribute==[16] => mysql
QUERY: SHOW TABLES  
PDO_DataObject   : query       : NO# of results: 1
Fetch Row 0 / 1
PDO_DataObject   : FETCH       : {"Tables_in_somedb":"Groups"}
Fetch Row 1 / 1
PDO_DataObject   : FETCH       : false
Close Cursor
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : QUERY       : dcae9cad4d5f111b6b2ac65d922aa38f : DESCRIBE Groups
getAttribute==[16] => mysql
QUERY: DESCRIBE Groups  
PDO_DataObject   : query       : NO# of results: 4
Fetch Row 0 / 4
PDO_DataObject   : FETCH       : {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"}
Fetch Row 1 / 4
PDO_DataObject   : FETCH       : {"Field":"name","Type":"varchar(64)","Null":"NO","Key":"","Default":"","Extra":""}
Fetch Row 2 / 4
PDO_DataObject   : FETCH       : {"Field":"type","Type":"int(11)","Null":"YES","Key":"","Default":"0","Extra":""}
Fetch Row 3 / 4
PDO_DataObject   : FETCH       : {"Field":"leader","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
Fetch Row 4 / 4
PDO_DataObject   : FETCH       : false
Close Cursor
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : databaseStructure       : CALL:["mysql_somedb",{"Groups":{"id":129,"name":130,"type":1,"leader":129},"Groups__keys":{"id":"N"}}]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : ERROR       : Could not find INI values for database=mysql_somedb and table=do_not_exist
Exception Thrown: Could not find INI values for database=mysql_somedb and table=do_not_exist
PDO_DataObject   : __construct       : ["do_not_exist\/do_not_exist"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('do_not_exist') : config[databases][do_not_exist] in options
__construct==["mysql:dbname=testdb;host=localhost","user","pass",[]]
Exception Thrown: Fake connection failed to non-existant database