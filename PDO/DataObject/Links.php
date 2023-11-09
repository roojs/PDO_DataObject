<?php
/**
 * Link tool for PDO_DataObject
 *
 * PHP versions 5 & 7
 *
 * Copyright (c) 2023 Alan Knowles
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

/**
 *
 * Example of how this could be used..
 * 
 * The link method are now in here.
 *
 * Currenly only supports existing methods, and new 'link()' method
 *
 */
  
  
/**
 * Links class
 *
 * @package DB_DataObject
 */
class PDO_DataObject_Links 
{
     /**
     * @property {DB_DataObject}      do   DataObject to apply this to.
     */
    var $do = false;
    
    
    /**
     * @property {Array|String} load    What to load, 'all' or an array of properties. (default all)
     */
    var $load = 'all';
    /**
     * @property {String|Boolean}       scanf   use part of column name as resulting
     *                                          property name. (default false)
     */
    var $scanf = false;
    /**
     * @property {String|Boolean}       printf  use column name as sprintf for resulting property name..
     *                                     (default %s_link if apply is true, otherwise it is %s)
     */
    var $printf = false;
    /**
     * @property {Boolean}      cached  cache the result, so future queries will use cache rather
     *                                  than running the expensive sql query.
     */
    var $cached = false;
    /**
     * @property {Boolean}      apply   apply the result to this object, (default true)
     */
    var $apply = true;
   
    
    //------------------------- RETURN ------------------------------------
    /**
     * @property {Array}      links    key value associative array of links.
     */
    var $links;
    
    
    /**
     * Constructor
     *   -- good ole style..
     *  @param {DB_DataObject}           do  DataObject to apply to.
     *  @param {Array}           cfg  Configuration (basically properties of this object)
     */
    
    function __construct($do,$cfg= array())
    {
        // check if do is set!!!?
        $this->do = $do;
        
        foreach($cfg as $k=>$v) {
            $this->$k = $v;
        }
       
        
    }
     
    /**
     * return name from related object
     *
     * The relies on  a <dbname>.links.ini file, unless you specify the arguments.
     * 
     * you can also use $this->getLink('thisColumnName','otherTable','otherTableColumnName')
     *
     *
     * @param string $field|array    either row or row.xxxxx or links spec.
     * @param string|DB_DataObject $table  (optional) name of table to look up value in
     * @param string $link   (optional)  name of column in other table to match
     * @author Tim White <tim@cyface.com>
     * @access public
     * @return mixed object on success false on failure or '0' when not linked
     */
    function getLink($field, $table= false, $link='')
    {
        
        static $cache = array();
        
        // GUESS THE LINKED TABLE.. (if found - recursevly call self)
        
        if ($table == false) {
            
            
            $info = $this->linkInfo($field);
            
            if ($info) {
                return $this->getLink($field, $info[0],  $link === false ? $info[1] : $link );
            }
            
            // no links defined.. - use borked BC method...
                  // use the old _ method - this shouldnt happen if called via getLinks()
            if (!($p = strpos($field, '_'))) {
                return false;
            }
            $table = substr($field, 0, $p);
            return $this->getLink($field, $table);
            
            

        }
         
        $tn = is_string($table) ? $table : $table->tableName();
         
            
 
        if (!isset($this->do->$field)) {
            $this->do->raise("getLink: row not set $field", PDO_DataObject::ERROR_NODATA);
            return false;
        }
        
        // check to see if we know anything about this table..
        
        
        if (empty($this->do->$field) || $this->do->$field < 0) {
            return 0; // no record. 
        }
        
        if ($this->cached && isset($cache[$tn.':'. $link .':'. $this->do->$field])) {
            return $cache[$tn.':'. $link .':'. $this->do->$field];    
        }
        
        $obj = is_string($table) ? $this->do->factory($table) : $table;
        
        if (!is_a($obj,'PDO_DataObject')) {
            $this->do->raise(
                "getLink:Could not find class for row $field, table $tn", 
                PDO_DataObject::ERROR_INVALIDCONFIG);
            return false;
        }
        // -1 or 0 -- no referenced record..
       
        $ret = false;
        if ($link) {

            if ($obj->get($link, $this->do->$field)) {
                $ret = $obj;
            }
            
            
        // this really only happens when no link config is set (old BC stuff)    
        } else if ($obj->get($this->do->$field)) {
            $ret= $obj;
             
        }
        if ($this->cached) {
            $cache[$tn.':'. $link .':'. $this->do->$field] = $ret;
        }
        return $ret;
        
    }
    /**
     * get link information for a field or field specification
     *
     * alll link (and join methods accept the 'link' info ) in various ways
     * string : 'field' = which field to get (uses ???.links.ini to work out what)
     * array(2) : 'field', 'table:remote_col' << just like the links.ini def.
     * array(3) : 'field', $dataobject, 'remote_col'  (handy for joinAdd to do nested joins.)
     *
     * @param string|array $field or link spec to use. 
     * @return (false|array) array of dataobject and linked field or false.
     *
     *
     */
    
