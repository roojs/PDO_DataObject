<?php
/**
 * Object Based Database Query Builder and data store
 *  - Mysql Introspection Component.
 *
 * For PHP versions  5 and 7
 * 
 * 
 * Copyright (c) 2016 Alan Knowles
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
class PDO_DataObject_Introspection_mysql extends PDO_DataObject_Introspection
{
    
    function getSpecialQuery($type)
    {
        switch ($type) {
            case 'tables':
                return 'SHOW TABLES';
            case 'databases':
                return 'SHOW DATABASES';
            case 'views':
                 return "SELECT
                        distinct(TABLE_NAME)
                    FROM
                        information_schema.TABLES
                    WHERE
                        table_type = 'VIEW'
                        AND
                        TABLE_SCHEMA=DATABASE()
                    ";
            
            default:
                return null;
        }
    }

    // }}}
    
    
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
    function tableInfo($string)
    {
        // FIXME = use META data....
        // 
        
        $cache = &PDO_DataObject_Introspection::$cache;
        
        // this query takes about 1.5 seconds to do all tables in the database, or 0.5 for single ones.
        // so it's quicker to query, all and cache the results..
        
        if (empty($cache[__CLASS__.'::'. __FUNCTION__])) {
             // FK first...
            
            $cacheblock = class_exists('PDO_DummyStatement') ?' 12 as _prevent_cache' : ( time(). " as _prevent_cache");
            
            $cache[__CLASS__.'::'. __FUNCTION__] =  $this->do
                ->query("
                        
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
                            $cacheblock
                            
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
                ")
                ->fetchAllAssoc();
        }
        
        //var_Dump(count($cache[__CLASS__.'::'. __FUNCTION__]));
        
        $records = array();
        foreach($cache[__CLASS__.'::'. __FUNCTION__] as $ar) {
            if ($ar['tablename'] != $string) {
                continue;
            }
            $records[] = $ar;
        }
        
        
   
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

        
        foreach($records as $r) {
            
            $r['table'] =  $case_func($string);
            $r['name'] =  $case_func($r['name']);
            $r['default_value'] = $r['default_value_raw']; /// probably...
            $res[] = $r;
           
        }
        
        
        return $res;
    }
        
 
    
}
