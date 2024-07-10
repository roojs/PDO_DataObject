<?php
/**
 * Generation tools for PDO_DataObject
 * -- replacement of old Hook methods
 * -- just implement this and set
 * -- generator_hook = {classname}|{object}* For PHP versions  5 and 7
 *
 *  NOTE - NONE OF THIS IS TESTED..... - please report issues if you use it..
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
 */

#[AllowDynamicProperties]
class PDO_DataObject_Generator_Hooks {
   
    var $gen;
   
    function __construct($gen)
    {
        $this->gen = $gen;
        
    }
    
      /**
     * hook to add extra methods to all classes
     *
     * called once for each class, use with $this->table and
     * $this->_definitions[$this->table], to get data out of the current table,
     * use it to add extra methods to the default classes.
     *
     * @access   public
     * @return  string added to class eg. functions.
     */
    
    function functions($original)
    {
        return '';
    }
    /**
     * hook to add extra class level DocBlock (in terms of phpDocumentor)
     *
     * called once for each class, use it add extra comments to class
     * string (require_once...)
     * @access public
     * @return string added to class eg. functions.
     */
    function classDocBlock($original)
    {
        return '';
    }
    /**
     * hook for var lines
     * called each time a var line is generated, override to add extra var
     * lines
     *
     * @param object t containing type,len,flags etc. from tableInfo call
     * @param int padding number of spaces
     * @access   public
     * @return  string added to class eg. functions.
     */
    function varDef($column, $padding)
    {
        return '';
    }
       /**
     * hook for after var lines (
     * called at the end of the output of var line have generated, override to add extra var
     * lines
     *
     * @param array cols containing array of objects with type,len,flags etc. from tableInfo call
     * @access   public
     * @return  string added to class eg. functions.
     */
 
    function postVar($columns_array)
    {
        return '';
    }
     /**
     * hook to add extra page-level (in terms of phpDocumentor) DocBlock
     *
     * called once for each class, use it add extra page-level docs
     * @access public
     * @return string added to class eg. functions.
     */
    function pageLevelDocBlock($original)
    {
        return '';
    }
      /**
     * hook to add extra doc block (in terms of phpDocumentor) to extend string
     *
     * called once for each class, use it add extra comments to extends
     * string (require_once...)
     * @access public
     * @return string added to class eg. functions.
     */
    function extendsDocBlock($original)
    {
        return '';   
    }
    
    
}
