<?php
/**
 *
 *
 */

class PDO_DataObject_Generator_Column {
   
    var $table; //
    var $gen; //
    var $name = '';
    var $type = '';
    var $len = 0;
    var $flats = '';
    var $do_type = 0; // eg . PDO_DataObject::INT
    var $foreign_key = ''; /// XXX:YYY  XXX=table, YYY=column that it points to.
    var $is_key;
    var $default_value;
    
    var $is_sequence;
    var $sequence_name;
    var $is_sequence_native;

    /**
     * 
     * @param PDO_DataObject_Generator_Table $table - table that this column belongs to..
     * @param Array  definition array --inludes
     *    name
     *    default
     *    type
     * 
     */  
    function __construct($table,$def_ar)
    {
        $this->table = $table;
        $this->gen = $table->gen;
        $this->hook = $table->hook;
        $this->name = $def_ar['name'];
        // and set other stuff?
        // put all the type parsing here!?
        $this->default_value = $def_ar['default'];
        $this->length = $def_ar['len'];
        
        
        
        
        
        
           
            
        switch (strtoupper($def_ar['type'])) {

            case 'INT':
            case 'INT2':    // postgres
            case 'INT4':    // postgres
            case 'INT8':    // postgres
            case 'SERIAL4': // postgres
            case 'SERIAL8': // postgres
            case 'INTEGER':
            case 'TINYINT':
            case 'SMALLINT':
            case 'MEDIUMINT':
            case 'BIGINT':
                $type = PDO_DataObject::INT;
                if ($t->len == 1) {
                    $type +=  PDO_DataObject::BOOL;
                }
                break;
           
            case 'REAL':
            case 'DOUBLE':
            case 'DOUBLE PRECISION': // double precision (firebird)
            case 'FLOAT':
            case 'FLOAT4': // real (postgres)
            case 'FLOAT8': // double precision (postgres)
            case 'DECIMAL':
            case 'MONEY':  // mssql and maybe others
            case 'NUMERIC':
            case 'NUMBER': // oci8 
                $type = PDO_DataObject::INT; // should really by FLOAT!!! / MONEY...
                break;
                
            case 'YEAR':
                $type = PDO_DataObject::INT; 
                break;
                
            case 'BIT':
            case 'BOOL':   
            case 'BOOLEAN':   
            
                $type = PDO_DataObject::BOOL;
                // postgres needs to quote '0'
                if ($dbtype == 'pgsql') {
                    $type +=  PDO_DataObject::STR;
                }
                break;
                
            case 'STRING':
            case 'CHAR':
            case 'VARCHAR':
            case 'VARCHAR2':
            case 'TINYTEXT':
            
            case 'ENUM':
            case 'SET':         // not really but oh well
            
            case 'POINT':       // mysql geometry stuff - not really string - but will do..
            
            case 'TIMESTAMPTZ': // postgres
            case 'BPCHAR':      // postgres
            case 'INTERVAL':    // postgres (eg. '12 days')
            
            case 'CIDR':        // postgres IP net spec
            case 'INET':        // postgres IP
            case 'MACADDR':     // postgress network Mac address.
            
            case 'INTEGER[]':   // postgres type
            case 'BOOLEAN[]':   // postgres type
            
                $type = PDO_DataObject::STR;
                break;
            
            case 'TEXT':
            case 'MEDIUMTEXT':
            case 'LONGTEXT':
            case '_TEXT':   //postgres (?? view ??)
                
                $type = PDO_DataObject::STR + PDO_DataObject::TXT;
                break;
            
            
            case 'DATE':    
                $type = PDO_DataObject::STR + PDO_DataObject::DATE;
                break;
                
            case 'TIME':    
                $type = PDO_DataObject::STR + PDO_DataObject::TIME;
                break;    
                
            
            case 'DATETIME': 
                 
                $type = PDO_DataObject::STR + PDO_DataObject::DATE + PDO_DataObject::TIME;
                break;    
                
            case 'TIMESTAMP': // do other databases use this???
                
                $type = ($dbtype == 'mysql' || $dbtype == 'mysqli') ?
                    PDO_DataObject::MYSQLTIMESTAMP : 
                    PDO_DataObject::STR + PDO_DataObject::DATE + PDO_DataObject::TIME;
                break;    
                
            
            case 'BLOB':       /// these should really be ignored!!!???
            case 'TINYBLOB':
            case 'MEDIUMBLOB':
            case 'LONGBLOB':
            
            case 'CLOB': // oracle character lob support
            
            case 'BYTEA':   // postgres blob support..
                $type = PDO_DataObject::STR + PDO_DataObject::BLOB;
                break;
                
            default:     
                echo "*****************************************************************\n".
                     "**               WARNING UNKNOWN TYPE                          **\n".
                     "** Found column '{$t->name}', of type  '{$t->type}'            **\n".
                     "** Please submit a bug, describe what type you expect this     **\n".
                     "** column  to be                                               **\n".
                     "** ---------POSSIBLE FIX / WORKAROUND -------------------------**\n".
                     "** Try using MDB2 as the backend - eg set the config option    **\n".
                     "** db_driver = MDB2                                            **\n".
                     "*****************************************************************\n";
                $write_ini = false;
                break;
        }
        
        if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $t->name)) {
            echo "*****************************************************************\n".
                 "**               WARNING COLUMN NAME UNUSABLE                  **\n".
                 "** Found column '{$t->name}', of type  '{$t->type}'            **\n".
                 "** Since this column name can't be converted to a php variable **\n".
                 "** name, and the whole idea of mapping would result in a mess  **\n".
                 "** This column has been ignored...                             **\n".
                 "*****************************************************************\n";
            continue;
        }
        
        if (!strlen(trim($t->name))) {
            continue; // is this a bug?
        }
        
        if (preg_match('/not[ _]null/i',$t->flags)) {
            $type += PDO_DataObject::NOTNULL;
        }
       
       
        if (in_array($t->name,array('null','yes','no','true','false'))) {
            echo "*****************************************************************\n".
                 "**                             WARNING                         **\n".
                 "** Found column '{$t->name}', which is invalid in an .ini file **\n".
                 "** This line will not be writen to the file - you will have    **\n".
                 "** define the keys()/method manually.                          **\n".
                 "*****************************************************************\n";
            $write_ini = false;
        } else {
            $this->_newConfig .= "{$t->name} = $type\n";
        }
        
        $ret['table'][$t->name] = $type;
        // i've no idea if this will work well on other databases?
        // only use primary key or nextval(), cause the setFrom blocks you setting all key items...
        // if no keys exist fall back to using unique
        //echo "\n{$t->name} => {$t->flags}\n";
        $secondary_key_match = isset($options['generator_secondary_key_match']) ? $options['generator_secondary_key_match'] : 'primary|unique';
        
        $m = array();
        if (preg_match('/(auto_increment|nextval\(([^)]*))/i',rawurldecode($t->flags),$m) 
            || (isset($t->autoincrement) && ($t->autoincrement === true))) {
            
            $sn = 'N';
            if ($dbtype == 'pgsql' && !empty($m[2])) { 
                $sn = preg_replace('/[("]+/','', $m[2]);
                $sn = preg_replace('/::.*$/', '', $sn); // new query for postgresql returns nextval('XXXX'::type)
                $sn = trim($sn, "'");
                //echo urldecode($t->flags) . "\n" ;
            }
            // native sequences = 2
            if ($write_ini) {
                $keys_out_primary .= "{$t->name} = $sn\n";
            }
            $ret_keys_primary[$t->name] = $sn;
        
        } else if ($secondary_key_match && preg_match('/('.$secondary_key_match.')/i',$t->flags)) {
            // keys.. = 1
            $key_type = 'K';
            if (!preg_match("/(primary)/i",$t->flags)) {
                $key_type = 'U';
            }
            
            if ($write_ini) {
                $keys_out_secondary .= "{$t->name} = {$key_type}\n";
            }
            $ret_keys_secondary[$t->name] = $key_type;
        }
        
    
        
        
        
        
        
        
        
        
        
        
    }
    
     
    function toPhpVar($var)
    {
          
     
        if (!strlen(trim($this->name))) {
            return '';
        }
        if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $this->name)) {
            echo "*****************************************************************\n".
                 "**               WARNING COLUMN NAME UNUSABLE                  **\n".
                 "** Found column '{$t->name}', of type  '{$t->type}'            **\n".
                 "** Since this column name can't be converted to a php variable **\n".
                 "** name, and the whole idea of mapping would result in a mess  **\n".
                 "** This column has been ignored...                             **\n".
                 "*****************************************************************\n";
            return;
        }
        
        $pad = str_repeat(' ',max(2,  (30 - strlen($this->name))));

        $length = empty($this->len) ? '' : '('.$this->len.')';
        $flags = strlen($this->flags) ? (' '. trim($this->flags)) : '';
        $body .="    {$var} \${$this->name}; {$pad}// {$this->type}{$length}{$flags}\n";
        
        // can not do set as PEAR::DB table info doesnt support it.
        //if (substr($t->Type,0,3) == "set")
        //    $sets[$t->Field] = "array".substr($t->Type,3);
        $body .= $this->hook->varDef($t,strlen($p));
    }
    /**
    * Generate getter methods for class definition
    *
    * @param    string  $input  Existing class contents
    * @return   string
    * @access   public
    */
    function toPhpGetter($user_code)
    {
        $options = $this->gen->config();
        
        // only generate if option is set to true
        if  ($options['getters']) {
            return '';
        }
        $getters = '';

        
        $getters .= "\n\n";
        
            // build mehtod name
        $methodName = 'get' . $this->table->getMethodNameFromColumnName($this->name);

        if (!strlen(trim($this->name)) || preg_match("/function[\s]+[&]?$methodName\(/i", $user_code)) {
            return '';
        }

        $getters .= "   /**\n";
        $getters .= "    * Getter for \${$this->name}\n";
        $getters .= "    *\n";
        // this makes no sense - mysql multiple key (MUL) - is just for indexed columns?
       // $getters .= (stristr($t->flags, 'multiple_key')) ? "    * @return   object\n"
       //                                                  : "    * @return   {$t->type}\n";
        $getters .= "    * @return   {$this->type}\n";
        $getters .= "    * @access   public\n";
        $getters .= "    */\n";
        // why add public it's pointless...
        //$getters .= (substr(phpversion(),0,1) > 4) ? '    public '
                                                   
        $getters .= "    function $methodName() {\n";
        $getters .= "        return \$this->{$this->name};\n";
        $getters .= "    }\n\n";
        
        return $getters;
    }
    
     /**
    * Generate setter methods for class definition
    *
    * @param    string  Existing class contents
    * @return   string
    * @access   public
    */
    function toPhpSetter($user_code) 
    {

        $options = $this->gen->config();
        
        // only generate if option is set to true
        if  ($options['setters']) {
            return '';
        }
        $setters = '';

         
       

            // build mehtod name
        $methodName = 'set' . $this->table->getMethodNameFromColumnName($this->name);

        if (!strlen(trim($this->name)) || preg_match("/function[\s]+[&]?$methodName\(/i", $user_code)) {
            return '';
        }

        $setters .= "   /**\n";
        $setters .= "    * Setter for \${$this->name}\n";
        $setters .= "    *\n";
        $setters .= "    * @param    mixed   input value\n";
        $setters .= "    * @access   public\n";
        $setters .= "    */\n";
        //$setters .= (substr(phpversion(),0,1) > 4) ? '    public '
        //                                           : '    ';
        $setters .= "   function $methodName(\$value) {\n";
        $setters .= "        \$this->{$t->name} = \$value;\n";
        $setters .= "    }\n\n";
    

        return $setters;
    }
        
    /**
    * Generate link setter/getter methods for class definition
    *
    * @param    string  Existing class contents
    * @return   string
    * @access   public
    */
    function toPhpLinkMethod($user_code) 
    {

        $options = $this->gen->config();
        
        $setters = '';

        // only generate if option is set to true
        
        // generate_link_methods true::
        
        
        if  (empty($options['link_methods'])) {
            //echo "skip lm? - not set";
            return '';
        }
        
        if (empty($this->foreign_key)) {
            // echo "skip lm? - fkyes empty";
            return '';
        }
            
        
        $setters .= "\n";
        // build mehtod name
        
        $methodName =  is_callable($options['link_methods']) ?
                    call_user_func($options['link_methods'], $this->name) : $this->name;

        if (!strlen(trim($k)) || preg_match("/function[\s]+[&]?$methodName\(/i", $user_code)) {
            return '';
        }

        $setters .= "   /**\n";
        $setters .= "    * Getter / Setter for \${$this->name}\n";
        $setters .= "    *\n";
        $setters .= "    * @param    mixed   (optional) value to assign\n";
        $setters .= "    * @access   public\n";
        
        $setters .= "    */\n";
      
                                                   
        $setters .= "function $methodName() {\n";
        $setters .= "        return \$this->link('$this->name', func_get_args());\n";
        $setters .= "    }\n\n";
    
         
        return $setters;
    }
    function toPhpTableFunc()
    {
        
    }
    function toPhpKeyFunc()
    {
        
    }
    function toPhpSequenceFunc()
    {
        
        return var_export(array(true,$this->is_sequence_native,$this->sequence_name));
    }
    function toPhpDefault()
    {
        $type = $this->do_type;
        $value = '';
        switch(true) {
             
            case (is_null( $this->default_value)):
                $value  = 'null';
                break;
            
            case ($type & PDO_DataObject::DATE): 
            case ($type & PDO_DataObject::TIME): 
            case ($type & PDO_DataObject::MYSQLTIMESTAMP): // not supported yet..
                return '';
                
            case ($type & PDO_DataObject::BOOL): 
                $value =  (int)(boolean) $this->default_value; // postgres... 
                break;
                
            
            case ($type & PDO_DataObject::STR): 
                $value =  "'" . addslashes($this->default_value) . "'";
                break;
            
         
            default:    // hopefully eveything else...  - numbers etc.
                if (is_numeric($this->default_value)) {
                    $value =   $this->default_value;
                    break;
                }
                return '';
                    
        }
        return "'".addslashes($k)."' => {$v}";
    }
    
    
    function toIni()
    {
        
    }
    function toIniSequence()
    {
        
    }
    
    
    function toLinks()
    {
        
    }
    
    
}
