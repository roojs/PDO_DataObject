--TEST--
link Test 
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
print_r(
    PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id')
        ->toArray()
);
$new_child = PDO_DataObject::factory('childa')->load(3);

PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', $new_child)
        ->save()

PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', 5)
        ->save()
 
 
?>
--EXPECT--
