--TEST--
selectAs test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        'database' => 'mysql://user:pass@localhost/gettest'
));
 

echo "\n\n--------\n";
echo "selectAs default\n" ;

$company = PDO_DataObject::factory('Companies');
$company->selectAs();
echo "resulting query: " . $company->toSelectSQL();





?>
--EXPECT--

