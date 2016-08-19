<?php
/**
 *
 *
 */

class PDO_DataObject_Generator_Column {
   
   var $table; // generator.
   var $name = '';
   var $type = '';
   var $do_type = 0; // eg . PDO_DataObject::INT
   
    function __construct($table,$def_ar)
    {
        $this->table = $table;
        $this->name = $def_ar['name'];
        // and set other stuff?
        // put all the type parsing here!?
    }
    
     
    function toPhpVar($original)
    {
        
    }
    function toPhpGetter($original)
    {
        
    }
    function toPhpSetter($original)
    {
        
    }
    
    
    function toIni()
    {
        
    }
    function toIniSequence()
    {
        
    }
    
    
    function toLinks()
    {
        
    }
    
    
}
