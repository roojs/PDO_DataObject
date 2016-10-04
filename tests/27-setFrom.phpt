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

echo "\n\n--------\n";
echo "TESTING props setting\n" ;

// now setting properties...
$d =  PDO_DataObject::factory('Dummy');
$d->ex_string = null;
$d->ex_int = null;
$d->ex_null_string = null;
$d->ex_null_int = null;
echo "\nusing null props : == {$d->whereToString()} == \n";

$d =  PDO_DataObject::factory('Dummy');
$d->ex_string = "null";
$d->ex_int = "null";
$d->ex_null_string = "null";
$d->ex_null_int = "null";
echo "\nusing null props : == {$d->whereToString()} == \n";

$d =  PDO_DataObject::factory('Dummy');
$d->ex_null_string = PDO_DataObject::sqlValue('NULL');
$d->ex_null_int = PDO_DataObject::sqlValue('NULL');
echo "\nusing null props : == {$d->whereToString()} == \n";

try {
$d =  PDO_DataObject::factory('Dummy');
$d->ex_string = PDO_DataObject::sqlValue('NULL');
$d->whereToString();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}

try {
$d =  PDO_DataObject::factory('Dummy');
$d->ex_int = PDO_DataObject::sqlValue('NULL');
$d->whereToString();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}





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




echo "\n\n--------\n";
echo "TESTING props setting\n" ;

// now setting properties...
$d =  PDO_DataObject::factory('Dummy');
$d->ex_string = null;
$d->ex_int = null;
$d->ex_null_string = null;
$d->ex_null_int = null;
echo "\nusing null props : == {$d->whereToString()} == \n";



echo "\n\n--------\n";
echo "TESTING props setting (string)\n" ;

$d =  PDO_DataObject::factory('Dummy');
$d->ex_null_string = "null";
$d->ex_null_int = "null";
echo "\nusing null props : == {$d->whereToString()} == \n";

try {
$d =  PDO_DataObject::factory('Dummy');
$d->ex_string = "null";
echo $d->whereToString();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}
try {
$d =  PDO_DataObject::factory('Dummy');
$d->ex_int = "null";
echo $d->whereToString();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}

echo "\n\n--------\n";
echo "TESTING props setting cast)\n" ;



$d =  PDO_DataObject::factory('Dummy');
$d->ex_null_string = PDO_DataObject::sqlValue('NULL');
$d->ex_null_int = PDO_DataObject::sqlValue('NULL');
echo "\nusing null props : == {$d->whereToString()} == \n";

try {
$d =  PDO_DataObject::factory('Dummy');
$d->ex_string = PDO_DataObject::sqlValue('NULL');
echo $d->whereToString();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}

try {
$d =  PDO_DataObject::factory('Dummy');
$d->ex_int = PDO_DataObject::sqlValue('NULL');
echo $d->whereToString();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}

 


echo "\n\n----------------------------------------------------------------\n";

echo "enable_null_strings = full\n" ;
PDO_DataObject::config('enable_null_strings', 'full');

PDO_DataObject::debugLevel(1);
  
 
echo "\nsetting string and int to null: " . PDO_DataObject::factory('Dummy')
    ->set([
        'ex_null_string' => null,
        'ex_null_int' => null,
    ])->whereToString(). "\n";



try {   
echo "\nsetting string and int to 'NULL' : " . PDO_DataObject::factory('Dummy')
    ->set([
        'ex_int' => null,
        'ex_string' => null,
        
    ])->whereToString() . "\n";    
} catch (PDO_DataObject_Exception_Set $e) {
    echo "\nset got errors as expected: {$e->getMessage()}\n";
}   


echo "\n\n--------\n";
echo "TESTING string NULL -  enable_null_strings = full \n" ;

    
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





echo "\n\n--------\n";
echo "TESTING props setting\n" ;

// now setting properties... -- in theory this is what 'full' was supposed to do, but it will never work,
// as we can not test this!?!?
$d =  PDO_DataObject::factory('Dummy');
$d->ex_string = null;
$d->ex_int = null;
$d->ex_null_string = null;
$d->ex_null_int = null;
echo "\nusing null props with FULL - this is a broken situation, which is why removed support for it.: == {$d->whereToString()} == \n";

 



echo "\n\n--------\n";
echo "TESTING props setting (string)\n" ;

$d =  PDO_DataObject::factory('Dummy');
$d->ex_null_string = "null";
$d->ex_null_int = "null";
echo "\nusing null props : == {$d->whereToString()} == \n";

