<?php 

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
         
        
        $records =  $this->do->PDO()
            ->query("DESCRIBE $string")
            ->fetchAll(false,false,'toArray');
        
        
        if ($this->options['portability'] & DB_PORTABILITY_LOWERCASE) {
            $case_func = 'strtolower';
        } else {
            $case_func = 'strval';
        }

        
        $res   = array();

        
        foreach($records as $r) {
            
            $bits = explode('(',$r['Type']);
            
            
            
            
            $res[] = array(
                'table' => $case_func($table),
                'name'  => $case_func($r['Field']),
                'type'  => $bits[0],
                'len'   => isset($bits[1]) ? str_replace(')','', $bits[1])  : '',
                'flags' => $r['Extra'] . 
                        ($r['Null'] == 'NO' ? ' not_null' : '').
                        ($r['Key'] == 'PRI' ? ' primary' : '').
                        ($r['Key'] == 'UNI' ? ' unique' : '')
                        ($r['Key'] == 'MUL' ? ' multiple_key' : '')
                        
            );
            if ($mode & DB_TABLEINFO_ORDER) {
                $res['order'][$res[$i]['name']] = $i;
            }
            if ($mode & DB_TABLEINFO_ORDERTABLE) {
                $res['ordertable'][$res[$i]['table']][$res[$i]['name']] = $i;
            }
        }

        // free the result only if we were called on a table
        if ($got_string) {
            @mysql_free_result($id);
        }
        return $res;
    }
    
}
