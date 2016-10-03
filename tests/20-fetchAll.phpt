--TEST--
fetch() test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   //     'database' => 'mysql://user:pass@localhost/gettest'
    // real db...
         'database' => 'mysql://root:@localhost/pman',
         'PDO' => 'PDO',        'proxy' => 'full',
));

PDO_DataObject::debugLevel(0);
 


echo "\n\n--------\n";
echo "single col - fetchAll('id');\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
$company->orderBy('id ASC');
print_r($company->fetchAll('id'));

echo "\n\n--------\n";
echo "single col - fetchAll(true);\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
$company->select('LENGTH(name)');
$company->orderBy('LENGTH(name) DESC');
print_r($company->fetchAll(true));

echo "\n\n--------\n";
echo "single col -  select('name'), fetchAll('name');\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
$company->select('*,  name');
print_r($company->fetchAll('name'));


echo "\n\n--------\n";
echo "associative array\n" ;
$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
print_r($company->fetchAll('id', 'name'));


echo "\n\n--------\n";
echo "array of objects\n" ;
$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
$ar = $company->fetchAll();
foreach($ar as $a) {
    echo get_class($a) . " {$a->id}\n";
}

echo "\n\n--------\n";
echo "array of arrays (faster version - no dataObject created)\n" ;
$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
print_r($company->fetchAll(false, false, true));

echo "\n\n--------\n";
echo "array of arrays  - fetchAllAssoc - aliased method (faster version - no dataObject created)\n" ;
$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
print_r($company->fetchAllAssoc());



echo "\n\n--------\n";
echo "array of arrays (by calling toArray())\n" ;
$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
print_r($company->fetchAll(false, false, 'toArray'));






?>
--EXPECT--
