--TEST--
fetchAll() test
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
 

echo "\n\n--------\n";
echo "empty insert;\n" ;

$event = PDO_DataObject::factory('Events');

$id = $event->insert();
var_dump($id);
print_r($event->toArray());


echo "\n\n--------\n";
echo "empty insert (postgresql);\n" ;
PDO_DataObject::config('database' , 'pgsql://user:pass@localhost/pginsert');
    // real db...

$event = PDO_DataObject::factory('Events');

$id = $event->insert();
var_dump($id);
print_r($event->toArray());



echo "\n\n--------\n";
echo "simple insert;\n" ;
PDO_DataObject::config('database' , 'mysql://user:pass@localhost/inserttest');

$event = PDO_DataObject::factory('Events');
$event ->set(array(
    'person_name' => 'fred',
    'event_when' => '2016-10-03 13:58:06',
    'action' => 'TEST',
    'ip' => '127.0.0.1',
    'on_id' => 0,
    'on_table' => '',
    'remarks' => 'a test event',

));
$id = $event->insert();
var_dump($id);
print_r($event->toArray());


//---------------
///SQLlite...

$temp  = tempnam(ini_get('session.save-path'), 'sqlite-test');
copy(__DIR__.'/includes/EssentialSQL.db', $temp);

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

 

$Customers = PDO_DataObject::factory('Customers');
 
$id = $Customers->insert();
var_dump($id);
print_r($event->toArray());








?>
--EXPECT--
