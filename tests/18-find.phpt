--TEST--
find() test
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
--------
find with a single name
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
Fetch Row 1 / 3
Array
(
    [code] => MASL
    [name] => Modern (INTL) Access & Scaffolding Ltd
    [remarks] => 
    [owner_id] => 0
    [address] => 
    [tel] => 
    [fax] => 
    [email] => test@example.com
    [id] => 16
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
Fetch Row 2 / 3
Array
(
    [code] => HKDNR
    [name] => HK Domain Registry
    [remarks] => 
    [owner_id] => 0
    [address] => 
    [tel] => 
    [fax] => 
    [email] => test@example.com
    [id] => 17
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
Fetch Row 3 / 3
Close Cursor


--------
find & fetch with a single name
QUERY:2a1daa39fc1c411b62e53c52ff873eee:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  1
Fetch Row 0 / 1
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
find - mixing where and properties
QUERY:d67f7387466fef0c36b56c91273fa513:
SELECT *
 FROM   Companies   
 WHERE ( ( id !=1  ) AND (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  1
Fetch Row 0 / 1
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
error running find twice..
QUERY:ebba0af48c52cc567e77a69664b3addb:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
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
Fetch Row 1 / 3
Array
(
    [code] => MASL
    [name] => Modern (INTL) Access & Scaffolding Ltd
    [remarks] => 
    [owner_id] => 0
    [address] => 
    [tel] => 
    [fax] => 
    [email] => test@example.com
    [id] => 16
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
Fetch Row 2 / 3
Array
(
    [code] => HKDNR
    [name] => HK Domain Registry
    [remarks] => 
    [owner_id] => 0
    [address] => 
    [tel] => 
    [fax] => 
    [email] => test@example.com
    [id] => 17
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
Fetch Row 3 / 3
Close Cursor
Threw exception as expected You cannot do two queries on the same object (copy it before finding)