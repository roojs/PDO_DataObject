--TEST--
Modify Limit Query
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
        'oracle_somedb' => 'oci://somedb',
    ),
    'schema_location' => array(
        'mysql_somedb' =>  __DIR__ .'/includes/mysql_somedb.ini',
        'pgsql_somedb' =>  __DIR__ .'/includes/mysql_somedb.ini',
        'sqlite_somedb'=>  __DIR__ .'/includes/mysql_somedb.ini',
        'oracle_somedb'=>  __DIR__ .'/includes/mysql_somedb.ini',
    ),
));

var_dump((new PDO_DataObject('mysql_somedb/account_code'))
    ->limit(40)
    ->modifyLimitQuery("SELECT * FROM TEST")
);
var_dump((new PDO_DataObject('mysql_somedb/account_code'))
    ->limit(10,4)
    ->modifyLimitQuery("SELECT * FROM TEST")
);

var_dump((new PDO_DataObject('pgsql_somedb/account_code'))
    ->limit(40)
    ->modifyLimitQuery("SELECT * FROM TEST")
);

var_dump((new PDO_DataObject('pgsql_somedb/account_code'))
    ->limit(10,4)
    ->modifyLimitQuery("SELECT * FROM TEST")
);


var_dump((new PDO_DataObject('oracle_somedb/account_code'))
    ->limit(40)
    ->modifyLimitQuery("SELECT * FROM TEST")
);

var_dump((new PDO_DataObject('oracle_somedb/account_code'))
    ->limit(10,4)
    ->modifyLimitQuery("SELECT * FROM TEST")
);

//--- the tests below can use the real driver...


PDO_DataObject::config('PDO','PDO');
var_dump((new PDO_DataObject('sqlite_somedb/account_code'))
    ->limit(40)
    ->modifyLimitQuery("SELECT * FROM TEST")
);

var_dump((new PDO_DataObject('sqlite_somedb/account_code'))
    ->limit(10,4)
    ->modifyLimitQuery("SELECT * FROM TEST")
);









--EXPECT--
PDO_DataObject   : __construct       : ["mysql_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_somedb') : config[databases][mysql_somedb] in options
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
string(28) "SELECT * FROM TEST LIMIT  40"
PDO_DataObject   : __construct       : ["mysql_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_somedb') : config[databases][mysql_somedb] in options
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
string(30) "SELECT * FROM TEST LIMIT 10, 4"
PDO_DataObject   : __construct       : ["pgsql_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('pgsql_somedb') : config[databases][pgsql_somedb] in options
__construct==["pgsql:dbname=example;host=localhost;port=3434","nobody","change_me",[]]
setAttribute==[3,2]
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
string(36) "SELECT * FROM TEST LIMIT 40 OFFSET 0"
PDO_DataObject   : __construct       : ["pgsql_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('pgsql_somedb') : config[databases][pgsql_somedb] in options
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
string(36) "SELECT * FROM TEST LIMIT 4 OFFSET 10"
PDO_DataObject   : __construct       : ["sqlite_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('sqlite_somedb') : config[databases][sqlite_somedb] in options
PDO_DataObject   : PDO       : Using Cached connection
string(36) "SELECT * FROM TEST LIMIT 40 OFFSET 0"
PDO_DataObject   : __construct       : ["sqlite_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('sqlite_somedb') : config[databases][sqlite_somedb] in options
PDO_DataObject   : PDO       : Using Cached connection
string(36) "SELECT * FROM TEST LIMIT 4 OFFSET 10"