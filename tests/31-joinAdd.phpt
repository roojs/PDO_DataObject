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
 
echo "simple join - with object: ". PDO_DataObject::factory('joiner')
    ->joinAdd(PDO_DataObject::factory('childa'))
    ->_join;
    
echo "simple join - with string: ". PDO_DataObject::factory('joiner')
    ->joinAdd('childa')
    ->_join;
        
// these do not need the links.. to calculate the join..
    
echo "simple join - with array (2): ". PDO_DataObject::factory('Joiner')
    ->joinAdd(array('childb_id', 'childb:cb_id'))
    ->_join;
        
echo "simple join - with array (3): ". PDO_DataObject::factory('Joiner')
    ->joinAdd(array('childb_id', PDO_DataObject::factory('childb'), 'cb_id'))
    ->_join;
     
     


 

?>
--EXPECT--
