--TEST--
count() test
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
      //*/   
));

PDO_DataObject::debugLevel(0);
 
// used to extract sample data...
//PDO_DataObject::factory('Events')->limit(1)->find(true);

echo "\n\n--------\n";
echo "basic count;\n" ;

$event = PDO_DataObject::factory('Events');
echo "Total rows: {$event->count()}\n";


echo "\n\n--------\n";
echo "count matching properties....);\n" ;

$event = PDO_DataObject::factory('Events');
$event->person_name = 'Alan';
echo "Total rows (with person=Alan): {$event->count()}\n";

echo "\n\n--------\n";
echo "count based on where......);\n" ;

$event = PDO_DataObject::factory('Events');
$event->where('person_id < 20');
echo "Total rows (with person_id < 20): {$event->count(PDO_DataObject::WHERE_ONLY)}\n";



echo "\n\n--------\n";
echo "count distinct;\n" ;

$event = PDO_DataObject::factory('Events');
echo "Total rows (distinct person_name): {$event->count('distinct person_name')}\n";



echo "\n\n--------\n";
echo "count distinct + property;\n" ;

$event = PDO_DataObject::factory('Events');
$event->action = 'RELOAD';
echo "Total rows (distinct person_name) - with action=RELOAD: {$event->count('distinct person_name')}\n";



echo "\n\n--------\n";
echo "sql typo;\n" ;

$event = PDO_DataObject::factory('Events');
$event->action = 'RELOAD';
$event->where('id = > 10000');
try {
    $event->count('distinct person_name');
} catch(PDO_DataObject_Exception_Query $e) {
    echo "Typo got exception as expected : {$e->getMessage()}\n";
}


echo "\n\n--------\n";
echo "count distinct + property + where ;\n" ;

$event = PDO_DataObject::factory('Events');
$event->action = 'RELOAD';
$event->where('id >= 10000');
echo "Total rows (distinct person_name) - with action=RELOAD  where: {$event->count('distinct person_name')}\n";



echo "\n\n--------\n";
echo "count distinct + property + where + WHERE_ONLY ;\n" ;

$event = PDO_DataObject::factory('Events');
$event->action = 'RELOAD';
$event->where('id >= 10000');
echo "Total rows (distinct person_name) - with action=RELOAD  where: {$event->count('distinct person_name', PDO_DataObject::WHERE_ONLY)}\n";


echo "\n\n--------\n";
echo "count zero results. ;\n" ;

$event = PDO_DataObject::factory('Events');
$event->action = 'RELOAD';
$event->where('id < -1');
echo "Total rows (zero results) where: {$event->count(PDO_DataObject::WHERE_ONLY)}\n";





echo "\n\n--------\n";
echo "count after fetch (error) ;\n" ;


$event = PDO_DataObject::factory('Events');
$event->action = 'RELOAD';
$event->limit(3);
$event->fetchAll();
try {
    $event->count();
} catch(PDO_DataObject_Exception_InvalidArgs $e) {
    echo "count after fetch, throws error as expected: {$e->getMessage()}\n";
}


 
 
 
echo "\n\n--------\n";
echo "Test SQLite\n" ;



PDO_DataObject::reset();
PDO_DataObject::config(array(
        'PDO' => 'PDO', // we can do this for real...
        'tables' => array(
            'Customers' => 'EssentialSQL'
        ),
        'databases' => array(
            'EssentialSQL' => 'sqlite:'.__DIR__.'/includes/EssentialSQL.db'
        ),
        'proxy' => 'Full',
        'debug' => 0,
));

PDO_DataObject::factory('Customers')->databaseStructure();

PDO_DataObject::debugLevel(1);

 


echo "\n\n--------\n";
echo "basic count;\n" ;

$Customers = PDO_DataObject::factory('Customers');
echo "Total rows: {$Customers->count()}\n";


echo "\n\n--------\n";
echo "count matching properties....);\n" ;

$Customers = PDO_DataObject::factory('Customers');
$Customers->State='FL';
echo "Total rows (with state=FL): {$Customers->count()}\n";

echo "\n\n--------\n";
echo "count based on where......);\n" ;

$Customers = PDO_DataObject::factory('Customers');
$Customers->where("state in ('FL', 'TX')");
echo "Total rows (with FL or TX): {$Customers->count(PDO_DataObject::WHERE_ONLY)}\n";



