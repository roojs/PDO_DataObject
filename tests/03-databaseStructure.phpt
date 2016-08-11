--TEST--
databaseStructure
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);

PDO_DataObject::config(array_merge
    PDO_DataObject::config(),
    array(
        'databases' => array(
            'mysql_somedb' => 'mysql://username:test@localhost:3344/somedb';
        )
    )
);



echo "\n\nSINGLE INI FILE \n";

// test structure from single ini file
PDO_DataObject::$config['schema_location'] = dirname(__FILE__).'/includes/';
PDO_DataObject::$config['database']='mysql://username:test@localhost:3344/somedb';
$obj = new PDO_DataObject();
$obj->__table = 'account_code';

print_r($obj->databaseStructure('somedb', false));


echo "\n\TWO INI FILES\n";
(new PDO_DataObject())->reset();
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

(new PDO_DataObject())->reset();
PDO_DataObject::$config['PDO'] = 'PDO';
PDO_DataObject::$config['tables']['account_transaction']='hebe';
PDO_DataObject::$config['databases']['hebe']='mysql://root:@localhost/hebe';

PDO_DataObject::$config['proxy'] = true;

$obj = new PDO_DataObject();
$obj->__table = 'account_transaction';
$obj->PDO();
print_r($obj->databaseStructure('hebe'));

echo "\n\nREAL DATABASE CONNECT - NOT IN FINAL TEST\n";
(new PDO_DataObject())->reset();
PDO_DataObject::$config['PDO'] = 'PDO';
PDO_DataObject::$config['tables']['accnt']='xtuplehk';
PDO_DataObject::$config['databases']['xtuplehk']='pgsql://admin:pass4xtuple@localhost/xtuplehk';
PDO_DataObject::$config['proxy'] = true;
PDO_DataObject::debugLevel(1);

$obj = new PDO_DataObject();
$obj->__table = 'accnt';
$obj->PDO();
print_r($obj->databaseStructure('xtuplehk'));

PDO_DataObject::$config['PDO'] = 'PDO_Dummy';


*/


// test structure from introspection

echo "\n\nDATABASE INSTROSPECT - mysql dummy\n";
(new PDO_DataObject())->reset();

PDO_DataObject::$config['tables']['Events']='anotherdb';

$obj = new PDO_DataObject();
$obj->__table = 'Events';
$obj->PDO();
PDO_DataObject::$config['proxy'] = true;
print_r($obj->databaseStructure('anotherdb'));



 
// postgresql
echo "\n\nDATABASE INSTROSPECT - mysql postgres dummyu\n";
(new PDO_DataObject())->reset();
PDO_DataObject::$config['tables']['accnt']='xtuplehk';
PDO_DataObject::$config['databases']['xtuplehk']='pgsql://user:nopass@localhost/xtuple';
PDO_DataObject::$config['proxy'] = true;

$obj = new PDO_DataObject();
$obj->__table = 'accnt';
$obj->PDO();
print_r($obj->databaseStructure('xtuplehk'));

 
// sqlite
PDO_DataObject::$config['PDO'] = 'PDO'; // we can do this for real...

 
PDO_DataObject::$config['tables']['Customers']='EssentialSQL';
PDO_DataObject::$config['databases']['EssentialSQL']='sqlite:'.__DIR__.'/includes/EssentialSQL.db';
PDO_DataObject::$config['proxy'] = true;
PDO_DataObject::debugLevel(1);
$obj = new PDO_DataObject();
$obj->__table = 'Customers';
$obj->PDO(true);
print_r($obj->databaseStructure('EssentialSQL'));


// set structure + retrieve it.
// test not really needed as proxy really tests this..

 
// test error conditions?!? 
// not sure about this one...



?>
--EXPECT--
SINGLE INI FILE 
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
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
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
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


