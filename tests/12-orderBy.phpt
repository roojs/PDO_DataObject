--TEST--
orderBy test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        'database' => 'mysql://user:pass@localhost/gettest'
));
 

echo "\n\n--------\n";
echo "test numbers\n" ;

$company = PDO_DataObject::factory('Companies');
$company->whereIn('id', $numbers, 'int');
echo "resulting query: " . $company->toSelectSQL();


echo "\n\n--------\n";
echo "test strings\n";

$company = PDO_DataObject::factory('Companies');
$company->whereIn('name', $text, 'string');
echo "resulting query: " . $company->toSelectSQL();


 
?>
--EXPECT--
--------
test numbers
resulting query: SELECT *
 FROM   Companies   
 WHERE ( id  IN (1,2,3,4,5) )

--------
test strings
__construct==["mysql:dbname=gettest;host=localhost","user","pass",[]]
setAttribute==[3,2]
resulting query: SELECT *
 FROM   Companies   
 WHERE ( name  IN ('this','is','a','test','of','escaping') )