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
$company->select("a,b");
$company->where('a=b');

$events = PDO_DataObject::factory('Events');
$events->select("c,d");
$events->where('e=f');

$company->union($events);

$company->orderBy('b desc');
$company->limit(10);


echo "resulting query: " . $company->toSelectSQL();

 
 
?>
--EXPECT--
