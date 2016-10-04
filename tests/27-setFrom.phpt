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





echo "\n\n----------------------------------------------------------------\n";


PDO_DataObject::debugLevel(1);
echo "\n\n--------\n";
echo "enable_null_valus = default = off\n" ;

 
echo "\nsetting string and int to null: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_string' => null,
        'ex_int' => null,
        'ex_null_string' => null,
        'ex_null_int' => null,
    ])->whereToString(). "\n";


echo "\n\n--------\n";
echo "TESTING string NULL - enable_null_valus = default = off\n" ;

    
echo "\nsetting string   to 'NULL' : " . PDO_DataObject::factory('Dummy')
    ->set([
        'ex_string' => 'NULL',
        'ex_null_string' => 'NULL',
    ])->whereToString() . "\n";
    
try {   
echo "\nsetting string and int to 'NULL' : " . PDO_DataObject::factory('Dummy')
    ->set([
        'ex_int' => 'NULL',
        'ex_null_int' => 'NULL',
    ])->whereToString() . "\n";    
} catch (PDO_DataObject_Exception_Set $e) {
    echo "\nset got errors as expected: {$e->getMessage()}\n";
}   



echo "TESTING CAST NULL - enable_null_valus = default = off\n" ;    

try {
echo "\nempty where with real null.: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_string' => PDO_DataObject::sqlValue('NULL'),
       'ex_int' => PDO_DataObject::sqlValue('NULL'),
    ])->whereToString();
   
} catch (PDO_DataObject_Exception_Set $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}

echo "\nempty where with real null.: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_null_string' => PDO_DataObject::sqlValue('NULL'),
       'ex_null_int' => PDO_DataObject::sqlValue('NULL'),
    ])->whereToString();



echo "\n\n----------------------------------------------------------------\n";

echo "enable_null_strings = true\n" ;
PDO_DataObject::config('enable_null_strings', true);

PDO_DataObject::debugLevel(1);
  
 
echo "\nsetting string and int to null: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_string' => null,
        'ex_int' => null,
        'ex_null_string' => null,
        'ex_null_int' => null,
    ])->whereToString(). "\n";


echo "\n\n--------\n";
echo "TESTING string NULL -  enable_null_strings = true \n" ;

    
echo "\nsetting string   to 'NULL' : " . PDO_DataObject::factory('Dummy')
    ->set([
        
        'ex_null_string' => 'NULL',
        'ex_null_int' => 'NULL',
    ])->whereToString() . "\n";
    
try {   
echo "\nsetting string and int to 'NULL' : " . PDO_DataObject::factory('Dummy')
    ->set([
        'ex_int' => 'NULL',
        'ex_string' => 'NULL',
        
    ])->whereToString() . "\n";    
} catch (PDO_DataObject_Exception_Set $e) {
    echo "\nset got errors as expected: {$e->getMessage()}\n";
}   



echo "TESTING CAST NULL - enable_null_strings = true\n" ;    

try {
echo "\nempty where with real null.: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_string' => PDO_DataObject::sqlValue('NULL'),
       'ex_int' => PDO_DataObject::sqlValue('NULL'),
    ])->whereToString();
   
} catch (PDO_DataObject_Exception_Set $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}

echo "\nempty where with real null.: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_null_string' => PDO_DataObject::sqlValue('NULL'),
       'ex_null_int' => PDO_DataObject::sqlValue('NULL'),
    ])->whereToString();







echo "\n\n----------------------------------------------------------------\n";

echo "enable_null_strings = full\n" ;
PDO_DataObject::config('enable_null_strings', 'full');

PDO_DataObject::debugLevel(1);
  
 
echo "\nsetting string and int to null: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_string' => null,
        'ex_int' => null,
        'ex_null_string' => null,
        'ex_null_int' => null,
    ])->whereToString(). "\n";


echo "\n\n--------\n";
echo "TESTING string NULL -  enable_null_strings = true \n" ;

    
echo "\nsetting string   to 'NULL' : " . PDO_DataObject::factory('Dummy')
    ->set([
        
        'ex_null_string' => 'NULL',
        'ex_null_int' => 'NULL',
    ])->whereToString() . "\n";
    
try {   
echo "\nsetting string and int to 'NULL' : " . PDO_DataObject::factory('Dummy')
    ->set([
        'ex_int' => 'NULL',
        'ex_string' => 'NULL',
        
    ])->whereToString() . "\n";    
} catch (PDO_DataObject_Exception_Set $e) {
    echo "\nset got errors as expected: {$e->getMessage()}\n";
}   



echo "TESTING CAST NULL - enable_null_strings = true\n" ;    

try {
echo "\nempty where with real null.: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_string' => PDO_DataObject::sqlValue('NULL'),
       'ex_int' => PDO_DataObject::sqlValue('NULL'),
    ])->whereToString();
   
} catch (PDO_DataObject_Exception_Set $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}

echo "\nempty where with real null.: " . PDO_DataObject::factory('Dummy')
    ->set([
       'ex_null_string' => PDO_DataObject::sqlValue('NULL'),
       'ex_null_int' => PDO_DataObject::sqlValue('NULL'),
    ])->whereToString();










?>
--EXPECT--
