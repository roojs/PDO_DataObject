--TEST--
sqlValue Test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest'
      
));

PDO_DataObject::debugLevel(1);
 

echo "\n\n--------\n";
echo "sqlValue - basic Raw;\n" ;

echo PDO_DataObject::factory('Events')
    ->set(['action' => PDO_DataObject::sqlValue('NOW()') ])
    ->whereToString();

echo "\n\n--------\n";
echo "sqlValue - various values..;\n" ;

echo PDO_DataObject::factory('Events')
    ->set([
        'action' => PDO_DataObject::sqlValue('blob','a long piece of data'))
        'remarks' => PDO_DataObject::sqlValue('string', 123123),
        'person_name' => PDO_DataObject::sqlValue('sql', 'NOW()'),
        'event_when' => PDO_DataObject::sqlValue('date', '2000-01-01 10:00:00)'),  
    ])
    ->whereToString();


// need a few more date fields to test really..
echo PDO_DataObject::factory('Events')
    ->set([ 'event_when' => PDO_DataObject::sqlValue('dateTime', '2000-01-01 10:00:00)'),  
    ])
    ->whereToString() . "\n";
    
echo PDO_DataObject::factory('Events')
    ->set([ 'event_when' => PDO_DataObject::sqlValue('time', '2000-01-01 10:00:00)'),  
    ])
    ->whereToString() . "\n";
    
//=== test on pgsql.. for blobs.

?>
--EXPECT--
