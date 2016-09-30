--TEST--
union test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        'database' => 'mysql://user:pass@localhost/gettest'
));
 

echo "\n\n--------\n";
echo "test union\n" ;

$company = PDO_DataObject::factory('Companies');
$company->where('a=b');

$events = PDO_DataObject::factory('Events');
$events->select("a)
$events->where('c=d');

$company->union($events)





echo "resulting query: " . $company->toSelectSQL();


echo "\n\n--------\n";
echo "test having mulitple\n" ;
$company = PDO_DataObject::factory('Companies');
$company->having('a=b')->having('c=d');
echo "resulting query: " . $company->toSelectSQL();
 
 
 echo "\n\n--------\n";
echo "test having mulitple or\n" ;
$company = PDO_DataObject::factory('Companies');
$company->having('a=b')->having('c=d', 'OR');
echo "resulting query: " . $company->toSelectSQL();

 
echo "\n\n--------\n";
echo "test having clear\n" ;
$company->having()->having('e=f'); 
 echo "resulting query: " . $company->toSelectSQL();
 
?>
--EXPECT--
--------
test having
resulting query: SELECT *
 FROM   Companies   
 HAVING a=b 


--------
test having mulitple
resulting query: SELECT *
 FROM   Companies   
 HAVING a=b AND c=d 


--------
test having mulitple or
resulting query: SELECT *
 FROM   Companies   
 HAVING a=b OR c=d 


--------
test having clear
resulting query: SELECT *
 FROM   Companies   
 HAVING e=f
