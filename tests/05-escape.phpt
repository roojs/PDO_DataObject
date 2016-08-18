--TEST--
Basic 'quote/escape testing'
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
// Mysql

    

PDO_DataObject::config(array(
    'databases' => array(
        'mysql_somedb' =>  'mysql://username:test@localhost:3344/somedb#',
        'pgsql_somedb' => 'pgsql://nobody:change_me@localhost:3434/example',
        'sqlite_somedb'=> 'sqlite:'.__DIR__.'/includes/EssentialSQL.db',
    ),
    'schema_location' => array(
        'mysql_somedb' =>  __DIR__ .'/includes/mysql_somedb.ini',
        'pgsql_somedb' =>  __DIR__ .'/includes/mysql_somedb.ini',
        'sqlite_somedb'=>  __DIR__ .'/includes/mysql_somedb.ini',
    ),
));

var_dump((new PDO_DataObject('mysql_somedb/account_code'))
    ->escape("Mc'Donalds")
);
var_dump((new PDO_DataObject('pgsql_somedb/account_code'))
    ->escape("Mc'Donalds")
);


PDO_DataObject::config('PDO','PDO');
var_dump((new PDO_DataObject('sqlite_somedb/account_code'))
    ->escape("Mc'Donalds")
);
--EXPECT--
PDO_DataObject   : __construct       : ["mysql_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_somedb') : config[databases][mysql_somedb] in options
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : PDO       : Using Cached connection
string(11) "Mc\'Donalds"
PDO_DataObject   : __construct       : ["pgsql_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('pgsql_somedb') : config[databases][pgsql_somedb] in options
__construct==["pgsql:dbname=example;host=localhost;port=3434","nobody","change_me",[]]
setAttribute==[3,2]
PDO_DataObject   : PDO       : Using Cached connection
string(11) "Mc\'Donalds"
PDO_DataObject   : __construct       : ["sqlite_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('sqlite_somedb') : config[databases][sqlite_somedb] in options
PDO_DataObject   : PDO       : Using Cached connection
string(11) "Mc''Donalds"