DATABASE INSTROSPECT - mysql dummy
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
getAttribute==[16] => mysql
getAttribute==[16] => mysql
QUERY: SHOW TABLES  
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Close Cursor
getAttribute==[16] => mysql
getAttribute==[16] => mysql
QUERY: DESCRIBE Companies  
Fetch Row 0 / 23
Fetch Row 1 / 23
Fetch Row 2 / 23
Fetch Row 3 / 23
Fetch Row 4 / 23
Fetch Row 5 / 23
Fetch Row 6 / 23
Fetch Row 7 / 23
Fetch Row 8 / 23
Fetch Row 9 / 23
Fetch Row 10 / 23
Fetch Row 11 / 23
Fetch Row 12 / 23
Fetch Row 13 / 23
Fetch Row 14 / 23
Fetch Row 15 / 23
Fetch Row 16 / 23
Fetch Row 17 / 23
Fetch Row 18 / 23
Fetch Row 19 / 23
Fetch Row 20 / 23
Fetch Row 21 / 23
Fetch Row 22 / 23
Fetch Row 23 / 23
Close Cursor
getAttribute==[16] => mysql
getAttribute==[16] => mysql
getAttribute==[16] => mysql
QUERY: DESCRIBE Events  
Fetch Row 0 / 10
Fetch Row 1 / 10
Fetch Row 2 / 10
Fetch Row 3 / 10
Fetch Row 4 / 10
Fetch Row 5 / 10
Fetch Row 6 / 10
Fetch Row 7 / 10
Fetch Row 8 / 10
Fetch Row 9 / 10
Fetch Row 10 / 10
Close Cursor
getAttribute==[16] => mysql
getAttribute==[16] => mysql
getAttribute==[16] => mysql
QUERY: DESCRIBE Groups  
Fetch Row 0 / 4
Fetch Row 1 / 4
Fetch Row 2 / 4
Fetch Row 3 / 4
Fetch Row 4 / 4
Close Cursor
getAttribute==[16] => mysql
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


DATABASE INSTROSPECT - mysql postgres dummyu
__construct==["pgsql:dbname=xtuple;host=localhost","user","nopass",[]]
setAttribute==[3,2]
getAttribute==[16] => pgsql
getAttribute==[16] => pgsql
QUERY: SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'public' order by table_name ASC  
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Close Cursor
getAttribute==[16] => pgsql
getAttribute==[16] => pgsql
QUERY: SELECT  
                        f.attnum AS number,  
                        f.attname AS name,  
                        f.attnum,  
                        f.attnotnull AS notnull,  
                        pg_catalog.format_type(f.atttypid,f.atttypmod) AS type,  
                        CASE  
                            WHEN p.contype = 'p' THEN 't'  
                            ELSE 'f'  
                        END AS primarykey,  
                        CASE  
                            WHEN p.contype = 'u' THEN 't'  
                            ELSE 'f'
                        END AS uniquekey,
                        CASE
                            WHEN p.contype = 'f' THEN g.relname
                        END AS foreignkey,
                        CASE
                            WHEN p.contype = 'f' THEN p.confkey
                        END AS foreignkey_fieldnum,
                        CASE
                            WHEN p.contype = 'f' THEN g.relname
                        END AS foreignkey,
                        CASE
                            WHEN p.contype = 'f' THEN p.conkey
                        END AS foreignkey_connnum,
                        CASE
                            WHEN f.atthasdef = 't' THEN d.adsrc
                        END AS default
                    FROM pg_attribute f  
                        JOIN pg_class c ON c.oid = f.attrelid  
                        JOIN pg_type t ON t.oid = f.atttypid  
                        LEFT JOIN pg_attrdef d ON d.adrelid = c.oid AND d.adnum = f.attnum  
                        LEFT JOIN pg_namespace n ON n.oid = c.relnamespace  
                        LEFT JOIN pg_constraint p ON p.conrelid = c.oid AND f.attnum = ANY (p.conkey)  
                        LEFT JOIN pg_class AS g ON p.confrelid = g.oid  
                    WHERE c.relkind = 'r'::char  
                        AND n.nspname = 'public'  
                        AND c.relname = 'acalitem'  
                        AND f.attnum > 0 ORDER BY number
              
