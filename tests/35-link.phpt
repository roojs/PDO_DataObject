--TEST--
link Test 
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest',
        'class_prefix' => 'DataObjects_',
));

PDO_DataObject::debugLevel(0);
 
// these need the links to calculate the join..
echo "\n---\nFetch a related link.n";
print_r(
    PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id')
        ->toArray()
);


echo "\n---\nFetch a related link using link info.n";
print_r(
    PDO_DataObject::factory('joiner')
        ->load(1)
        ->link(array('childb_id','childb:cb_id'))
        ->toArray()
);

  

echo "\n---\nUpdate by assigning child\n";
PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', PDO_DataObject::factory('childa')->load(3)  )
        ->save();

        
echo "\n---\nUpdate by assigning 5\n";
PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', 5)
        ->save();
 
echo "\n---\nUpdate by assigning 0\n";
PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', 0)
        ->save();

echo "\n---\nUpdate by assigning invalid value\n";
try{
PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', 99)
        ->save();
} catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "\nexception thrown as expected: {$e->getMessage()}\n";
}

echo "\n---\nUpdate by assigning array() - error condition\n";
try {
PDO_DataObject::factory('joinerb')
        ->load(1)
        ->link('childa_id', array())
        ->save();
 } catch (PDO_DataObject_Exception_InvalidArgs $e) {
    echo "\nexception thrown as expected: {$e->getMessage()}\n";
}
?>
--EXPECT--
---
Fetch a related link.n__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:7a50b46e8bf9c1c7ee5aa2e4193b2dcc:
SELECT *
 FROM   joinerb   
 WHERE ( (joinerb.id = 1) ) 

Fetch Row 0 / 1
QUERY:62a851a3ecaf722d3d2de3b49d639b99:
SELECT *
 FROM   childa   
 WHERE ( (childa.ca_id = 2) ) 

Fetch Row 0 / 1
Array
(
    [ca_id] => 2
    [name] => x
    [ex_int] => 2
    [ex_string] => test
    [ex_date] => 2001-01-01
    [ex_datetime] => 2002-02-02 12:12:12
    [ex_time] => 04:04:04
)

---
Fetch a related link using link info.nQUERY:e0d21de2663b8a6765bb6d5bf8d0e1f8:
SELECT *
 FROM   joiner   
 WHERE ( (joiner.id = 1) ) 

Fetch Row 0 / 1
QUERY:5bf162cc002da7e8fdc212453069c410:
SELECT *
 FROM   childb   
 WHERE ( (childb.cb_id = 3) ) 

Fetch Row 0 / 1
Array
(
    [cb_id] => 3
    [name] => yyy
    [ex_int] => 99
    [ex_string] => test
    [ex_date] => 2001-01-01
    [ex_datetime] => 2002-02-02 12:12:12
    [ex_time] => 04:04:04
)

---
Update by assigning child
QUERY:7a50b46e8bf9c1c7ee5aa2e4193b2dcc:
SELECT *
 FROM   joinerb   
 WHERE ( (joinerb.id = 1) ) 

Fetch Row 0 / 1
QUERY:0c192ff0f3a2aa7370db30026808f365:
SELECT *
 FROM   childa   
 WHERE ( (childa.ca_id = 3) ) 

Fetch Row 0 / 1
QUERY:b567807fd5e6679c97dae318060fdb4c:
UPDATE  joinerb  SET childa_id = 3  WHERE (joinerb.id = 1) 

---
Update by assigning 5
QUERY:7a50b46e8bf9c1c7ee5aa2e4193b2dcc:
SELECT *
 FROM   joinerb   
 WHERE ( (joinerb.id = 1) ) 

Fetch Row 0 / 1
QUERY:b21e50231b6df62832c6c0c76b807d03:
SELECT *
 FROM   childa   
 WHERE ( (childa.ca_id = 5) ) 

Fetch Row 0 / 1
QUERY:969e31a113b519f231a2fd01b811d14e:
UPDATE  joinerb  SET childa_id = 5  WHERE (joinerb.id = 1) 

---
Update by assigning 0
QUERY:7a50b46e8bf9c1c7ee5aa2e4193b2dcc:
SELECT *
 FROM   joinerb   
 WHERE ( (joinerb.id = 1) ) 

Fetch Row 0 / 1
QUERY:9d99040b862edc9987b3172f357b1346:
UPDATE  joinerb  SET childa_id = 0  WHERE (joinerb.id = 1) 

---
Update by assigning invalid value
QUERY:7a50b46e8bf9c1c7ee5aa2e4193b2dcc:
SELECT *
 FROM   joinerb   
 WHERE ( (joinerb.id = 1) ) 

Fetch Row 0 / 1
QUERY:40eb1d8f650d4ed98324e3914ef8d70d:
SELECT *
 FROM   childa   
 WHERE ( (childa.ca_id = 99) ) 


exception thrown as expected: Assigning foreign key value to point to a non existant element

---
Update by assigning array() - error condition
QUERY:7a50b46e8bf9c1c7ee5aa2e4193b2dcc:
SELECT *
 FROM   joinerb   
 WHERE ( (joinerb.id = 1) ) 

Fetch Row 0 / 1

exception thrown as expected: Assigning foreign key column to a non_numeric value
