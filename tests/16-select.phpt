--TEST--
select test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        'database' => 'mysql://user:pass@localhost/gettest'
));
 

echo "\n\n--------\n";
echo "select default\n" ;

$company = PDO_DataObject::factory('Companies');
echo "resulting query: " . $company->toSelectSQL();


echo "\n\n--------\n";
echo "select multiple calls\n" ;

$events = PDO_DataObject::factory('Events');
$events->select("e as a, f as b")
        ->select('h as j, vv as q');


echo "resulting query: " . $events->toSelectSQL();


echo "\n\n--------\n";
echo "select multiple calls - manually add star \n" ;

$events = PDO_DataObject::factory('Events');
$events->select('*')
        ->select("e as a, f as b")
        ->select('h as j, vv as q');


echo "resulting query: " . $events->toSelectSQL();


echo "\n\n--------\n";
echo "classic selectAdd with star added by default \n" ;

$events = PDO_DataObject::factory('Events');
$events->selectAdd('e as a, f as b');


echo "resulting query: " . $events->toSelectSQL();




echo "\n\n--------\n";
echo "select reset calls\n" ;

$events->select()
        ->select('a as b, c as d');
echo "resulting query: " . $events->toSelectSQL();


echo "\n\n--------\n";
echo "select reset nothing new (error)..\n" ;


$events->select();
try {
echo "resulting query: " . $events->toSelectSQL();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "as expected toSelectSQL failed : " . $e->getMessage();
}

echo "\n\n--------\n";
echo "select reset invalid args..\n" ;
try {
$events->select(' ');
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "as expected select failed : " . $e->getMessage();
}



?>
--EXPECT--
--------
select default
resulting query: SELECT *
 FROM   Companies 


--------
select multiple calls
resulting query: SELECT e as a, f as b ,  h as j, vv as q
 FROM   Events 


--------
select multiple calls - manually add star 
resulting query: SELECT * ,  e as a, f as b ,  h as j, vv as q
 FROM   Events 


--------
classic selectAdd with star added by default 
resulting query: SELECT *,  e as a, f as b
 FROM   Events 


--------
select reset calls
resulting query: SELECT a as b, c as d
 FROM   Events 


--------
select reset nothing new (error)..
PDO_DataObject   : ERROR       : Select is empty, call select with some arguments
as expected toSelectSQL failed : Select is empty, call select with some arguments

--------
select reset invalid args..
PDO_DataObject   : ERROR       : selectAdd: No Valid Arguments
as expected select failed : selectAdd: No Valid Arguments

