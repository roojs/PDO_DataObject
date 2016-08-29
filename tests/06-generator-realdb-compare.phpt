--TEST--
Generator - compare to DB_DataObject - Postgres (real database) - will not normmally pass...
--FILE--
<?php
require_once 'includes/init.php';
 

// hard coded to my path....
ini_set('require_path', ini_get('require_path') . PATH_SEPARATOR .'/home/alan/gitlive/pear');
 
require_once 'DB/DataObject.php';
require_once 'DB/DataObject/Generator.php';
$opts = &PEAR::getStaticProperty('DB_DataObject');
$opts = array(
    


);



// test structure from introspection
 


PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO',
        'databases' => array(
            'xtuple_db' => 'pgsql://admin:pass4xtuple@localhost/xtuplehk'
        ),
        
        'proxy' => true,
        'debug' => 0,
        
    )
);

$gen = (new PDO_DataObject('xtuple_db/accnt'))->generator();

PDO_DataObject_Generator::config(array(
         
            'build_views' => true,
            //'strip_schema' => true,
            'embed_schema' => true,
              
        
            'generate_links' => true,
        
            'var_keyword' => 'private',
                
            'add_database_nickname' => true,
                
            // 'no_column_vars' => false,
                
                
            'setters' => true,
            'getters' => true,
            'add_defaults' => true,
            'link_methods'  =>true,
                
           // 'include_regex' =>  '/^Companies$/'
            //'exclude_regex' => false,
              
            


));
 
$fn = tempnam (sys_get_temp_dir(), 'pdo-do-tests-') . '-dir';
mkdir($fn);

try { 
    $gen->start();
} catch(Exception $e) {
    echo "Expected Exception (no class location) - " . (string)$e;
}
echo "\nSetting class location\n";

copy(__DIR__.'/includes/test_ini/Companies.php', $fn.'/Companies.php');


PDO_DataObject::config('class_location', $fn);
$gen->start();

echo `cd  $fn; md5sum *`;

echo file_get_contents($fn.'/Companies.php');

`rm -rf $fn`;
 
 
?>
--EXPECT--
