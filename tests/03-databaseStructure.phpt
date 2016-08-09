--TEST--
databaseStructure
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);

// test structure from single ini file
PDO_DataObject::$config['schema_location'] = dirname(__FILE__).'/includes/';
PDO_DataObject::$config['database']='mysql://username:test@localhost:3344/somedb';
$obj = new PDO_DataObject();
$obj->__table = 'account_code';

print_r($obj->databaseStructure('somedb', false));

// test structure from two ini files. (using database)
PDO_DataObject::$config['databases']['anotherdb']='mysql://username:test@localhost:3344/anotherdb';

$obj = new PDO_DataObject();
$obj->__table = 'account_transaction';
$obj->_database = 'anotherdb';


// test structure from introspection

// set structure + retrieve it.
 
// test error conditions?!? 


?>
--EXPECT--
