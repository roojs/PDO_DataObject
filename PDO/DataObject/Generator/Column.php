<?php
/**
 *
 *
 */

class PDO_DataObject_Generator_Column {
   
   var $table; // generator.
   var $name = '';
   var $type = '';
   var $len = 0;
   var $flats = '';
   var $do_type = 0; // eg . PDO_DataObject::INT
   
    function __construct($table,$def_ar)
    {
        $this->table = $table;
        $this->hook = $table->hook;
        $this->name = $def_ar['name'];
        // and set other stuff?
        // put all the type parsing here!?
    }
    
     
    function toPhpVar($var)
    {
          
     
        if (!strlen(trim($this->name))) {
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
        
        $pad = str_repeat(' ',max(2,  (30 - strlen($this->name))));

        $length = empty($this->len) ? '' : '('.$this->len.')';
        $flags = strlen($this->flags) ? (' '. trim($this->flags)) : '';
        $body .="    {$var} \${$this->name}; {$pad}// {$this->type}{$length}{$flags}\n";
        
        // can not do set as PEAR::DB table info doesnt support it.
        //if (substr($t->Type,0,3) == "set")
        //    $sets[$t->Field] = "array".substr($t->Type,3);
        $body .= $this->hook->varDef($t,strlen($p));
    }
    function toPhpGetter($original)
    {
          $options = &PEAR::getStaticProperty('DB_DataObject','options');
        $getters = '';

        // only generate if option is set to true
        if  (empty($options['generate_getters'])) {
            return '';
        }

        // remove auto-generated code from input to be able to check if the method exists outside of the auto-code
        $input = preg_replace('/(\n|\r\n)\s*###START_AUTOCODE(\n|\r\n).*(\n|\r\n)\s*###END_AUTOCODE(\n|\r\n)/s', '', $input);

        $getters .= "\n\n";
        $defs     = $this->_definitions[$this->table];

        // loop through properties and create getter methods
        foreach ($defs = $defs as $t) {

            // build mehtod name
            $methodName = 'get' . $this->getMethodNameFromColumnName($t->name);

            if (!strlen(trim($t->name)) || preg_match("/function[\s]+[&]?$methodName\(/i", $input)) {
                continue;
            }

            $getters .= "   /**\n";
            $getters .= "    * Getter for \${$t->name}\n";
            $getters .= "    *\n";
            // this makes no sense - mysql multiple key (MUL) - is just for indexed columns?
           // $getters .= (stristr($t->flags, 'multiple_key')) ? "    * @return   object\n"
           //                                                  : "    * @return   {$t->type}\n";
            $getters .= "    * @return   {$t->type}\n";
            $getters .= "    * @access   public\n";
            $getters .= "    */\n";
            $getters .= (substr(phpversion(),0,1) > 4) ? '    public '
                                                       : '    ';
            $getters .= "function $methodName() {\n";
            $getters .= "        return \$this->{$t->name};\n";
            $getters .= "    }\n\n";
        }
   

        return $getters;
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