    function linkInfo($field)
    {
         
        if (is_array($field)) {
            if (count($field) == 3) {
                // array with 3 args:
                // local_col , dataobject, remote_col
                return array(
                    $field[1],
                    $field[2],
                    $field[0]
                );
                
            } 
            list($table,$link) = explode(':', $field[1]);
            
            return array(
                $this->do->factory($table),
                $link,
                $field[0]
            );
            
        }
        // work out the link.. (classic way)
        
        $links = $this->do->links();
        
        if (empty($links) || !is_array($links)) {
             
            return false;
        }
            
            
        if (!isset($links[$field])) {
            
            return false;
        }
        list($table,$link) = explode(':', $links[$field]);
    
        
        //??? needed???
        if ($p = strpos($field,".")) {
            $field = substr($field,0,$p);
        }
        
        return array(
            $this->do->factory($table),
            $link,
            $field
        );
        
        
         
        
    }
    
    
        
    /**
     *  a generic geter/setter provider..
     *
     *  provides a generic getter setter for the referenced object
     *  eg.
     *  $link->link('company_id') returns getLink for the object
     *  if nothing is linked (it will return an empty dataObject)
     *  $link->link('company_id', array(1)) - just sets the 
     *
     *  also array as the field speck supports
     *      $link->link(array('company_id', 'company:id'))
     *  
     *
     *  @param  string|array   $field   the field to fetch or link spec.
     *  @params array          $args    the arguments sent to the getter setter
     *  @return mixed true of false on set, the object on getter.
     *
     */
    function link($field, $assign = false)
    {
        $info = $this->linkInfo($field);
       
        if (!$info) {
            return $this->do->raise(
                "getLink:Could not find link for row $field", 
                PDO_DataObject::ERROR_INVALIDCONFIG);
            
        }
        $field = $info[2];
        
        $cols = $this->do->tableColumns();
        if (!isset($cols[$field])) {
            $this->do->raiseError("table {$this->do->tableName()} does not have the column used for the linked field {$field}",
                PDO_DataObject::ERROR_INVALIDARGS);
        }

        
        if ($assign === false) { // either an empty array or really empty....
            

            if (!isset($this->do->$field)) {
                return $info[0]; // empty dataobject.
            }
            
            $ret = $this->getLink($field);
            // nothing linked -- return new object..
            return ($ret === 0) ? $info[0] : $ret;
            
        }
        // otherwise it's a set call..

        // we used to support array as args.. ?? why!?!
        
        if (is_a($assign , 'PDO_DataObject')) {
            $this->do->$field = $assign->{$info[1]};
            return $this->do;
        }
            

        if (!is_numeric($assign)) {
            $this->do->raise("Assigning foreign key column to a non_numeric value",
                  PDO_DataObject::ERROR_INVALIDARGS);
        }
        $assign *=1;
        if ($assign  == 0) {           
            $this->do->$field = 0;
            return $this->do;
        }
           
                    // check that record exists..
        if (!$info[0]->get($info[1], $assign )) {
            $this->do->raise("Assigning foreign key value to point to a non existant element",
                  PDO_DataObject::ERROR_INVALIDARGS);

        }
                    
        $this->do->$field = $assign ;
        
        return $this->do;
        // otherwise we are assigning it ...
        
        
        
        
    }
    /**
     * load related objects
     * @depricated
     *
     * This code has not been tested with PDO_DataObjects
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
         
        // get table will load the options.
        if ($this->do->_link_loaded) {
            return true;
        }
        
        $this->do->_link_loaded = false;
        $cols  = $this->do->tableColumns();
        $links = $this->do->links();
         
        $loaded = array();
        
        if ($links) {   
            foreach($links as $key => $match) {
                list($table,$link) = explode(':', $match);
                $k = sprintf($format, str_replace('.', '_', $key));
                // makes sure that '.' is the end of the key;
                if ($p = strpos($key,'.')) {
                      $key = substr($key, 0, $p);
                }
                
                $this->do->$k = $this->getLink($key, $table, $link);
                
                if (is_object($this->do->$k)) {
                    $loaded[] = $k; 
                }
            }
            $this->do->_link_loaded = $loaded;
            return true;
        }
        // this is the autonaming stuff..
        // it sends the column name down to getLink and lets that sort it out..
        // if there is a links file then it is not used!
        // IT IS DEPRECATED!!!! - DO NOT USE 
        if (!is_null($links)) {    
            return false;
        }
        
        
        foreach (array_keys($cols) as $key) {
            if (!($p = strpos($key, '_'))) {
                continue;
            }
            // does the table exist.
            $k =sprintf($format, $key);
            $this->do->$k = $this->getLink($key);
            if (is_object($this->do->$k)) {
                $loaded[] = $k; 
            }
        }
        $this->do->_link_loaded = $loaded;
        return true;
    }
    
    /**
     * getLinkArray
     * @depricated
     * 
     * I think the original idea was to load reverse foriegn keys... 
     * it would be far more usefull, if this used a cross reference table to load and save related items.
     * as that is a far more common pattern.
     *
     * This code has not been tested with PDO_DataObjects
     *
     * Fetch an array of related objects. This should be used in conjunction with a
     * <dbname>.links.ini file configuration (see the introduction on linking for details on this).
     *
     * You may also use this with all parameters to specify, the column and related table.
     * 
     * @access public
     * @param string $field- either column or column.xxxxx
     * @param string $table (optional) name of table to look up value in
     * @param string $fkey (optional) fetchall key see DB_DataObject::fetchAll()
     * @param string $fval (optional)fetchall val DB_DataObject::fetchAll()
     * @param string $fval (optional) fetchall method DB_DataObject::fetchAll()
     * @return array - array of results (empty array on failure)
     * 
     * Example - Getting the related objects
     * 
     * $person = PDO_DataObject::Factory('Person');
     * $person->get(12);
     * $children = $person->getLinkArray('children');
     * 
     * echo 'There are ', count($children), ' descendant(s):<br />';
     * foreach ($children as $child) {
     *     echo $child->name, '<br />';
     * }
     * 
     */
    function getLinkArray($field, $table = null, $fkey = false, $fval = false, $fmethod = false)
    {
        
        $ret = array();
        if (!$table)  {
            
            
            $links = $this->do->links();
            
            if (is_array($links)) {
                if (!isset($links[$field])) {
                    // failed..
                    return $ret;
                }
                list($table,$link) = explode(':',$links[$field]);
                return $this->getLinkArray($field,$table);
            } 
            if (!($p = strpos($field,'_'))) {
                return $ret;
            }
            return $this->getLinkArray($field,substr($field,0,$p));


        }
        
        $c  = $this->do->factory($table);
        
        if (!is_object($c) || !is_a($c,'DB_DataObject')) {
            $this->do->raise(
                "getLinkArray:Could not find class for row $field, table $table", 
                PDO_DataObject::ERROR_INVALIDCONFIG
            );
            return $ret;
        }
 
        return $c->fetchAll($fkey, $fval, $fmethod);
        
        
    }

}
