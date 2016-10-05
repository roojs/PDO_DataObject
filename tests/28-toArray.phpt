--TEST--
setFrom / set Test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
   //     'database' => 'mysql://user:pass@localhost/inserttest'
      
        'database' => '',
        'tables' => array(
            'Events'=> 'inserttest',
        ),
        'databases' => array(
            'inserttest' => 'mysql://root:@localhost/pman',
        ),
         'PDO' => 'PDO',
));

PDO_DataObject::debugLevel(0);
 
/*
echo "\n\n--------\n";
echo "toArray - basic Raw;\n" ;

print_r( PDO_DataObject::factory('Dummy')
    ->set([
         
        'ex_string' => 'string'
        'ex_date' => '2000-01-01',
        'ex_datetime'  '2000-01-01 10:00:00',
        'ex_time' => '10:00:00',
        'ex_int' => 123
    ])
    ->toArray()
);

*/
print_r( PDO_DataObject::factory('Dummy')
    ->set([
         
        'ex_string' => 'string'
        'ex_date' => '2000-01-01',
        'ex_datetime'  '2000-01-01 10:00:00',
        'ex_time' => '10:00:00',
        'ex_int' => 123
    ])
    ->toArray('with_prefix_%s')
);

print_r(  PDO_DataObject::factory('Companies')
    ->set(['comptype' => 'CONSULTANT'])
    ->select(" id, name, 'fred the dog' as the_dog")
    ->limit(1)
    ->load()
    ->toArray('%s')
);


print_r(  PDO_DataObject::factory('Companies')
    ->set(['comptype' => 'CONSULTANT'])
    ->select(" id, name, 'fred the dog' as the_dog  ")
    ->limit(1)
    ->load()
    ->toArray('%s', true)
);

print_r(  PDO_DataObject::factory('Companies')
    ->set(['comptype' => 'CONSULTANT'])
    ->select(" id, name, 'fred the dog' as the_dog  ")
    ->limit(1)
    ->load()
    ->toArray('%s', 0)
);



?>
--EXPECT--
--------
