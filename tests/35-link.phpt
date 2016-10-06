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


echo "\n---\nFetch a related link using link info.n";
print_r(
    PDO_DataObject::factory('joiner')
        ->load(1)
        ->link(array('childb_id','childb:cb_id'))
        ->toArray()
);






echo "\n---\nUpdate by assigning child\n";
PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', PDO_DataObject::factory('childa')->load(3)  )
        ->save();

        
echo "\n---\nUpdate by assigning 5\n";
PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', 5)
        ->save();
 
echo "\n---\nUpdate by assigning 0\n";
PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', 0)
        ->save();

echo "\n---\nUpdate by assigning invalid value\n";
try{
PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', 99)
        ->save();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "\nexception thrown as expected: {$e->getMessage()}\n";
}

echo "\n---\nUpdate by assigning array() - error condition\n";
try {
PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', array())
        ->save();
 } catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "\nexception thrown as expected: {$e->getMessage()}\n";
}
?>
--EXPECT--
