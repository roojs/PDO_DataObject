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
QUERY:0d1e9dce4875a86e86bce4f186f64534:
SELECT schemaname || '.' || tablename AS "Name" FROM pg_catalog.pg_tables WHERE schemaname NOT IN ('pg_catalog', 'information_schema', 'pg_toast')
QUERY:e1cbe336d18feb312b6ec9685b9f64b2:
SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'public' order by table_name ASC
QUERY:eb30dc0b1b7c48a6974d9399257e82ff:

                    SELECT
                        DISTINCT(pg_attribute.attname) AS name, 
                        pg_class.relname AS tablename, 
                        
                        
                        (SELECT pg_attrdef.adsrc FROM pg_attrdef 
                            WHERE pg_attrdef.adrelid = pg_class.oid 
                            AND pg_attrdef.adnum = pg_attribute.attnum)
                        AS default_value_raw,
                        
                        format_type(pg_attribute.atttypid, NULL) AS type,  
                        
                        CASE pg_attribute.atttypid
                            WHEN 1042 THEN (pg_attribute.atttypmod - 4) -- character?
                            WHEN 21 /*int2*/ THEN 16
                            WHEN 23 /*int4*/ THEN 32
                            WHEN 20 /*int8*/ THEN 64
                            WHEN 1700 /*numeric*/ THEN
                                 CASE WHEN pg_attribute.atttypmod = -1
                                      THEN null
                                      ELSE ((pg_attribute.atttypmod - 4) >> 16) & 65535     -- calculate the precision
                                      END
                            WHEN 700 /*float4*/ THEN 24 /*FLT_MANT_DIG*/
                            WHEN 701 /*float8*/ THEN 53 /*DBL_MANT_DIG*/
                            ELSE null
                        END  ::text || 
                        CASE 
                            WHEN pg_attribute.atttypid IN (21, 23, 20) THEN ''
                            WHEN pg_attribute.atttypid IN (1700) THEN            
                                CASE 
                                    WHEN pg_attribute.atttypmod = -1 THEN ''
                                    ELSE ',' || ((pg_attribute.atttypmod - 4) & 65535)::text            -- calculate the scale  
                            END
                           ELSE ''
                        END AS len,

                       CONCAT(
                                        
                            CASE pg_attribute.attnotnull 
                                WHEN true THEN ' not_null'  ELSE ''
                            END, 
                            CASE WHEN pg_constraint.conname is NULL THEN '' 
                                ELSE ' primary' END,
                                CASE WHEN pc3.conname is NULL THEN '' 
                                ELSE ' unique' END,
                             CASE WHEN pg_class.relkind = 'v' THEN ' is_view ' 
                                ELSE '' END   
                        )    as flags,
                     
                     
                                
                         
                        fk_table_class.relname as fk_table,
                        fk_table_cols.attname as fk_column ,
                        pg_attribute.attnum
 
                    FROM
                        pg_class 
                    JOIN
                        pg_attribute
                    ON
                        pg_class.oid = pg_attribute.attrelid 
                        AND
                        pg_attribute.attnum > 0 
                    LEFT JOIN
                        pg_constraint
                    ON
                        pg_constraint.contype = 'p'::char
                        AND
                        pg_constraint.conrelid = pg_class.oid
                        AND
                        (pg_attribute.attnum = ANY (pg_constraint.conkey)) 
        
                    LEFT JOIN  -- foreign_key
                        pg_constraint AS pc2
                    ON
                        pc2.contype = 'f'::char
                        AND
                        pc2.conrelid = pg_class.oid 
                        AND
                        (pg_attribute.attnum = ANY (pc2.conkey)) 
                    LEFT JOIN
                        pg_class as fk_table_class
                    ON
                        fk_table_class.oid = pc2.confrelid
                    LEFT JOIN
                        pg_attribute as fk_table_cols
                    ON
                       fk_table_cols.attrelid = pc2.confrelid
                       AND
                       fk_table_cols.attnum = ANY (pc2.confkey)
                       
                    LEFT JOIN -- unique
                        pg_constraint AS pc3
                    ON
                        pc3.contype = 'u'::char
                        AND
                        pc3.conrelid = pg_class.oid 
                        AND
                        (pg_attribute.attnum = ANY (pc3.conkey)) 
                       
                    LEFT JOIN
                        pg_namespace
                    ON
                        pg_namespace.oid = pg_class.relnamespace  
                    WHERE
                        
                        pg_attribute.atttypid <> 0::oid  
                        AND
                        pg_class.relname='acalitem'
                        AND 
                        pg_namespace.nspname = 'public'


                    ORDER BY
                        pg_attribute.attnum ASC 
        
            
QUERY:f08fe09be9698b4d9a44cf6e90250153: [Query hidden from tests]
QUERY:4e13cce432f03f6cb6b4b66b56d60b43: [Query hidden from tests]
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
QUERY:7e4bbcd04982917de4c1fb94ff94e608:
SELECT table_name FROM user_tables
QUERY:d632f626d40c91f7f96d697e86122c38:
SELECT
                        column_name, data_type,
                        data_length,   nullable 
                    FROM
                        user_tab_columns 
                    WHERE
                        table_name='GROUPS'
                    ORDER BY
                        column_id
Array
(
    [Groups] => Array
        (
            [id] => 129
            [name] => 2
            [type] => 1
        )

)