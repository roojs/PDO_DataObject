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
if ($person->get('email','test@example.com')) {
    echo "GOT result\n"
    print_r($person);
}
  
echo "\n\n--------\n";
echo "get with other values set.\n";

$person = PDO_DataObject::factory('Customers');
$preson->active = 1;
if ($person->get(12)) {
    echo "GOT result\n"
    print_r($person);
}

echo "\n\n--------\n";
echo "get with conditions set.\n";

$person = PDO_DataObject::factory('Customers');
$person->where("age > 10");
if ($person->get('email','test@example.com')) {
    echo "GOT result\n"
    print_r($person);
}
  

 

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