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

PDO_DataObject::debugLevel(0);
 
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
 

echo "\n\n--------\n";
echo "Testing cast;\n" ;



print_r(
PDO_DataObject::factory('Dummy')
    ->set([
        'ex_blob' => PDO_DataObject::sqlValue('blob','a long piece of data'),
        'ex_string' => PDO_DataObject::sqlValue('string', 123123),
        'ex_sql' => PDO_DataObject::sqlValue('sql', 'NOW()'),
        'ex_date' => PDO_DataObject::sqlValue('date', '2000-01-01'),
        'ex_datetime' => PDO_DataObject::sqlValue('dateTime', '2000-01-01 10:00:00'),
        'ex_time' => PDO_DataObject::sqlValue('time', '10:00:00'),
        'ex_null_string' => PDO_DataObject::sqlValue('null'),
        'ex_null_int' => PDO_DataObject::sqlValue('null'),
    ])
    ->save()
    ->reload()
    ->toArray()
);


PDO_DataObject::factory('Dummy')
    ->load(123)
    ->set([
        'ex_null_string' => PDO_DataObject::sqlValue('null'),
        'ex_null_int' => PDO_DataObject::sqlValue('null'),
    ])
    ->save();
    
echo "\n\n--------\n";
echo "Testing update with 'null' and null (with set) ;\n" ;
// this works, as set has 'null' support?!?
PDO_DataObject::factory('Dummy')
    ->load(123)
    ->set([
        'ex_null_string' => 'null',
        'ex_null_int' => null,
    ])
    ->save();

echo "\n\n--------\n";
echo "Testing update with 'null' and null (with properties) - ignore the raw null..;\n" ;
 
// this ingores the null_int
$d = PDO_DataObject::factory('Dummy')
    ->load(123);
$d->ex_null_string = 'null';
$d->ex_null_int = null;
$d->save();
    



echo "\n\n--------\n";
echo "Testing insert null testing;\n" ;
try {
$d = PDO_DataObject::factory('Dummy');
$d->ex_string = PDO_DataObject::sqlValue('null');
$d->insert();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "\ngot exception as expected : {$e->getMessage()}\n";
    
}


echo "\n\n--------\n";
echo "Testing string null = inserts a string..;\n" ;

PDO_DataObject::factory('Dummy')
    ->set([
        'ex_null_string' => 'null',
    ])
    ->save();


 

echo "\n\n--------\n";
PDO_DataObject::config('enable_null_strings', true);
echo "SET enable_null_strings= TRUE\n" ;
echo "\n\n--------\n";
echo "Testing null (string null);\n" ;



PDO_DataObject::factory('Dummy')
    ->set([
        'ex_null_string' => 'null',
    ])
    ->save();

echo "\n\n--------\n";
echo "Testing null string where non-null column;\n" ;
try {
$d = PDO_DataObject::factory('Dummy');
$d->ex_string = 'null';
$d->save();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "\ngot exception as expected : {$e->getMessage()}\n";
    
}

echo "\n\n--------\n";
echo "Testing update with 'null' and null (with set) - both should be null;\n" ;

// this works, as set has 'null' support?!?
PDO_DataObject::factory('Dummy')
    ->load(123)
    ->set([
        'ex_null_string' => 'null',
        'ex_null_int' => null,
    ])
    ->save();

echo "\n\n--------\n";
echo "Testing update with 'null' and null (with properties) - expect string null to work..;\n" ; 
// this ingores the null_int
$d = PDO_DataObject::factory('Dummy')
    ->load(123);
$d->ex_null_string = 'null';
$d->ex_null_int = null;
$d->save();
    





// FULL!!!


echo "\n\n--------\n";
PDO_DataObject::config('enable_null_strings', 'full');
echo "SET enable_null_strings= FULL\n" ;
echo "\n\n--------\n";
echo "Testing null (string null);\n" ;

// basically all the properties are null at this point.....

try {
PDO_DataObject::factory('Dummy')
    ->set([        
        'ex_string' => 'a test'
    ])
    ->save();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    
    echo "\ngot exception as expected : {$e->getMessage()}\n";
    
}

