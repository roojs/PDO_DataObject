--TEST--
fetchAll() test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
        'database' => 'mysql://user:pass@localhost/gettest'
    // real db...
      //  'database' => 'mysql://root:@localhost/pman',
      //   'PDO' => 'PDO',        'proxy' => 'full',
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
echo "array of objects set key \n" ;
$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
$ar = $company->fetchAll(false,'name');
foreach($ar as $k=>$a) {
    echo $k . '=> ' . get_class($a) . " {$a->id}\n";
}

echo "\n\n--------\n";
echo "array of objects using primary key\n" ;
$company = PDO_DataObject::factory('Companies');
$company->comptype = 'CONSULTANT';
$company->limit(3);
$ar = $company->fetchAll(false,true);
foreach($ar as $k=>$a) {
    echo $k . '=> ' . get_class($a) . " {$a->id}\n";
}

echo "\n\n--------\n";
echo "array of objects using closures\n" ;
PDO_DataObject::factory('Companies')
    ->set(['comptype' => 'CONSULTANT' ])
    ->limit(3)
    ->fetchAll(function($row) {
            echo "callback" . $this->name ."\n";
            $this->snapshot()
                ->set(['code' => $this->code . '-add a bit'])
                ->save();
                // do an update on it..
           
    
    });









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
--------
single col - fetchAll('id');
__construct==["mysql:dbname=gettest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:23df5cd6e811c14da7711b51d7298521:
SELECT id
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) ORDER BY id ASC  
 LIMIT  3
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Array
(
    [0] => 2
    [1] => 4
    [2] => 6
)


--------
single col - fetchAll(true);
QUERY:33f59edd5519f8086b193b7f9132403d:
SELECT LENGTH(name)
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) ORDER BY LENGTH(name) DESC  
 LIMIT  3
Array
(
    [0] => 29
    [1] => 19
    [2] => 17
)


--------
single col -  select('name'), fetchAll('name');
QUERY:9beebf44ab64393f0c2b80f9d7f1172b:
SELECT *,  name
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Array
(
    [0] => Vinski Web
    [1] => Modern (INTL) Access & Scaffolding Ltd
    [2] => HK Domain Registry
)


--------
associative array
QUERY:d4905245ba332d8a3f42024e1e09c124:
SELECT id ,  name
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Array
(
    [15] => Vinski Web
    [16] => Modern (INTL) Access & Scaffolding Ltd
    [17] => HK Domain Registry
)


--------
array of objects
QUERY:ebba0af48c52cc567e77a69664b3addb:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Close Cursor
DataObjects_Companies 15
DataObjects_Companies 16
DataObjects_Companies 17


--------
array of objects set key 
QUERY:ebba0af48c52cc567e77a69664b3addb:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Close Cursor
Vinski Web=> DataObjects_Companies 15
Modern (INTL) Access & Scaffolding Ltd=> DataObjects_Companies 16
HK Domain Registry=> DataObjects_Companies 17


--------
array of objects using primary key
QUERY:ebba0af48c52cc567e77a69664b3addb:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Close Cursor
15=> DataObjects_Companies 15
16=> DataObjects_Companies 16
17=> DataObjects_Companies 17


--------
array of objects using closures
QUERY:ebba0af48c52cc567e77a69664b3addb:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Fetch Row 0 / 3
callbackVinski Web
QUERY:484572458888176050c44ae140ba1190:
UPDATE  Companies  SET code = 'vinski-add a bit'  WHERE (Companies.id = 15) 
Fetch Row 1 / 3
callbackModern (INTL) Access & Scaffolding Ltd
QUERY:c5dd2edd3e0b599889c895382284ac70:
UPDATE  Companies  SET code = 'MASL-add a bit'  WHERE (Companies.id = 16) 
Fetch Row 2 / 3
callbackHK Domain Registry
QUERY:c859fde34ab3312a29b61eb1a7b66148:
UPDATE  Companies  SET code = 'HKDNR-add a bit'  WHERE (Companies.id = 17) 
Fetch Row 3 / 3
Close Cursor


--------
array of arrays (faster version - no dataObject created)
QUERY:ebba0af48c52cc567e77a69664b3addb:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Array
(
    [0] => Array
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
        )

    [1] => Array
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
        )

    [2] => Array
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
        )

)


--------
array of arrays  - fetchAllAssoc - aliased method (faster version - no dataObject created)
QUERY:ebba0af48c52cc567e77a69664b3addb:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Array
(
    [0] => Array
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
        )

    [1] => Array
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
        )

    [2] => Array
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
        )

)


--------
array of arrays (by calling toArray())
QUERY:ebba0af48c52cc567e77a69664b3addb:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  3
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Close Cursor
Array
(
    [0] => Array
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

    [1] => Array
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

    [2] => Array
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

)