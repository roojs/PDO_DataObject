--TEST--
Factory test
--FILE--
<?php
require_once 'includes/init.php';

DB_DataObject::config('class_location', __DIR__.'/includes/sample_classes');


echo "Simple factory call\n";
$person = DB_DataObject::factory('Person');
print_r(get_class($person);


echo "--------\n";
echo "factory call with failure\n";

$person = DB_DataObject::factory('Person_invalid');
print_r(get_class($person);

  

$gen = (new PDO_DataObject('mysql_anotherdb/Events'))->generator();
$gen->readTableList();
echo $gen->toINI(); 
echo $gen->toPhp('Companies');
 








?>
--EXPECT--