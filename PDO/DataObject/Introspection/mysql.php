<?php
/**
 * Object Based Database Query Builder and data store
 *  - Mysql Introspection Component.
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
class PDO_DataObject_Introspection_mysql extends PDO_DataObject_Introspection
{
    
    function getSpecialQuery($type)
    {
        switch ($type) {
            case 'tables':
                return 'SHOW TABLES';
            case 'databases':
                return 'SHOW DATABASES';
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
        
        
        // always quote. 
        $string = $this->do->quoteIdentifier($string);
        
        $records =  $this->do
            ->query("DESCRIBE $string")
            ->fetchAll(false,false,'toArray');
        
        
        if (PDO_DataObject::config()['portability'] & PDO_DataObject::PORTABILITY_LOWERCASE) {
            $case_func = 'strtolower';
        } else {
            $case_func = 'strval';
        }

        
        $res   = array();

        
        foreach($records as $r) {
            
            $bits = explode('(',$r['Type']);
               
            $res[] = array(
                'table' => $case_func($string),
                'name'  => $case_func($r['Field']),
                'type'  => $bits[0],
                'len'   => isset($bits[1]) ? str_replace(')','', $bits[1])  : '',
                'flags' => $r['Extra'] . 
                        ($r['Null'] == 'NO' ? ' not_null' : '').
                        ($r['Key'] == 'PRI' ? ' primary' : '').
                        ($r['Key'] == 'UNI' ? ' unique' : '').
                        ($r['Key'] == 'MUL' ? ' multiple_key' : '')
                        
            );
           
        }
        return $res;
    }
        
     /**
     * Returns information about a foriegn keys of a table.
     * Used to generate the links / join .. 
     * 
     * @param  string  $table   string containing the name of a table.
     *                           MUST BE QUOTED if required....
     *                          
     
     * @return array  an associative array (local column) ->  {related_table}:{related_column}
     * 
     *
     */
    function foreignKeys($table)
    {
           
          $quotedTable = $this->quoteIdentifier($table);
                    
                    $res =& $DB->query('SHOW CREATE TABLE ' . $quotedTable );

                    if (PEAR::isError($res)) {
                        die($res->getMessage());
                    }

                    $text = $res->fetchRow(DB_FETCHMODE_DEFAULT, 0);
                    $treffer = array();
                    // Extract FOREIGN KEYS
                    preg_match_all(
                        "/FOREIGN KEY \(`(\w*)`\) REFERENCES `(\w*)` \(`(\w*)`\)/i", 
                        $text[1], 
                        $treffer, 
                        PREG_SET_ORDER);

                    if (!count($treffer)) {
                        continue;
                    }
                    foreach($treffer as $i=> $tref) {
                        $fk[$this->table][$tref[1]] = $tref[2] . ":" . $tref[3];
                    }
    }
     
    
    
}
