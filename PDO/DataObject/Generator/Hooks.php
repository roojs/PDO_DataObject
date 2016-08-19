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
    function derivedHookFunctions($input = "")
    {
        // This is so derived generator classes can generate functions
        // It MUST NOT be changed here!!!
        return "";
    }

    function functions($original)
    {
        return '';
    }
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
    function var($original)
    {
        return '';
    }
    function postVar($original)
    {
        return '';
    }
    
    function pageLevelDocBlock($original)
    {
        return '';
    }
    
    function ExtendsLevelDocBlock($original)
    {
        return '';   
    }
    
    
}
