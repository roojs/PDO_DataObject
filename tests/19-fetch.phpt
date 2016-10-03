--TEST--
fetch() test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
        'database' => 'mysql://user:pass@localhost/gettest'
   // real db...
   //     'database' => 'mysql://root:@localhost/pman',
   //     'PDO' => 'PDO',        'proxy' => 'full',
));

//PDO_DataObject::debugLevel(0);
//PDO_DataObject::factory('Companies')->databaseStructure();
PDO_DataObject::debugLevel(0);


echo "\n\n--------\n";
echo "find with a single name\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
$rows = $company->find();
echo "Got $rows rows from find\n";
while ($company->fetch()) {
    print_r($company->toArray());
}

echo "\n\n--------\n";
echo "find & fetch with a single name\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(1);
$company->find(true);

print_r($company->toArray());


echo "\n\n--------\n";
echo "find - mixing where and properties\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->where('id !=1 ');
$company->limit(1);
$company->find(true);
print_r($company->toArray());



echo "\n\n--------\n";
echo "error running find twice..\n" ;
$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
$company->find();
while ($company->fetch()) {
    print_r($company->toArray());
}
try {
    $company->find();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "Threw exception as expected {$e->getMessage()}\n";
}










?>
--EXPECT--
