--TEST--
Generator - write files
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
$base_config = PDO_DataObject::config();

 

// test structure from introspection
 
$fn = tempnam (sys_get_temp_dir(), 'pdo-do-tests-') . '-dir';
mkdir($fn);


PDO_DataObject::config(
    array(
        'schema_location' => $fn,
        'PDO' => 'PDO_Dummy',
        'proxy' => true,
        'database' => '',
        'databases' => array(
            'mysql_anotherdb' => 'mysql://root:@localhost:3344/anotherdb'
        ),
    )
);
 

$gen = (new PDO_DataObject('mysql_anotherdb/Events'))->generator();

PDO_DataObject_Generator::config(array(
         
            
            //'strip_schema' => true,
            'embed_schema' => true,
            'extends_class' => 'PDO_DataObject_Test1',
            'extends_class_location' => 'PDO/DataObject_Test1.php',
                
        
            //'generate_links' => false,
                // generate .link.ini files based on introspecting the database.
        
            'var_keyword' => 'private',
                
            'add_database_nickname' => true,
                
            // 'no_column_vars' => false,
                
                
            'setters' => true,
            'getters' => true,
            'add_defaults' => true,
            'link_methods'  =>true,
                
            //'include_regex' =>  '/^Companies$/'
            //'exclude_regex' => false,
              
            


));

try { 
    $gen->start();
} catch(Exception $e) {
    echo "Expected Exception (no class location) - " . (string)$e;
}
echo "\nSetting class location\n";

copy(__DIR__.'/includes/test_ini/Companies.php', $fn.'/Companies.php');


PDO_DataObject::config('class_location', $fn);
$gen->start();

echo `cd  $fn; md5sum *`

echo file_get_contents($fn.'/Companies.php');

?>
--EXPECT--