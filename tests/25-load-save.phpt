--TEST--
load() save() and snapshot() test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
   //      'database' => 'mysql://user:pass@localhost/inserttest'
    // real db...
    
        'database' => '',
        'tables' => array(
            'Events'=> 'inserttest',
        ),
        'databases' => array(
            'inserttest' => 'mysql://root:@localhost/pman',
        ),
         'PDO' => 'PDO',
     // */   
));

PDO_DataObject::debugLevel(1);
 
// used to extract sample data...
//PDO_DataObject::factory('Events')->limit(1)->find(true);

PDO_DataObject::factory('Events')->query('BEGIN');

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
    ->set(['action' => "testing" ])
    ->save();



echo "\n\n--------\n";
echo "Testing errors in load;\n" ;



// error condition.. loading data that does not exist...
try {

    PDO_DataObject::factory('Events')
        ->load(12);

} catch (PDO_DataObject_Exception_NoData $e) {
    echo "Load fail - Error thrown as expected: {$e->getMessage()}\n";
}

try {

PDO_DataObject::factory('Events')
    ->load();

} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "Load fail - Error thrown as expected: {$e->getMessage()}\n";
}
try {

PDO_DataObject::factory('Events')
    ->where("id > 100")
    ->limit(10)
    ->load();

} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "Load fail - Error thrown as expected: {$e->getMessage()}\n";
}




echo "\n\n--------\n";
echo "Testing insert save;\n" ;

PDO_DataObject::factory('Events')->set(
    PDO_DataObject::factory('Events')
        ->load(3523)
)->save();
 





?>
--EXPECT--
