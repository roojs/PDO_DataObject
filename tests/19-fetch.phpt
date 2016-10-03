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
echo "simple fetch\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(1);
$rows = $company->find();
echo "Got $rows rows from find\n";
$company->fetch()
var_dump($company->toArray());




echo "\n\n--------\n";
echo "fetch with 'fetch_into' set - might be faster....\n" ;
PDO_DataObject::config('fetch_into', true);

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(1);
$rows = $company->find();
echo "Got $rows rows from find\n";
$company->fetch()
var_dump($company->toArray());



echo "\n\n--------\n";
echo "fetch without find (error)\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->fetch();

echo "\n\n--------\n";
echo "mutliple find/fetch with keep_query_after_fetch\n" ;

PDO_DataObject::config('keep_query_after_fetch', true);

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(1);
$rows = $company->find();
echo "Got $rows rows from find\n";
$company->fetch()
var_dump($company->toArray());

$rows = $company->find();
echo "Got $rows rows from find\n";
$company->fetch()
var_dump($company->toArray());







?>
--EXPECT--
