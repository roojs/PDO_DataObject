<?php
/**
 * Generation tools for PDO_DataObject
 *  - representation of a table.
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
   
class PDO_DataObject_Generator_Table {
   
    var $gen; // generator.
    var $hook;
    var $table= ''; // name of table..
    var $columns = array();
    var $links = array();
    
   
    function __construct($gen, $table)
    {
        $this->gen = $gen;
        $this->hook = $gen->hook;
        $this->table= $table;
        $this->readFromDB();
        $this->classname = $this->getClassNameFromTableName();
        
    }
     /**
    * Convert a table name into a class name -> override this if you want a different mapping
    *
    * @access  public
    * @return  string class name;
    */
    function toPhpClassName()
    {
        $class_prefix_ar  = explode(PATH_SEPERATOR, PDO_DataObject::config('class_prefix'));
        return  $class_prefix_ar[0].preg_replace('/[^A-Z0-9]/i','_',ucfirst(trim($this->table)));
    }
    
    
    
    /**
    * Convert a table name into a file name -> override this if you want a different mapping
    *
    * @access  public
    * @return  string file name;
    */
    
    
    function toPhpFileName()
    {
        $options = PDO_DataObject::config();
        
        $base_ar = explode(PATH_SEPARATOR,$options['class_location']);
        
        if (count($base_ar) != 1 || !strlen($base_ar[0] )) {
            $this->gen->raiseError(
                "option[class_location] must be a single location for the generator to work.",
                PDO_DataObject::ERROR_INVALIDCONFIG, PDO_DataObject::ERROR_DIE
            );
        }
        $base = $base_ar[0];
        if (strpos($base,'%s') !== false) {
            $fn   = sprintf($base, 
                    preg_replace('/[^A-Z0-9]/i','_',ucfirst($this->table)));
        } else { 
            $fn = "{$base}/".preg_replace('/[^A-Z0-9]/i','_',ucfirst($this->table)).".php";
        }
        
        if (!file_exists(dirname($fn))) {
            mkdir(dirname($fn), 0644, true); //??? permissions???
        }
        
        return $outfilename;
        
    }
    
    
    
    /**
    * Convert a column name into a method name (usually prefixed by get/set/validateXXXXX)
    * Designed to be overidden if you really think it's a good idea?
    *
    * @access  public
    * @return  string method name;
    */
    function getMethodNameFromColumnName($col)
    {
        return ucfirst($col);
    }
    
    function readFromDB() // and set's databaseStructure!?
    {
         
         // a little bit of sanity testing.
        
        $options = PDO_DataObject::config();;
        $pdo = $this->gen->PDO();
     
        // quote table not needed as the intropection classes handle it..
        
        $defs = $this->introspection()->tableInfo($this->table);
         
        
        $this->debug("getting def for {$pdo->database_nickname}/{$this->table}", __FUNCTION__,3);
        $this->debug(print_r($defs,true),'defs',3);
        
        // cast all definitions to objects - as we deal with that better.
        
        class_exists('PDO_DataObject_Generator_Column') ? '' :
            require_once 'PDO/DataObject/Generator/Column.php';
            
        foreach($defs as $def) {
            if (is_array($def)) {
                $this->columns[] = new PDO_DataObject_Generator_Column($this,$def);
                
            }
        }
        
        $this->gen->databaseStructure($pdo->database_nickname,   $this->toIniArray()  ); 
        
         
    }
 
    function toPhp($original)
    {
        $user_code = preg_replace('/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n).*(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s', '', $original);
        
        $config = $this->gen->config();
         
         // title = expand me!
        $foot = "";
        $head = "<?php\n/**\n * Table Definition for {$this->table}\n";
        $head .= $this->hook->pageLevelDocBlock();
        $head .= " */\n";
        $head .= $this->hook->extendsDocBlock();

        
        // requires - if you set extends_location = (blank) then no require line will be set
        // this can be used if you have an autoloader
        
        if (!empty($config['extends_class_location'])) {
            $head .= "class_exists('{$config['extends_class']}') ? '' : require_once '{$config['extends_class_location']}';\n\n";
        }
        // add dummy class header in...
        // class 
        $head .= $this->hook->classDocBlock();
        $head .= "class {$this->classname} extends {$config['extends_class']} \n{";

        $body =  "\n    ###START_AUTOCODE\n";
        $body .= "    /* the code below is auto generated do not remove the above tag if you want to regenerate it */\n\n";
        // table

        $p = str_repeat(' ',max(2, (18 - strlen($this->table)))) ;
    
         
        $var = $config['var_keyword']; 
        
        
        $body .= "    {$config['var_keyword']} \$__table = '{$this->table}';  {$p}// table name\n";
    
       

        // Only include the $_database property if the omit_database_var is unset or false
        
        if ($config['add_database_var']) {
            $p = str_repeat(' ',   max(2, (16 - strlen($this->_database))));
            $body .= "    {$config['var_keyword']} \$_database = '{$this->_database}';  {$p}// database name (used with databases[{*}] config)\n";
        }
        
        
        if ($config['no_column_vars']) {
            $var = '//'.$var;
        }
        
        foreach($this->columns as $col) {
            if ($col->is_name_invalid) {
                continue;
            }
            $body .= $col->toPhpVar($var);
        }
         
        $body .= $this->hook->postVar($defs);

        foreach($this->columns as $col) {
            if ($col->is_name_invalid) {
                continue;
            }
            $body .= $col->toPhpGetter($user_code)
                  .  $col->toPhpSetter($user_code)
                  .  $col->toPhpLinkMethod($user_code);
        }
           
        // set methods
        //foreach ($sets as $k=>$v) {
        //    $kk = strtoupper($k);
        //    $body .="    function getSets{$k}() { return {$v}; }\n";
        //}
        
        if (($config['no_ini'] || $config['add_defaults'])) {
            $tdef = array();
            $kdef = array();
            $sdef = var_export(array(false,false,false)); // should only be one fo thieses
            $vdef = array();
            foreach($this->columns as $col) {
                if ($col->is_name_invalid) {
                    continue;
                }
                $tdef[] = $col->toPhpTableFunc();
                if ($col->is_key) {
                    $kdef[] = $col->toPhpKeyFunc();
                }
                if ($col->is_sequence_key) {
                    $sdef = $col->toPhpSequenceFunc();
                }
                if ($col->toPhpDefault() != '') {
                    $vdef[] = $col->toPhpDefault() ;
                }
            }
            
            
            $schema =  "\n" 
                    . "    function table()\n" 
                    . "    {\n" 
                    . "         return array(\n"
                    . "             ". implode(",\n             ", $tdef)
                    . "         );" 
                    . "    }\n"
                    . "    function keys()\n" 
                    . "    {\n" 
                    . "         return array(\n"
                    . "             ". implode(",\n             ", $kdef)
                    . "         );" 
                    . "    }\n"   
                    . "    function sequenceKey()\n" 
                    . "    {\n" 
                    . "         return ". $sdef . ";\n"
                    . "    }\n";
            $defaults = "\n" 
                    . "    function defaults() // column default values \n" 
                    . "    {\n"
                    . "         return array(\n"
                    . "             ". implode(",\n             ", $vdef)
                    . "         );" 
                    . "    }\n";
                    
            if ($config['no_ini']) {
                $body .= $schema;
            }
            $body .=  $defaults;
            
        }
        
        
        $body .= $this->hook->functions($input);

        $body .= "\n    /* the code above is auto generated do not remove the tag below */";
        $body .= "\n    ###END_AUTOCODE\n";
         




        $foot .= "}\n";
        $full = $head . $body . $foot;

        if (!$input) {
            return $full;
        }
        if (!preg_match('/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n)/s',$input))  {
            return $full;
        }
        if (!preg_match('/(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s',$input)) {
            return $full;
        }

        
        
        /* this used to be configurable - */

        $input = preg_replace(
            '/(\n|\r\n)class\s*[a-z0-9_]+\s*extends\s*[a-z0-9_]+\s*(\n|\r\n)\{(\n|\r\n)/si',
            "\nclass {$this->classname} extends {$config['extends_class']}\n{\n",
            $input);
        
        $ret =  preg_replace(
            '/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n).*(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s',
            $body,$input);
        
        if (!strlen($ret)) {
            return $this->gen->raiseError(
                "PREG_REPLACE failed to replace body, - you probably need to set these in your php.ini\n".
                "pcre.backtrack_limit=1000000\n".
                "pcre.recursion_limit=1000000\n"
                ,null, PEAR_ERROR_DIE);
        }
        
        return $ret;
    }
        
         
    
    function toIniString()
    {
        $ret = "[{This->table}]\n";
        foreach($this->columns as $c) {
            if ($c->is_name_invalid) {
                continue;
            }
            $ret .= "{$c->name} = {$c->do_type}\n";
            
            
        }
        $ar = $this->toIniSequenceArray();
        if (!$ar) {
            return $ret;
        }
        $ret .= "\n[{This->table}__keys]\n";
        foreach($ar as $k=>$v) {
            $ret .= "$k = $v\n";
        }
        return $ret;
       
    }
    /**
     * return the 'table definition' associative array
     *  (refered to as 'keys')
     *
     */
    function toIniKeysArray()
    {
        $kv = array();
        foreach($this->columns as $c) {
            if ($c->is_name_invalid) {
                continue;
            }
            $kv[$c->name] = $c->do_type;
        }
        return $kv;
    }
    /**
     * return in a format suitable for databaseStructure
     * [table] => array ( col => type, col, type)
     * [table_keys] => array ( col => sequencetype|name )
     */
    function toDatabaseStructureArray()
    {
        $ret = array();
        $ret[$this->table] = $this->toIniKeysArray();
        $seq = $this->toIniSequenceArray();
        if (!empty($seq)) {
            $ret["{$this->table}__keys"] = $seq;
        }
        return $ret;
    }
    
    /**
     * this is the ini array that relates to sequence keys
     *   in the ini file, we output the key column, and the type of sequence (N|nextval_sequence_name)
     *   it can also have 'U' = unquie and 'K' = just a key...
     */ 
    
    function toIniSequenceArray()
    {
        $native = array();
        $other = array();
        foreach($this->columns as $c) {
            if ($c->is_name_invalid) {
                continue;
            }
            if ($c->is_sequence_native) {
                $native[$c->name] = $c->sequence_name == '' ? 'N' : $c->sequence_name;
            } else {
                $other[$c->name] = $c->key_type;
            }
            
        }
        return empty($native) ? $other : $native;
    }
    
    
    function toLinks()
    {
        
    }
    
    
}