try {
$d =  PDO_DataObject::factory('Dummy');
$d->ex_string = "null";
echo $d->whereToString();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}
try {
$d =  PDO_DataObject::factory('Dummy');
$d->ex_int = "null";
echo $d->whereToString();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}

echo "\n\n--------\n";
echo "TESTING props setting cast)\n" ;



$d =  PDO_DataObject::factory('Dummy');
$d->ex_null_string = PDO_DataObject::sqlValue('NULL');
$d->ex_null_int = PDO_DataObject::sqlValue('NULL');
echo "\nusing null props : == {$d->whereToString()} == \n";

try {
$d =  PDO_DataObject::factory('Dummy');
$d->ex_string = PDO_DataObject::sqlValue('NULL');
echo $d->whereToString();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}

try {
$d =  PDO_DataObject::factory('Dummy');
$d->ex_int = PDO_DataObject::sqlValue('NULL');
echo $d->whereToString();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "set got errors as expected: {$e->getMessage()}\n";
}

 

 

?>
--EXPECT--
--------
sqlValue - basic Raw;
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
 Events.action = NOW()

--------
sqlValue - various values..;
FROM VALUE ex_string, 130, 'aaa' 
FROM VALUE ex_sql, 130, 'bbb' 
(Dummy.ex_string  = 'aaa') AND (Dummy.ex_sql  = 'bbb')

--------
sqlValue - using formating ..;
FROM VALUE ex_string, 130, 'aaa' 
FROM VALUE ex_sql, 130, 'bbb' 
(Dummy.ex_string  = 'aaa') AND (Dummy.ex_sql  = 'bbb')

--------
sqlValue - skip empty...;
FROM VALUE ex_string, 130, 'aaa' 
FROM VALUE ex_sql, 130, 'bbb' 
FROM VALUE ex_string, 130, 'ccc' 
(Dummy.ex_string  = 'ccc') AND (Dummy.ex_sql  = 'bbb')

----------------------------------------------------------------


--------
enable_null_valus = default = off
PDO_DataObject   : databaseStructure       : CALL:[]
FROM VALUE ex_int, 129, NULL 
FROM VALUE ex_string, 130, NULL 
FROM VALUE ex_null_string, 2, NULL 
FROM VALUE ex_null_int, 1, NULL 

setting string and int to null: (Dummy.ex_int = 0) AND (Dummy.ex_string  = '') AND (Dummy.ex_null_string  = '') AND (Dummy.ex_null_int = 0)


--------
TESTING string NULL - enable_null_valus = default = off
PDO_DataObject   : databaseStructure       : CALL:[]
FROM VALUE ex_string, 130, 'NULL' 
FROM VALUE ex_null_string, 2, 'NULL' 

setting string   to 'NULL' : (Dummy.ex_string  = 'NULL') AND (Dummy.ex_null_string  = 'NULL')
PDO_DataObject   : databaseStructure       : CALL:[]
FROM VALUE ex_int, 129, 'NULL' 
FROM VALUE ex_null_int, 1, 'NULL' 
PDO_DataObject   : raise       : Set Errors Returned Values: 
Array
(
    [ex_int] => Error: ex_int : type is INT -> Non numeric 'NULL' passed to it
    [ex_null_int] => Error: ex_null_int : type is INT -> Non numeric 'NULL' passed to it
)


set got errors as expected: Set Errors Returned Values: 
Array
(
    [ex_int] => Error: ex_int : type is INT -> Non numeric 'NULL' passed to it
    [ex_null_int] => Error: ex_null_int : type is INT -> Non numeric 'NULL' passed to it
)

TESTING CAST NULL - enable_null_valus = default = off
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : raise       : Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)

set got errors as expected: Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)

PDO_DataObject   : databaseStructure       : CALL:[]

empty where with real null.: (Dummy.ex_null_string IS NULL) AND (Dummy.ex_null_int IS NULL)

--------
TESTING props setting

using null props : ==  == 

using null props : == (Dummy.ex_int = 0) AND (Dummy.ex_string  = 'null') AND (Dummy.ex_null_string  = 'null') AND (Dummy.ex_null_int = 0) == 

using null props : == (Dummy.ex_null_string IS NULL) AND (Dummy.ex_null_int IS NULL) == 
PDO_DataObject   : raise       : Error setting col 'ex_string' to NULL - column is NOT NULL
set got errors as expected: Error setting col 'ex_string' to NULL - column is NOT NULL
PDO_DataObject   : raise       : Error setting col 'ex_int' to NULL - column is NOT NULL
set got errors as expected: Error setting col 'ex_int' to NULL - column is NOT NULL


