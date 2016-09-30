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
$company->having('id, a');
echo "resulting query: " . $company->toSelectSQL();


echo "\n\n--------\n";
echo "test having mulitple\n" ;
$company = PDO_DataObject::factory('Companies');
$company->having('id, a')->having('c,d');
echo "resulting query: " . $company->toSelectSQL();
 
echo "\n\n--------\n";
echo "test having clear\n" ;
$company->having()->having('e, f'); 
 echo "resulting query: " . $company->toSelectSQL();
 
?>
--EXPECT--
--------
test order By
resulting query: SELECT *
 FROM   Companies   
 GROUP BY id, a 


--------
test having mulitple
resulting query: SELECT *
 FROM   Companies   
 GROUP BY id, a  , c,d 


--------
test having clear
resulting query: SELECT *
 FROM   Companies   
 GROUP BY e, f
