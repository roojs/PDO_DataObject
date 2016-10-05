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
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]

simple join - with object: 
 INNER JOIN childa  ON (childa.ca_id=joiner.childa_id)  
simple join - with string: 
 INNER JOIN childa  ON (childa.ca_id=joiner.childa_id)  
simple join - with array (2): 
 INNER JOIN childb  ON (childb.cb_id=joiner.childb_id)  
simple join - with array (3): 
 INNER JOIN childb  ON (childb.cb_id=joiner.childb_id)  

--------
join Types

simple join left join: 
 LEFT JOIN childa  ON (childa.ca_id=joiner.childa_id)  
simple join right join 
 RIGHT JOIN childa  ON (childa.ca_id=joiner.childa_id)  
simple join empty string type: 
 , childa  
 - with WHERE:
( childa.ca_id=joiner.childa_id )
 threw exception as expected Invalid Join type :'XXX'


--------
join As

 LEFT JOIN childa AS first_child ON (first_child.ca_id=joiner.childa_id)  

--------
joinCol

joining without specifying which column, fails as expected: There are multiple locations where table 'childa' is joined to 'joinerb' 
 you should use the joinCol argument to specify which one to use

 INNER JOIN childa AS join_childa_first ON (join_childa_first.ca_id=joinerb.childa_id)  
 INNER JOIN childa AS join_childa_second ON (join_childa_second.ca_id=joinerb.childc_id)  

--------
useWhereAsOn

 INNER JOIN childa  ON (childa.ca_id=joiner.childa_id)  AND ( childa.name = 'fred' )