----------------------------------------------------------------
enable_null_strings = true
PDO_DataObject   : databaseStructure       : CALL:[]
FROM VALUE ex_int, 129, NULL 
FROM VALUE ex_string, 130, NULL 
FROM VALUE ex_null_string, 2, NULL 
FROM VALUE ex_null_int, 1, NULL 

setting string and int to null: (Dummy.ex_int = 0) AND (Dummy.ex_string  = '') AND (Dummy.ex_null_string  = '') AND (Dummy.ex_null_int = 0)


--------
TESTING string NULL -  enable_null_strings = true 
PDO_DataObject   : databaseStructure       : CALL:[]

setting string   to 'NULL' : (Dummy.ex_null_string IS NULL) AND (Dummy.ex_null_int IS NULL)
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : raise       : Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)


set got errors as expected: Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)

TESTING CAST NULL - enable_null_strings = true
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : raise       : Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)

set got errors as expected: Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)

PDO_DataObject   : databaseStructure       : CALL:[]

empty where with real null.: (Dummy.ex_null_string IS NULL) AND (Dummy.ex_null_int IS NULL)

--------
TESTING props setting

using null props : ==  == 


--------
TESTING props setting (string)

using null props : == (Dummy.ex_null_string  IS NULL) AND (Dummy.ex_null_int  IS NULL) == 
PDO_DataObject   : raise       : Error setting col 'ex_string' to NULL - column is NOT NULL
set got errors as expected: Error setting col 'ex_string' to NULL - column is NOT NULL
PDO_DataObject   : raise       : Error setting col 'ex_int' to NULL - column is NOT NULL
set got errors as expected: Error setting col 'ex_int' to NULL - column is NOT NULL


--------
TESTING props setting cast)

using null props : == (Dummy.ex_null_string IS NULL) AND (Dummy.ex_null_int IS NULL) == 
PDO_DataObject   : raise       : Error setting col 'ex_string' to NULL - column is NOT NULL
set got errors as expected: Error setting col 'ex_string' to NULL - column is NOT NULL
PDO_DataObject   : raise       : Error setting col 'ex_int' to NULL - column is NOT NULL
set got errors as expected: Error setting col 'ex_int' to NULL - column is NOT NULL


----------------------------------------------------------------
enable_null_strings = full
PDO_DataObject   : databaseStructure       : CALL:[]

setting string and int to null: (Dummy.ex_null_string IS NULL) AND (Dummy.ex_null_int IS NULL)
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : raise       : Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)


set got errors as expected: Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)



--------
TESTING string NULL -  enable_null_strings = full 
PDO_DataObject   : databaseStructure       : CALL:[]

setting string   to 'NULL' : (Dummy.ex_null_string IS NULL) AND (Dummy.ex_null_int IS NULL)
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : raise       : Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)


set got errors as expected: Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)

TESTING CAST NULL - enable_null_strings = true
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : raise       : Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)

set got errors as expected: Set Errors Returned Values: 
Array
(
    [ex_int] => setting column ex_int to Null is invalid as it's NOTNULL
    [ex_string] => setting column ex_string to Null is invalid as it's NOTNULL
)

PDO_DataObject   : databaseStructure       : CALL:[]

empty where with real null.: (Dummy.ex_null_string IS NULL) AND (Dummy.ex_null_int IS NULL)

--------
TESTING props setting

using null props with FULL - this is a broken situation, which is why removed support for it.: ==  == 


--------
TESTING props setting (string)

using null props : == (Dummy.ex_null_string  IS NULL) AND (Dummy.ex_null_int  IS NULL) == 
PDO_DataObject   : raise       : Error setting col 'ex_string' to NULL - column is NOT NULL
set got errors as expected: Error setting col 'ex_string' to NULL - column is NOT NULL
PDO_DataObject   : raise       : Error setting col 'ex_int' to NULL - column is NOT NULL
set got errors as expected: Error setting col 'ex_int' to NULL - column is NOT NULL


--------
TESTING props setting cast)

using null props : == (Dummy.ex_null_string IS NULL) AND (Dummy.ex_null_int IS NULL) == 
PDO_DataObject   : raise       : Error setting col 'ex_string' to NULL - column is NOT NULL
set got errors as expected: Error setting col 'ex_string' to NULL - column is NOT NULL
PDO_DataObject   : raise       : Error setting col 'ex_int' to NULL - column is NOT NULL
set got errors as expected: Error setting col 'ex_int' to NULL - column is NOT NULL