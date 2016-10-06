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
echo "\n---\nNo portability.n";

PDO_DataObject::factory('Events')
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    
PDO_DataObject::config(array(
        'portability' => PDO_DataObject::PORTABILITY_LOWERCASE
));
echo "\n---\nWith lowercase portability.n";
PDO_DataObject::factory('Events')
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    

?>
--EXPECT--
