--TEST--
get test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config('class_location', __DIR__.'/includes/sample_classes/DataObjects_');

echo "\n\n--------\n";

echo "Simple get by id call\n";
$person = PDO_DataObject::factory('Customers');
if ($person->get(12)) {
    echo "GOT result\n";
    print_r($person);
}


echo "\n\n--------\n";
echo "get by id / no results\n";

$person = PDO_DataObject::factory('Customers');
if (!$person->get(13)) {
    echo "correctly got no result\n";
}

echo "\n\n--------\n";
echo "get by key value\n";

$person = PDO_DataObject::factory('Customers');
$person->get('email','test@example.com');
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
Simple factory call
factory('Customers') returns a class called  DataObjects_Customers


--------
Calling factory on a existing dataobject, creates a fresh instance
new object 'test' value is :UNDEFINED


--------
factory call with failure
calling factory on a non-existant table results in an PDO_DataObject_Exception_InvalidArgs and a message of factory could not find class from Customers_invalid

--------
factory call with invalid proxy method
calling factory with proxy set wrong results in an PDO_DataObject_Exception_InvalidConfig and a message of: Generator does not have method getProxyall, 
  usually proxy should be set to 'Full', you set it to 'all'

--------
factory call with proxy all (auto generate)
factory('Employees') when using proxy returns a class called  DataObjects_Employees