Fetch Row 0 / 5
Fetch Row 1 / 5
Fetch Row 2 / 5
Fetch Row 3 / 5
Fetch Row 4 / 5
Fetch Row 5 / 5
Close Cursor
getAttribute==[16] => pgsql
getAttribute==[16] => pgsql
getAttribute==[16] => pgsql
QUERY: SELECT  
                        f.attnum AS number,  
                        f.attname AS name,  
                        f.attnum,  
                        f.attnotnull AS notnull,  
                        pg_catalog.format_type(f.atttypid,f.atttypmod) AS type,  
                        CASE  
                            WHEN p.contype = 'p' THEN 't'  
                            ELSE 'f'  
                        END AS primarykey,  
                        CASE  
                            WHEN p.contype = 'u' THEN 't'  
                            ELSE 'f'
                        END AS uniquekey,
                        CASE
                            WHEN p.contype = 'f' THEN g.relname
                        END AS foreignkey,
                        CASE
                            WHEN p.contype = 'f' THEN p.confkey
                        END AS foreignkey_fieldnum,
                        CASE
                            WHEN p.contype = 'f' THEN g.relname
                        END AS foreignkey,
                        CASE
                            WHEN p.contype = 'f' THEN p.conkey
                        END AS foreignkey_connnum,
                        CASE
                            WHEN f.atthasdef = 't' THEN d.adsrc
                        END AS default
                    FROM pg_attribute f  
                        JOIN pg_class c ON c.oid = f.attrelid  
                        JOIN pg_type t ON t.oid = f.atttypid  
                        LEFT JOIN pg_attrdef d ON d.adrelid = c.oid AND d.adnum = f.attnum  
                        LEFT JOIN pg_namespace n ON n.oid = c.relnamespace  
                        LEFT JOIN pg_constraint p ON p.conrelid = c.oid AND f.attnum = ANY (p.conkey)  
                        LEFT JOIN pg_class AS g ON p.confrelid = g.oid  
                    WHERE c.relkind = 'r'::char  
                        AND n.nspname = 'public'  
                        AND c.relname = 'accnt'  
                        AND f.attnum > 0 ORDER BY number
              
Fetch Row 0 / 17
Fetch Row 1 / 17
Fetch Row 2 / 17
Fetch Row 3 / 17
Fetch Row 4 / 17
Fetch Row 5 / 17
Fetch Row 6 / 17
Fetch Row 7 / 17
Fetch Row 8 / 17
Fetch Row 9 / 17
Fetch Row 10 / 17
Fetch Row 11 / 17
Fetch Row 12 / 17
Fetch Row 13 / 17
Fetch Row 14 / 17
Fetch Row 15 / 17
Fetch Row 16 / 17
Fetch Row 17 / 17
Close Cursor
getAttribute==[16] => pgsql
getAttribute==[16] => pgsql
getAttribute==[16] => pgsql
QUERY: SELECT  
                        f.attnum AS number,  
                        f.attname AS name,  
                        f.attnum,  
                        f.attnotnull AS notnull,  
                        pg_catalog.format_type(f.atttypid,f.atttypmod) AS type,  
                        CASE  
                            WHEN p.contype = 'p' THEN 't'  
                            ELSE 'f'  
                        END AS primarykey,  
                        CASE  
                            WHEN p.contype = 'u' THEN 't'  
                            ELSE 'f'
                        END AS uniquekey,
                        CASE
                            WHEN p.contype = 'f' THEN g.relname
                        END AS foreignkey,
                        CASE
                            WHEN p.contype = 'f' THEN p.confkey
                        END AS foreignkey_fieldnum,
                        CASE
                            WHEN p.contype = 'f' THEN g.relname
                        END AS foreignkey,
                        CASE
                            WHEN p.contype = 'f' THEN p.conkey
                        END AS foreignkey_connnum,
                        CASE
                            WHEN f.atthasdef = 't' THEN d.adsrc
                        END AS default
                    FROM pg_attribute f  
                        JOIN pg_class c ON c.oid = f.attrelid  
                        JOIN pg_type t ON t.oid = f.atttypid  
                        LEFT JOIN pg_attrdef d ON d.adrelid = c.oid AND d.adnum = f.attnum  
                        LEFT JOIN pg_namespace n ON n.oid = c.relnamespace  
                        LEFT JOIN pg_constraint p ON p.conrelid = c.oid AND f.attnum = ANY (p.conkey)  
                        LEFT JOIN pg_class AS g ON p.confrelid = g.oid  
                    WHERE c.relkind = 'r'::char  
                        AND n.nspname = 'public'  
                        AND c.relname = 'addr'  
                        AND f.attnum > 0 ORDER BY number
              
