--TEST--
setFrom / set Test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest'
      
));

PDO_DataObject::debugLevel(0);
 

echo "\n\n--------\n";
echo "toArray - basic Raw;\n" ;

print_r( PDO_DataObject::factory('Dummy')
    ->set([
    'action' => PDO_DataObject::sqlValue('NOW()')
    ])
    ->toArray()
);



?>
--EXPECT--
--------
