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
$events->select("e as a, f as b");
        ->select('h as j, vv as q');


echo "resulting query: " . $events->toSelectSQL();


echo "\n\n--------\n";
echo "select reset calls\n" ;

$events->select()
        ->select('a as b, c as d');
echo "resulting query: " . $events->toSelectSQL();


echo "\n\n--------\n";
echo "select reset nothing new (error)..\n" ;

$events->select();
echo "resulting query: " . $events->toSelectSQL();


echo "\n\n--------\n";
echo "select reset invalid args..\n" ;

$events->select(' ');
echo "resulting query: " . $events->toSelectSQL();



?>
--EXPECT--
--------
test union
__construct==["mysql:dbname=gettest;host=localhost","user","pass",[]]
setAttribute==[3,2]
resulting query: SELECT a,b
 FROM   Companies   
 WHERE ( a=b )
UNION  
 SELECT c as a, d as b
 FROM   Events   
 WHERE ( e=f ) 
 ORDER BY b desc  
 LIMIT  10

--------
test union rest
resulting query: SELECT a,b
 FROM   Companies   
 WHERE ( a=b )
UNION  
 SELECT e as a, f as b
 FROM   Events   
 WHERE ( e=f ) 
 ORDER BY b desc  , c desc 
 LIMIT  50

