--TEST--
autoJOin and joinAll Test 
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest',
        'class_prefix' => 'DataObjects_',
));

PDO_DataObject::debugLevel(0);
 
// these need the links to calculate the join..
 
$j = PDO_DataObject::factory('joinerb')
    ->joinAll()
    ->find(true);

print_r(     
    PDO_DataObject::factory('joinerb')
    ->autoJoin()
);
     



echo "\n\n--------\n";
echo "Exclude tests\n" ;
     
     
echo "\nexclude single resulting column and column that hides a link.\n";
$j = PDO_DataObject::factory('joinerb')
    ->joinAll([
        'exclude' => array('childa_id_ca_id', 'childc_id')
    ])
    ->find(true);

print_r(     
    PDO_DataObject::factory('joinerb')
    ->autoJoin([
        'exclude' => array('childa_id_ca_id', 'childc_id')
    ])
);    
    
    
    
echo "\nexclude joined table.., but keep the column.\n";
$j = PDO_DataObject::factory('joinerb')
    ->joinAll([
        'exclude' => array('childc_id.*')
    ])
    ->find(true);

    
    
    
echo "\nexclude joined table using target* and 'joined as' name.., .\n";
$j = PDO_DataObject::factory('joinerc')
    ->joinAll([
        'exclude' => array('childa.*','join_childb_id_ca_id')
    ])
    ->find(true);
 
 
echo "\n\n--------\n";
echo "Include tests\n" ;

echo "\n include only two columns...  .\n";
$j = PDO_DataObject::factory('joinerc')
    ->joinAll([
        'include' => array('childa_id','childa_id_name')
    ])
    ->find(true);
  
 
echo "\n\n--------\n";
echo "links tests\n" ;

echo "\n include only two columns...  .\n";
$j = PDO_DataObject::factory('joiner')
    ->joinAll([
        'links' => array('childb_id' => 'childb:cb_id')
    ])
    ->find(true);



echo "\n distinct column...  .\n";
$j = PDO_DataObject::factory('joiner')
    ->joinAll([
        'distinct' => 'childa_id'
    ])
    ->find(true);
    
 
echo "\n distinct column...  .\n";
$j = PDO_DataObject::factory('joiner')
    ->joinAll([
        'distinct' => 'childa_id_name'
    ])
    ->find(true);
  
 
 
 
?>
--EXPECT--
