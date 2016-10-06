--TEST--
config - schema_location Test  
--FILE--
<?php
require_once 'includes/init.php';


 
PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        
        'class_prefix' => 'DataObjects_',
        
        'database' => '',
        'databases' => array(
            'mysql_anotherdb' =>  'mysql://username:test@localhost:3344/somedb#',
            'inserttest' => 'mysql://user:pass@localhost/inserttest',
        ),
        
          
     
));

PDO_DataObject::debugLevel(1);
 

echo "\n\n--------\n";
echo "listed with seperators\n" ;
PDO_DataObject::config(array(
    'schema_location' => __DIR__.'/includes' . PATH_SEPARATOR . __DIR__.'/includes/test_ini'
));


PDO_DataObject::factory('Events')
        ->limit(1)
        ->find(true);
        
print_r(PDO_DataObject::factory('Events')->tableColumns());

PDO_DataObject::factory('account_transaction')
        ->limit(1)
        ->find();
        
print_r(PDO_DataObject::factory('account_transaction')->tableColumns());

PDO_DataObject::reset();
echo "\n\n--------\n";
echo "listed associative array\n" ;

PDO_DataObject::config(array(
    'schema_location' => array(
        'inserttest' =>    __DIR__.'/includes' ,
        'mysql_anotherdb' =>   PATH_SEPARATOR . __DIR__.'/includes/test_ini'
    )
));



PDO_DataObject::factory('Events')
        ->limit(1)
        ->find(true);
        
print_r(PDO_DataObject::factory('Events')->tableColumns());

PDO_DataObject::factory('account_transaction')
        ->limit(1)
        ->find();
        
print_r(PDO_DataObject::factory('account_transaction')->tableColumns());


PDO_DataObject::reset();
echo "\n\n--------\n";
echo "listed associative array with absolute path. \n" ;

// we could test array's here...
PDO_DataObject::config(array(
    'schema_location' => array(
        'inserttest' =>    __DIR__.'/includes/mysql_somedb.ini' ,
        'mysql_anotherdb' =>   __DIR__.'/includes/test_ini/mysql_anotherdb.ini'
    )
));



PDO_DataObject::factory('account_code')
        ->limit(1)
        ->find(true);
        
print_r(PDO_DataObject::factory('account_code')->tableColumns());

PDO_DataObject::factory('account_transaction')
        ->limit(1)
        ->find();
        
print_r(PDO_DataObject::factory('account_transaction')->tableColumns());



PDO_DataObject::reset();
echo "\n\n--------\n";
echo "only list one schema location....\n" ;

// we could test array's here...
PDO_DataObject::config(array(
    'schema_location' => array(
        'inserttest' =>    array(__DIR__.'/includes/mysql_somedb.ini' , __DIR__.'/includes/test_ini/mysql_anotherdb.ini')
    ),
    // we need to change this, as it hunt's the databases for schema's...
    'databases' => array(
          'inserttest' => 'mysql://user:pass@localhost/inserttest',
    ),
));



PDO_DataObject::factory('account_code')
        ->limit(1)
        ->find(true);
        
print_r(PDO_DataObject::factory('account_code')->tableColumns());

PDO_DataObject::factory('account_transaction')
        ->limit(1)
        ->find();
        
print_r(PDO_DataObject::factory('account_transaction')->tableColumns());




?>
--EXPECT--
--------
Test Mysql 


--------
listed with seperators
PDO_DataObject   : find       : true
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
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
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
PDO_DataObject   : databaseStructure       : CALL:["inserttest"]
Array
(
    [id] => 129
    [person_name] => 130
    [event_when] => 142
    [action] => 130
    [ipaddr] => 130
    [on_id] => 129
    [on_table] => 130
    [person_id] => 129
    [person_table] => 130
    [remarks] => 162
)
PDO_DataObject   : find       : false
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : query       : 49a4307336aeaeb2e24de305a3d0da30 : SELECT *
 FROM   account_transaction 
 LIMIT  1
QUERY:49a4307336aeaeb2e24de305a3d0da30:
SELECT *
 FROM   account_transaction 
 LIMIT  1
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched false
PDO_DataObject   : 1       : FIND: nothing found - reseting query and result)?
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
Array
(
    [id] => 129
    [member] => 1
    [at_date] => 6
    [voucher_number] => 2
    [chit_number] => 2
    [cheque_number] => 2
    [reverse_id] => 1
    [account_code] => 1
    [value] => 1
    [description_old] => 2
    [sequence_no] => 1
    [ts] => 2
    [description] => 2
)


