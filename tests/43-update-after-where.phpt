--TEST--
Update after using where with OLD
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
       //  'database' => 'mysql://user:pass@localhost/inserttest'
    // real db...
    
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
echo "update after using where  ;\n" ;

$event = PDO_DataObject::factory('Events');
$event->ipaddr="127.0.0.1";
$event->where('id >880453 and id < 880456');
foreach($event->fetchAll() as $e) {
        $old = clone($e);
        $e->action = "Ccc";
        $e->update($old);
}

--EXPECT--
DONE