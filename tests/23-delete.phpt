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
echo "basic dlete;\n" ;

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
echo "delete all?....);\n" ;

$event = PDO_DataObject::factory('Events');
$res = $event->delete();
// should throw error..


echo "\n\n--------\n";
echo "update (nothing changed);\n" ;

$event = PDO_DataObject::factory('Events');
$event->get(12);
$old = clone($event);
echo "UPDATED {$event->update($old)} records\n";


echo "\n\n--------\n";
echo "bulk update using where (wrong usage);\n" ;

$event = PDO_DataObject::factory('Events');
$event->action="ssss";
try {
     $event->update(PDO_DataObject::WHEREADD_ONLY);
} catch(PDO_DataObject_Exception_InvalidArgs $e) {
    echo "Throws exception as expected: {$e->getMessage()}\n";
}

echo "\n\n--------\n";
echo "bulk update using where  ;\n" ;

$event = PDO_DataObject::factory('Events');
$event->action="ssss";
$event->where('id >15 and id < 20');
$rows = $event->update(PDO_DataObject::WHEREADD_ONLY);

echo "UPDATED {$rows} records\n";
 
echo "\n\n--------\n";
echo "empty insert (postgresql);\n" ;
PDO_DataObject::config('database' , 'pgsql://user:pass@localhost/pginsert');
    // real db...

$event = PDO_DataObject::factory('Events');

$id = $event->insert();
var_dump($id);
print_r($event->toArray());

 

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
print_r($Customers->toArray());
$Customers->set(array(
    'CompanyName' => 'test1',
    'ContactName' => 'test2',

));
$Customers->update();
print_r($Customers->toArray());




echo "\n\n--------\n";
echo "Test SQLite  update - with old.\n" ;




$Customers = PDO_DataObject::factory('Customers');
$Customers->get(3);
$old = clone($Customers);
print_r($Customers->toArray());
$Customers->set(array(
    'CompanyName' => 'test1',
    'ContactName' => 'test2',

));
$Customers->update($old);
print_r($Customers->toArray());




unlink($temp);



?>
--EXPECT--