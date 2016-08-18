--TEST--
quoteIdentifiers
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);

PDO_DataObject::config('database','mysql://test@localhost/somedb');
var_dump((new PDO_DataObject())->quoteIdentifier('fred'));

PDO_DataObject::config('database','pgsql://test@localhost/somedb');
var_dump((new PDO_DataObject())->quoteIdentifier('fred'));

PDO_DataObject::config('database','sybase://test@localhost/somedb');
var_dump((new PDO_DataObject())->quoteIdentifier('fred'));

PDO_DataObject::config('database','oci:///mydb');
var_dump((new PDO_DataObject())->quoteIdentifier('fred'));


?>
--EXPECT--
__construct==["mysql:dbname=somedb;host=localhost","test","",[]]
setAttribute==[3,2]
getAttribute==[16] => mysql
string(6) "`fred`"
__construct==["pgsql:dbname=somedb;host=localhost","test","",[]]
setAttribute==[3,2]
getAttribute==[16] => pgsql
string(6) ""fred""
__construct==["sybase:dbname=somedb;host=localhost","test","",[]]
setAttribute==[3,2]
getAttribute==[16] => sybase
string(6) "[fred]"

