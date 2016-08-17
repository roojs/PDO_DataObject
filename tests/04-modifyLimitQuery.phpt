--TEST--
Modify Limit Query
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
// Mysql

    

PDO_DataObject::config('databases' => array(
        'mysql_somedb' =>  'mysql://username:test@localhost:3344/somedb#',
        'pgsql_somedb' => 'pgsql://nobody:change_me@localhost:3434/example',
        'sqlite_somedb'='sqlite:'.__DIR__.'/includes/EssentialSQL.db',
));

var_dump((new PDO_DataObject('mysql_somedb/Companies'))
    ->limit(10,4)
    ->modifyLimitQuery("SELECT * FROM TEST")
);
var_dump((new PDO_DataObject('pgsql_somedb/Companies'))
    ->limit(10,4)
    ->modifyLimitQuery("SELECT * FROM TEST")
);
var_dump((new PDO_DataObject('sqlite_somedb/Companies'))
    ->limit(10,4)
    ->modifyLimitQuery("SELECT * FROM TEST")
);
