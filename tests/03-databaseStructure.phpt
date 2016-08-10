--TEST--
databaseStructure
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);

echo "\n\nSINGLE INI FILE \n";
// test structure from single ini file
PDO_DataObject::$config['schema_location'] = dirname(__FILE__).'/includes/';
PDO_DataObject::$config['database']='mysql://username:test@localhost:3344/somedb';
$obj = new PDO_DataObject();
$obj->__table = 'account_code';

print_r($obj->databaseStructure('somedb', false));


echo "\n\TWO INI FILES\n";
// test structure from two ini files. (using database)
PDO_DataObject::$config['databases']['anotherdb']='mysql://username:test@localhost:3344/anotherdb';

$obj = new PDO_DataObject();
$obj->__table = 'account_transaction';
$obj->_database = 'anotherdb'; // this method is not advised as it's not very portable...

// does not actually connect to the DB - as we only do a db connection if we do not know the database name..
print_r($obj->databaseStructure('anotherdb', false));



/*
// -- normally disabled - used to geenrate the test data...

echo "\n\nREAL DATABASE CONNECT - NOT IN FINAL TEST\n";

PDO_DataObject::$config['PDO'] = 'PDO';
PDO_DataObject::$config['tables']['account_transaction']='hebe';
PDO_DataObject::$config['databases']['hebe']='mysql://root:@localhost/hebe';

PDO_DataObject::$config['proxy'] = true;

$obj = new PDO_DataObject();
$obj->__table = 'account_transaction';
$obj->PDO(true);
print_r($obj->databaseStructure('hebe'));
*/




// test structure from introspection

echo "\n\DATABASE INSTROSPECT\n";
 
PDO_DataObject::$config['proxy'] = true;
print_r($obj->databaseStructure('anotherdb'));




// set structure + retrieve it.
// test not really needed as proxy really tests this..

 
// test error conditions?!? 
// not sure about this one...



?>
--EXPECT--
SINGLE INI FILE 
PDO_DataObject   : databaseStructure       : ["somedb",false]
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
Array
(
    [account_code] => Array
        (
            [id] => 129
            [name] => 2
            [description] => 2
            [cost_center] => 1
            [accpac] => 2
            [accpac_out] => 2
        )

    [account_code__keys] => Array
        (
            [id] => N
        )

)

\TWO INI FILES
PDO_DataObject   : databaseStructure       : ["anotherdb",false]
Array
(
    [account_transaction] => Array
        (
            [id] => 129
            [member] => 1
            [at_date] => 6
            [voucher_number] => 2
            [chit_number] => 2
            [cheque_number] => 2
            [reverse_id] => 1
            [account_code] => 1
            [value] => 1
            [description_old] => 2
            [sequence_no] => 1
            [ts] => 2
            [description] => 2
        )

    [account_transaction__keys] => Array
        (
            [id] => N
        )

)

