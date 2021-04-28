--TEST--
databaseStructure - error checking
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
$base_config = PDO_DataObject::config();



PDO_DataObject::config(
    array(
        'databases' => array(
            'mysql_somedb' => 'mysql://username:test@localhost:3344/somedb',
            'mysql_anotherdb' =>  'mysql://username:test@localhost:3344/anotherdb',
            
        ),
        'debug' => 0,
    )
);


// connect to a table that does not exist
try {
    $obj = new PDO_DataObject('mysql_somedb/do_not_exist');
} catch(Exception $e) {
   echo "no such table - Exception Thrown: ". $e->getMessage() ."\n";
}

echo "-- check invalid database --\n\n";

// reset the schema location.

$old = PDO_DataObject::config( 'schema_location' , '');
        

try {
    $obj = new PDO_DataObject('do_not_exist');
} catch(Exception $e) {
   echo "no such table - no schema -  Exception Thrown: ". $e->getMessage() ."\n";
}
PDO_DataObject::config( 'schema_location' , $old);
PDO_DataObject::reset();


echo "-- check invalid table on proxy --\n\n";

// ?? any other connection error conditions.?
// proxy on database that does not exist..
PDO_DataObject::config( 'proxy' , true);

try {
    $obj = new PDO_DataObject('mysql_somedb/do_not_exist');
} catch(Exception $e) {
   echo "proxy - no such table - Exception Thrown: ". $e->getMessage() ."\n";
}


try {
    $obj = new PDO_DataObject('do_not_exist/do_not_exist');
} catch(Exception $e) {
   echo "proxy - no such db -  Exception Thrown: ". $e->getMessage() ."\n";
}







?>
--EXPECT--
__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
setAttribute==[3,2]
no such table - Exception Thrown: Could not find INI values for database=mysql_somedb and table=do_not_exist
-- check invalid database --

__construct==["mysql:dbname=testdb;host=localhost","user","pass",[]]
no such table - no schema -  Exception Thrown: Fake connection failed to non-existant database
-- check invalid table on proxy --

__construct==["mysql:dbname=somedb;host=localhost;port=3344","username","test",[]]
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
                
proxy - no such table - Exception Thrown: Could not find INI values for database=mysql_somedb and table=do_not_exist
__construct==["mysql:dbname=testdb;host=localhost","user","pass",[]]
proxy - no such db -  Exception Thrown: Fake connection failed to non-existant database