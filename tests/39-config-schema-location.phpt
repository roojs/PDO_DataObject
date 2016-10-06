--TEST--
config - schema_location Test  
--FILE--
<?php
require_once 'includes/init.php';


echo "\n\n--------\n";
echo "Test Mysql \n" ;



PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        
        'class_prefix' => 'DataObjects_',
        
        'database' => '',
        'databases' => array(
            'mysql_somedb' =>  'mysql://username:test@localhost:3344/somedb#',
            'inserttest' => 'mysql://user:pass@localhost/inserttest',
        ),
        
          
     
));

PDO_DataObject::debugLevel(1);
 

echo "\n\n--------\n";
echo "listed with seperators\n" ;
PDO_DataObject::config(array(
    'schema_location' => __DIR__.'/includes' . PATH_SEPARATOR . __DIR__.'/includes/test_ini' 


PDO_DataObject::factory('Events')
        ->limit(1)
        ->find(true);


PDO_DataObject::factory('account_code')
        ->limit(1)
        ->find();



?>
--EXPECT--
--------
Test Mysql 


--------
basic load a big result set
PDO_DataObject   : find       : true
PDO_DataObject   : databaseStructure       : CALL:["mysql_somedb"]
PDO_DataObject   : databaseStructure       : CALL:["inserttest"]
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
PDO_DataObject   : query       : 196f2986575f749efe84e6134d37fbf7 : SELECT *
 FROM   Events 
 LIMIT  1
QUERY:196f2986575f749efe84e6134d37fbf7:
SELECT *
 FROM   Events 
 LIMIT  1
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : 1       : FIND: nothing found - reseting query and result)?
PDO_DataObject   : find       : false
PDO_DataObject   : databaseStructure       : CALL:["mysql_somedb"]
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : query       : f5a65e29f10636175726b93d83e99ad6 : SELECT *
 FROM   account_code 
 LIMIT  1
QUERY:f5a65e29f10636175726b93d83e99ad6:
SELECT *
 FROM   account_code 
 LIMIT  1
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched false
PDO_DataObject   : 1       : FIND: nothing found - reseting query and result)?
