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

PDO_DataObject::debugLevel(0);
 
// these need the links to calculate the join..
echo "\n---\nFetch a related link.n";

PDO_DataObject::factory('Events')
    ->query("BEGIN")
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    ->query("COMMIT")


PDO_DataObject::factory('Events')
    ->query("BEGIN")
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    ->query("ROLLBACK")
