--TEST--
load() save() and snapshot() test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
         'database' => 'mysql://user:pass@localhost/inserttest'
    // real db...
    /*
        'database' => '',
        'tables' => array(
            'Events'=> 'inserttest',
        ),
        'databases' => array(
            'inserttest' => 'mysql://root:@localhost/pman',
        ),
         'PDO' => 'PDO',
      */   
));

PDO_DataObject::debugLevel(1);
 
// used to extract sample data...
//PDO_DataObject::factory('Events')->limit(1)->find(true);

echo "\n\n--------\n";
echo "basic load/set/save;\n" ;

PDO_DataObject::factory('Events')
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save();


echo "\n\n--------\n";
echo "using where to filter.. find/set/save;\n" ;

PDO_DataObject::factory('Events')
    ->where('id > 3600')
    ->limit(1)
    ->load()
    ->set(['action' => "testing" ])
    ->save();

echo "\n\n--------\n";
echo "using where set filter.. find/set/save;\n" ;

PDO_DataObject::factory('Events')
    ->set(['action' => "RELOAD" ])
    ->limit(1)
    ->load()
    ->set(['action => "testing" ])
    ->save();

// error condition.. loading data that does not exist...
PDO_DataObject::factory('Events')
    ->load(3523)


PDO_DataObject::factory('Events')
    ->load();


 

?>
--EXPECT--
