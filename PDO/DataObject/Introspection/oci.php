<?php 
/**
 * Object Based Database Query Builder and data store
 *  - Oracle Introspection Component.
 *
 * For PHP versions  5 and 7
 * 
 * 
 * Copyright (c) 2015 Alan Knowles
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
class PDO_DataObject_Introspection_oci extends PDO_DataObject_Introspection
{
    
 
    /**
     * Obtains the query string needed for listing a given type of objects
     *
     * @param string $type  the kind of objects you want to retrieve
 
     *
     * @return string  the SQL query string or null if the driver doesn't
     *                  support the object type requested
     *
     * @access protected
      */
      
    function getSpecialQuery($type)
    {
        switch ($type) {
            case 'tables':
                return 'SELECT table_name FROM user_tables';
            case 'synonyms':
                return 'SELECT synonym_name FROM user_synonyms';
            case 'views':
                return 'SELECT view_name FROM user_views';
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
        
 
            /*
             * Probably received a table name.
             * Create a result resource identifier.
             */
            $result = strtoupper($result);
            $records  = $this->do
                ->query("SELECT
                            column_name, data_type,
                            data_length,   nullable 
                        FROM
                            user_tab_columns 
                        WHERE
                            table_name='{$this->do->escape($result)}'
                        ORDER BY
                            column_id")
                ->fetchAll(false,false,'toArray');
            
            $case_func = 'strval';
            if (PDO_DataObject::config()['portability'] & PDO_DataObject::PORTABILITY_LOWERCASE) {
                $case_func = 'strtolower';
            }
            
            
            $i = 0;
            forech($records as $r) {
                $res[] = array(
                    'table' => $case_func($result),
                    'name'  => $case_func(@OCIResult($stmt, 1)),
                    'type'  => @OCIResult($stmt, 2),
                    'len'   => @OCIResult($stmt, 3),
                    'flags' => (@OCIResult($stmt, 4) == 'N') ? 'not_null' : '',
                );
                if ($mode & DB_TABLEINFO_ORDER) {
                    $res['order'][$res[$i]['name']] = $i;
                }
                if ($mode & DB_TABLEINFO_ORDERTABLE) {
                    $res['ordertable'][$res[$i]['table']][$res[$i]['name']] = $i;
                }
                $i++;
            }

            if ($mode) {
                $res['num_fields'] = $i;
            }
            @OCIFreeStatement($stmt);

        } 
        return $res;
    }  
        $case_func = 'strval';
        if (PDO_DataObject::config()['portability'] & PDO_DataObject::PORTABILITY_LOWERCASE) {
            $case_func = 'strtolower';
        }
        
        $res = array();
        foreach($records as $r) {
 
            if (strpos($r['type'], '(') !== false) {
                $bits = explode('(', $r['type']);
                $type = $bits[0];
                $len  = rtrim($bits[1],')');
            } else {
                $type = $r['type'];
                $len  = 0;
            }

            $flags = '';
            if ($r['pk']) {
                $flags .= 'primary_key ';
                if (strtoupper($type) == 'INTEGER') {
                    $flags .= 'auto_increment ';
                }
            }
            if ($r['notnull']) {
                $flags .= 'not_null ';
            }
            if ($r['dflt_value'] !== null) {
                $flags .= 'default_' . rawurlencode($r['dflt_value']);
            }
            $flags = trim($flags);

            $res[] = array(
                'table' => $case_func($table),
                'name'  => $case_func($r['name']),
                'type'  => $type,
                'len'   => $len,
                'flags' => $flags,
            );

            
        }

        return $res;
    }
    
    
}
