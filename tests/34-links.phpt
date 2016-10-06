--TEST--
autoJOin and joinAll Test 
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
echo "\n---\nDefault Columns\n";
var_export(PDO_DataObject::factory('joinerb')
    ->links()
);
exit;
$a = PDO_DataObject::factory('joinerb');
$a->tableColumns(
    array (
     'id' => '129',
     'code' => '130',
     'name' => '130',
     'remarks' => '162',
     'owner_id' => '129',
     'address' => '162',
     'tel' => '130',
     'fax' => '130',
     'email' => '130',
     
   )
);
echo "\n---\n After setting this instance\n";
var_export($a->tableColumns());

echo "\n---\n new instance\n";
var_export(PDO_DataObject::factory('Companies')
    ->tableColumns()
);
 
?>
--EXPECT--
---
Default Columns
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
array (
  'id' => '129',
  'code' => '130',
  'name' => '130',
  'remarks' => '162',
  'owner_id' => '129',
  'address' => '162',
  'tel' => '130',
  'fax' => '130',
  'email' => '130',
  'isOwner' => '129',
  'logo_id' => '129',
  'background_color' => '130',
  'comptype' => '130',
  'url' => '130',
  'main_office_id' => '129',
  'created_by' => '129',
  'created_dt' => '142',
  'updated_by' => '129',
  'updated_dt' => '142',
  'passwd' => '130',
  'dispatch_port' => '130',
  'province' => '130',
  'country' => '130',
)
---
 After setting this instance
array (
  'id' => '129',
  'code' => '130',
  'name' => '130',
  'remarks' => '162',
  'owner_id' => '129',
  'address' => '162',
  'tel' => '130',
  'fax' => '130',
  'email' => '130',
)
---
 new instance
array (
  'id' => '129',
  'code' => '130',
  'name' => '130',
  'remarks' => '162',
  'owner_id' => '129',
  'address' => '162',
  'tel' => '130',
  'fax' => '130',
  'email' => '130',
  'isOwner' => '129',
  'logo_id' => '129',
  'background_color' => '130',
  'comptype' => '130',
  'url' => '130',
  'main_office_id' => '129',
  'created_by' => '129',
  'created_dt' => '142',
  'updated_by' => '129',
  'updated_dt' => '142',
  'passwd' => '130',
  'dispatch_port' => '130',
  'province' => '130',
  'country' => '130',
)
 