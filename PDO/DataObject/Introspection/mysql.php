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
     * @see DB_common::tableInfo()
     */
    function tableInfo($string)
    {
         
        
        $this->do->PDO()->query("SELECT * FROM $string LIMIT 0")
         
            /*
             * Probably received a table name.
             * Create a result resource identifier.
             */
            $id = @mysql_query("SELECT * FROM $result LIMIT 0",
                               $this->connection);
            $got_string = true;
        } elseif (isset($result->result)) {
            /*
             * Probably received a result object.
             * Extract the result resource identifier.
             */
            $id = $result->result;
            $got_string = false;
        } else {
            /*
             * Probably received a result resource identifier.
             * Copy it.
             * Deprecated.  Here for compatibility only.
             */
            $id = $result;
            $got_string = false;
        }

        if (!is_resource($id)) {
            return $this->mysqlRaiseError(DB_ERROR_NEED_MORE_DATA);
        }

        if ($this->options['portability'] & DB_PORTABILITY_LOWERCASE) {
            $case_func = 'strtolower';
        } else {
            $case_func = 'strval';
        }

        $count = @mysql_num_fields($id);
        $res   = array();

        if ($mode) {
            $res['num_fields'] = $count;
        }

        for ($i = 0; $i < $count; $i++) {
            $res[$i] = array(
                'table' => $case_func(@mysql_field_table($id, $i)),
                'name'  => $case_func(@mysql_field_name($id, $i)),
                'type'  => @mysql_field_type($id, $i),
                'len'   => @mysql_field_len($id, $i),
                'flags' => @mysql_field_flags($id, $i),
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
