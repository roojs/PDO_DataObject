<?php
/**
 * Object Based Database Query Builder and data store
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
  
   
 
class PDO_DataObject
{
   /**
    * The Version - use this to check feature changes
    *
    * @access   private
    * @var      string
    */
    public $_PDO_DataObject_version = "1.0";
 
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
    */
    const WHEREADD_ONLY = true;

    /**
     * used by config[portability]
     */
    
    const PORTABILITY_LOWERCASE =  1;  // from Pear DB compatibility options..
    
    /**
     * 
     * Theses are the standard error codes - 
     * 
     */
    
    const ERROR_INVALIDARGS =   -1;  // wrong args to function
    const ERROR_NODATA =        -2;  // no data available
    const ERROR_INVALIDCONFIG = -3;  // something wrong with the config
    const ERROR_NOCLASS =       -4;  // no class exists
    
    
    
    const ERROR_DIE  =  9;  // from PEAR_ERROR_DIE

    
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
                // normally we use pre-created 'ini' files, but if you use proxy, it will generate the
                // the database schema on the fly..
                // true - calls PDO_DataObject_Generator->
                // full|light ??? - not sure what these do ....
                // YourClass::somemethod... --- calls some other method to generate proxy..
            
            
            
            'portability' => 0,
                // similar to DB's portability setting,
                // currently it only lowercases the tablename when you call tableName(), and
                // flatten's ini files ..
                
            'disable_null_strings' => false,
                // DataObjects will convert the text value 'null' to NULL when building queries
                // this may cause problems! Setting to true will turn off this feature.
                // you can use DB_DataObject_Cast::SQL('NULL'); in where you have to turn this off.
		 
                // can also be set to 'full' however - this may delete data quietly if properties are 
                // not fetched and are set *** Highly recommended not to use this..
                
                
        //  NEW ------------   peformance 
             
            'fetch_into' => false,
                // use PDO's fetch_INTO for performance... - not sure what other effects this may have..
            
            // -----   behavior
            
            'keep_query_after_fetch' => false,
                // the query building will be cleared after a fetch , or find 
                // To disable this behavior set this to 1

                
            'debug' => 0,
                // debuging - only relivant on initialization - modifying it after, may be ignored.
                
            'PDO' => 'PDO',  
                // what class to use as PDO - we use PDO_Dummy for the unittests

        
        
        // -------- Error handling --------
            
            'exceptions' => true,
                // new behaviour is to throw exceptions - everywhere!!!
                // to turn on 'old' behaviour - use 'exceptions' => false
                
            
            'dont_die' => false,
                // normally errors are triggered
                // if non-exception behaviour is on then we trigger PEAR error's with
                // if a fatal erorr occurs - we normally die.. but this can be prevented by
                // this flag -- I'm not sure how usefull it is, as if you use a global pear error handler
                // you can catch the error anyway
        
         

    );
    
    static $debug = 0;
    
    private static $config_loaded = false; // flag to indicate if we have attempted to load config from PEAR::getStaticProperty
    
    
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
     *
     * @access  public
     * @var     int
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
        'data_select' => '*', // the columns to be SELECTed
        'unions'      => array(), // the added unions,
        'derive_table' => '', // derived table name (BETA)
        'derive_select' => '', // derived table select (BETA)
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
            $this->debug(json_encode(func_get_args()), __FUNCTION__,1);
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
            $this->raiseError("Could not find INI values for database={$this->_database} and table={$this->__table}", self::ERROR_INVALIDARGS, self::ERROR_DIE );
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
    function PDO()
    {
        
        $config = self::config();
         
        // We can use a fake PDO class when testing..
        $PDO = $config['PDO'];
        
        // is it already connected ?    
        if ($this->_database_dsn_md5 && !empty(self::$connections[$this->_database_dsn_md5])) {
            
            $con = self::$connections[$this->_database_dsn_md5];
            
            // connection is an error...?? assumes pear error???
            if (!is_a($con, $PDO)) {
                
                return $this->raiseError(
                        $con->message,
                        $con->code, self::ERROR_DIE
                );
                 
            }

            if (empty($this->_database_nickname)) {
                $this->_database = $con->dsn['nickname'];
                
                // note
                // sqlite -- database == basename of database...
                // ibase -- last 4 characters (substring basename, 0, -4 )
                
            }
            
            if (self::$debug) {
                $this->debug("Using Cached connection",__FUNCTION__);
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
            return $this->raiseError(
                "No database name / dsn found anywhere",
                self::ERROR_INVALIDCONFIG, self::ERROR_DIE
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
                    return $this->raiseError("Invalid syntax of DSN : {$dsn}\n". print_r($dsn_ar,true), 0, self::ERROR_DIE);
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
            $this->debug( (string) $ex , "CONNECT FAILED",5);
            return $this->raiseError("Connect failed, turn on debugging to 5 see why",0,self::ERROR_DIE, $ex );
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
     * Configuration can be loaded from 
     * PEAR::getStaticProperty('PDO_DataObject','options');
     * (part of PEAR5.php)
     * This is available for backward Compatibility - new versions should just include this file
     * and set the options via config({array})
     *  Just including this file does not load anything else -- like pear.. etc..
     *  So it's a relatively low overhead..
     *
     *
     * @access   private
     * @return   Void
     */
    private static function _loadPEARConfig()
    {
        
        if (self::$config_loaded) {
            return;
        }
        self::$config_loaded = true;
        
        if (!class_exists('PEAR', false)) {
            return;
        }
        
        $cfg = PEAR::getStaticProperty('PDO_DataObject','options');
        foreach ($cfg as $k=>$v) {
            if (!isset(self::$config[$k])) {
                $this->raiseError("Invalid PEAR PDO_DataObject Configuration setting : $k",
                                  self::ERROR_INVALIDCONFIG, self::ERROR_DIE);
            }
            self::$config[$k] = $v;
        }
        if (isset($cfg['debug'])) {
            self::$debug = $cfg['debug'];
        }
        

    }
    
    /**
     * Set/get the global configuration...
     * Used to be via PEAR::getStaticProperty() - now depricated..
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
        self::_loadPEARConfig();
        
        if (!func_num_args()) {
            return self::$config;
        }
        
        if (!is_array($cfg_in) && func_num_args() < 2) {
            // one arg = not an array..
            (new PDO_DataObject())->raiseError("Invalid Call to config should be string+anther value or array",
                              self::ERROR_INVALIDARGS, self::ERROR_DIE);
        }
        
        $old = self::$config;
        
        $cfg = $cfg_in;
        
        if (func_num_args() > 1) {
            // two args..
            if (!is_string($cfg_in)) {
                (new PDO_DataObject())->raiseError("Invalid Call to config should be string+anther value or array",
                              self::ERROR_INVALIDARGS, self::ERROR_DIE);    
            }
            
            $k = $cfg_in;
            $cfg = array();
            $cfg[$k] = $value;
        } 
          
        foreach ($cfg as $k=>$v) {
            if (!isset(self::$config[$k])) {
                (new PDO_DataObject())->raiseError("Invalid Configuration setting : $k",
                        self::ERROR_INVALIDCONFIG, self::ERROR_DIE);
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
    function quoteIdentifier($str)
    {
        $pdo = $this->PDO();
        if (!is_a($pdo, self::$config['PDO'])) {
            $this->raiseError("Can not quoteIdentifier as connection failed", $pdo, self::ERROR_DIE);
        }
        
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
    function modifyLimitQuery($sql, $manip=false)
    {
        $start = $this->_query['limit_start'];
        $count = $this->_query['limit_count'];
        if ($start === '' && $end === '') {
            return $sql;
        }
        $count = (int)$count;
        $start = (int)$start;
        $drv = $this->PDO()->getAttribute(PDO::ATTR_DRIVER_NAME);
        switch($drv) {
            case 'mysql':
                if ($manip && $start) {
                    $this->raiseError("Mysql may not support offset in modification queries",
                            self::ERROR_INVALIDARGS, self::ERROR_DIE); // from PEAR DB?
                }
                $start = empty($start) ? '': ($start .',');
                return "$sql LIMIT $start $count";
            
            case 'sqlite':
            case 'sqlite2':
            case 'pgsql':
                return "$sql LIMIT $count OFFSET $start";
            case 'oci':
                if ($manip) {
                    $this->raiseError("Oracle may not support offset in modification queries",
                            self::ERROR_INVALIDARGS, self::ERROR_DIE); // from PEAR DB?
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
                $this->raiseError("The Database $drv, does not support limit queries - if you know how this can be added, please send a patch.",
                    self::ERROR_INVALIDARGS, self::ERROR_DIE); // from PEAR DB?
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
     * @param   string  $k column
     * @param   string  $v value
     * @access  public
     * @return  int     No. of rows
     */
    function get($k = null, $v = null)
    {
        global $_DB_DATAOBJECT;
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            PDO_DataObject::config();
        }
        $keys = array();
        
        if ($v === null) {
            $v = $k;
            $keys = $this->keys();
            if (!$keys) {
                $this->raiseError("No Keys available for {$this->tableName()}", DB_DATAOBJECT_ERROR_INVALIDCONFIG);
                return false;
            }
            $k = $keys[0];
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("$k $v " .print_r($keys,true), "GET");
        }
        
        if ($v === null) {
            $this->raiseError("No Value specified for get", DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        $this->$k = $v;
        return $this->find(1);
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
     * @return the id 
     */
    function pid()
    {
        $keys = $this->keys();
        if (!$keys) {
            $this->raiseError("No Keys available for {$this->tableName()}",
                            DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }
        $k = $keys[0];
        if (empty($this->$k)) { // we do not 
            $this->raiseError("pid() called on Object where primary key value not available",
                            DB_DATAOBJECT_ERROR_NODATA);
            return false;
        }
        return $this->$k;
    }
    


    /**
     * build the basic select query.
     * 
     * @access private
     */
    
    function _build_select()
    {
        global $_DB_DATAOBJECT;
        $quoteIdentifiers = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);
        if ($quoteIdentifiers) {
            $this->_connect();
            $DB = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
        }
        $tn = ($quoteIdentifiers ? $DB->quoteIdentifier($this->tableName()) : $this->tableName()) ;
        if (!empty($this->_query['derive_table']) && !empty($this->_query['derive_select']) ) {
            
            // this is a derived select..
            // not much support in the api yet..
            
             $sql = 'SELECT ' .
               $this->_query['derive_select']
               .' FROM ( SELECT'.
                    $this->_query['data_select'] . " \n" .
                    " FROM   $tn  " . $this->_query['useindex'] . " \n" .
                    $this->_join . " \n" .
                    $this->_query['condition'] . " \n" .
                    $this->_query['group_by'] . " \n" .
                    $this->_query['having'] . " \n" .
                ') ' . $this->_query['derive_table'];
                     
            return $sql;
            
            
        }
        
       
        
        $sql = 'SELECT ' .
            $this->_query['data_select'] . " \n" .
            " FROM   $tn  " . $this->_query['useindex'] . " \n" .
            $this->_join . " \n" .
            $this->_query['condition'] . " \n" .
            $this->_query['group_by'] . " \n" .
            $this->_query['having'] . " \n";
                 
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
     * if numRows is not supported it will 
     * 
     *
     * @param   boolean $n Fetch first result
     * @access  public
     * @return  mixed (number of rows returned, or true if numRows fetching is not supported)
     */
    function find($n = false)
    {
        global $_DB_DATAOBJECT;
        if ($this->_query === false) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)", 
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            PDO_DataObject::config();
        }

        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug($n, "find",1);
        }
        if (!strlen($this->tableName())) {
            // xdebug can backtrace this!
            trigger_error("NO \$__table SPECIFIED in class definition",E_USER_ERROR);
        }
        $this->N = 0;
        $query_before = $this->_query;
        $this->_build_condition($this->table()) ;
        
       
        $this->_connect();
        $DB = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
       
        
        $sql = $this->_build_select();
        
        foreach ($this->_query['unions'] as $union_ar) {  
            $sql .=   $union_ar[1] .   $union_ar[0]->_build_select() . " \n";
        }
        
        $sql .=  $this->_query['order_by']  . " \n";
        
        
        /* We are checking for method modifyLimitQuery as it is PEAR DB specific */
        
        $sql = $this->modifyLimitQuery($sql);
        
        
        $err = $this->_query($sql);
        if (is_a($err,'PEAR_Error')) {
            return false;
        }
        
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("CHECK autofetchd $n", "find", 1);
        }
        
        // find(true)
        
        $ret = $this->N;
        if (!$ret && !empty($_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid])) {     
            // clear up memory if nothing found!?
            unset($_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid]);
        }
        
        if ($n && $this->N > 0 ) {
            if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                $this->debug("ABOUT TO AUTOFETCH", "find", 1);
            }
            $fs = $this->fetch();
            // if fetch returns false (eg. failed), then the backend doesnt support numRows (eg. ret=true)
            // - hence find() also returns false..
            $ret = ($ret === true) ? $fs : $ret;
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("DONE", "find", 1);
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
     *
     * @access  public
     * @return  boolean on success
     */
    function fetch()
    {

        
        if (!self::$config_loaded) {
            PDO_DataObject::config();
        }
        if ($this->N === false) {
            $this->raiseError("Fetch Called without Query being run");
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
                $this->debug('fetched on object after fetch completed (no results found)');
            }
            return false;
        }
        //PDO::FETCH_ASSOC
        
        // fast_fetch - experimentall... - not sure what happens on missing/null values etc.. on rows.
        if (self::$config['fetch_into']) {
            $array = $this->_result->fetch(PDO::FETCH_INTO|PDO::FETCH_ASSOC, $this);
        } else {
            $array = $this->_result->fetch(PDO::FETCH_ASSOC);
            if (self::$debug) {
                $this->debug(json_encode($array),"FETCH");
            }
        }
        
         
        
        if (!$array) {
                
            if (self::$debug) {
                $t= explode(' ',microtime());
            
                $this->debug("Last Data Fetch'ed after " . 
                        number_format($t[0]+$t[1]- $this->_result->time_query_end ,3) . 
                        " seconds",
                    "FETCH", 2);
            }
            $fields = $this->_result->fields;
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
                    $this->debug("$kk = ". $array[$k], "fetchrow LINE", 4);
                }
                $this->$kk = $array[$k];
            }
        }
        // set link flag
        $this->_link_loaded = false;
        if (self::$debug) {
            $this->debug("{$this->tableName()} DONE", "fetchrow",2);
        }
        if (($this->_query !== false) &&  !self::$config['keep_query_after_fetch']) {
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
     * A) Array of values (eg. a list of 'id')
     *
     * $x = DB_DataObject::factory('mytable');
     * $x->whereAdd('something = 1')
     * $ar = $x->fetchAll('id');
     * -- returns array(1,2,3,4,5)
     *
     * B) Array of values (not from table)
     *
     * $x = DB_DataObject::factory('mytable');
     * $x->whereAdd('something = 1');
     * $x->selectAdd();
     * $x->selectAdd('distinct(group_id) as group_id');
     * $ar = $x->fetchAll('group_id');
     * -- returns array(1,2,3,4,5)
     *     *
     * C) A key=>value associative array
     *
     * $x = DB_DataObject::factory('mytable');
     * $x->whereAdd('something = 1')
     * $ar = $x->fetchAll('id','name');
     * -- returns array(1=>'fred',2=>'blogs',3=> .......
     *
     * D) array of objects
     * $x = DB_DataObject::factory('mytable');
     * $x->whereAdd('something = 1');
     * $ar = $x->fetchAll();
     *
     * E) array of arrays (for example)
     * $x = DB_DataObject::factory('mytable');
     * $x->whereAdd('something = 1');
     * $ar = $x->fetchAll(false,false,'toArray');
     *
     *
     * @param    string|false  $k key
     * @param    string|false  $v value
     * @param    string|false  $method method to call on each result to get array value (eg. 'toArray')
     * @access  public
     * @return  array  format dependant on arguments, may be empty
     */
    function fetchAll($k= false, $v = false, $method = false)  
    {
        // should it even do this!!!?!?
        if ($k !== false && 
                (   // only do this is we have not been explicit..
                    empty($this->_query['data_select']) || 
                    ($this->_query['data_select'] == '*')
                )
            ) {
            $this->selectAdd();
            $this->selectAdd($k);
            if ($v !== false) {
                $this->selectAdd($v);
            }
        }
        if (!$this->_result) {
            $this->find();
        }
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
    
    function fetchAllFast($key_col=false, $value_col=false)
    {
        $args = func_num_args();
        if (!$args) {
            return $this->_result->fetchAll(PDO::FETCH_ASSOC);
        }
        if ($args  === 1 && $key_col === true) { // first column...
            return $this->_result->fetchAll(PDO::FETCH_COLUMN, 0);
        }
        
        
    }
    
    
    /**
     * Adds a condition to the WHERE statement, defaults to AND
     *
     * $object->whereAdd(); //reset or cleaer ewhwer
     * $object->whereAdd("ID > 20");
     * $object->whereAdd("age > 20","OR");
     *
     * @param    string  $cond  condition
     * @param    string  $logic optional logic "OR" (defaults to "AND")
     * @access   public
     * @return   string|PEAR::Error - previous condition or Error when invalid args found
     */
    function whereAdd($cond = false, $logic = 'AND')
    {
        // for PHP5.2.3 - there is a bug with setting array properties of an object.
        $_query = $this->_query;
         
        if (!isset($this->_query) || ($_query === false)) {
            return $this->raiseError(
                "You cannot do two queries on the same object (clone it before finding)", 
                DB_DATAOBJECT_ERROR_INVALIDARGS);
        }
        
        if ($cond === false) {
            $r = $this->_query['condition'];
            $_query['condition'] = '';
            $this->_query = $_query;
            return preg_replace('/^\s+WHERE\s+/','',$r);
        }
        // check input...= 0 or '   ' == error!
        if (!trim($cond)) {
            return $this->raiseError("WhereAdd: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }
        $r = $_query['condition'];
        if ($_query['condition']) {
            $_query['condition'] .= " {$logic} ( {$cond} )";
            $this->_query = $_query;
            return $r;
        }
        $_query['condition'] = " WHERE ( {$cond} ) ";
        $this->_query = $_query;
        return $r;
    }

    /**
    * Adds a 'IN' condition to the WHERE statement
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
    * @return   string|PEAR::Error - previous condition or Error when invalid args found
    */
    function whereAddIn($key, $list, $type, $logic = 'AND') 
    {
        $not = '';
        if ($key[0] == '!') {
            $not = 'NOT ';
            $key = substr($key, 1);
        }
        // fix type for short entry. 
        $type = $type == 'int' ? 'integer' : $type; 

        if ($type == 'string') {
            $this->_connect();
        }

        $ar = array();
        foreach($list as $k) {
            settype($k, $type);
            $ar[] = $type == 'string' ? $this->_quote($k) : $k;
        }
      
        if (!$ar) {
            return $not ? $this->_query['condition'] : $this->whereAdd("1=0");
        }
        return $this->whereAdd("$key $not IN (". implode(',', $ar). ')', $logic );    
    }

    
    
    /**
     * Adds a order by condition
     *
     * $object->orderBy(); //clears order by
     * $object->orderBy("ID");
     * $object->orderBy("ID,age");
     *
     * @param  string $order  Order
     * @access public
     * @return none|PEAR::Error - invalid args only
     */
    function orderBy($order = false)
    {
        if ($this->_query === false) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)", 
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        if ($order === false) {
            $this->_query['order_by'] = '';
            return;
        }
        // check input...= 0 or '    ' == error!
        if (!trim($order)) {
            return $this->raiseError("orderBy: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }
        
        if (!$this->_query['order_by']) {
            $this->_query['order_by'] = " ORDER BY {$order} ";
            return;
        }
        $this->_query['order_by'] .= " , {$order}";
    }

    /**
     * Adds a group by condition
     *
     * $object->groupBy(); //reset the grouping
     * $object->groupBy("ID DESC");
     * $object->groupBy("ID,age");
     *
     * @param  string  $group  Grouping
     * @access public
     * @return none|PEAR::Error - invalid args only
     */
    function groupBy($group = false)
    {
        if ($this->_query === false) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)", 
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        if ($group === false) {
            $this->_query['group_by'] = '';
            return;
        }
        // check input...= 0 or '    ' == error!
        if (!trim($group)) {
            return $this->raiseError("groupBy: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }
        
        
        if (!$this->_query['group_by']) {
            $this->_query['group_by'] = " GROUP BY {$group} ";
            return;
        }
        $this->_query['group_by'] .= " , {$group}";
    }

    /**
     * Adds a having clause
     *
     * $object->having(); //reset the grouping
     * $object->having("sum(value) > 0 ");
     *
     * @param  string  $having  condition
     * @access public
     * @return none|PEAR::Error - invalid args only
     */
    function having($having = false)
    {
        if ($this->_query === false) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)", 
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        if ($having === false) {
            $this->_query['having'] = '';
            return;
        }
        // check input...= 0 or '    ' == error!
        if (!trim($having)) {
            return $this->raiseError("Having: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }
        
        
        if (!$this->_query['having']) {
            $this->_query['having'] = " HAVING {$having} ";
            return;
        }
        $this->_query['having'] .= " AND {$having}";
    }

    /**
     * Adds a using Index
     *
     * $object->useIndex(); //reset the use Index 
     * $object->useIndex("some_index");
     *
     * Note do not put unfiltered user input into theis method.
     * This is mysql specific at present? - might need altering to support other databases.
     * 
     * @param  string|array  $index  index or indexes to use.
     * @access public
     * @return none|PEAR::Error - invalid args only
     */
    function useIndex($index = false)
    {
        if ($this->_query === false) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)", 
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        if ($index=== false) {
            $this->_query['useindex'] = '';
            return;
        }
        // check input...= 0 or '    ' == error!
        if ((is_string($index) && !trim($index)) || (is_array($index) && !count($index)) ) {
            return $this->raiseError("Having: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }
        $index = is_array($index) ? implode(', ', $index) : $index;
        
        if (!$this->_query['useindex']) {
            $this->_query['useindex'] = " USE INDEX ({$index}) ";
            return;
        }
        $this->_query['useindex'] =  substr($this->_query['useindex'],0, -2) . ", {$index}) ";
    }
    /**
     * Sets the Limit
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
    function limit($a = null, $b = null)
    {
        
        if ($this->_query === false) {
            return $this->raiseError(
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
            return $this->raiseError("limit: No Valid Arguments", self::ERROR_INVALIDARGS);
        }
        // used to connect here?? why?
        
        $this->_query['limit_start'] = func_num_args() < 2 ? 0 : (int)$a;
        $this->_query['limit_count'] = func_num_args() < 2  ? (int)$a : (int)$b;
        return $this;
        
    }

    /**
     * Adds a select columns
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
    function selectAdd($k = null)
    {
        if ($this->_query === false) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)", 
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        if ($k === null) {
            $old = $this->_query['data_select'];
            $this->_query['data_select'] = '';
            return $old;
        }
        
        // check input...= 0 or '    ' == error!
        if (!trim($k)) {
            return $this->raiseError("selectAdd: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }
        
        if ($this->_query['data_select']) {
            $this->_query['data_select'] .= ', ';
        }
        $this->_query['data_select'] .= " $k ";
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
     *
     * @param  array|object|null the array or object to take column names from.
     * @param  string           format in sprintf format (use %s for the colname)
     * @param  string           table name eg. if you have joinAdd'd or send $from as an array.
     * @access public
     * @return void
     */
    function selectAs($from = null,$format = '%s',$tableName=false)
    {
        global $_DB_DATAOBJECT;
        
        if ($this->_query === false) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)", 
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        
        if ($from === null) {
            // blank the '*' 
            $this->selectAdd();
            $from = $this;
        }
        
        
        $table = $this->tableName();
        if (is_object($from)) {
            $table = $from->tableName();
            $from = array_keys($from->table());
        }
        
        if ($tableName !== false) {
            $table = $tableName;
        }
        $s = '%s';
        if (!empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers'])) {
            $this->_connect();
            $DB = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
            $s      = $DB->quoteIdentifier($s);
            $format = $DB->quoteIdentifier($format); 
        }
        foreach ($from as $k) {
            $this->selectAdd(sprintf("{$s}.{$s} as {$format}",$table,$k,$k));
        }
        $this->_query['data_select'] .= "\n";
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
     * @return mixed false on failure, int when auto increment or sequence used, otherwise true on success
     */
    function insert()
    {
        global $_DB_DATAOBJECT;
        
        // we need to write to the connection (For nextid) - so us the real
        // one not, a copyied on (as ret-by-ref fails with overload!)
        
        if (!isset($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            $this->_connect();
        }
        
        $quoteIdentifiers  = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);
        
        $DB = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
         
        $items = $this->table();
            
        if (!$items) {
            $this->raiseError("insert:No table definition for {$this->tableName()}",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }
        $options = $_DB_DATAOBJECT['CONFIG'];


        $datasaved = 1;
        $leftq     = '';
        $rightq    = '';
     
        $seqKeys   = isset($_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()]) ?
                        $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()] : 
                        $this->sequenceKey();
        
        $key       = isset($seqKeys[0]) ? $seqKeys[0] : false;
        $useNative = isset($seqKeys[1]) ? $seqKeys[1] : false;
        $seq       = isset($seqKeys[2]) ? $seqKeys[2] : false;
        
        $dbtype    = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn["phptype"];
        
         
        // nativeSequences or Sequences..     

        // big check for using sequences
        
        if (($key !== false) && !$useNative) { 
        
            if (!$seq) {
                $keyvalue =  $DB->nextId($this->tableName());
            } else {
                $f = $DB->getOption('seqname_format');
                $DB->setOption('seqname_format','%s');
                $keyvalue =  $DB->nextId($seq);
                $DB->setOption('seqname_format',$f);
            }
            if (PEAR::isError($keyvalue)) {
                $this->raiseError($keyvalue->toString(), DB_DATAOBJECT_ERROR_INVALIDCONFIG);
                return false;
            }
            $this->$key = $keyvalue;
        }
        
        // if we haven't set disable_null_strings to "full"
        $ignore_null = $options['disable_null_strings'] === false; // default...
                    
             
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
            if ($v & DB_DATAOBJECT_MYSQLTIMESTAMP) {
                continue;
            }
            
            if ($leftq) {
                $leftq  .= ', ';
                $rightq .= ', ';
            }
            
            $leftq .= ($quoteIdentifiers ? ($DB->quoteIdentifier($k) . ' ')  : "$k ");
            
            if (is_object($this->$k) && is_a($this->$k,'DB_DataObject_Cast')) {
                $value = $this->$k->toString($v,$DB);
                if (PEAR::isError($value)) {
                    $this->raiseError($value->toString() ,DB_DATAOBJECT_ERROR_INVALIDARGS);
                    return false;
                }
                $rightq .=  $value;
                continue;
            }
            
            
            if (!($v & DB_DATAOBJECT_NOTNULL) && DB_DataObject::_is_null($this,$k)) {
                $rightq .= " NULL ";
                continue;
            }
            // DATE is empty... on a col. that can be null.. 
            // note: this may be usefull for time as well..
            if (!$this->$k && 
                    (($v & DB_DATAOBJECT_DATE) || ($v & DB_DATAOBJECT_TIME)) && 
                    !($v & DB_DATAOBJECT_NOTNULL)) {
                    
                $rightq .= " NULL ";
                continue;
            }
              
            
            if ($v & DB_DATAOBJECT_STR) {
                $rightq .= $this->_quote((string) (
                        ($v & DB_DATAOBJECT_BOOL) ? 
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
                $this->debug('ODD DATA: ' .$k . ' ' .  print_r($this->$k,true),'ERROR');
            }
            
            // at present we only cast to integers
            // - V2 may store additional data about float/int
            $rightq .= ' ' . intval($this->$k) . ' ';

        }
        
        // not sure why we let empty insert here.. - I guess to generate a blank row..
        
        
        if ($leftq || $useNative) {
            $table = ($quoteIdentifiers ? $DB->quoteIdentifier($this->tableName())    : $this->tableName());
            
            
            if (($dbtype == 'pgsql') && empty($leftq)) {
                $r = $this->_query("INSERT INTO {$table} DEFAULT VALUES");
            } else {
               $r = $this->_query("INSERT INTO {$table} ($leftq) VALUES ($rightq) ");
            }
            
 
            
            
            if (PEAR::isError($r)) {
                $this->raiseError($r);
                return false;
            }
            
            if ($r < 1) {
                return 0;
            }
            
            
            // now do we have an integer key!
            
            if ($key && $useNative) {
                switch ($dbtype) {
                    case 'mysql':
                    case 'mysqli':
                        $method = "{$dbtype}_insert_id";
                        $this->$key = $method(
                            $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->connection
                        );
                        break;
                    
                    case 'mssql':
                        // note this is not really thread safe - you should wrapp it with 
                        // transactions = eg.
                        // $db->query('BEGIN');
                        // $db->insert();
                        // $db->query('COMMIT');
                        $db_driver = empty($options['db_driver']) ? 'DB' : $options['db_driver'];
                        $method = ($db_driver  == 'DB') ? 'getOne' : 'queryOne';
                        $mssql_key = $DB->$method("SELECT @@IDENTITY");
                        if (PEAR::isError($mssql_key)) {
                            $this->raiseError($mssql_key);
                            return false;
                        }
                        $this->$key = $mssql_key;
                        break; 
                        
                    case 'pgsql':
                        if (!$seq) {
                            $seq = $DB->getSequenceName(strtolower($this->tableName()));
                        }
                        $db_driver = empty($options['db_driver']) ? 'DB' : $options['db_driver'];
                        $method = ($db_driver  == 'DB') ? 'getOne' : 'queryOne';
                        $pgsql_key = $DB->$method("SELECT currval('".$seq . "')"); 


                        if (PEAR::isError($pgsql_key)) {
                            $this->raiseError($pgsql_key);
                            return false;
                        }
                        $this->$key = $pgsql_key;
                        break;
                    
                    case 'ifx':
                        $this->$key = array_shift (
                            ifx_fetch_row (
                                ifx_query(
                                    "select DBINFO('sqlca.sqlerrd1') FROM systables where tabid=1",
                                    $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->connection,
                                    IFX_SCROLL
                                ), 
                                "FIRST"
                            )
                        ); 
                        break;
                    
                }
                        
            }

            if (isset($_DB_DATAOBJECT['CACHE'][strtolower(get_class($this))])) {
                $this->_clear_cache();
            }
            if ($key) {
                return $this->$key;
            }
            return true;
        }
        $this->raiseError("insert: No Data specifed for query", DB_DATAOBJECT_ERROR_NODATA);
        return false;
    }

    /**
     * Updates  current objects variables into the database
     * uses the keys() to decide how to update
     * Returns the  true on success
     *
     * for example
     *
     * $object = DB_DataObject::factory('mytable');
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
     * $object = DB_DataObject::factory('mytable');
     * $object->status = "dead";
     * $object->whereAdd('age > 150');
     * $object->update(DB_DATAOBJECT_WHEREADD_ONLY);
     *
     * @param object dataobject (optional) | DB_DATAOBJECT_WHEREADD_ONLY - used to only update changed items.
     * @access public
     * @return  int rows affected or false on failure
     */
    function update($dataObject = false)
    {
        global $_DB_DATAOBJECT;
        // connect will load the config!
        $this->_connect();
        
        
        $original_query =  $this->_query;
        
        $items = $this->table();
        
        // only apply update against sequence key if it is set?????
        
        $seq    = $this->sequenceKey();
        if ($seq[0] !== false) {
            $keys = array($seq[0]);
            if (!isset($this->{$keys[0]}) && $dataObject !== true) {
                $this->raiseError("update: trying to perform an update without 
                        the key set, and argument to update is not 
                        DB_DATAOBJECT_WHEREADD_ONLY
                    ". print_r(array('seq' => $seq , 'keys'=>$keys), true), DB_DATAOBJECT_ERROR_INVALIDARGS);
                return false;  
            }
        } else {
            $keys = $this->keys();
        }
        
         
        if (!$items) {
            $this->raiseError("update:No table definition for {$this->tableName()}", DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }
        $datasaved = 1;
        $settings  = '';
        $this->_connect();
        
        $DB            = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
        $dbtype        = $DB->dsn["phptype"];
        $quoteIdentifiers = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);
        $options = $_DB_DATAOBJECT['CONFIG'];
        
        
        $ignore_null = $options['disable_null_strings'] === false;
                    
      
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
            if ($v & DB_DATAOBJECT_MYSQLTIMESTAMP) {
                continue;
            }
            
            
            if ($settings)  {
                $settings .= ', ';
            }
            
            $kSql = ($quoteIdentifiers ? $DB->quoteIdentifier($k) : $k);
            
            if (is_object($this->$k) && is_a($this->$k,'DB_DataObject_Cast')) {
                $value = $this->$k->toString($v,$DB);
                if (PEAR::isError($value)) {
                    $this->raiseError($value->getMessage() ,DB_DATAOBJECT_ERROR_INVALIDARG);
                    return false;
                }
                $settings .= "$kSql = $value ";
                continue;
            }
            
            // special values ... at least null is handled...
            if (!($v & DB_DATAOBJECT_NOTNULL) && DB_DataObject::_is_null($this,$k)) {
                $settings .= "$kSql = NULL ";
                continue;
            }
            // DATE is empty... on a col. that can be null.. 
            // note: this may be usefull for time as well..
            if (!$this->$k && 
                    (($v & DB_DATAOBJECT_DATE) || ($v & DB_DATAOBJECT_TIME)) && 
                    !($v & DB_DATAOBJECT_NOTNULL)) {
                    
                $settings .= "$kSql = NULL ";
                continue;
            }
            

            if ($v & DB_DATAOBJECT_STR) {
                $settings .= "$kSql = ". $this->_quote((string) (
                        ($v & DB_DATAOBJECT_BOOL) ? 
                            // this is thanks to the braindead idea of postgres to 
                            // use t/f for boolean.
                            (($this->$k === 'f') ? 0 : (int)(bool) $this->$k) :  
                            $this->$k
                    )) . ' ';
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
         
        
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("got keys as ".serialize($keys),3);
        }
        if ($dataObject !== true) {
            $this->_build_condition($items,$keys);
        } else {
            // prevent wiping out of data!
            if (empty($this->_query['condition'])) {
                 $this->raiseError("update: global table update not available
                        do \$do->whereAdd('1=1'); if you really want to do that.
                    ", DB_DATAOBJECT_ERROR_INVALIDARGS);
                return false;
            }
        }
        
        
        
        //  echo " $settings, $this->condition ";
        if ($settings && isset($this->_query) && $this->_query['condition']) {
            
            $table = ($quoteIdentifiers ? $DB->quoteIdentifier($this->tableName()) : $this->tableName());
        
            $r = $this->_query("UPDATE  {$table}  SET {$settings} {$this->_query['condition']} ");
            
            // restore original query conditions.
            $this->_query = $original_query;
            
            if (PEAR::isError($r)) {
                $this->raiseError($r);
                return false;
            }
            if ($r < 1) {
                return 0;
            }

            $this->_clear_cache();
            return $r;
        }
        // restore original query conditions.
        $this->_query = $original_query;
        
        // if you manually specified a dataobject, and there where no changes - then it's ok..
        if ($dataObject !== false) {
            return true;
        }
        
        $this->raiseError(
            "update: No Data specifed for query $settings , {$this->_query['condition']}", 
            DB_DATAOBJECT_ERROR_NODATA);
        return false;
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
     * @param bool $useWhere (optional) If DB_DATAOBJECT_WHEREADD_ONLY is passed in then
     *             we will build the condition only using the whereAdd's.  Default is to
     *             build the condition only using the object parameters.
     *
     * @access public
     * @return mixed Int (No. of rows affected) on success, false on failure, 0 on no data affected
     */
    function delete($useWhere = false)
    {
        global $_DB_DATAOBJECT;
        // connect will load the config!
        $this->_connect();
        $DB = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
        $quoteIdentifiers  = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);
        
        $extra_cond = ' ' . (isset($this->_query['order_by']) ? $this->_query['order_by'] : ''); 
        
        if (!$useWhere) {

            $keys = $this->keys();
            $this->_query = array(); // as it's probably unset!
            $this->_query['condition'] = ''; // default behaviour not to use where condition
            $this->_build_condition($this->table(),$keys);
            // if primary keys are not set then use data from rest of object.
            if (!$this->_query['condition']) {
                $this->_build_condition($this->table(),array(),$keys);
            }
            $extra_cond = '';
        } 
            

        // don't delete without a condition
        if (($this->_query !== false) && $this->_query['condition']) {
        
            $table = ($quoteIdentifiers ? $DB->quoteIdentifier($this->tableName()) : $this->tableName());
            $sql = "DELETE ";
            // using a joined delete. - with useWhere..
            $sql .= (!empty($this->_join) && $useWhere) ? 
                "{$table} FROM {$table} {$this->_join} " : 
                "FROM {$table} ";
                
            $sql .= $this->_query['condition']. $extra_cond;
            
            // add limit..
            $sql = $this->modifyLimitQuery($sql, true);
            
            $r = $this->_query($sql);
            
            
            if (PEAR::isError($r)) {
                $this->raiseError($r);
                return false;
            }
            if ($r < 1) {
                return 0;
            }
            $this->_clear_cache();
            return $r;
        } else {
            $this->raiseError("delete: No condition specifed for query", DB_DATAOBJECT_ERROR_NODATA);
            return false;
        }
    }
 
    /**
     * Find the number of results from a simple query
     *
     * for example
     *
     * $object = new mytable();
     * $object->name = "fred";
     * echo $object->count();
     * echo $object->count(true);  // dont use object vars.
     * echo $object->count('distinct mycol');   count distinct mycol.
     * echo $object->count('distinct mycol',true); // dont use object vars.
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
     * @param bool      $whereAddOnly (optional) If DB_DATAOBJECT_WHEREADD_ONLY is passed in then
     *                  we will build the condition only using the whereAdd's.  Default is to
     *                  build the condition using the object parameters as well.
     *                  
     * @access public
     * @return int
     */
    function count($countWhat = false,$whereAddOnly = false)
    {
        global $_DB_DATAOBJECT;
        
        if (is_bool($countWhat)) {
            $whereAddOnly = $countWhat;
        }
        
        $t = clone($this);
        $items   = $t->table();
        
        $quoteIdentifiers = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);
        
        
        if (!isset($t->_query)) {
            $this->raiseError(
                "You cannot do run count after you have run fetch()", 
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        $this->_connect();
        $DB = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
       

        if (!$whereAddOnly && $items)  {
            $t->_build_condition($items);
        }
        $keys = $this->keys();

        if (empty($keys[0]) && (!is_string($countWhat) || (strtoupper($countWhat) == 'DISTINCT'))) {
            $this->raiseError(
                "You cannot do run count without keys - use \$do->count('id'), or use \$do->count('distinct id')';", 
                DB_DATAOBJECT_ERROR_INVALIDARGS,PEAR_ERROR_DIE);
            return false;
            
        }
        $table   = ($quoteIdentifiers ? $DB->quoteIdentifier($this->tableName()) : $this->tableName());
        $key_col = empty($keys[0]) ? '' : (($quoteIdentifiers ? $DB->quoteIdentifier($keys[0]) : $keys[0]));
        $as      = ($quoteIdentifiers ? $DB->quoteIdentifier('DATAOBJECT_NUM') : 'DATAOBJECT_NUM');
        
        // support distinct on default keys.
        $countWhat = (strtoupper($countWhat) == 'DISTINCT') ? 
            "DISTINCT {$table}.{$key_col}" : $countWhat;
        
        $countWhat = is_string($countWhat) ? $countWhat : "{$table}.{$key_col}";
        
        $r = $t->_query(
            "SELECT count({$countWhat}) as $as
                FROM $table {$t->_join} {$t->_query['condition']}");
        if (PEAR::isError($r)) {
            return false;
        }
         
        $result  = $_DB_DATAOBJECT['RESULTS'][$t->_DB_resultid];
        $l = $result->fetchRow(DB_DATAOBJECT_FETCHMODE_ORDERED);
        // free the results - essential on oracle.
        $t->free();
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug('Count returned '. $l[0] ,1);
        }
        return (int) $l[0];
    }

    /**
     * sends raw query to database
     *
     * Since _query has to be a private 'non overwriteable method', this is a relay
     *
     * @param  string  $string  SQL Query
     * @access public
     * @return void or DB_Error
     */
    function query($string)
    {
        return $this->_query($string);
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
    function escape($string, $likeEscape=false)
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
     * DB_DataObject::databaseStructure(  'databasename')
     *
     * 2 argument - just returns the database structure - if any.
     * DB_DataObject::databaseStructure(  'databasename', false)
     * 
     * 
     * 2 arguments:
     * DB_DataObject::databaseStructure(  'databasename', parse_ini_file('mydb.ini',true))
     *  - set's the structure..
     *  
     * 3 arguments:
     * DB_DataObject::databaseStructure(  'databasename',
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
    function databaseStructure($database_nickname = false, $inidata = false, $linksdata=false, $overwrite = false)
    {

        
    
        $args = func_get_args();
    
        if (self::$debug) {
            self::debug('CALL:' . json_encode($args, true), __FUNCTION__ , 1);
        }
        
        
        // Assignment code    
        if (count($args) > 1) {
            
            // databaseStructure('mydb',   a$tabledatarray(.... schema....), array( ... links')
            if ($inidata !== false) {
                self::$ini[$database_nickname] = isset( self::$ini[$database_nickname]) && !$overwrite ?
                    self::$ini[$database_nickname] + $inidata :
                    $inidata;
            }
            if ($linksdata !== false)  {
                self::$links[$database_nickname] = isset(self::$links[$database_nickname]) && !$overwrite ?  
                    self::$links[$database_nickname] + $linksdata :
                    $linksdata;
            }
            
            return isset(self::$ini[$database_nickname]) ? self::$ini[$database_nickname] : false;
            
            // will not get here....
        }
        
        if (false === $database_nickname) {
            $database_nickname = $this->_database_nickname;
        }
        
        // not sure why we need to connect here...
        //if (!$this->_database) {
        $this->PDO();
        //}
        
         
        // if this table is already loaded this table..
        if (!empty(self::$ini[$database_nickname])) {
            return self::$ini[$database_nickname];
        }
        
        // initialize the ini data.. if empt..
        if (empty(self::$ini[$database_nickname])) {
            self::$ini[$database_nickname] = array();
        }
         
         
        // we do not have the data for this table yet...
        
        // if we are configured to use the proxy..
        
        if ( self::$config['proxy'])   {
            return $this->_generator()->databaseStructureProxy($database_nickname);
        }
            
        // basic idea here..
        // if we have a really simple format - do that here.. otherwise pass to introspection to sort out.
        
        // uses 'ini_* settings..
        $schemas = array();
        $suffix = '';
        
        if (is_array(self::$config['schema_location'])) {
            if (!isset(PDO_DataObject::$config['schema_location'][$database_nickname])) {
                $this->raiseError("Could not find configuration for database $database_nickname in schema_location",
                        self::ERROR_INVALIDCONFIG, self::ERROR_DIE
                );
            }
            
            $schemas = is_array(PDO_DataObject::$config['schema_location'][$database_nickname]) ?
                PDO_DataObject::$config['schema_location'][$database_nickname]:
                explode(PATH_SEPARATOR, PDO_DataObject::$config['schema_location'][$database_nickname]);
        } else if (is_string(self::$config['schema_location']) && !empty(self::$config['schema_location'])) {
            $schemas  = explode(PATH_SEPARATOR,PDO_DataObject::$config['schema_location']);
            $suffix = '/'. $database_nickname .'.ini';
        } else {
            $this->raiseError("Invalid format or empty value for config[schema_location]",
                            self::ERROR_INVALIDCONFIG, self::ERROR_DIE
            );
        }
          
        $tried = array();
        $ini_out  = array();
        foreach ($schemas as $ini) {
            if (empty($ini)) {
                continue;
            }
            $fn = $suffix ? rtrim($ini ,'/') . $suffix : $ini;
            $tried[] = $ini;
            if (!file_exists($fn) || !is_file($fn) || !is_readable ($fn)) {
                continue;
            }
            $this->debug("load schema from: ". $fn , "SCHEMA", 3);
            $ini_out = array_merge(
                $ini_out,
                parse_ini_file($fn, true)
            );
                
             
        }
        
        if (empty($ini_out)) {
            $this->raiseError("Failed to load any schema for database={$this->_database_nickname} from these files/locations" . json_encode($tried),
                         self::ERROR_INVALIDCONFIG, self::ERROR_DIE
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
        
        // now have we loaded the structure.. 
        
        if (!empty(self::$ini[$database_nickname])) {
            return self::$ini[$database_nickname];
        }
       
        $this->debug("Cant find database schema: {$this->_database}\n".
                    "in links file data: " . print_r(self::$ini,true),"databaseStructure",5);
        // we have to die here!! - it causes chaos if we dont (including looping forever!)
        $this->raiseError( "Unable to load schema for database and table (turn debugging up to 5 for full error message)",
                self::ERROR_INVALIDARGS, self::ERROR_DIE);
        return false;
        
         
    }
    /**
     * create an instance of the generator.
     * class can be set by using proxy = {classname}::
     * We do not really care if you have implemented it correctly....????
     * 
     */
    
    private function _generator()
    {
        $dcls = 'PDO_DataObject_Generator';
        $cls = (is_string(self::$config['proxy']) && strpos(self::$config['proxy'], '::') !== false) ?
            explode('::', self::$config['proxy'])[0] : $dcls;
            
        if ($dcls == $cls) {
            class_exists('PDO_DataObject_Generator') ? '' : 
                require_once 'PDO/DataObject/Generator.php';
        }
        return new $cls();
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
        global $_DB_DATAOBJECT;
        $args = func_get_args();
        if (count($args)) {
            $this->__table = $args[0];
        }
        if (empty($this->__table)) {
            return '';
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['portability']) && $_DB_DATAOBJECT['CONFIG']['portability'] & 1) {
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
  
    /**
     * get/set an associative array of table columns
     *
     * @access public
     * @param  array key=>type array
     * @return array (associative)
     */
    function table()
    {
        
        // for temporary storage of database fields..
        // note this is not declared as we dont want to bloat the print_r output
        $args = func_get_args();
        if (count($args)) {
            $this->_result->fields = $args[0];
        }
        if (isset($this->_result->fields)) {
            return $this->_result->fields;
        }
        
        
        global $_DB_DATAOBJECT;
        if (!isset($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            $this->_connect();
        }
          
        if (isset($_DB_DATAOBJECT['INI'][$this->_database][$this->tableName()])) {
            return $_DB_DATAOBJECT['INI'][$this->_database][$this->tableName()];
        }
        
        $this->databaseStructure();
 
        
        $ret = array();
        if (isset($_DB_DATAOBJECT['INI'][$this->_database][$this->tableName()])) {
            $ret =  $_DB_DATAOBJECT['INI'][$this->_database][$this->tableName()];
        }
        
        return $ret;
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
        
        global $_DB_DATAOBJECT;
        if (!isset($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            $this->_connect();
        }
        if (isset($_DB_DATAOBJECT['INI'][$this->_database][$this->tableName()."__keys"])) {
            return array_keys($_DB_DATAOBJECT['INI'][$this->_database][$this->tableName()."__keys"]);
        }
        $this->databaseStructure();
        
        if (isset($_DB_DATAOBJECT['INI'][$this->_database][$this->tableName()."__keys"])) {
            return array_keys($_DB_DATAOBJECT['INI'][$this->_database][$this->tableName()."__keys"]);
        }
        return array();
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
        global $_DB_DATAOBJECT;
          
        // call setting
        if (!$this->_database) {
            $this->_connect();
        }
        
        if (!isset($_DB_DATAOBJECT['SEQUENCE'][$this->_database])) {
            $_DB_DATAOBJECT['SEQUENCE'][$this->_database] = array();
        }

        
        $args = func_get_args();
        if (count($args)) {
            $args[1] = isset($args[1]) ? $args[1] : false;
            $args[2] = isset($args[2]) ? $args[2] : false;
            $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()] = $args;
        }
        if (isset($_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()])) {
            return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()];
        }
        // end call setting (eg. $do->sequenceKeys(a,b,c); )
        
       
        
        
        $keys = $this->keys();
        if (!$keys) {
            return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()] 
                = array(false,false,false);
        }
 

        $table =  $this->table();
       
        $dbtype    = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['phptype'];
        
        $usekey = $keys[0];
        
        
        
        $seqname = false;
        
        if (!empty($_DB_DATAOBJECT['CONFIG']['sequence_'.$this->tableName()])) {
            $seqname = $_DB_DATAOBJECT['CONFIG']['sequence_'.$this->tableName()];
            if (strpos($seqname,':') !== false) {
                list($usekey,$seqname) = explode(':',$seqname);
            }
        }  
        
        
        // if the key is not an integer - then it's not a sequence or native
        if (empty($table[$usekey]) || !($table[$usekey] & DB_DATAOBJECT_INT)) {
                return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()] = array(false,false,false);
        }
        
        
        if (!empty($_DB_DATAOBJECT['CONFIG']['ignore_sequence_keys'])) {
            $ignore =  $_DB_DATAOBJECT['CONFIG']['ignore_sequence_keys'];
            if (is_string($ignore) && (strtoupper($ignore) == 'ALL')) {
                return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()] = array(false,false,$seqname);
            }
            if (is_string($ignore)) {
                $ignore = $_DB_DATAOBJECT['CONFIG']['ignore_sequence_keys'] = explode(',',$ignore);
            }
            if (in_array($this->tableName(),$ignore)) {
                return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()] = array(false,false,$seqname);
            }
        }
        
        
        $realkeys = $_DB_DATAOBJECT['INI'][$this->_database][$this->tableName()."__keys"];
        
        // if you are using an old ini file - go back to old behaviour...
        if (is_numeric($realkeys[$usekey])) {
            $realkeys[$usekey] = 'N';
        }
        
        // multiple unique primary keys without a native sequence...
        if (($realkeys[$usekey] == 'K') && (count($keys) > 1)) {
            return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()] = array(false,false,$seqname);
        }
        // use native sequence keys...
        // technically postgres native here...
        // we need to get the new improved tabledata sorted out first.
        
        // support named sequence keys.. - currently postgres only..
        
        if (    in_array($dbtype , array('pgsql')) &&
                ($table[$usekey] & DB_DATAOBJECT_INT) && 
                isset($realkeys[$usekey]) && strlen($realkeys[$usekey]) > 1) {
            return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()] = array($usekey,true, $realkeys[$usekey]);
        }
        
        if (    in_array($dbtype , array('pgsql', 'mysql', 'mysqli', 'mssql', 'ifx')) && 
                ($table[$usekey] & DB_DATAOBJECT_INT) && 
                isset($realkeys[$usekey]) && ($realkeys[$usekey] == 'N')
                ) {
            return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()] = array($usekey,true,$seqname);
        }
        
        
        // if not a native autoinc, and we have not assumed all primary keys are sequence
        if (($realkeys[$usekey] != 'N') && 
            !empty($_DB_DATAOBJECT['CONFIG']['dont_use_pear_sequences'])) {
            return array(false,false,false);
        }
        
        
        
        // I assume it's going to try and be a nextval DB sequence.. (not native)
        return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->tableName()] = array($usekey,false,$seqname);
    }
    
    
    
    /* =========================================================== */
    /*  Major Private Methods - the core part!              */
    /* =========================================================== */

 
    
    /**
     * clear the cache values for this class  - normally done on insert/update etc.
     *
     * @access private
     * @return void
     */
    function _clear_cache()
    {
        global $_DB_DATAOBJECT;
        
        $class = strtolower(get_class($this));
        
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("Clearing Cache for ".$class,1);
        }
        
        if (!empty($_DB_DATAOBJECT['CACHE'][$class])) {
            unset($_DB_DATAOBJECT['CACHE'][$class]);
        }
    }

    
    /**
     * backend wrapper for quoting, as MDB2 and DB do it differently...
     *
     * @access private
     * @return string quoted
     */
    
    function _quote($str) 
    {
        global $_DB_DATAOBJECT;
        return (empty($_DB_DATAOBJECT['CONFIG']['db_driver']) || 
                ($_DB_DATAOBJECT['CONFIG']['db_driver'] == 'DB'))
            ? $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->quoteSmart($str)
            : $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->quote($str);
    }
    
    
     

    /**
     * sends query to database - this is the private one that must work 
     *   - internal functions use this rather than $this->query()
     *
     * @param  string  $string
     * @access private
     * @return PDO_DataObject|number (self for chaining) - insert/update/delete - return a number.
     */
    private function _query($string)
    {
        $pdo = $this->PDO();

        $dbtype = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

        //$options = $_DB_DATAOBJECT['CONFIG'];
        
        
        if (self::$debug) {
            $t= explode(' ',microtime());
            $time = $t[0]+$t[1];
         
            $this->debug( md5($string) . ' : ' . $string,"QUERY");
            $this->debug( "Driver: " . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME), 'QUERY', 3);
        }
        
        if (
            strtoupper($string) == 'BEGIN' ||
            strtoupper($string) == 'START TRANSACTION'
        ) {
            if (self::$debug) {
                $this->debug('BEGIN');
            }
            $pdo->beginTranaction();
            
            return $this;
        }
        
        if (strtoupper($string) == 'COMMIT') {
            if (self::$debug) {
                $this->debug('COMMIT');
            }
            $pdo->commit();
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, true); // not sure if needed...
            return $this;
        }
        
        
        if (strtoupper($string) == 'ROLLBACK') {
            if (self::$debug) {
                $this->debug('ROLLBACK');
            }
            $pdo->rollBack();
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, true); // not sure if needed...
            
            return true;
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
                $this->debug((string)$e, "Query Error",1 );
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
                $this->debug((string)$result, "Query Error",1 );
            }
            $this->N = false;
            return $this->raiseError("Could not run Query", 0, self::ERROR_DIE, $result);
        }
        
        
        if (self::$debug) {
            $t= explode(' ',microtime());
            $result->time_query_end = $t[0]+$t[1];
            $this->debug('QUERY DONE IN  '.number_format($t[0]+$t[1]-$time,3)." seconds", 'query',2);
            $this->debug('NO# of results: '.$result->rowCount(), 'query',1);
        }
        
        
        switch (strtolower(substr(trim($string),0,6))) {
            case 'insert':
            case 'update':
            case 'delete':
                return $result->rowCount();
        }
        
        // previously we used _DB_resultid as a pointer to a result array..
        // hopefully this will result in better memory management???
        $this->_result = $result;
        $this->N = $dbtype  == 'sqlite' ? true : $result->rowCount();
        
        return $this; // for chaining...
     
    }

    /**
     * Builds the WHERE based on the values of of this object
     *
     * @param   mixed   $keys
     * @param   array   $filter (used by update to only uses keys in this filter list).
     * @param   array   $negative_filter (used by delete to prevent deleting using the keys mentioned..)
     * @access  private
     * @return  string
     */
    function _build_condition($keys, $filter = array(),$negative_filter=array())
    {
        global $_DB_DATAOBJECT;
        $this->_connect();
        $DB = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
       
        $quoteIdentifiers  = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);
        $options = $_DB_DATAOBJECT['CONFIG'];
        
        // if we dont have query vars.. - reset them.
        if ($this->_query === false) {
            $x = new DB_DataObject;
            $this->_query= $x->_query;
        }
       
                    
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
                ? ( $DB->quoteIdentifier($this->tableName()) . '.' . $DB->quoteIdentifier($k) )  
                : "{$this->tableName()}.{$k}";
             
             
            
            if (is_object($this->$k) && is_a($this->$k,'DB_DataObject_Cast')) {
                $dbtype = $DB->dsn["phptype"];
                $value = $this->$k->toString($v,$DB);
                if (PEAR::isError($value)) {
                    $this->raiseError($value->getMessage() ,DB_DATAOBJECT_ERROR_INVALIDARG);
                    return false;
                }
                if ((strtolower($value) === 'null') && !($v & DB_DATAOBJECT_NOTNULL)) {
                    $this->whereAdd(" $kSql IS NULL");
                    continue;
                }
                $this->whereAdd(" $kSql = $value");
                continue;
            }
            
            if (!($v & DB_DATAOBJECT_NOTNULL) && DB_DataObject::_is_null($this,$k)) {
                $this->whereAdd(" $kSql  IS NULL");
                continue;
            }
            

            if ($v & DB_DATAOBJECT_STR) {
                $this->whereAdd(" $kSql  = " . $this->_quote((string) (
                        ($v & DB_DATAOBJECT_BOOL) ? 
                            // this is thanks to the braindead idea of postgres to 
                            // use t/f for boolean.
                            (($this->$k === 'f') ? 0 : (int)(bool) $this->$k) :  
                            $this->$k
                    )) );
                continue;
            }
            if (is_numeric($this->$k)) {
                $this->whereAdd(" $kSql = {$this->$k}");
                continue;
            }
            /* this is probably an error condition! */
            $this->whereAdd(" $kSql = ".intval($this->$k));
        }
    }

    
    
     /**
     * classic factory method for loading a table class
     * usage: $do = DB_DataObject::factory('person')
     * WARNING - this may emit a include error if the file does not exist..
     * use @ to silence it (if you are sure it is acceptable)
     * eg. $do = @DB_DataObject::factory('person')
     *
     * table name can bedatabasename/table
     * - and allow modular dataobjects to be written..
     * (this also helps proxy creation)
     *
     * Experimental Support for Multi-Database factory eg. mydatabase.mytable
     * 
     * 
     * @param  string  $table  tablename (use blank to create a new instance of the same class.)
     * @access private
     * @return DataObject|PEAR_Error 
     */
    
    

    static function factory($table = '')
    {
        global $_DB_DATAOBJECT;
        
        
        // multi-database support.. - experimental.
        $database = '';
       
        if (strpos( $table,'/') !== false ) {
            list($database,$table) = explode('.',$table, 2);
          
        }
         
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            PDO_DataObject::config();
        }
        // no configuration available for database
        if (!empty($database) && empty($_DB_DATAOBJECT['CONFIG']['database_'.$database])) {
                $do = new DB_DataObject();
                $do->raiseError(
                    "unable to find database_{$database} in Configuration, It is required for factory with database"
                    , 0, PEAR_ERROR_DIE );   
       }
        
       
        /*
        if ($table === '') {
            if (is_a($this,'DB_DataObject') && strlen($this->tableName())) {
                $table = $this->tableName();
            } else {
                return DB_DataObject::raiseError(
                    "factory did not recieve a table name",
                    DB_DATAOBJECT_ERROR_INVALIDARGS);
            }
        }
        
        */
        // does this need multi db support??
        $cp = isset($_DB_DATAOBJECT['CONFIG']['class_prefix']) ?
            explode(PATH_SEPARATOR, $_DB_DATAOBJECT['CONFIG']['class_prefix']) : '';
        
        //print_r($cp);
        
        // multiprefix support.
        $tbl = preg_replace('/[^A-Z0-9]/i','_',ucfirst($table));
        if (is_array($cp)) {
            $class = array();
            foreach($cp as $cpr) {
                $ce = substr(phpversion(),0,1) > 4 ? class_exists($cpr . $tbl,false) : class_exists($cpr . $tbl);
                if ($ce) {
                    $class = $cpr . $tbl;
                    break;
                }
                $class[] = $cpr . $tbl;
            }
        } else {
            $class = $tbl;
            $ce = substr(phpversion(),0,1) > 4 ? class_exists($class,false) : class_exists($class);
        }
        
        
        $rclass = $ce ? $class  : DB_DataObject::_autoloadClass($class, $table);
        // proxy = full|light
        if (!$rclass && isset($_DB_DATAOBJECT['CONFIG']['proxy'])) { 
        
            DB_DataObject::debug("FAILED TO Autoload  $database.$table - using proxy.","FACTORY",1);
        
        
            $proxyMethod = 'getProxy'.$_DB_DATAOBJECT['CONFIG']['proxy'];
            // if you have loaded (some other way) - dont try and load it again..
            class_exists('DB_DataObject_Generator') ? '' : 
                    require_once 'DB/DataObject/Generator.php';
            
            $d = new DB_DataObject;
           
            $d->__table = $table;
            
            $ret = $d->_connect();
            if (is_object($ret) && is_a($ret, 'PEAR_Error')) {
                return $ret;
            }
            
            $x = new DB_DataObject_Generator;
            return $x->$proxyMethod( $d->_database, $table);
        }
        
        if (!$rclass || !class_exists($rclass)) {
            $dor = new DB_DataObject();
            return $dor->raiseError(
                "factory could not find class " . 
                (is_array($class) ? implode(PATH_SEPARATOR, $class)  : $class  ). 
                "from $table",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
        }
 
        $ret = new $rclass();
 
        if (!empty($database)) {
            DB_DataObject::debug("Setting database to $database","FACTORY",1);
            $ret->database($database);
        }
        return $ret;
    }
    /**
     * autoload Class
     *
     * @param  string|array  $class  Class
     * @param  string  $table  Table trying to load.
     * @access private
     * @return string classname on Success
     * @static
     */
    static function _autoloadClass($class, $table=false)
    {
        global $_DB_DATAOBJECT;
        
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            PDO_DataObject::config();
        }
        $class_prefix = empty($_DB_DATAOBJECT['CONFIG']['class_prefix']) ? 
                '' : $_DB_DATAOBJECT['CONFIG']['class_prefix'];
                
        $table   = $table ? $table : substr($class,strlen($class_prefix));

        // only include the file if it exists - and barf badly if it has parse errors :)
        if (!empty($_DB_DATAOBJECT['CONFIG']['proxy']) || empty($_DB_DATAOBJECT['CONFIG']['class_location'])) {
            return false;
        }
        // support for:
        // class_location = mydir/ => maps to mydir/Tablename.php
        // class_location = mydir/myfile_%s.php => maps to mydir/myfile_Tablename
        // with directory sepr
        // class_location = mydir/:mydir2/: => tries all of thes locations.
        $cl = $_DB_DATAOBJECT['CONFIG']['class_location'];
        
        
        switch (true) {
            case (strpos($cl ,'%s') !== false):
                $file = sprintf($cl , preg_replace('/[^A-Z0-9]/i','_',ucfirst($table)));
                break;
                
            case (strpos($cl , PATH_SEPARATOR) !== false):
                $file = array();
                foreach(explode(PATH_SEPARATOR, $cl ) as $p) {
                    $file[] =  $p .'/'.preg_replace('/[^A-Z0-9]/i','_',ucfirst($table)).".php";
                }
                break;
            default:
                $file = $cl .'/'.preg_replace('/[^A-Z0-9]/i','_',ucfirst($table)).".php";
                break;
        }
        
        $cls = is_array($class) ? $class : array($class);
        
        if (is_array($file) || !file_exists($file)) {
            $found = false;
            
            $file = is_array($file) ? $file : array($file);
            $search = implode(PATH_SEPARATOR, $file);
            foreach($file as $f) {
                foreach(explode(PATH_SEPARATOR, '' . PATH_SEPARATOR . ini_get('include_path')) as $p) {
                    $ff = empty($p) ? $f : "$p/$f";

                    if (file_exists($ff)) {
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
                $dor = new DB_DataObject();
                $dor->raiseError(
                    "autoload:Could not find class " . implode(',', $cls) .
                    " using class_location value :" . $search .
                    " using include_path value :" . ini_get('include_path'), 
                    DB_DATAOBJECT_ERROR_INVALIDCONFIG);
                return false;
            }
        }
        
        include_once $file;
        
       
        $ce = false;
        foreach($cls as $c) {
            $ce = substr(phpversion(),0,1) > 4 ? class_exists($c,false) : class_exists($c);
            if ($ce) {
                $class = $c;
                break;
            }
        }
        if (!$ce) {
            $dor = new DB_DataObject();
            $dor->raiseError(
                "autoload:Could not autoload " . implode(',', $cls) , 
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }
        return $class;
    }
    
    
    
    
    
    /**
    * Get the links associate array  as defined by the links.ini file.
    * 
    *
    * Experimental... - 
    * Should look a bit like
    *       [local_col_name] => "related_tablename:related_col_name"
    * 
    * @param    array $new_links optional - force update of the links for this table
    *               You probably want to restore it to it's original state after,
    *               as modifying here does it for the whole PHP request.
    * 
    * @return   array|null    
    *           array       = if there are links defined for this table.
    *           empty array - if there is a links.ini file, but no links on this table
    *           false       - if no links.ini exists for this database (hence try auto_links).
    * @access   public
    * @see      DB_DataObject::getLinks(), DB_DataObject::getLink()
    */
    
    function links()
    {
        global $_DB_DATAOBJECT;
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            $this->config();
        }
        // have to connect.. -> otherwise things break later.
        $this->_connect();
        
        // alias for shorter code..
        $lcfg  = &$_DB_DATAOBJECT['LINKS'];
        $cfg   =  $_DB_DATAOBJECT['CONFIG'];

        if ($args = func_get_args()) {
            // an associative array was specified, that updates the current
            // schema... - be careful doing this
            if (empty( $lcfg[$this->_database])) {
                $lcfg[$this->_database] = array();
            }
            $lcfg[$this->_database][$this->tableName()] = $args[0];
            
        }
        // loaded and available.
        if (isset($lcfg[$this->_database][$this->tableName()])) {
            return $lcfg[$this->_database][$this->tableName()];
        }

        // loaded 
        if (isset($lcfg[$this->_database])) {
            // either no file, or empty..
            return $lcfg[$this->_database] === false ? null : array();
        }
        
        // links are same place as schema by default.
        $schemas = isset($cfg['schema_location']) ?
            array("{$cfg['schema_location']}/{$this->_database}.ini") :
            array() ;

        // if ini_* is set look there instead.
        // and support multiple locations.                 
        if (isset($cfg["ini_{$this->_database}"])) {
            $schemas = is_array($cfg["ini_{$this->_database}"]) ?
                $cfg["ini_{$this->_database}"] :
                explode(PATH_SEPARATOR,$cfg["ini_{$this->_database}"]);
        }
                        
        // default to not available.
        $lcfg[$this->_database] = false;

        foreach ($schemas as $ini) {
                
            $links = isset($cfg["links_{$this->_database}"]) ?
                    $cfg["links_{$this->_database}"] :
                    str_replace('.ini','.links.ini',$ini);
            
            // file really exists..
            if (!file_exists($links) || !is_file($links)) {
                if (!empty($cfg['debug'])) {
                    $this->debug("Missing links.ini file: $links","links",1);
                }
                continue;
            }

            // set to empty array - as we have at least one file now..
            $lcfg[$this->_database] = empty($lcfg[$this->_database]) ? array() : $lcfg[$this->_database];

            // merge schema file into lcfg..
            $lcfg[$this->_database] = array_merge(
                $lcfg[$this->_database],
                parse_ini_file($links, true)
            );

                        
            if (!empty($cfg['debug'])) {
                $this->debug("Loaded links.ini file: $links","links",1);
            }
             
        }
        
        if (!empty($_DB_DATAOBJECT['CONFIG']['portability']) && $_DB_DATAOBJECT['CONFIG']['portability'] & 1) {
            foreach($lcfg[$this->_database] as $k=>$v) {
                
                $nk = strtolower($k);
                // results in duplicate cols.. but not a big issue..
                $lcfg[$this->_database][$nk] = isset($lcfg[$this->_database][$nk])
                    ? $lcfg[$this->_database][$nk]  : array();
                
                foreach($v as $kk =>$vv) {
                    //var_Dump($vv);exit;
                    $vv =explode(':', $vv);
                    $vv[0] = strtolower($vv[0]);
                    $lcfg[$this->_database][$nk][$kk] = implode(':', $vv);
                }
                
                
            }
        }
        //echo '<PRE>';print_r($lcfg);exit;
        
        // if there is no link data at all on the file!
        // we return null.
        if ($lcfg[$this->_database] === false) {
            return null;
        }
        
        if (isset($lcfg[$this->_database][$this->tableName()])) {
            return $lcfg[$this->_database][$this->tableName()];
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
     *  $do->link('company_id', array($obj));
     *
     *  example function
     *
     *  function company() {
     *     $this->link(array('company_id','company:id'), func_get_args());
     *   }
     *
     * 
     *
     * @param  mixed $link_spec              link specification (normally a string)
     *                                       uses similar rules to  joinAdd() array argument.
     * @param  mixed $set_value (optional)   int, DataObject, or array('set')
     * @author Alan Knowles
     * @access public
     * @return mixed true or false on setting, object on getting
     */
    function link($field, $set_args = array())
    {
        require_once 'DB/DataObject/Links.php';
        $l = new DB_DataObject_Links($this);
        return  $l->link($field,$set_args) ;
        
    }
    
      /**
     * load related objects
     *
     * Generally not recommended to use this.
     * The generator should support creating getter_setter methods which are better suited.
     *
     * Relies on  <dbname>.links.ini
     *
     * Sets properties on the calling dataobject  you can change what
     * object vars the links are stored in by  changeing the format parameter
     *
     *
     * @param  string format (default _%s) where %s is the table name.
     * @author Tim White <tim@cyface.com>
     * @access public
     * @return boolean , true on success
     */
    function applyLinks($format = '_%s')
    {
        require_once 'DB/DataObject/Links.php';
         $l = new DB_DataObject_Links($this);
        return $l->applyLinks($format);
           
    }

 

    /**
     * linkArray
     * Fetch an array of related objects. This should be used in conjunction with a <dbname>.links.ini file configuration (see the introduction on linking for details on this).
     * You may also use this with all parameters to specify, the column and related table.
     * This is highly dependant on naming columns 'correctly' :)
     * using colname = xxxxx_yyyyyy
     * xxxxxx = related table; (yyyyy = user defined..)
     * looks up table xxxxx, for value id=$this->xxxxx
     * stores it in $this->_xxxxx_yyyyy
     *
     * @access public
     * @param string $column - either column or column.xxxxx
     * @param string $table - name of table to look up value in
     * @return array - array of results (empty array on failure)
     * 
     * Example - Getting the related objects
     * 
     * $person = new DataObjects_Person;
     * $person->get(12);
     * $children = $person->getLinkArray('children');
     * 
     * echo 'There are ', count($children), ' descendant(s):<br />';
     * foreach ($children as $child) {
     *     echo $child->name, '<br />';
     * }
     * 
     */
    function linkArray($row, $table = null)
    {
        require_once 'DB/DataObject/Links.php';
        $l = new DB_DataObject_Links($this);
        return $l->getLinkArray($row, $table === null ? false: $table);
     
    }

     /**
     * unionAdd - adds another dataobject to this, building a unioned query.
     *
     * usage:  
     * $doTable1 = DB_DataObject::factory("table1");
     * $doTable2 = DB_DataObject::factory("table2");
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
     * @param             $obj       object|false the union object or false to reset
     * @param    optional $is_all    string 'ALL' to do all.
     * @returns           $obj       object|array the added object, or old list if reset.
     */
    
    function unionAdd($obj,$is_all= '')
    {
        if ($obj === false) {
            $ret = $this->_query['unions'];
            $this->_query['unions'] = array();
            return $ret;
        }
        $this->_query['unions'][] = array($obj, 'UNION ' . $is_all . ' ') ;
        return $obj;
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
     * @param    optional $obj       object |array    the joining object (no value resets the join)
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
     * @return   none
     * @access   public
     * @author   Stijn de Reede      <sjr@gmx.co.uk>
     */
    function joinAdd($obj = false, $joinType='INNER', $joinAs=false, $joinCol=false)
    {
        global $_DB_DATAOBJECT;
        if ($obj === false) {
            $this->_join = '';
            return;
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
        if (is_array($obj)) {
            $tfield = $obj[0];
            
            if (count($obj) == 3) {
                $ofield = $obj[2];
                $obj = $obj[1];
            } else {
                list($toTable,$ofield) = explode(':',$obj[1]);
            
                $obj = is_string($toTable) ? DB_DataObject::factory($toTable) : $toTable;
            
                if (!$obj || !is_object($obj) || is_a($obj,'PEAR_Error')) {
                    $obj = new DB_DataObject;
                    $obj->__table = $toTable;
                }
                $obj->_connect();
            }
            // set the table items to nothing.. - eg. do not try and match
            // things in the child table...???
            $items = array();
        }
        
        if (!is_object($obj) || !is_a($obj,'DB_DataObject')) {
            return $this->raiseError("joinAdd: called without an object", DB_DATAOBJECT_ERROR_NODATA,PEAR_ERROR_DIE);
        }
        /*  make sure $this->_database is set.  */
        $this->_connect();
        $DB = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
       

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
                         $this->raiseError( 
                            "joinAdd: You cannot target a join column in the " .
                            "'link from' table ({$obj->tableName()}). " . 
                            "Either remove the fourth argument to joinAdd() ".
                            "({$joinCol}), or alter your links.ini file. ",
                            DB_DATAOBJECT_ERROR_NODATA);
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
            $this->raiseError(
                "joinAdd: {$obj->tableName()} has no link with {$this->tableName()}",
                DB_DATAOBJECT_ERROR_NODATA);
            return false;
        }
        $joinType = strtoupper($joinType);
        
        // we default to joining as the same name (this is remvoed later..)
        
        if ($joinAs === false) {
            $joinAs = $obj->tableName();
        }
        
        $quoteIdentifiers = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);
        $options = $_DB_DATAOBJECT['CONFIG'];
        
        // not sure  how portable adding database prefixes is..
        $objTable = $quoteIdentifiers ? 
                $DB->quoteIdentifier($obj->tableName()) : 
                 $obj->tableName() ;
                
        $dbPrefix  = '';
        if (strlen($obj->_database) && in_array($DB->dsn['phptype'],array('mysql','mysqli'))) {
            $dbPrefix = ($quoteIdentifiers
                         ? $DB->quoteIdentifier($obj->_database)
                         : $obj->_database) . '.';    
        }
        
        // if they are the same, then dont add a prefix...                
        if ($obj->_database == $this->_database) {
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
        if ( strtolower(get_class($obj)) != 'db_dataobject') {
                 
            // now add where conditions for anything that is set in the object 
        
        
        
            $items = $obj->table();
            // will return an array if no items..
            
            // only fail if we where expecting it to work (eg. not joined on a array)
             
            if (!$items) {
                $this->raiseError(
                    "joinAdd: No table definition for {$obj->tableName()}", 
                    DB_DATAOBJECT_ERROR_INVALIDCONFIG);
                return false;
            }
            
            $ignore_null = $options['disable_null_strings'] === false;
            

            foreach($items as $k => $v) {
                if (!isset($obj->$k) && $ignore_null) {
                    continue;
                }
                
                $kSql = ($quoteIdentifiers ? $DB->quoteIdentifier($k) : $k);
                
                if (DB_DataObject::_is_null($obj,$k)) {
                	$obj->whereAdd("{$joinAs}.{$kSql} IS NULL");
                	continue;
                }
                
                if ($v & DB_DATAOBJECT_STR) {
                    $obj->whereAdd("{$joinAs}.{$kSql} = " . $this->_quote((string) (
                            ($v & DB_DATAOBJECT_BOOL) ? 
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
                            
                if (is_object($obj->$k) && is_a($obj->$k,'DB_DataObject_Cast')) {
                    $value = $obj->$k->toString($v,$DB);
                    if (PEAR::isError($value)) {
                        $this->raiseError($value->getMessage() ,DB_DATAOBJECT_ERROR_INVALIDARG);
                        return false;
                    } 
                    $obj->whereAdd("{$joinAs}.{$kSql} = $value");
                    continue;
                }
                
                
                /* this is probably an error condition! */
                $obj->whereAdd("{$joinAs}.{$kSql} = 0");
            }
            if ($this->_query === false) {
                $this->raiseError(
                    "joinAdd can not be run from a object that has had a query run on it,
                    clone the object or create a new one and use setFrom()", 
                    DB_DATAOBJECT_ERROR_INVALIDARGS);
                return false;
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
            if (in_array($DB->dsn["phptype"],array('pgsql'))) {
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
            $joinAs   = $DB->quoteIdentifier($joinAs);
            $table    = $DB->quoteIdentifier($table);     
            $ofield   = (is_array($ofield)) ? array_map(array($DB, 'quoteIdentifier'), $ofield) : $DB->quoteIdentifier($ofield);
            $tfield   = (is_array($tfield)) ? array_map(array($DB, 'quoteIdentifier'), $tfield) : $DB->quoteIdentifier($tfield); 
        }
        // add database prefix if they are different databases
       
        
        $fullJoinAs = '';
        $addJoinAs  = ($quoteIdentifiers ? $DB->quoteIdentifier($obj->tableName()) : $obj->tableName()) != $joinAs;
        if ($addJoinAs) {
            // join table a AS b - is only supported by a few databases and is probably not needed
            // , however since it makes the whole Statement alot clearer we are leaving it in
            // for those databases.
            $fullJoinAs = in_array($DB->dsn["phptype"],array('mysql','mysqli','pgsql')) ? "AS {$joinAs}" :  $joinAs;
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
                $this->whereAdd("{$joinAs}.{$ofield}={$table}.{$tfield}");
        }
         
         
        return true;

    }

    /**
     * autoJoin - using the links.ini file, it builds a query with all the joins 
     * usage: 
     * $x = DB_DataObject::factory('mytable');
     * $x->autoJoin();
     * $x->get(123); 
     *   will result in all of the joined data being added to the fetched object..
     * 
     * $x = DB_DataObject::factory('mytable');
     * $x->autoJoin();
     * $ar = $x->fetchAll();
     *   will result in an array containing all the data from the table, and any joined tables..
     * 
     * $x = DB_DataObject::factory('mytable');
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
     *          links    The equivilant links.ini data for this table eg.
     *                    array( 'person_id' => 'person:id', .... )
     *          include  Array of columns to include
     *          distinct Array of distinct columns.
     *          
     * @return   array      info about joins
     *                      cols => map of resulting {joined_tablename}.{joined_table_column_name}
     *                      join_names => map of resulting {join_name_as}.{joined_table_column_name}
     *                      count => the column to count on.
     * @access   public
     */
    function autoJoin($cfg = array())
    {
        global $_DB_DATAOBJECT;
        //var_Dump($cfg);exit;
        $pre_links = $this->links();
        if (!empty($cfg['links'])) {
            $this->links(array_merge( $pre_links , $cfg['links']));
        }
        $map = $this->links( );
        
        $this->databaseStructure();
        $dbstructure = $_DB_DATAOBJECT['INI'][$this->_database];
        //print_r($map);
        $tabdef = $this->table();
         
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
            
             //echo '<PRE>' ;print_r($xx);exit;
            foreach($keys as $c) {
                //var_dump($c);
                
                if (  $cfg['distinct'] == $c) {
                    $has_distinct = 'DISTINCT( ' . $this->tableName() .'.'. $c .') as ' . $c;
                    $ret['count'] =  'DISTINCT  ' . $this->tableName() .'.'. $c .'';
                    continue;
                }
                // cols is in our filtered keys...
                $cols = $c;
                
            }
            // apply our filtered version, which excludes the distinct column.
            
            $selectAs = empty($cols) ?  array() : array(array(array(  $cols) , '%s', false)) ;
            
            
            
        } 
                
        foreach($keys as $k) {
            $ret['cols'][$k] = $this->tableName(). '.' . $k;
        }
        
        
        
        foreach($map as $ocl=>$info) {
            if (strpos($info, ':') === false) {
                $this->raiseError(
                    "format of links.ini is not correct for table {$this->tableName()} - missing 'colon:' in value - " . print_R($map,true), 
                    DB_DATAOBJECT_ERROR_INVALIDCONFIG);
                continue;
            }
            list($tab,$col) = explode(':', $info);
            // what about multiple joins on the same table!!!
            
            // if links point to a table that does not exist - ignore.
            if (!isset($dbstructure[$tab])) {
                continue;
            }
            
            if (!empty($cfg['exclude']) && in_array($tab .'.*', $cfg['exclude'])) {
                continue;
            }
            
            $xx = DB_DataObject::factory($tab);
            if (!is_object($xx) || !is_a($xx, 'DB_DataObject')) {
                continue;
            }
            // skip columns that are excluded.
            
            // we ignore include here... - as
             
            // this is borked ... for multiple jions..
            $this->joinAdd($xx, 'LEFT', 'join_'.$ocl.'_'. $col, $ocl);
            
            if (!empty($cfg['exclude']) && in_array($ocl, $cfg['exclude'])) {
                continue;
            }
            
            $tabdef = $xx->table();
            $table = $xx->tableName();
            
            $keys = array_keys($tabdef);
            
            
            if (!empty($cfg['exclude'])) {
                $keys = array_intersect($keys, array_diff($keys, $cfg['exclude']));
                
                foreach($keys as $k) {
                    if (in_array($ocl.'_'.$k, $cfg['exclude'])) {
                        $keys = array_diff($keys, $k); // removes the k..
                    }
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
        
        // fill in the select details..
        $this->selectAdd(); 
        
        if ($has_distinct) {
            $this->selectAdd($has_distinct);
        }
       
        foreach($selectAs as $ar) {            
            $this->selectAs($ar[0], $ar[1], $ar[2]);
        }
        // restore links..
        $this->links( $pre_links );
        
        return $ret;
        
    }
    
    /**
     * Factory method for calling DB_DataObject_Cast
     *
     * if used with 1 argument DB_DataObject_Cast::sql($value) is called
     * 
     * if used with 2 arguments DB_DataObject_Cast::$value($callvalue) is called
     * valid first arguments are: blob, string, date, sql
     * 
     * eg. $member->updated = $member->sqlValue('NOW()');
     * 
     * 
     * might handle more arguments for escaping later...
     * 
     *
     * @param string $value (or type if used with 2 arguments)
     * @param string $callvalue (optional) used with date/null etc..
     */
    
    function sqlValue($value)
    {
        $method = 'sql';
        if (func_num_args() == 2) {
            $method = $value;
            $value = func_get_arg(1);
        }
        require_once 'DB/DataObject/Cast.php';
        return call_user_func(array('DB_DataObject_Cast', $method), $value);
        
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
     * @return   true on success or array of key=>setValue error message
     */
    function setFrom($from, $format = '%s', $skipEmpty=false)
    {
        global $_DB_DATAOBJECT;
        $keys  = $this->keys();
        $items = $this->table();
            
     
        if (!$items) {
            $this->raiseError(
                "setFrom:Could not find table definition for {$this->tableName()}", 
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return;
        }
        $overload_return = array();
        foreach (array_keys($items) as $k) {
            if (in_array($k,$keys)) {
                continue; // dont overwrite keys
            }
            if (!$k) {
                continue; // ignore empty keys!!! what
            }
            
            $chk = is_object($from) &&  
                (version_compare(phpversion(), "5.1.0" , ">=") ? 
                    property_exists($from, sprintf($format,$k)) :  // php5.1
                    array_key_exists( sprintf($format,$k), get_class_vars($from)) //older
                );
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
            
            if (!isset($from[sprintf($format,$k)]) && !DB_DataObject::_is_null($from, sprintf($format,$k))) {
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
            if (is_a($val, 'DB_DataObject_Cast')) {
                $this->$k = $val;
                continue;
            }
            if (is_object($val) || is_array($val)) {
                continue;
            }
            $ret = $this->fromValue($k,$val);
            if ($ret !== true)  {
                $overload_return[$k] = 'Not A Valid Value';
            }
            //$this->$k = $from[sprintf($format,$k)];
        }
        if ($overload_return) {
            return $overload_return;
        }
        return true;
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
            (($hideEmpty === 0) ? $rf : array_merge($rf, $this->table())) :
            $this->table();

        foreach($ar as $k=>$v) {
             
            if (!isset($this->$k)) {
                if (!$hideEmpty) {
                    $ret[$format === false ? $k : sprintf($format,$k)] = '';
                }
                continue;
            }
            // call the overloaded getXXXX() method. - except getLink and getLinks
            if (method_exists($this,'get'.$k) && !in_array(strtolower($k),array('links','link'))) {
                $ret[$format === false ? $k : sprintf($format,$k)] = $this->{'get'.$k}();
                continue;
            }
            // should this call toValue() ???
            $ret[$format === false ? $k : sprintf($format,$k)] = $this->$k;
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
     * validate the values of the object (usually prior to inserting/updating..)
     *
     * Note: This was always intended as a simple validation routine.
     * It lacks understanding of field length, whether you are inserting or updating (and hence null key values)
     *
     * This should be moved to another class: DB_DataObject_Validate 
     *      FEEL FREE TO SEND ME YOUR VERSION FOR CONSIDERATION!!!
     *
     * Usage:
     * if (is_array($ret = $obj->validate())) { ... there are problems with the data ... }
     *
     * Logic:
     *   - defaults to only testing strings/numbers if numbers or strings are the correct type and null values are correct
     *   - validate Column methods : "validate{ROWNAME}()"  are called if they are defined.
     *            These methods should return 
     *                  true = everything ok
     *                  false|object = something is wrong!
     * 
     *   - This method loads and uses the PEAR Validate Class.
     *
     *
     * @access  public
     * @return  array of validation results (where key=>value, value=false|object if it failed) or true (if they all succeeded)
     */
    function validate()
    {
        global $_DB_DATAOBJECT;
        require_once 'Validate.php';
        $table = $this->table();
        $ret   = array();
        $seq   = $this->sequenceKey();
        $options = $_DB_DATAOBJECT['CONFIG'];
        foreach($table as $key => $val) {
            
            
            // call user defined validation always...
            $method = "Validate" . ucfirst($key);
            if (method_exists($this, $method)) {
                $ret[$key] = $this->$method();
                continue;
            }
            
            // if not null - and it's not set.......
            
            if ($val & DB_DATAOBJECT_NOTNULL && DB_DataObject::_is_null($this, $key)) {
                // dont check empty sequence key values..
                if (($key == $seq[0]) && ($seq[1] == true)) {
                    continue;
                }
                $ret[$key] = false;
                continue;
            }
            
            
             if (DB_DataObject::_is_null($this, $key)) {
                if ($val & DB_DATAOBJECT_NOTNULL) {
                    $this->debug("'null' field used for '$key', but it is defined as NOT NULL", 'VALIDATION', 4);
                    $ret[$key] = false;
                    continue;
                }
                continue;
            }

            // ignore things that are not set. ?
           
            if (!isset($this->$key)) {
                continue;
            }
            
            // if the string is empty.. assume it is ok..
            if (!is_object($this->$key) && !is_array($this->$key) && !strlen((string) $this->$key)) {
                continue;
            }
            
            // dont try and validate cast objects - assume they are problably ok..
            if (is_object($this->$key) && is_a($this->$key,'DB_DataObject_Cast')) {
                continue;
            }
            // at this point if you have set something to an object, and it's not expected
            // the Validate will probably break!!... - rightly so! (your design is broken, 
            // so issuing a runtime error like PEAR_Error is probably not appropriate..
            
            switch (true) {
                // todo: date time.....
                case  ($val & DB_DATAOBJECT_STR):
                    $ret[$key] = Validate::string($this->$key, VALIDATE_PUNCTUATION . VALIDATE_NAME);
                    continue;
                case  ($val & DB_DATAOBJECT_INT):
                    $ret[$key] = Validate::number($this->$key, array('decimal'=>'.'));
                    continue;
            }
        }
        // if any of the results are false or an object (eg. PEAR_Error).. then return the array..
        foreach ($ret as $key => $val) {
            if ($val !== true) {
                return $ret;
            }
        }
        return true; // everything is OK.
    }

   
 
    /**
     * Gets the DB result object related to the objects active query
     *
     * @access public
     * @return PDOStatement|false  
     */
     
    function result()
    {
        return !$this->_result ? false :
            (is_a($this->_result,'StdClass') ? false : $this->_result);
        
    }
 
    
    /**
    * standard set* implementation.
    *
    * takes data and uses it to set dates/strings etc.
    * normally called from __call..  
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
    * @return   true| false     (False on error)
    * @access   public 
    * @see      DB_DataObject::_call
    */
  
    
    function fromValue($col,$value) 
    {
        global $_DB_DATAOBJECT;
        $options = $_DB_DATAOBJECT['CONFIG'];
        $cols = $this->table();
        // dont know anything about this col..
        if (!isset($cols[$col]) || is_a($value, 'DB_DataObject_Cast')) {
            $this->$col = $value;
            return true;
        }
        //echo "FROM VALUE $col, {$cols[$col]}, $value\n";
        switch (true) {
            // set to null and column is can be null...
            case ((!($cols[$col] & DB_DATAOBJECT_NOTNULL)) && DB_DataObject::_is_null($value, false)):
            case (is_object($value) && is_a($value,'DB_DataObject_Cast')): 
                $this->$col = $value;
                return true;
                
            // fail on setting null on a not null field..
            case (($cols[$col] & DB_DATAOBJECT_NOTNULL) && DB_DataObject::_is_null($value,false)):

                return false;
        
            case (($cols[$col] & DB_DATAOBJECT_DATE) &&  ($cols[$col] & DB_DATAOBJECT_TIME)):
                // empty values get set to '' (which is inserted/updated as NULl
                if (!$value) {
                    $this->$col = '';
                }
            
                if (is_numeric($value)) {
                    $this->$col = date('Y-m-d H:i:s', $value);
                    return true;
                }
              
                // eak... - no way to validate date time otherwise...
                $this->$col = (string) $value;
                return true;
            
            case ($cols[$col] & DB_DATAOBJECT_DATE):
                // empty values get set to '' (which is inserted/updated as NULl
                 
                if (!$value) {
                    $this->$col = '';
                    return true; 
                }
            
                if (is_numeric($value)) {
                    $this->$col = date('Y-m-d',$value);
                    return true;
                }
                 
                // try date!!!!
                require_once 'Date.php';
                $x = new Date($value);
                $this->$col = $x->format("%Y-%m-%d");
                return true;
            
            case ($cols[$col] & DB_DATAOBJECT_TIME):
                // empty values get set to '' (which is inserted/updated as NULl
                if (!$value) {
                    $this->$col = '';
                }
            
                $guess = strtotime($value);
                if ($guess != -1) {
                     $this->$col = date('H:i:s', $guess);
                    return $return = true;
                }
                // otherwise an error in type...
                return false;
            
            case ($cols[$col] & DB_DATAOBJECT_STR):
                
                $this->$col = (string) $value;
                return true;
                
            // todo : floats numerics and ints...
            default:
                $this->$col = $value;
                return true;
        }
    
    
    
    }
     /**
    * standard get* implementation.
    *
    *  with formaters..
    * supported formaters:  
    *   date/time : %d/%m/%Y (eg. php strftime) or pear::Date 
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
    * @see      DB_DataObject::_call(),strftime(),Date::format()
    */
    function toValue($col,$format = null) 
    {
        if (is_null($format)) {
            return $this->$col;
        }
        $cols = $this->table();
        switch (true) {
            case (($cols[$col] & DB_DATAOBJECT_DATE) &&  ($cols[$col] & DB_DATAOBJECT_TIME)):
                if (!$this->$col) {
                    return '';
                }
                $guess = strtotime($this->$col);
                if ($guess != -1) {
                    return strftime($format, $guess);
                }
                // eak... - no way to validate date time otherwise...
                return $this->$col;
            case ($cols[$col] & DB_DATAOBJECT_DATE):
                if (!$this->$col) {
                    return '';
                } 
                $guess = strtotime($this->$col);
                if ($guess != -1) {
                    return strftime($format,$guess);
                }
                // try date!!!!
                require_once 'Date.php';
                $x = new Date($this->$col);
                return $x->format($format);
                
            case ($cols[$col] & DB_DATAOBJECT_TIME):
                if (!$this->$col) {
                    return '';
                }
                $guess = strtotime($this->$col);
                if ($guess > -1) {
                    return strftime($format, $guess);
                }
                // otherwise an error in type...
                return $this->$col;
                
            case ($cols[$col] &  DB_DATAOBJECT_MYSQLTIMESTAMP):
                if (!$this->$col) {
                    return '';
                }
                require_once 'Date.php';
                
                $x = new Date($this->$col);
                
                return $x->format($format);
            
             
            case ($cols[$col] &  DB_DATAOBJECT_BOOL):
                
                if ($cols[$col] &  DB_DATAOBJECT_STR) {
                    // it's a 't'/'f' !
                    return ($this->$col === 't');
                }
                return (bool) $this->$col;
            
               
            default:
                return sprintf($format,$this->col);
        }
            

    }
    
    
    /* ----------------------- Debugger ------------------ */

    /**
     * Debugger. - use this in your extended classes to output debugging information.
     *
     * Uses DB_DataObject::DebugLevel(x) to turn it on
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
     * eg. DB_DataObject::debugLevel(4);
     *
     * @param   int     $v  level
     * @access  public
     * @return  none
     */
    static function debugLevel($v = null)
    {
        // can be slow....
        PDO_DataObject::config();
        
        if ($v !== null) {
            
            $r = self::$debug;
            self::$debug = $v;
            self::$config['debug'] = $v;// for reference only
            return $r;
        }
        return self::$debug;
    }


    /**
     * Default error handling is to create throw an exception , unless config[excpetions] == false
     * if it's off a pear error is returned (and may trigger a 'DIE' event
     * if you need to handle errors you should look at setting the PEAR_Error callback
     * this is due to the fact it would wreck havoc on the internal methods!
     *
     * @param  int $message    message
     * @param  int $type       type
     * @param  int $behaviour  behaviour (die or continue!);
     * @param  Exception $previous_exception  Cause of error...
     * @access public
     * @return error object
     */
    function raiseError($message, $type = 0, $behaviour = null, $previous_exception = null)
    {
        PDO_DataObject::debug($message,'ERROR',1);
        
        // default behaviour now...
        if (self::$config['exceptions']) {
            //?? is this it???
            
            throw  new Exception($message, $type, $previous_exception);
            
        }
        
         
        if ($behaviour == self::ERROR_DIE && self::$config['dont_die']) {
            $behaviour = null;
        }
        
        
        class_exists('PEAR') ? '' : require_once 'PEAR.php';
        
        
        $error = &PEAR::getStaticProperty('DB_DataObject','lastError');
          
        if (PEAR::isError($message)) {
            $error = $message;
            return $error;
        }
        
        class_exists('PDO_DataObject_Error') ? '' : require_once 'PDO/DataObject/Error.php';
        $dor = new PEAR();
        $error = $dor->raiseError($message, $type, $behaviour,
                $opts=null, $userinfo=null, 'PDO_DataObject_Error'
        );
        
        // this will never work totally with PHP's object model.
        // as this is passed on static calls (like staticGet in our case)
 
        
        return $error;
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
        self::$config_loaded = false;
        self::$connections = array(); 
        self::$ini = array();
        self::$links = array();
        self::$sequence = array();
        
    }
    /**
    * Evaluate whether or not a value is set to null, taking the 'disable_null_strings' option into account.
    * If the value is a string set to "null" and the "disable_null_strings" option is not set to 
    * true, then the value is considered to be null.
    * If the value is actually a PHP NULL value, and "disable_null_strings" has been set to 
    * the value "full", then it will also be considered null. - this can not differenticate between not set
    * 
    * 
    * @param  object|array $obj_or_ar 
    * @param  string|false $prop prperty
    
    * @access private
    * @return bool  object
    */
    function _is_null($obj_or_ar , $prop) 
    {
     	
        
        $isset = $prop === false ? isset($obj_or_ar) : 
            (is_array($obj_or_ar) ? isset($obj_or_ar[$prop]) : isset($obj_or_ar->$prop));
        
        $value = $isset ? 
            ($prop === false ? $obj_or_ar : 
                (is_array($obj_or_ar) ? $obj_or_ar[$prop] : $obj_or_ar->$prop))
            : null;
        
        
        
    	$options = self::$config;
    	
        $null_strings =  $options['disable_null_strings'] === false;
                    
        $crazy_null =   $options['disable_null_strings'] === 'full'; // why case insensitive?
        
        if ( $null_strings && $isset  && is_string($value)  && (strtolower($value) === 'null') ) {
            return true;
        }
        
        if ( $crazy_null && !$isset )  {
        	return true;
        }
        
        return false;
        
    	
    }
     
    
    
    
} 

