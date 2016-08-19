<?php
/**
 * replacement of old Hook methods
 * -- just implement this and set
 * generator_hook = {classname}|{object}
 *
 */

class PDO_DataObject_Generator_Hooks {
   
   
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
    function varDef($original)
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
 
    function postVar($original)
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
    function ExtendsLevelDocBlock($original)
    {
        return '';   
    }
    
    
}