// we have to set everything
PDO_DataObject::factory('Dummy')
    ->set([
        'ex_int' => 1,
        'ex_str_bool' => 't',
        'ex_blob' => PDO_DataObject::sqlValue('blob','a long piece of data'),
        'ex_string' => PDO_DataObject::sqlValue('string', 123123),
        'ex_sql' => PDO_DataObject::sqlValue('sql', 'NOW()'),
        'ex_date' => PDO_DataObject::sqlValue('date', '2000-01-01'),
        'ex_datetime' => PDO_DataObject::sqlValue('dateTime', '2000-01-01 10:00:00'),
        'ex_time' => PDO_DataObject::sqlValue('time', '10:00:00'),
        'ex_null_string' => 'null',
        'ex_null_int' => null
    ])
    ->save();



echo "\n\n--------\n";
echo "Testing update with 'null' and null (with set) - both should be null;\n" ;

// this works, as set has 'null' support?!?
PDO_DataObject::factory('Dummy')
    ->load(123)
    ->set([
        'ex_null_string' => 'null',
        'ex_null_int' => null,
    ])
    ->save();
 
echo "\n\n--------\n";
echo "Testing update with 'null' and null (with properties) -   result = both of them will get set to nul..;\n" ;

// this ingores the null_int
$d = PDO_DataObject::factory('Dummy')
    ->load(123);
$d->ex_null_string = 'null';
$d->ex_null_int = null;
$d->save();
    


?>
--EXPECT--
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]


--------
basic load/set/save;
QUERY:183b4035a4a59e23b849e6bdd8a53fdb:
SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3523) ) 

Fetch Row 0 / 1
QUERY:9da43100ad8e2d1eee0cfee396c16588:
UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3523) 


--------
using where to filter.. find/set/save;
QUERY:30e4e6e9c534f092302558ec8faa1c11:
SELECT *
 FROM   Events   
 WHERE ( ( id > 3600 ) ) 
 LIMIT  1
Fetch Row 0 / 1
QUERY:35026f20209f1caa71d6443d725b9aa2:
UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3601) 


--------
using where set filter.. find/set/save;
QUERY:abbcef562aa23b791bed62846d4ca33f:
SELECT *
 FROM   Events   
 WHERE ( (Events.action  = 'RELOAD') ) 
 LIMIT  1
Fetch Row 0 / 1
QUERY:0115ca6837334e416b34e84c0b4f31a7:
UPDATE  Events  SET action = 'testing'  WHERE (Events.id = 3524) 


--------
Testing errors in load;
QUERY:2bdf264b81e628acfbf68368a1175be6:
SELECT *
 FROM   Events   
 WHERE ( (Events.id = 12) ) 

Load fail - Error thrown as expected: No Data returned from load
Load fail - Error thrown as expected: No condition (property or where) set for loading data.
QUERY:65e45926e39a354d24d0cefa47038dd8:
SELECT *
 FROM   Events   
 WHERE ( ( id > 100 ) ) 
 LIMIT  10
Fetch Row 0 / 2
Load fail - Error thrown as expected: Too many rows returned from load


--------
Testing insert save (copying an object);
QUERY:9d10a45b72cac1e6e75db3e71e077d7c:
SELECT *
 FROM   Events   
 WHERE ( (Events.id = 3526) ) 

Fetch Row 0 / 1
QUERY:86f9b0a9131676c87d66a0cb0264b879:
INSERT INTO Events (person_name , event_when , action , ipaddr , on_id , on_table , person_id , remarks ) VALUES ('Alan' , '2009-04-16 14:08:40' , 'RELOAD' , '202.134.82.251' ,  0 , '' ,  4 , '0' ) 
lastInsertId from sequence=''  is 1


--------
Testing cast;
string(3) "140"
QUERY:108a355193fb27d09332bc366bb171bd:
INSERT INTO Dummy (ex_blob , ex_string , ex_date , ex_datetime , ex_time , ex_sql , ex_null_string , ex_null_int ) VALUES ('a long piece of data', '123123', '2000-01-01', '2000-01-01 10:00:00', '10:00:00', NOW(), NULL, NULL) 
lastInsertId from sequence=''  is 134
QUERY:6788f6fdaf20faf6090c919d156389ba:
SELECT *
 FROM   Dummy   
 WHERE ( (Dummy.id = 134) ) 

Fetch Row 0 / 1
Array
(
    [id] => 134
    [ex_blob] => a long piece of data
    [ex_string] => 123123
    [ex_date] => 2000-01-01
    [ex_datetime] => 2000-01-01 10:00:00
    [ex_time] => 10:00:00
    [ex_sql] => 2000-01-01 10:00:00
    [ex_null_string] => 
    [ex_null_int] => 
    [ex_int] => 
    [ex_str_bool] => 
)
QUERY:1652d7b57c57078e2a9b3b09d3dca169:
SELECT *
 FROM   Dummy   
 WHERE ( (Dummy.id = 123) ) 