\DATABASE INSTROSPECT
PDO_DataObject   : databaseStructure       : ["anotherdb"]
PDO_DataObject   : CONNECT       : Checking for database specific ini ('anotherdb') : config[databases][anotherdb] in options
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","username","test",[]]
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : 1       : Loading Generator as databaseStructure called with args
PDO_DataObject   : CONNECT       : Checking for database specific ini ('anotherdb') : config[databases][anotherdb] in options
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : QUERY       : SHOW TABLES
QUERY: SHOW TABLES  
PDO_DataObject   : query       : QUERY DONE IN  0.0001380443572998 seconds
PDO_DataObject   : query       : NO# of results: 3
Fetch Row 0 / 3
PDO_DataObject   : FETCH       : {"Tables_in_somedb":"Companies"}
Fetch Row 1 / 3
PDO_DataObject   : FETCH       : {"Tables_in_somedb":"Events"}
Fetch Row 2 / 3
PDO_DataObject   : FETCH       : {"Tables_in_somedb":"Groups"}
Fetch Row 3 / 3
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.00012302398681641 seconds
Close Cursor
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : CONNECT       : Checking for database specific ini ('anotherdb') : config[databases][anotherdb] in options
PDO_DataObject   : CONNECT       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : ERROR       : Can not get Listof schema.tables
PDO_DataObject   : CONNECT       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : QUERY       : DESCRIBE Companies
QUERY: DESCRIBE Companies  
PDO_DataObject   : query       : QUERY DONE IN  5.0783157348633E-5 seconds
PDO_DataObject   : query       : NO# of results: 23
Fetch Row 0 / 23
PDO_DataObject   : FETCH       : {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"}
Fetch Row 1 / 23
PDO_DataObject   : FETCH       : {"Field":"code","Type":"varchar(32)","Null":"NO","Key":"","Default":"","Extra":""}
Fetch Row 2 / 23
PDO_DataObject   : FETCH       : {"Field":"name","Type":"varchar(128)","Null":"YES","Key":"MUL","Default":null,"Extra":""}
Fetch Row 3 / 23
PDO_DataObject   : FETCH       : {"Field":"remarks","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""}
Fetch Row 4 / 23
PDO_DataObject   : FETCH       : {"Field":"owner_id","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
Fetch Row 5 / 23
PDO_DataObject   : FETCH       : {"Field":"address","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""}
Fetch Row 6 / 23
PDO_DataObject   : FETCH       : {"Field":"tel","Type":"varchar(32)","Null":"YES","Key":"","Default":null,"Extra":""}
Fetch Row 7 / 23
PDO_DataObject   : FETCH       : {"Field":"fax","Type":"varchar(32)","Null":"YES","Key":"","Default":null,"Extra":""}
Fetch Row 8 / 23
PDO_DataObject   : FETCH       : {"Field":"email","Type":"varchar(128)","Null":"YES","Key":"","Default":null,"Extra":""}
Fetch Row 9 / 23
PDO_DataObject   : FETCH       : {"Field":"isOwner","Type":"int(11)","Null":"YES","Key":"","Default":null,"Extra":""}
Fetch Row 10 / 23
PDO_DataObject   : FETCH       : {"Field":"logo_id","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
Fetch Row 11 / 23
PDO_DataObject   : FETCH       : {"Field":"background_color","Type":"varchar(8)","Null":"NO","Key":"","Default":null,"Extra":""}
Fetch Row 12 / 23
PDO_DataObject   : FETCH       : {"Field":"comptype","Type":"varchar(32)","Null":"YES","Key":"","Default":"","Extra":""}
Fetch Row 13 / 23
PDO_DataObject   : FETCH       : {"Field":"url","Type":"varchar(254)","Null":"NO","Key":"","Default":"","Extra":""}
Fetch Row 14 / 23
PDO_DataObject   : FETCH       : {"Field":"main_office_id","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
Fetch Row 15 / 23
PDO_DataObject   : FETCH       : {"Field":"created_by","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
Fetch Row 16 / 23
PDO_DataObject   : FETCH       : {"Field":"created_dt","Type":"datetime","Null":"NO","Key":"","Default":null,"Extra":""}
Fetch Row 17 / 23
PDO_DataObject   : FETCH       : {"Field":"updated_by","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
Fetch Row 18 / 23
PDO_DataObject   : FETCH       : {"Field":"updated_dt","Type":"datetime","Null":"NO","Key":"","Default":null,"Extra":""}
Fetch Row 19 / 23
PDO_DataObject   : FETCH       : {"Field":"passwd","Type":"varchar(64)","Null":"NO","Key":"","Default":"","Extra":""}
Fetch Row 20 / 23
PDO_DataObject   : FETCH       : {"Field":"dispatch_port","Type":"varchar(255)","Null":"NO","Key":"","Default":"","Extra":""}
Fetch Row 21 / 23
PDO_DataObject   : FETCH       : {"Field":"province","Type":"varchar(255)","Null":"NO","Key":"","Default":"","Extra":""}
Fetch Row 22 / 23
PDO_DataObject   : FETCH       : {"Field":"country","Type":"varchar(4)","Null":"NO","Key":"","Default":"","Extra":""}
Fetch Row 23 / 23
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.00046014785766602 seconds
Close Cursor
PDO_DataObject   : CONNECT       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : databaseStructure       : ["anotherdb",{"Companies":{"id":129,"code":130,"name":2,"remarks":34,"owner_id":129,"address":34,"tel":2,"fax":2,"email":2,"isOwner":1,"logo_id":129,"background_color":130,"comptype":2,"url":130,"main_office_id":129,"created_by":129,"created_dt":142,"updated_by":129,"updated_dt":142,"passwd":130,"dispatch_port":130,"province":130,"country":130},"Companies__keys":{"id":"N"}}]
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : CONNECT       : Checking for database specific ini ('anotherdb') : config[databases][anotherdb] in options
PDO_DataObject   : CONNECT       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : ERROR       : Can not get Listof schema.tables
PDO_DataObject   : CONNECT       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : QUERY       : DESCRIBE Events
QUERY: DESCRIBE Events  
PDO_DataObject   : query       : QUERY DONE IN  3.0040740966797E-5 seconds
PDO_DataObject   : query       : NO# of results: 10
Fetch Row 0 / 10
PDO_DataObject   : FETCH       : {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"}
Fetch Row 1 / 10
PDO_DataObject   : FETCH       : {"Field":"person_name","Type":"varchar(128)","Null":"YES","Key":"","Default":null,"Extra":""}
Fetch Row 2 / 10
PDO_DataObject   : FETCH       : {"Field":"event_when","Type":"datetime","Null":"YES","Key":"MUL","Default":null,"Extra":""}
Fetch Row 3 / 10
PDO_DataObject   : FETCH       : {"Field":"action","Type":"varchar(32)","Null":"YES","Key":"MUL","Default":null,"Extra":""}
Fetch Row 4 / 10
PDO_DataObject   : FETCH       : {"Field":"ipaddr","Type":"varchar(16)","Null":"YES","Key":"","Default":null,"Extra":""}
Fetch Row 5 / 10
PDO_DataObject   : FETCH       : {"Field":"on_id","Type":"int(11)","Null":"YES","Key":"MUL","Default":null,"Extra":""}
Fetch Row 6 / 10
PDO_DataObject   : FETCH       : {"Field":"on_table","Type":"varchar(64)","Null":"YES","Key":"MUL","Default":null,"Extra":""}
Fetch Row 7 / 10
PDO_DataObject   : FETCH       : {"Field":"person_id","Type":"int(11)","Null":"YES","Key":"","Default":null,"Extra":""}
Fetch Row 8 / 10
PDO_DataObject   : FETCH       : {"Field":"person_table","Type":"varchar(64)","Null":"YES","Key":"MUL","Default":null,"Extra":""}
Fetch Row 9 / 10
PDO_DataObject   : FETCH       : {"Field":"remarks","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""}
Fetch Row 10 / 10
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.00021886825561523 seconds
Close Cursor
PDO_DataObject   : CONNECT       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : databaseStructure       : ["anotherdb",{"Events":{"id":129,"person_name":2,"event_when":14,"action":2,"ipaddr":2,"on_id":1,"on_table":2,"person_id":1,"person_table":2,"remarks":34},"Events__keys":{"id":"N"}}]
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : CONNECT       : Checking for database specific ini ('anotherdb') : config[databases][anotherdb] in options
PDO_DataObject   : CONNECT       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : ERROR       : Can not get Listof schema.tables
PDO_DataObject   : CONNECT       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : QUERY       : DESCRIBE Groups
QUERY: DESCRIBE Groups  
PDO_DataObject   : query       : QUERY DONE IN  1.6927719116211E-5 seconds
PDO_DataObject   : query       : NO# of results: 4
Fetch Row 0 / 4
PDO_DataObject   : FETCH       : {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"}
Fetch Row 1 / 4
PDO_DataObject   : FETCH       : {"Field":"name","Type":"varchar(64)","Null":"NO","Key":"","Default":"","Extra":""}
Fetch Row 2 / 4
PDO_DataObject   : FETCH       : {"Field":"type","Type":"int(11)","Null":"YES","Key":"","Default":"0","Extra":""}
Fetch Row 3 / 4
PDO_DataObject   : FETCH       : {"Field":"leader","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
Fetch Row 4 / 4
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.0001060962677002 seconds
Close Cursor
PDO_DataObject   : CONNECT       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : databaseStructure       : ["anotherdb",{"Groups":{"id":129,"name":130,"type":1,"leader":129},"Groups__keys":{"id":"N"}}]
PDO_DataObject   : databaseStructure       : ["anotherdb",false]
Array
(
    [account_transaction] => Array
        (
            [id] => 129
            [member] => 1
            [at_date] => 6
            [voucher_number] => 2
            [chit_number] => 2
            [cheque_number] => 2
            [reverse_id] => 1
            [account_code] => 1
            [value] => 1
            [description_old] => 2
            [sequence_no] => 1
            [ts] => 2
            [description] => 2
        )

    [account_transaction__keys] => Array
        (
            [id] => N
        )

    [Companies] => Array
        (
            [id] => 129
            [code] => 130
            [name] => 2
            [remarks] => 34
            [owner_id] => 129
            [address] => 34
            [tel] => 2
            [fax] => 2
            [email] => 2
            [isOwner] => 1
            [logo_id] => 129
            [background_color] => 130
            [comptype] => 2
            [url] => 130
            [main_office_id] => 129
            [created_by] => 129
            [created_dt] => 142
            [updated_by] => 129
            [updated_dt] => 142
            [passwd] => 130
            [dispatch_port] => 130
            [province] => 130
            [country] => 130
        )

    [Companies__keys] => Array
        (
            [id] => N
        )

    [Events] => Array
        (
            [id] => 129
            [person_name] => 2
            [event_when] => 14
            [action] => 2
            [ipaddr] => 2
            [on_id] => 1
            [on_table] => 2
            [person_id] => 1
            [person_table] => 2
            [remarks] => 34
        )

    [Events__keys] => Array
        (
            [id] => N
        )

    [Groups] => Array
        (
            [id] => 129
            [name] => 130
            [type] => 1
            [leader] => 129
        )

    [Groups__keys] => Array
        (
            [id] => N
        )

)
