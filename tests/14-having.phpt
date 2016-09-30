--TEST--
having test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        'database' => 'mysql://user:pass@localhost/gettest'
));
 

echo "\n\n--------\n";
echo "test having\n" ;

$company = PDO_DataObject::factory('Companies');
$company->having('a=b');
echo "resulting query: " . $company->toSelectSQL();


echo "\n\n--------\n";
echo "test having mulitple\n" ;
$company = PDO_DataObject::factory('Companies');
$company->having('a=b')->having('c=d');
echo "resulting query: " . $company->toSelectSQL();
 
echo "\n\n--------\n";
echo "test having clear\n" ;
$company->having()->having('e=f'); 
 echo "resulting query: " . $company->toSelectSQL();
 
?>
--EXPECT--
