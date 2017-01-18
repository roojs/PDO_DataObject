<?php
/**
 * Generation tools for PDO_DataObject
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
  
 
 /*
 * Security Notes:
 *   This class may use eval to create classes on the fly.
 *   The table name and database name are used to check the database before writing the
 *   class definitions, we now check for quotes and semi-colon's in both variables
 *   so I cant see how it would be possible to generate code even if
 *   for some crazy reason you took the classname and table name from User Input.
 *   
 *   If you consider that wrong, or can prove it.. let me know!
 */
 
 /**
 * 
 * Config _$options
 * [PDO_DataObject]
 * ; optional default = DB/DataObject.php
 * extends_location =
 * ; optional default = DB_DataObject
 * extends =
 * ; alter the extends field when updating a class (defaults to only replacing PDO_DataObject)
 * generator_class_rewrite = ANY|specific_name   // default is PDO_DataObject
 *
 */

/**
 * Needed classes
 * We lazy load here, due to problems with the tests not setting up include path correctly.
 * FIXME!
 */
class_exists('PDO_DataObject') ? '' : require_once 'PDO/DataObject.php';
 
/**
 * Generator class
 *
 * @package PDO_DataObject
 */
class PDO_DataObject_Generator extends PDO_DataObject
{
    
    
    
     /* ---------------- ---------------- static  -------------------------------- */
    /**
     * Configuration - use config() to access this.
     *
     * @access  private
     * @static
     * @var     array
     */
    private static $config = array(
            
         
        
        // ---- Generator
              
            'build_views' => false,
                // for postgres, you can build dataobjects for views as well
                // you can set this to 'schema.views' to extract views with schema information
                // I believe  postgres also supports updating on views (nice feature)
                // *** NOTE *** You will have to manually define keys() / sequenceKeys()
                // As the generator can not recognize these automatically
                
            'strip_schema' => true,
                //	postgres has a wierd concept of schema's which end up prefixed to
                //	the list of tables. - this makes a mess of class/schema generation
                //	setting this to '', makes the generator strip the schema from the table name.
                //  now supports regex (if you set it to a regex it will strip schema of matched names)
                //  for example '/^public\./'
            'embed_schema' => false,
                // (True) will generate the methods tableColumns() ,keys(), sequenceKeys() and defaults()
                // methods in the generated classes 
                // and not generate any ini file to describe the table.
                
            'extends_class' => 'PDO_DataObject',
                // what class do the generated classes extend?
            'extends_class_location' => 'PDO/DataObject.php',
                // what file is the extended class in.                
        
            'generate_links' => false,
                // generate .link.ini files based on introspecting the database.
        
        // advanced customization..
            'hook' => 'PDO_DataObject_Generator_Hooks',
                // class for hooks code (used to be derivedHook****)
                // allows custom generation of PHP code.
                // can be class name or object
            'table_gen_class' => 'PDO_DataObject_Generator_Table',
                // class for table parsing/ generator
                // allows for more custom generaton.
                // if you use a custom class - you must include it before loading..
            'var_keyword' => 'public',
                // var|public  - (or private if you want to break things)
                // The variable prefix that is used when class properties are created
                //  the default is public 
            'add_database_nickname' => false,
                // add the line public $_database_nickname = .... (disabled by default)
            'no_column_vars' => false,
                // (True) prevents writing of private/var's so you can overload get/set 
                // note: this has the downside of making code less clear... (alot of magic!!)
            'setters' => false,
            	// (true) will generate setXXXX() methods for you.
            'getters' => false,
            	// (true) will generate getXXXX() methods for you.
            'add_defaults' => false,
                // add a method defaults() - that returns the default value for each column.
            'link_methods'  =>false,
                // (true|callable) will create the wrappers around link()
                // => function($k) { return $k; } // to munge the column name into a method name.
                // Only likely to work with with mysql / mysqli / postgres  at present. ?? maybe sqlite?
            'secondary_key_match' => 'primary|unique',
                // if a column is auto-increment or nextval() - then it's determined to be a sequence key
                // if it's only primary or unique - then it's assumed to be an index, but using emulated sequences keys.
            'include_regex' => false,
                // regex to match table names = if set, then only table names matching will be generated
            'exclude_regex' => false,
                // regex to match table names = if set, then matching tables will not be generated
                
    );
      /**
     * Set/get the generator configuration...
 
     * Usage:
     *
     * Fetch the current config.
     * $cfg = PDO_DataObject_Generator::config(); 
     *
     * SET a configuration value. (returns old value.)
     * $old = PDO_DataObject_Generator::config('schema_location', '');  
     *
     * GET a specific value ** does not do this directly to stop errors...
     * somevar = PDO_DataObject_Generator::config()['schema_location'];  
     *
     * SET multiple values (returns 'old' configuration)
     * $old_array = PDO_DataObject_Generator::config( array( 'schema_location' => '' ));
     * 
     * 
     * @param   array  key/value 
     * @param   mixed value 
     * @static
     * @access  public
     * @return - the current config (or previous value/config) 
     */
     
