<?php
/**
 * Generation tools for PDO_DataObject
 *  - representation of a table column.
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
class PDO_DataObject_Generator_Column
{
   
   /**
     * @var PDO_DataObject_Generator the generator
     */
    var $table; //
    /**
     * @var PDO_DataObject_Generator the generator
     */
    var $gen; //
    /**
     * @var string raw name from database
     */
    var $name = '';
    /**
     * @var bool is the name invalid (and should be ignored?)
     */
    var $is_name_invalid = false;
    /**
     * @var string Uppercase raw type from database
     */
    var $type = '';  // upper case Type
    /**
     * @var int|string length of the argument  (might be 4,2 in case of decimal)
     */
    var $length = 0;
    /**
     * @var int  the PDO_DataObject type ,eg . PDO_DataObject::INT
     */
    var $do_type = 0; 
    /**
     * @var string from original database table meta table - flags - contains not_nul autoincrement but
     *         not nextval() - that's in default value...
     */
    var $flags = ''; //?/
    
    /**
     * @var string   colon seperated reference to foriegn table/column that it points to.
     *              eg. XXX:YYY  XXX=table, YYY=column 
     */
    var $foreign_key = '';
    
    /**
     * @var mixed the default as defined  in the database (used to build the defaults() method )
     */
    var $default_value;
    
    /**
     * @var string the raw default as defined  in the database used to find nextval)
     */
    var $default_value_raw;
    
    /**
     * @var bool  is the column a sequence (eg auto_increment or nextval())
     */
    var $is_sequence = false;
    /**
     * @var string the name of the sequence (relivant for nextval etc..)
     */
    var $sequence_name = '';
    /**
     * @var string the type of Sequence, N=Native, K=(Primary or indexed?), U=Unique..
     */
    var $key_type= ''; 
    /**
     * @var bool is the sequence native? - Need to check on this - basically postgres nextval and mysql auto increment are regarded
     *         as native - not sure if this was supposed to be the old 'emuluated sequences' that used to be used?
     */
    var $is_sequence_native = false;

    /**
     * 
     * @param PDO_DataObject_Generator_Table $table - table that this column belongs to..
     * @param Array  definition array --inludes
     *    name
     *    default_value
     *    default_value_raw (not used at present, but contains methods in pgsql etc..
     *    type
     *    len
     *    fk_table,
     *    fk_column
     *    autoincrement ???<< where from??
     * 
     */  
    function __construct($table,$def_ar)
    {
        $this->table = $table;
        $this->gen = $table->gen;
        $this->hook = $table->hook;
        $this->name = trim($def_ar['name']);
        $this->type = strtoupper($def_ar['type']);
        $this->flags = $def_ar['flags'];
        // and set other stuff?
        // put all the type parsing here!?
        $this->default_value = $def_ar['default_value'];
        $this->default_value_raw = $def_ar['default_value_raw'];
        $this->length = $def_ar['len'];
        if (!empty($def_ar['fk_table'])) {
            $this->foreign_key = $def_ar['fk_table'] .':' . $def_ar['fk_column'];
        }
        
        
        $dbtype = $this->gen->PDO()->getAttribute(PDO::ATTR_DRIVER_NAME);
        
        
        
           
            
        switch ($this->type) {

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
                if ($this->length == 1) {
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
            case 'CHARACTER': // pgsql
            case 'CHARACTER VARYING': //postgres
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
            
            // these are all array types..
            case 'INTEGER[]':   // postgres type
            case 'BOOLEAN[]':   // postgres type
            case 'TEXT[]':   // postgres type
            
            case 'TIMESTAMP WITH TIME ZONE': // pgsql -- might need another 'type' to handle this correctly..
            
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
            case 'TIMESTAMP WITHOUT TIME ZONE': // postgresql..
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
                $this->gen->raiseError(
                    "*****************************************************************\n".
                     "**               WARNING UNKNOWN TYPE                          **\n".
                     "** Found column '{$this->name}', of type  '{$this->type}'            **\n".
                     "** Please submit a bug, describe what type you expect this     **\n".
                     "** column  to be                                               **\n".
                     "*****************************************************************\n"
                ,PDO_DataObject::ERROR_INVALIDCONFIG, PDO_DataObject::ERROR_DIE);
                break;
        }
        
        if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $this->name)) {
            echo "*****************************************************************\n".
                 "**               WARNING COLUMN NAME UNUSABLE                  **\n".
                 "** Found column '{$this->name}', of type  '{$this->type}'            **\n".
                 "** Since this column name can't be converted to a php variable **\n".
                 "** name, and the whole idea of mapping would result in a mess  **\n".
                 "** This column has been ignored...                             **\n".
                 "*****************************************************************\n";
            $this->is_name_invalid = true;
            return;
        }
        
        if (!strlen($this->name)) {
            $this->is_name_invalid = true;
            return;
        }
        
        if (preg_match('/not[ _]null/i',$this->flags)) {
            $type += PDO_DataObject::NOTNULL;
        }
       
        $this->do_type = $type;
       
       
       
        if (in_array($this->name,array('null','yes','no','true','false'))) {
            echo "*****************************************************************\n".
                 "**                             WARNING                         **\n".
                 "** Found column '{$this->name}', which is invalid in an .ini file **\n".
                 "** This line will not be writen to the file - you will have    **\n".
                 "** define the keys()/method manually.                          **\n".
                 "*****************************************************************\n";
            $this->is_name_invalid = true;
        }  
        
        $options = PDO_DataObject_Generator::config();
        // i've no idea if this will work well on other databases?
        // only use primary key or nextval(), cause the setFrom blocks you setting all key items...
        // if no keys exist fall back to using unique
        //echo "\n{$t->name} => {$t->flags}\n";
        $secondary_key_match =  $options['secondary_key_match']; // normally unique|primary
        
        $m = array();
       
        if (preg_match('/(nextval\(([^)]*))/i',$this->default_value_raw,$m)
            ||
            preg_match('/auto_increment/i',rawurldecode($this->flags)) 
            || (isset($def_ar['autoincrement']) && ($def_ar['autoincrement'] === true))) {
            
            
            $this->is_sequence = true;
            $this->is_sequence_native = true;
            $this->key_type = 'N';
            if ($dbtype == 'pgsql' && !empty($m[2])) { 
                $sn = preg_replace('/[("]+/','', $m[2]);
                $sn = preg_replace('/::.*$/', '', $sn); // new query for postgresql returns nextval('XXXX'::type)
                $this->sequence_name = trim($sn, "'");
                //echo urldecode($t->flags) . "\n" ;
            }
            // native sequences = 2
            ;
        
        } else if ($secondary_key_match && preg_match('/('.$secondary_key_match.')/i',$this->flags)) {
            // keys.. = 1
            $this->is_sequence = false;
            $this->is_sequence_native = false;
            $this->key_type = 'K';
            
            // since unique keys 'might' be unique in combo with others??
            if (!preg_match("/(primary)/i",$this->flags)) {
                $this->key_type = 'U';
            }
            
            
        }
         
        
        
        
        
        
        
    }
    
     
    function toPhpVar($var)
    {
          
        $body = '';
        if (!strlen($this->name) || $this->is_name_invalid) {
            return '';
        }
        
        $pad = str_repeat(' ',max(2,  (30 - strlen($this->name))));

        $length = empty($this->len) ? '' : '('.$this->len.')';
        $flags = strlen($this->flags) ? (' '. trim($this->flags)) : '';
        $body .="    {$var} \${$this->name}; {$pad}// {$this->type}{$length}{$flags}\n";
        
        // can not do set as PEAR::DB table info doesnt support it.
        //if (substr($t->Type,0,3) == "set")
        //    $sets[$t->Field] = "array".substr($t->Type,3);
        $body .= $this->hook->varDef($this,$pad);
        
        return $body;
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
        if  (!$options['getters'] || $this->is_name_invalid) {
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
        if  (!$options['setters'] ||  $this->is_name_invalid) {
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
        $setters .= "    function $methodName(\$value) {\n";
        $setters .= "        \$this->{$this->name} = \$value;\n";
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
        
        return var_export(array(true,$this->is_sequence_native,$this->sequence_name), true);
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
                
            case ($type & PDO_DataObject::BOOL &&  is_bool($this->default_value)): 
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
        return var_export($this->name,true) . ' => ' . var_export($value,true);
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
