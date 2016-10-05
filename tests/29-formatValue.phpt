--TEST--
formatValue Test 
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
echo "sqlValue - various values..;\n" ;

$d = PDO_DataObject::factory('Dummy')
    ->set([
        'ex_date' => PDO_DataObject::sqlValue('date', '2000-01-01'),
        'ex_datetime' => PDO_DataObject::sqlValue('dateTime', '2000-01-01 10:00:00'),
        'ex_time' => PDO_DataObject::sqlValue('time', '10:00:00'),        
    ]);

echo "date : {$d->formatValue('ex_date', 'd/M/Y')}\n"
echo "date : {$d->formatValue('ex_datetime', 'd/M/Y H:i')}\n"
echo "date : {$d->formatValue('ex_time', 'H:i')}\n"
 
 $d = PDO_DataObject::factory('Dummy')
    ->set([
        'ex_date' => '2000-01-01',
        'ex_datetime' => '2000-01-01 10:00:00',
        'ex_time' => '10:00:00',        
    ]);
echo "date : {$d->formatValue('ex_date', 'd/M/Y')}\n"
echo "date : {$d->formatValue('ex_datetime', 'd/M/Y H:i')}\n"
echo "date : {$d->formatValue('ex_time', 'H:i')}\n"

echo "Booleans "
var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => 't'
    ])->formatValue('ex_str_bool')
);


var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => 't'
    ])->formatValue('ex_str_bool', '%s')
);
var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => 't'
    ])->formatValue('ex_str_bool', '%d')
);
var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => 'f'
    ])->formatValue('ex_str_bool')
);

var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => false
    ])->formatValue('ex_str_bool', '%s')
);

var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => false
    ])->formatValue('ex_str_bool', '%d')
); 

?>
--EXPECT--