    static function config($cfg_in = array(), $value=false) 
    {
         
        if (!func_num_args()) {
            return self::$config;
        }
        
        if (!is_array($cfg_in) && func_num_args() < 2) {
            // one arg = not an array..
            (new PDO_DataObject())->raise("Invalid Call to config should be string+anther value or array",
                              self::ERROR_INVALIDARGS);
        }
        
        $old = self::$config;
        
        $cfg = $cfg_in;
        
        if (func_num_args() > 1) {
            // two args..
            if (!is_string($cfg_in)) {
                (new PDO_DataObject())->raise("Invalid Call to config should be string+anther value or array",
                              self::ERROR_INVALIDARGS);    
            }
            
            $k = $cfg_in;
            $cfg = array();
            $cfg[$k] = $value;
        } 
          
        foreach ($cfg as $k=>$v) {
            if (!isset(self::$config[$k])) {
                (new PDO_DataObject())->raise("Invalid Configuration setting : $k",
                        self::ERROR_INVALIDCONFIG);
            }
            self::$config[$k] = $v;
        }
        
        
        return is_array($cfg_in) ? $old : $old[$cfg_in];
    }
    /**
     * Associate Array of table names => Table Objects
     *
     * @var array
     * @access private
     */
    var $tables = array();
    
    
    /**
     * Constructor
     *  - although it extends PDO_DataObject, the ctor behavior is slightly different
     *    it expects a database nickname (optiontally)
     * @param string database nickname
     */
    function __construct($cfg = false)
    {
        if ($cfg !== false) {
            $this->databaseNickname($cfg);
        }
        
        $hook = self::$config['hook'];
        if (is_object($hook)) {
            $this->hook = $hook;
            return;
        }
        if ($hook == 'PDO_DataObject_Generator_Hooks') {
            class_exists($hook) ? '' :
                require_once 'PDO/DataObject/Generator/Hooks.php';
        }
        if (!class_exists($hook)) {
            $this->raise("Hook class '{$hook}' does not exist - please include it or use an autoloader");
        }
        $this->hook = new $hook($this);
    }
    
    
    /**
     * The 'starter' = call this to start the process
     *
     * @access  public
     * @return  none
     */
    function start()
    {
        $options = PDO_DataObject::config();
        
        $databases = array();
        if (!empty($options['databases'])) {
            $databases  = $options['databases'];
        }
        
        
        if (!empty($options['database'])) {
            // ctor without table...
            $do = new PDO_DataObject();
            $dname = $do->databaseNickname();
            
            
            if (!isset($database[$dname])){
                $databases[$dname] = $options['database'];
            }
        }

        
        foreach($databases as $databasename => $database) {
            if (!$database) {
                continue;
            }
            $this->debug("CREATING FOR $databasename\n",__FUNCTION__,1);
            $class = get_class($this);
            $t = new $class();
            $t->_database_dsn = $database;
            $t->databaseNickname( $databasename);
            
            $t->readTableList();
 

            foreach(get_class_methods($class) as $method) {
                if (substr($method,0,8 ) != 'generate') {
                    continue;
                }
                $this->debug("calling $method");
                $t->$method();
            }
        }
        $this->debug("DONE\n\n");
    }

