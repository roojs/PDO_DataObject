<?php
/**
 * Object Based Database Query Builder and data store
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
  
   
 
class PDO_DataObject
{
   /**
    * The Version - use this to check feature changes
    *
    * @access   private
    * @var      string
    */
    public $_PDO_DataObject_version = "@version@";
 
    /* ---------------- ---------------- Constants  -------------------------------- */

    /**
     * these are constants for the get_table array
     * user to determine what type of escaping is required around the object vars.
     */
    const INT = 1;  // does not require ''
    const STR = 2;  // requires ''
    
    const DATE = 4;  // is date 
    const TIME = 8;  // is time 
    const BOOL = 16; // is boolean 
    const TXT  = 32; // is long text 
    const BLOB = 64; // is blob type
     
    const NOTNULL = 128;           // not null col.
    const MYSQLTIMESTAMP = 256;           // mysql timestamps (ignored by update/insert)
    
    /**
    * Used for clarity in methods like delete() and count() to specify that the method should
    * build the condition only out of the whereAdd's and not the object parameters. 
    * use WHERE_ONLY now.. whereadd's only the for easier conversion.
    */
    const WHEREADD_ONLY = true;
    const WHERE_ONLY = true;

    /**
     * used by config[portability]
     */
    
    const PORTABILITY_LOWERCASE =  1;  // from Pear DB compatibility options..
    
    /**
     * 
     * Theses are the standard error codes - 
     * 
     */
    
    const ERROR_INVALIDARGS =   'InvalidArgs';  // wrong args to function
    const ERROR_NODATA =        'NoData';  // no data available
    const ERROR_INVALIDCONFIG = 'InvalidConfig';  // something wrong with the config
    const ERROR_NOCLASS =       'NoClass';  // no class exists
    const ERROR_SET =           'Set';  // set() caused errors when calling set*** methods.
    const ERROR_QUERY =         'Query';  // if query throws an error....
    const ERROR_CONNECT =       'Connect';  // if connect throws an error....

    
    
    
    
    /* ---------------- ---------------- static  -------------------------------- */
    /**
     * Configuration - use PDO_DataObject::config() to access this.
     *
     * @access  private
     * @static
     * @var     array
     */
    private static $config = array(
            
        // connection related    
            'database' => false,
                //  the default database dsn (not PDO standard = see @$_database for details)
                // it's similar format to PEAR::DB..
            
            'databases' => array(),
                // map of database nick-names to connection dsn's
            
            'tables' => array(),
                // map of tables names to database 'nick-names'
                
        // schema (INI files)   
            'schema_location' => false,
                // unless you are using 'proxy' then schema_location is required.
                
                // possible values:
                
                // String = directory, or list of directories (with path Seperator..)
                //         eg. if your database schema is in /var/www/mysite/Myproejct/DataObject/mydb.ini
                //         then schema_location = /var/www/mysite/Myproejct/DataObject/
                //              you can use path seperator if there are multiple paths. and combined           
                
                // Array = map of database names to exact location(s).
                //         eg.
                //         mydb => /var/www/mysite/Myproejct/DataObject/mydb.ini
                //              value can be an array of absolute paths, or PATH_SEPERATED
    
                
    
        // class - factory + load derived classes
            'class_prefix' => 'DataObjects_',
                // Prefix Mapping of table name to PHP Class
                //    to use multiple prefixes seperate them with PATH_SEPERATOR
                //    for 'loading' it will try them all in sequence.. - first found wins.
                //    for the generator it will only use the first..

            'class_location' => '',
                // directory where the Table classes are..
                // you can also use the format
                // /home/me/Projects/myapplication/DataObjects_%s.php  (%s==table)
                // /home/me/Projects/myapplication/DataObjects_%2$s%1$s.php  (%1$s==table) (%2$s==database nickname)
                // and %s gets replaced with the tablename.
                // to use multiple search paths use the PATH_SEPERATOR

            
            'proxy' => false,
                // NOT RECOMMENDED - it's very slow!!!!
                // normally we use pre-created 'ini' files, but if you use proxy, it will generate the
                // the database schema on the fly..
                // true - calls PDO_DataObject_Generator-> ???
                // full - generates dataobjects when you call factory...
                // YourClass::somemethod... --- calls some other method to generate proxy..
            
            
            
            'portability' => 0,
                // similar to DB's portability setting,
                // currently it only lowercases the tablename when you call tableName(), and
                // flatten's ini files ..
            
            'transactions' => true,
                // some databases, like sqlite do not support transactions, so if you have code that
                // uses transactions, and you want DataObjects to ignore the BEGIN/COMMIT/ROLLBACK etc..
                // then set this to false, otherwise you will get errors.

            'quote_identifiers' => false,
                // Quote table and column names when building queries 
 
            'enable_null_strings' => false,
                // This is only for BC support - 
                // previously you could use 'null' as a string to represent a NULL, or even null 
                // however this behaviour is very problematic.
                // 
                // if you want or needto use NULL in your database:
                // use PDO_DataObject::sqlValue('NULL');

		            // BC - not recommended for new code...
                // values true  means  'NULL' as a string is supported      
                // values 'full' means both 'NULL' and guessing with isset() is supported
                
                
        //  NEW ------------   peformance 
             
            'fetch_into' => false,
                // use PDO's fetch_INTO for performance... - not sure what other effects this may have..
            
            // -----   behavior
 
                
            'debug' => 0,
                // debuging - only relivant on initialization - modifying it after, may be ignored.
                
            'PDO' => 'PDO',  
                // what class to use as PDO - we use PDO_Dummy for the unittests

        
        
        // -------- Error handling --------
            
          
        
         

    );
    
    private static $debug = 0; // set by config() and debugLevel()
      
    
    /**
     * Connections [md5] => PDO
     * note - we overload PDO with some values
     *   $pdo->database (as there is no support for it..!)
     */
    private static $connections = array(); // md5 map of connections to DSN
    
    
    // use databaseStructure to set these...
    // mapping of database(??realname??) to ini file results
    private static $ini = array();
    
    //  mapping of database to links file (foreign keys really)
    private static $links = array(); 
    
    // cache of sequence keys ??- used by autoincrement?? -- need to check..
    private static $sequence = array(); 
    
    /**
     * calling set() may throw an exception.
     *  -> you can catch PDO_DataObject_Exception_Set , and check this value to see what failed.
     *
     * @var array the errors (key == the object key, value == the error messages/return from set****)
     *
     */
    public static  $set_errors = false;
  
     
    
    /* ---------------- ---------------- non-static  -------------------------------- */
    
    /**
     * The Database table (used by table extends)
     *
     * @access  semi-private (not recommened - by you can modify it...)
     * @var     string
     */
    public $__table = '';  // database table
    /**
     * The Database nick-name (usually matches the real database name, but may not..)
     * created in __connection
     * Note - this used to be called _database - however it's not guarenteed to be the real database name,
     * for that use PDO()->dsn[database_name]
     *
     * @access  private (ish) - extended classes can overide this
     * @var  string
     */
    public $_database_nickname = false;
 
   
    /* ---------------- ---------------- connecting to the database  -------------------------------- */

    
      

    /**
     * The Database connection id (md5 sum of databasedsn)
     *
     * @access  private (ish) - extended classes can overide this
     * @var     string
     */
    private $_database_dsn_md5 = '';
    
    /**
     * The PDOStatement Result object.  accesable by  result() ????
     * created in _query()
     *
     * @access  private 
     * @var  PDOStatement|StdClass|false
     */
    private $_result = false;
    
    
    

    /**
     * The Number of rows returned from a query
     * false = nothing fetched yet.
     * 0...9999.....  number of rows returned by find/query etc.
     * true = sqlite - not able to find number of results.
     *
     * @access  public
     * @var     int|boolean
     */
    public $N = false;  // Number of rows returned from a query
    
    /**
     * The QUERY rules
     * This replaces alot of the private variables 
     * used to build a query, it is unset after find() is run.
     * 
     *
     * @access  private
     * @var     array
     */
    private $_query = array(
        'condition'   => '', // the WHERE condition
        'group_by'    => '', // the GROUP BY condition
        'order_by'    => '', // the ORDER BY condition
        'having'      => '', // the HAVING condition
        'useindex'   => '', // the USE INDEX condition
        'limit_start' => '', // the LIMIT condition
        'limit_count' => '', // the LIMIT condition
        'data_select' => false, // the columns to be SELECTed (false == '*') the default.
        'derive_table' => '', // derived table name (BETA)
        'derive_select' => '', // derived table select (BETA),
        'unions' => array(), // unions
    );
        
    
     
    
    /**
     * The JOIN condition - this get's modified by extended classes alot
     * 
     *
     * @access  public
     * @var     string
     */
    public $_join = '';

    /**
     * array of links.. - if relivant.
     * NOTE - not sure if we should leave this defined here?? only defined if created by PDO_DataObject_Links
     * Not generally recommended -- JOIN or using the generator is a better method of
     * cross referencing related objects.
     *
     * @access  private
     * @var     boolean | array
     */
    public $_link_loaded = false;
    
    /**
     * Constructor
     * -- not normally used. - use factory to load extended dataObjects.
     *
     * Can be used to create on-the fly DataObjects. not heavily tested yet though...
     * Should be used with config[proxy] = true  
     *
     * Normally you would extend this class an fill it up with methods that relate to actions on that table
     *
     * @param string|array    either tablename or databasename/tablename or array(database,tablename)
     *
     */
    function __construct($cfg = false)
    {
        if ($cfg === false) {
            return;
        }
        
        
        if (self::$debug) {
            $this->debug(json_encode(func_get_args()),  __FUNCTION__,1);
        }
        if (!is_array($cfg)) {
            $cfg = explode('/', $cfg);
        }
        $this->__table = count($cfg) > 1 ? $cfg[1] : $cfg[0];
        if (count($cfg) > 1) {
            $this->_database_nickname = $cfg[0];
        } else if (isset(self::$config['tables'][$this->__table])) {
            
            $this->_database_nickname = self::$config['tables'][$this->__table];
            
        } 
        // should error out if database is not set.. or know..
        $ds = $this->databaseStructure();
        if (!isset($ds[$this->__table])) {
            $this->raise("Could not find INI values for database={$this->_database_nickname} and table={$this->__table}",
                         self::ERROR_INVALIDARGS );
        }
        
        
        
        // should this trigger a tableStructure..
        // if you are using it this way then using 'proxy' = true is probably required..
    }
    
    
    
     /**
     * connects to the database
     *
     *  Uses database DSN to connect
     *
     *  Database specific behaviours relating to connect?
     *   * ?????
     * 
     *
     * @access private
     * @return PDO Object the connection
     */
    final function PDO()
    {
        
        $config = self::config();
         
        // We can use a fake PDO class when testing..
        $PDO = $config['PDO'];
        
        // is it already connected ?    
        if ($this->_database_dsn_md5 && !empty(self::$connections[$this->_database_dsn_md5])) {
            
            $con = self::$connections[$this->_database_dsn_md5];
            
            // connection is an error...?? assumes pear error???
            if (!is_a($con, $PDO)) {
                
                return $this->raise( "Error with cached connection", self::ERROR_INVALIDCONFIG, $con);
                 
            }

            if (empty($this->_database_nickname)) {
                $this->_database = $con->dsn['nickname'];
                
                // note
                // sqlite -- database == basename of database...
                // ibase -- last 4 characters (substring basename, 0, -4 )
                
            }
            
            if (self::$debug) {
                $this->debug("Using Cached connection",__FUNCTION__,4); // occurs quite a lot...
            }
            // theoretically we have a md5, it's listed in connections and it's not an error.
            // so everything is ok!
            return $con;
            
        }

        
        
        $tn = $this->tableName();
        if (!$this->_database_nickname && strlen($tn)) {
            $this->_database_nickname = isset(self::$config['tables'][$tn]) ? self::$config['tables'][$tn] : false;
        }
        if (self::$debug && $this->_database_nickname) {
            $this->debug("Checking for database specific ini ('{$this->_database_nickname}') : config[databases][$this->_database_nickname] in options",__FUNCTION__);
        }
        
        if ($this->_database_nickname && !empty(self::$config['databases'][$this->_database_nickname]))  {
            $dsn = self::$config['databases'][$this->_database_nickname];
        } else if (false !== self::$config['database']) {
            $dsn = self::$config['database'];
        }
    

        // if still no database...
        if (!$dsn) {
            return $this->raise(
                "No database name / dsn found anywhere",
                self::ERROR_INVALIDCONFIG
            );
                 
        }
        
        
        $md5 = md5($dsn); // we used to support array of dsn? - not sure why... as you should use a proxy here...
        
        
        $this->_database_dsn_md5 = $md5;
        // we now have the dsn + 
        
        if (!empty(self::$connections[$md5])) {
            if (self::$debug) {
                $this->debug("USING CACHED CONNECTION", __FUNCTION__,3);
            }
            
            
            
            if (!$this->_database_nickname) {
                $this->_database_nickname = self::$connections[$md5]->dsn['nickname'];
                
            }
            return self::$connections[$md5];
        }

         
        $dsn_ar = parse_url($dsn);

        // create a pdo dsn....
        
        switch($dsn_ar['scheme'] ) {
            case 'sqlite':
            case 'sqlite2':
                $pdo_dsn =      $dsn_ar['scheme'] . ':' .$dsn_ar['path']; // urldec917ode perhaps?
                $dsn_ar['database_name'] = basename($dsn_ar['path']);
                break;
            
            case 'sqlsrv':
                $pdo_dsn =
                    $dsn_ar['scheme'] . ':' .
                    'Database=' . substr($dsn_ar['path'],1) .
                    (empty($dsn_ar['host']) ? '': ';Server=' . $dsn_ar['host']) .
                    (empty($dsn_ar['port']) ? '' : ',' . $dsn_ar['port']);
                $dsn_ar['database_name'] = substr($dsn_ar['path'],1);
                break;
            
            case 'oci':
                
                $pdo_dsn = $dsn_ar['scheme'] . ':';
                $dsn_ar['database_name'] = empty($dsn_ar['path']) ? $dsn_ar['host'] : substr($dsn_ar['path'],1);
                
                switch(true) {
                    
                    // oracle instant client..
                    case (!empty($dsn_ar['host']) && !empty($dsn_ar['port'])):
                        $pdo_dsn .= 'dbname=//' . $dsn_ar['host']. ':'. $dsn_ar['port'] . $dsn_ar['path'];
                        break;
                    
                    // this is from the comments on pdo page...?
                    case (!empty($dsn_ar['host']) && !empty($dsn_ar['path'])):
                        $pdo_dsn .= 'dbname=' . $dsn_ar['host'] . $dsn_ar['path'];
                        break;
                    
                    default:
                        $pdo_dsn .= 'dbname=' .  $dsn_ar['database_name'] ;
                        break;
                }
                break;
              
            // others go here...
        
            default:
                // by default we need to validate a little bit..
                if (empty($dsn_ar['host']) || empty($dsn_ar['path'])  || strlen($dsn_ar['path']) < 2) {
                    return $this->raise("Invalid syntax of DSN : {$dsn}\n". print_r($dsn_ar,true), self::ERROR_INVALIDCONFIG);
                }
                $pdo_dsn =
                    $dsn_ar['scheme'] . ':' .
                    'dbname=' . substr($dsn_ar['path'],1) .
                    (empty($dsn_ar['host']) ? '': ';host=' . $dsn_ar['host']) .
                    (empty($dsn_ar['port']) ? '' : ';port=' . $dsn_ar['port']);
                $dsn_ar['database_name'] = substr($dsn_ar['path'],1);
               break;
            
        }
        if (!empty($dsn_ar['query'])) {
            $pdo_dsn .= ';' . str_replace('&', ';',  $dsn_ar['query']); // could just str_replace..
        }
        $opts = array();
        if (!empty($dsn_ar['fragment'])) {
            // options.. |MYSQL_ATTR_INIT_COMMAND=....|
            $pdo_rc = new ReflectionClass( "PDO" );
            foreach(explode('|', $dsn_ar['fragment']) as $opt) {
                list($k,$v) = explode('=', $opt);
                $opts[$pdo_rc->getConstant($k)] = $v;
                
            }
        }
        
        if (self::$debug) {
            $this->debug("NEW CONNECTION TO DATABASE :" .$dsn_ar['database_name'], __FUNCTION__,3);
            /* actualy make a connection */
            $this->debug(print_r($dsn,true) . ' ' . $pdo_dsn . ' ' . $this->_database_dsn_md5, __FUNCTION__,3);
        }    
            
        $username = isset($dsn_ar['user']) ? urldecode( $dsn_ar['user'] ): '';
        $password = isset($dsn_ar['pass']) ? urldecode( $dsn_ar['pass'] ): '';
        
        // might throw an eror..
        try {
            self::$connections[$md5] = new $PDO($pdo_dsn, $username, $password, $opts );
            self::$connections[$md5]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // just in case?
        } catch (PDOException $ex) {
            $this->debug( (string) $ex , __FUNCTION__,5);
            return $this->raise("Connect failed, turn on debugging to 5 see why", self::ERROR_CONNECT, $ex );
        }
        
        
        
        if (self::$debug) {
            $this->debug(print_r(self::$connections,true), __FUNCTION__,5);
        } 
        
        $dsn_ar['nickname'] = empty($this->_database_nickname) ?
                    $dsn_ar['database_name']  : $this->_database_nickname;
                    
      
        
        self::$connections[$md5]->dsn = $dsn_ar;
        
        if (empty($this->_database_nickname)) {
            $this->_database_nickname =  $dsn_ar['nickname'] ;
        }
         
        // Oracle need to optimize for portibility - not sure exactly what this does though :)
         
        return self::$connections[$md5];
    }

     
    
    
    
    
    /**
     * Set/get the global configuration...
     * Used to be via PEAR::getStaticProperty() - now removed
     *
     * Usage:
     *
     * Fetch the current config.
     * $cfg = PDO_DataObject::config(); 
     *
     * SET a configuration value. (returns old value.)
     * $old = PDO_DataObject::config('schema_location', '');  
     *
     * GET a specific value ** does not do this directly to stop errors...
     * somevar = PDO_DataObject::config()['schema_location'];  
     *
     * SET multiple values (returns 'old' configuration)
     * $old_array = PDO_DataObject::config( array( 'schema_location' => '' ));
     * 
     * 
     * @param   array  key/value 
     * @param   mixed value 
     * @static
     * @access  public
     * @return - the current config..
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
        if (isset($cfg['debug'])) {
            self::$debug = $cfg['debug'];
        }
        
        
        return is_array($cfg_in) ? $old : $old[$cfg_in];
    }
    
     
    
    /* ---------------- ---------------- database  portability methods -------------------------------- */
    /**
     * Quote identifiers - similar to escape - but for identifiers, like column names.
     *
     * @param string $identifier
     * @result string wrapped string  
     *
     */
    final function quoteIdentifier($str)
    {
        $pdo = $this->PDO();
        
        switch($pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            case 'mysql':
                return '`' . str_replace('`', '``', $str) . '`';
            
            case 'mssql':
            case 'sybase':
                return '[' . str_replace(']', ']]', $str) . ']';
            
            default: // pretty much most databases....
                return '"' . str_replace('"', '""', $str) . '"'; // not sure if this works..
            
            
            // some don't suppor it -> msql
            // odbc?? - do we deal with this?
                
        }
        
        
    }
    
    /**
     *
     * modifyLimitQuery - modifies an sql query, filling in the limit's as defined in _query[limit_start / limit_count]
     *
     * Note: the original code does determine 
     *
     * @param string $sql the query to modify
     * @param bool $manip - is the query a manipluation?
     * @return string - the modified string
     * 
     */
    final function modifyLimitQuery($sql, $manip=false)
    {
        $start = $this->_query['limit_start'];
        $count = $this->_query['limit_count'];
        if ($start === '' && $count === '') {
            return $sql;
        }
        $count = (int)$count;
        $start = (int)$start;
        $drv = $this->PDO()->getAttribute(PDO::ATTR_DRIVER_NAME);
        switch($drv) {
            case 'mysql':
                if ($manip && $start) {
                    $this->raise("Mysql may not support offset in modification queries",
                            self::ERROR_INVALIDARGS); // from PEAR DB?
                }
                $start = empty($start) ? '': ($start .',');
                return "$sql LIMIT $start $count";
            
            case 'sqlite':
            case 'sqlite2':
            case 'pgsql':
                return "$sql LIMIT $count OFFSET $start";
            case 'oci':
                if ($manip) {
                    $this->raise("Oracle may not support offset in modification queries",
                            self::ERROR_INVALIDARGS); // from PEAR DB?
                }
                // from http://stackoverflow.com/questions/2912144/alternatives-to-limit-and-offset-for-paging-in-oracle
                // note, it adds an extra column _pdo_rnum.... but we should be able to ingore it.
                return "SELECT * FROM (
                            SELECT
                                rownum _pdo_rnum, pdo_do.* 
                            FROM (
                                {$sql}
                            ) _pdo_do
                            WHERE rownum <= {$start}+{$count}
                        )
                        WHERE rnum >= {$start}
                ";
                
                
            default:
                $this->raise("The Database $drv, does not support limit queries - if you know how this can be added, please send a patch.",
                    self::ERROR_INVALIDARGS); // from PEAR DB?
        }
        
        
    }
    
    
     
 
    /* ============================================================= */
    /*                      Major Public Methods                     */
    /* (designed to be optionally then called with parent::method()) */
    /* ============================================================= */


  
 /**
     * Get a result using key, value.
     *
     * for example
     * $object->get("ID",1234);
     * Returns Number of rows located (usually 1) for success,
     * and puts all the table columns into this classes variables
     *
     * see the fetch example on how to extend this.
     *
     * if no value is entered, it is assumed that $key is a value
     * and get will then use the first key in keys()
     * to obtain the key.
     *
     * @param  mixed  $k column (or primary key value)
     * @param  mixed $v (optional) value
     * @throws PDO_DataObject_Exception
     * @access  public
     * @return  int     No. of rows
     */
    final function get($k = null, $v = null)
    {
       
        $keys = array();
        
        if ($v === null) {
            $v = $k;
            $keys = $this->keys();
            if (!$keys) {
                return $this->raise("No Keys available for table '{$this->tableName()}'", self::ERROR_INVALIDCONFIG);
            }
            $k = $keys[0];
        }
        if (self::$debug) {
            $this->debug('('.var_export($k,true) . ', ' . var_export($v,true) . ') keys= '  .print_r($keys,true), __FUNCTION__);
        }
        
        if ($v === null) {
            return $this->raise("No Value specified for get", self::ERROR_INVALIDARGS);
            
        }
        $this->$k = $v;
 

        return $this->find(true);
    }
      /**
     * Get a result using key, value.
     * Chainable.
     *
     * for example
     * $object->load("ID",1234);
     *
     * and puts all the table columns into this classes variables
     * Note: this also snapshot's the object, ready for update.., and clears any 'where condition'
     *
     * see the fetch example on how to extend this.
     *
     * if no value is entered, it is assumed that $key is a value
     * and get will then use the first key in keys()
     * to obtain the key.
     *
     * @param   string  $k column
     * @param   string  $v value
     * @throws PDO_DataObject_Exception (if not matching row returned)
     * @access  public
     * @return  PDO_DataObject  self.
     */
     final function load($k = null, $v = null)
     {
          $res = 0;          
          if ($k === null && $v === null) {

              $str = $this->whereToString();
              if (!strlen(trim($str))) {
                  $this->raise("No condition (property or where) set for loading data.", self::ERROR_INVALIDARGS);
              }
              $res = $this->find(true);
          } else {
              $res = $this->get($k, $v);
          }
          if ($res < 1) {
              $this->raise("No Data returned from load", self::ERROR_NODATA);
          }
          if ($res > 1) {
              $this->raise("Too many rows returned from load", self::ERROR_INVALIDARGS);
          }
          $this->_query['condition'] = '';
          $this->snapshot();
          return $this;
     }
    
   /**
     * reload (usually called after update or insert)
     * Chainable.
     *
     * for example
     * $object->joinAll()
     *        ->load(1234)
     *        ->set([ 'ex_datetime' => PDO_DataObject::sqlValue('sql', 'NOW()') ])
     *        ->update()
     *        ->reload(true)
     * 
    
     *    
     * It enables you to work on the data after the database has done the update.
     *
     * @param  $autojoin  should auto join be done on the 
     * @throws PDO_DataObject_Exception (if not matching row returned)
     * @access  public
     * @return  PDO_DataObject  fresh copy of the row.
     */
     final function reload($autojoin = false)
     {
          return  $autojoin ?
              $this->factorySelf()->joinAll()->load($this->pid())
              : $this->factorySelf()->load($this->pid());
     }
    
    /**
     * Get the value of the primary id
     *
     * While I normally use 'id' as the PRIMARY KEY value, some database use
     * {table}_id as the column name.
     *
     * To save a bit of typing,
     *
     * $id = $do->pid();
     * 
     * @throws PDO_DataObject_Exception (if the table does not have a pid or is called before insert.)
     * @return the value of the column that is the primary id
     */
    final function pid()
    {
        $keys = $this->keys();
        if (!$keys) {
            
            return $this->raise("No Primary Key available for table '{$this->tableName()}'",
                            self::ERROR_INVALIDCONFIG);

        }
        $k = $keys[0];
        if (empty($this->$k)) { // we do not 
            return $this->raise("pid() called on Object where primary key value not available",
                            self::ERROR_NODATA);
        }
        return $this->$k;
    }
    


    /**
     * build the basic select query. (was _build_select)
     * 
     * @return string the SQL select query built from the properties.
     * @param boolean flag to block recusive calling of unions..
     * @access public
     */
    
    final function toSelectSQL($unions = true)
    {
        $quoteIdentifiers = self::$config['quote_identifiers'];
        
        $tn = ($quoteIdentifiers ? $this->quoteIdentifier($this->tableName()) : $this->tableName()) ;
        
        $data_select = $this->_query['data_select'] === false ? '*' : $this->_query['data_select'];
        
        if (!strlen(trim($data_select))) {
             $this->raise("Select is empty, call select with some arguments", self::ERROR_INVALIDARGS);
        }

        $sql =  trim('SELECT ' . trim($data_select) . "\n" .
            " FROM   $tn  " . $this->_query['useindex'] . " \n" .
            ($this->_join == '' ? '' :               $this->_join . " \n") .
            ($this->_query['condition'] == '' ? '' : ' WHERE ' . $this->_query['condition'] . " \n") .
            ($this->_query['group_by']  == '' ? '' : $this->_query['group_by'] . " \n") .
            ($this->_query['having']    == '' ? '' : $this->_query['having'] . " \n")
        );

        
        // derive table.. not sure how well this is really supported...??
        if (!empty($this->_query['derive_table']) && !empty($this->_query['derive_select']) ) {
            
            // this is a derived select..
            // not much support in the api yet..
            
            $sql  = 'SELECT ' .
               $this->_query['derive_select'] . " \n" .
                   "FROM ( $sql ) " .  $this->_query['derive_table'];
            
            
        }
        
        if ($unions) {
            foreach ($this->_query['unions'] as $union_ar) {  
                 $sql .=  "\n" .  $union_ar[1] . "\n " .  $union_ar[0]->toSelectSQL(false) . " \n";
            }
            $sql .=  $this->_query['order_by']  . " \n";
                
            $sql = $this->modifyLimitQuery($sql);

        }
        
      
        return $sql;
        
    }

     
    /**
     * find results, either normal or crosstable
     *
     * for example
     *
     * $object = new mytable();
     * $object->ID = 1;
     * $object->find();
     *
     *
     * will set $object->N to number of rows, and expects next command to fetch rows
     * will return $object->N
     *
     * if an error occurs $object->N will be set to false and return value will also be false;
     * if numRows is not supported it will return true.
     * 
     * @throws PDO_DataObject_Exception - if run twice on the same object, or tablename missing in class.
     * @param   boolean $n Fetch first result
     * @access  public
     * @return  mixed (number of rows returned, or true if numRows fetching is not supported)
     */
    final function find($n = false)
    {
        
        if ($this->_query === false) {
            return $this->raise(
                "You cannot do two queries on the same object (copy it before finding)", 
                self::ERROR_INVALIDARGS);
            return false;
        }
        
       
        if (self::$debug) {
            $this->debug(var_export($n,true), __FUNCTION__,1);
        }
        
        if (!strlen($this->tableName())) {
            return $this->raise(
                "NO \$__table SPECIFIED in class definition", 
                self::ERROR_INVALIDARGS);
             
        }
        $this->N = 0;
        $query_before = $this->_query;
        $where = $this->whereToString() ;
        $this->where(); //clear existing...
        if (strlen($where)) {
            $this->where($where);
        }
        
       
        $DB = $this->PDO();
        
        $sql = $this->toSelectSQL();
        
     
        
        // this should throw an error if there is a problem..
        $this->query($sql);
       
        if (self::$debug) {
            $this->debug("CHECK autofetched " . var_export($n, true), __FUNCTION__, 1);
        }
        
        
        
        $ret = $this->N;
        if (!$ret && !empty( $this->_result)) {     
            // clear up memory if nothing found!?
           $this->_query = $query_before;
            $this->_result = 0;
            return $ret;
        }
        
        // find(true)
        if ($n && $this->N > 0 ) { // technically in sqlite N=true therefore N>0..
            if (self::$debug) {
                $this->debug("ABOUT TO AUTOFETCH", "find", 1);
            }
            $fs = $this->fetch();
            // if fetch returns false (eg. failed), then the backend doesnt support numRows (eg. ret=true)
            // - hence find() also returns false..
            $ret = ($ret === true) ? $fs : $ret;
        }
        if (self::$debug) {
            $this->debug("DONE", __FUNCTION__, 1);
        }
        $this->_query = $query_before;
        return $ret;
    }

    /**
     * fetches next row into this objects var's
     *
     * returns 1 on success 0 on failure
     *
     *
     *
     * Example
     * $object = new mytable();
     * $object->name = "fred";
     * $object->find();
     * $store = array();
     * while ($object->fetch()) {
     *   echo $this->ID;
     *   $store[] = $object; // builds an array of object lines.
     * }
     *
     * to add features to a fetch
     * function fetch () {
     *    $ret = parent::fetch();
     *    $this->date_formated = date('dmY',$this->date);
     *    return $ret;
     * }
     * @throws PDO_DataObject_Exception called without query being run, 
     * @access  public
     * @return  boolean on success
     */
    final function fetch()
    {

         
        if ($this->N === false) {
            return $this->raise("Fetch Called without Query being run", self::ERROR_INVALIDARGS);
        }
        /*
        Some drivers may return '0' ?? SQLITE???
        if (empty($this->N)) {
            if (self::$debug) {
                $this->debug("No data returned from FIND (eg. N is 0)","FETCH", 3);
            }
            return false;
        }
        */
        
        if ($this->_result === 0 || is_a($this->_result,'StdClass'))
        {
            if (self::$debug) {
                $this->debug('fetched on object after fetch completed (no results found)',__FUNCTION__);
            }
            return false;
        }
        //PDO::FETCH_ASSOC
        
        // fast_fetch - experimentall... - not sure what happens on missing/null values etc.. on rows.
        if (self::$config['fetch_into']) {
            $this->_result->setFetchMode(PDO::FETCH_INTO , $this);
            $array = $this->_result->fetch();
        } else {
            $array = $this->_result->fetch(PDO::FETCH_ASSOC);
            if (self::$debug) {
                $this->debug(json_encode($array),__FUNCTION__);
            }
        }
        
         
        
        if (!$array) {
                
            if (self::$debug) {
                $t= explode(' ',microtime());
            
                $this->debug("Last Data Fetch'ed after " . 
                        number_format($t[0]+$t[1]- $this->_result->time_query_end ,3) . 
                        " seconds",
                   __FUNCTION__, 2);
            }
            //may not be available in sqlite when zero rows returned.. we only find out after a fetch..
            $fields = isset($this->_result->fields) ? $this->_result->fields : array();
            $this->_result->closeCursor();
            $this->_result = new StdClass;
            $this->_result->fields  = $fields;
            return false; // no more data... -- and this fetch did not return any...
             
        }
        static $replace = array('.', ' ');

        if (!isset($this->_result->fields)) {
            
            
            $this->_result->fields = array();
            foreach($array as $k=>$v) {
                $kk =  (strpos($k, '.') === false && strpos($k, ' ') === false) ?
                    $k : str_replace($replace, '_', $k);
                $this->_result->fields[$kk] = 0; // unknown type...
            }

            
            for ($i = 0; $i < $this->_result->columnCount();$i++) {
                 
                $meta = $this->_result->getColumnMeta($i);
                
                if (!$meta) { // not sure what is actually returned if it's not supported by the driver..
                    break;
                }
                $k = $meta['name'];
                $kk =  (strpos($k, '.') === false && strpos($k, ' ') === false) ?
                    $k : str_replace($replace, '_', $k);
                
                $v = 0;
                switch($meta['pdo_type']) { // tried using 'native_type' - just returns junk!
                    // we could be smarter here...
                    case 1:
                        $v = self::INT;
                        break;
                    
                    case 2:
                        $v = self::STR;
                        break;
                    
                    case 5:
                        $v = self::BOOL;
                        break;
                    /*
                    case 'float':
                        $v = self::INT;
                        break;
                    */
                    default:
                        print_r($meta);
                        throw new Exception("Unknown type {$meta['native_type']} ");
    
                }
                $this->_result->fields[$kk] = 0; // unknown type...
            }
                
        }
        
         
        // make sure resultFields is always empty..
        if (!self::$config['fetch_into']) {
            foreach($array as $k=>$v) {
                // use strpos as str_replace is slow.
                $kk =  (strpos($k, '.') === false && strpos($k, ' ') === false) ?
                    $k : str_replace($replace, '_', $k);
                    
                if (self::$debug) {
                    $this->debug("$kk = ". $array[$k], __FUNCTION__, 4);
                }
                $this->$kk = $array[$k];
            }
        }
        // set link flag
        $this->_link_loaded = false;
        if (self::$debug) {
            $this->debug("{$this->tableName()} DONE", __FUNCTION__,2);
        }
        if ($this->_query !== false) {
            $this->_query = false;
        }
        return true;
    }

    
     /**
     * fetches all results as an array,
     *
     * return format is dependant on args.
     * if selectAdd() has not been called on the object, then it will add the correct columns to the query.
     *
     *
     * A) ONE COLUMN ARRAY - Array of values (eg. a list of 'id')
     *
     * $x = PDO_DataObject::factory('mytable');
     * $x->whereAdd('something = 1')
     * $ar = $x->fetchAll('id');
     * -- returns array(1,2,3,4,5)
     *
     * B) ONE COLUMN ARRAY - Fetch the first column (1st argument = true)
     *
     * $x = PDO_DataObject::factory('mytable');
     * $x->select('id')
     * $x->whereAdd('something = 1')
     * $ar = $x->fetchAll(true);
     * -- returns array(1,2,3,4,5)
    
     * C) ONE COLUMN ARRAY - Array of values (using selectAdd)
     *
     * $x = PDO_DataObject::factory('mytable');
     * $x->whereAdd('something = 1');
     * $x->select('distinct(group_id) as group_id');
     * $ar = $x->fetchAll('group_id');
     * -- returns array(1,2,3,4,5)
     *
     *
     * 
     * D) ASSOCIATIVE ARRAY - A key=>value associative array
     *
     * $x = PDO_DataObject::factory('mytable');
     * $x->whereAdd('something = 1')
     * $ar = $x->fetchAll('id','name');
     * -- returns array(1=>'fred',2=>'blogs',3=> .......
     *
     * 
     * E) array of objects -- NO ARGUMENTS
     * $x = PDO_DataObject::factory('mytable');
     * $x->whereAdd('something = 1');
     * $ar = $x->fetchAll();
     
     
     * E) array of associative arrays - No child dataobjects created... fetchAllAssoc()
     * $x = PDO_DataObject::factory('mytable');
     * $x->whereAdd('something = 1');
     * $ar = $x->fetchAll(false,false, true);
     *  returns [ { a=>1 }, {a=>2}, .... ]
     *
     * F) array of associative arrays call by method...
     * $x = PDO_DataObject::factory('mytable');
     * $x->whereAdd('something = 1');
     * $ar = $x->fetchAll(false,false,'toArray');
     *
     *
     * @param    string|false  $k key
     * @param    string|false  $v value
     * @param    string|false  true|$method method to call on each result to get array value (eg. 'toArray')
     * @access  public
     * @return  array  format dependant on arguments, may be empty
     */
    final function fetchAll($k= false, $v = false, $method = false)  
    {
        // should it even do this!!!?!?
        if (!$this->_result) {
            if ($k !== false &&   $this->_query['data_select'] === false) {
                $this->select($k);
                if ($v !== false) {
                    $this->select($v);
                }
            }
            
            $this->find();
        }
        
        if ($method == true) {
            // ignore's key/value.
            $ret = $this->_result->fetchAll(PDO::FETCH_ASSOC);
            if (self::$debug) {
                $this->debug("fetchAll returned: ". json_encode($ret),__FUNCTION__);
            }
            return $ret;
        }
        if ($k === false && $v === false ) {
             
            $ret = array();
            while ($this->fetch()) {
                if ($v !== false) {
                    $ret[$this->$k] = $this->$v;
                    continue;
                }
                $ret[] = $k === false ? 
                    ($method == false ? clone($this)  : $this->$method())
                    : $this->$k;
            }
     
            return $ret;
        }
        
        if ($k === true) { // first column...
            $ret = $this->_result->fetchAll(PDO::FETCH_COLUMN, 0);
            if (self::$debug) {
                $this->debug("fetchAll returned: ". json_encode($ret),__FUNCTION__);
            }
            return $ret;
        }
         $cols = array();
        for($i =0;$i< $this->_result->columnCount(); $i++) {
            $meta = $this->_result->getColumnMeta($i);
            if ($meta['name'] == $k) {
                $cols[0] = $i;
            }
            if ($meta['name'] == $v) {
                $cols[1] = $i;
            }
        }
        if (!isset($cols[0])) {
            return $this->raise("can not find column '{$k}' in results", self::ERROR_INVALIDARGS);
        }
        // in theory this is not 
        if ($v === false) {
            $ret = $this->_result->fetchAll(PDO::FETCH_COLUMN, $cols[0]);
            if (self::$debug) {
                $this->debug("fetchAll returned: (Column {$cols[0]} ". json_encode($ret),1);
            }
            return $ret;
        }
        
        // 2 args..
        if (!isset($cols[1])) {
            return $this->raise("can not find column '{$k}' in results", self::ERROR_INVALIDARGS);
        }
        
        // this is only a bit faster than standard.. - no better way to do this using the PDO API?
        $ret = array();
        while($row = $this->_result->fetch(PDO::FETCH_ASSOC)) {
            if (self::$debug) {
                $this->debug("fetch FETCH_ASSOC: (Columns {$k}/{$v} " . json_encode($row),__FUNCTION__);
            }
            
            $ret[$row[$k]] =  $row[$v];
        }
        return $ret;
         
    }
     /**
     * fetches all results as an array of associative  arrays, without creating Child DataObjects
     *
     * It's an alias for fetchAll(false,false, true)
     * @access  public
     * @return  array  array of associative arrays (note does note create child dataobjects.
     */
    final function fetchAllAssoc()
    {
        return $this->fetchAll(false,false,true);
        
    }
    
    
    /**
     * Adds a condition to the WHERE statement, defaults to AND
     * NOTE : ALWAYS ENSURE ARGUMENTS ARE ESCAPED
 
     *
     * $object->whereAdd(); //reset or cleaer ewhwer
     * $object->whereAdd("ID > 20");
     * $object->whereAdd("age > 20","OR");
     *
     * @param    string  $cond condition or false to reset.
     * @param    string  $logic optional logic "OR" (defaults to "AND")
     * @throws   PDO_DataObject_Exception running on object with results., or invalid arguments
     * @access   public
     * @return   string - previous condition
     */
    final function whereAdd($cond = false, $logic = 'AND')
    {
        // for PHP5.2.3 - there is a bug with setting array properties of an object.
        $_query = $this->_query;
         
        if (!isset($this->_query) || ($_query === false)) {
            return $this->raise(
                "You cannot do two queries on the same object (clone it before finding)", 
                self::ERROR_INVALIDARGS);
        }
        
        if ($cond === false) {
            $r = $this->_query['condition'];
            $_query['condition'] = '';
            $this->_query = $_query;
            return $r;
        }
        // check input...= 0 or '   ' == error!
        if (!trim($cond)) {
            return $this->raise("WhereAdd: No Valid Arguments", self::ERROR_INVALIDARGS);
        }
        $r = $_query['condition'];
        if ($_query['condition']) {
            $_query['condition'] .= " {$logic} ( {$cond} )";
            $this->_query = $_query;
            return $r;
        }
        $_query['condition'] = "( {$cond} ) ";
        $this->_query = $_query;
        return $r;
    }
    
     /**
     * Adds a condition to the WHERE statement, defaults to AND,
     * Chained verions of whereAdd()
     * NOTE : ALWAYS ENSURE ARGUMENTS ARE ESCAPED
     *
     * $object->where()
     *     ->where("ID > 20");
     *     ->where("age > 20","OR");
     *
     * @param    string  $cond condition or false to reset.
     * @param    string  $logic optional logic "OR" (defaults to "AND")
     * @access   public
     * @return   PDO_DataObject - self
     */
    
    final function where($cond = false, $logic = 'AND')
    {
        $this->whereAdd($cond, $logic);
        return $this;
    }

    /**
    * Adds a 'IN' condition to the WHERE statement
    * NOTE : ALWAYS ENSURE KEY IS ESCAPED
    *
    * $object->whereAddIn('id', $array, 'int'); //minimal usage
    * $object->whereAddIn('price', $array, 'float', 'OR');  // cast to float, and call whereAdd with 'OR'
    * $object->whereAddIn('name', $array, 'string');  // quote strings
    *
    * @param    string  $key  key column to match
    * @param    array  $list  list of values to match
    * @param    string  $type  string|int|integer|float|bool  cast to type. 
    * @param    string  $logic optional logic to call whereAdd with eg. "OR" (defaults to "AND")
    * @access   public
    * @return   string previous condition or Error when invalid args found
    */
    final function whereAddIn($key, $list, $type, $logic = 'AND') 
    {
        $not = '';
        if ($key[0] == '!') {
            $not = 'NOT ';
            $key = substr($key, 1);
        }
        // fix type for short entry. 
        $type = $type == 'int' ? 'integer' : $type; 
  
        $PDO =  ($type == 'string')  ? $this->PDO() : false;
        $ar = array();

        foreach($list as $k) {
            settype($k, $type);
            $ar[] = $type == 'string' ? $PDO->quote($k) : $k;
        }
      
        if (!$ar) {
            return $not ? $this->_query['condition'] : $this->whereAdd("1=0");
        }
        return $this->whereAdd("$key $not IN (". implode(',', $ar). ')', $logic );    
    }

    /**
    * Adds a 'IN' condition to the WHERE statement
    * Chained verions of whereAddIn()
     * NOTE : ALWAYS ENSURE KEY IS ESCAPED

    * $object->whereAddIn('id', $array, 'int'); //minimal usage
    * $object->whereAddIn('price', $array, 'float', 'OR');  // cast to float, and call whereAdd with 'OR'
    * $object->whereAddIn('name', $array, 'string');  // quote strings
    *
    * @param    string  $key  key column to match
    * @param    array  $list  list of values to match
    * @param    string  $type  string|int|integer|float|bool  cast to type. 
    * @param    string  $logic optional logic to call whereAdd with eg. "OR" (defaults to "AND")
    * @access   public
    * @return   PDO_DataObject - self
    */
    final function whereIn($key, $list, $type, $logic = 'AND') 
    {
        $this->whereAddIn($key,$list,$type, $logic);
        return $this;
    }
    
    /**
     * Adds a order by condition (Chainable)
     * NOTE : ALWAYS ENSURE ARGUMENTS ARE ESCAPED
     *
     * $object->orderBy(); //clears order by
     * $object->orderBy("ID");
     * $object->orderBy("ID,age");
     *
     * @param  string $order  Order
     * @access public
     * @return PDO_DataObject self
     */
    final function orderBy($order = false)
    {
        if ($this->_query === false) {
            return $this->raise(
                "You cannot do two queries on the same object (copy it before finding)", 
                self::ERROR_INVALIDARGS);
        }
        if ($order === false) {
            $this->_query['order_by'] = '';
            return $this;
        }
        // check input...= 0 or '    ' == error!
        if (!trim($order)) {
            return $this->raise("orderBy: No Valid Arguments", self::ERROR_INVALIDARGS);
        }
        
        if (!$this->_query['order_by']) {
            $this->_query['order_by'] = " ORDER BY {$order} ";
            return $this;
        }
        $this->_query['order_by'] .= " , {$order}";
        return $this;
    }

    /**
     * Adds a group by condition (Chainable)
     * NOTE : ALWAYS ENSURE ARGUMENTS ARE ESCAPED
     * 
     * $object->groupBy(); //reset the grouping
     * $object->groupBy("ID DESC");
     * $object->groupBy("ID,age");
     *
     * @param  string  $group  Grouping
     * @access public
     * @return PDO_DataObject self
     */
    final function groupBy($group = false)
    {
        if ($this->_query === false) {
            return $this->raise(
                "You cannot do two queries on the same object (copy it before finding)", 
                self::ERROR_INVALIDARGS);
        }
        if ($group === false) {
            $this->_query['group_by'] = '';
            return $this;
        }
        // check input...= 0 or '    ' == error!
        if (!trim($group)) {
            return $this->raise("groupBy: No Valid Arguments", self::ERROR_INVALIDARGS);
        }
        
        
        if (!$this->_query['group_by']) {
            $this->_query['group_by'] = " GROUP BY {$group} ";
            return $this;
        }
        $this->_query['group_by'] .= " , {$group}";
        return $this;
    }

    /**
     * Adds a having clause (Chainable)
     * NOTE : ALWAYS ENSURE ARGUMENTS ARE ESCAPED
     *
     * $object->having(); //reset the grouping
     * $object->having("sum(value) > 0 ");
     *
     * @param  string  $having  condition
     * @access public
     * @return PDO_DataObject self
     */
    final function having($having = false, $logic = 'AND' )
    {
        if ($this->_query === false) {
            return $this->raise(
                "You cannot do two queries on the same object (copy it before finding)", 
                self::ERROR_INVALIDARGS);
        }
        if (!in_array($logic,array('AND','OR'))) {
            return $this->raise(
                "Having logic should be AND or OR", 
                self::ERROR_INVALIDARGS);
        }

        if ($having === false) {
            $this->_query['having'] = '';
            return $this;
        }
        // check input...= 0 or '    ' == error!
        if (!trim($having)) {
            return $this->raise("Having: No Valid Arguments", self::ERROR_INVALIDARGS);
        }
        
        
        if (!$this->_query['having']) {
            $this->_query['having'] = " HAVING {$having}";
            return $this;
        }
        $this->_query['having'] .= " {$logic} {$having}";
        return $this;
    }

    /**
     * Adds a using Index (Chainable)
     * NOTE : ALWAYS ENSURE ARGUMENTS ARE ESCAPED
     *
     * $object->useIndex(); //reset the use Index 
     * $object->useIndex("some_index");
     *
     * Note do not put unfiltered user input into theis method.
     * This is mysql specific at present? - might need altering to support other databases.
     * 
     * @param  string|array  $index  index or indexes to use.
     * @access public
     * @return PDO_DataObject self
     */
    final function useIndex($index = false)
    {
        if ($this->_query === false) {
            return $this->raise(
                "You cannot do two queries on the same object (copy it before finding)", 
                self::ERROR_INVALIDARGS);
        }
        if ($index=== false) {
            $this->_query['useindex'] = '';
            return $this;
        }
        // check input...= 0 or '    ' == error!
        if ((is_string($index) && !trim($index)) || (is_array($index) && !count($index)) ) {
            return $this->raise("Having: No Valid Arguments", self::ERROR_INVALIDARGS);
        }
        $index = is_array($index) ? implode(', ', $index) : $index;
        
        if (!$this->_query['useindex']) {
            $this->_query['useindex'] = " USE INDEX ({$index}) ";
            return $this;
        }
        $this->_query['useindex'] =  substr($this->_query['useindex'],0, -2) . ", {$index}) ";
        return $this;
    }
    
    
     /**
     * unionAdd - adds another dataobject to this, building a unioned query.
     *
     * usage:  
     * $doTable1 = PDO_DataObject::factory("table1");
     * $doTable2 = PDO_DataObject::factory("table2");
     * 
     * $doTable1->selectAdd();
     * $doTable1->selectAdd("col1,col2");
     * $doTable1->whereAdd("col1 > 100");
     * $doTable1->orderBy("col1");
     *
     * $doTable2->selectAdd();
     * $doTable2->selectAdd("col1, col2");
     * $doTable2->whereAdd("col2 = 'v'");
     * 
     * $doTable1->unionAdd($doTable2);
     * $doTable1->find();
      * 
     * Note: this model may be a better way to implement joinAdd?, eg. do the building in find?
     * 
     * 
     * @param             $obj       object|false the union object, or false to reset
     * @param    optional $is_all    string 'ALL' to do all.
     * @returns           $obj       object|array the added object, or old list if reset.
     */
    
    final function unionAdd($obj,$is_all= '')
    {
        if ($obj === false ) {
            $ret = $this->_query['unions'];
            $this->_query['unions'] = array();
            return $ret;
        }
        if (!is_object($obj) || !is_a($obj, 'PDO_DataObject')) {
            $this->raise("unionAdd invalid first argument - must be false or an DataObject", self::ERROR_INVALIDARGS);
        }
        $this->_query['unions'][] = array($obj, 'UNION ' . $is_all . ' ') ;
        return $obj;
    }

      /**
     * union  - adds another dataobject to this, building a unioned query.
     * (Chainable)
     * 
     * usage:  
     * $doTable1 = PDO_DataObject::factory("table1");
     * $doTable2 = PDO_DataObject::factory("table2");
     * 
     * $doTable1->selectAdd();
     * $doTable1->selectAdd("col1,col2");
     * $doTable1->whereAdd("col1 > 100");
     * $doTable1->orderBy("col1");
     *
     * $doTable2->selectAdd();
     * $doTable2->selectAdd("col1, col2");
     * $doTable2->whereAdd("col2 = 'v'");
     * 
     * $doTable1->unionAdd($doTable2);
     * $doTable1->find();
      * 
     * Note: this model may be a better way to implement joinAdd?, eg. do the building in find?
     * 
     * 
     * @param             $obj       object   the union object - leave blank to reset.
     * @param    optional $is_all    string 'ALL' to do all.
     * @returns           PDO_DataObject        self
     */
    
    final function union($obj='',$is_all= '')
    {
        $this->unionAdd(func_num_args() ? $obj : false ,$is_all);
        return $this;
    }

    /**
     * Sets the Limit (Chainable)
     *
     * $boject->limit(); // clear limit - returns 'previous settings.
     * $object->limit(12);
     * $object->limit(12,10);
     *
     * Note may result in an error on databases other than mysql/postgress/sqlite
     * as there is no 'clean way' to implement it. - you should consider refering to
     * your database manual to decide how you want to implement it.
     *
     * @param  string $a  limit start (or number), or blank to reset
     * @param  string $b  number
     * @access public
     * @return self  (for chaining) - except 'reset' call
     */
    final function limit($a = null, $b = null)
    {
        
        if ($this->_query === false) {
            return $this->raise(
                "You cannot do two queries on the same object (copy it before finding)", 
                self::ERROR_INVALIDARGS);
            
        }
        // reset
        if (!func_num_args()) {
            $old = $this->_query;
            $this->_query['limit_start'] = '';
            $this->_query['limit_count'] = '';
            return array( $old['limit_start'],$old['limit_count'] );
        }
        // check input...= 0 or '    ' == error!
        if (!is_numeric($a) || (func_num_args() > 1 && !is_numeric($b))) {
            return $this->raise("limit: No Valid Arguments", self::ERROR_INVALIDARGS);
        }
        // used to connect here?? why?
        
        $this->_query['limit_start'] = func_num_args() < 2 ? 0       : (int)$a;
        $this->_query['limit_count'] = func_num_args() < 2 ? (int)$a : (int)$b;
        return $this;
        
    }

    /**
     * Adds a select columns
     * NOTE : ALWAYS ENSURE ARGUMENTS ARE ESCAPED
     *
     * $object->selectAdd(); // resets select to nothing!
     * $object->selectAdd("*"); // default select
     * $object->selectAdd("unixtime(DATE) as udate");
     * $object->selectAdd("DATE");
     *
     * to prepend distict:
     * $object->selectAdd('distinct ' . $object->selectAdd());
     *
     * @param  string  $k
     * @access public
     * @return mixed null or old string if you reset it.
     */
    final function selectAdd($k = null)
    {
        if ($this->_query === false) {
            return $this->raise(
                "You cannot do two queries on the same object (copy it before finding)", 
                self::ERROR_INVALIDARGS);
        }
        if ($k === null) {
            $old = $this->_query['data_select'];
            $this->_query['data_select'] = '';
            return $old === false ? '*' : $old;
        }
        
        // check input...= 0 or '    ' == error!
        if (!trim($k)) {
            return $this->raise("selectAdd: No Valid Arguments", self::ERROR_INVALIDARGS);
        }
        if ($this->_query['data_select'] === false) {        
            $this->_query['data_select'] = '*';
        }
        
        if ($this->_query['data_select']) {
            $this->_query['data_select'] .= ', ';
        }
        $this->_query['data_select'] .= " $k ";
    }
    
    
    
    /**
     * Adds a select columns
     * Chainable Version
     * NOTE : ALWAYS ENSURE ARGUMENTS ARE ESCAPED 
     *
     * Initial behaviour is slightly different to selectAdd()
     * when you call select() with an argument the first time, it will remove the default '*' 
     *
     * $object->selectAdd(); // resets select to nothing!
     * $object->selectAdd("*"); // default select
     * $object->selectAdd("unixtime(DATE) as udate");
     * $object->selectAdd("DATE");
     *
     * to prepend distict:
     * $object->selectAdd('distinct ' . $object->selectAdd());
     *
     * @param  string  $k
     * @access public
     * @return PDO_DataObject self
     */
    final function select($k = null)
    {
        
        if ($k !== null &&  $this->_query['data_select'] === false) {
           $this->_query['data_select'] = '';
        }
        $this->selectAdd($k);
        return $this;
    }
    
    /**
     * Adds multiple Columns or objects to select with formating.
     *
     * $object->selectAs(null); // adds "table.colnameA as colnameA,table.colnameB as colnameB,......"
     *                      // note with null it will also clear the '*' default select
     * $object->selectAs(array('a','b'),'%s_x'); // adds "a as a_x, b as b_x"
     * $object->selectAs(array('a','b'),'ddd_%s','ccc'); // adds "ccc.a as ddd_a, ccc.b as ddd_b"
     * $object->selectAdd($object,'prefix_%s'); // calls $object->get_table and adds it all as
     *                  objectTableName.colnameA as prefix_colnameA
     * $object->selectAdd('another_table','prefix_%s'); // calls $object->get_table and adds it all as
     *                  objectTableName.colnameA as prefix_colnameA
     *
     * @param  array|object|string|null the array or object, or tablename(for factory) to take column names from.
     * @param  string           format in sprintf format (use %s for the colname)
     * @param  string           table name eg. if you have joinAdd'd or send $from as an array.
     * @access public
     * @return PDO_DataObject self
     */
    final function selectAs($from = null,$format = '%s',$tableName=false)
    {
         
        if ($this->_query === false) {
            $this->raise(
                "You cannot do two queries on the same object (copy it before finding)", 
                self::ERROR_INVALIDARGS);
            return false;
        }
        
        if ($from === null) {
            // blank the '*' 
            if ($this->_query['data_select'] === false) {
                $this->_query['data_select'] = '';
            }
            $from = $this;
        }
        
        
        $table = $this->tableName();
      
        if (is_string($from)) {
            $from = self::factory($from);
        }

        if (is_object($from)) {
            $table = $from->tableName();
            $from = array_keys($from->tableColumns());
        }
        
        if ($tableName !== false) {
            $table = $tableName;
        }
        $s = '%s';
        if (self::$config['quote_identifiers']) {
            
            $s      = $this->quoteIdentifier($s);
            $format = $this->quoteIdentifier($format); 
        }
        foreach ($from as $k) {
            $this->select(sprintf("{$s}.{$s} as {$format}",$table,$k,$k) . "\n");
        }
      
        return $this;
    }
    /**
     * Insert the current objects variables into the database
     *
     * Returns the ID of the inserted element (if auto increment or sequences are used.)
     *
     * for example
     *
     * Designed to be extended
     *
     * $object = new mytable();
     * $object->name = "fred";
     * echo $object->insert();
     *
     * @access public
     * @throws PDO_DataObject_Error
     * @return int|boolean  when auto increment or sequence used, otherwise true on success
     */
    final function insert()
    {
          
        // we need to write to the connection (For nextid) - so us the real
        // one not, a copyied on (as ret-by-ref fails with overload!)
         
        
        $PDO = $this->PDO();;
         
        $items = $this->tableColumns();
            
        if (!$items) {
            return $this->raise("insert:No table definition for {$this->tableName()}",
                self::ERROR_INVALIDCONFIG);
            return false;
        }
        
 

        $datasaved = 1;
        $leftq     = '';
        $rightq    = '';
     
        $seqKeys   =  $this->sequenceKey();
        
        $key       = isset($seqKeys[0]) ? $seqKeys[0] : false;
        $useNative = isset($seqKeys[1]) ? $seqKeys[1] : false;
        $seq       = isset($seqKeys[2]) ? $seqKeys[2] : false;
        
        $useEmulated = ($key !== false) && !$useNative; /// make it clear..
        
        $quoteIdentifiers  = self::$config['quote_identifiers'];
         
        // nativeSequences or Sequences..     

        // big check for using sequences
        
        if ($useEmulated) { 
            $this->raise("Emulated Sequences are not supported at present", self::ERROR_INVALIDCONFIG);
        }
        
        // if we haven't set enable_null_strings to "full"
        $ignore_null = self::$config['enable_null_strings'] === false; // default...
                    
             
        foreach($items as $k => $v) {
            
            // if we are using autoincrement - skip the column...
            if ($key && ($k == $key) && $useNative) {
                continue;
                
            }
        
             
            // Ignore INTEGERS which aren't set to a value - or empty string..
            if ( (!isset($this->$k) || ($v == 1 && $this->$k === ''))
                    && $ignore_null
            ) {
                continue;
            }
            // dont insert data into mysql timestamps 
            // use query() if you really want to do this!!!!
            if ($v & self::MYSQLTIMESTAMP) {
                continue;
            }



            if (($v & self::NOTNULL) && self::_is_null_member($this,$k)) {
                $this->raise("Trying to set {$k} to null however it's set as NOT NULL", 
                    self::ERROR_INVALIDARGS);
            }

            if (!isset($this->$k)) {
                // it's a  not null field
                if ($v & self::NOTNULL) {
                    continue;
                }
                // value is not set, and it's not 'defined' as null.....?!?!
                if (!self::_is_null_member($this,$k)) {
                    continue;
                }
                // in theory this is when enable_null_value='full' - and it's notnull - we will insert 'null..
            }
            
            if ($leftq) {
                $leftq  .= ', ';
                $rightq .= ', ';
            }
            
            $leftq .= ($quoteIdentifiers ? ($this->quoteIdentifier($k) . ' ')  : "$k ");

            if (isset($this->$k) && is_object($this->$k) && is_a($this->$k,'PDO_DataObject_Cast')) {
                $value = $this->$k->toString($v,$PDO);
                $rightq .=  $value;
                continue;
            }
            
            if (!($v & self::NOTNULL) && self::_is_null_member($this,$k)) {
                $rightq .= " NULL ";
                continue;
            }

            
            // DATE is empty... on a col. that can be null.. 
            // note: this may be usefull for time as well..
            if (!$this->$k && 
                    (($v & self::DATE) || ($v & self::TIME)) && 
                    !($v & self::NOTNULL)) {
                    
                $rightq .= " NULL ";
                continue;
            }
              
            
            if ($v & self::STR) {
                $rightq .= $PDO->quote((string) (
                        ($v & self::BOOL) ? 
                            // this is thanks to the braindead idea of postgres to 
                            // use t/f for boolean.
                            (($this->$k === 'f') ? 0 : (int)(bool) $this->$k) :  
                            $this->$k
                    )) . " ";
                continue;
            }
            if (is_numeric($this->$k)) {
                $rightq .=" {$this->$k} ";
                continue;
            }
            /* flag up string values - only at debug level... !!!??? */
            if (is_object($this->$k) || is_array($this->$k)) {
                $this->raise("Trying to insert a row - found object used as a column variable ".
                                  print_r(array($k, $this->$k),true), self::ERROR_INVALIDARGS);
                continue;
            }
            
            // at present we only cast to integers
            // - V2 may store additional data about float/int
            $rightq .= ' ' . intval($this->$k) . ' ';

        }
        
        
        
        $dbtype    = $PDO->getAttribute(PDO::ATTR_DRIVER_NAME);
        
        
        // not sure why we let empty insert here.. - I guess to generate a blank row..
        
        
        if (!$leftq && !$useNative) {
            return $this->raise("insert: No Data specifed for query", self::ERROR_NODATA);
        }
        
        $table = ($quoteIdentifiers ? $this->quoteIdentifier($this->tableName())    : $this->tableName());
        
        // simplyfy this...

        if (empty($leftq) && in_array($dbtype, array('pgsql', 'sqlite'))) {
            $r = $this->query("INSERT INTO {$table} DEFAULT VALUES");
        } else {
           $r = $this->query("INSERT INTO {$table} ($leftq) VALUES ($rightq) ");
        }
        
        // query will return rowCount() for insert...
        // mssql may have problems here....
        if ($r < 1) {
            return 0;
        }
        
        
        // now do we have an integer key!
        
        if ($key && $useNative) {
            switch ($dbtype) {
                case 'mysql':
                case 'sqlite': // possibly...
                    $this->$key = $PDO->lastInsertId();
                    break;
                
                case 'mssql':
                    // note this is not really thread safe - you should wrapp it with 
                    // transactions = eg.
                    // $db->query('BEGIN');
                    // $db->insert();
                    // $db->query('COMMIT');
                    $res = $PDO->query("SELECT @@IDENTITY");
                    $this->$key = $res->fetchAll(PDO::FETCH_COLUMN, 0)[0]; // could throw error...
                
                    break; 
                    
                case 'pgsql':
                    if (!$seq) {
                        $this->raise("Could not determine Sequence name for table: " . $this->tableName(),
                                          self::ERROR_INVALIDCONFIG);
                    }
                    $this->$key = $PDO->lastInsertId($seq); // hopefully...
                    
                    break;
               
            }
                    
        }
 
        if ($key) {
            return $this->$key;
        }
        return true;
    }
      

    /**
     * Updates  current objects variables into the database
     * uses the keys() to decide how to update
     * Returns the  true on success
     *
     * for example
     *
     * $object = PDO_DataObject::factory('mytable');
     * $object->get("ID",234);
     * $object->email="testing@test.com";
     * if(!$object->update())
     *   echo "UPDATE FAILED";
     *
     * to only update changed items :
     * $dataobject->get(132);
     * $original = $dataobject; // clone/copy it..
     * $dataobject->setFrom($_POST);
     * if ($dataobject->validate()) {
     *    $dataobject->update($original);
     * } // otherwise an error...
     *
     * performing global updates:
     * $object = PDO_DataObject::factory('mytable');
     * $object->status = "dead";
     * $object->where('age > 150')
     *      ->update(PDO_DataObject::WHERE_ONLY);
     * 
     * NEW in PDO DataObjects 
     *
     * PDO_DataObject::factory('mytable');
     *      ->load(23)
     *      ->snapshot()
     *      ->set(['email' => "test@testing.com"]),
     *      ->save()
     *
     *
     *
     *
     *
     * @param  object|boolean (optional)  dataobject | PDO_DataObject::WHERE_ONLY - used to only update changed items.
     * @access public
     * @throws PDO_DataObject_Error
     * @return  int|true Number rows affected (may be 0), true (if no difference between old/new), false
     */
    final function update($dataObject = false)
    {
 
        // connect will load the config!
        $PDO = $this->PDO();
        
        $original_query =  $this->_query;
        
        $items = $this->tableColumns();
        
        // only apply update against sequence key if it is set?????
        
        $seq    = $this->sequenceKey();
        if ($seq[0] !== false) {
            $keys = array($seq[0]);
            if (!isset($this->{$keys[0]}) && $dataObject !== true) {
                return $this->raise("update: trying to perform an update without 
                        the key set, and argument to update is not 
                        PDO_DataObject::WHERE_ONLY
                    ". print_r(array('seq' => $seq , 'keys'=>$keys), true), self::ERROR_INVALIDARGS);
            }
        } else {
            $keys = $this->keys();
        }
        
         
        if (!$items) {
            return $this->raise("update:No table definition for {$this->tableName()}", self::ERROR_INVALIDCONFIG);
        }
        $datasaved = 1;
        $settings  = '';
        
        
        
        $dbtype    = $PDO->getAttribute(PDO::ATTR_DRIVER_NAME);
        $quoteIdentifiers = self::$config['quote_identifiers'];

        if ($dataObject !== true && !empty($this->_snapshot)) {
            $dataObject = $this->_snapshot;
        }
        
        $ignore_null = self::$config['enable_null_strings'] === false;
                    

        foreach($items as $k => $v) {

            // I think this is ignoring empty vlalues
            if ((!isset($this->$k) || ($v == 1 && $this->$k === ''))
                    && $ignore_null
            ) {
                 continue;
            }
            // ignore stuff thats 
          
            // dont write things that havent changed..
            if (($dataObject !== false) && isset($dataObject->$k) && ($dataObject->$k === $this->$k)) {
                continue;
            }
            
            // - dont write keys to left.!!!
            if (in_array($k,$keys)) {
                continue;
            }
            
             // dont insert data into mysql timestamps 
            // use query() if you really want to do this!!!!
            if ($v & self::MYSQLTIMESTAMP) {
                continue;
            }
            
            //echo "{$k}:isset=".  var_export(isset($this->$k)  ? $this->$k : '--no-set--',true). "\n";
            if (!isset($this->$k)) {
                // it's a  not null field
                if ($v & self::NOTNULL) {
                    continue;
                }
                // value is not set, and it's not 'defined' as null.....?!?!
                if (!self::_is_null_member($this,$k)) {
                    continue;
                }

                // in theory this is when enable_null_value='full' - and it's notnull - we will insert 'null..
            }
            
            if ($settings)  {
                $settings .= ', ';
            }
            
            $kSql = ($quoteIdentifiers ? $this->quoteIdentifier($k) : $k);
            
            if (is_object($this->$k) && is_a($this->$k,'PDO_DataObject_Cast')) {
                $value = $this->$k->toString($v,$PDO);
                $settings .= "$kSql = $value ";
                continue;
            }
            
            // special values ... at least null is handled...
            if (!($v & self::NOTNULL) && self::_is_null_member($this,$k)) {
                $settings .= "$kSql = NULL ";
                continue;
            }
            // DATE is empty... on a col. that can be null.. 
            // note: this may be usefull for time as well..
            if (!$this->$k && 
                    (($v & self::DATE) || ($v & self::TIME)) && 
                    !($v & self::NOTNULL)) {
                    
                $settings .= "$kSql = NULL ";
                continue;
            }
 

            if ($v & self::STR) {
 
                $val = $this->$k;
                if ($v &  self::BOOL) {
                    $val = ($this->$k === 'f') ? 0 : (int)(bool) $this->$k;
                }

                $settings .= "$kSql = ". $PDO->quote((string) $val) . ' ';
                continue;
            }
            if (is_numeric($this->$k)) {
                $settings .= "$kSql = {$this->$k} ";
                continue;
            }
            // at present we only cast to integers
            // - V2 may store additional data about float/int
            $settings .= "$kSql = " . intval($this->$k) . ' ';
        }
         
        
        if (self::$debug) {
            $this->debug("got keys as ".serialize($keys),__FUNCTION__,3);
        }
        $where = isset($this->_query)   && isset($this->_query['condition']) ? $this->_query['condition'] : '';
        
        if ($dataObject !== true) {
            // add's the primary key to the where condition.
            $where = $this->whereToString($items,$keys);
        }
        // at this point we have to have set a condition.. otherwise results could be disasterous...
        
        // prevent wiping out of data!
        if (!strlen($where)) {
            return  $this->raise(
                "updating all records in a table is not enabled by default, use \$do->whereAdd('1=1'); if you really want to do that.",
                self::ERROR_INVALIDARGS);
        }
        
        
        if (!$settings && is_object($dataObject)) {
            // this is a condition where update does not change anything
            // but we do not raise an error as it's a common occurance on posting forms etc...
            $this->_query = $original_query;
            return true;    
        }
        // now if you did an update with no values....
        if (!$settings) {
             $this->raise(
                "update: No Data specifed for query $settings , {$this->_query['condition']}", 
                self::ERROR_NODATA
            );
        }
        
        
                    
        $table = ($quoteIdentifiers ? $this->quoteIdentifier($this->tableName()) : $this->tableName());
    
        // where has to be set... see above...        

        $r = $this->query("UPDATE  {$table}  SET {$settings} WHERE {$where} ");
        
        $this->snapshot(); // store the current state, so any future updates will use that as a comparison..
        // restore original query conditions.
        $this->_query = $original_query;
        
        if ($r < 1) {
            return 0;
        }

         
        return $r;
    
    }
    private $_snapshot = false;

    /**
     *  Save data to database (simple wrapper around insert/update)
     *  recommend it is used with snapshot()
     *  Chainable? 
     * 
     *  Uses primary id to determine if data should be updated or inserted.
     *  @param  PDO_DAtaObject (optional) original snapshot of object, before it was changed.
     *  @returns PDO_DAtaObject  self  
     */
    function save($dataObject = false)
    {
        $keys = $this->keys();
        if (!$keys) {            
            return $this->raise("No Primary Key available for table '{$this->tableName()}'",
                            self::ERROR_INVALIDCONFIG);
        }
        $k = $keys[0];
        if (empty($this->$k)) { 
            $this->insert();
            return $this;
        }
        
        $this->update($dataObject);
        return $this;
    }
    /**
     *  snapshot the objects state (for updating later)
     *  Chainable? 
     * 
     *  When you use 'update' or save, this makes a copy, so you do not need to clone/pass arguments to save or  
     * 
     *  @returns PDO_DAtaObject  self  
     */
    function snapshot()
    {
        $keys = $this->keys();
        if (!$keys) {            
            return $this->raise("No Primary Key available for table '{$this->tableName()}'",
                            self::ERROR_INVALIDCONFIG);
        }
        $k = $keys[0];
        if (empty($this->$k)) { // no need to store originall...
            return;
        }
        $this->_snapshot = clone($this);
        return $this;
    }
  



    /**
     * Deletes items from table which match current objects variables
     *
     * Returns the true on success
     *
     * for example
     *
     * Designed to be extended
     *
     * $object = new mytable();
     * $object->ID=123;
     * echo $object->delete(); // builds a conditon
     *
     * $object = new mytable();
     * $object->whereAdd('age > 12');
     * $object->limit(1);
     * $object->orderBy('age DESC');
     * $object->delete(true); // dont use object vars, use the conditions, limit and order.
     *
     * @param bool $useWhere (optional) If PDO_DataObject::WHERE_ONLY is passed in then
     *             we will build the condition only using the whereAdd's.  Default is to
     *             build the condition only using the object parameters.
     *
     * @access public
     * @return mixed Int (No. of rows affected) on success, false on failure, 0 on no data affected
     */
    final function delete($useWhere = false)
    {
          
        $PDO = $this->PDO();
        $quoteIdentifiers  = self::$config['quote_identifiers'];
        
        // why would we use order by?????
        // I guess if we have dependant elements?!?!? eg. parent's pointing to children...
        $extra_cond = ' ' . (isset($this->_query['order_by']) ? $this->_query['order_by'] : ''); 
        
        $where = !empty($this->_query) && !empty($this->_query['condition']) ?
            $this->_query['condition'] : '';
        
        if (!$useWhere) {

            $keys = $this->keys();
            $old = $this->_query;
            $this->_query = array('condition' => ''); // as it's probably unset!
            
            $where = $this->whereToString($this->tableColumns(),$keys);
            
            $this->_query = $old;
            
            
            //$extra_cond = ''; // why????
        } 
        
        // don't delete without a condition
        if (!strlen($where)) {
            return $this->raise("deleting all data from database is disabled by default, use where('1=1') if you really want to do that.", 
                self::ERROR_INVALIDARGS);
        }
        
        
        
        $table = ($quoteIdentifiers ? $this->quoteIdentifier($this->tableName()) : $this->tableName());
        $sql = "DELETE " .
            (
                (!empty($this->_join) && $useWhere) ?  // using a joined delete. - with useWhere..
                   "{$table} FROM {$table} {$this->_join} " : 
                   "FROM {$table}"
            ) .
              " WHERE " .  $where . $extra_cond;
        
        // add limit..
        $sql = $this->modifyLimitQuery($sql, true);
        
        $r = $this->query($sql);
        
         
        if ($r < 1) {
            return 0;
        }
         
        return $r;
        
    }
 
    /**
     * Find the number of results from a simple query
     *
     * for example
     *
     * $object = new mytable();
     * $object->name = "fred";
     * echo $object->count();
     * echo $object->count(PDO_DataObject::WHERE_ONLY);  // dont use object vars.
     * echo $object->count('distinct mycol');   count distinct mycol.
     * echo $object->count('distinct mycol',PDO_DataObject::WHERE_ONLY); // dont use object vars.
     * echo $object->count('distinct');      // count distinct id (eg. the primary key)
     *
     *
     * @param bool|string  (optional)
     *                  (true|false => see below not on whereAddonly)
     *                  (string)
     *                      "DISTINCT" => does a distinct count on the tables 'key' column
     *                      otherwise  => normally it counts primary keys - you can use 
     *                                    this to do things like $do->count('distinct mycol');
     *                  
     * @param bool      $whereAddOnly (optional) If PDO_DataObject::WHERE_ONLY is passed in then
     *                  we will build the condition only using the whereAdd's.  Default is to
     *                  build the condition using the object parameters as well.
     *                  
     * @access public
     * @return int
     */
    final function count($countWhat = false,$whereAddOnly = false)
    {
        
        if (is_bool($countWhat)) {
            $whereAddOnly = $countWhat;
        }
        
        $t = clone($this);
        $items   = $t->tableColumns();
        
        $quoteIdentifiers = self::$config['quote_identifiers'];
        
        
        if ($t->_query === false) {
            return $this->raise(
                "You cannot do run count after you have run fetch()", 
                self::ERROR_INVALIDARGS);
        }
        
        $PDO = $this->PDO();
        
        $where = $this->_query['condition'];

        if (!$whereAddOnly && $items)  {
            $where = $t->whereToString();
 
        }
        $keys = $this->keys();

        if (empty($keys[0]) && (!is_string($countWhat) || (strtoupper($countWhat) == 'DISTINCT'))) {
            return $this->raise(
                "You cannot do run count without keys - use \$do->count('id'), or use \$do->count('distinct id')';", 
                self::ERROR_INVALIDARGS);
        }
        $table   = ($quoteIdentifiers ? $this->quoteIdentifier($this->tableName()) : $this->tableName());
        $key_col = empty($keys[0]) ? '' : (($quoteIdentifiers ? $this->quoteIdentifier($keys[0]) : $keys[0]));
        $as      = ($quoteIdentifiers ? $this->quoteIdentifier('DATAOBJECT_NUM') : 'DATAOBJECT_NUM');
        
        // support distinct on default keys.
        $countWhat = (strtoupper($countWhat) == 'DISTINCT') ? 
            "DISTINCT {$table}.{$key_col}" : $countWhat;
        
        $countWhat = is_string($countWhat) ? $countWhat : "{$table}.{$key_col}";
        
        $where = strlen(trim($where)) ? "WHERE $where" : '';

        $r = $t->query(
            "SELECT count({$countWhat}) as $as
                FROM $table {$t->_join} $where"
            );
        $l = $t->result()->fetchAll(PDO::FETCH_COLUMN, 0)[0];
        
        if (self::$debug) {
            $this->debug('Count returned '. $l ,__FUNCTION__, 1);
        }
        return (int) $l;
    }

    /**
     * sends raw query to database - returns 
     *
     * set's $this->_result -available publically using $dataobject->result();
     *
     * @param  string  $string  SQL Query
     * @access public
     * @throws PDO_Dataobject_Exception
     * @return PDO_DataObject|int  it'self, or the number of rows affected (insert|update|delete)
     */
    final function query($string)
    {
        $pdo = $this->PDO();

        $dbtype = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

 
        
        
        if (self::$debug) {
            $t= explode(' ',microtime());
            $time = $t[0]+$t[1];
         
            $this->debug( md5($string) . ' : ' . $string,__FUNCTION__);
            $this->debug( "Driver: " . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME), __FUNCTION__, 3);
        }
        
        if (
            strtoupper($string) == 'BEGIN' ||
            strtoupper($string) == 'START TRANSACTION'
        ) {
            if (self::$debug) {
                $this->debug('BEGIN' . (self::$config['transactions'] ? '' : '--IGNORED'),__FUNCTION__);
            }
            if (!self::$config['transactions']) {
                return $this;
            }
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false); // we do not commit by default...
            $pdo->beginTransaction();
            
            return $this;
        }
        
        if (strtoupper($string) == 'COMMIT') {
            if (self::$debug) {
                $this->debug('COMMIT' . (self::$config['transactions'] ? '' : '--IGNORED'),__FUNCTION__);
            }
            if (!self::$config['transactions']) {
                return $this;
            }
            $pdo->commit();
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, true); // not sure if needed...
            return $this;
        }
        
        
        if (strtoupper($string) == 'ROLLBACK') {
            if (self::$debug) {
                $this->debug('ROLLBACK' . (self::$config['transactions'] ? '' : '--IGNORED'),__FUNCTION__);
            }
            if (!self::$config['transactions']) {
                return $this;
            }
            $pdo->rollBack();
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, true); // not sure if needed...
            
            return $this;
        }
        
        
        
        // some sim
      
        
        for ($tries = 0;$tries < 3;$tries++) {
            
            try {
                // not sure if needed..
                if ($dbtype  == 'sqlite') {
                    $result = $pdo->prepare($string);
                    $result->execute();
                } else {
                    $result = $pdo->query($string);
                }
                
                
            } catch (PDOException $e) {
                $this->debug((string)$e, __FUNCTION__,1 );
                $result = $e;
                switch($e->getCode()) {
                    // see http://www.csee.umbc.edu/portal/help/oracle8/server.815/a58231/appd.htm
                    // may need fine tuning...
                    case 1002:
                    case 8000:
                    case 8003:
                    case 8004:
                    case 8006:
                        sleep(1);
                        self::$connections = array(); // reset the connections.
                        $this->PDO();
                        continue;
                }
        
            }
            break;
        }
        

        if (is_a($result,'PDOException')) {
            if (self::$debug) { 
                $this->debug((string)$result, __FUNCTION__,1 );
            }
            $this->N = false;
            return $this->raise("Could not run Query", self::ERROR_QUERY, $result);
        }
        
        $no_results =  $result->rowCount();

        case $dbtype  == 'sqlite':
            case $pdo->getAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY) === false:
                $no_results = true;
                break;
    
            default:
              break;
        }        


        if (self::$debug) {
            $t= explode(' ',microtime());
            $result->time_query_end = $t[0]+$t[1];
            $this->debug('QUERY DONE IN  '.number_format($t[0]+$t[1]-$time,3)." seconds", __FUNCTION__,2);
            $this->debug('NO# of results: '. ($no_results === true ? 'Unknown' : $no_results ), __FUNCTION__,1);
        }
        
        
        switch (strtolower(substr(trim($string),0,6))) {
            case 'insert':
            case 'update':
            case 'delete':
                return $no_results;
        }
        
        // previously we used _DB_resultid as a pointer to a result array..
        // hopefully this will result in better memory management???
        $this->_result = $result;
        switch(true) {
            case $dbtype  == 'sqlite':
            case $pdo->getAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY) === false:
                $this->N = true;
                break;
    
            default:
              $this->N = $result->rowCount();
        }
        
        return $this; // for chaining...
     
    }


    /**
     * an escape string wrapper
     * can be used when adding manual queries or clauses
     * eg.
     * $object->query("select * from xyz where abc like '". $object->escape($_GET['name']) . "'");
     *
     * return value excludes the outer quotes - use $do->PDO->quote($string) - if you want to include them.
     * 
     *
     * @param  string  $string  value to be escaped 
     * @param  bool $likeEscape  escapes % and _ as well. - so like queries can be protected.
     * @access public
     * @return string
     */
    final function escape($string, $likeEscape=false)
    {
        $ret = trim($this->PDO()->quote($string),"'");
        if ($likeEscape) {
            $ret = str_replace(array('_','%'), array('\_','\%'), $ret);
        }
        return $ret;
        
    }

    
    

    /* ============================================================== */
    /*  Table definition layer (started of very private but 'came out'*/
    /* ============================================================== */

    /**
     * Autoload or manually load the table definitions
     *
     *
     * usage :
     * 1 argument - forces generator run..
     * PDO_DataObject::databaseStructure(  'databasename')
     *
     * 2 argument - just returns the database structure - if any.
     * PDO_DataObject::databaseStructure(  'databasename', false)
     * 
     * 
     * 2 arguments:
     * PDO_DataObject::databaseStructure(  'databasename', parse_ini_file('mydb.ini',true))
     *  - set's the structure..
     *  
     * 3 arguments:
     * PDO_DataObject::databaseStructure(  'databasename',
     *                                    parse_ini_file('mydb.ini',true), 
     *                                    parse_ini_file('mydb.link.ini',true)); 
    
     * obviously you dont have to use ini files.. (just return array similar to ini files..)
     *  
     * It should append to the table structure array 
     *
     *     
     * @param optional string  name of database to assign / read
     * @param optional array|false   structure of database, and keys
     * @param optional array|false  table links
     * @param optional bool overwrite - normally the first two will just append
     *
     * @access public
     * @return Array(databse Structure)|PEAR_Error|false     if no file exists
     *              or the array(tablename => array(column_name=>type)) if called with 1 argument.. (databasename)
     */
    final function databaseStructure($database_nickname = false, $inidata = false, $linksdata=false, $overwrite = false)
    {

        
    
        $args = func_get_args();
    
        if (self::$debug) {
            self::debug('CALL:' . json_encode($args, true), __FUNCTION__, 1);
        }
        
        
        // Assignment code    
        if (count($args) > 1) {
            
            // databaseStructure('mydb',   a$tabledatarray(.... schema....), array( ... links')
            if ($inidata !== false) {
                if (self::$debug) {
                    $this->debug("databaseStructure setting ini data: " . print_R($inidata, true),  __FUNCTION__, 3);
                }
                self::$ini[$database_nickname] = isset( self::$ini[$database_nickname]) && !$overwrite ?
                    self::$ini[$database_nickname] + $inidata :
                    $inidata;
            }
            if ($linksdata !== false)  {
                if (self::$debug) {
                    $this->debug("databaseStructure setting links ini data: " . print_R($inidata, true), __FUNCTION__, 3);
                }
                self::$links[$database_nickname] = isset(self::$links[$database_nickname]) && !$overwrite ?  
                    self::$links[$database_nickname] + $linksdata :
                    $linksdata;
            }
            
            return isset(self::$ini[$database_nickname]) ? self::$ini[$database_nickname] : false;
            
            // will not get here....
        }
        $this->PDO();  /// need to connect to assign database nickname...
        if (false === $database_nickname) {
            $database_nickname = $this->_database_nickname;
        }
        
        
        // if this table is already loaded this table..
        if (!empty(self::$ini[$database_nickname])) {
            if (self::$debug) {
                $this->debug("structure already loaded",  __FUNCTION__, 3);
            }
            return self::$ini[$database_nickname];  
        }
        
        // initialize the ini data.. if empt..
        if (empty(self::$ini[$database_nickname])) {
            self::$ini[$database_nickname] = array();
        }
         
         
        // we do not have the data for this table yet...
        
        // if we are configured to use the proxy..
        
        if ( self::$config['proxy'])   {
            if (self::$debug) {
                $this->debug("loading structure from proxy",  __FUNCTION__, 3);
            }

            return $this->generator()->databaseStructureProxy($database_nickname);
        }
            
        // basic idea here..
        // if we have a really simple format - do that here.. otherwise pass to introspection to sort out.
        
        // uses 'ini_* settings..
        $schemas = array();
        $suffix = '';
        
        if (is_array(self::$config['schema_location'])) {
            if (!isset(self::$config['schema_location'][$database_nickname])) {
                $this->raise("Could not find configuration for database $database_nickname in schema_location",
                        self::ERROR_INVALIDCONFIG
                );
            }
            
            $schemas = is_array(self::$config['schema_location'][$database_nickname]) ?
                self::$config['schema_location'][$database_nickname]:
                explode(PATH_SEPARATOR, self::$config['schema_location'][$database_nickname]);
        } else if (is_string(self::$config['schema_location']) && !empty(self::$config['schema_location'])) {
            $schemas  = explode(PATH_SEPARATOR,self::$config['schema_location']);
            $suffix = '/'. $database_nickname .'.ini';
        } else {
            $this->raise("Invalid format or empty value for config[schema_location]",
                            self::ERROR_INVALIDCONFIG
            );
        }
          
        $tried = array();
        $ini_out  = array();
        foreach ($schemas as $ini) {
            if (empty($ini)) {
                continue;
            }
            $fn = $suffix ? rtrim($ini ,'/') . $suffix : $ini;
            $tried[] = $fn;
            if (!file_exists($fn) || !is_file($fn) || !is_readable ($fn)) {
                continue;
            }
            $this->debug("load schema from: ". $fn ,  __FUNCTION__,   3);
            $ini_out = array_merge(
                $ini_out,
                parse_ini_file($fn, true)
            );
                
             
        }
        
        if (empty($ini_out)) {
            $this->raise("Failed to load any schema for database: '{$this->_database_nickname} \n" .
                        "  using schema_location=" . var_export(self::$config['schema_location'], true). "\n" .
                        "  from these files/locations: " . implode(', ', $tried) ."\n  ",
                         self::ERROR_INVALIDCONFIG
            );
        }
                
               
        // are table name lowecased..
        if (self::$config['portability'] & self::PORTABILITY_LOWERCASE) {
            foreach($ini_out as $k=>$v) {
                // results in duplicate cols.. but not a big issue..
                $ini_out[strtolower($k)] = $v;
            }
        }
        
        self::$ini[$database_nickname] =  $ini_out;

        
        if (self::$debug) {
                $this->debug("schema for {$database_nickname} is now " . print_r($ini_out,true), __FUNCTION__, 3);
        }

        
        // now have we loaded the structure.. 
        
        if (!empty(self::$ini[$database_nickname])) {
            return self::$ini[$database_nickname];
        }
       
        $this->debug("Cant find database schema: {$this->_database_nickname}\n".
                    "in links file data: " . print_r(self::$ini,true), __FUNCTION__, 5);
        // we have to die here!! - it causes chaos if we dont (including looping forever!)
        $this->raise( "Unable to load schema for database and table (turn debugging up to 5 for full error message)",
                self::ERROR_INVALIDARGS);
        return false;
        
         
    }
    /**
     * create an instance of the generator.
     * class can be set by using proxy = {classname}::
     * We do not really care if you have implemented it correctly....????
     * you can modify the class by setting proxy to {YOUR CLASS}::{your method}
     *
     * @return PDO_DataObject_Generator
     */
    
    function generator()
    {
        $dcls = 'PDO_DataObject_Generator';
        $cls = (is_string(self::$config['proxy']) && strpos(self::$config['proxy'], '::') !== false) ?
            explode('::', self::$config['proxy'])[0] : $dcls;
            
        if ($dcls == $cls) {
            class_exists('PDO_DataObject_Generator') ? '' : 
                require_once 'PDO/DataObject/Generator.php';
        }
        return new $cls($this->_database_nickname);
    }
    
    
    
    /**
     * Return or assign the name of the current table
     *
     *
     * @param   string optinal table name to set
     * @access public
     * @return string The name of the current table
     */
    function tableName()
    {
         $args = func_get_args();
        if (count($args)) {
            $this->__table = $args[0];
        }
        if (empty($this->__table)) {
            return '';
        }
        if (!empty(self::$config['portability']) && self::$config['portability'] & self::PORTABILITY_LOWERCASE) {
            return strtolower($this->__table);
        }
        return $this->__table;
    }
    
    /**
     * Return or assign the nickname of the current database
     * If you need the real database - use PDO()->dsn['database_name']
     *
     * @param   string optional database name to set
     * @access public
     * @return string The name of the current database
     */
    function databaseNickname()
    {
        $args = func_get_args();
        if (count($args)) {
            $this->_database_nickname = $args[0];
        } else {
            $this->PDO();
        }
        
        return $this->_database_nickname;
    }
    
    final function table()
    {
        $this->raise("
            Table has been replaced with tableColumns()
            - we have to define it to ensure that if it was over-ridden an error occurs
        ",self::ERROR_INVALIDARGS);
    }
    
    // used to store tableColumns for a specific instance.. - use databaseStructure to set globally.
    private $_assigned_fields;
  
    /**
     * get/set an associative array of table columns
     *
     * @access public
     * @param  array key=>type array
     * @return array (associative)
     */
    function tableColumns()
    {
        
        // for temporary storage of database fields..
        // it's not really a good idea to use this... 
      
        $args = func_get_args();
        if (count($args)) {
            $this->_assigned_fields = $args[0];
        }
        if (isset($this->_assigned_fields)) {
            return $this->_assigned_fields;
        }
        
        $this->PDO();
        
         
          
        if (isset(self::$ini[$this->_database_nickname][$this->tableName()])) {
            return self::$ini[$this->_database_nickname][$this->tableName()];
        }
        
        $this->databaseStructure();
 
        
        if (isset(self::$ini[$this->_database_nickname][$this->tableName()])) {
            return self::$ini[$this->_database_nickname][$this->tableName()];
        }
        
         // ???? why not an error?
        return array();
    }

    /**
     * get/set an  array of table primary keys
     *
     * set usage: $do->keys('id','code');
     *
     * This is defined in the table definition if it gets it wrong,
     * or you do not want to use ini tables, you can override this.
     * @param  string optional set the key
     * @param  *   optional  set more keys
     * @access public
     * @return array
     */
    function keys()
    {
        // for temporary storage of database fields..
        // note this is not declared as we dont want to bloat the print_r output
        $args = func_get_args();
        if (count($args)) {
            $this->_database_keys = $args;
        }
        if (isset($this->_database_keys)) {
            return $this->_database_keys;
        }
        
         
        if (isset(self::$ini[$this->_database_nickname][$this->tableName() . '__keys'])) {
            return array_keys(self::$ini[$this->_database_nickname][$this->tableName() . '__keys']);
        }
        
        $this->databaseStructure();
        
         

        if (!isset(self::$ini[$this->_database_nickname][$this->tableName() . '__keys'])) {
            return array();
        }
        $keys=  array_keys(self::$ini[$this->_database_nickname][$this->tableName() . '__keys']);
        // quick bit of validation... - only done on first load...
        $cols = $this->tableColumns();
        foreach($keys as $k) {
            if (!isset($cols[$k])) {
                $this->raise("Schema for {$this->tableName()} is not valid, key '{$k}' does not exist in the table structure information",
                    self::ERROR_INVALIDCONFIG);
            }
        }
        return $keys;
    }
    /**
     * get/set an  sequence key
     *
     * by default it returns the first key from keys()
     * set usage: $do->sequenceKey('id',true);
     *
     * override this to return array(false,false) if table has no real sequence key.
     *
     * @param  string  optional the key sequence/autoinc. key
     * @param  boolean optional use native increment. default false 
     * @param  false|string optional native sequence name
     * @access public
     * @return array (column,use_native,sequence_name)
     */
    function sequenceKey()
    {
        $this->PDO(); // needed to get database nickname.        
        $dn = $this->_database_nickname;
        $tn = $this->tableName();
        
        if (!isset(self::$sequence[$dn])) {
            self::$sequence[$dn] = array();
        }
 
        $args = func_get_args();
        if (count($args)) {
            $args[1] = isset($args[1]) ? $args[1] : false;
            $args[2] = isset($args[2]) ? $args[2] : false;
            self::$sequence[$dn][$tn] = $args;
        }
        if (isset(self::$sequence[$dn][$tn])) {
            return self::$sequence[$dn][$tn];
        }
        // end call setting (eg. $do->sequenceKeys(a,b,c); )
        
       
        
        
        $keys = $this->keys();
        if (!$keys) {
            return self::$sequence[$dn][$tn] 
                = array(false,false,false);
        }
 

        $table =  $this->tableColumns();
       
        $dbtype = $this->PDO()->getAttribute(PDO::ATTR_DRIVER_NAME);

        
        $usekey = $keys[0];
        
     
        $seqname = false;
        
       
        
        // if the key is not an integer - then it's not a sequence or native
        if (empty($table[$usekey]) || !($table[$usekey] & self::INT)) {
                return self::$sequence[$dn][$tn] = array(false,false,false);
        }
      
        $realkeys = self::$ini[$dn][$tn."__keys"];
        
         
        // multiple unique primary keys without a native sequence...
        if (($realkeys[$usekey] == 'K') && (count($keys) > 1)) {
            return self::$sequence[$dn][$tn]  = array(false,false,$seqname);
        }
        // use native sequence keys...
        // technically postgres native here...
        // we need to get the new improved tabledata sorted out first.
        
        // support named sequence keys.. - currently postgres only..
        
        if (    in_array($dbtype , array('pgsql')) &&
                ($table[$usekey] & self::INT) && 
                isset($realkeys[$usekey]) && strlen($realkeys[$usekey]) > 1) {
            return self::$sequence[$dn][$tn] = array($usekey,true, $realkeys[$usekey]);
        }
        
        // database that support native sequences?? 
        if (    in_array($dbtype , array('pgsql', 'mysql',  'mssql', 'ifx', 'sqlite')) && 
                ($table[$usekey] & self::INT) && 
                isset($realkeys[$usekey]) && ($realkeys[$usekey] == 'N')
                ) {
            return self::$sequence[$dn][$tn] = array($usekey,true,$seqname);
        }
        
        
        
         
        // I assume it's going to try and be a nextval DB sequence.. (not native)
        return self::$sequence[$dn][$tn] = array($usekey,false,$seqname);
    }
    
    
    
    /* =========================================================== */
    /*  Major Private Methods - the core part!              */
    /* =========================================================== */

 
    
    
 
    /**
     * Builds the WHERE based on the values of of this object (used to be _build_condition)
     *
     * @param   mixed   $keys (defaults to this->tableColumns())
     * @param   array   $filter (used by update to only uses keys in this filter list).
     * @param   array   $negative_filter (used by delete to prevent deleting using the keys mentioned..)
     * @param   string $tablename (used by join to override tablename...)
     * @access  private
     * @return  string
     */
    final function whereToString($keys = false, $filter = array(), $negative_filter = array(), $tableName = false)
    {
        
        $keys = $keys === false ? $this->tableColumns() : $keys;

        $quoteIdentifiers  = self::$config['quote_identifiers'];
        
        $tableName = $tableName ? $tableName : $this->tableName();
        
        // if we dont have query vars.. - reset them.
        
        $ret = empty($this->_query) || empty($this->_query['condition'])  ? '' :
            trim($this->_query['condition']);
             
        foreach($keys as $k => $v) {
            // index keys is an indexed array
            /* these filter checks are a bit suspicious..
                - need to check that update really wants to work this way */

            if ($filter) {
                if (!in_array($k, $filter)) {
                    continue;
                }
            }
            if ($negative_filter) {
                if (in_array($k, $negative_filter)) {
                    continue;
                }
            }
 
            if (!isset($this->$k)) {
                continue;
            }
            
            $kSql = $quoteIdentifiers 
                ? ( $this->quoteIdentifier($tableName) . '.' . $this->quoteIdentifier($k) )  
                : "{$tableName}.{$k}";
             
             
            // everything after here results in a condition getting added.... 
            $ret .= strlen($ret) ? ' AND ' : '';
            
            
            if (is_object($this->$k) && is_a($this->$k,'PDO_DataObject_Cast')) {
                $value = $this->$k->toString($v,$this->PDO());
                if ($this->$k->isNull() && ($v & self::NOTNULL)) {                
                    $this->raise("Error setting col '$k' to NULL - column is NOT NULL", self::ERROR_INVALIDARGS);
                }
                if ($this->$k->isNull() && !($v & self::NOTNULL)) {
                    $ret .= "($kSql IS NULL)";
                    continue;
                }
                


                $ret .= " $kSql = $value";
                continue;
            }

            if (!($v & self::NOTNULL) && self::_is_null_member($this,$k)) {
                $ret .= "($kSql  IS NULL)";
                continue;
            }
            if (($v & self::NOTNULL) && self::_is_null_member($this,$k)) {
                $this->raise("Error setting col '$k' to NULL - column is NOT NULL", self::ERROR_INVALIDARGS);
            }

            if ($v & self::STR) {
                $ret .= "($kSql  = " .
                        $this->PDO()->quote((string) (
                            ($v & self::BOOL) ? 
                                // this is thanks to the braindead idea of postgres to 
                                // use t/f for boolean.
                                (($this->$k === 'f') ? 0 : (int)(bool) $this->$k) :  
                                $this->$k
                        )) .
                        ')';
                
                continue;
            }
            if (is_numeric($this->$k)) {
                
                $ret .= "($kSql = {$this->$k})";
                continue;
            }
            // strings get cast to '0' .... it's a little unexpected...
            /* this is probably an error condition! */
            $ret .= "($kSql = ".intval($this->$k) .')';
        }
        return $ret;
    }
    
    /**
     * convience version of factory, can be called on an existing
     * object to create a clean new instance.
     * 
     * usage:
     * $do = PDO_DataObject::factory('person');
     * $person = $do->factorySelf();
     *
     * It's needed, as PHP5 (later versions started enfocing static/calling etc..)
     *
     * @access public
     * @throws PDO_DataObject_Exception for many reasons... 
     * @return PDO_DataObject
     */
    
    
    function factorySelf()
    {
        return self::factory($this->tableName());
    }
    
    
     /**
     * classic factory method for loading a table class
     * usage: $do = PDO_DataObject::factory('person')
     *
     * table name can bedatabasename/table
     * - and allow modular dataobjects to be written..
     * (this also helps proxy creation)
     *
     * Experimental Support for Multi-Database factory eg. mydatabase.mytable
     * 
     * 
     * @param  string  $table  tablename or database_nickname/tablename  
     * @access public
     * @throws PDO_DataObject_Exception for many reasons... 
     * @return PDO_DataObject
     */
    
    

    static function factory($table)
    {
        
        // multi-database support.. - experimental.
       
        $rclass = self::tableToClass($table);
        // proxy = full|light
        if (!$rclass && self::$config['proxy']) { 
        
            self::debug("FAILED TO Autoload  $table - using proxy.",__FUNCTION__,1);
            
            $proxyMethod  = (is_string(self::$config['proxy']) && strpos(self::$config['proxy'], '::') !== false) ?
                explode('::', self::$config['proxy'])[1] : ('getProxy' . self::$config['proxy']);
        
            // if you have loaded (some other way) - dont try and load it again..
            $do = new PDO_DataObject($table);
            $gen = $do->generator();
            if (!method_exists($gen, $proxyMethod)) {
                $do->raise("Generator does not have method $proxyMethod, \n".
                           "  usually proxy should be set to 'Full', you set it to ". var_export(self::$config['proxy'],true),
                           self::ERROR_INVALIDCONFIG);
            }
            return $do->generator()->{$proxyMethod}( $do->_database_nickname, $table);
            
        }
        
        if (!$rclass || !class_exists($rclass)) {
            $dor = new PDO_DataObject();
            return $dor->raise(
                "factory could not find class " . 
                (is_array($rclass) ? implode(PATH_SEPARATOR, $rclass)  : $rclass  ). 
                "from
                $table",
                self::ERROR_NOCLASS);
        }
 
        $ret = new $rclass();
 
        if (!empty($database)) {
            self::debug("Setting database to $database",__FUNCTION__,1);
            $ret->database($database);
        }
        return $ret;
    }
    /**
     * table to ClassName
     * 
     * @param  string  $table  tablename  
     * @throws PDO_DataObject_Exception
     *              database not set or does not exist.
     *              file exists, but does not contain valid class.
     *              
     * @return string|classname
     *
     */
    private static function tableToClass($table)
    {
        
        // multi-database support.. - experimental.
        $database = '';
       
        if (strpos( $table,'/') !== false ) {
            list($database,$table) = explode('.',$table, 2);
          
        }
          
        // no configuration available for database
        if (!empty($database) && empty(self::config['databases'][$database])) {
                $do = new PDO_DataObject();
                $do->raise(
                    "unable to find databases[{$database}] in Configuration, It is required for factory with database"
                    , self::ERROR_INVALIDARGS);   
        }
        
       
        
        // does this need multi db support??
        $cp =  explode(PATH_SEPARATOR, self::$config['class_prefix']);
        
        //print_r($cp);
        
        // multiprefix support.
        $tbl = preg_replace('/[^A-Z0-9]/i','_',ucfirst($table));
    
        $class = array();
        foreach($cp as $cpr) {
            $ce =  class_exists($cpr . $tbl,false); //class exists without autoloader..
            if ($ce) {
                $class = $cpr . $tbl;
                return $class;
            }
            
            $class[]  =  $cpr . $tbl;
            
        }
        
        return self::loadClass($class, $table);
        
        
        
    }
    
    
    /**
     * autoload Class - Note - does not throw errors on loading, so can be used to test.
     * 
     *
     * @param  string|array  $class  Class
     * @param  string  $table  Table trying to load.
     * @access private
     * @return string classname on Success
     * @throws PDO_DataObject_Exception only when class is loaded, and file does not exist.
     * @static
     */
    private static function loadClass($class, $table=false)
    {
         
        $class_prefix = self::$config['class_prefix'];
                
        $table   = $table ? $table : substr($class,strlen($class_prefix));

        // only include the file if it exists - and barf badly if it has parse errors :)
        if (self::$config['proxy']|| empty(self::$config['class_location'])) {
            return false;
        }
        // support for:
        // class_location = mydir/ => maps to mydir/Tablename.php
        // class_location = mydir/myfile_%s.php => maps to mydir/myfile_Tablename
        // with directory sepr
        // class_location = mydir/:mydir2/: => tries all of thes locations.
        $file = array();
       
        $cl = self::$config['class_location'];
        foreach (explode(PATH_SEPARATOR, self::$config['class_location']) as $cl) {
            
            if(strpos($cl ,'%s') !== false) {
                $file[] = sprintf($cl , preg_replace('/[^A-Z0-9]/i','_',ucfirst($table)));
                continue;
            }
            if (substr($cl,-1) == '/') {
                $file[] = $cl .'/'.preg_replace('/[^A-Z0-9]/i','_',ucfirst($table)).".php";
                continue;
            }
            // othwise we have a situation where it's not suffixed... - but we will allow directories.
            if (file_exists($cl) && is_dir($cl)) {
                $file[] = $cl .'/'.preg_replace('/[^A-Z0-9]/i','_',ucfirst($table)).".php";
                continue;
            }
            $file[] = $cl . preg_replace('/[^A-Z0-9]/i','_',ucfirst($table)).".php";
        }
        
        
        
        $cls = is_array($class) ? $class : array($class);
        
        
        $found = false;
        
        foreach($file as $f) {
            // if absolute path...
            if ($f[0] == '/') {
                if (file_exists($f)) {
                    $file = $f;
                    $found = true;
                    break;
                }
                continue; //?? should we do this?
            }
            // not absolute path 'starting with '/'
            
            foreach(explode(PATH_SEPARATOR,  ini_get('include_path')) as $p) {
                $ff = "$p/$f";

                if (file_exists($ff) && is_readable($ff)) {
                    $file = $ff;
                    $found = true;
                    break;
                }
            }
            if ($found) {
                break;
            }
        }
        if (!$found) {
            $search = implode(PATH_SEPARATOR, $file); // used for errors..
            
            self::debug(
                "autoload:Could not find class " . implode(',', $cls) . "\n" .
                " using class_location value :" . $search .  "\n" .
                " using include_path value :" . ini_get('include_path'),__FUNCTION__);
            return false;
        }
        
        
        include_once $file;
        
       
        $ce = false;
        foreach($cls as $c) {
            $ce =  class_exists($c,false);
            if ($ce) {
                $class = $c;
                break;
            }
        }
        if (!$ce) {
            $dor = new PDO_DataObject();
            return $dor->raise(
                "autoload: Included $file \n   however could not find the class :" . implode(',', $cls) , 
                 self::ERROR_NOCLASS);
            
        }
        return $class;
    }
    
    
    
    // used to store links for a specific instance.. - use databaseStructure to set globally.
    private $_assigned_links;
    
    /**
    * Get the links associate array  as defined by the links.ini file.
    * mapping the foreign key relationships (which MAY NOT be enforced by the database)
    *
    * Will attempt to load the file
    *   This can be over-ridden rather than using links.ini files...
    *
    * Experimental... - 
    * Should look a bit like
    *       [local_col_name] => "related_tablename:related_col_name"
    * 
    * @param    array $new_links optional - if used it will only set it for the current instance, not globally, 
                           use databaseStructure if you need to do that.
    * 
    * @return   array|null    
    *           array       = if there are links defined for this table.
    *           empty array - if there is a links.ini file, but no links on this table
    *           false       - if no links.ini exists for this database (hence try auto_links).
    * @access   public
    * @see      PDO_DataObject::applyLinks(), PDO_DataObject::link()
    */
    
    function links()
    {
       
        
        // alias for shorter code..
        $dn = $this->_database_nickname;
        $tn = $this->tableName();
        

        if ($args = func_get_args()) {
            $this->_assigned_links = $args[0];
        }
        if (isset($this->_assigned_links)) {
            return $this->_assigned_links;
        }
        


        // loaded and available.
        if (isset(self::$links[$dn][$tn])) {
            return self::$links[$dn][$tn];
        }

        // loaded 
        if (isset(self::$links[$dn])) {
            // either no file, or empty..
            return self::$links[$dn] === false ? null : array();
        }
        
        $suffix = '';
        if (is_array(self::$config['schema_location'])) {
            if (!isset(self::$config['schema_location'][$database_nickname])) {
                $this->raise("Could not find configuration for database $database_nickname in schema_location",
                        self::ERROR_INVALIDCONFIG
                );
            }
            
            $schemas = is_array(self::$config['schema_location'][$database_nickname]) ?
                self::$config['schema_location'][$database_nickname]:
                explode(PATH_SEPARATOR, self::$config['schema_location'][$database_nickname]);
        } else if (is_string(self::$config['schema_location']) && !empty(self::$config['schema_location'])) {
            $this->PDO(); // as we need the nickname..
            $schemas  = explode(PATH_SEPARATOR,self::$config['schema_location']);
            $suffix = '/'. $this->_database_nickname .'.ini';
        } else {
            $this->raise("Invalid format or empty value for config[schema_location]",
                            self::ERROR_INVALIDCONFIG
            );
        }
        
                  
        // default to not available.
        self::$links[$dn] = false;

        foreach ($schemas as $ini) {
            
            
            if (empty($ini)) {
                continue;
            }
            $fn = $suffix ? rtrim($ini ,'/') . $suffix : $ini;
            $fn =  str_replace('.ini','.links.ini',$fn);
            $tried[] = $fn;
            if (!file_exists($fn) || !is_file($fn) || !is_readable ($fn)) {
                continue;
            }
            // got a match.... - if it's not set yet... then set it...
            self::$links[$dn] = empty(self::$links[$dn]) ? array() : self::$links[$dn];
            
            self::$links[$dn] = array_merge(
                self::$links[$dn],
                parse_ini_file($fn, true)
            );
            
                
             
        }
        if (false === self::$links[$dn] ) {
            // this used to return 'null' ???? 
            return $this->raise(
                "Failed to load any links schema for database={$this->_database_nickname} from these files/locations" . json_encode($tried),
                self::ERROR_INVALIDCONFIG 
            );
        }
        
        
        if (self::$config['portability'] & self::PORTABILITY_LOWERCASE) {
            foreach(self::$links[$dn] as $k=>$v) {
                
                $nk = strtolower($k);
                // results in duplicate cols.. but not a big issue..
                self::$links[$dn][$nk] = isset(self::$links[$dn][$nk])
                    ? self::$links[$dn][$nk]  : array();
                
                foreach($v as $kk =>$vv) {
                    //var_Dump($vv);exit;
                    $vv =explode(':', $vv);
                    $vv[0] = strtolower($vv[0]);
                    self::$links[$dn][$nk][$kk] = implode(':', $vv);
                }
                
                
            }
        }
    
        if (isset(self::$links[$dn][$tn])) {
            return self::$links[$dn][$tn];
        }
        
        return array();
    }
    
    
    /**
     * generic getter/setter for links
     *
     * This is the new 'recommended' way to get get/set linked objects.
     * must be used with links.ini
     *
     * usage:
     *  get:
     *  $obj = $do->link('company_id');
     *  $obj = $do->link(array('local_col', 'linktable:linked_col'));
     *  
     *  set:
     *  $do->link('company_id',0);
     *  $do->link('company_id',$obj);
     *
     *  example function (you could add to your extended classes - to make the code easy to read...)
     *
     *  function company($set = false) {
     *     $this->link('company_id', $set);
     *  }
     *
     *
     * @param  string $column  which column to get or set  (or the link specification)           
     * @param  mixed $set_value (optional)   int or DataObject
     * @author Alan Knowles
     * @access public
     * @throws 
     * @return PDO_DataObject  child on get, self on set
     */
    function link($field, $set_args = false)
    {
        require_once 'PDO/DataObject/Links.php';
        $l = new PDO_DataObject_Links($this);
        return  $l->link($field,$set_args) ;
        
    }
    
    /**
     * load related objects
     * @depricated
     * This is only in for compatibility ( not supported anymore )
     */
    function applyLinks($format = '_%s')
    {
        require_once 'PDO/DataObject/Links.php';
         $l = new PDO_DataObject_Links($this);
        return $l->applyLinks($format);
           
    }

 

    /**
     * linkArray
     * @depricated
     * This is only in for compatibility ( not supported anymore )
     */
    function linkArray($row, $table = null)
    {
        require_once 'PDO/DataObject/Links.php';
        $l = new PDO_DataObject_Links($this);
        return $l->getLinkArray($row, $table === null ? false: $table);
     
    }

    
 
    /**
     * joinAdd - adds another dataobject to this, building a joined query.
     *
     * example (requires links.ini to be set up correctly)
     * // get all the images for product 24
     * $i = new DataObject_Image();
     * $pi = new DataObjects_Product_image();
     * $pi->product_id = 24; // set the product id to 24
     * $i->joinAdd($pi); // add the product_image connectoin
     * $i->find();
     * while ($i->fetch()) {
     *     // do stuff
     * }
     * // an example with 2 joins
     * // get all the images linked with products or productgroups
     * $i = new DataObject_Image();
     * $pi = new DataObject_Product_image();
     * $pgi = new DataObject_Productgroup_image();
     * $i->joinAdd($pi);
     * $i->joinAdd($pgi);
     * $i->find();
     * while ($i->fetch()) {
     *     // do stuff
     * }
     *
     *
     * @param    optional $obj       string | object |array    the joining object (no value resets the join)
     *                                          If you use an array here it should be in the format:
     *                                          array('local_column','remotetable:remote_column');
     *                                             if remotetable does not have a definition, you should
     *                                             use @ to hide the include error message..
     *                                          array('local_column',  $dataobject , 'remote_column');
     *                                             if array has 3 args, then second is assumed to be the linked dataobject.
     *
     * @param    optional $joinType  string | array
     *                                          'LEFT'|'INNER'|'RIGHT'|'' Inner is default, '' indicates 
     *                                          just select ... from a,b,c with no join and 
     *                                          links are added as where items.
     *                                          
     *                                          If second Argument is array, it is assumed to be an associative
     *                                          array with arguments matching below = eg.
     *                                          'joinType' => 'INNER',
     *                                          'joinAs' => '...'
     *                                          'joinCol' => ....
     *                                          'useWhereAsOn' => false,
     *
     * @param    optional $joinAs    string     if you want to select the table as anther name
     *                                          useful when you want to select multiple columsn
     *                                          from a secondary table.
     
     * @param    optional $joinCol   string     The column on This objects table to match (needed
     *                                          if this table links to the child object in 
     *                                          multiple places eg.
     *                                          user->friend (is a link to another user)
     *                                          user->mother (is a link to another user..)
     *
     *           optional 'useWhereAsOn' bool   default false;
     *                                          convert the where argments from the object being added
     *                                          into ON arguments.
     * 
     * 
     * @return   PDO_DataObject                 for chaining
     * @throws   PDO_DataObject_Exception       if it can not work out how to join...
     * @access   public
     * @author   Stijn de Reede      <sjr@gmx.co.uk>
     */
    function joinAdd($obj = false, $joinType='INNER', $joinAs=false, $joinCol=false)
    {
         if ($obj === false) {
            $this->_join = '';
            return $this;
        }
         
        //echo '<PRE>'; print_r(func_get_args());
        $useWhereAsOn = false;
        // support for 2nd argument as an array of options
        if (is_array($joinType)) {
            // new options can now go in here... (dont forget to document them)
            $useWhereAsOn = !empty($joinType['useWhereAsOn']);
            $joinCol      = isset($joinType['joinCol'])  ? $joinType['joinCol']  : $joinCol;
            $joinAs       = isset($joinType['joinAs'])   ? $joinType['joinAs']   : $joinAs;
            $joinType     = isset($joinType['joinType']) ? $joinType['joinType'] : 'INNER';
        }
        // support for array as first argument 
        // this assumes that you dont have a links.ini for the specified table.
        // and it doesnt exist as am extended dataobject!! - experimental.
        
        $ofield = false; // object field
        $tfield = false; // this field
        $toTable = false;

        if (is_string($obj)) {
            $obj = self::factory($obj);
        }

        if (is_array($obj)) {
            $tfield = $obj[0];
            
            if (count($obj) == 3) {
                $ofield = $obj[2];
                $obj = $obj[1];
            } else {
                list($toTable,$ofield) = explode(':',$obj[1]);
            
                
                $obj = self::tableToClass($toTable);

                if ($obj) {
                    $obj =self::factory($toTable);
                } else {
                    $obj = new PDO_DataObject($toTable);
                }
            }
            // set the table items to nothing.. - eg. do not try and match
            // things in the child table...???
            $items = array();
        }


        
        if (!is_object($obj) || !is_a($obj,'PDO_DataObject')) {
            return $this->raise("joinAdd: called without an object", self::ERROR_INVALIDARGS);
        }
        /*  make sure $this->_database is set.  */
        

        /// CHANGED 26 JUN 2009 - we prefer links from our local table over the remote one.
        
        /* otherwise see if there are any links from this table to the obj. */
        //print_r($this->links());
        if (($ofield === false) && ($links = $this->links())) {
            // this enables for support for arrays of links in ini file.
            // link contains this_column[] =  linked_table:linked_column
            // or standard way.
            // link contains this_column =  linked_table:linked_column



            foreach ($links as $k => $linkVar) {
            
                if (!is_array($linkVar)) {
                    $linkVar  = array($linkVar);
                }
                foreach($linkVar as $v) {

                    
                    
                    /* link contains {this column} = {linked table}:{linked column} */
                    $ar = explode(':', $v);
                    // Feature Request #4266 - Allow joins with multiple keys
                    if (strpos($k, ',') !== false) {
                        $k = explode(',', $k);
                    }
                    if (strpos($ar[1], ',') !== false) {
                        $ar[1] = explode(',', $ar[1]);
                    }

                    if ($ar[0] != $obj->tableName()) {
                        continue;
                    }
                    if ($joinCol !== false) {
                        if ($k == $joinCol) {
                            // got it!?

                            $tfield = $k;
                            $ofield = $ar[1];
                            break;
                        } 
                        continue;
                        
                    } 
                    if ($tfield !== false) {
                        $this->raise("There are multiple locations where table '{$obj->tableName()}' is joined to '{$this->tableName()}' \n" .
                                     " you should use the joinCol argument to specify which one to use", self::ERROR_INVALIDARGS);
                    }

                    $tfield = $k;
                    $ofield = $ar[1];
                    break;
                        
                }
  
            }
        }
         /* look up the links for obj table */
        //print_r($obj->links());
        if (!$ofield && ($olinks = $obj->links())) {
            
            foreach ($olinks as $k => $linkVar) {
                /* link contains {this column} = array ( {linked table}:{linked column} )*/
                if (!is_array($linkVar)) {
                    $linkVar  = array($linkVar);
                }
                foreach($linkVar as $v) {
                    
                    /* link contains {this column} = {linked table}:{linked column} */
                    $ar = explode(':', $v);
                    
                    // Feature Request #4266 - Allow joins with multiple keys
                    $links_key_array = strpos($k,',');
                    if ($links_key_array !== false) {
                        $k = explode(',', $k);
                    }
                    
                    $ar_array = strpos($ar[1],',');
                    if ($ar_array !== false) {
                        $ar[1] = explode(',', $ar[1]);
                    }
                 
                    if ($ar[0] != $this->tableName()) {
                        continue;
                    }
                    
                    // you have explictly specified the column
                    // and the col is listed here..
                    // not sure if 1:1 table could cause probs here..
                    
                    if ($joinCol !== false) {
                        $this->raise( 
                            "joinAdd: You cannot target a join column in the " .
                            "'link from' table ({$obj->tableName()}). " . 
                            "Either remove the fourth argument to joinAdd() ".
                            "({$joinCol}), or alter your links.ini file. ",
                            self::ERROR_INVALIDARGS);
                        return false;
                    }
                
                    $ofield = $k;
                    $tfield = $ar[1];
                    break;
                    
                }
            }
        }

        // finally if these two table have column names that match do a join by default on them

        if (($ofield === false) && $joinCol) {
            $ofield = $joinCol;
            $tfield = $joinCol;

        }
        /* did I find a conneciton between them? */

        if ($ofield === false) {
            return $this->raise(
                "joinAdd: {$obj->tableName()} has no link with {$this->tableName()}",
                self::ERROR_INVALIDARGS);
        }
        $joinType = strtoupper($joinType);
        
        // we default to joining as the same name (this is remvoed later..)
        
        if ($joinAs === false) {
            $joinAs = $obj->tableName();
        }
        
        $quoteIdentifiers = self::$config['quote_identifiers'];
         
        // not sure  how portable adding database prefixes is..
        $objTable = $quoteIdentifiers ? 
                $this->quoteIdentifier($obj->tableName()) : 
                 $obj->tableName() ;
        
        $PDO = $this->PDO();
                    
        
        $dbPrefix  = '';
        
        $obj_database = $obj->PDO()->dsn['database_name'];
        
        if ($PDO->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') {
            $dbPrefix = ($quoteIdentifiers
                         ? $this->quoteIdentifier($obj_database)
                         : $obj_database) . '.';    
        }
        
        // if they are the same, then dont add a prefix...                
        if ($obj_database == $PDO->dsn['database_name']) {
           $dbPrefix = '';
        }
        // as far as we know only mysql supports database prefixes..
        // prefixing the database name is now the default behaviour,
        // as it enables joining mutiple columns from multiple databases...
         
            // prefix database (quoted if neccessary..)
        $objTable = $dbPrefix . $objTable;
       
        $cond = '';

        // if obj only a dataobject - eg. no extended class has been defined..
        // it obvioulsy cant work out what child elements might exist...
        // until we get on the fly querying of tables..
        // note: we have already checked that it is_a(db_dataobject earlier)
        if ( get_class($obj) != 'PDO_DataObject') {
                 
            // now add where conditions for anything that is set in the object 
        
        
        
            $items = $obj->tableColumns();
            // will return an array if no items..
            
            // only fail if we where expecting it to work (eg. not joined on a array)
             
            if (!$items) {
                return $this->raise(
                    "joinAdd: No table definition for {$obj->tableName()}", 
                    self::ERROR_INVALIDCONFIG);
            }
            
          
            $ignore_null = self::$config['enable_null_strings'] === false;
            
            // obj->whereToString()???
            foreach($items as $k => $v) {
                if (!isset($obj->$k) && $ignore_null) {
                    continue;
                }
                
                $kSql = ($quoteIdentifiers ? $this->quoteIdentifier($k) : $k);
                
                if (self::_is_null_member($obj,$k)) {
                	$obj->whereAdd("{$joinAs}.{$kSql} IS NULL");
                	continue;
                }
                
                if ($v & self::STR) {
                    $obj->whereAdd("{$joinAs}.{$kSql} = " . $PDO->quote((string) (
                            ($v & self::BOOL) ? 
                                // this is thanks to the braindead idea of postgres to 
                                // use t/f for boolean.
                                (($obj->$k === 'f') ? 0 : (int)(bool) $obj->$k) :  
                                $obj->$k
                        )));
                    continue;
                }
                if (is_numeric($obj->$k)) {
                    $obj->whereAdd("{$joinAs}.{$kSql} = {$obj->$k}");
                    continue;
                }
                            
                if (is_object($obj->$k) && is_a($obj->$k,'PDO_DataObject_Cast')) {
                    $value = $obj->$k->toString($v,$PDO);
                    $obj->whereAdd("{$joinAs}.{$kSql} = $value");
                    continue;
                }
                
                
                /* this is probably an error condition! */
                $obj->whereAdd("{$joinAs}.{$kSql} = 0");
            }
            if ($this->_query === false) {
                return $this->raise(
                    "joinAdd can not be run from a object that has had a query run on it,
                    clone the object or create a new one and use setFrom()", 
                    self::ERROR_INVALIDARGS);
            }
        }

        // and finally merge the whereAdd from the child..
        if ($obj->_query['condition']) {
            $cond = preg_replace('/^\sWHERE/i','',$obj->_query['condition']);

            if (!$useWhereAsOn) {
                $this->whereAdd($cond);
            }
        }
    
        
        
        
        // nested (join of joined objects..)
        $appendJoin = '';
        if ($obj->_join) {
            // postgres allows nested queries, with ()'s
            // not sure what the results are with other databases..
            // may be unpredictable..
            if (in_array($PDO->getAttribute(PDO::ATTR_DRIVER_NAME) ,array('pgsql'))) {
                $objTable = "($objTable {$obj->_join})";
            } else {
                $appendJoin = $obj->_join;
            }
        }
        
  
        // fix for #2216
        // add the joinee object's conditions to the ON clause instead of the WHERE clause
        if ($useWhereAsOn && strlen($cond)) {
            $appendJoin = ' AND ' . $cond . ' ' . $appendJoin;
        }
               
        
        
        $table = $this->tableName();
        
        if ($quoteIdentifiers) {
            $joinAs   = $this->quoteIdentifier($joinAs);
            $table    = $this->quoteIdentifier($table);     
            $ofield   = (is_array($ofield)) ? array_map(array($this, 'quoteIdentifier'), $ofield) : $this->quoteIdentifier($ofield);
            $tfield   = (is_array($tfield)) ? array_map(array($this, 'quoteIdentifier'), $tfield) : $this->quoteIdentifier($tfield); 
        }
        // add database prefix if they are different databases
       
        
        $fullJoinAs = '';
        $addJoinAs  = ($quoteIdentifiers ? $this->quoteIdentifier($obj->tableName()) : $obj->tableName()) != $joinAs;
        if ($addJoinAs) {
            // join table a AS b - is only supported by a few databases and is probably not needed
            // , however since it makes the whole Statement alot clearer we are leaving it in
            // for those databases.
            $fullJoinAs = in_array($PDO->getAttribute(PDO::ATTR_DRIVER_NAME) ,array('mysql','pgsql')) ? "AS {$joinAs}" :  $joinAs;
        } else {
            // if 
            $joinAs = $dbPrefix . $joinAs;
        }
        
        
        switch ($joinType) {
            case 'INNER':
            case 'LEFT': 
            case 'RIGHT': // others??? .. cross, left outer, right outer, natural..?
                
                // Feature Request #4266 - Allow joins with multiple keys
                $jadd = "\n {$joinType} JOIN {$objTable} {$fullJoinAs}";
                //$this->_join .= "\n {$joinType} JOIN {$objTable} {$fullJoinAs}";
                if (is_array($ofield)) {
                	$key_count = count($ofield);
                    for($i = 0; $i < $key_count; $i++) {
                    	if ($i == 0) {
                    		$jadd .= " ON ({$joinAs}.{$ofield[$i]}={$table}.{$tfield[$i]}) ";
                    	}
                    	else {
                    		$jadd .= " AND {$joinAs}.{$ofield[$i]}={$table}.{$tfield[$i]} ";
                    	}
                    }
                    $jadd .= ' ' . $appendJoin . ' ';
                } else {
	                $jadd .= " ON ({$joinAs}.{$ofield}={$table}.{$tfield}) {$appendJoin} ";
                }
                // jadd avaliable for debugging join build.
                //echo $jadd ."\n";
                $this->_join .= $jadd;
                break;
                
            case '': // this is just a standard multitable select..
                $this->_join .= "\n , {$objTable} {$fullJoinAs} {$appendJoin}";
                $this->where("{$joinAs}.{$ofield}={$table}.{$tfield}");
                break;

            default:
                return $this->raise("Invalid Join type :'{$joinType}'", self::ERROR_INVALIDARGS);

        }
         
         
        return $this;

    }

    /**
     * autoJoin - using the links.ini file, it builds a query with all the joins 
     * Note: clears and replaces the existing 'select' arguments.
     * usage: 
     * $x = PDO_DataObject::factory('mytable');
     * $x->autoJoin();
     * $x->get(123); 
     *   will result in all of the joined data being added to the fetched object..
     * 
     * $x = PDO_DataObject::factory('mytable');
     * $x->autoJoin();
     * $ar = $x->fetchAll();
     *   will result in an array containing all the data from the table, and any joined tables..
     * 
     * $x = PDO_DataObject::factory('mytable');
     * $jdata = $x->autoJoin();
     * $x->selectAdd(); //reset..
     * foreach($_REQUEST['requested_cols'] as $c) {
     *    if (!isset($jdata[$c])) continue; // ignore columns not available..
     *    $x->selectAdd( $jdata[$c] . ' as ' . $c);
     * }
     * $ar = $x->fetchAll(); 
     *   will result in only the columns requested being fetched...
     *
     *
     *
     * @param     array     Configuration
     *          exclude  Array of columns to exclude from results (eg. modified_by_id)
     *                    Use TABLENAME.* to prevent a join occuring to a specific table.
     *          include  Array of specific columns to include (none others are added to select, join is still done though)
     *          links    The equivilant links.ini data for this table eg.
     *                    array( 'person_id' => 'person:id', .... ) - only applied to this instance of the DataObject (used to be applied globally)
     *          distinct Array of distinct columns. (note you may need to add GROUP BY for this to work)
     *          
     * @return   array      info about joins
     *                      cols => map of resulting {joined_tablename}.{joined_table_column_name}
     *                      join_names => map of resulting {join_name_as}.{joined_table_column_name}
     *                      count => the column to count on.
     * @access   public
     */
    function autoJoin($cfg = array())
    {
         //var_Dump($cfg);exit;
         
        $map = $this->links();
        if (!empty($cfg['links'])) {
            $map = array_merge( $map, $cfg['links']);
        }
        
        $this->databaseStructure();
        $dbstructure = self::$ini[$this->_database_nickname];
        //print_r($map);
        $tabdef = $this->tableColumns();
         
        // we need this as normally it's only cleared by an empty selectAs call.
       
        
        $keys = array_keys($tabdef);
        if (!empty($cfg['exclude'])) {
            $keys = array_intersect($keys, array_diff($keys, $cfg['exclude'])); 
        }
        
        if (!empty($cfg['include'])) {
            $keys =  array_intersect($keys,  $cfg['include']); 
        }
        
        $selectAs = array();
        
        if (!empty($keys)) {
            $selectAs = array(array( $keys , '%s', false));
        }
        
        $ret = array(
            'cols' => array(),
            'join_names' => array(),
            'count' => false,
        );
        
        
        
        $has_distinct = false;
        if (!empty($cfg['distinct']) && $keys) {
            
            // reset the columsn?
             
            $cols = array();
             
            foreach($keys as $c) {
 
                
                if (  $cfg['distinct'] == $c) {
                    $has_distinct = 'DISTINCT( ' . $this->tableName() .'.'. $c .') as ' . $c;
                    $ret['count'] =  'DISTINCT  ' . $this->tableName() .'.'. $c .'';
                    continue;
                }
                // cols is in our filtered keys...
                $cols = $c;
                
            }
            // apply our filtered version, which excludes the distinct column.
            if ($has_distinct) {
                 $selectAs = empty($cols) ?  array() : array(array(array($cols) , '%s', false)) ;
            } 
            


            
            
        } 
                
        foreach($keys as $k) {
            $ret['cols'][$k] = $this->tableName(). '.' . $k;
        }
        
        
        
        foreach($map as $ocl=>$info) {
            if (strpos($info, ':') === false) {
                $this->raise(
                    "format of links.ini is not correct for table {$this->tableName()} - missing 'colon:' in value - " . print_R($map,true), 
                    self::ERROR_INVALIDCONFIG);
                continue;
            }
            list($tab,$col) = explode(':', $info);
            // what about multiple joins on the same table!!!
            
            // if links point to a table that does not exist - ignore.
            if (!isset($dbstructure[$tab])) {
                continue;
            }
            
            if (!empty($cfg['exclude']) && 
                 (
                    in_array($tab .'.*', $cfg['exclude']) 
                    || 
                    in_array($ocl .'.*', $cfg['exclude'])
                    ||
                    in_array('join_'.$ocl.'_'. $col,$cfg['exclude'])
                )
            ) {
                continue;
            }
            $cls = self::tableToClass($tab);
            if ($cls === false) {
                continue;
            }
            
            $xx = self::factory($tab);
            
            // skip columns that are excluded.
            
            // we ignore include here... - as
             
            $this->joinAdd($xx, 'LEFT', 'join_'.$ocl.'_'. $col, $ocl);
            
            if (!empty($cfg['exclude']) && in_array($ocl, $cfg['exclude'])) {
                continue;
            }
            
            $tabdef = $xx->tableColumns();
            $table = $xx->tableName();
            
            $keys = array_keys($tabdef);
            
            
            if (!empty($cfg['exclude'])) {
                
                $nkeys = array_intersect($keys, array_diff($keys, $cfg['exclude']));
                $keys = array();
                foreach($nkeys as $k) {
                    if (in_array($ocl.'_'.$k, $cfg['exclude'])) {
                        continue;
                    }
                    $keys[] = $k;
                }
                
            }
            
            if (!empty($cfg['include'])) {
                // include will basically be BASECOLNAME_joinedcolname
                $nkeys = array();
                foreach($keys as $k) {
                    if (in_array( sprintf($ocl.'_%s', $k), $cfg['include'])) {
                        $nkeys[] = $k;
                    }
                }
                $keys = $nkeys;
            }
            
            if (empty($keys)) {
                continue;
            }
            // got distinct, and not yet found it..
            if (!$has_distinct && !empty($cfg['distinct']))  {
                $cols = array();
                foreach($keys as $c) {
                    $tn = sprintf($ocl.'_%s', $c);
                      
                    if ( $tn == $cfg['distinct']) {
                        
                        $has_distinct = 'DISTINCT( ' . 'join_'.$ocl.'_'.$col.'.'.$c .')  as ' . $tn ;
                        $ret['count'] =  'DISTINCT  join_'.$ocl.'_'.$col.'.'.$c;
                       // var_dump($this->countWhat );
                        continue;
                    }
                    $cols[] = $c;
                     
                }
                
                if (!empty($cols)) {
                    $selectAs[] = array($cols, $ocl.'_%s', 'join_'.$ocl.'_'. $col);
                }
                
            } else {
                $selectAs[] = array($keys, $ocl.'_%s', 'join_'.$ocl.'_'. $col);
            }
              
            foreach($keys as $k) {
                $ret['cols'][sprintf('%s_%s', $ocl, $k)] = $tab.'.'.$k;
                $ret['join_names'][sprintf('%s_%s', $ocl, $k)] = sprintf('join_%s_%s.%s',$ocl, $col, $k);
            }
             
        }
        
        // clear the existing select...
        $this->selectAdd(); 
        
        if ($has_distinct) {
            $this->selectAdd($has_distinct);
        }
       
        foreach($selectAs as $ar) {            
            $this->selectAs($ar[0], $ar[1], $ar[2]);
        }
    
        return $ret;
        
    }
    /**
     * joinAll - chained Version of autoJoin()
     * usage: 
     * $array  = PDO_DataObject::factory('mytable')->joinAll()->fetchAssoc();
     * 
     * @see #autoJoin for more details.
     *
     * @param     array     Configuration
     *          exclude  Array of columns to exclude from results (eg. modified_by_id)
     *                    Use TABLENAME.* to prevent a join occuring to a specific table.
     *          links    The equivilant links.ini data for this table eg.
     *                    array( 'person_id' => 'person:id', .... )
     *          include  Array of columns to include
     *          distinct Array of distinct columns.
     *          
     * @return   PDO_DataObject self
     * @access   public
     */

    function joinAll($cfg = array())
    {
         $this->autoJoin($cfg);
         return $this;
    }

    /**
     * Factory method for calling PDO_DataObject_Cast
     *
     * if used with 1 argument PDO_DataObject_Cast::sql($value) is called
     * 
     * if used with 2 arguments PDO_DataObject_Cast::$value($callvalue) is called
     * valid first arguments are: blob, string, date, sql
     * 
     * eg. $member->updated = $member->sqlValue('NOW()');
     * 
     * 
     * might handle more arguments for escaping later...
     * 
     * @static
     * @param string $value (or type if used with 2 arguments)
     * @param string $callvalue (optional) used with date/null etc..
     * @return PDO_DataObject_Cast 
     */
    
    static function sqlValue($value)
    {
        $method = 'sql';
        if (func_num_args() == 2) {
            $method = $value;
            $value = func_get_arg(1);
        }
        require_once 'PDO/DataObject/Cast.php';
        return call_user_func(array('PDO_DataObject_Cast', $method), $value);
        
    }
    
     /**
     * Copies items that are in the table definitions from an
     * array or object into the current object
     * will not override key values.
     *
     *
     * @param    array | object  $from
     * @param    string  $format eg. map xxxx_name to $object->name using 'xxxx_%s' (defaults to %s - eg. name -> $object->name
     * @param    boolean  $skipEmpty (dont assign empty values if a column is empty (eg. '' / 0 etc...)
     * @access   public
     * @throws  PDO_DataObject_Exception if tableColumns return empty..
     * @return   true on success or array of key=>setValue error message retured from 
     */
    final function setFrom($from, $format = '%s', $skipEmpty=false)
    {
        $keys  = $this->keys();
        $items = $this->tableColumns();
            
        
        if (!$items) {
            $this->raise(
                "setFrom:Could not find table definition for {$this->tableName()}", 
                self::ERROR_INVALIDCONFIG);
            return;
        }
        $overload_return = array();
        foreach ($items as $k => $type) {
            if (in_array($k,$keys)) {
                continue; // dont overwrite keys
            }
            if (!$k) {
                continue; // ignore empty keys!!! what
            }
            
            $chk = is_object($from) &&  property_exists($from, sprintf($format,$k));
                 
            // if from has property ($format($k)      
            if ($chk) {
                $kk = (strtolower($k) == 'from') ? '_from' : $k;
                if (method_exists($this,'set'.$kk)) {
                    $ret = $this->{'set'.$kk}($from->{sprintf($format,$k)});
                    if (is_string($ret)) {
                        $overload_return[$k] = $ret;
                    }
                    continue;
                }
                $this->$k = $from->{sprintf($format,$k)};
                continue;
            }
            
            if (is_object($from)) {
                continue;
            }
            
            if (empty($from[sprintf($format,$k)]) && $skipEmpty) {
                continue;
            }
          
            if (!array_key_exists( sprintf($format,$k), $from)) {
                continue;
            }
           


            $kk = (strtolower($k) == 'from') ? '_from' : $k;
            if (method_exists($this,'set'. $kk)) {
                $ret =  $this->{'set'.$kk}($from[sprintf($format,$k)]);
                if (is_string($ret)) {
                    $overload_return[$k] = $ret;
                }
                continue;
            }
            $val = $from[sprintf($format,$k)];

            // convert's 'null' and null (if enable_null_strings is set..
            if (self::_is_null_member($from, sprintf($format,$k))) {
                $val = $this->sqlValue('NULL');
            }

            if (!is_a($val, 'PDO_DataObject_Cast') && (is_object($val) || is_array($val))) {
                continue;
            }
            $ret = $this->fromValue($k,$val);
            if ($ret !== true)  {
                $overload_return[$k] = $ret === false ? 'Not A Valid Value' : $ret;
            }
            //$this->$k = $from[sprintf($format,$k)];
        }
        if ($overload_return) {
          
            return $overload_return;
        }
        return true;
    }
    
     
    /**
     * Chainable versoin of setFrom()
     *
     * If errors occur on set** methods, then $this->_set_errors will be set to the problem, and an exception is thrown.
     *
     * @param    array | object  $from
     * @param    string  $format eg. map xxxx_name to $object->name using 'xxxx_%s' (defaults to %s - eg. name -> $object->name
     * @param    boolean  $skipEmpty (dont assign empty values if a column is empty (eg. '' / 0 etc...)
     * @access   public
     * @return   PDO_DataObject
     */
    final function set($from, $format = '%s', $skipEmpty=false)
    {
        $ret = $this->setFrom($from, $format, $skipEmpty);
        if ($ret !== true) {
            self::$set_errors  = $ret;
            return $this->raise("Set Errors Returned Values: \n" . print_R($ret,true),self::ERROR_SET);
        }
        return $this;
    }
 
    /**
    * standard set* implementation. - used by set()/setFrom()
    *
    * Current supports
    *   date      = using (standard time format, or unixtimestamp).... so you could create a method :
    *               function setLastread($string) { $this->fromValue('lastread',strtotime($string)); }
    *
    *   time      = using strtotime 
    *   datetime  = using  same as date - accepts iso standard or unixtimestamp.
    *   string    = typecast only..
    * 
    * TODO: add formater:: eg. d/m/Y for date! ???
    *
    * @param   string       column of database
    * @param   mixed        value to assign
    *
    * @return   string|true     (String on error)
    * @access   public
    */
  
    
    function fromValue($col,$value) 
    {
        
        $cols = $this->tableColumns();
        // dont know anything about this col..
        if (!isset($cols[$col]) || is_a($value, 'PDO_DataObject_Cast')) {

            if ($cols[$col] & self::NOTNULL && $value->isNull()) {
                return "setting column $col to Null is invalid as it's NOTNULL";
            }

            $this->$col = $value;
            return true;
        }
        //echo "FROM VALUE $col, {$cols[$col]}, " .  var_export( $value, true) . " \n";
        switch (true) {
            // set to null and column is can be null...
            case ((!($cols[$col] & self::NOTNULL)) && self::_is_null($value)):
                $this->$col = $this->sqlValue('NULL');
                return true;
                
            // fail on setting null on a not null field..
            case (($cols[$col] & self::NOTNULL) && self::_is_null($value)):
                self::debug("Error: $col : type is NOTNULL -> value is equal null", __FUNCTION__);
                return "Error: $col : type is NOTNULL -> value is equal null";
        
            case (($cols[$col] & self::DATE) &&  ($cols[$col] & self::TIME)):
                // empty values get set to '' (which is inserted/updated as NULl
                if (!$value) {
                    $this->$col = '';
                }
            
                if (is_numeric($value)) {
                    $this->$col = date('Y-m-d H:i:s', $value);
                    return true;
                }
                if (!is_string($value)) {
                    self::debug("Error: $col : type is DATE/TIME -> value is not string or number", __FUNCTION__);
                    return "Error: $col : type is DATE/TIME -> value is not string or number";
                }
                $x = new DateTime($value);
                $this->$col = $x->format("Y-m-d H:i:s");
                return true;
            
            
            case ($cols[$col] & self::DATE):
                // empty values get set to '' (which is inserted/updated as NULl
                 
                if (!$value) {
                    $this->$col = '';
                    return true; 
                }
            
                if (is_numeric($value)) {
                    $this->$col = date('Y-m-d',$value);
                    return true;
                }
                
                  if (!is_string($value)) {
                    self::debug("Error: $col : type is DATE -> value is not string or number", __FUNCTION__);
                    return "Error: $col : type is DATE -> value is not string or number";
                }
                // try date!!!!
                
                $x = new DateTime($value);
                $this->$col = $x->format("Y-m-d");
                return true;
            
            case ($cols[$col] & self::TIME):
                // empty values get set to '' (which is inserted/updated as NULl
                if (!$value) {
                    $this->$col = '';
                }
                try {
                    // should we sliently fail to update here???
                    $x = new DateTime($value);
                    $this->$col = $x->format('H:i:s');
                } catch(Exception $e) {
                    self::debug("Error: $col : type is TIME -> Datetime threw an error {$e->getMessage()}", __FUNCTION__);
    
                    return "Error: $col : type is TIME -> Datetime threw an error {$e->getMessage()}";
                }
                
                return true;
            
            case ($cols[$col] & self::STR):
            case ($cols[$col] & self::BLOB):                
                $this->$col = (string) $value;
                return true;
            
            case ($cols[$col] & self::INT):
                $value = is_null($value) ? 0 : $value;
                if (!is_numeric($value)) {
                    return "Error: $col : type is INT -> Non numeric '$value' passed to it";
                }
                $this->$col = $value;
                return true;
               
            // todo : floats numerics and ints...
            default:
                $this->$col = $value;
                return true;
        }
    
    
    
    }
    /**
     * Returns an associative array from the current data
     * (kind of oblivates the idea behind DataObjects, but
     * is usefull if you use it with things like QuickForms.
     *
     * you can use the format to return things like user[key]
     * by sending it $object->toArray('user[%s]')
     *
     * will also return links converted to arrays.
     *
     * @param   string  sprintf format for array
     * @param   bool||number    [true = elemnts that have a value set],
     *                          [false = table + returned colums] ,
     *                          [0 = returned columsn only]
     *
     * @access   public
     * @return   array of key => value for row
     */

    function toArray($format = '%s', $hideEmpty = false) 
    {
         
        // we use false to ignore sprintf.. (speed up..)
        $format = $format == '%s' ? false : $format;
        
        $ret = array();
        $rf = isset($this->_result->fields) ? $this->_result->fields: false;
        
        // table knows better...??? -- table() will use result->fields anyway...
        // need to look at this... -- 
        
        $ar = ($rf !== false) ?
            (($hideEmpty === 0) ? $rf : array_merge($rf, $this->tableColumns())) :
            $this->tableColumns();

        foreach($ar as $k=>$v) {
             
            if (!isset($this->$k)) {
                if (!$hideEmpty) {
                    $ret[$format === false ? $k : sprintf($format,$k)] = '';
                }
                continue;
            }
            // call the overloaded getXXXX() method. - except getLink and getLinks
            if (method_exists($this,'get'.$k)) {
                $ret[$format === false ? $k : sprintf($format,$k)] = $this->{'get'.$k}();
                continue;
            }
            $v = $this->$k;
            if (is_a($v, 'PDO_DataObject_Cast')) {
                if (!$this->$k->canToValue()) {
                    continue;
                }
                $v = $this->$k->toValue();
            }

            // should this call formatValue() ??? -- no... point...??
            $ret[$format === false ? $k : sprintf($format,$k)] = $v;
        }
        if (!$this->_link_loaded) {
            return $ret;
        }
        foreach($this->_link_loaded as $k) {
            $ret[$format === false ? $k : sprintf($format,$k)] = $this->$k->toArray();
        
        }
        
        return $ret;
    }
    
    
     /**
    *  standard formated get* implementation.
    *  BC Break: that the standard date formating is different from DB_DataObject.
    *
    *   
    *
    *  with formaters..
    * supported formaters:  
    *   date/time : d/m/m (eg. php strftime) or pear::Date 
    *   numbers   : %02d (eg. sprintf)
    *  NOTE you will get unexpected results with times like 0000-00-00 !!!
    *
    * 
    * 
    * @param   string       column of database
    * @param   format       foramt
    *
    * @return   true     Description
    * @access   public 
    */
    function formatValue($col,$format = null) 
    {
       
        $cols = $this->tableColumns();
        switch (true) {
            case (($cols[$col] & self::DATE) &&  ($cols[$col] & self::TIME)):
            case ($cols[$col] & self::DATE):
            case ($cols[$col] & self::TIME):
            case ($cols[$col] &  self::MYSQLTIMESTAMP): //?? really????
                if (is_null($format)) {
                    return $this->$col;
                }

                if (!$this->$col) {
                    return '';
                }
                $val = $this->$col;
                if (is_a($val, 'PDO_DataObject_Cast')) {
                    $val = $val->toValue(); // might throw error if you do it on sql='NOW()' etc...
                }
                $r = new DateTime($val);
                return $r->format($format);
                 
            
             
            case ($cols[$col] &  self::BOOL):
                $val =  $this->$col;

                if ($cols[$col] &  self::STR) {
                    // it's a 't'/'f' !
                    $val = ($this->$col === 't');
                }
                $val = (bool) $val;
                switch($format) {
                    case '%s':
                        return $val ? 'true' : 'false';
                    case '%d':
                        return (int)$val;
                    default:
                        return $val;
                  }
                  // should not get here....
               
            default:
                if (is_null($format)) {
                    return $this->$col;
                }

                return sprintf($format,$this->col);
        }
            

    }
    
    

    /**
     * validate the values of the object (usually prior to inserting/updating..)
     *
     * Uses PDO_DataObject_Validate
     *
     * @access  public
     * @return  array of validation results (where key=>value, value=false|object if it failed) or true (if they all succeeded)
     */
    function validate()
    {
        class_exists('PDO_DataObject_Validate') ? '' :
            require_once 'PDO/DataObject/Validate.php';
            
        $v = new PDO_DataObject_Validate($this);
        return $v->validate();
        
    }

   
 
    /**
     * Gets the DB result object related to the objects active query
     *
     * @access public
     * @return PDOStatement|false  
     */
     
    final function result()
    {
        return !$this->_result ? false :
            (is_a($this->_result,'StdClass') ? false : $this->_result);
        
    }
 
   
    
    /* ----------------------- Debugger ------------------ */

    /**
     * Debugger. - use this in your extended classes to output debugging information.
     *
     * Uses PDO_DataObject::DebugLevel(x) to turn it on
     *
     *eg. logging into apache error.log 
     *
     *
     * @param    string $message - message to output
     * @param    string $logtype - bold at start
     * @param    string $level   - output level
     * @access   public
     * @return   none
     */
    static function debug($message, $logtype = 0, $level = 1)
    {
         
        if (!self::$debug  || 
            (is_numeric(self::$debug) &&  self::$debug < $level)) {
            return;
        }
        
        // this is a bit flaky due to php's wonderfull class passing around crap..
        // but it's about as good as it gets..
        
        $bt = debug_backtrace();
        
        $class = $bt[0]['class']; // hopefully...
        
        if (!is_string($message)) {
            $message = print_r($message,true);
        }
        
        if (!is_numeric( self::$debug ) && is_callable( self::$debug)) {
            return call_user_func(self::$debug, $class, $message, $logtype, $level);
        }
        
        if (!ini_get('html_errors')) {
            echo "$class   : $logtype       : $message\n";
            flush();
            return;
        }
        
        $colorize = ($logtype == 'ERROR') ? '<font color="red">' : '<font>';
        echo "<code>{$colorize}<B>$class: $logtype:</B> ". nl2br(htmlspecialchars($message)) . "</font></code><BR>\n";
    }

    /**
     * sets and returns debug level
     * eg. PDO_DataObject::debugLevel(4);
     * without arguments it just returns the existing debug level
     * It's an alias for PDO_DataObject::config('debug', $value);
     *
     * @param   int     $v  level
     * @access  public
     * @return  none
     */
    static function debugLevel($v = null)
    {   
        if ($v !== null) {
            return self::config('debug', $v);
        }
        return self::$debug;
    }


    /**
     * wrapper around throw exception.
     *
     * @param  string $message    message
     * @param  string $type       type
     * @param  Exception (optional) $previous_exception  Cause of error...
     * @access public
     * @return error object
     */
    function raise($message, $type  , $previous_exception = null)
    {
        
        self::debug($message,__FUNCTION__,1);
        
        class_exists('PDO_DataObject_Exception') ? '' :
            require_once 'PDO/DataObject/Exception.php';
         
        throw  PDO_DataObject_Exception::factory($message, $type, $previous_exception);
             
    }

    
     /**
     * Free the result object.
     * and resets other variables...
     *
     *
     * @access   public
     * @return   none
     */
    function free() 
    {
        $this->_result = false;
        
        $cls = __CLASS__;
        $qref = (new ReflectionClass($cls))->getProperty('_query');
        $qref->setAccessible(true);
        $this->_query = $qref->getValue(new $cls());
        
        
        
        if (isset($this->_link_loaded) && !is_array($this->_link_loaded)) {
            return;
        }
        // link code must ensure that 'member of the _link_loaded array
        foreach ($this->_link_loaded as $do) {
            $this->{$do}->free();
             
        }
          
    }
     /**
     * Free the global statics - like connections, and loaded links files etc..
     * and resets other variables...
     *
     * Note - this is realy only for testing - calling it will likely slow down any future calls to the database
     *
     * @access   public
     * @return   none
     */
    static function reset()
    {
        self::$connections = array(); 
        self::$ini = array();
        self::$links = array();
        self::$sequence = array();
        
    }
    /**
    * Null member testing
    *
    * Testing for null is a bit of a nightmare... - the database may have null values in it, but that does not mean 
    * that properties are actually set to null..!!!
    *
    * When updateing / inserting or searching queries need to be built based on the properties.
    * 
    * when a column is NOT_NULL - we just ignore any null testing... the value is either set or not-set...
    *
    * when a column allows NULL
    *     then we have to determine was it actually set to NULL by the user, or was it just empty, and never filled in.
    *     if you use real null values, not CAST , then we can only really detect it when you use 'set/setFrom'
    *         in which case we actually set the value to a CAST.. 
    * 
    * enable_null_strings (seriously not recommended) - modifies the behaviour - it's really only for BC code.
    *     setting it to true = then 'null' as a string works..
    *     setting it to 'full' - results in $this->XXXX << even if it's not set, then we read it as null!!!
    *
    * @param  object|array $obj_or_ar 
    * @param  string|false $prop prperty
    
    * @access private
    * @return bool  object
    */
    static function _is_null_member($obj_or_ar , $prop) 
    {
     	
        switch(true) {
              case is_array($obj_or_ar):
                  $isset = isset($obj_or_ar[$prop]);
                  $value = $isset ? $obj_or_ar[$prop] : null;
                  break;
              
              case is_object($obj_or_ar):
                  $isset = isset($obj_or_ar->$prop);
                  $value = $isset ? $obj_or_ar->$prop : null;
                  break;

              default:
                  self::raise("argument passed to is_null_member was not an object or array",
                        self::ERROR_INVALIDARGS);
        }
   
          
        if ($isset) {
            return self::_is_null($value);
        }
        
        $crazy_null =   self::$config['enable_null_strings'] === 'full'; // why case insensitive?
       
        if ( $crazy_null && !$isset )  {
        	  return true;
        }
        
        return false;
        
    	
    }
    /**
    * Check a value, to see if it matches our 'null' rules
    * normally  real null, and CAST('null') will match
    * if you have enable_null_strings (not recommended) then string 'null' will also return true.
    * 
    * @param  mixed $value to check
    
    * @access private
    * @return bool  object
    */
    static function _is_null($value) 
    {
     	
        $null_strings =  self::$config['enable_null_strings'] !== false;
        
        if (is_a($value, 'PDO_DataObject_Cast') && $value->isNull()) {
            return true;
        }
        if (is_null($value)) {
            return true;
        }
        
        if ( $null_strings  && is_string($value)  && (strtolower($value) === 'null') ) {
            return true;
        }
        
        
        return false;
        
    	
    }
     
    
    
    
} 

