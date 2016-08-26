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
 

$gen = (new PDO_DataObject('mysql_anotherdb/Events'))->generator();

PDO_DataObject_Generator::config(array(
         
            'build_views' => true,
            //'strip_schema' => true,
            //'no_ini' => false,
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
                
            'include_regex' =>  '/^Companies$/'
            //'exclude_regex' => false,
              


))

$gen->readTableList();
echo $gen->toINI(); 
echo $gen->toPhp('Companies');
 








?>
--EXPECT--