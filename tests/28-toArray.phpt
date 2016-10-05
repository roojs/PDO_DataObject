--TEST--
setFrom / set Test
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
       'database' => 'mysql://user:pass@localhost/inserttest'
     /* 
        'database' => '',
        'tables' => array(
            'Events'=> 'inserttest',
            'Companies'=> 'inserttest',
        ),
        'databases' => array(
            'inserttest' => 'mysql://root:@localhost/pman',
        ),
         'PDO' => 'PDO',
         'proxy' => 'full',
         */
));

PDO_DataObject::debugLevel(0);
 
 
echo "\n\n--------\n";
echo "toArray - basic Raw;\n" ;

print_r(
    PDO_DataObject::factory('Dummy')
        ->set([
            'ex_string' => 'string',
            'ex_date' => '2000-01-01',
            'ex_datetime' => '2000-01-01 10:00:00',
            'ex_time' => '10:00:00',
            'ex_int' => 123
        ])
        ->toArray()
);

print_r(
    PDO_DataObject::factory('Dummy')
        ->set([
             
            'ex_string' => 'string',
            'ex_date' => '2000-01-01',
            'ex_datetime'  =>'2000-01-01 10:00:00',
            'ex_time' => '10:00:00',
            'ex_int' => 123
        ])
        ->toArray('with_prefix_%s')
);
 
echo "\n\n--------\n";
echo "toArray - default - table columns + result;\n" ;


print_r(
    PDO_DataObject::factory('Companies')
        ->set(['comptype' => 'CONSULTANT'])
        ->select(" id, name, 'fred the dog' as the_dog")
        ->limit(1)
        ->load()
        ->toArray('%s')
);

echo "\n\n--------\n";
echo "toArray - (3rd argument = true) -  table columns (not null) + result;\n" ;

print_r(
    PDO_DataObject::factory('Companies')
        ->set(['comptype' => 'CONSULTANT'])
        ->select(" id, name, 'fred the dog' as the_dog  ")
        ->limit(1)
        ->load()
        ->toArray('%s', true)
);
echo "\n\n--------\n";
echo "toArray - (3rd argument = 0) -  result columns only;\n" ;

print_r(
    PDO_DataObject::factory('Companies')
        ->set(['comptype' => 'CONSULTANT'])
        ->select(" id, name, 'fred the dog' as the_dog  ")
        ->limit(1)
        ->load()
        ->toArray('%s', 0)
);



?>
--EXPECT--
--------
toArray - basic Raw;
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
Array
(
    [id] => 
    [ex_blob] => 
    [ex_int] => 123
    [ex_string] => string
    [ex_date] => 2000-01-01
    [ex_datetime] => 2000-01-01 10:00:00
    [ex_time] => 10:00:00
    [ex_sql] => 
    [ex_null_string] => 
    [ex_null_int] => 
)
Array
(
    [with_prefix_id] => 
    [with_prefix_ex_blob] => 
    [with_prefix_ex_int] => 123
    [with_prefix_ex_string] => string
    [with_prefix_ex_date] => 2000-01-01
    [with_prefix_ex_datetime] => 2000-01-01 10:00:00
    [with_prefix_ex_time] => 10:00:00
    [with_prefix_ex_sql] => 
    [with_prefix_ex_null_string] => 
    [with_prefix_ex_null_int] => 
)


--------
toArray - default - table columns + result;
QUERY:765668840e5fa133769973c8b3d27bef:
SELECT id, name, 'fred the dog' as the_dog
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  1
Fetch Row 0 / 1
Array
(
    [id] => 68
    [name] => A company name
    [the_dog] => fred the dog
    [code] => 
    [remarks] => 
    [owner_id] => 
    [address] => 
    [tel] => 
    [fax] => 
    [email] => 
    [isOwner] => 
    [logo_id] => 
    [background_color] => 
    [comptype] => CONSULTANT
    [url] => 
    [main_office_id] => 
    [created_by] => 
    [created_dt] => 
    [updated_by] => 
    [updated_dt] => 
    [passwd] => 
    [dispatch_port] => 
    [province] => 
    [country] => 
)


--------
toArray - (3rd argument = true) -  table columns (not null) + result;
QUERY:765668840e5fa133769973c8b3d27bef:
SELECT id, name, 'fred the dog' as the_dog
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  1
Fetch Row 0 / 1
Array
(
    [id] => 68
    [name] => A company name
    [the_dog] => fred the dog
    [comptype] => CONSULTANT
)


--------
toArray - (3rd argument = 0) -  result columns only;
QUERY:765668840e5fa133769973c8b3d27bef:
SELECT id, name, 'fred the dog' as the_dog
 FROM   Companies   
 WHERE ( (Companies.comptype  = 'CONSULTANT') ) 
 LIMIT  1
Fetch Row 0 / 1
Array
(
    [id] => 68
    [name] => A company name
    [the_dog] => fred the dog
)