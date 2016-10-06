--TEST--
insert() test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
    
         'database' => 'mysql://user:pass@localhost/inserttest'
    // real db...
    /*
        'database' => '',
        'tables' => array(
            'Events'=> 'inserttest',
        ),
        'databases' => array(
            'inserttest' => 'mysql://root:@localhost/pman',
        ),
         'PDO' => 'PDO',
         */
));

PDO_DataObject::debugLevel(0);
 

echo "\n\n--------\n";
echo "empty insert;\n" ;

$event = PDO_DataObject::factory('Events');

$id = $event->insert();
var_dump($id);
print_r($event->toArray());


echo "\n\n--------\n";
echo "empty insert (postgresql);\n" ;
PDO_DataObject::config('database' , 'pgsql://user:pass@localhost/pginsert');
    // real db...

$event = PDO_DataObject::factory('Events');

$id = $event->insert();
var_dump($id);
print_r($event->toArray());



echo "\n\n--------\n";
echo "insert with data;\n" ;
PDO_DataObject::config('database' , 'mysql://user:pass@localhost/inserttest');

$event = PDO_DataObject::factory('Events');
$event ->set(array(
    'person_name' => 'fred',
    'event_when' => '2016-10-03 13:58:06',
    'action' => 'TEST',
    'ip' => '127.0.0.1',
    'on_id' => 0,
    'on_table' => '',
    'remarks' => 'a test event',

));
$id = $event->insert();
var_dump($id);
print_r($event->toArray());















echo "\n\n--------\n";
echo "Test SQLite  insert - empty\n" ;

$temp  = tempnam(ini_get('session.save-path'), 'sqlite-test');
copy(__DIR__.'/includes/EssentialSQL.db', $temp);

PDO_DataObject::reset();
PDO_DataObject::config(array(
        'PDO' => 'PDO', // we can do this for real...
        'tables' => array(
            'Customers' => 'EssentialSQL'
        ),
        'databases' => array(
            'EssentialSQL' => 'sqlite:'.$temp
        ),
        'proxy' => 'Full',
        'debug' => 0,
));

PDO_DataObject::factory('Customers')->databaseStructure();

PDO_DataObject::debugLevel(1);
$Customers = PDO_DataObject::factory('Customers');
 
$id = $Customers->insert();
var_dump($id);
print_r($Customers->toArray());

echo "\n\n--------\n";
echo "Test SQLite  insert with data;\n" ;

 

$Customers = PDO_DataObject::factory('Customers');
$Customers->set(array(
    'CompanyName' => 'test1',
    'ContactName' => 'test2',

));
$id = $Customers->insert();
var_dump($id);
print_r($Customers->toArray());

PDO_DataObject::reset();

unlink($temp);



?>
--EXPECT--
--------
empty insert;
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:5f82f3a2da7afaa78228444fbcba3e37:
INSERT INTO Events () VALUES () 
lastInsertId from sequence=''  is 123123
int(123123)
Array
(
    [id] => 123123
    [person_name] => 
    [event_when] => 
    [action] => 
    [ipaddr] => 
    [on_id] => 
    [on_table] => 
    [person_id] => 
    [person_table] => 
    [remarks] => 
)


--------
empty insert (postgresql);
__construct==["pgsql:dbname=pginsert;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:b641522a3fbae38828891f330aeb7313:
INSERT INTO Events DEFAULT VALUES
lastInsertId from sequence='id_sequence'  is 43434
int(43434)
Array
(
    [id] => 43434
    [person_name] => 
    [event_when] => 
    [action] => 
    [ipaddr] => 
    [on_id] => 
    [on_table] => 
    [person_id] => 
    [person_table] => 
    [remarks] => 
)


--------
insert with data;
QUERY:628879af4d41c471483702443eb35560:
INSERT INTO Events (person_name , event_when , action , on_id , on_table , remarks ) VALUES ('fred' , '2016-10-03 13:58:06' , 'TEST' ,  0 , '' , 'a test event' ) 
lastInsertId from sequence=''  is 34343
int(34343)
Array
(
    [id] => 34343
    [person_name] => fred
    [event_when] => 2016-10-03 13:58:06
    [action] => TEST
    [ipaddr] => 
    [on_id] => 0
    [on_table] => 
    [person_id] => 
    [person_table] => 
    [remarks] => a test event
)


--------
Test SQLite  insert - empty
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : fb46160d204b8d7f7d32c5dc9f8e8135 : INSERT INTO Customers DEFAULT VALUES
PDO_DataObject   : query       : NO# of results: Unknown
string(1) "6"
Array
(
    [CustomerID] => 6
    [CompanyName] => 
    [ContactName] => 
    [ContactTitle] => 
    [Address] => 
    [City] => 
    [State] => 
)


--------
Test SQLite  insert with data;
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : 45f2d3ea1493f222b65c8d64a148531c : INSERT INTO Customers (CompanyName , ContactName ) VALUES ('test1' , 'test2' ) 
PDO_DataObject   : query       : NO# of results: Unknown
string(1) "7"
Array
(
    [CustomerID] => 7
    [CompanyName] => test1
    [ContactName] => test2
    [ContactTitle] => 
    [Address] => 
    [City] => 
    [State] => 
)