Fetch Row 0 / 1
QUERY:c8d6d4b551d4b67722aca033ffbb0565:
UPDATE  Dummy  SET ex_null_string = NULL , ex_null_int = NULL  WHERE (Dummy.id = 123) 


--------
Testing update with 'null' and null (with set) ;
QUERY:1652d7b57c57078e2a9b3b09d3dca169:
SELECT *
 FROM   Dummy   
 WHERE ( (Dummy.id = 123) ) 

Fetch Row 0 / 1
QUERY:6b645525eb7211f33f4fc3b5b6dc5662:
UPDATE  Dummy  SET ex_null_string = 'null' , ex_null_int = NULL  WHERE (Dummy.id = 123) 


--------
Testing update with 'null' and null (with properties) - ignore the raw null..;
QUERY:1652d7b57c57078e2a9b3b09d3dca169:
SELECT *
 FROM   Dummy   
 WHERE ( (Dummy.id = 123) ) 

Fetch Row 0 / 1
QUERY:c98633c24f80f97ffcf852d6a685573a:
UPDATE  Dummy  SET ex_null_string = 'null'  WHERE (Dummy.id = 123) 


--------
Testing insert null testing;

got exception as expected : Trying to set ex_string to null however it's set as NOT NULL


--------
Testing string null = inserts a string..;
QUERY:dc4ce49311092488f2b6ef4f8c69de95:
INSERT INTO Dummy (ex_null_string ) VALUES ('null' ) 
lastInsertId from sequence=''  is 3434


--------
SET enable_null_strings= TRUE


--------
Testing null (string null);
QUERY:3b7ff9bae558b4da7dd1c66bba394523:
INSERT INTO Dummy (ex_null_string ) VALUES (NULL) 
lastInsertId from sequence=''  is 101


--------
Testing null string where non-null column;

got exception as expected : Trying to set ex_string to null however it's set as NOT NULL


--------
Testing update with 'null' and null (with set) - both should be null;
QUERY:1652d7b57c57078e2a9b3b09d3dca169:
SELECT *
 FROM   Dummy   
 WHERE ( (Dummy.id = 123) ) 

Fetch Row 0 / 1
QUERY:c8d6d4b551d4b67722aca033ffbb0565:
UPDATE  Dummy  SET ex_null_string = NULL , ex_null_int = NULL  WHERE (Dummy.id = 123) 


--------
Testing update with 'null' and null (with properties) - expect string null to work..;
QUERY:1652d7b57c57078e2a9b3b09d3dca169:
SELECT *
 FROM   Dummy   
 WHERE ( (Dummy.id = 123) ) 

Fetch Row 0 / 1
QUERY:51f07942c9284421cf98a6ba687c0b06:
UPDATE  Dummy  SET ex_null_string = NULL  WHERE (Dummy.id = 123) 


--------
SET enable_null_strings= FULL


--------
Testing null (string null);

got exception as expected : Trying to set ex_blob to null however it's set as NOT NULL
string(3) "140"
QUERY:95c0c9fb39ff2e1f982dd42609cc40c4:
INSERT INTO Dummy (ex_blob , ex_int , ex_string , ex_date , ex_datetime , ex_time , ex_sql , ex_null_string , ex_null_int , ex_str_bool ) VALUES ('a long piece of data',  1 , '123123', '2000-01-01', '2000-01-01 10:00:00', '10:00:00', NOW(), NULL, NULL, '1' ) 
lastInsertId from sequence=''  is 12


--------
Testing update with 'null' and null (with set) - both should be null;
QUERY:1652d7b57c57078e2a9b3b09d3dca169:
SELECT *
 FROM   Dummy   
 WHERE ( (Dummy.id = 123) ) 

Fetch Row 0 / 1
QUERY:c8d6d4b551d4b67722aca033ffbb0565:
UPDATE  Dummy  SET ex_null_string = NULL , ex_null_int = NULL  WHERE (Dummy.id = 123) 


--------
Testing update with 'null' and null (with properties) -   result = both of them will get set to nul..;
QUERY:1652d7b57c57078e2a9b3b09d3dca169:
SELECT *
 FROM   Dummy   
 WHERE ( (Dummy.id = 123) ) 

Fetch Row 0 / 1
QUERY:c8d6d4b551d4b67722aca033ffbb0565:
UPDATE  Dummy  SET ex_null_string = NULL , ex_null_int = NULL  WHERE (Dummy.id = 123)