--TEST--
setFrom / set Test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest'
      
));

PDO_DataObject::debugLevel(0);
 

echo "\n\n--------\n";
echo "sqlValue - basic Raw;\n" ;

echo PDO_DataObject::factory('Events')
    ->set(['action' => PDO_DataObject::sqlValue('NOW()') ])
    ->whereToString();

echo "\n\n--------\n";
echo "sqlValue - various values..;\n" ;

echo PDO_DataObject::factory('Dummy')
    ->set([
        'ex_blob' => PDO_DataObject::sqlValue('blob','a long piece of data'),
        'ex_string' => PDO_DataObject::sqlValue('string', 123123),
        'ex_sql' => PDO_DataObject::sqlValue('sql', 'NOW()'),
        'ex_date' => PDO_DataObject::sqlValue('date', '2000-01-01'),
        'ex_datetime' => PDO_DataObject::sqlValue('dateTime', '2000-01-01 10:00:00'),
        'ex_time' => PDO_DataObject::sqlValue('time', '10:00:00'),        
    ])
    ->whereToString();

echo "\n\n--------\n";
echo "sqlValue - datetime to other types..;\n" ;
// test other crosses.. probably throwing errors..
echo PDO_DataObject::factory('Dummy')
    ->set([
        
        'ex_date' => PDO_DataObject::sqlValue('datetime', '2000-01-01 10:00:00'),
        'ex_datetime' => PDO_DataObject::sqlValue('dateTime', '2000-01-01 10:00:00'),
        'ex_time' => PDO_DataObject::sqlValue('dateTime',  '2000-01-01 10:00:00'),        
    ])
    ->whereToString();    

echo "\n\n--------\n";
echo "sqlValue - date to other types..;\n" ;

echo PDO_DataObject::factory('Dummy')
    ->set([
        
        'ex_date' => PDO_DataObject::sqlValue('date', '2000-01-01'),
        'ex_datetime' => PDO_DataObject::sqlValue('date', '2000-01-01'),
    ])
    ->whereToString();    
    
    
//=== test on pgsql.. for blobs.

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'pgsql://user:pass@localhost/pginsert'
       
));
echo "\n\n--------\n";
echo "sqlValue - Postgresql..;\n" ;

echo PDO_DataObject::factory('Dummy')
    ->set([
        'ex_blob' => PDO_DataObject::sqlValue('blob','a long piece of data'),
        'ex_string' => PDO_DataObject::sqlValue('string', 123123),
        'ex_sql' => PDO_DataObject::sqlValue('sql', 'NOW()'),
        'ex_date' => PDO_DataObject::sqlValue('date', '2000-01-01'),
        'ex_datetime' => PDO_DataObject::sqlValue('dateTime', '2000-01-01 10:00:00'),
        'ex_time' => PDO_DataObject::sqlValue('time', '10:00:00'),
        
    ])
    ->whereToString();

echo "\nbool test: " . PDO_DataObject::factory('Dummy')
    ->set([ 'ex_pgbool' => true ])
    ->whereToString();

echo "\nbool test: " . PDO_DataObject::factory('Dummy')
    ->set([ 'ex_pgbool' => false ])
    ->whereToString();

echo "\nbool test: " . PDO_DataObject::factory('Dummy')
    ->set([ 'ex_pgbool' => 't' ])
    ->whereToString();

echo "\nbool test: " . PDO_DataObject::factory('Dummy')
    ->set([ 'ex_pgbool' => 'f' ])
    ->whereToString();

echo "\nbool test: " . PDO_DataObject::factory('Dummy')
    ->set([ 'ex_pgbool' => 1 ])
    ->whereToString();

echo "\nbool test: " . PDO_DataObject::factory('Dummy')
    ->set([ 'ex_pgbool' => 0 ])
    ->whereToString();

echo "\nbool test: " . PDO_DataObject::factory('Dummy')
    ->set([ 'ex_pgbool' => '1' ])
    ->whereToString();

echo "\nbool test: " . PDO_DataObject::factory('Dummy')
    ->set([ 'ex_pgbool' => '0' ])
    ->whereToString();


echo "\n\n--------\n";
echo "sqlValue - Date time invalid..;\n" ;

try {
PDO_DataObject::factory('Dummy')
    ->set([ 'ex_datetime' => true ]);
 } catch (PDO_DataObject_Exception_Set $e) {
    echo "Setting a date field to a boolean throws an error... as expected : " . $e->getMessage(); 
 }
?>
--EXPECT--
--------
sqlValue - basic Raw;
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
 Events.action = NOW()

--------
sqlValue - various values..;
string(3) "140"
 Dummy.ex_blob = 'a long piece of data' AND  Dummy.ex_string = '123123' AND  Dummy.ex_date = '2000-01-01' AND  Dummy.ex_datetime = '2000-01-01 10:00:00' AND  Dummy.ex_time = '10:00:00' AND  Dummy.ex_sql = NOW()

--------
sqlValue - datetime to other types..;
string(3) "132"
string(3) "140"
string(3) "136"
 Dummy.ex_date = '2000-01-01' AND  Dummy.ex_datetime = '2000-01-01 10:00:00' AND  Dummy.ex_time = '2000:01:01'

--------
sqlValue - date to other types..;
 Dummy.ex_date = '2000-01-01' AND  Dummy.ex_datetime = '2000-01-01 00:00:00'

--------
sqlValue - Postgresql..;
__construct==["pgsql:dbname=pginsert;host=localhost","user","pass",[]]
setAttribute==[3,2]
string(3) "140"
 Dummy.ex_blob = 'a long piece of data3'::bytea AND  Dummy.ex_string = '123123' AND  Dummy.ex_date = '2000-01-01' AND  Dummy.ex_datetime = '2000-01-01 10:00:00' AND  Dummy.ex_time = '10:00:00' AND  Dummy.ex_sql = NOW()
bool test: (Dummy.ex_pgbool  = '1')
bool test: (Dummy.ex_pgbool  = '0')
bool test: (Dummy.ex_pgbool  = '1')
bool test: (Dummy.ex_pgbool  = '0')
bool test: (Dummy.ex_pgbool  = '1')
bool test: (Dummy.ex_pgbool  = '0')
bool test: (Dummy.ex_pgbool  = '1')
bool test: (Dummy.ex_pgbool  = '0')

--------
sqlValue - Date time invalid..;
Setting a date field to a boolean throws an error... as expected : Set Errors Returned Values