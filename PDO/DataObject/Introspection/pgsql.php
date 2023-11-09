<?php 
/**
 * Object Based Database Query Builder and data store
 *  - Postgresql Introspection Component.
 *
 * For PHP versions  5 and 7
 * 
 * 
 * Copyright (c) 2023 Alan Knowles
 * 
 * This program is free software: you can redistribute it and/or modify  
 * it under the terms of the GNU Lesser General Public License as   
 * published by the Free Software Foundation, version 3.
 *
 * This program is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU 
 * Lesser General Lesser Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *  
 * @category   Database
 * @package    PDO_DataObject
 * @author     Alan Knowles <alan@roojs.com>
 * @copyright  2016 Alan Knowles
 * @license    https://www.gnu.org/licenses/lgpl-3.0.en.html  LGPL 3
 * @version    1.0
 * @link       https://github.com/roojs/PDO_DataObject
 */
  
  
class_exists('PDO_DataObject_Introspection') ? '' : require_once 'PDO/DataObject/Introspection.php';
// move me to seperate classes...
class PDO_DataObject_Introspection_pgsql extends PDO_DataObject_Introspection
{
    
    function getSpecialQuery($type)
    {
        switch ($type) {
            
            case 'tables':
                
                return "SELECT table_name FROM information_schema.tables" .
                        " WHERE table_type = 'BASE TABLE'" .
                        " AND table_schema = 'public' order by table_name ASC";
            
            case 'tables.all': /// not sure if this really works....
                return 'SELECT c.relname AS "Name"'
                        . ' FROM pg_class c, pg_user u'
                        . ' WHERE c.relowner = u.usesysid'
                        . " AND c.relkind = 'r'"
                        . ' AND NOT EXISTS'
                        . ' (SELECT 1 FROM pg_views'
                        . '  WHERE viewname = c.relname)'
                        . " AND c.relname !~ '^(pg_|sql_)'"
                        . ' UNION'
                        . ' SELECT c.relname AS "Name"'
                        . ' FROM pg_class c'
                        . " WHERE c.relkind = 'r'"
                        . ' AND NOT EXISTS'
                        . ' (SELECT 1 FROM pg_views'
                        . '  WHERE viewname = c.relname)'
                        . ' AND NOT EXISTS'
                        . ' (SELECT 1 FROM pg_user'
                        . '  WHERE usesysid = c.relowner)'
                        . " AND c.relname !~ '^pg_'";
            case 'schema.tables':
                return "SELECT schemaname || '.' || tablename"
                        . ' AS "Name"'
                        . ' FROM pg_catalog.pg_tables'
                        . ' WHERE schemaname NOT IN'
                        . " ('pg_catalog', 'information_schema', 'pg_toast')";
            case 'schema.views':
                return "SELECT schemaname || '.' || viewname from pg_views WHERE schemaname"
                        . " NOT IN ('information_schema', 'pg_catalog')";
            case 'views':
                // Table cols: viewname | viewowner | definition
                return "SELECT viewname from pg_views WHERE schemaname = 'public'"; // default is to only get public.* views..
                        
            case 'users':
                // cols: usename |usesysid|usecreatedb|usetrace|usesuper|usecatupd|passwd  |valuntil
                return 'SELECT usename FROM pg_user';
            case 'databases':
                return 'SELECT datname FROM pg_database';
            case 'functions':
            case 'procedures':
                return 'SELECT proname FROM pg_proc WHERE proowner <> 1';
            default:
                return null;
        }
    }

    
    
    /**
     * Returns information about a table or a result set
     *
     * @param  string  $table   string containing the name of a table.
     *                           MUST BE QUOTED if required....
     *                          
     
     * @return array  an associative array with the information requested.
     *                 A DB_Error object on failure.
     *
     *
     *  multiple_key
        
     *
     */
    function tableInfo($table)
    {
        
        
        // currently only queries 'public'???
        $schema  ='public';
        if (strpos($table,'.') !== false) {
            list($schema, $table) =explode('.', $table);
        }
        // not used?
        $database = $this->do->PDO()->dsn['database_name'];
        
        
        
         $records =  $this->do
            ->query("
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
                        pg_class.relname='{$this->do->escape($table)}'
                        AND 
                        pg_namespace.nspname = '{$this->do->escape($schema)}'


                    ORDER BY
                        pg_attribute.attnum ASC 
        
            ")
            ->fetchAllAssoc();
        
        if (PDO_DataObject::debugLevel() > 2)  {
            // this is for the test_suite...
            $rr = array();
            foreach($records as $r) {
                $rr[] = json_encode($r);
            }
            $this->do->debug(var_export("\n[\n    " . implode( ",\n   ", $rr) ."\n]\n"), __FUNCTION__,  3);
            
        }
        
        if (PDO_DataObject::config()['portability'] & PDO_DataObject::PORTABILITY_LOWERCASE) {
            $case_func = 'strtolower';
        } else {
            $case_func = 'strval';
        }

        
        $res   = array();

        //print_r($records);
        
        foreach($records as $r) {
            
            $r['name'] =  $case_func($r['name']);
            $r['table'] =  $case_func($table);
            
            $r['default_value']  = null;
            switch($r['default_value_raw']) {
                case '':
                    break;
                case "''::text":
                    $r['default_value'] = '';
                    break;
                case 'true';
                    $r['default_value']  = true;
                    break;
                case 'false';
                    $r['default_value']  = false;
                    break;
                default:
                    // we send 'default_value_raw' to the server...
                    break;
            }
            
            if (is_numeric($r['default_value_raw'])) {
                $r['default_value'] *= 1.0; // hopefully...
            }
            // character '0'::bpchar .... - 
            // could add more..... 
            
            
            $res[] = $r;
            
             
           
        }

        
        return $res;
    }
  
    
}
