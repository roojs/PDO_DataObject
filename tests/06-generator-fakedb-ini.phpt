--TEST--
Generator - INI file
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
$base_config = PDO_DataObject::config();

 

// test structure from introspection
 


PDO_DataObject::config(
    array(
        'schema_location' => false,
        'PDO' => 'PDO_Dummy',
        'proxy' => true,
       'database' => '',
        'databases' => array(
            'mysql_anotherdb' => 'mysql://root:@localhost:3344/anotherdb'
        ),
    )
);

$gen = (new PDO_DataObject('mysql_anotherdb/Events'))->generator();
$gen->readTableList();
echo $gen->toINI(); 
echo $gen->toPhp('Companies');
 








?>
--EXPECT--
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","root","",[]]
setAttribute==[3,2]
QUERY:9c36cac1372650b703400c60dd29042c:
SHOW TABLES
QUERY:e7e98b166e84d8a86f012e03789dc226:

                        
                        SELECT
                            COLUMNS.TABLE_NAME as tablename,
                            COLUMNS.COLUMN_NAME as name,
                            COLUMN_DEFAULT as default_value_raw,
                            DATA_TYPE as type,
                            COALESCE(NUMERIC_PRECISION,CHARACTER_MAXIMUM_LENGTH) as len,
                            CONCAT(
                                EXTRA,  -- autoincrement...
                                IF (IS_NULLABLE, '', ' not_null'),
                                IF (COLUMN_KEY = 'PRI', ' primary', ''),
                                IF (COLUMN_KEY = 'UNI', ' unique', ''),
                                IF (COLUMN_KEY = 'MUL', ' multiple_key', '')
                                
                            )    as flags,
                            COALESCE(REFERENCED_TABLE_NAME,'') as fk_table,
                            COALESCE(REFERENCED_COLUMN_NAME,'') as fk_column,
                             12 as _prevent_cache
                            
                        FROM
                            INFORMATION_SCHEMA.COLUMNS
                        LEFT JOIN
                            INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                        ON
                            KEY_COLUMN_USAGE.TABLE_NAME = COLUMNS.TABLE_NAME 
                            AND
                            KEY_COLUMN_USAGE.COLUMN_NAME = COLUMNS.COLUMN_NAME
                            AND
                            KEY_COLUMN_USAGE.TABLE_SCHEMA = COLUMNS.TABLE_SCHEMA 
                        WHERE
                            COLUMNS.TABLE_SCHEMA = DATABASE()
                
QUERY:9c36cac1372650b703400c60dd29042c:
SHOW TABLES
[Companies]
id = 129
code = 130
name = 130
remarks = 162
owner_id = 129
address = 162
tel = 130
fax = 130
email = 130
isOwner = 129
logo_id = 129
background_color = 130
comptype = 130
url = 130
main_office_id = 129
created_by = 129
created_dt = 142
updated_by = 129
updated_dt = 142
passwd = 130
dispatch_port = 130
province = 130
country = 130

[Companies__keys]
id = N

[Events]
id = 129
person_name = 130
event_when = 142
action = 130
ipaddr = 130
on_id = 129
on_table = 130
person_id = 129
person_table = 130
remarks = 162

[Events__keys]
id = N

[Groups]
id = 129
name = 130
type = 129
leader = 129

[Groups__keys]
id = N

<?php
/**
 * Table Definition for Companies
 */
class_exists('PDO_DataObject') ? '' : require_once 'PDO/DataObject.php';

class DataObjects_Companies extends PDO_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag if you want to regenerate it */

    public $__table = 'Companies';           // table name
    public $id;                             // INT auto_increment not_null primary
    public $code;                           // VARCHAR not_null
    public $name;                           // VARCHAR not_null multiple_key
    public $remarks;                        // TEXT not_null
    public $owner_id;                       // INT not_null
    public $address;                        // TEXT not_null
    public $tel;                            // VARCHAR not_null
    public $fax;                            // VARCHAR not_null
    public $email;                          // VARCHAR not_null
    public $isOwner;                        // INT not_null
    public $logo_id;                        // INT not_null
    public $background_color;               // VARCHAR not_null
    public $comptype;                       // VARCHAR not_null
    public $url;                            // VARCHAR not_null
    public $main_office_id;                 // INT not_null
    public $created_by;                     // INT not_null
    public $created_dt;                     // DATETIME not_null
    public $updated_by;                     // INT not_null
    public $updated_dt;                     // DATETIME not_null
    public $passwd;                         // VARCHAR not_null
    public $dispatch_port;                  // VARCHAR not_null
    public $province;                       // VARCHAR not_null
    public $country;                        // VARCHAR not_null

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}