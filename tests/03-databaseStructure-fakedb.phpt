--TEST--
databaseStructure
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
$base_config = PDO_DataObject::config();

 

// test structure from introspection

echo "\n\nDATABASE INSTROSPECT - mysql dummy\n";
(new PDO_DataObject())->reset();


PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO_Dummy',
        'proxy' => true,
        'tables' => array(
            'Events' => 'mysql_anotherdb',
        ),
        'databases' => array(
            'mysql_anotherdb' => 'mysql://root:@localhost:3344/anotherdb'
        ),
    )
);

$obj = new PDO_DataObject('mysql_anotherdb/Events');
print_r($obj->databaseStructure());



 
// postgresql
echo "\n\nDATABASE INSTROSPECT - postgres dummyu\n";
(new PDO_DataObject())->reset();

PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO_Dummy',
        'proxy' => true,
        'tables' => array(
            'accnt' => 'dummy_xtuple'
        ),
        'databases' => array(
            'dummy_xtuple' => 'pgsql://user:nopass@localhost/xtuple'
        ),
        'debug'=>0,
    )
);


$obj = new PDO_DataObject('accnt');
print_r($obj->databaseStructure());


// oracle
echo "\n\nDATABASE INSTROSPECT - oracle dummyu\n";
(new PDO_DataObject())->reset();

PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO_Dummy',
        'proxy' => true,
        'tables' => array(
            'accnt' => 'dummy_oci'
        ),
        'databases' => array(
            'dummy_oci' => 'oci://somedb'
        ),
         'debug'=>0,
    )
);


$obj = new PDO_DataObject('dummy_oci/Groups');
print_r($obj->databaseStructure());

  









?>
--EXPECT--
DATABASE INSTROSPECT - mysql dummy
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","root","",[]]
setAttribute==[3,2]
QUERY: 9c36cac1372650b703400c60dd29042c
QUERY: 6996acc544ef440ec8756b9a474a8261
QUERY: fbfdf155a2b80c37a9da0b57c7ec0c8a
QUERY: f77e1669034239c845220bf51ee0a9f2
Array
(
    [Companies] => Array
        (
            [id] => 129
            [code] => 130
            [name] => 130
            [remarks] => 162
            [owner_id] => 129
            [address] => 162
            [tel] => 130
            [fax] => 130
            [email] => 130
            [isOwner] => 129
            [logo_id] => 129
            [background_color] => 130
            [comptype] => 130
            [url] => 130
            [main_office_id] => 129
            [created_by] => 129
            [created_dt] => 142
            [updated_by] => 129
            [updated_dt] => 142
            [passwd] => 130
            [dispatch_port] => 130
            [province] => 130
            [country] => 130
        )

    [Companies__keys] => Array
        (
            [id] => N
        )

    [Events] => Array
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

    [Events__keys] => Array
        (
            [id] => N
        )

    [Groups] => Array
        (
            [id] => 129
            [name] => 130
            [type] => 129
            [leader] => 129
        )

    [Groups__keys] => Array
        (
            [id] => N
        )

)


DATABASE INSTROSPECT - postgres dummyu
__construct==["pgsql:dbname=xtuple;host=localhost","user","nopass",[]]
setAttribute==[3,2]
QUERY: 0d1e9dce4875a86e86bce4f186f64534
QUERY: e1cbe336d18feb312b6ec9685b9f64b2
QUERY: eb30dc0b1b7c48a6974d9399257e82ff
QUERY: f08fe09be9698b4d9a44cf6e90250153
QUERY: 4e13cce432f03f6cb6b4b66b56d60b43
Array
(
    [acalitem] => Array
        (
            [acalitem_id] => 129
            [acalitem_calhead_id] => 1
            [acalitem_periodstart] => 6
            [acalitem_periodlength] => 1
            [acalitem_name] => 34
        )

    [acalitem__keys] => Array
        (
            [acalitem_id] => xcalitem_xcalitem_id_seq
        )

    [accnt] => Array
        (
            [accnt_id] => 129
            [accnt_number] => 34
            [accnt_descrip] => 34
            [accnt_comments] => 34
            [accnt_profit] => 34
            [accnt_sub] => 34
            [accnt_type] => 130
            [accnt_extref] => 34
            [accnt_company] => 34
            [accnt_closedpost] => 18
            [accnt_forwardupdate] => 18
            [accnt_subaccnttype_code] => 34
            [accnt_curr_id] => 1
            [accnt_active] => 146
            [accnt_name] => 34
            [accnt_code_alt] => 34
            [accnt_descrip_alt] => 34
        )

    [accnt__keys] => Array
        (
            [accnt_id] => accnt_accnt_id_seq
        )

    [addr] => Array
        (
            [addr_id] => 129
            [addr_active] => 18
            [addr_line1] => 34
            [addr_line2] => 34
            [addr_line3] => 34
            [addr_city] => 34
            [addr_state] => 34
            [addr_postalcode] => 34
            [addr_country] => 34
            [addr_notes] => 34
            [addr_number] => 162
        )

    [addr__keys] => Array
        (
            [addr_id] => addr_addr_id_seq
        )

)


DATABASE INSTROSPECT - oracle dummyu
__construct==["oci:dbname=somedb","","",[]]
setAttribute==[3,2]
QUERY: 7e4bbcd04982917de4c1fb94ff94e608
QUERY: d632f626d40c91f7f96d697e86122c38
Array
(
    [Groups] => Array
        (
            [id] => 129
            [name] => 2
            [type] => 1
        )

)