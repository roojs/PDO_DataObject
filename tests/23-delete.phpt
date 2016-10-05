--TEST--
delete() test
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
 
// used to extract sample data...
//PDO_DataObject::factory('Events')->limit(1)->find(true);

echo "\n\n--------\n";
echo "basic delete;\n" ;

$event = PDO_DataObject::factory('Events');
$event->get(12);
$res = $event->delete();
echo "DELETED {$res} records\n";


echo "\n\n--------\n";
echo "delete where....);\n" ;

$event = PDO_DataObject::factory('Events');
$event->where('id > 12');
$res = $event->delete(PDO_DAtaObject::WHERE_ONLY);
echo "DELETED {$res} records\n";



echo "\n\n--------\n";
echo "delete where, without flag....);\n" ;

$event = PDO_DataObject::factory('Events');
try {
    $event->where('id > 12');
    $event->delete();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "failed as expected : " . $e->getMessage();
}


echo "\n\n--------\n";
echo "delete all?....);\n" ;

$event = PDO_DataObject::factory('Events');
try {
    $event->delete();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "failed as expected : " . $e->getMessage();
}
// should throw error..

 
// joined????  
 
 
 
 

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

 

 
echo "\n\n--------\n";
echo "Test SQLite  delete single\n" ;
$Customers = PDO_DataObject::factory('Customers');
$Customers->get(2);
$Customers->delete();

$Customers = PDO_DataObject::factory('Customers');
if (!$Customers->get(2)) {
    echo "id=2 has been deleted as expected\n";
}




echo "\n\n--------\n";
echo "Test SQLite  delete where .\n" ;



echo "There is ". PDO_DataObject::factory('Customers')->count() ." records\n";
PDO_DataObject::factory('Customers')
        ->where("CustomerID > 2")->delete(PDO_DataObject::WHEREADD_ONLY);

echo "There are now only ". PDO_DataObject::factory('Customers')->count() ." records\n";





unlink($temp);



?>
--EXPECT--
--------
basic delete;
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:2bdf264b81e628acfbf68368a1175be6:
SELECT *
 FROM   Events   
 WHERE ( (Events.id = 12) ) 

QUERY:c3b86f332b94f57d9d3008b059b2a1f7:
DELETE FROM Events WHERE (Events.id = 12) 
DELETED 1 records


--------
delete where....);
QUERY:e0f63974357eab3b7b082f80cf5c26aa:
DELETE FROM Events WHERE ( id > 12 )  
DELETED 10 records


--------
delete where, without flag....);
failed as expected : deleting all data from database is disabled by default, use where('1=1') if your really want to do that.

--------
delete all?....);
failed as expected : deleting all data from database is disabled by default, use where('1=1') if your really want to do that.

--------
Test SQLite  delete single
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : get       : CustomerID 2 Array
(
    [0] => CustomerID
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 2ee20b35241ab34768d20c8f10e8510d : SELECT *
 FROM   Customers   
 WHERE ( (Customers.CustomerID = 2) ) 

PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"CustomerID":"2","CompanyName":"Sagebrush Carpet","ContactName":"Barbara Berber","ContactTitle":"Director of Installations","Address":"10 Industrial Drive","City":"El Paso","State":"TX"}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : b638ac545f0ca96fbbc8ea538f5908b5 : DELETE FROM Customers WHERE (Customers.CustomerID = 2) 
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : get       : CustomerID 2 Array
(
    [0] => CustomerID
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 2ee20b35241ab34768d20c8f10e8510d : SELECT *
 FROM   Customers   
 WHERE ( (Customers.CustomerID = 2) ) 

PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : false
PDO_DataObject   : find       : DONE
id=2 has been deleted as expected


--------
Test SQLite  delete where .
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : 9d3e7ecc7ac70671316cfe4cfdb42db1 : SELECT count(Customers.CustomerID) as DATAOBJECT_NUM
                FROM Customers  
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : count       : Count returned 4
There is 4 records
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : 7068b0ce4990031ff71d3618eb0d34af : DELETE FROM Customers WHERE ( CustomerID > 2 )  
PDO_DataObject   : query       : NO# of results: 3
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : 9d3e7ecc7ac70671316cfe4cfdb42db1 : SELECT count(Customers.CustomerID) as DATAOBJECT_NUM
                FROM Customers  
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : count       : Count returned 1
There are now only 1 records