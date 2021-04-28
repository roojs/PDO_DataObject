--TEST--
unbuffered query Test  - needs real mysql
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest',
        'class_prefix' => 'DataObjects_',
));

 


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
echo "basic load a big result set\n" ;


PDO_DataObject::factory('Events')->PDO()->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
 
$x = PDO_DataObject::factory('Events');
$x->find();

while($x->fetch()) {
    print_r($x->toArray());
    exit;
    
}
?>
--EXPECT--
--------
basic load a big result set
PDO_DataObject   : PDO       : Checking for database specific ini ('inserttest') : config[databases][inserttest] in options
PDO_DataObject   : find       : false
PDO_DataObject   : PDO       : Checking for database specific ini ('inserttest') : config[databases][inserttest] in options
PDO_DataObject   : databaseStructure       : CALL:[]
PDO_DataObject   : query       : 004af7f304aea7717b306884cddc605d : SELECT *
 FROM   Events 

PDO_DataObject   : query       : NO# of results: Unknown
PDO_DataObject   : find       : CHECK autofetched false
PDO_DataObject   : find       : DONE
PDO_DataObject   : fetch       : {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null,"dupe_id":"0"}
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