  /**
     *  
     * 'proxy' version of databaseStructure - this is not so 'speed sensitive'
     * only used when
     * b) proxy is set..
     
    *
     *  - set's the structure.. and the links data..
          
     *
     * obviously you dont have to use ini files.. (just return array similar to ini files..)
     *  
     * It should append to the table structure array 
     *
     *     
     * @param optional string  name of database to assign / read
     * @param optional array   structure of database, and keys
     * @param optional array  table links
     * @return (varies) - depends if you are setting or getting...
     */
    
    function databaseStructureProxy($database, $table = false)
    {
        
        $this->databaseNickname( $database );
        $this->PDO();
        $this->readTableList();
         
            // prevent recursion...
            
        $old = PDO_DataObject::config('proxy', false);
        $ret = $this->databaseStructure(); 
        PDO_DataObject::config('proxy', $old);
        return $ret;
            // databaseStructure('mydb',   array(.... schema....), array( ... links')
         
            // will not get here....
    }    
    
     /**
     * create an instance of introspection. 
     * - manual set
     * - proxy
     * - ini_****
     */
    function introspection()
    {
        
        $type  = $this->PDO()->getAttribute(PDO::ATTR_DRIVER_NAME);
        if (empty($type)) {
            throw new Exception("could not work out database type");
        }
        $class = 'PDO_DataObject_Introspection_'. $type;
        class_exists($class)  ? '' : require_once 'PDO/DataObject/Introspection/'. $type. '.php';
        $this->debug("Creating Introspection for $class", "_introspection");
        return new $class( clone($this) ); /// clone so we can run multipel queries?
       
    }

    
   
    /**
     * Build a list of tables and definitions.;
     * and store it in $this->tables and $this->_definitions[tablename];
     *
     * @access  public
     * @return  Array of tables
     */
    function readTableList()
    {
        $options = self::config();
        
        $pdo = $this->PDO();
        $io  = $this->introspection();
        
        $tables = array();
        
        // try schema first...
        try {
            $tables = $io->getListOf('schema.tables');
        } catch (Exception $e) {     
        }
        
        if (empty($this->tables)) {
            $tables = $io->getListOf('tables');
        }
        
 
        // build views as well if asked to.
        if (!empty($options['build_views'])) {
            $views =$io->getListOf(
                    is_string($options['build_views']) ?
                                $options['build_views'] : 'views'
            );
            
            $tables = array_merge ($tables, $views);
        }
       
        

        // declare a temporary table to be filled with matching tables names
        $tmp_table = array();


        foreach($tables as $table) {
            if ($options['include_regex'] &&
                    !preg_match($options['include_regex'],$table)) {
                $this->debug("SKIPPING (include_regex) : $table", __FUNCTION__,1);
                continue;
            } 
            
            if ($options['exclude_regex'] &&
                    preg_match($options['exclude_regex'],$table)) {
                $this->debug("SKIPPING (exclude_regex) : $table", __FUNCTION__,1);
                continue;
            }
            
            $strip = $options['strip_schema'];
            $strip = (is_string($strip) && strtolower($strip) == 'true') ? true : $strip;
        
            // postgres strip the schema bit from the
            if (!empty($strip) ) {
                
                if (!is_string($strip) || preg_match($strip, $table)) { 
                    $bits = explode('.', $table,2);
                    $table = $bits[0];
                    if (count($bits) > 1) {
                        $table = $bits[1];
                    }
                }
            }
            $this->debug("EXTRACTING : $table");
            
            // we do not quote table - as these are now internal methods - and it is done by the introspection classes 
            $this->tables[$table] = $this->newTable($table);
            
            
             


        }
        return array_keys($this->tables);
         
        //print_r($this->_definitions);
    }
    
    
    /**
     * Create an instance of the table class (which can be specified in config[table_gen_class])
     *
     * 
     *
     */
    function newTable($name)
    {
        $tcls = self::$config['table_gen_class'];
        
        if ($tcls == 'PDO_DataObject_Generator_Table') {
            class_exists($tcls) ? '' :
                require_once 'PDO/DataObject/Generator/Table.php';
        }
        if (!class_exists($tcls)) {
            $this->raise("Table class '{$tcls}' does not exist - please include it or use an autoloader");
        }
        return new $tcls($this,$name);
    }
    /**
     * fetch the content of '.ini' files with database schema in them.
     *
     * @access  public
     * @return  none
     */    