--------
listed associative array
PDO_DataObject   : find       : true
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
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
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
PDO_DataObject   : databaseStructure       : CALL:["inserttest"]
Array
(
    [id] => 129
    [person_name] => 130
    [event_when] => 142
    [action] => 130
    [ipaddr] => 130
    [on_id] => 129
    [on_table] => 130
    [person_id] => 129
    [person_table] => 130
    [remarks] => 162
)
PDO_DataObject   : find       : false
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : query       : 49a4307336aeaeb2e24de305a3d0da30 : SELECT *
 FROM   account_transaction 
 LIMIT  1
QUERY:49a4307336aeaeb2e24de305a3d0da30:
SELECT *
 FROM   account_transaction 
 LIMIT  1
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched false
PDO_DataObject   : 1       : FIND: nothing found - reseting query and result)?
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
Array
(
    [id] => 129
    [member] => 1
    [at_date] => 6
    [voucher_number] => 2
    [chit_number] => 2
    [cheque_number] => 2
    [reverse_id] => 1
    [account_code] => 1
    [value] => 1
    [description_old] => 2
    [sequence_no] => 1
    [ts] => 2
    [description] => 2
)


--------
listed associative array with absolute path. 
PDO_DataObject   : find       : true
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
PDO_DataObject   : databaseStructure       : CALL:["inserttest"]
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
PDO_DataObject   : query       : f5a65e29f10636175726b93d83e99ad6 : SELECT *
 FROM   account_code 
 LIMIT  1
QUERY:f5a65e29f10636175726b93d83e99ad6:
SELECT *
 FROM   account_code 
 LIMIT  1
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : 1       : FIND: nothing found - reseting query and result)?
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
PDO_DataObject   : databaseStructure       : CALL:["inserttest"]
Array
(
    [id] => 129
    [name] => 2
    [description] => 2
    [cost_center] => 1
    [accpac] => 2
    [accpac_out] => 2
)
PDO_DataObject   : find       : false
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
PDO_DataObject   : query       : 49a4307336aeaeb2e24de305a3d0da30 : SELECT *
 FROM   account_transaction 
 LIMIT  1
QUERY:49a4307336aeaeb2e24de305a3d0da30:
SELECT *
 FROM   account_transaction 
 LIMIT  1
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched false
PDO_DataObject   : 1       : FIND: nothing found - reseting query and result)?
PDO_DataObject   : databaseStructure       : CALL:["mysql_anotherdb"]
Array
(
    [id] => 129
    [member] => 1
    [at_date] => 6
    [voucher_number] => 2
    [chit_number] => 2
    [cheque_number] => 2
    [reverse_id] => 1
    [account_code] => 1
    [value] => 1
    [description_old] => 2
    [sequence_no] => 1
    [ts] => 2
    [description] => 2
)


--------
only list one schema location....
PDO_DataObject   : find       : true
PDO_DataObject   : databaseStructure       : CALL:["inserttest"]
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
PDO_DataObject   : query       : f5a65e29f10636175726b93d83e99ad6 : SELECT *
 FROM   account_code 
 LIMIT  1
QUERY:f5a65e29f10636175726b93d83e99ad6:
SELECT *
 FROM   account_code 
 LIMIT  1
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched true
PDO_DataObject   : 1       : FIND: nothing found - reseting query and result)?
PDO_DataObject   : databaseStructure       : CALL:["inserttest"]
Array
(
    [id] => 129
    [name] => 2
    [description] => 2
    [cost_center] => 1
    [accpac] => 2
    [accpac_out] => 2
)
PDO_DataObject   : find       : false
PDO_DataObject   : databaseStructure       : CALL:["inserttest"]
PDO_DataObject   : query       : 49a4307336aeaeb2e24de305a3d0da30 : SELECT *
 FROM   account_transaction 
 LIMIT  1
QUERY:49a4307336aeaeb2e24de305a3d0da30:
SELECT *
 FROM   account_transaction 
 LIMIT  1
PDO_DataObject   : query       : NO# of results: 0
PDO_DataObject   : find       : CHECK autofetched false
PDO_DataObject   : 1       : FIND: nothing found - reseting query and result)?
PDO_DataObject   : databaseStructure       : CALL:["inserttest"]
Array
(
    [id] => 129
    [member] => 1
    [at_date] => 6
    [voucher_number] => 2
    [chit_number] => 2
    [cheque_number] => 2
    [reverse_id] => 1
    [account_code] => 1
    [value] => 1
    [description_old] => 2
    [sequence_no] => 1
    [ts] => 2
    [description] => 2
)