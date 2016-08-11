--TEST--
databaseStructure
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
$base_config = PDO_DataObject::config();



PDO_DataObject::config(
    array(
        'databases' => array(
            'mysql_somedb' => 'mysql://username:test@localhost:3344/somedb',
            'mysql_anotherdb' =>  'mysql://username:test@localhost:3344/anotherdb',
            
        ),
        'debug' => 1,
    )
);



echo "\n\nSINGLE INI FILE \n";

// test structure from single ini file

$obj = new PDO_DataObject('mysql_somedb/account_code');
print_r($obj->databaseStructure('mysql_somedb'));




echo "\n\MULTIPLE LOCATIONS INI FILES\n";
(new PDO_DataObject())->reset();


PDO_DataObject::config(
    array(
        'schema_location' => __DIR__.'/includes'.PATH_SEPARATOR .__DIR__.'/includes/test_ini'
    )
);
// test structure from two ini files. (using database)

$obj = new PDO_DataObject('mysql_anotherdb/account_transaction');
print_r($obj->databaseStructure('mysql_anotherdb'));


// -- TO ADD::: - exact location ...

echo "\n\EXACT LOCATIONS INI FILES\n";
(new PDO_DataObject())->reset();

PDO_DataObject::config(
    array(
        'schema_location' => array(
            'mysql_anotherdb' => __DIR__.'/includes/test_ini/mysql_anotherdb.ini'
        )
    )
);
$obj = new PDO_DataObject('mysql_anotherdb/account_transaction');
print_r($obj->databaseStructure('mysql_anotherdb'));


 


// -- normally disabled - used to geenrate the test data...
/*
echo "\n\nREAL DATABASE CONNECT - NOT IN FINAL TEST\n";

(new PDO_DataObject())->reset();



PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO',
        'databases' => array(
            'hebe' => 'mysql://root:@localhost/hebe'
        ),
        'proxy' => true,
        
    )
);

$obj = new PDO_DataObject('hebe/account_transaction');
$obj->PDO();
print_r($obj->databaseStructure('hebe'));

exit;
*/

/*
echo "\n\nREAL DATABASE CONNECT - NOT IN FINAL TEST (postgres)\n";

(new PDO_DataObject())->reset();

PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO',
        'databases' => array(
            'xtuple_db' => 'pgsql://admin:pass4xtuple@localhost/xtuplehk'
        ),
        'tables' => array(
            'accnt' => 'xtuple_db'
        ),
        'proxy' => true,
        
    )
);



$obj = new PDO_DataObject('accnt');
$obj->PDO();
print_r($obj->databaseStructure());

exit;
/*
*/


// test structure from introspection

echo "\n\nDATABASE INSTROSPECT - mysql dummy\n";
(new PDO_DataObject())->reset();


PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO_Dummy',
        'proxy' => true,
        'tables' => array(
            'Events' => 'mysql_anotherdb',
        ),
        'databases' => array(
            'mysql_anotherdb' => 'mysql://root:@localhost:3344/anotherdb'
        ),
    )
);

$obj = new PDO_DataObject('mysql_anotherdb/Events');
print_r($obj->databaseStructure());



 
// postgresql
echo "\n\nDATABASE INSTROSPECT - postgres dummyu\n";
(new PDO_DataObject())->reset();

PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO_Dummy',
        'proxy' => true,
        'tables' => array(
            'accnt' => 'dummy_xtuple'
        ),
        'databases' => array(
            'dummy_xtuple' => 'pgsql://user:nopass@localhost/xtuple'
        )
    )
);


