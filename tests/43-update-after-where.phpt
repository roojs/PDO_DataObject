--TEST--
Update after using where with OLD
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest'
    // real db...
    /*
        'database' => '',
        'tables' => array(
            'Events'=> 'inserttest',
        ),
        'databases' => array(
            'inserttest' => 'mysql://root:@localhost/pman',
        ),
         'PDO' => 'PDO',
       */ 
));

PDO_DataObject::debugLevel(1);
  
 
echo "\n\n--------\n";
echo "update after using where  ;\n" ;

$event = PDO_DataObject::factory('Events');
$event->ipaddr="127.0.0.1";
$event->where('id >880453 and id < 880456');
foreach($event->fetchAll() as $e) {
        $old = clone($e);
        $e->action = "Ccc";
        $e->update($old);
}

--EXPECT--
--------
update after using where  ;
PDO_DataObject   : find       : false
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : query       : f3c3df658c34091f268f3767ae835fbb : SELECT *
 FROM   Events   
 WHERE ( ( id >880453 and id < 880456 ) AND (Events.ipaddr  = '127.0.0.1') ) 

QUERY:f3c3df658c34091f268f3767ae835fbb:
SELECT *
 FROM   Events   
 WHERE ( ( id >880453 and id < 880456 ) AND (Events.ipaddr  = '127.0.0.1') ) 

PDO_DataObject   : query       : NO# of results: 2
PDO_DataObject   : find       : CHECK autofetched false
PDO_DataObject   : find       : DONE
Fetch Row 0 / 2
PDO_DataObject   : fetch       : {"id":"880454","person_name":"alan","event_when":"2021-05-26 15:30:02","action":"bbb","ipaddr":"127.0.0.1","on_id":"0","on_table":"","person_id":"1","remarks":"PERMISSION DENIED (g)","person_table":"core_person","dupe_id":"0"}
Fetch Row 1 / 2
PDO_DataObject   : fetch       : {"id":"880455","person_name":"alan","event_when":"2021-05-27 11:37:56","action":"bbb","ipaddr":"127.0.0.1","on_id":"0","on_table":"","person_id":"1","remarks":"PERMISSION DENIED (g)","person_table":"core_person","dupe_id":"0"}
Fetch Row 2 / 2
PDO_DataObject   : fetch       : false
Close Cursor
PDO_DataObject   : query       : 1b787098d6053b2cb040a5d136424e80 : UPDATE  Events  SET action = 'Ccc'  WHERE (Events.id = 880454) 
QUERY:1b787098d6053b2cb040a5d136424e80:
UPDATE  Events  SET action = 'Ccc'  WHERE (Events.id = 880454) 
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : query       : ac53eb383010cd58315aa0d3a1d691a7 : UPDATE  Events  SET action = 'Ccc'  WHERE (Events.id = 880455) 
QUERY:ac53eb383010cd58315aa0d3a1d691a7:
UPDATE  Events  SET action = 'Ccc'  WHERE (Events.id = 880455) 
PDO_DataObject   : query       : NO# of results: 0