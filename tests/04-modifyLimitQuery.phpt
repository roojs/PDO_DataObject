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
    ),
    'schema_location' => array(
        'mysql_somedb' =>  __DIR__ .'/includes/mysql_somedb.ini',
        'pgsql_somedb' =>  __DIR__ .'/includes/mysql_somedb.ini',
        'sqlite_somedb'=>  __DIR__ .'/includes/mysql_somedb.ini',
    ),
));

var_dump((new PDO_DataObject('mysql_somedb/account_code'))
    ->limit(10,4)
    ->modifyLimitQuery("SELECT * FROM TEST")
);
var_dump((new PDO_DataObject('pgsql_somedb/account_code'))
    ->limit(10,4)
    ->modifyLimitQuery("SELECT * FROM TEST")
);

PDO_DataObject::config('PDO','PDO');
var_dump((new PDO_DataObject('sqlite_somedb/account_code'))
    ->limit(10,4)
    ->modifyLimitQuery("SELECT * FROM TEST")
);
--EXPECT--