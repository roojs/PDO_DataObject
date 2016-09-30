--TEST--
pid test
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
echo "simple where\n" ;

$company = PDO_DataObject::factory('Companies');
$company->where("a > 100");
echo "first add result: " $company->toSelectSQL();


echo "\n\n--------\n";
echo "multiple chained where \n";

$company = PDO_DataObject::factory('Companies');
$company->where("a > 100")
       ->where("b < 100");

echo "multiple chained : " $company->toSelectSQL();


echo "\n\n--------\n";
echo "reset and clear\n";
$company->where()->where("c > 10")
       

echo "After clear: " $company->toSelectSQL();


?>
--EXPECT--
 