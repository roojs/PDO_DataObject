--TEST--
Factory test
--FILE--
<?php
require_once 'includes/init.php';

DB_DataObject::config('class_location', __DIR__.'/includes/sample_classes');


echo "Simple factory call\n";
$person = DB_DataObject::factory('Customers');
echo "factory returns a class called  " . get_class($person) . "\n";


echo "--------\n";
echo "Calling factory on a existing dataobject, creates a fresh instance\n";

$person = DB_DataObject::factory('Customers');
$person->test = 1;
$next_person = $person->factory();
echo "new object 'test' value is :" . (isset($next_person->test) ? "DEFINED" : "UNDEFINED") . "\n";


echo "--------\n";
echo "factory call with failure\n";
try {
$person = DB_DataObject::factory('Customers_invalid');
} catch (Exception $e) {
    echo "calling factory on a non-existant table results in an ". get_class($e) . " and a message of " . $e->getMessage();
}




echo "--------\n";
echo "factory call with proxy all (auto generate)\n";

DB_DataObject::config('proxy', 'all');
$person = DB_DataObject::factory('Employees');








?>
--EXPECT--