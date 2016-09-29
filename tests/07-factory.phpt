--TEST--
Factory test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
PDO_DataObject::config('class_location', __DIR__.'/includes/sample_classes/DataObjects_');


echo "Simple factory call\n";
$person = PDO_DataObject::factory('Customers');
echo "factory('Customers') returns a class called  " . get_class($person) . "\n";


echo "\n\n--------\n";
echo "Calling factory on a existing dataobject, creates a fresh instance\n";

$person = PDO_DataObject::factory('Customers');
$person->test = 1;
$next_person = $person->factorySelf();
echo "new object 'test' value is :" . (isset($next_person->test) ? "DEFINED" : "UNDEFINED") . "\n";


echo "\n\n--------\n";
echo "factory call with failure\n";
try {
$person = PDO_DataObject::factory('Customers_invalid');
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "calling factory on a non-existant table results in an ". get_class($e) . " and a message of " . $e->getMessage();
}

echo "\n\n--------\n";
echo "factory call with invalid proxy method\n";
PDO_DataObject::config(array(
        'PDO' => 'PDO',
        'database' => 'sqlite:'.__DIR__.'/includes/EssentialSQL.db',
        'proxy' => 'all'
));
try {
    $Employees = PDO_DataObject::factory('Employees');
} catch (PDO_DataObject_Exception_InvalidConfig $e) {
    echo "calling factory with proxy set wrong results in an ". get_class($e) . " and a message of: " . $e->getMessage();
}





echo "\n\n--------\n";
echo "factory call with proxy all (auto generate)\n";
PDO_DataObject::config(array(
        'PDO' => 'PDO',
        'database' => 'sqlite:'.__DIR__.'/includes/EssentialSQL.db',
        'proxy' => 'full'
));

$Employees = PDO_DataObject::factory('Employees');
echo "factory('Employees') when using proxy returns a class called  " . get_class($Employees) . "\n";




?>
--EXPECT--