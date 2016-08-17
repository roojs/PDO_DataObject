--TEST--
dsn - test various formats of dsn.
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
// Mysql

    

PDO_DataObject::config('database', 'mysql://username:test@localhost:3344/somedb#' . implode( '|',
    array(
        'MYSQL_ATTR_SSL_KEY=/path/to/client-key.pem',
        'MYSQL_ATTR_SSL_CERT=/path/to/client-cert.pem',
        'MYSQL_ATTR_SSL_CA=/path/to/ca-cert.pem',
        
        'MYSQL_ATTR_LOCAL_INFILE=1',
        'MYSQL_ATTR_INIT_COMMAND=2',
       // 'MYSQL_ATTR_READ_DEFAULT_FILE=3',
       //  'MYSQL_ATTR_READ_DEFAULT_GROUP=4',
        'MYSQL_ATTR_MAX_BUFFER_SIZE=5',
        'MYSQL_ATTR_DIRECT_QUERY=6',
        'MYSQL_ATTR_FOUND_ROWS=7',
        'MYSQL_ATTR_IGNORE_SPACE=8',
        'MYSQL_ATTR_COMPRESS=9',
        'MYSQL_ATTR_SSL_CIPHER=10',
        'MYSQL_ATTR_SSL_KEY=11',
        'MYSQL_ATTR_MULTI_STATEMENTS=12',
        
    )));
(new PDO_DataObject())->PDO();

// Postgres

PDO_DataObject::config('database', 'pgsql://nobody:change_me@localhost:3434/example');
(new PDO_DataObject())->PDO();

// postgres (with user/pass in dsn..

PDO_DataObject::config('database', 'pgsql://localhost:3434/example?user=nobody&password=change_me');
(new PDO_DataObject())->PDO();

// SQL server

PDO_DataObject::config('database', 'sqlsrv://test@localhost/somedb');
(new PDO_DataObject())->PDO();
PDO_DataObject::config('database', 'sqlsrv://UserName%4012345abcde:Password@12345abcde.database.windows.net/somedb');
(new PDO_DataObject())->PDO();
PDO_DataObject::config('database', 'sqlsrv://UserName%4012345abcde:Password@(localdb)\\v11.0/somedb?AttachDBFilename=C:\Users\user\my_db.mdf');
(new PDO_DataObject())->PDO();

// Sqlite

PDO_DataObject::config('database', 'sqlite:/opt/databases/mydb.sq3');
(new PDO_DataObject())->PDO();
PDO_DataObject::config('database', 'sqlite::memory:');
(new PDO_DataObject())->PDO();
PDO_DataObject::config('database', 'sqlite2:/opt/databases/mydb.sq2#ATTR_PERSISTENT=1');
(new PDO_DataObject())->PDO();
PDO_DataObject::config('database', 'sqlite2::memory:');
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
