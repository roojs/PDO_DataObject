--TEST--
update() test
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
echo "basic update;\n" ;

$event = PDO_DataObject::factory('Events');
$event->get(12);
$event->action = "testing";
echo "UPDATED {$event->update()} records\n";


echo "\n\n--------\n";
echo "update (changed columns);\n" ;

$event = PDO_DataObject::factory('Events');
$event->get(12);
$old = clone($event);
$event->action = "testing";
echo "UPDATED {$event->update($old)} records\n";


echo "\n\n--------\n";
echo "update (nothing changed);\n" ;

$event = PDO_DataObject::factory('Events');
$event->get(12);
$old = clone($event);
echo "UPDATED {$event->update($old)} records\n";


echo "\n\n--------\n";
echo "bulk update using where (wrong usage);\n" ;

$event = PDO_DataObject::factory('Events');
$event->action="ssss";
try {
     $event->update(PDO_DataObject::WHEREADD_ONLY);
} catch(PDO_DataObject_Exception_InvalidArgs $e) {
    echo "Throws exception as expected: {$e->getMessage()}\n";
}



echo "\n\n--------\n";
echo "bulk update using where  ;\n" ;

$event = PDO_DataObject::factory('Events');
$event->action="ssss";
$event->where('id >15 and id < 20');
$rows = $event->update(PDO_DataObject::WHEREADD_ONLY);

echo "UPDATED {$rows} records\n";
 
echo "\n\n--------\n";
echo "empty insert (postgresql);\n" ;
PDO_DataObject::config('database' , 'pgsql://user:pass@localhost/pginsert');
    // real db...

$event = PDO_DataObject::factory('Events');

$id = $event->insert();
var_dump($id);
print_r($event->toArray());

 

echo "\n\n--------\n";
echo "Test SQLite  update - empty\n" ;

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
$Customers->get(2);
print_r($Customers->toArray());
$Customers->set(array(
    'CompanyName' => 'test1',
    'ContactName' => 'test2',

));
$Customers->update();
print_r($Customers->toArray());




echo "\n\n--------\n";
echo "Test SQLite  update - with old.\n" ;




$Customers = PDO_DataObject::factory('Customers');
$Customers->get(3);
$old = clone($Customers);
print_r($Customers->toArray());
$Customers->set(array(
    'CompanyName' => 'test1',
    'ContactName' => 'test2',

));
$Customers->update($old);
print_r($Customers->toArray());




unlink($temp);



?>
--EXPECT--
--------
basic update;
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:2bdf264b81e628acfbf68368a1175be6:
SELECT *
 FROM   Events   
 WHERE ( (Events.id = 12) ) 

QUERY:b2a4eb0dec91cfe1617857e5cf0eda5c:
UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 12) 
UPDATED 1 records


--------
update (changed columns);
QUERY:2bdf264b81e628acfbf68368a1175be6:
SELECT *
 FROM   Events   
 WHERE ( (Events.id = 12) ) 

QUERY:b2a4eb0dec91cfe1617857e5cf0eda5c:
UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 12) 
UPDATED 1 records


--------
update (nothing changed);
QUERY:2bdf264b81e628acfbf68368a1175be6:
SELECT *
 FROM   Events   
 WHERE ( (Events.id = 12) ) 

UPDATED 1 records


--------
bulk update using where (wrong usage);
Throws exception as expected: updating all records in a table is not enabled by default, use $do->whereAdd('1=1'); if you really want to do that.


--------
bulk update using where  ;
QUERY:a6282b3421edef2d12c5aa79b5c3ea77:
UPDATE  Events  SET action = 'ssss'  WHERE ( id >15 and id < 20 )  
UPDATED 3 records


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
Test SQLite  update - empty
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : get       : ('CustomerID', 2) keys= Array
(
    [0] => CustomerID
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 2ee20b35241ab34768d20c8f10e8510d : SELECT *
 FROM   Customers   
 WHERE ( (Customers.CustomerID = 2) ) 

PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"CustomerID":"2","CompanyName":"Sagebrush Carpet","ContactName":"Barbara Berber","ContactTitle":"Director of Installations","Address":"10 Industrial Drive","City":"El Paso","State":"TX"}
PDO_DataObject   : find       : DONE
Array
(
    [CustomerID] => 2
    [CompanyName] => Sagebrush Carpet
    [ContactName] => Barbara Berber
    [ContactTitle] => Director of Installations
    [Address] => 10 Industrial Drive
    [City] => El Paso
    [State] => TX
)
PDO_DataObject   : query       : e62d517cdee81be4d67df04a5fdcc63d : UPDATE  Customers  SET CompanyName = 'test1' , ContactName = 'test2'  WHERE (Customers.CustomerID = 2) 
PDO_DataObject   : query       : NO# of results: Unknown
Array
(
    [CustomerID] => 2
    [CompanyName] => test1
    [ContactName] => test2
    [ContactTitle] => Director of Installations
    [Address] => 10 Industrial Drive
    [City] => El Paso
    [State] => TX
)


--------
Test SQLite  update - with old.
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : get       : ('CustomerID', 3) keys= Array
(
    [0] => CustomerID
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : d59a6682883acfa372854db08a88caf2 : SELECT *
 FROM   Customers   
 WHERE ( (Customers.CustomerID = 3) ) 

PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"CustomerID":"3","CompanyName":"Floor Co.","ContactName":"Jim Wood","ContactTitle":"Installer","Address":"34218 Private Lane","City":"Monclair","State":"NJ"}
PDO_DataObject   : find       : DONE
Array
(
    [CustomerID] => 3
    [CompanyName] => Floor Co.
    [ContactName] => Jim Wood
    [ContactTitle] => Installer
    [Address] => 34218 Private Lane
    [City] => Monclair
    [State] => NJ
)
PDO_DataObject   : query       : a66b273860037f83132521bbfa541f35 : UPDATE  Customers  SET CompanyName = 'test1' , ContactName = 'test2'  WHERE (Customers.CustomerID = 3) 
PDO_DataObject   : query       : NO# of results: Unknown
Array
(
    [CustomerID] => 3
    [CompanyName] => test1
    [ContactName] => test2
    [ContactTitle] => Installer
    [Address] => 34218 Private Lane
    [City] => Monclair
    [State] => NJ
)