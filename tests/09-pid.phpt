--TEST--
pid test
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(1);
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
PDO_DataObject   : databaseStructure       : CALL:[]
__construct==["mysql:dbname=gettest;host=localhost","user","pass",[]]
setAttribute==[3,2]
PDO_DataObject   : find       : true
PDO_DataObject   : query       : dde36b8c2603ce0b7357c878a4c6ad50 : SELECT *
 FROM   Companies   
 WHERE ( (Companies.id = 12) ) 

QUERY: dde36b8c2603ce0b7357c878a4c6ad50
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 1
PDO_DataObject   : fetch       : {"code":"MASL","name":"Modern (INTL) Access & Scaffolding Ltd","remarks":"","owner_id":"0","address":"","tel":"","fax":"","email":null,"id":"12","isOwner":"0","logo_id":"0","background_color":"","comptype":"","url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00","updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
PDO_DataObject   : find       : DONE
PID is : 12

--------
get pid on object that does not support it..
PDO_DataObject   : find       : true
PDO_DataObject   : query       : 196f2986575f749efe84e6134d37fbf7 : SELECT *
 FROM   Events 
 LIMIT  1
QUERY: 196f2986575f749efe84e6134d37fbf7
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 1
PDO_DataObject   : fetch       : {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
PDO_DataObject   : find       : DONE
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : raise       : No Primary Key available for table 'Events'
Getting Events pid() returned an exception as expected : No Primary Key available for table 'Events'