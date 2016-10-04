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
echo "basic count;\n" ;

$event = PDO_DataObject::factory('Events');
echo "Total rows: {$event->count()}\n";


echo "\n\n--------\n";
echo "count matching properties....);\n" ;

$event = PDO_DataObject::factory('Events');
$event->person_name = 'Alan';
echo "Total rows (with person=Alan): {$event->count()}\n";

echo "\n\n--------\n";
echo "count based on where......);\n" ;

$event = PDO_DataObject::factory('Events');
$event->where('person_id < 20');
echo "Total rows (with person_id < 20): {$event->count(PDO_DataObject::WHERE_ONLY)}\n";



echo "\n\n--------\n";
echo "count distinct;\n" ;

$event = PDO_DataObject::factory('Events');
echo "Total rows (distinct person_name): {$event->count('distinct person_name')}\n";



echo "\n\n--------\n";
echo "count distinct + property;\n" ;

$event = PDO_DataObject::factory('Events');
$event->action = 'RELOAD';
echo "Total rows (distinct person_name) - with action=RELOAD: {$event->count('distinct person_name')}\n";


echo "\n\n--------\n";
echo "count distinct + property + where ;\n" ;

$event = PDO_DataObject::factory('Events');
$event->action = 'RELOAD';
$event->where('id = > 10000');
echo "Total rows (distinct person_name) - with action=RELOAD  where: {$event->count('distinct person_name')}\n";



echo "\n\n--------\n";
echo "count distinct + property + where + WHERE_ONLY ;\n" ;

$event = PDO_DataObject::factory('Events');
$event->action = 'RELOAD';
$event->where('id = > 10000');
echo "Total rows (distinct person_name) - with action=RELOAD  where: {$event->count('distinct person_name', PDO_DataObject::WHERE_ONLY)}\n";





echo "\n\n--------\n";
echo "count after fetch (error) ;\n" ;


$event = PDO_DataObject::factory('Events');
$event->action = 'RELOAD';
$event->limit(1);
$event->fetchAll();
$event->count();

 
 
 
echo "\n\n--------\n";
echo "Test SQLite\n" ;



PDO_DataObject::reset();
PDO_DataObject::config(array(
        'PDO' => 'PDO', // we can do this for real...
        'tables' => array(
            'Customers' => 'EssentialSQL'
        ),
        'databases' => array(
            'EssentialSQL' => 'sqlite:'.$__DIR__.'/includes/EssentialSQL.db'
        ),
        'proxy' => 'Full',
        'debug' => 0,
));

PDO_DataObject::factory('Customers')->databaseStructure();

PDO_DataObject::debugLevel(1);

 


echo "\n\n--------\n";
echo "basic count;\n" ;

$Customers = PDO_DataObject::factory('Customers');
echo "Total rows: {$Customers->count()}\n";


echo "\n\n--------\n";
echo "count matching properties....);\n" ;

$Customers = PDO_DataObject::factory('Customers');
$Customers->State='FL';
echo "Total rows (with state=FL): {$Customers->count()}\n";

echo "\n\n--------\n";
echo "count based on where......);\n" ;

$Customers = PDO_DataObject::factory('Customers');
$Customers->where("state in ('FL', 'TX')");
echo "Total rows (with FL or TX): {$Customers->count(PDO_DataObject::WHERE_ONLY)}\n";



echo "\n\n--------\n";
echo "count distinct;\n" ;

$Customers = PDO_DataObject::factory('Customers');
echo "Total rows (distinct state): {$Customers->count('distinct state')}\n";


  


?>
--EXPECT--