$obj = new PDO_DataObject('accnt');
print_r($obj->databaseStructure());


 
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
PDO_DataObject   : __construct       : ["mysql_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:["mysql_somedb"]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_somedb') : config[databases][mysql_somedb] in options
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

\MULTIPLE LOCATIONS INI FILES
PDO_DataObject   : __construct       : ["mysql_anotherdb\/account_transaction"]
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_anotherdb') : config[databases][mysql_anotherdb] in options
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

\EXACT LOCATIONS INI FILES
PDO_DataObject   : __construct       : ["mysql_anotherdb\/account_transaction"]
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_anotherdb') : config[databases][mysql_anotherdb] in options
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
PDO_DataObject   : __construct       : ["mysql_anotherdb\/Events"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_anotherdb') : config[databases][mysql_anotherdb] in options
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","root","",[]]
setAttribute==[3,2]
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : 1       : Loading Generator as databaseStructure called with args for database = mysql_anotherdb
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_anotherdb') : config[databases][mysql_anotherdb] in options
PDO_DataObject   : getListOf       : tables
PDO_DataObject   : getListOf       : SHOW TABLES
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : QUERY       : 9c36cac1372650b703400c60dd29042c : SHOW TABLES
getAttribute==[16] => mysql
QUERY: SHOW TABLES  
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 3
Fetch Row 0 / 3
PDO_DataObject   : FETCH       : {"Tables_in_somedb":"Companies"}
Fetch Row 1 / 3
PDO_DataObject   : FETCH       : {"Tables_in_somedb":"Events"}
Fetch Row 2 / 3
PDO_DataObject   : FETCH       : {"Tables_in_somedb":"Groups"}
Fetch Row 3 / 3
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
Close Cursor
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_anotherdb') : config[databases][mysql_anotherdb] in options
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : QUERY       : 16df8b2c9d4c9a5e5d29184cedc0f90d : DESCRIBE Companies
getAttribute==[16] => mysql
QUERY: DESCRIBE Companies  
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
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
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
Close Cursor
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb",{"Companies":{"id":129,"code":130,"name":2,"remarks":34,"owner_id":129,"address":34,"tel":2,"fax":2,"email":2,"isOwner":1,"logo_id":129,"background_color":130,"comptype":2,"url":130,"main_office_id":129,"created_by":129,"created_dt":142,"updated_by":129,"updated_dt":142,"passwd":130,"dispatch_port":130,"province":130,"country":130},"Companies__keys":{"id":"N"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_anotherdb') : config[databases][mysql_anotherdb] in options
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : QUERY       : 5b30c8fedc52d8f73f669f2348ecf576 : DESCRIBE Events
getAttribute==[16] => mysql
QUERY: DESCRIBE Events  
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
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
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
Close Cursor
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb",{"Events":{"id":129,"person_name":2,"event_when":14,"action":2,"ipaddr":2,"on_id":1,"on_table":2,"person_id":1,"person_table":2,"remarks":34},"Events__keys":{"id":"N"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_anotherdb') : config[databases][mysql_anotherdb] in options
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_mysql
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : QUERY       : dcae9cad4d5f111b6b2ac65d922aa38f : DESCRIBE Groups
getAttribute==[16] => mysql
QUERY: DESCRIBE Groups  
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
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
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
Close Cursor
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => mysql
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb",{"Groups":{"id":129,"name":130,"type":1,"leader":129},"Groups__keys":{"id":"N"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
PDO_DataObject   : PDO       : Using Cached connection
Array
(
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


DATABASE INSTROSPECT - postgres dummyu
PDO_DataObject   : __construct       : ["accnt"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('dummy_xtuple') : config[databases][dummy_xtuple] in options
__construct==["pgsql:dbname=xtuple;host=localhost","user","nopass",[]]
setAttribute==[3,2]
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_pgsql
PDO_DataObject   : 1       : Loading Generator as databaseStructure called with args for database = dummy_xtuple
PDO_DataObject   : PDO       : Checking for database specific ini ('dummy_xtuple') : config[databases][dummy_xtuple] in options
PDO_DataObject   : getListOf       : tables
PDO_DataObject   : getListOf       : SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'public' order by table_name ASC
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : QUERY       : e1cbe336d18feb312b6ec9685b9f64b2 : SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'public' order by table_name ASC
getAttribute==[16] => pgsql
QUERY: SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'public' order by table_name ASC  
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 3
Fetch Row 0 / 3
PDO_DataObject   : FETCH       : {"table_name":"acalitem"}
Fetch Row 1 / 3
PDO_DataObject   : FETCH       : {"table_name":"accnt"}
Fetch Row 2 / 3
PDO_DataObject   : FETCH       : {"table_name":"addr"}
Fetch Row 3 / 3
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
Close Cursor
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('dummy_xtuple') : config[databases][dummy_xtuple] in options
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_pgsql
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : QUERY       : 08e4aa9f52824fa6d6c01dfea04d5efd : SELECT  
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
              
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 5
Fetch Row 0 / 5
PDO_DataObject   : FETCH       : {"number":1,"name":"acalitem_id","attnum":1,"notnull":true,"type":"integer","primarykey":"t","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"nextval(('\"xcalitem_xcalitem_id_seq\"'::text)::regclass)"}
Fetch Row 1 / 5
PDO_DataObject   : FETCH       : {"number":2,"name":"acalitem_calhead_id","attnum":2,"notnull":false,"type":"integer","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 2 / 5
PDO_DataObject   : FETCH       : {"number":3,"name":"acalitem_periodstart","attnum":3,"notnull":false,"type":"date","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 3 / 5
PDO_DataObject   : FETCH       : {"number":4,"name":"acalitem_periodlength","attnum":4,"notnull":false,"type":"integer","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 4 / 5
PDO_DataObject   : FETCH       : {"number":5,"name":"acalitem_name","attnum":5,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 5 / 5
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
Close Cursor
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : databaseStructure       : CALL:["dummy_xtuple",{"acalitem":{"acalitem_id":129,"acalitem_calhead_id":1,"acalitem_periodstart":6,"acalitem_periodlength":1,"acalitem_name":34},"acalitem__keys":{"acalitem_id":"xcalitem_xcalitem_id_seq"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('dummy_xtuple') : config[databases][dummy_xtuple] in options
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_pgsql
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : QUERY       : 910efae3bc8352cab9a73df70006a9bc : SELECT  
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
              
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 17
Fetch Row 0 / 17
PDO_DataObject   : FETCH       : {"number":1,"name":"accnt_id","attnum":1,"notnull":true,"type":"integer","primarykey":"t","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"nextval(('accnt_accnt_id_seq'::text)::regclass)"}
Fetch Row 1 / 17
PDO_DataObject   : FETCH       : {"number":2,"name":"accnt_number","attnum":2,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 2 / 17
PDO_DataObject   : FETCH       : {"number":3,"name":"accnt_descrip","attnum":3,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 3 / 17
PDO_DataObject   : FETCH       : {"number":4,"name":"accnt_comments","attnum":4,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 4 / 17
PDO_DataObject   : FETCH       : {"number":5,"name":"accnt_profit","attnum":5,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 5 / 17
PDO_DataObject   : FETCH       : {"number":6,"name":"accnt_sub","attnum":6,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 6 / 17
PDO_DataObject   : FETCH       : {"number":7,"name":"accnt_type","attnum":7,"notnull":true,"type":"character(1)","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 7 / 17
PDO_DataObject   : FETCH       : {"number":8,"name":"accnt_extref","attnum":8,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 8 / 17
PDO_DataObject   : FETCH       : {"number":9,"name":"accnt_company","attnum":9,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":"company","foreignkey_fieldnum":"{2}","foreignkey_connnum":"{9}","default":null}
Fetch Row 9 / 17
PDO_DataObject   : FETCH       : {"number":10,"name":"accnt_closedpost","attnum":10,"notnull":false,"type":"boolean","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 10 / 17
PDO_DataObject   : FETCH       : {"number":11,"name":"accnt_forwardupdate","attnum":11,"notnull":false,"type":"boolean","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 11 / 17
PDO_DataObject   : FETCH       : {"number":12,"name":"accnt_subaccnttype_code","attnum":12,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 12 / 17
PDO_DataObject   : FETCH       : {"number":13,"name":"accnt_curr_id","attnum":13,"notnull":false,"type":"integer","primarykey":"f","uniquekey":"f","foreignkey":"curr_symbol","foreignkey_fieldnum":"{1}","foreignkey_connnum":"{13}","default":"basecurrid()"}
Fetch Row 13 / 17
PDO_DataObject   : FETCH       : {"number":14,"name":"accnt_active","attnum":14,"notnull":true,"type":"boolean","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"true"}
Fetch Row 14 / 17
PDO_DataObject   : FETCH       : {"number":15,"name":"accnt_name","attnum":15,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 15 / 17
PDO_DataObject   : FETCH       : {"number":16,"name":"accnt_code_alt","attnum":16,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"''::text"}
Fetch Row 16 / 17
PDO_DataObject   : FETCH       : {"number":17,"name":"accnt_descrip_alt","attnum":17,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"''::text"}
Fetch Row 17 / 17
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
Close Cursor
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : databaseStructure       : CALL:["dummy_xtuple",{"accnt":{"accnt_id":129,"accnt_number":34,"accnt_descrip":34,"accnt_comments":34,"accnt_profit":34,"accnt_sub":34,"accnt_type":130,"accnt_extref":34,"accnt_company":34,"accnt_closedpost":18,"accnt_forwardupdate":18,"accnt_subaccnttype_code":34,"accnt_curr_id":1,"accnt_active":146,"accnt_name":34,"accnt_code_alt":34,"accnt_descrip_alt":34},"accnt__keys":{"accnt_id":"accnt_accnt_id_seq"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('dummy_xtuple') : config[databases][dummy_xtuple] in options
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_pgsql
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : QUERY       : 0464cd1439d5cf9ac030e8cbe858bbfd : SELECT  
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
              
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 11
Fetch Row 0 / 11
PDO_DataObject   : FETCH       : {"number":1,"name":"addr_id","attnum":1,"notnull":true,"type":"integer","primarykey":"t","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"nextval('addr_addr_id_seq'::regclass)"}
Fetch Row 1 / 11
PDO_DataObject   : FETCH       : {"number":2,"name":"addr_active","attnum":2,"notnull":false,"type":"boolean","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"true"}
Fetch Row 2 / 11
PDO_DataObject   : FETCH       : {"number":3,"name":"addr_line1","attnum":3,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"''::text"}
Fetch Row 3 / 11
PDO_DataObject   : FETCH       : {"number":4,"name":"addr_line2","attnum":4,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"''::text"}
Fetch Row 4 / 11
PDO_DataObject   : FETCH       : {"number":5,"name":"addr_line3","attnum":5,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"''::text"}
Fetch Row 5 / 11
PDO_DataObject   : FETCH       : {"number":6,"name":"addr_city","attnum":6,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"''::text"}
Fetch Row 6 / 11
PDO_DataObject   : FETCH       : {"number":7,"name":"addr_state","attnum":7,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"''::text"}
Fetch Row 7 / 11
PDO_DataObject   : FETCH       : {"number":8,"name":"addr_postalcode","attnum":8,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"''::text"}
Fetch Row 8 / 11
PDO_DataObject   : FETCH       : {"number":9,"name":"addr_country","attnum":9,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"''::text"}
Fetch Row 9 / 11
PDO_DataObject   : FETCH       : {"number":10,"name":"addr_notes","attnum":10,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"''::text"}
Fetch Row 10 / 11
PDO_DataObject   : FETCH       : {"number":11,"name":"addr_number","attnum":11,"notnull":true,"type":"text","primarykey":"f","uniquekey":"t","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
Fetch Row 11 / 11
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
Close Cursor
PDO_DataObject   : PDO       : Using Cached connection
getAttribute==[16] => pgsql
PDO_DataObject   : databaseStructure       : CALL:["dummy_xtuple",{"addr":{"addr_id":129,"addr_active":18,"addr_line1":34,"addr_line2":34,"addr_line3":34,"addr_city":34,"addr_state":34,"addr_postalcode":34,"addr_country":34,"addr_notes":34,"addr_number":162},"addr__keys":{"addr_id":"addr_addr_id_seq"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["dummy_xtuple"]
PDO_DataObject   : PDO       : Using Cached connection
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
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL"]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : 1       : Loading Generator as databaseStructure called with args for database = EssentialSQL
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : getListOf       : tables
PDO_DataObject   : getListOf       : SELECT name FROM sqlite_master WHERE type='table' UNION ALL SELECT name FROM sqlite_temp_master WHERE type='table' ORDER BY name
PDO_DataObject   : PDO       : Using Cached connection
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
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : PDO       : Using Cached connection
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
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",{"Customers":{"CustomerID":1,"CompanyName":2,"ContactName":2,"ContactTitle":2,"Address":2,"City":2,"State":2},"Customers__keys":{"CustomerID":"N"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : PDO       : Using Cached connection
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
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",{"Employees":{"EmployeeID":1,"LastName":2,"FirstName":2,"Title":2,"Address":2,"HireDate":2},"Employees__keys":{"EmployeeID":"N"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : PDO       : Using Cached connection
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
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",{"OrderDetails":{"OrderDetailID":1,"OrderID":1,"ProductID":1,"UnitPrice":1,"Quantity":1},"OrderDetails__keys":{"OrderDetailID":"N"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : PDO       : Using Cached connection
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
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",{"Orders":{"OrderID":1,"CustomerID":1,"EmployeeID":1,"OrderDate":2,"RequiredDate":2,"ShippedDate":2,"ShipVia":1,"FreightCharge":1},"Orders__keys":{"OrderID":"N"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : PDO       : Checking for database specific ini ('EssentialSQL') : config[databases][EssentialSQL] in options
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : _introspection       : Creating Introspection for PDO_DataObject_Introspection_sqlite
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : QUERY       : 02f4528d77058145e7f11034d44c4289 : PRAGMA table_info('Shippers');
PDO_DataObject   : query       : QUERY DONE IN  0.000 seconds
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : FETCH       : {"cid":"0","name":"ShipperID","type":"INTEGER","notnull":"0","dflt_value":null,"pk":"1"}
PDO_DataObject   : FETCH       : {"cid":"1","name":"CompanyName","type":"VARCHAR(60)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : {"cid":"2","name":"Phone","type":"VARCHAR(20)","notnull":"0","dflt_value":null,"pk":"0"}
PDO_DataObject   : FETCH       : false
PDO_DataObject   : FETCH       : Last Data Fetch'ed after 0.000 seconds
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL",{"Shippers":{"ShipperID":1,"CompanyName":2,"Phone":2},"Shippers__keys":{"ShipperID":"N"}}]
PDO_DataObject   : PDO       : Using Cached connection
PDO_DataObject   : databaseStructure       : CALL:["EssentialSQL"]
PDO_DataObject   : PDO       : Using Cached connection
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