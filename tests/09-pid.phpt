--TEST--
pid test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        'database' => 'mysql://user:pass@localhost/gettest'

));

echo "\n\n--------\n";
echo "get some pid's\n" ;

$company = PDO_DataObject::factory('Companies');
if ($company->get(12)) {
    echo "PID is : " . $company->pid();
}



echo "\n\n--------\n";
echo "get pid on object that does not support it..\n";

$events = PDO_DataObject::factory('Events');
$events->limit(1);
$events->find(true);
try {
    $pid = $events->pid();
} catch (PDO_DataObject_Exception_InvalidConfig $e) {
    echo "Getting Events pid() returned an exception as expected : " . $e->getMessage();
}

?>
--EXPECT--
--------
get some pid's
__construct==["mysql:dbname=gettest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:dde36b8c2603ce0b7357c878a4c6ad50:
SELECT *
 FROM   Companies   
 WHERE ( (Companies.id = 12) ) 

Fetch Row 0 / 1
PID is : 12

--------
get pid on object that does not support it..
QUERY:196f2986575f749efe84e6134d37fbf7:
SELECT *
 FROM   Events 
 LIMIT  1
Fetch Row 0 / 1
Getting Events pid() returned an exception as expected : No Primary Key available for table 'Events'