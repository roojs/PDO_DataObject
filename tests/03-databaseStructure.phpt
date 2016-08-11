--TEST--
databaseStructure
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
$base_config = PDO_DataObject::config();



PDO_DataObject::config(array_merge(
    PDO_DataObject::config(),
    array(
        'databases' => array(
            'mysql_somedb' => 'mysql://username:test@localhost:3344/somedb',
            'mysql_anotherdb' =>  'mysql://username:test@localhost:3344/anotherdb',
            
        ),
        'debug' => 3,
    )
));



echo "\n\nSINGLE INI FILE \n";

// test structure from single ini file

$obj = new PDO_DataObject('mysql_somedb/account_code');
print_r($obj->databaseStructure('mysql_somedb'));




echo "\n\MULTIPLE LOCATIONS INI FILES\n";
(new PDO_DataObject())->reset();
 
// test structure from two ini files. (using database)

$obj = new PDO_DataObject('mysql_anotherdb/account_transaction');

// does not actually connect to the DB - as we only do a db connection if we do not know the database name..
print_r($obj->databaseStructure('mysql_anotherdb'));





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
