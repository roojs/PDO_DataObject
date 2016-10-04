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
echo "sqlValue - basic Raw;\n" ;

echo PDO_DataObject::factory('Events')
    ->set(['action' => PDO_DataObject::sqlValue('NOW()') ])
    ->whereToString();

echo "\n\n--------\n";
echo "sqlValue - various values..;\n" ;

echo PDO_DataObject::factory('Dummy')
    ->set([
        'ex_string' => 'aaa',
        'ex_sql' => 'bbb'
    ])
    ->whereToString();

echo "\n\n--------\n";
echo "sqlValue - using formating ..;\n" ;

echo PDO_DataObject::factory('Dummy')
    ->set([
        'a_ex_string' => 'aaa',
        'a_ex_sql' => 'bbb'
    ], 'a_%s')
    ->whereToString();


echo "\n\n--------\n";
echo "sqlValue - skip empty...;\n" ;

echo PDO_DataObject::factory('Dummy')
    ->set([
        'ex_string' => 'aaa',
        'ex_sql' => 'bbb'
    ])
    ->set([
        'ex_string' => 'ccc',
        'ex_sql' => ''
    ], '%s', true)
    ->whereToString();







PDO_DataObject::debugLevel(1);
echo "\n\n--------\n";
 
 
echo "\nsetting string and int to null: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_string' => null,
        'ex_int' => null,
        'ex_null_string' => null,
        'ex_null_int' => null,
    ])->whereToString(). "\n";
    
echo "\nsetting string and int to 'NULL' : " . PDO_DataObject::factory('Dummy')
    ->set([
        'ex_string' => 'NULL',
        'ex_int' => 'NULL',
        'ex_null_string' => 'NULL',
        'ex_null_int' => 'NULL',
    ])->whereToString() . "\n";
    

try {
echo "\nempty where with real null.: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_string' => PDO_DataObject::sqlValue('NULL'),
       'ex_int' => PDO_DataObject::sqlValue('NULL'),
    ])->whereToString();

    
} catch (PDO_DataObject_Exception_Set $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}
echo "\n\n--------\n";
echo "sqlValue - string null values on notnull (null);\n" ;

try {
PDO_DataObject::factory('Dummy')
    ->set([
       'ex_string' => 'NULL',
        'ex_int' => 'NULL',
    ])
    ->whereToString();
    
} catch (PDO_DataObject_Exception_Set $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}


PDO_DataObject::debugLevel(1);
echo "\n\n--------\n";
echo "sqlValue - null values;\n" ;









echo "\nusing value null: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_string' => null,
        'ex_int' => null,
        'ex_null_string' => null,
        'ex_null_int' => null
    ])
    ->whereToString();



echo "\nusing string null: " . PDO_DataObject::factory('Dummy')
    ->set([
       // 'ex_string' => 'NULL',
       // 'ex_int' => 'NULL',
        'ex_null_string' => 'NULL',
        'ex_null_sql' => 'NULL'
    ])
    ->whereToString();
    
    
echo "\n\n--------\n";
echo "sqlValue - null values (disable_null_strings);\n" ;
PDO_DataObject::config('disable_null_strings', true);

echo "\nusing value null: " . PDO_DataObject::factory('Dummy')
    ->set([
        'ex_string' => null,
        'ex_int' => null,
        'ex_null_string' => null,
        'ex_null_int' => null
    ])
    ->whereToString();



echo "\nusing string null: " . PDO_DataObject::factory('Dummy')
    ->set([
        'ex_string' => 'NULL',
        'ex_int' => 'NULL',
        'ex_null_string' => 'NULL',
        'ex_null_sql' => 'NULL'
    ])
    ->whereToString();


 
?>
--EXPECT--
