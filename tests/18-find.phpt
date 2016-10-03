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
PDO_DataObject::debugLevel(1);


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
PDO_DataObject   : find       : false
__construct==["mysql:dbname=gettest;host=localhost","user","pass",[]]
setAttribute==[3,2]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : query       : ebba0af48c52cc567e77a69664b3addb : SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
QUERY: ebba0af48c52cc567e77a69664b3addb
PDO_DataObject   : query       : NO# of results: 3
PDO_DataObject   : find       : CHECK autofetched false
PDO_DataObject   : find       : DONE
Got 3 rows from find
Fetch Row 0 / 3
PDO_DataObject   : fetch       : {"code":"vinski","name":"Vinski Web","remarks":"","owner_id":"0","address":"","tel":"","fax":"","email":"test@example.com","id":"15","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT","url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00","updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
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
PDO_DataObject   : fetch       : {"code":"MASL","name":"Modern (INTL) Access & Scaffolding Ltd","remarks":"","owner_id":"0","address":"","tel":"","fax":"","email":"test@example.com","id":"16","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT","url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00","updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
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
PDO_DataObject   : fetch       : {"code":"HKDNR","name":"HK Domain Registry","remarks":"","owner_id":"0","address":"","tel":"","fax":"","email":"test@example.com","id":"17","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT","url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00","updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
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
PDO_DataObject   : fetch       : false
Close Cursor


--------
find & fetch with a single name
PDO_DataObject   : find       : true
PDO_DataObject   : query       : 2a1daa39fc1c411b62e53c52ff873eee : SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  1
QUERY: 2a1daa39fc1c411b62e53c52ff873eee
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
Array
(
    [id] => 
    [code] => 
    [name] => 
    [remarks] => 
    [owner_id] => 
    [address] => 
    [tel] => 
    [fax] => 
    [email] => 
    [isOwner] => 
    [logo_id] => 
    [background_color] => 
    [comptype] => CONSULTANT
    [url] => 
    [main_office_id] => 
    [created_by] => 
    [created_dt] => 
    [updated_by] => 
    [updated_dt] => 
    [passwd] => 
    [dispatch_port] => 
    [province] => 
    [country] => 
)


--------
find - mixing where and properties
PDO_DataObject   : find       : true
PDO_DataObject   : query       : d67f7387466fef0c36b56c91273fa513 : SELECT *
 FROM   Companies   
 WHERE ( ( id !=1  ) AND (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  1
QUERY: d67f7387466fef0c36b56c91273fa513
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
Array
(
    [id] => 
    [code] => 
    [name] => 
    [remarks] => 
    [owner_id] => 
    [address] => 
    [tel] => 
    [fax] => 
    [email] => 
    [isOwner] => 
    [logo_id] => 
    [background_color] => 
    [comptype] => CONSULTANT
    [url] => 
    [main_office_id] => 
    [created_by] => 
    [created_dt] => 
    [updated_by] => 
    [updated_dt] => 
    [passwd] => 
    [dispatch_port] => 
    [province] => 
    [country] => 
)


--------
error running find twice..
PDO_DataObject   : find       : false
PDO_DataObject   : query       : ebba0af48c52cc567e77a69664b3addb : SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
QUERY: ebba0af48c52cc567e77a69664b3addb
PDO_DataObject   : query       : NO# of results: 3
PDO_DataObject   : find       : CHECK autofetched false
PDO_DataObject   : find       : DONE
Fetch Row 0 / 3
PDO_DataObject   : fetch       : {"code":"vinski","name":"Vinski Web","remarks":"","owner_id":"0","address":"","tel":"","fax":"","email":"test@example.com","id":"15","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT","url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00","updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
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
PDO_DataObject   : fetch       : {"code":"MASL","name":"Modern (INTL) Access & Scaffolding Ltd","remarks":"","owner_id":"0","address":"","tel":"","fax":"","email":"test@example.com","id":"16","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT","url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00","updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
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
PDO_DataObject   : fetch       : {"code":"HKDNR","name":"HK Domain Registry","remarks":"","owner_id":"0","address":"","tel":"","fax":"","email":"test@example.com","id":"17","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT","url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00","updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
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
PDO_DataObject   : fetch       : false
Close Cursor
PDO_DataObject   : raise       : You cannot do two queries on the same object (copy it before finding)
Threw exception as expected You cannot do two queries on the same object (copy it before finding)