    function toIni()
    {
        $out = '';
        foreach($this->tables as $table) {
            $out .= $table->toIniString();
        }
        return $out;
    }

    /**
     * Create '.ini' files with database schema in them.
     *
     * @access  public
     * @return  none
     */
    function generateIni()
    {
        $this->debug("Generating Definitions INI file:        ");
        if (!$this->tables) {
            $this->debug("-- NO TABLES -- \n");
            return;
        }

        $options = PDO_DataObject::config();

        
        if (empty($options['schema_location']) ) {
            return;
        }
        
        if (!empty($options['generator_no_ini'])) { // built in ini files..
            return;
        }
        
        $out = $this->toIni();

        $this->PDO();
        // dont generate a schema if location is not set
        // it's created on the fly!

        // where to generate the schema...
        $base = $options['schema_location'];
        
        if (is_array($base)) {
            if (!isset($base[$this->_database_nickname])) {
                $this->raise("Could not find schema location from config[schema_location] - array but no matching database",
                    PDO_DataObject::ERROR_INVALIDCONFIG);
            }
            $base =  explode(PATH_SEPARATOR, $base[$this->_database_nickname])[0]; // get the first path...

            $file = $base[$this->_database_nickname];
        } else {
            $base =  explode(PATH_SEPARATOR, $options['schema_location'])[0]; // get the first path...

            $file = "{$base}/{$this->_database_nickname}.ini";
        }
        
       
        $this->debug("Writing ini as {$file}\n");
        //touch($file);
        $tmpname = tempnam(session_save_path(),'PDO_DataObject_');
        //print_r($this->_newConfig);
        $fh = fopen($tmpname,'w');
        if (!$fh) {
            return $this->raise(
                "Failed to create temporary file: $tmpname\n".
                "make sure session.save_path is set and is writable\n"
                ,null);
        }
        fwrite($fh,$out);
        fclose($fh);
        $perms = file_exists($file) ? fileperms($file) : 0755;
        // windows can fail doing this. - not a perfect solution but otherwise it's getting really kludgy..
         if (!file_exists(dirname($file))) {
            mkdir(dirname($file), $perms, true);
        }
        if (!@rename($tmpname, $file)) { 
            unlink($file); 
            rename($tmpname, $file);
        }
        chmod($file,$perms);


    }
 
    
    function toLinksIni()
    {
        $out = '';
        foreach($this->tables as $tn=>$table) {
            $out .= $table->toLinksIni();
        }
        return $out;

        
    }
    
