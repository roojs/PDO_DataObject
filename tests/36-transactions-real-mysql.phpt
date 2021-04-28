--TEST--
tranaction Test  - needs real mysql
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest',
        'class_prefix' => 'DataObjects_',
));


echo "\n\n--------\n";
echo "Test Mysql \n" ;



PDO_DataObject::config(array(
     
        'database' => '',
        'tables' => array(
            'Events'=> 'inserttest',
        ),
        'databases' => array(
            'inserttest' => 'mysql://root:@localhost/pman',
        ),
         'PDO' => 'PDO',
     
));

PDO_DataObject::debugLevel(1);
 

echo "\n\n--------\n";
echo "basic load/set/save ROLLBACK;\n" ;

print_r(
PDO_DataObject::factory('Events')
    ->query('BEGIN')
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    ->query('ROLLBACK')
    ->reload()
    ->toArray()
);

print_r(
PDO_DataObject::factory('Events')
    ->query('BEGIN')
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save()
    ->query('COMMIT')
    ->reload()
    ->toArray()
);

// reset the value...
PDO_DataObject::factory('Events')
    ->load(3523)
    ->set(['action' => "RELOAD" ])
    ->save();

?>
--EXPECT--
--------
Test Mysql 


--------
basic load/set/save ROLLBACK;
PDO_DataObject   : PDO       : Checking for database specific ini ('inserttest') : config[databases][inserttest] in options
PDO_DataObject   : query       : 19aad9f2fe3ce0023298ab83f7e75775 : BEGIN
PDO_DataObject   : query       : BEGIN
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : get       : ('id', 3523) keys= Array
(
    [0] => id
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 183b4035a4a59e23b849e6bdd8a53fdb : SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null,"dupe_id":"0"}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : 9da43100ad8e2d1eee0cfee396c16588 : UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3523) 
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : query       : 2805522dd41e1b57da11967ac5fa258c : ROLLBACK
PDO_DataObject   : query       : ROLLBACK
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('inserttest') : config[databases][inserttest] in options
PDO_DataObject   : get       : ('id', '3523') keys= Array
(
    [0] => id
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 183b4035a4a59e23b849e6bdd8a53fdb : SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null,"dupe_id":"0"}
PDO_DataObject   : find       : DONE
Array
(
    [id] => 3523
    [person_name] => Alan
    [event_when] => 2009-04-16 14:05:32
    [action] => RELOAD
    [ipaddr] => 202.134.82.251
    [on_id] => 0
    [on_table] => 
    [person_id] => 4
    [remarks] => 0
    [person_table] => 
    [dupe_id] => 0
)
PDO_DataObject   : PDO       : Checking for database specific ini ('inserttest') : config[databases][inserttest] in options
PDO_DataObject   : query       : 19aad9f2fe3ce0023298ab83f7e75775 : BEGIN
PDO_DataObject   : query       : BEGIN
PDO_DataObject   : get       : ('id', 3523) keys= Array
(
    [0] => id
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 183b4035a4a59e23b849e6bdd8a53fdb : SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null,"dupe_id":"0"}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : 9da43100ad8e2d1eee0cfee396c16588 : UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3523) 
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : query       : 1d0ba376e273b9d622641124d8c59264 : COMMIT
PDO_DataObject   : query       : COMMIT
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('inserttest') : config[databases][inserttest] in options
PDO_DataObject   : get       : ('id', '3523') keys= Array
(
    [0] => id
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 183b4035a4a59e23b849e6bdd8a53fdb : SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"testing","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null,"dupe_id":"0"}
PDO_DataObject   : find       : DONE
Array
(
    [id] => 3523
    [person_name] => Alan
    [event_when] => 2009-04-16 14:05:32
    [action] => testing
    [ipaddr] => 202.134.82.251
    [on_id] => 0
    [on_table] => 
    [person_id] => 4
    [remarks] => 0
    [person_table] => 
    [dupe_id] => 0
)
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : PDO       : Checking for database specific ini ('inserttest') : config[databases][inserttest] in options
PDO_DataObject   : get       : ('id', 3523) keys= Array
(
    [0] => id
)

PDO_DataObject   : find       : true
PDO_DataObject   : query       : 183b4035a4a59e23b849e6bdd8a53fdb : SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
PDO_DataObject   : fetch       : {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"testing","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null,"dupe_id":"0"}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : aa7e82b2a77902f4d3cc43c60837099b : UPDATE  Events  SET action = 'RELOAD'  WHERE (Events.id = 3523) 
PDO_DataObject   : query       : NO# of results: 1