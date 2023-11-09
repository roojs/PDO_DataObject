<?php 
/**
 * Object Based Database Query Builder and data store
 *  - SQLite Introspection Component.
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
class PDO_DataObject_Introspection_sqlite extends PDO_DataObject_Introspection
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
    function getSpecialQuery($type   )
    {
     

        switch ($type) {
            case 'master':
                return 'SELECT * FROM sqlite_master';
            case 'tables':
                return "SELECT name FROM sqlite_master WHERE type='table' "
                       . 'UNION ALL SELECT name FROM sqlite_temp_master '
                       . "WHERE type='table' ORDER BY name";
            case 'schema':
                return 'SELECT sql FROM (SELECT * FROM sqlite_master '
                       . 'UNION ALL SELECT * FROM sqlite_temp_master) '
                       . "WHERE type!='meta' "
                       . 'ORDER BY tbl_name, type DESC, name';
            
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
        

        $records  = $this->do
            ->query("PRAGMA table_info('{$this->do->escape($table)}');")
            ->fetchAllAssoc();
        
        
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
                'tablename' => $case_func($table),
                'name'  => $case_func($r['name']),
                'type'  => $type,
                'len'   => $len,
                'flags' => $flags,
                'default_value' => null, /// no info...
                'default_value_raw' => null,
                'fk_column' => '',
                'fk_table' => '',
            );

            
        }

        return $res;
    }
    function foreignKeys($table)
    {
        $this->do->raise("Foriegn keys on SQLite is Not supported");
    }
}
