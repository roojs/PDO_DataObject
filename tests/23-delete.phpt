--TEST--
delete() test
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
echo "basic delete;\n" ;

$event = PDO_DataObject::factory('Events');
$event->get(12);
$res = $event->delete();
echo "DELETED {$res} records\n";


echo "\n\n--------\n";
echo "delete where....);\n" ;

$event = PDO_DataObject::factory('Events');
$event->where('id > 12');
$res = $event->delete();
echo "DELETED {$res} records\n";



echo "\n\n--------\n";
echo "delete where, without flag....);\n" ;

$event = PDO_DataObject::factory('Events');
try {
    $event->where('id > 12');
    $event->delete();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "failed as expected : " . $e->toMessage();
}


echo "\n\n--------\n";
echo "delete all?....);\n" ;

$event = PDO_DataObject::factory('Events');
try {
    $event->delete();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "failed as expected : " . $e->toMessage();
}
// should throw error..

 
// joined????  
 
 
 
 
 
echo "\n\n--------\n";
echo "Test SQLite  update - empty\n" ;

$temp  = tempnam(ini_get('session.save-path'), 'sqlite-test');
copy(__DIR__.'/includes/EssentialSQL.db', $temp);

PDO_DataObject::reset();
PDO_DataObject::config(array(
        'PDO' => 'PDO', // we can do this for real...
        'tables' => array(
            'Customers' => 'EssentialSQL'
        ),
        'databases' => array(
            'EssentialSQL' => 'sqlite:'.$temp
        ),
        'proxy' => 'Full',
        'debug' => 0,
));

PDO_DataObject::factory('Customers')->databaseStructure();

PDO_DataObject::debugLevel(1);

 

$Customers = PDO_DataObject::factory('Customers');
$Customers->get(2);
$Customers->delete();

$Customers = PDO_DataObject::factory('Customers');
if (!$Customers->get(2)) {
    echo "id=2 has been deleted as expected\n";
}




echo "\n\n--------\n";
echo "Test SQLite  delete where .\n" ;



echo "There is ". PDO_DataObject::factory('Customers')->count() ." records\n";
PDO_DataObject::factory('Customers')
        ->where("CustomerID > 2")->delete(PDO_DataObject::WHEREADD_ONLY);

echo "There are now only ". PDO_DataObject::factory('Customers')->count() ." records\n";





unlink($temp);



?>
--EXPECT--