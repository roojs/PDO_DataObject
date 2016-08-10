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





// test structure from introspection

echo "\n\nDATABASE INSTROSPECT - mysql dummy\n";

$obj = new PDO_DataObject();
$obj->__table = 'Events';
$obj->PDO(true);
PDO_DataObject::$config['proxy'] = true;
print_r($obj->databaseStructure('anotherdb'));



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


DATABASE INSTROSPECT
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","username","test",[]]
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
