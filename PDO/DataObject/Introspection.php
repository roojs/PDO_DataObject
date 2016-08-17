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
    /**
     * @var PDO_DataObject $do - the dataobject.
     */
    protected $do;
    
    /**
     * Constructor
     * @arg DataObject $do   - the dataobject.
      */
    
    function __construct(PDO_DataObject $do)
    {
        $this->do = $do;
        
    }
    /**
     * ?? might be better in generator?
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

        $config = PDO_DataObject::config();
        if ($table === false) {
            // get all 
            $this->do->debug("Loading Generator as databaseStructure called with args for database = {$database}",1);
            
            
            
            $x = new PDO_DataObject();
            $x->database( $database );
            $x->PDO();
            $cls = get_class($this);
             
            $tables = (new $cls ($x))->getListOf('tables');
           
            if (empty($tables)) {
                $this->do->raiseError("Could not introspect database, no table returned from getListOf(tables)");
            }
        } else {
            $tables = array($tables);
        }
        
        foreach($tables as $table) {
            
            $this->_generator()->fillTableSchema($x->database(), $table);
            
        }
            // prevent recursion...
            
        PDO_DataObject::config('proxy', false);
        $ret = $x->databaseStructure($x->database()); 
        PDO_DataObject::config($config );
        return $ret;
            // databaseStructure('mydb',   array(.... schema....), array( ... links')
         
            // will not get here....
    }
     
    
    
    
    /**
     * Create an instance of the generator.
     *
     * @returns PDO_DataObject_Generator
     */
    private function _generator()
    {
        class_exists('PDO_DataObject_Generator') ? '' : 
                require_once 'PDO/DataObject/Generator.php';
        return new PDO_DataObject_Generator();
    }
    
    /**
     * Lists internal database information
     *
     * @param string $type  type of information being sought.
     *                       Common items being sought are:
     *                       tables, databases, users, views, functions
     *                       Each DBMS's has its own capabilities.
     *
     * @return array  an array listing the items sought.
     *                Or throws an error..
     */
    
    function getListOf($type)
    {
        $this->do->debug($type, __FUNCTION__);
        $sql = $this->getSpecialQuery($type); // can throw an exception...
        if ($sql === null) {
            $this->last_query = '';
            return $this->do->raiseError("Can not get Listof $type", PDO_DataObject::ERROR_INVALIDCONFIG);
        }
        $this->do->debug($sql, __FUNCTION__);
      
        if (is_array($sql)) {
            // Already the result
            return $sql;
        }
        $this->do->query($sql);
        $ret = array();
        while ($this->do->fetch()) {
            // pretty slow way to do this, but if we are doing this stuff it's slow anyway.
            $ret[] = array_values($this->do->toArray())[0];
        }
        //var_export($ret);
        
        return $ret;
    }
    
    // we could put a generic tableInfo here... - using ColumnMeta ??
    
    
}


