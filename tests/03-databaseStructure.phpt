--TEST--
databaseStructure
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);

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

echo "\n\nREAL DATABASE CONNECT - NOT IN FINAL TEST\n";

PDO_DataObject::$config['PDO'] = 'PDO';
PDO_DataObject::$config['tables']['accnt']='xtuplehk';
PDO_DataObject::$config['databases']['xtuplehk']='pgsql://admin:pass4xtuple@localhost/xtuplehk';
PDO_DataObject::$config['proxy'] = true;
PDO_DataObject::debugLevel(1);

$obj = new PDO_DataObject();
$obj->__table = 'accnt';
$obj->PDO(true);
print_r($obj->databaseStructure('xtuplehk'));

PDO_DataObject::$config['PDO'] = 'PDO_Dummy';


*/


// test structure from introspection

echo "\n\nDATABASE INSTROSPECT - mysql dummy\n";
PDO_DataObject::$config['tables']['Events']='anotherdb';

$obj = new PDO_DataObject();
$obj->__table = 'Events';
$obj->PDO(true);
PDO_DataObject::$config['proxy'] = true;
print_r($obj->databaseStructure('anotherdb'));



 
// postgresql
echo "\n\nDATABASE INSTROSPECT - mysql postgres dummyu\n";
 
PDO_DataObject::$config['tables']['accnt']='xtuplehk';
PDO_DataObject::$config['databases']['xtuplehk']='pgsql://user:nopass@localhost/xtuple';
PDO_DataObject::$config['proxy'] = true;

$obj = new PDO_DataObject();
$obj->__table = 'accnt';
$obj->PDO(true);
print_r($obj->databaseStructure('xtuplehk'));

 
// sqlite




// set structure + retrieve it.
// test not really needed as proxy really tests this..

 
// test error conditions?!? 
// not sure about this one...



?>
--EXPECT--
SINGLE INI FILE 
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
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","username","test",[]]
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
getAttribute==[16] => mysql
QUERY: SHOW TABLES  
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Close Cursor
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
getAttribute==[16] => pgsql
QUERY: SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'public' order by table_name ASC  
Fetch Row 0 / 3
Fetch Row 1 / 3
Fetch Row 2 / 3
Fetch Row 3 / 3
Close Cursor
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