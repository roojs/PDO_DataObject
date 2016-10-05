--TEST--
autoJOin and joinAll Test 
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
 
$j = PDO_DataObject::factory('joiner')
    ->joinAll()
    ->find(true);
    
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
     
 
echo "\n\n--------\n";
echo "join Types\n" ;
    
// second param...

echo "\nsimple join left join: ". PDO_DataObject::factory('joiner')
    ->joinAdd('childa','LEFT')
    ->_join;

echo "\nsimple join right join ". PDO_DataObject::factory('joiner')
    ->joinAdd('childa','RIGHT')
    ->_join;
 
 
$j = PDO_DataObject::factory('joiner')
    ->joinAdd('childa','');
echo "\nsimple join empty string type: ". $j->_join ."\n - with WHERE:\n" .
    $j->whereToString();
    
    
    
try {
PDO_DataObject::factory('joiner')
    ->joinAdd('childa','XXX')
    ->_join;
} catch(PDO_DataObject_Exception_InvalidArgs $e) {
    echo "\n threw exception as expected {$e->getMessage()}\n";
}


echo "\n\n--------\n";
echo "join As\n" ;

echo   PDO_DataObject::factory('joiner')
    ->joinAdd('childa', 'LEFT', 'first_child')
    ->_join;




echo "\n\n--------\n";
echo "joinCol\n" ;

// error...
try {
  PDO_DataObject::factory('joinerb')
    ->joinAdd('childa')
    ->_join;
} catch(PDO_DataObject_Exception_InvalidArgs $e){
    echo "\njoining without specifying which column, fails as expected: {$e->getMessage()}\n";
}

echo   PDO_DataObject::factory('joinerb')
    ->joinAdd('childa','INNER', 'join_childa_first', 'childa_id')
    ->joinAdd('childa','INNER', 'join_childa_second', 'childc_id')
    ->_join;



echo "\n\n--------\n";
echo "useWhereAsOn\n" ;

$ca = PDO_DataObject::factory('childa')->set(['name' => 'fred']);
    
echo   PDO_DataObject::factory('joiner')
    ->joinAdd($ca, array(
            'useWhereAsOn' => true
    ))
    ->_join;



?>
--EXPECT--
