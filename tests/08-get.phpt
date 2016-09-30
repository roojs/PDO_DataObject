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
PDO_DataObject   : QUERY       : 99589c46dbd978ffe3f382d56e38be75 : SELECT *
 FROM   Companies   
 WHERE ( (Companies.id = 12) )  
 

QUERY: 99589c46dbd978ffe3f382d56e38be75
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
PDO_DataObject   : QUERY       : 0171501aea9c3a9ec2df4ae3d2a936a4 : SELECT *
 FROM   Companies   
 WHERE ( (Companies.id = 13) )  
 

QUERY: 0171501aea9c3a9ec2df4ae3d2a936a4
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
correctly got no result


--------
get by key value
PDO_DataObject   : find       : true
PDO_DataObject   : QUERY       : cbd9c7848089dfd2e47f930f24c423dc : SELECT *
 FROM   Companies   
 WHERE ( (Companies.email  = 'test@example.com') )  
 

QUERY: cbd9c7848089dfd2e47f930f24c423dc
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
PDO_DataObject   : QUERY       : d75c2aa04f615504daa9b0e152c460b3 : SELECT *
 FROM   Companies   
 WHERE ( (Companies.id = 12) AND (Companies.isOwner = 1) )  
 

QUERY: d75c2aa04f615504daa9b0e152c460b3
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
correctly got no result


--------
get with conditions set.
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : find       : true
PDO_DataObject   : QUERY       : 91094393302d56a8ca0cf0c424afbe8f : SELECT *
 FROM   Companies   
 WHERE ( WHERE ( updated_by > 10 ) AND (Companies.id = 12) )  
 

QUERY: 91094393302d56a8ca0cf0c424afbe8f
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
correctly got no result