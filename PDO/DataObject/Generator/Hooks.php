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
    
     
    function functions($original)
    {
        return '';
    }
    function classDocBlock($original)
    {
        return '';
    }
    function preVar($original)
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
