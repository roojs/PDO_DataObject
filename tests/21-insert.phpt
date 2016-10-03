--TEST--
fetchAll() test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
    
        // 'database' => 'mysql://user:pass@localhost/inserttest'
    // real db...
        'database' => 'mysql://root:@localhost/pman',
        'databases' => array(
            'inserttest' => 'mysql://root:@localhost/pman',
        ),
         'PDO' => 'PDO',        'proxy' => 'full',
));

PDO_DataObject::debugLevel(1);
 


echo "\n\n--------\n";
echo "simple insert;\n" ;

$event = PDO_DataObject::factory('Events');
$event ->set(array(
    'evtype' => 'TEST',
    'remarks' => 'a test event',

));
$event->insert();



?>
--EXPECT--
--------
single col - fetchAll('id');
__construct==["mysql:dbname=gettest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY: 23df5cd6e811c14da7711b51d7298521
Array
(
    [0] => 2
    [1] => 4
    [2] => 6
)


--------
single col - fetchAll(true);
QUERY: 33f59edd5519f8086b193b7f9132403d
Array
(
    [0] => 29
    [1] => 19
    [2] => 17
)


--------
single col -  select('name'), fetchAll('name');
QUERY: 9beebf44ab64393f0c2b80f9d7f1172b
Array
(
    [0] => Vinski Web
    [1] => Modern (INTL) Access & Scaffolding Ltd
    [2] => HK Domain Registry
)


--------
associative array
QUERY: d4905245ba332d8a3f42024e1e09c124
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
QUERY: ebba0af48c52cc567e77a69664b3addb
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Close Cursor
DataObjects_Companies 15
DataObjects_Companies 16
DataObjects_Companies 17


--------
array of arrays (faster version - no dataObject created)
QUERY: ebba0af48c52cc567e77a69664b3addb
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
QUERY: ebba0af48c52cc567e77a69664b3addb
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
QUERY: ebba0af48c52cc567e77a69664b3addb
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