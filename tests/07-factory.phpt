--TEST--
Factory test
--FILE--
<?php
require_once 'includes/init.php';

DB_DataObject::config('class_location', __DIR__.'/includes/sample_classes');

$person = DB_DataObject::factory('Person');
print_r(get_class('Person'));


echo "--\n";


  

$gen = (new PDO_DataObject('mysql_anotherdb/Events'))->generator();
$gen->readTableList();
echo $gen->toINI(); 
echo $gen->toPhp('Companies');
 








?>
--EXPECT--