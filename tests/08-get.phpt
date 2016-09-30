--TEST--
get test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
        'database' => 'mysql://user:pass@localhost/gettest'
   // real db...
    //    'database' => 'mysql://root:@localhost/pman',
    //    'PDO' => 'PDO',        'proxy' => 'full',
));

echo "\n\n--------\n";

echo "Simple get by id call\n";
$company = PDO_DataObject::factory('Companies');
if ($company->get(12)) {
    echo "GOT result\n";
    print_r(get_object_vars($company));
}


echo "\n\n--------\n";
echo "get by id / no results\n";

$company = PDO_DataObject::factory('Companies');
if (!$company->get(13)) {
    echo "correctly got no result\n";
}

echo "\n\n--------\n";
echo "get by key value\n";

$company = PDO_DataObject::factory('Companies');
if ($company->get('email','test@example.com')) {
    echo "GOT result\n";
    print_r(get_object_vars($company));
}
  
echo "\n\n--------\n";
echo "get with other values set. / no result \n";

$company = PDO_DataObject::factory('Companies');
$company->isOwner = 1;
if (!$company->get(12)) {
    echo "correctly got no result\n";
}

echo "\n\n--------\n";
echo "get with conditions set.\n";

$company = PDO_DataObject::factory('Companies');
$company->where("age > 10");
if ($company->get(12)) {
    echo "GOT result\n";
    print_r(get_object_properties($Company));
}
  

 

?>
--EXPECT--
Simple factory call
factory('Companies') returns a class called  DataObjects_Companies


--------
Calling factory on a existing dataobject, creates a fresh instance
new object 'test' value is :UNDEFINED


--------
factory call with failure
calling factory on a non-existant table results in an PDO_DataObject_Exception_InvalidArgs and a message of factory could not find class from Companies_invalid

--------
factory call with invalid proxy method
calling factory with proxy set wrong results in an PDO_DataObject_Exception_InvalidConfig and a message of: Generator does not have method getProxyall, 
  usually proxy should be set to 'Full', you set it to 'all'

--------
factory call with proxy all (auto generate)
factory('Employees') when using proxy returns a class called  DataObjects_Employees