Fetch Row 0 / 11
Fetch Row 1 / 11
Fetch Row 2 / 11
Fetch Row 3 / 11
Fetch Row 4 / 11
Fetch Row 5 / 11
Fetch Row 6 / 11
Fetch Row 7 / 11
Fetch Row 8 / 11
Fetch Row 9 / 11
Fetch Row 10 / 11
Fetch Row 11 / 11
Close Cursor
getAttribute==[16] => pgsql
Array
(
    [acalitem] => Array
        (
            [acalitem_id] => 129
            [acalitem_calhead_id] => 1
            [acalitem_periodstart] => 6
            [acalitem_periodlength] => 1
            [acalitem_name] => 34
        )

    [acalitem__keys] => Array
        (
            [acalitem_id] => xcalitem_xcalitem_id_seq
        )

    [accnt] => Array
        (
            [accnt_id] => 129
            [accnt_number] => 34
            [accnt_descrip] => 34
            [accnt_comments] => 34
            [accnt_profit] => 34
            [accnt_sub] => 34
            [accnt_type] => 130
            [accnt_extref] => 34
            [accnt_company] => 34
            [accnt_closedpost] => 18
            [accnt_forwardupdate] => 18
            [accnt_subaccnttype_code] => 34
            [accnt_curr_id] => 1
            [accnt_active] => 146
            [accnt_name] => 34
            [accnt_code_alt] => 34
            [accnt_descrip_alt] => 34
        )

    [accnt__keys] => Array
        (
            [accnt_id] => accnt_accnt_id_seq
        )

    [addr] => Array
        (
            [addr_id] => 129
            [addr_active] => 18
            [addr_line1] => 34
            [addr_line2] => 34
            [addr_line3] => 34
            [addr_city] => 34
            [addr_state] => 34
            [addr_postalcode] => 34
            [addr_country] => 34
            [addr_notes] => 34
            [addr_number] => 162
        )

    [addr__keys] => Array
        (
            [addr_id] => addr_addr_id_seq
        )

)
PDO_DataObject   : CONNECT       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL"]
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : 1       : Loading Generator as databaseStructure called with args for database = EssentialSQL
PDO_DataObject   : CONNECT       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : getListOf       : tables
PDO_DataObject   : getListOf       : SELECT name FROM sqlite_master WHERE type='table' UNION ALL SELECT name FROM sqlite_temp_master WHERE type='table' ORDER BY name
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : QUERY       : ea3ca8779fe015d52cc1a09a3bb4010d : SELECT name FROM sqlite_master WHERE type='table' UNION ALL SELECT name FROM sqlite_temp_master WHERE type='table' ORDER BY name
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : FETCH       : {"name":"Customers"}
PDO_DataObject   : FETCH       : {"name":"Employees"}
PDO_DataObject   : FETCH       : {"name":"OrderDetails"}
PDO_DataObject   : FETCH       : {"name":"Orders"}
PDO_DataObject   : FETCH       : {"name":"Shippers"}
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : CONNECT       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : QUERY       : e459bf5d26556fa01d255e9f4f45900f : PRAGMA table_info('Customers');
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : FETCH       : {"cid":"0","name":"CustomerID","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"1"}
PDO_DataObject   : FETCH       : {"cid":"1","name":"CompanyName","type":"VARCHAR(60)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"2","name":"ContactName","type":"VARCHAR(40)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"3","name":"ContactTitle","type":"VARCHAR(60)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"4","name":"Address","type":"VARCHAR(60)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"5","name":"City","type":"VARCHAR(60)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"6","name":"State","type":"VARCHAR(2)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",{"Customers":{"CustomerID":1,"CompanyName":2,"ContactName":2,"ContactTitle":2,"Address":2,"City":2,"State":2},"Customers__keys":{"CustomerID":"N"}}]
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : CONNECT       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : QUERY       : f4f6e6dea2ce91edc63339a63a63557d : PRAGMA table_info('Employees');
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : FETCH       : {"cid":"0","name":"EmployeeID","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"1"}
PDO_DataObject   : FETCH       : {"cid":"1","name":"LastName","type":"VARCHAR(20)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"2","name":"FirstName","type":"VARCHAR(20)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"3","name":"Title","type":"VARCHAR(60)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"4","name":"Address","type":"VARCHAR(40)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"5","name":"HireDate","type":"VARCHAR(25)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",{"Employees":{"EmployeeID":1,"LastName":2,"FirstName":2,"Title":2,"Address":2,"HireDate":2},"Employees__keys":{"EmployeeID":"N"}}]
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : CONNECT       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : QUERY       : 4be38faf7194500e1894f7d5150da013 : PRAGMA table_info('OrderDetails');
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : FETCH       : {"cid":"0","name":"OrderDetailID","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"1"}
PDO_DataObject   : FETCH       : {"cid":"1","name":"OrderID","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"2","name":"ProductID","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"3","name":"UnitPrice","type":"REAL","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"4","name":"Quantity","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",{"OrderDetails":{"OrderDetailID":1,"OrderID":1,"ProductID":1,"UnitPrice":1,"Quantity":1},"OrderDetails__keys":{"OrderDetailID":"N"}}]
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : CONNECT       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : QUERY       : d274cc9a18844d15cb63cad939785fba : PRAGMA table_info('Orders');
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : FETCH       : {"cid":"0","name":"OrderID","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"1"}
PDO_DataObject   : FETCH       : {"cid":"1","name":"CustomerID","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"2","name":"EmployeeID","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"3","name":"OrderDate","type":"VARCHAR(25)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"4","name":"RequiredDate","type":"VARCHAR(25)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"5","name":"ShippedDate","type":"VARCHAR(25)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"6","name":"ShipVia","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"7","name":"FreightCharge","type":"REAL","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",{"Orders":{"OrderID":1,"CustomerID":1,"EmployeeID":1,"OrderDate":2,"RequiredDate":2,"ShippedDate":2,"ShipVia":1,"FreightCharge":1},"Orders__keys":{"OrderID":"N"}}]
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : CONNECT       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : QUERY       : 02f4528d77058145e7f11034d44c4289 : PRAGMA table_info('Shippers');
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : FETCH       : {"cid":"0","name":"ShipperID","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"1"}
PDO_DataObject   : FETCH       : {"cid":"1","name":"CompanyName","type":"VARCHAR(60)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"2","name":"Phone","type":"VARCHAR(20)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",{"Shippers":{"ShipperID":1,"CompanyName":2,"Phone":2},"Shippers__keys":{"ShipperID":"N"}}]
PDO_DataObject   : CONNECT       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",false]
PDO_DataObject   : CONNECT       : Using Cached connection
Array
(
    [Customers] => Array
        (
            [CustomerID] => 1
            [CompanyName] => 2
            [ContactName] => 2
            [ContactTitle] => 2
            [Address] => 2
            [City] => 2
            [State] => 2
        )

    [Customers__keys] => Array
        (
            [CustomerID] => N
        )

    [Employees] => Array
        (
            [EmployeeID] => 1
            [LastName] => 2
            [FirstName] => 2
            [Title] => 2
            [Address] => 2
            [HireDate] => 2
        )

    [Employees__keys] => Array
        (
            [EmployeeID] => N
        )

    [OrderDetails] => Array
        (
            [OrderDetailID] => 1
            [OrderID] => 1
            [ProductID] => 1
            [UnitPrice] => 1
            [Quantity] => 1
        )

    [OrderDetails__keys] => Array
        (
            [OrderDetailID] => N
        )

    [Orders] => Array
        (
            [OrderID] => 1
            [CustomerID] => 1
            [EmployeeID] => 1
            [OrderDate] => 2
            [RequiredDate] => 2
            [ShippedDate] => 2
            [ShipVia] => 1
            [FreightCharge] => 1
        )

    [Orders__keys] => Array
        (
            [OrderID] => N
        )

    [Shippers] => Array
        (
            [ShipperID] => 1
            [CompanyName] => 2
            [Phone] => 2
        )

    [Shippers__keys] => Array
        (
            [ShipperID] => N
        )

)
