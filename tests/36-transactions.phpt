--TEST--
tranaction Test 
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest',
        'class_prefix' => 'DataObjects_',
));

PDO_DataObject::debugLevel(1);
 
// these need the links to calculate the join..
echo "\n---\nFetch a related link.n";

PDO_DataObject::factory('Events')
    ->query("BEGIN")
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    ->query("COMMIT");


PDO_DataObject::factory('Events')
    ->query("BEGIN")
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    ->query("ROLLBACK");



echo "\n\n--------\n";
echo "Test SQLite  insert - empty\n" ;

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
 
$id = $Customers->insert();
var_dump($id);
print_r($Customers->toArray());

echo "\n\n--------\n";
echo "Test SQLite  insert with data;\n" ;

 

$Customers = PDO_DataObject::factory('Customers');
$Customers->set(array(
    'CompanyName' => 'test1',
    'ContactName' => 'test2',

));    
    
unlink($temp);

?>
--EXPECT--