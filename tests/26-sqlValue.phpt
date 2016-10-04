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

echo PDO_DataObject::factory('Dummy')
    ->set([
        'ex_blob' => PDO_DataObject::sqlValue('blob','a long piece of data'),
        'ex_string' => PDO_DataObject::sqlValue('string', 123123),
        'ex_sql' => PDO_DataObject::sqlValue('sql', 'NOW()'),
        'ex_date' => PDO_DataObject::sqlValue('date', '2000-01-01 10:00:00)'),
        'ex_datetime' => PDO_DataObject::sqlValue('dateTime', '2000-01-01 10:00:00)'),
        'ex_time' => PDO_DataObject::sqlValue('time', '2000-01-01 10:00:00)'),        
    ])
    ->whereToString();

// test other crosses.. probably throwing errors..
    
    
//=== test on pgsql.. for blobs.

?>
--EXPECT--
