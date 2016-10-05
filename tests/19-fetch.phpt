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
//        'database' => 'mysql://root:@localhost/pman',
 //       'PDO' => 'PDO',        'proxy' => 'full',
));

//PDO_DataObject::debugLevel(0);
//PDO_DataObject::factory('Companies')->databaseStructure();
PDO_DataObject::debugLevel(0);


echo "\n\n--------\n";
echo "simple fetch\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
$rows = $company->find();
echo "Got $rows rows from find\n";
$company->fetch();
print_r($company->toArray());




echo "\n\n--------\n";
echo "fetch with 'fetch_into' set - might be faster....\n" ;
PDO_DataObject::config('fetch_into', true);

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
$rows = $company->find();
echo "Got $rows rows from find\n";
$company->fetch();
print_r($company->toArray());



echo "\n\n--------\n";
echo "fetch without find (error)\n" ;

$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
try {
    $company->fetch();
} catch(PDO_DataObject_Exception_InvalidArgs $e) {
    echo "got exception as expected: {$e->getMessage()}\n";
}
/*


echo "\n\n--------\n";
echo "mutliple find/fetch with keep_query_after_fetch\n" ;

PDO_DataObject::config('keep_query_after_fetch', true);
 
*/





?>
--EXPECT--
--------
simple fetch
__construct==["mysql:dbname=gettest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:ebba0af48c52cc567e77a69664b3addb:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Got 3 rows from find
Fetch Row 0 / 3
Array
(
    [code] => vinski
    [name] => Vinski Web
    [remarks] => 
    [owner_id] => 0
    [address] => 
    [tel] => 
    [fax] => 
    [email] => test@example.com
    [id] => 15
    [isOwner] => 0
    [logo_id] => 0
    [background_color] => 
    [comptype] => CONSULTANT
    [url] => 
    [main_office_id] => 0
    [created_by] => 0
    [created_dt] => 0000-00-00 00:00:00
    [updated_by] => 0
    [updated_dt] => 0000-00-00 00:00:00
    [passwd] => 
    [dispatch_port] => 
    [province] => 
    [country] => 
)


--------
fetch with 'fetch_into' set - might be faster....
QUERY:ebba0af48c52cc567e77a69664b3addb:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Got 3 rows from find
Fetch Row 0 / 3
Array
(
    [code] => vinski
    [name] => Vinski Web
    [remarks] => 
    [owner_id] => 0
    [address] => 
    [tel] => 
    [fax] => 
    [email] => test@example.com
    [id] => 15
    [isOwner] => 0
    [logo_id] => 0
    [background_color] => 
    [comptype] => CONSULTANT
    [url] => 
    [main_office_id] => 0
    [created_by] => 0
    [created_dt] => 0000-00-00 00:00:00
    [updated_by] => 0
    [updated_dt] => 0000-00-00 00:00:00
    [passwd] => 
    [dispatch_port] => 
    [province] => 
    [country] => 
)


--------
fetch without find (error)
got exception as expected: Fetch Called without Query being run