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
