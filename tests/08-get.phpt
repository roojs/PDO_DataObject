--TEST--
get test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
        'database' => 'mysql://user:pass@localhost/gettest'
   // real db...
    //    'database' => 'mysql://root:@localhost/pman',
    //    'PDO' => 'PDO',        'proxy' => 'full',
));

echo "\n\n--------\n";

echo "Simple get by id call\n";
$company = PDO_DataObject::factory('Companies');
if ($company->get(12)) {
    echo "GOT result\n";
    print_r(get_object_vars($company));
}


echo "\n\n--------\n";
echo "get by id / no results\n";

$company = PDO_DataObject::factory('Companies');
if (!$company->get(13)) {
    echo "correctly got no result\n";
}

echo "\n\n--------\n";
echo "get by key value\n";

$company = PDO_DataObject::factory('Companies');
if ($company->get('email','test@example.com')) {
    echo "GOT result\n";
    print_r(get_object_vars($company));
}
  
echo "\n\n--------\n";
echo "get with other values set. / no result \n";

$company = PDO_DataObject::factory('Companies');
$company->isOwner = 1;
if (!$company->get(12)) {
    echo "correctly got no result\n";
}

echo "\n\n--------\n";
echo "get with conditions set.\n";

$company = PDO_DataObject::factory('Companies');
$company->where("updated_by > 10");
if (!$company->get(12)) {
    echo "correctly got no result\n";
}

 

?>
--EXPECT--
--------
Simple get by id call
PDO_DataObject   : databaseStructure       : CALL:[]
__construct==["mysql:dbname=gettest;host=localhost","user","pass",[]]
setAttribute==[3,2]
PDO_DataObject   : find       : true
PDO_DataObject   : QUERY       : dde36b8c2603ce0b7357c878a4c6ad50 : SELECT *
 FROM   Companies   
 WHERE ( (Companies.id = 12) ) 

QUERY: dde36b8c2603ce0b7357c878a4c6ad50
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 1
PDO_DataObject   : FETCH       : {"code":"MASL","name":"Modern (INTL) Access & Scaffolding Ltd","remarks":"","owner_id":"0","address":"","tel":"","fax":"","email":null,"id":"12","isOwner":"0","logo_id":"0","background_color":"","comptype":"","url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00","updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
PDO_DataObject   : find       : DONE
GOT result
Array
(
    [__table] => Companies
    [_PDO_DataObject_version] => @version@
    [_database_nickname] => gettest
    [N] => 1
    [_join] => 
    [_link_loaded] => 
    [id] => 12
    [code] => MASL
    [name] => Modern (INTL) Access & Scaffolding Ltd
    [remarks] => 
    [owner_id] => 0
    [address] => 
    [tel] => 
    [fax] => 
    [email] => 
    [isOwner] => 0
    [logo_id] => 0
    [background_color] => 
    [comptype] => 
    [url] => 
    [main_office_id] => 0
    [created_by] => 0
    [created_dt] => 0000-00-00 00:00:00
    [updated_by] => 0
    [updated_dt] => 0000-00-00 00:00:00
)


--------
get by id / no results
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : find       : true
PDO_DataObject   : QUERY       : 4f8bbbe831550e7ece687a7f98bbdb32 : SELECT *
 FROM   Companies   
 WHERE ( (Companies.id = 13) ) 

QUERY: 4f8bbbe831550e7ece687a7f98bbdb32
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
correctly got no result


--------
get by key value
PDO_DataObject   : find       : true
PDO_DataObject   : QUERY       : ba1ed5f8fbeba84966d40094fc0771f4 : SELECT *
 FROM   Companies   
 WHERE ( (Companies.email  = 'test@example.com') ) 

QUERY: ba1ed5f8fbeba84966d40094fc0771f4
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 1
PDO_DataObject   : FETCH       : {"code":"MASL","name":"Modern (INTL) Access & Scaffolding Ltd","remarks":"","owner_id":"0","address":"","tel":"","fax":"","email":"test@example.com","id":"15","isOwner":"0","logo_id":"0","background_color":"","comptype":"","url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00","updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
PDO_DataObject   : find       : DONE
GOT result
Array
(
    [__table] => Companies
    [_PDO_DataObject_version] => @version@
    [_database_nickname] => gettest
    [N] => 1
    [_join] => 
    [_link_loaded] => 
    [email] => test@example.com
    [code] => MASL
    [name] => Modern (INTL) Access & Scaffolding Ltd
    [remarks] => 
    [owner_id] => 0
    [address] => 
    [tel] => 
    [fax] => 
    [id] => 15
    [isOwner] => 0
    [logo_id] => 0
    [background_color] => 
    [comptype] => 
    [url] => 
    [main_office_id] => 0
    [created_by] => 0
    [created_dt] => 0000-00-00 00:00:00
    [updated_by] => 0
    [updated_dt] => 0000-00-00 00:00:00
)


--------
get with other values set. / no result 
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : find       : true
PDO_DataObject   : QUERY       : b72a52d4f5f0ada645dcf4e594992766 : SELECT *
 FROM   Companies   
 WHERE ( (Companies.id = 12) AND (Companies.isOwner = 1) ) 

QUERY: b72a52d4f5f0ada645dcf4e594992766
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
correctly got no result


--------
get with conditions set.
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : find       : true
PDO_DataObject   : QUERY       : e3d46f1f19d5a7eacbd4e5464358b26e : SELECT *
 FROM   Companies   
 WHERE ( ( updated_by > 10 ) AND (Companies.id = 12) ) 

QUERY: e3d46f1f19d5a7eacbd4e5464358b26e
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
correctly got no result