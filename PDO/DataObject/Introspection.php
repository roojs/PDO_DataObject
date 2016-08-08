<?php
/**
 * Object Based Database Query Builder and data store
 *  - Introspection Component.
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
  
  
class PDO_DataObject_Introspection
{
    
    private $dataobject;
    
    /**
     * Constructor
     * @arg DataObject $do   - the dataobject.
      */
    
    function __construct(PDO_DataObject $do)
    {
        $this->dataobject = $do;
        
    }
    /**
     * 'complex' version of databaseStructure - this is not so 'speed sensitive'
     * only used when
     * a) setting manually the structure or ini.
     * b) proxy is set..
     * c) ini_**** is set...
     *
     *
     *
     *    
     * usage :
     * DB_DataObject::databaseStructure(  'databasename',
     *                                    parse_ini_file('mydb.ini',true), 
     *                                    parse_ini_file('mydb.link.ini',true)); 
     *
     * 1 argument:
     * DB_DataObject::databaseStructure(  'databasename')
     *  - returns the structure
     *  - always calls generator...
     
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
    
    function databaseStructure()
    {
        
         
        
        // Assignment code 
        
        if ($args = func_get_args()) {
             
                // this returns all the tables and their structure..
                
            $this->do->debug("Loading Generator as databaseStructure called with args",1);
            
            
            $x = new PDO_DataObject();
            $x->databaseName( $args[0]);
            $x->PDO();
             
            $tables = (new PDO_DataObject_Introspection($x))->getListOf('tables');
            
               
            foreach($tables as $table) {
                
                $this->relayGenerator('fillTableSchema', array($x->databaseName(), $table));
                
            }
            
            return PDO_DataObject::$ini[$x->databaseName()];            
         
            // databaseStructure('mydb',   array(.... schema....), array( ... links')
         
            // will not get here....
        }
        
        
        $this->PDO();
        
        
        $database = $this->do->databaseName();
        $table = $this->do->tableName();
        
        // probably not need (pdo() will load it..)
        PDO_DataObject::loadConfig();
        
        // we do not have the data for this table yet...
        
        // if we are configured to use the proxy..
        
        if ( PDO_DataObject::$config['proxy'])  {
            
            $this->relayGenerator('fillTableSchema', array($database, $table));
            return true;
        }
            
             
        
        
        // if you supply this with arguments, then it will take those
        // as the database and links array...
         
        //           
        
        $schemas = is_array(PDO_DataObject::$config["ini_{$database}"]) ?
            PDO_DataObject::$config["ini_{$database}"] :
            explode(PATH_SEPARATOR,PDO_DataObject::$config["ini_{$database}"]);
        
                    
         
        $ini_out  = array();
        foreach ($schemas as $ini) {
            if (empty($ini)) {
                continue;
            }
            if (!file_exists($ini) || !is_file($ini) || !is_readable ($ini)) {
                $this->do->debug("ini file is not readable / does not exist: $ini","databaseStructure",1);
                return $this->do->raiseError( "Unable to load schema for database and table (turn debugging up to 5 for full error message)",
                                   PDO_DataObject::ERROR_INVALIDARGS, PDO_DataObject::ERROR_DIE);
       
            }
            $ini_out = array_merge(
                $ini_out,
                parse_ini_file($ini, true)
            );
                
             
        }
        
        // are table name lowecased..
        if (PDO_DataObject::$config['portability'] & 1) {
            foreach($ini_out as $k=>$v) {
                // results in duplicate cols.. but not a big issue..
                $ini_out[strtolower($k)] = $v;
            }
        }
        if (!empty($ini_out)) {
            PDO_DataObject::databaseStructure($database,$ini_out,false, true);
        }
        $dbini = PDO_DataObject::databaseStructure($database,false);
        
        // now have we loaded the structure.. 
        
        if (!empty($dbini[$this->tableName()])) {
            return true;
        }
        // - if not try building it..
        if (!empty($_DB_DATAOBJECT['CONFIG']['proxy'])) {
            class_exists('DB_DataObject_Generator') ? '' : 
                require_once 'DB/DataObject/Generator.php';
                
            $x = new DB_DataObject_Generator;
            $x->fillTableSchema($this->_database,$this->tableName());
            // should this fail!!!???
            return true;
        }
        $this->debug("Cant find database schema: {$this->_database}/{$this->tableName()} \n".
                    "in links file data: " . print_r($_DB_DATAOBJECT['INI'],true),"databaseStructure",5);
        // we have to die here!! - it causes chaos if we dont (including looping forever!)
        $this->raiseError( "Unable to load schema for database and table (turn debugging up to 5 for full error message)", DB_DATAOBJECT_ERROR_INVALIDARGS, PEAR_ERROR_DIE);
        return false;
        
         
        
    }
    
    private function relayGenerator($method, $args)
    {
            
            $this->debug("Loading Generator to fetch Schema",1);
            
            class_exists('PDO_DataObject_Generator') ? '' : 
                require_once 'DB/DataObject/Generator.php';
                
            
            $x = new DB_DataObject_Generator;
            return call_user_func_array(
                    array($method, $args)
            );
        
    }
    
    
}