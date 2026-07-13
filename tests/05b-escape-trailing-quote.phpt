--TEST--
escape() must not over-strip wrapper quotes from PDO::quote()
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);

PDO_DataObject::config(array(
    'databases' => array(
        'mysql_somedb' =>  'mysql://username:test@localhost:3344/somedb#',
    ),
    'schema_location' => array(
        'mysql_somedb' =>  __DIR__ .'/includes/mysql_somedb.ini',
    ),
));

$do = new PDO_DataObject('mysql_somedb/account_code');

var_dump($do->escape("x'"));
var_dump($do->escape("'"));
var_dump($do->escape("Mc'Donalds"));
--EXPECT--
PDO_DataObject   : __construct       : ["mysql_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_somedb') : config[databases][mysql_somedb] in options
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
string(3) "x\\'"
string(2) "\\'"
string(11) "Mc\\'Donalds"
