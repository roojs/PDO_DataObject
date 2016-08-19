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
          
     
        if (!strlen(trim($t->name))) {
            return '';
        }
        if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $this->name)) {
            echo "*****************************************************************\n".
                 "**               WARNING COLUMN NAME UNUSABLE                  **\n".
                 "** Found column '{$t->name}', of type  '{$t->type}'            **\n".
                 "** Since this column name can't be converted to a php variable **\n".
                 "** name, and the whole idea of mapping would result in a mess  **\n".
                 "** This column has been ignored...                             **\n".
                 "*****************************************************************\n";
            return;
        }
        
        $pad = str_repeat(' ',max(2,  (30 - strlen($t->name))));

        $length = empty($t->len) ? '' : '('.$t->len.')';
        $flags = strlen($t->flags) ? (' '. trim($t->flags)) : '';
        $body .="    {$var} \${$t->name}; {$pad}// {$t->type}{$length}{$flags}\n";
        
        // can not do set as PEAR::DB table info doesnt support it.
        //if (substr($t->Type,0,3) == "set")
        //    $sets[$t->Field] = "array".substr($t->Type,3);
        $body .= $this->hook->varDef($t,strlen($p));
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
