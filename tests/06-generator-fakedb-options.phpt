--TEST--
Generator - INI file
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
$base_config = PDO_DataObject::config();

 

// test structure from introspection
 


PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO_Dummy',
        'proxy' => true,
        'database' => '',
        'databases' => array(
            'mysql_anotherdb' => 'mysql://root:@localhost:3344/anotherdb'
        ),
    )
);
PDO_DataObject_Generator

$gen = (new PDO_DataObject('mysql_anotherdb/Events'))->generator();

PDO_DataObject_Generator::config(array(
    


))

$gen->readTableList();
echo $gen->toINI(); 
echo $gen->toPhp('Companies');
 








?>
--EXPECT--