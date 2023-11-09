<?php 
/**
 * Object Based Database Query Builder and data store
 *  - Oracle Introspection Component.
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
        $table = strtoupper($table);
        $records  = $this->do
            ->query("SELECT
                        column_name, data_type,
                        data_length,   nullable 
                    FROM
                        user_tab_columns 
                    WHERE
                        table_name='{$this->do->escape($table)}'
                    ORDER BY
                        column_id")
            ->fetchAllAssoc();
        
        $case_func = 'strval';
        if (PDO_DataObject::config()['portability'] & PDO_DataObject::PORTABILITY_LOWERCASE) {
            $case_func = 'strtolower';
        }
        
        
        $i = 0;
        foreach($records as $r) {
            $res[] = array(
                'tablename' => $case_func($table),
                'name'  => $case_func($r['column_name']),
                'type'  => $r['data_type'],
                'len'   => $r['data_length'],
                'flags' => ($r['nullable'] == 'N') ? 'not_null' : '',
                'default_value' => null, /// no info...
                'default_value_raw' => null,
                'fk_column' => '',
                'fk_table' => '',
            );
            
        }

 
        return $res;
     
    }  
    
}
