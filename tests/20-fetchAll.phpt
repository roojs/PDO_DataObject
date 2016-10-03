--TEST--
fetch() test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
     //   'database' => 'mysql://user:pass@localhost/gettest'
     real db...
         'database' => 'mysql://root:@localhost/pman',
         'PDO' => 'PDO',        'proxy' => 'full',
));

//PDO_DataObject::debugLevel(0);
//PDO_DataObject::factory('Companies')->databaseStructure();
PDO_DataObject::debugLevel(0);


echo "\n\n--------\n";
echo "fetchAll('id');\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(10);
$company->orderBy('id ASC');
print_r($company->fetchAll('id'));

echo "\n\n--------\n";
echo "fetchAll(true);\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(10);
$company->select('LENGTH(name)')
$company->orderBy('LENGTH(name) DESC');
print_r($company->fetchAll(true));

echo "\n\n--------\n";
echo "select('name'), fetchAll('name');\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(10);
$company->select('name')
$company->orderBy('LENGTH(name) DESC');
print_r($company->fetchAll(true));




?>
--EXPECT--
