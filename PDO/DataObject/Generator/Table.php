<?php
/**
 *
 *
 */

class PDO_DataObject_Generator_Table {
   
    var $gen; // generator.
    var $hook;
    var $table= ''; // name of table..
    var $cols = array();
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
    function getClassNameFromTableName()
    {
        $class_prefix_ar  = explode(PATH_SEPERATOR, PDO_DataObject::config('class_prefix'));
        return  $class_prefix_ar[0].preg_replace('/[^A-Z0-9]/i','_',ucfirst(trim($this->table)));
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
        
        class_exists('PDO_DataObject_Generator_Col') ? '' :
            require_once 'PDO/DataObject/Generator/Column.php';
            
        foreach($defs as $def) {
            if (is_array($def)) {
                $this->cols[] = new PDO_DataObject_Generator_Column($this,$def);
                
            }
        }
        
        $this->gen->databaseStructure($pdo->database_nickname,   $this->toIniArray()  ); 
        
         
    }
    
    function iterateCols($method, $original) {
        $ret = '';
        foreach($this->cols as $c) {
            $ret .= $c->{$method}($original);
        }
    }
    
    function toPhp($original)
    {
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
            $body .= $col->toPhpVar();
        }
        
       
         
        $body .= $this->hook->postVar($defs);

        // THIS IS TOTALLY BORKED old FC creation
        // IT WILL BE REMOVED!!!!! in DataObjects 1.6
        // grep -r __clone * to find all it's uses
        // and replace them with $x = clone($y);
        // due to the change in the PHP5 clone design.
        $static = 'static';
        if ( substr(phpversion(),0,1) < 5) {
            $body .= "\n";
            $body .= "    /* ZE2 compatibility trick*/\n";
            $body .= "    function __clone() { return \$this;}\n";
        }
        
        
        // depricated - in here for BC...
        if (!empty($options['static_get'])) {
            
            // simple creation tools ! (static stuff!)
            $body .= "\n";
            $body .= "    /* Static get */\n";
            $body .= "    $static  function staticGet(\$k,\$v=NULL) { " .
                    "return DB_DataObject::staticGet('{$this->classname}',\$k,\$v = null); }\n";
        }
        // generate getter and setter methods
        $body .= $this->_generateGetters($input);
        $body .= $this->_generateSetters($input);
        $body .= $this->_generateLinkMethods($input);
        /*
        theoretically there is scope here to introduce 'list' methods
        based up 'xxxx_up' column!!! for heiracitcal trees..
        */

        // set methods
        //foreach ($sets as $k=>$v) {
        //    $kk = strtoupper($k);
        //    $body .="    function getSets{$k}() { return {$v}; }\n";
        //}
        
        if (!empty($options['generator_no_ini'])) {
            $def = $this->_generateDefinitionsTable();  // simplify this!?
            $body .= $this->_generateTableFunction($def['table']);
            $body .= $this->_generateKeysFunction($def['keys']);
            $body .= $this->_generateSequenceKeyFunction($def);
            $body .= $this->_generateDefaultsFunction($this->table, $def['table']);
        }  else if (!empty($options['generator_add_defaults'])) {   
            // I dont really like doing it this way (adding another option)
            // but it helps on older projects.
            $def = $this->_generateDefinitionsTable();  // simplify this!?
            $body .= $this->_generateDefaultsFunction($this->table,$def['table']);
             
        }
        $body .= $this->hook->functions($input);

        $body .= "\n    /* the code above is auto generated do not remove the tag below */";
        $body .= "\n    ###END_AUTOCODE\n";


        // stubs..
        
        if (!empty($options['generator_add_validate_stubs'])) {
            foreach($defs as $t) {
                if (!strlen(trim($t->name))) {
                    continue;
                }
                $validate_fname = 'validate' . $this->getMethodNameFromColumnName($t->name);
                // dont re-add it..
                if (preg_match('/\s+function\s+' . $validate_fname . '\s*\(/i', $input)) {
                    continue;
                }
                $body .= "\n    function {$validate_fname}()\n    {\n        return false;\n    }\n";
            }
        }




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


        /* this will only replace extends DB_DataObject by default,
            unless use set generator_class_rewrite to ANY or a name*/

        $class_rewrite = 'DB_DataObject';
        $options = &PEAR::getStaticProperty('DB_DataObject','options');
        if (empty($options['generator_class_rewrite']) || !($class_rewrite = $options['generator_class_rewrite'])) {
            $class_rewrite = 'DB_DataObject';
        }
        if ($class_rewrite == 'ANY') {
            $class_rewrite = '[a-z_]+';
        }

        $input = preg_replace(
            '/(\n|\r\n)class\s*[a-z0-9_]+\s*extends\s*' .$class_rewrite . '\s*(\n|\r\n)\{(\n|\r\n)/si',
            "\nclass {$this->classname} extends {$this->_extends} \n{\n",
            $input);

        $ret =  preg_replace(
            '/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n).*(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s',
            $body,$input);
        
        if (!strlen($ret)) {
            return PEAR::raiseError(
                "PREG_REPLACE failed to replace body, - you probably need to set these in your php.ini\n".
                "pcre.backtrack_limit=1000000\n".
                "pcre.recursion_limit=1000000\n"
                ,null, PEAR_ERROR_DIE);
       }
        
        return $ret;
    }
        
        
        
        // head..
        $ret .= $this->iterateCols('var', $original);
        
    }
    
    function toIni()
    {
        
    }
    function toIniKeysArray() {
    
    }
    
    function toIniArray() {
        $kv = array();
        foreach($this->cols as $c) {
            $kv[$c->name] = $c->do_type;
          
        }
        $ret = array();
        $ret[$this->table] = $kv;
        $add = $this->toIniKeysArray();
        if ($add) {
            $ret[$this->table] = $add;
        }
        return $ret;    
    }
    
    function toIniSequence()
    {
        
    }
    
    
    function toLinks()
    {
        
    }
    
    
}
