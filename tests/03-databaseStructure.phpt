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
 
// test error conditions?!? 


?>
--EXPECT--
