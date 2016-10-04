--TEST--
load() save() and snapshot() test
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
     // */   
));

PDO_DataObject::debugLevel(1);
 
// used to extract sample data...
//PDO_DataObject::factory('Events')->limit(1)->find(true);

PDO_DataObject::factory('Events')->query('BEGIN');

echo "\n\n--------\n";
echo "basic load/set/save;\n" ;

PDO_DataObject::factory('Events')
    ->load(3523)
    ->set(['action' => "testing" ])
    ->save();


echo "\n\n--------\n";
echo "using where to filter.. find/set/save;\n" ;

PDO_DataObject::factory('Events')
    ->where('id > 3600')
    ->limit(1)
    ->load()
    ->set(['action' => "testing" ])
    ->save();

echo "\n\n--------\n";
echo "using where set filter.. find/set/save;\n" ;

PDO_DataObject::factory('Events')
    ->set(['action' => "RELOAD" ])
    ->limit(1)
    ->load()
    ->set(['action' => "testing" ])
    ->save();



echo "\n\n--------\n";
echo "Testing errors in load;\n" ;



// error condition.. loading data that does not exist...
try {

    PDO_DataObject::factory('Events')
        ->load(12);

} catch (PDO_DataObject_Exception_NoData $e) {
    echo "Load fail - Error thrown as expected: {$e->getMessage()}\n";
}

try {

PDO_DataObject::factory('Events')
    ->load();

} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "Load fail - Error thrown as expected: {$e->getMessage()}\n";
}
try {

PDO_DataObject::factory('Events')
    ->where("id > 100")
    ->limit(10)
    ->load();

} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "Load fail - Error thrown as expected: {$e->getMessage()}\n";
}




echo "\n\n--------\n";
echo "Testing insert save (copying an object);\n" ;

PDO_DataObject::factory('Events')->set(
    PDO_DataObject::factory('Events')
        ->load(3526)
)->save();
 





?>
--EXPECT--
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
PDO_DataObject   : query       : 19aad9f2fe3ce0023298ab83f7e75775 : BEGIN
PDO_DataObject   : query       : BEGIN


--------
basic load/set/save;
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : find       : true
PDO_DataObject   : query       : 183b4035a4a59e23b849e6bdd8a53fdb : SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

QUERY: 183b4035a4a59e23b849e6bdd8a53fdb
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 1
PDO_DataObject   : fetch       : {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : 9da43100ad8e2d1eee0cfee396c16588 : UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3523) 
QUERY: 9da43100ad8e2d1eee0cfee396c16588
PDO_DataObject   : query       : NO# of results: 1


--------
using where to filter.. find/set/save;
PDO_DataObject   : find       : true
PDO_DataObject   : query       : 30e4e6e9c534f092302558ec8faa1c11 : SELECT *
 FROM   Events   
 WHERE ( ( id > 3600 ) ) 
 LIMIT  1
QUERY: 30e4e6e9c534f092302558ec8faa1c11
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 1
PDO_DataObject   : fetch       : {"id":"3601","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : 35026f20209f1caa71d6443d725b9aa2 : UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3601) 
QUERY: 35026f20209f1caa71d6443d725b9aa2
PDO_DataObject   : query       : NO# of results: 1


--------
using where set filter.. find/set/save;
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : find       : true
PDO_DataObject   : query       : abbcef562aa23b791bed62846d4ca33f : SELECT *
 FROM   Events   
 WHERE ( (Events.action  = 'RELOAD') ) 
 LIMIT  1
QUERY: abbcef562aa23b791bed62846d4ca33f
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 1
PDO_DataObject   : fetch       : {"id":"3524","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
PDO_DataObject   : find       : DONE
PDO_DataObject   : query       : 0115ca6837334e416b34e84c0b4f31a7 : UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3524) 
QUERY: 0115ca6837334e416b34e84c0b4f31a7
PDO_DataObject   : query       : NO# of results: 1


--------
Testing errors in load;
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : find       : true
PDO_DataObject   : query       : 2bdf264b81e628acfbf68368a1175be6 : SELECT *
 FROM   Events   
 WHERE ( (Events.id = 12) ) 

QUERY: 2bdf264b81e628acfbf68368a1175be6
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : raise       : No Data returned from load
Load fail - Error thrown as expected: No Data returned from load
PDO_DataObject   : raise       : No condition (property or where) set for loading data.
Load fail - Error thrown as expected: No condition (property or where) set for loading data.
PDO_DataObject   : find       : true
PDO_DataObject   : query       : 65e45926e39a354d24d0cefa47038dd8 : SELECT *
 FROM   Events   
 WHERE ( ( id > 100 ) ) 
 LIMIT  10
QUERY: 65e45926e39a354d24d0cefa47038dd8
PDO_DataObject   : query       : NO# of results: 2
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 2
PDO_DataObject   : fetch       : {"id":"3524","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
PDO_DataObject   : find       : DONE
PDO_DataObject   : raise       : Too many rows returned from load
Load fail - Error thrown as expected: Too many rows returned from load


--------
Testing insert save (copying an object);
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : find       : true
PDO_DataObject   : query       : 9d10a45b72cac1e6e75db3e71e077d7c : SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3526) ) 

QUERY: 9d10a45b72cac1e6e75db3e71e077d7c
PDO_DataObject   : query       : NO# of results: 1
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : find       : ABOUT TO AUTOFETCH
Fetch Row 0 / 1
PDO_DataObject   : fetch       : {"id":"3526","person_name":"Alan","event_when":"2009-04-16 14:08:40","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
PDO_DataObject   : find       : DONE
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : query       : 86f9b0a9131676c87d66a0cb0264b879 : INSERT INTO Events (person_name , event_when , action , ipaddr , on_id , on_table , person_id , remarks ) VALUES ('Alan' , '2009-04-16 14:08:40' , 'RELOAD' , '202.134.82.251' ,  0 , '' ,  4 , '0' ) 
QUERY: 86f9b0a9131676c87d66a0cb0264b879
PDO_DataObject   : query       : NO# of results: 1
lastInsertId from sequence=''  is 1