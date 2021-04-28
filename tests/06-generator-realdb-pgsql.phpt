--TEST--
Generator - Postgres (real database) - will not normmally pass...
--FILE--
<?php
require_once 'includes/init.php';
 
die("DONE");

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

/* bugs fixed...
  shiptoinfo - duplicate columns..
  costupdate,invfifo,invfifopos,mrgundo - missing unique keys
  recurtype - recurtype_copyargs (DBDO = 162 notnull+TXT+STR,  - we are doing 130 notnull+string) (its a TEXT array)

PDO_DataObject::debugLevel(1);
//$gen->introspection()->tableInfo('shiptoinfo');
$gen->introspection()->tableInfo('costupdate');
exit;
*/

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




$gen->readTableList();


echo $gen->toIni();
echo $gen->toLinksIni(); 

echo $gen->toPhp('accnt');
 echo $gen->toPhp('address'); // a view..
 
?>
--EXPECT--
DONE