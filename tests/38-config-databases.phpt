--TEST--
database settings test Test  - real mysql
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest',
        'class_prefix' => 'DataObjects_',
));


echo "\n\n--------\n";
echo "Test Mysql \n" ;



PDO_DataObject::config(array(
     
        'database' => '',
        
        'databases' => array(
            'inserttest' => 'mysql://root:@localhost/pman',
        ),
         'PDO' => 'PDO',
     
));

PDO_DataObject::debugLevel(1);
 

echo "\n\n--------\n";
echo "basic load a big result set\n" ;

$x = PDO_DataObject::factory('Events');