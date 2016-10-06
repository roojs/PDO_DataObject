--TEST--
tranaction Test 
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest',
        'class_prefix' => 'DataObjects_',
));

PDO_DataObject::debugLevel(1);
 
// these need the links to calculate the join..
echo "\n---\nFetch a related link.n";

PDO_DataObject::factory('Events')
    ->query("BEGIN")
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    ->query("COMMIT");


PDO_DataObject::factory('Events')
    ->query("BEGIN")
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    ->query("ROLLBACK");




echo "\n\n--------\n";
echo "Test SQLite  ROLLBACK DOES NOT WORK HERE !!!!\n" ;

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
        'transactions' => false,  ///<<< have to add this in otherwise PDO will give us errors 'correctly'
));

PDO_DataObject::factory('Customers')->databaseStructure();

PDO_DataObject::debugLevel(1);
PDO_DataObject::factory('Customers')
    ->query("BEGIN")
    ->load(1)
    ->set(['CompanyName' => "test2" ])
    ->save()
    ->query("COMMIT");

print_r(
    PDO_DataObject::factory('Customers')
        ->load(1)
        ->toArray()
);

PDO_DataObject::factory('Customers')
    ->query("BEGIN")
    ->load(1)
    ->set(['CompanyName' => "test4" ])
    ->save()
    ->query("ROLLBACK");

print_r(
    PDO_DataObject::factory('Customers')
        ->load(1)
        ->toArray()
);



    
unlink($temp);

?>
--EXPECT--
---
Fetch a related link.n__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
PDO_DataObject   : query       : 19aad9f2fe3ce0023298ab83f7e75775 : BEGIN
PDO_DataObject   : query       : BEGIN
setAttribute==[0,false]
PDO_Dummy::beginTransaction
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : get       : ('id', 3523) keys= Array
(
    [0] => id
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 183b4035a4a59e23b849e6bdd8a53fdb : SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

QUERY:183b4035a4a59e23b849e6bdd8a53fdb:
SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 1
PDO_DataObject   : fetch       : {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : 9da43100ad8e2d1eee0cfee396c16588 : UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3523) 
QUERY:9da43100ad8e2d1eee0cfee396c16588:
UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3523) 
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : query       : 1d0ba376e273b9d622641124d8c59264 : COMMIT
PDO_DataObject   : query       : COMMIT
PDO_Dummy::commit
setAttribute==[0,true]
PDO_DataObject   : query       : 19aad9f2fe3ce0023298ab83f7e75775 : BEGIN
PDO_DataObject   : query       : BEGIN
setAttribute==[0,false]
PDO_Dummy::beginTransaction
PDO_DataObject   : get       : ('id', 3523) keys= Array
(
    [0] => id
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 183b4035a4a59e23b849e6bdd8a53fdb : SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

QUERY:183b4035a4a59e23b849e6bdd8a53fdb:
SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 1
PDO_DataObject   : fetch       : {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : 9da43100ad8e2d1eee0cfee396c16588 : UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3523) 
QUERY:9da43100ad8e2d1eee0cfee396c16588:
UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3523) 
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : query       : 2805522dd41e1b57da11967ac5fa258c : ROLLBACK
PDO_DataObject   : query       : ROLLBACK
PDO_Dummy::rollback
setAttribute==[0,true]


--------
Test SQLite  ROLLBACK DOES NOT WORK HERE !!!!
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : 19aad9f2fe3ce0023298ab83f7e75775 : BEGIN
PDO_DataObject   : query       : BEGIN--IGNORED
PDO_DataObject   : get       : ('CustomerID', 1) keys= Array
(
    [0] => CustomerID
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 9981104dd39772ef304153f276678819 : SELECT *
 FROM   Customers   
 WHERE ( (Customers.CustomerID = 1) ) 

PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"CustomerID":"1","CompanyName":"Deerfield Tile","ContactName":"Dick Terrcotta","ContactTitle":"Owner","Address":"450 Village Street","City":"Deerfield","State":"IL"}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : fb8ab69b63a9c51d37c6fcb83864b07b : UPDATE  Customers  SET CompanyName = 'test2'  WHERE (Customers.CustomerID = 1) 
PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : query       : 1d0ba376e273b9d622641124d8c59264 : COMMIT
PDO_DataObject   : query       : COMMIT--IGNORED
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : get       : ('CustomerID', 1) keys= Array
(
    [0] => CustomerID
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 9981104dd39772ef304153f276678819 : SELECT *
 FROM   Customers   
 WHERE ( (Customers.CustomerID = 1) ) 

PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"CustomerID":"1","CompanyName":"test2","ContactName":"Dick Terrcotta","ContactTitle":"Owner","Address":"450 Village Street","City":"Deerfield","State":"IL"}
PDO_DataObject   : find       : DONE
Array
(
    [CustomerID] => 1
    [CompanyName] => test2
    [ContactName] => Dick Terrcotta
    [ContactTitle] => Owner
    [Address] => 450 Village Street
    [City] => Deerfield
    [State] => IL
)
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : query       : 19aad9f2fe3ce0023298ab83f7e75775 : BEGIN
PDO_DataObject   : query       : BEGIN--IGNORED
PDO_DataObject   : get       : ('CustomerID', 1) keys= Array
(
    [0] => CustomerID
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 9981104dd39772ef304153f276678819 : SELECT *
 FROM   Customers   
 WHERE ( (Customers.CustomerID = 1) ) 

PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"CustomerID":"1","CompanyName":"test2","ContactName":"Dick Terrcotta","ContactTitle":"Owner","Address":"450 Village Street","City":"Deerfield","State":"IL"}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : d84b66d6105d30c7c8e68664e1c9ff59 : UPDATE  Customers  SET CompanyName = 'test4'  WHERE (Customers.CustomerID = 1) 
PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : query       : 2805522dd41e1b57da11967ac5fa258c : ROLLBACK
PDO_DataObject   : query       : ROLLBACK--IGNORED
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : get       : ('CustomerID', 1) keys= Array
(
    [0] => CustomerID
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 9981104dd39772ef304153f276678819 : SELECT *
 FROM   Customers   
 WHERE ( (Customers.CustomerID = 1) ) 

PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"CustomerID":"1","CompanyName":"test4","ContactName":"Dick Terrcotta","ContactTitle":"Owner","Address":"450 Village Street","City":"Deerfield","State":"IL"}
PDO_DataObject   : find       : DONE
Array
(
    [CustomerID] => 1
    [CompanyName] => test4
    [ContactName] => Dick Terrcotta
    [ContactTitle] => Owner
    [Address] => 450 Village Street
    [City] => Deerfield
    [State] => IL
)