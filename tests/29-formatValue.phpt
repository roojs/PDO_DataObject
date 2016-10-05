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

echo "date : {$d->formatValue('ex_date', 'd/M/Y')}\n";
echo "date : {$d->formatValue('ex_datetime', 'd/M/Y H:ia')}\n";
echo "date : {$d->formatValue('ex_time', 'H:ia')}\n";
 
 $d = PDO_DataObject::factory('Dummy')
    ->set([
        'ex_date' => '2000-01-01',
        'ex_datetime' => '2000-01-01 10:00:00',
        'ex_time' => '10:00:00',        
    ]);
echo "date : {$d->formatValue('ex_date', 'd/M/Y')}\n";
echo "date : {$d->formatValue('ex_datetime', 'd/M/Y H:ia')}\n";
echo "date : {$d->formatValue('ex_time', 'H:ia')}\n";

echo "\n\nBooleans\n ";
echo "\n expect TRUE\n";
var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => 't'
    ])->formatValue('ex_str_bool')
);

echo "\n expect 'true'\n";
var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => 't'
    ])->formatValue('ex_str_bool', '%s')
);
echo "\n expect '1'\n";
var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => 't'
    ])->formatValue('ex_str_bool', '%d')
);

echo "\n expect FALSE\n";
var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => 'f'
    ])->formatValue('ex_str_bool')
);
echo "\n expect 'false'\n";
var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => false
    ])->formatValue('ex_str_bool', '%s')
);
echo "\n expect '0'\n";
var_export(PDO_DataObject::factory('Dummy')
    ->set([
        'ex_str_bool' => false
    ])->formatValue('ex_str_bool', '%d')
); 

?>
--EXPECT--
--------
sqlValue - various values..;
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
date : 01/Jan/2000
date : 01/Jan/2000 10:00am
date : 10:00am
date : 01/Jan/2000
date : 01/Jan/2000 10:00am
date : 10:00am


Booleans
 
 expect TRUE
true
 expect 'true'
'true'
 expect '1'
1
 expect FALSE
false
 expect 'false'
'false'
 expect '0'
0
