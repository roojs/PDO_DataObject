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
        'sqlite_somedb']='sqlite:'.__DIR__.'/includes/EssentialSQL.db',
));

var_dump  (new PDO_DataObject('mysql_somedb/Companies'))->limit(10,4)->modifyLimitQuery("SELECT * FROM TEST");
var_dump  (new PDO_DataObject('mysql_somedb/Companies'))->limit(10,4)->modifyLimitQuery("SELECT * FROM TEST");

// Postgres

PDO_DataObject::$config['database']='pgsql://nobody:change_me@localhost:3434/example';
(new PDO_DataObject())->PDO();

// postgres (with user/pass in dsn..

PDO_DataObject::$config['database']='pgsql://localhost:3434/example?user=nobody&password=change_me';
(new PDO_DataObject())->PDO();

// SQL server

PDO_DataObject::$config['database']='sqlsrv://test@localhost/somedb';
(new PDO_DataObject())->PDO();
PDO_DataObject::$config['database']='sqlsrv://UserName%4012345abcde:Password@12345abcde.database.windows.net/somedb';
(new PDO_DataObject())->PDO();
PDO_DataObject::$config['database']='sqlsrv://UserName%4012345abcde:Password@(localdb)\\v11.0/somedb?AttachDBFilename=C:\Users\user\my_db.mdf';
(new PDO_DataObject())->PDO();

// Sqlite

PDO_DataObject::$config['database']='sqlite:/opt/databases/mydb.sq3';
(new PDO_DataObject())->PDO();
PDO_DataObject::$config['database']='sqlite::memory:';
(new PDO_DataObject())->PDO();
PDO_DataObject::$config['database']='sqlite2:/opt/databases/mydb.sq2#ATTR_PERSISTENT=1';
(new PDO_DataObject())->PDO();
PDO_DataObject::$config['database']='sqlite2::memory:';
(new PDO_DataObject())->PDO();
 


?>
--EXPECT--
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",{"1007":"11","1008":"\/path\/to\/client-cert.pem","1009":"\/path\/to\/ca-cert.pem","1001":"1","1002":"2","0":"5","1004":"6","1005":"7","1006":"8","1003":"9","1011":"10","1013":"12"}]
setAttribute==[3,2]
__construct==["pgsql:dbname=example;host=localhost;port=3434","nobody","change_me",[]]
setAttribute==[3,2]
__construct==["pgsql:dbname=example;host=localhost;port=3434;user=nobody;password=change_me","","",[]]
setAttribute==[3,2]
__construct==["sqlsrv:Database=somedb;Server=localhost","test","",[]]
setAttribute==[3,2]
__construct==["sqlsrv:Database=somedb;Server=12345abcde.database.windows.net","UserName@12345abcde","Password",[]]
setAttribute==[3,2]
__construct==["sqlsrv:Database=somedb;Server=(localdb)\\v11.0;AttachDBFilename=C:\\Users\\user\\my_db.mdf","UserName@12345abcde","Password",[]]
setAttribute==[3,2]
__construct==["sqlite:\/opt\/databases\/mydb.sq3","","",[]]
setAttribute==[3,2]
__construct==["sqlite::memory:","","",[]]
setAttribute==[3,2]
__construct==["sqlite2:\/opt\/databases\/mydb.sq2","","",{"12":"1"}]
setAttribute==[3,2]
__construct==["sqlite2::memory:","","",[]]
setAttribute==[3,2]
