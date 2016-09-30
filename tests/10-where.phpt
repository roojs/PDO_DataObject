--TEST--
pid test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
        'database' => 'mysql://user:pass@localhost/gettest'
   // real db...
    //    'database' => 'mysql://root:@localhost/pman',
    //    'PDO' => 'PDO',        'proxy' => 'full',
));

echo "\n\n--------\n";
echo "simple where\n" ;

$company = PDO_DataObject::factory('Companies');
$company->where("a > 100");
echo "first add result: " . $company->toSelectSQL();


echo "\n\n--------\n";
echo "multiple chained where \n";

$company = PDO_DataObject::factory('Companies');
$company->where("a > 100")
       ->where("b < 100");

echo "multiple chained : " .$company->toSelectSQL();


echo "\n\n--------\n";
echo "reset and clear and OR condition.\n";
$company->where()->where("c > 10")->where('d >= 10', 'OR');
       

echo "After clear: " . $company->toSelectSQL();

echo "\n\n--------\n";
echo "some invalid input.\n";
try {
    $company->where('   ');
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "got exception as expected " . $e->getMessage() . "\n";
}
 
 
?>
--EXPECT--
 --------
simple where
first add result: SELECT *
 FROM   Companies   
 WHERE ( a > 100 )

--------
multiple chained where 
multiple chained : SELECT *
 FROM   Companies   
 WHERE ( a > 100 )  AND ( b < 100 )

--------
reset and clear and OR condition.
After clear: SELECT *
 FROM   Companies   
 WHERE ( c > 10 )  OR ( d >= 10 )

--------
some invalid input.
PDO_DataObject   : ERROR       : WhereAdd: No Valid Arguments
got exception as expected WhereAdd: No Valid Arguments
