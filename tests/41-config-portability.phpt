--TEST--
portability Test 
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest',
        'class_prefix' => 'DataObjects_',
));

PDO_DataObject::debugLevel(0);
 
// these need the links to calculate the join..
echo "\n---\nNo portability\n";

PDO_DataObject::factory('Events')
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save();


PDO_DataObject::reset();    
PDO_DataObject::config(array(
        'portability' => PDO_DataObject::PORTABILITY_LOWERCASE,
        'quote_identifiers' => true,
));
echo "\n---\nWith lowercase portability\n";
PDO_DataObject::factory('Events')
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save();
    
// it should probably test more....



    
    
?>
--EXPECT--
---
No portability
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:183b4035a4a59e23b849e6bdd8a53fdb:
SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

Fetch Row 0 / 1
QUERY:9da43100ad8e2d1eee0cfee396c16588:
UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3523) 

---
With lowercase portability
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:3bcfaddd226e85092426f9166593c21f:
SELECT *
 FROM   events   
 WHERE ( (events.id = 3523) ) 

Fetch Row 0 / 1
QUERY:b6becd48cb3e23ad55b52f84bd8b04cf:
UPDATE  events  SET action = 'testing'  WHERE (events.id = 3523)
