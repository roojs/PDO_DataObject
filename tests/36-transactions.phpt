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
echo "Test Mysql - empty\n" ;



PDO_DataObject::config(array(
     
        'database' => '',
        'tables' => array(
            'Events'=> 'inserttest',
        ),
        'databases' => array(
            'inserttest' => 'mysql://root:@localhost/pman',
        ),
         'PDO' => 'PDO',
     
));

PDO_DataObject::debugLevel(1);
 

echo "\n\n--------\n";
echo "basic load/set/save ROLLBACK;\n" ;

print_r(
PDO_DataObject::factory('Events')
    ->query('BEGIN')
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    ->query('ROLLBACK')
    ->reload()
    ->toArray()
);

print_r(
PDO_DataObject::factory('Events')
    ->query('BEGIN')
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    ->query('COMMIT')
    ->reload()
    ->toArray()
);









echo "\n\n--------\n";
echo "Test SQLite  COMMIT DOES NOT WORK HERE !!!!\n" ;

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
        'transactions' => false,
));

PDO_DataObject::factory('Customers')->databaseStructure();

PDO_DataObject::debugLevel(1);
PDO_DataObject::factory('Customers')
    ->query("BEGIN")
    ->load(1)
    ->set(['CompanyName' => "test2" ])
    ->save()
    ->query("COMMIT");

print_r(
    PDO_DataObject::factory('Customers')
        ->load(1)
        ->toArray()
);

PDO_DataObject::factory('Customers')
    ->query("BEGIN")
    ->load(1)
    ->set(['CompanyName' => "test4" ])
    ->save()
    ->query("ROLLBACK");

print_r(
    PDO_DataObject::factory('Customers')
        ->load(1)
        ->toArray()
);



    
unlink($temp);

?>
--EXPECT--