    /**
     * generate Foreign Keys (for links.ini) 
     * Currenly only works with mysql / mysqli
     * to use, you must set option: generate_links=true
     * 
     * @author Pascal Sch�ni 
     */
    function generateForeignKeys() 
    {
        
        if (!self::$config['generate_links']) {
            return false;
        }
        $type  = $this->PDO()->getAttribute(PDO::ATTR_DRIVER_NAME);

        
        if (!in_array($type  , array('mysql', 'mysqli', 'pgsql'))) {
            return $this->raise("config[generate_links] only works currently with pgsql and mysql");
            
        }
        $this->debug("generateForeignKeys: Start");
        
        $out = $this->toLinksIni(); 

        $options = PDO_DataObject::config();

 // where to generate the schema...
        $base = $options['schema_location'];
        
        if (is_array($base)) {
            if (!isset($base[$this->_database_nickname])) {
                $this->raise("Could not find schema location from config[schema_location] - array but no matching database",
                    PDO_DataObject::ERROR_INVALIDCONFIG);
            }
            $base =  explode(PATH_SEPARATOR, $base[$this->_database_nickname])[0]; // get the first path...

            $file =  preg_replace('/\.ini/','.links.ini' , $base[$this->_database_nickname]);
        } else {
            $base =  explode(PATH_SEPARATOR, $options['schema_location'])[0]; // get the first path...

            $file = "{$base}/{$this->_database_nickname}.links.ini";
        }

      

        $this->debug("Writing ini as {$file}\n");
        
        //touch($file); // not sure why this is needed?
        $tmpname = tempnam(session_save_path(),'PDO_DataObject_');
       
        $fh = fopen($tmpname,'w');
        if (!$fh) {
            return $this->raise(
                "Failed to create temporary file: $tmpname\n".
                "make sure session.save_path is set and is writable\n"
                ,PDO_DataObject::ERROR_INVALIDCONFIG);
        }
        fwrite($fh,$out);
        fclose($fh);
        
        $perms = file_exists($file) ? fileperms($file) : 0755;

        if (!file_exists(dirname($file))) {
            mkdir(dirname($file),$perms, true);
        }
        
        // windows can fail doing this. - not a perfect solution but otherwise it's getting really kludgy..
        if (!@rename($tmpname, $file)) { 
            unlink($file); 
            rename($tmpname, $file);
        }
        chmod($file, $perms);
    }

      
    function toPhp($tablename)
    {
        return  $this->tables[$tablename]->toPhp('');
    
        
    }
    
    
    
    /*
     * building the class files
     * for each of the tables output a file!
     */
    function generatePhp()
    {
        //echo "Generating Class files:        \n";
        $options = self::config();
        

        foreach($this->tables as $table) {
            
            
            $cn = $table->toPhpClassName();
            $fn = $table->toPhpFileName();
            
            $oldcontents = '';
            if (file_exists($fn)) {
                $oldcontents = file_get_contents($fn);
            }
            
            $out = $table->toPhp($oldcontents);
            
            $this->debug( "writing $cn\n");
            $tmpname = tempnam(session_save_path(),'PDO_DataObject_');
       
            $fh = fopen($tmpname, "w");
            if (!$fh) {
                return $this->raise(
                    "Failed to create temporary file: $tmpname\n".
                    "make sure session.save_path is set and is writable\n"
                    ,null);
            }
            fputs($fh,$out);
            fclose($fh);
            $perms = file_exists($fn) ? fileperms($fn) : 0755;
            if (!file_exists(dirname($fn))) {
                mkdir(dirname($fn),$perms, true);
            }
            
            // windows can fail doing this. - not a perfect solution but otherwise it's getting really kludgy..
            if (!@rename($tmpname, $fn)) {
                unlink($fn); 
                rename($tmpname, $fn);
            }
            
            chmod($fn, $perms);
        }
        //echo $out;
    }
   
    
    /**

    /**
    * getProxyFull - create a class definition on the fly and instantate it..
    *
    * similar to generated files - but also evals the class definitoin code.
    * 
    * 
    * @param   string database name
    * @param   string  table   name of table to create proxy for.
    * 
    *
    * @return   object    Instance of class. or PEAR Error
    * @access   public
    */
    function getProxyFull($database,$table) 
    {
        
        $this->_database = $database;
        // might produce error??
        if (!isset($this->tables[$table])) {
            $this->tables[$table] = $this->newTable($table);
        }
        $tbl  = $this->tables[$table] ;
        
        $classname = $tbl->toPhpClassName();
        $out = $tbl->toPhp('');
        //echo $out;
        eval('?>'.$out);
        return new $classname;
        
    }
     
     
    
}
