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
 

 
echo "simple join - with object: ". PDO_DataObject::factory('Joiner')
    ->joinAdd(PDO_DataObject::factory('Child'))
    ->_join;
    
echo "simple join - with string: ". PDO_DataObject::factory('Joiner')
    ->joinAdd('Child')
    ->_join;
        
    
echo "simple join - with array (2): ". PDO_DataObject::factory('Joiner')
    ->joinAdd(array('child_id', 'Child2:id'))
    ->_join;
        
echo "simple join - with array (3): ". PDO_DataObject::factory('Joiner')
    ->joinAdd(array('child_id', PDO_DataObject::factory('Child'), 'id'))
    ->_join;
     
 
var_export(
    PDO_DataObject::factory('Dummy')
        ->set([
            'ex_string' => 'string',
            'ex_date' => '2000-01-01',
            'ex_datetime' => '2000-01-01 10:00:00',
            'ex_time' => '10:00:00',
            'ex_int' => 123
        ])
        ->validate()
);

echo "\ntest not null..\n";
$d = PDO_DataObject::factory('Dummy');
$d->ex_string = $d->sqlValue('NULL');
var_export($d->validate());

echo "\nvalidate numeric..\n";

$d= PDO_DataObject::factory('Dummy');
$d->ex_int = 'a dog';
var_export($d->validate());


class DataObjects_Testdog extends PDO_DataObject {
    var $__table = 'testdog';
    function validateDog()
    {
        return "problem with dog";
    }
    function tableColumns() {
        return array('id' => 129, 'dog' => 130);
    }
    function sequenceKeys()
    {
        return array('id',true, false);
    }
    
}


echo "\ntest validate methods?..\n";

$a =  PDO_DataObject::factory('testdog');
$a->dog = 123;
var_export(
    $a->validate()
);



 

?>
--EXPECT--
--------
validate ;
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
true
test not null..
true
validate numeric..
array (
  'ex_int' => 'Value is not numeric',
)
test validate methods?..
array (
  'dog' => 'problem with dog',
)
