--TEST--
groupBy test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        'database' => 'mysql://user:pass@localhost/gettest'
));
 

echo "\n\n--------\n";
echo "test order By\n" ;

$company = PDO_DataObject::factory('Companies');
$company->groupBy('id');
echo "resulting query: " . $company->toSelectSQL();


echo "\n\n--------\n";
echo "test order By mulitple\n" ;
$company = PDO_DataObject::factory('Companies');
$company->orderBy('id desc')->orderBy('c asc');
echo "resulting query: " . $company->toSelectSQL();
 
echo "\n\n--------\n";
echo "test order clear\n" ;
$company->orderBy()->orderBy('c asc'); 
 echo "resulting query: " . $company->toSelectSQL();
 
?>
--EXPECT--
--------
test order By
resulting query: SELECT *
 FROM   Companies ORDER BY id desc  


--------
test order By mulitple
resulting query: SELECT *
 FROM   Companies ORDER BY id desc  , c asc 


--------
test order clear
resulting query: SELECT *
 FROM   Companies ORDER BY c asc
