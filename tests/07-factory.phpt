--TEST--
Factory test
--FILE--
<?php
require_once 'includes/init.php';




$person = DB_DataObject::factory('Person');
print_r(get_class('Person'));
  

$gen = (new PDO_DataObject('mysql_anotherdb/Events'))->generator();
$gen->readTableList();
echo $gen->toINI(); 
echo $gen->toPhp('Companies');
 








?>
--EXPECT--