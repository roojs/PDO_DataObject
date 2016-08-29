--TEST--
Generator - compare to DB_DataObject - Postgres (real database) - will not normmally pass...
--FILE--
<?php
require_once 'includes/init.php';
 

// hard coded to my path....
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR .'/home/alan/gitlive/pear');
 
require_once 'DB/DataObject.php';
require_once 'DB/DataObject/Generator.php';

 
$dofn = tempnam (sys_get_temp_dir(), 'pdo-do-tests-') . '-dir';
mkdir($dofn);
$opts = &PEAR::getStaticProperty('DB_DataObject','options');
$opts = array(
    'database' =>   'pgsql://admin:pass4xtuple@localhost/xtuplehk',
    'schema_location' => $dofn,
    'class_location' => $dofn,
    'generator_strip_schema' => true,
    'generator_include_regex' => '/^public\.*/',

    
);

$generator = new DB_DataObject_Generator;
$generator->start();


var_dump(array(
    'dbdo' => $dofn,
    'pdodo' => $fn
));
exit;

// test structure from introspection
 
$fn = tempnam (sys_get_temp_dir(), 'pdo-do-tests-') . '-dir';
mkdir($fn);


PDO_DataObject::config(
    array(
        'schema_location' => $fn,
        'class_location' => $fn,
        'PDO' => 'PDO',
        'databases' => array(
            'xtuple_db' => 'pgsql://admin:pass4xtuple@localhost/xtuplehk'
        ),
        
        'proxy' => true,
        'debug' => 0,
        'database' => '',
        
    )
);

$gen = (new PDO_DataObject('xtuple_db/accnt'))->generator();

PDO_DataObject_Generator::config(array(
         
            //'build_views' => true,
              
            'generate_links' => true,
            
            'link_methods'  =>true,
              
            


));
 

$gen->start();


var_dump(array(
    'dbdo' => $dofn,
    'pdodo' => $fn
));
exit;

echo `cd  $fn; md5sum *`;

echo file_get_contents($fn.'/Companies.php');

`rm -rf $fn`;
 
 
?>
--EXPECT--
