--TEST--
validate Test 
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest'
      
));

PDO_DataObject::debugLevel(0);
 

 
echo "\n\n--------\n";
echo "validate ;\n" ;

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

echo "\ntest validate methods?..\n";


var_export(
    PDO_DataObject::factory('Dummy')
        ->set([
            'ex_int' => 'a dog'
        ])
        ->validate()
);

 

?>
--EXPECT--
 