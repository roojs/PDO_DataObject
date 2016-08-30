--TEST--
Generator - compare to DB_DataObject - Postgres (real database) - will not normmally pass...
--FILE--
<?php
require_once 'includes/init.php';
 

// hard coded to my path....
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR .'/home/alan/gitlive/pear');
 
require_once 'DB/DataObject.php';
require_once 'DB/DataObject/Generator.php';

 
$dofn = tempnam (sys_get_temp_dir(), 'pdo-dbdo-tests-') . '-dir';
mkdir($dofn);
$opts = &PEAR::getStaticProperty('DB_DataObject','options');
$opts = array(
    'database' =>   'pgsql://admin:pass4xtuple@localhost/xtuplehk',
    'schema_location' => $dofn,
    'class_location' => $dofn,
    'generator_strip_schema' => true,
    'generator_include_regex' => '/^public\.*/',
    'generate_links' => true,
    
);

$generator = new DB_DataObject_Generator;
$generator->start();


 

// test structure from introspection
 
$fn = tempnam (sys_get_temp_dir(), 'pdo-pdodo-tests-') . '-dir';
mkdir($fn);


PDO_DataObject::config(
    array(
        'schema_location' => $fn,
        'class_location' => $fn,
        'PDO' => 'PDO',
        'databases' => array(
            'xtuple_db' => 'pgsql://admin:pass4xtuple@localhost/xtuplehk'
        ),
        
        'proxy' => true,
        'debug' => 0,
        'database' => '',
        'class_prefix' => '',
        
    )
);

$gen = (new PDO_DataObject('xtuple_db/accnt'))->generator();

PDO_DataObject_Generator::config(array(
            
            //'build_views' => true,
              
            'generate_links' => true,
            
            //'link_methods'  =>true,
                    
            'extends_class' => 'DB_DataObject',
                // what class do the generated classes extend?
            'extends_class_location' => 'DB/DataObject.php',
            
            


));
 

$gen->start();


echo `diff -w -u $dofn/xtuplehk.ini $fn/xtuple_db.ini | grep -v /tmp/pdo`;
echo `diff -w -u $dofn/xtuplehk.links.ini $fn/xtuple_db.links.ini | grep -v /tmp/pdo`;

//echo "\nmeld $dofn/xtuplehk.links.ini $fn/xtuple_db.links.ini\n";
//echo "\n$fn\n$dofn\n";exit;
// as they have different file names...
`rm $dofn/xtuplehk.ini $fn/xtuple_db.ini`;

//echo `diff -u -r $dofn $fn`;

`rm -rf $dofn $fn`;


// trust me... these diffs are huge, but the output is simlar enough...
// pdo_dataobject - actually fixes stuff.....
 
?>
--EXPECT--
@@ -1,4 +1,3 @@
-
 [acalitem]
 acalitem_id = 129
 acalitem_calhead_id = 1
@@ -380,8 +379,6 @@
 usr_shift_id = 1
 usr_window = 34
 
-[backup_usr__keys]
-
 [bankaccnt]
 bankaccnt_id = 129
 bankaccnt_name = 34
@@ -2344,8 +2341,6 @@
 flrpt_accnt_id = 1
 flrpt_interval = 2
 
-[flrpt__keys]
-
 [flspec]
 flspec_id = 129
 flspec_flhead_id = 129
@@ -3603,8 +3598,6 @@
 payco_amount = 129
 payco_curr_id = 1
 
-[payco__keys]
-
 [period]
 period_id = 129
 period_start = 6
@@ -4331,8 +4324,6 @@
 [sequence]
 sequence_value = 1
 
-[sequence__keys]
-
 [shift]
 shift_id = 129
 shift_number = 162
@@ -4908,8 +4899,6 @@
 trgthist_col = 162
 trgthist_value = 162
 
-[trgthist__keys]
-
 [trialbal]
 trialbal_id = 129
 trialbal_period_id = 1
@@ -5331,3 +5320,4 @@
 
 [yearperiod__keys]
 yearperiod_id = yearperiod_yearperiod_id_seq
+
@@ -62,6 +62,7 @@
 bomhead_item_id = item:item_id
 
 [bomitem]
+bomitem_char_id = char:char_id
 bomitem_item_id = item:item_id
 bomitem_parent_item_id = item:item_id
 bomitem_uom_id = uom:uom_id
@@ -70,6 +71,9 @@
 bomitemsub_bomitem_id = bomitem:bomitem_id
 bomitemsub_item_id = item:item_id
 
+[bomwork]
+bomwork_char_id = char:char_id
+
 [budgitem]
 budgitem_budghead_id = budghead:budghead_id
 budgitem_period_id = period:period_id
@@ -93,6 +97,9 @@
 [ccbank]
 ccbank_bankaccnt_id = bankaccnt:bankaccnt_id
 
+[charopt]
+charopt_char_id = char:char_id
+
 [checkhead]
 checkhead_bankaccnt_id = bankaccnt:bankaccnt_id
 checkhead_curr_id = curr_symbol:curr_id
@@ -377,6 +384,7 @@
 ipshead_curr_id = curr_symbol:curr_id
 
 [ipsitemchar]
+ipsitemchar_char_id = char:char_id
 ipsitemchar_ipsitem_id = ipsiteminfo:ipsitem_id
 
 [ipsiteminfo]