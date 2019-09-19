<?php
/**
 * Generation tools for PDO_DataObject
 *  - representation of a table.
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
   
class PDO_DataObject_Generator_Table {
   
    /**
     * @var PDO_DataObject_Generator the Generator calling this.
     */
    var $gen; // generator.
    /**
     * @var PDO_DataObject_Generator_Hook - or a extended version.. - implement your own
     */
    var $hook;
    /**
     * @var string the name of the table that this instance describes
     */
    var $table = ''; // name of table..
    /**
     * @var array  array of PDO_DataObject_Generator_Column -
     */
    var $columns = array();
    /**
     * @var string the classname that this table will be generated to.
     */
    var $classname = '';
    
    /**
     * Constructor
     * Calls database introspection to fill information in.
     * 
     * @param PDO_DataObject_Generator - The calling geneator
     * @param string tablename to introspect and build.
     */
    function __construct($gen, $table)
    {
        $this->gen = $gen;
        $this->hook = $gen->hook;
        $this->table= $table;
        $this->readFromDB();
        $this->classname = $this->toPhpClassName();
       
        
    }
     /**
    * Convert a table name into a class name -> override this if you want a different mapping
    *
    * @access  public
    * @return  string class name;
    */
    function toPhpClassName()
    {
        $class_prefix_ar  = explode(PATH_SEPARATOR, PDO_DataObject::config()['class_prefix']);
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
        
        if (count($base_ar) != 1 || !strlen($base_ar[0])) {
            $this->gen->raise(
                "option[class_location] must be set, and a single location for the generator to work.".
                "Current value is " . var_export($options['class_location'],true),
                PDO_DataObject::ERROR_INVALIDCONFIG
            );
        }
        $base = $base_ar[0];
        if (strpos($base,'%s') !== false) {
            $fn   = sprintf($base, 
                    preg_replace('/[^A-Z0-9]/i','_',ucfirst($this->table)));
        } else { 
            $fn = "{$base}/".preg_replace('/[^A-Z0-9]/i','_',ucfirst($this->table)).".php";
        }
        
        
        return $fn;
        
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
    
    /**
     *
     * read the database schema from the database
     *
     *
     */
    
    function readFromDB() // and set's databaseStructure!?
    {
         
         // a little bit of sanity testing.
        
        $options = PDO_DataObject::config();;
        $pdo = $this->gen->PDO();
     
        // quote table not needed as the intropection classes handle it..
        
        $defs = $this->gen->introspection()->tableInfo($this->table);
         
        
        $this->gen->debug("getting def for {$pdo->dsn['database_name']}/{$this->table}", __FUNCTION__,3);
        $this->gen->debug(print_r($defs,true),'defs',3);
        
        // cast all definitions to objects - as we deal with that better.
        
        class_exists('PDO_DataObject_Generator_Column') ? '' :
            require_once 'PDO/DataObject/Generator/Column.php';
            
        foreach($defs as $def) {
            if (is_array($def)) {
                $this->columns[] = new PDO_DataObject_Generator_Column($this,$def);
                
            }
        }
        
        $this->gen->databaseStructure($this->gen->databaseNickName(),   $this->toDatabaseStructureArray()  ); 
        
         
    }
 
    function toPhp($original)
    {
        $user_code = preg_replace('/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n).*(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s', '', $original);
        
        $config = $this->gen->config();
         
         // title = expand me!
        $foot = "";
        $head = "<?php\n/**\n * Table Definition for {$this->table}\n";
        $head .= $this->hook->pageLevelDocBlock($user_code);
        $head .= " */\n";
        $head .= $this->hook->extendsDocBlock($user_code);

        
        // requires - if you set extends_location = (blank) then no require line will be set
        // this can be used if you have an autoloader
        
        if (!empty($config['extends_class_location'])) {
            $head .= "class_exists('{$config['extends_class']}') ? '' : require_once '{$config['extends_class_location']}';\n\n";
        }
        // add dummy class header in...
        // class 
        $head .= $this->hook->classDocBlock($user_code);
        $head .= "class {$this->classname} extends {$config['extends_class']} \n{";

        $body =  "\n    ###START_AUTOCODE\n";
        $body .= "    /* the code below is auto generated do not remove the above tag if you want to regenerate it */\n\n";
        // table

        $p = str_repeat(' ',max(2, (18 - strlen($this->table)))) ;
    
         
        $var = $config['var_keyword']; 
        
        
        $body .= "    {$config['var_keyword']} \$__table = '{$this->table}';  {$p}// table name\n";
    
       

        // Only include the $_database property if the omit_database_var is unset or false
        
        if ($config['add_database_nickname']) {
            $p = str_repeat(' ',   max(2, (16 - strlen($this->gen->_database_nickname))));
            $body .= "    {$config['var_keyword']} \$_database_nickname = '{$this->gen->_database_nickname}';  {$p}// database name (used with databases[{*}] config)\n";
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
         
        $body .= $this->hook->postVar($this->columns);

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
        
        if (($config['embed_schema'] || $config['add_defaults'])) {
            $tdef = array();
            $kdef = array();
            $sdef = 'array(false,false,false)'; // should only be one fo thieses
            $vdef = array();
            foreach($this->columns as $col) {
                if ($col->is_name_invalid) {
                    continue;
                }
                $tdef[] = $col->toPhpTableFunc();
                
                if ($col->is_sequence) {
                    $sdef = $col->toPhpSequenceFunc();
                }
                if ($col->toPhpDefault() != '') {
                    $vdef[] = $col->toPhpDefault() ;
                }
            }
            foreach($this->toIniSequenceArray() as $k => $v) {
                $kdef[] = var_export($k,true);
            }
            
            
            $schema =  "\n" 
                    . "    function tableColumns()\n" 
                    . "    {\n" 
                    . "         return array(\n"
                    . "             ". implode(",\n             ", $tdef) . "\n"
                    . "         );\n" 
                    . "    }\n"
                    . "    function keys()\n" 
                    . "    {\n" 
                    . "         return array(\n"
                    . "             ". implode(",\n             ", $kdef) . "\n"
                    . "         );\n" 
                    . "    }\n"   
                    . "    function sequenceKey()\n" 
                    . "    {\n" 
                    . "         return ". $sdef . ";\n"
                    . "    }\n";
            $defaults = "\n" 
                    . "    function defaults() // column default values \n" 
                    . "    {\n"
                    . "         return array(\n"
                    . "             ". implode(",\n             ", $vdef) . "\n"
                    . "         );\n" 
                    . "    }\n";
                    
            if ($config['embed_schema']) {
                $body .= $schema;
            }
            $body .=  $defaults;
            
        }
        
        
        $body .= $this->hook->functions($user_code);

        $body .= "\n    /* the code above is auto generated do not remove the tag below */";
        $body .= "\n    ###END_AUTOCODE\n";
         




        $foot .= "}\n";
        $full = $head . $body . $foot;

        if (!$original) {
            return $full;
        }
        if (!preg_match('/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n)/s',$original))  {
            return $full;
        }
        if (!preg_match('/(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s',$original)) {
            return $full;
        }
 
        /* this used to be configurable - */

        $input = preg_replace(
            '/(\n|\r\n)class\s*[a-z0-9_]+\s*extends\s*[a-z0-9_]+\s*(\n|\r\n)\{(\n|\r\n)/si',
            "\nclass {$this->classname} extends {$config['extends_class']}\n{\n",
            $original);
        
        
        
        $input = preg_replace(
            '/(\n|\r\n)class_exists\(\'[a-z0-9_]+\'\)\s*\?\s*\'\'\s*:\s*require_once\s*\'[^\']+\'\s*;(\n|\r\n)+class\s+/si',
            "\nclass_exists('{$this->classname}') ? '' : require_once '{$config['extends_class_location']}';\n\nclass ",
            $input);
        
        
        
        
        $ret =  preg_replace(
            '/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n).*(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s',
            $body,$input);
        
        if (!strlen($ret)) {
            return $this->gen->raise(
                "PREG_REPLACE failed to replace body, - you probably need to set these in your php.ini\n".
                "pcre.backtrack_limit=1000000\n".
                "pcre.recursion_limit=1000000\n"
                ,null);
        }
        
        return $ret;
    }
        
         
    
    function toIniString()
    {
        $ret = "[{$this->table}]\n";
        foreach($this->columns as $c) {
            if ($c->is_name_invalid) {
                continue;
            }
            $ret .= "{$c->name} = {$c->do_type}\n";
            
            
        }
        $ar = $this->toIniSequenceArray();
        if (!$ar) {
            return $ret . "\n";
        }
        $ret .= "\n[{$this->table}__keys]\n";
        foreach($ar as $k=>$v) {
            $ret .= "$k = $v\n";
        }
        $ret.="\n"; 
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
        $this->gen->debug(print_r($ret,true),__FUNCTION__, 2);
        
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
            if ($c->key_type == '') {
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
    
    
    function toLinksIni()
    {
        $ret = array();
        foreach($this->columns as $c) {
            if (strlen($c->foreign_key)) {
                $ret[] = $c->name . ' = ' . $c->foreign_key;
            }
        }
        if (!count($ret)) {
            return '';
        }
        sort($ret);
        return "[{$this->table}]\n" . implode("\n", $ret)."\n\n";
    }
    
    
}
