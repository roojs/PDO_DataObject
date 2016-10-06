--TEST--
setFrom / set Test (where enable_string_null = true)
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest'
      
));

PDO_DataObject::debugLevel(0);
 


 
  
  
echo "enable_null_strings = full\n" ;
PDO_DataObject::config('enable_null_strings', 'full');

PDO_DataObject::debugLevel(0);
  
 
echo "\nsetting string and int to null: " . PDO_DataObject::factory('Dummy')
    ->set([
        'ex_null_string' => null,
        'ex_null_int' => null,
    ])->whereToString(). "\n";



try {   
PDO_DataObject::factory('Dummy')
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

echo "\nusing real null props : == {$d->whereToString()} == \n";
echo "\nthat was empty, as properites can not be set to null - it can not be detected, use set() or cast()  \n";

 



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

 
