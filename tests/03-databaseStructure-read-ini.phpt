--TEST--
databaseStructure - reading INI files.
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

 




?>
--EXPECT--
SINGLE INI FILE 
PDO_DataObject   : __construct       : ["mysql_somedb\/account_code"]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_somedb') : config[databases][mysql_somedb] in options
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : databaseStructure       : CALL:["mysql_somedb"]
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
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_anotherdb') : config[databases][mysql_anotherdb] in options
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
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
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('mysql_anotherdb') : config[databases][mysql_anotherdb] in options
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
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