echo "\n\n--------\n";
echo "count distinct;\n" ;

$Customers = PDO_DataObject::factory('Customers');
echo "Total rows (distinct state): {$Customers->count('distinct state')}\n";


  


?>
--EXPECT--
--------
basic count;
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:da10443bc8585f7dc122c0bb5c930945:
SELECT count(Events.id) as DATAOBJECT_NUM
                FROM Events  
Total rows: 574675


--------
count matching properties....);
QUERY:47e8ef81ad766bcb6406bbafc65c9a68:
SELECT count(Events.id) as DATAOBJECT_NUM
                FROM Events  WHERE (Events.person_name  = 'Alan')
Total rows (with person=Alan): 4516


--------
count based on where......);
QUERY:6dae8ae5d6c695bb4e18534694646a97:
SELECT count(Events.id) as DATAOBJECT_NUM
                FROM Events  WHERE ( person_id < 20 ) 
Total rows (with person_id < 20): 547179


--------
count distinct;
QUERY:b8e89f17120074c01b0f14f4c0d6af77:
SELECT count(distinct person_name) as DATAOBJECT_NUM
                FROM Events  
Total rows (distinct person_name): 41


--------
count distinct + property;
QUERY:617692175d0901d4d050a9fb4ff199c2:
SELECT count(distinct person_name) as DATAOBJECT_NUM
                FROM Events  WHERE (Events.action  = 'RELOAD')
Total rows (distinct person_name) - with action=RELOAD: 19


--------
sql typo;
QUERY:de2b1352684938007346c359b3406ea9:
SELECT count(distinct person_name) as DATAOBJECT_NUM
                FROM Events  WHERE ( id = > 10000 ) AND (Events.action  = 'RELOAD')
Typo got exception as expected : Could not run Query: dummy sql error


--------
count distinct + property + where ;
QUERY:3aea344ea577bc8c10cd183ac72dad94:
SELECT count(distinct person_name) as DATAOBJECT_NUM
                FROM Events  WHERE ( id >= 10000 ) AND (Events.action  = 'RELOAD')
Total rows (distinct person_name) - with action=RELOAD  where: 16


--------
count distinct + property + where + WHERE_ONLY ;
QUERY:b39eb0824e17aab3aef96a262d2a8b7a:
SELECT count(distinct person_name) as DATAOBJECT_NUM
                FROM Events  WHERE ( id >= 10000 ) 
Total rows (distinct person_name) - with action=RELOAD  where: 38


--------
count zero results. ;
QUERY:fc6b5bd4000b9295f9d2efdf833d5335:
SELECT count(Events.id) as DATAOBJECT_NUM
                FROM Events  WHERE ( id < -1 ) 
Total rows (zero results) where: 0


--------
count after fetch (error) ;
QUERY:8954200ac8480d37239612ab7fe410a3:
SELECT *
 FROM   Events   
 WHERE ( (Events.action  = 'RELOAD') ) 
 LIMIT  3
Fetch Row 0 / 1
Fetch Row 1 / 1
Close Cursor
count after fetch, throws error as expected: You cannot do run count after you have run fetch()


--------
Test SQLite


--------
basic count;
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : 9d3e7ecc7ac70671316cfe4cfdb42db1 : SELECT count(Customers.CustomerID) as DATAOBJECT_NUM
                FROM Customers  
PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : count       : Count returned 5
Total rows: 5


--------
count matching properties....);
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : 58201c0ee2b824c542628d084a9b4662 : SELECT count(Customers.CustomerID) as DATAOBJECT_NUM
                FROM Customers  WHERE (Customers.State  = 'FL')
PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : count       : Count returned 1
Total rows (with state=FL): 1


--------
count based on where......);
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : 89dd46447e29fc19a6c9062de946e1b0 : SELECT count(Customers.CustomerID) as DATAOBJECT_NUM
                FROM Customers  WHERE ( state in ('FL', 'TX') ) 
PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : count       : Count returned 2
Total rows (with FL or TX): 2


--------
count distinct;
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : b6c610edea2b86c03c56bcfdb19c8656 : SELECT count(distinct state) as DATAOBJECT_NUM
                FROM Customers  
PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : count       : Count returned 5
Total rows (distinct state): 5