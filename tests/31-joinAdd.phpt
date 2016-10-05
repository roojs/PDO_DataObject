--TEST--
joinAdd Test 
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
 
echo "\nsimple join - with object: ". PDO_DataObject::factory('joiner')
    ->joinAdd(PDO_DataObject::factory('childa'))
    ->_join;
    
echo "\nsimple join - with string: ". PDO_DataObject::factory('joiner')
    ->joinAdd('childa')
    ->_join;
        
// these do not need the links.. to calculate the join..
    
echo "\nsimple join - with array (2): ". PDO_DataObject::factory('Joiner')
    ->joinAdd(array('childb_id', 'childb:cb_id'))
    ->_join;
        
echo "\nsimple join - with array (3): ". PDO_DataObject::factory('Joiner')
    ->joinAdd(array('childb_id', PDO_DataObject::factory('childb'), 'cb_id'))
    ->_join;
     
     
// second param...

echo "\nsimple join - with string: ". PDO_DataObject::factory('joiner')
    ->joinAdd('childa','LEFT')
    ->_join;

echo "\nsimple join - with string: ". PDO_DataObject::factory('joiner')
    ->joinAdd('childa','RIGHT')
    ->_join;
 
 
$j = PDO_DataObject::factory('joiner')
    ->joinAdd('childa','') 
echo "\nsimple join - with string: ". $j->_join ."\n" .
    $j->whereToString();
    
    
    
try {
PDO_DataObject::factory('joiner')
    ->joinAdd('childa','XXX')
    ->_join;
} catch(PDO_DataObject_Exception_InvalidArgs $e) {
    echo "\n threw exception as expected {$e->getMessage()}\n";
}






?>
--EXPECT--
