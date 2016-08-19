<?php
/**
 *
 *
 */

class PDO_DataObject_Generator_Column {
   
   var $table; //
   var $gen; //
   var $name = '';
   var $type = '';
   var $len = 0;
   var $flats = '';
   var $do_type = 0; // eg . PDO_DataObject::INT
   var $foreign_key = ''; /// XXX:YYY  XXX=table, YYY=column that it points to.
   
   
    function __construct($table,$def_ar)
    {
        $this->table = $table;
        $this->gen = $table->gen;
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
    /**
    * Generate getter methods for class definition
    *
    * @param    string  $input  Existing class contents
    * @return   string
    * @access   public
    */
    function toPhpGetter($user_code)
    {
        $options = $this->gen->config();
        
        // only generate if option is set to true
        if  ($options['getters']) {
            return '';
        }
        $getters = '';

        
        $getters .= "\n\n";
        
            // build mehtod name
        $methodName = 'get' . $this->table->getMethodNameFromColumnName($this->name);

        if (!strlen(trim($this->name)) || preg_match("/function[\s]+[&]?$methodName\(/i", $user_code)) {
            return '';
        }

        $getters .= "   /**\n";
        $getters .= "    * Getter for \${$this->name}\n";
        $getters .= "    *\n";
        // this makes no sense - mysql multiple key (MUL) - is just for indexed columns?
       // $getters .= (stristr($t->flags, 'multiple_key')) ? "    * @return   object\n"
       //                                                  : "    * @return   {$t->type}\n";
        $getters .= "    * @return   {$this->type}\n";
        $getters .= "    * @access   public\n";
        $getters .= "    */\n";
        // why add public it's pointless...
        //$getters .= (substr(phpversion(),0,1) > 4) ? '    public '
                                                   
        $getters .= "    function $methodName() {\n";
        $getters .= "        return \$this->{$this->name};\n";
        $getters .= "    }\n\n";
        
        return $getters;
    }
    
     /**
    * Generate setter methods for class definition
    *
    * @param    string  Existing class contents
    * @return   string
    * @access   public
    */
    function toPhpSetter($user_code) 
    {

        $options = $this->gen->config();
        
        // only generate if option is set to true
        if  ($options['setters']) {
            return '';
        }
        $setters = '';

         
       

            // build mehtod name
        $methodName = 'set' . $this->table->getMethodNameFromColumnName($this->name);

        if (!strlen(trim($this->name)) || preg_match("/function[\s]+[&]?$methodName\(/i", $user_code)) {
            return '';
        }

        $setters .= "   /**\n";
        $setters .= "    * Setter for \${$this->name}\n";
        $setters .= "    *\n";
        $setters .= "    * @param    mixed   input value\n";
        $setters .= "    * @access   public\n";
        $setters .= "    */\n";
        //$setters .= (substr(phpversion(),0,1) > 4) ? '    public '
        //                                           : '    ';
        $setters .= "   function $methodName(\$value) {\n";
        $setters .= "        \$this->{$t->name} = \$value;\n";
        $setters .= "    }\n\n";
    

        return $setters;
    }
        
    /**
    * Generate link setter/getter methods for class definition
    *
    * @param    string  Existing class contents
    * @return   string
    * @access   public
    */
    function toPhpLinkMethod($user_code) 
    {

        $options = $this->gen->config();
        
        $setters = '';

        // only generate if option is set to true
        
        // generate_link_methods true::
        
        
        if  (empty($options['link_methods'])) {
            //echo "skip lm? - not set";
            return '';
        }
        
        if (empty($this->foreign_key)) {
            // echo "skip lm? - fkyes empty";
            return '';
        }
            
        
        $setters .= "\n";
        // build mehtod name
        
        $methodName =  is_callable($options['link_methods']) ?
                    call_user_func($options['link_methods'], $this->name) : $this->name;

            if (!strlen(trim($k)) || preg_match("/function[\s]+[&]?$methodName\(/i", $user_code)) {
                continue;
            }

            $setters .= "   /**\n";
            $setters .= "    * Getter / Setter for \${$this->name}\n";
            $setters .= "    *\n";
            $setters .= "    * @param    mixed   (optional) value to assign\n";
            $setters .= "    * @access   public\n";
            
            $setters .= "    */\n";
            $setters .= (substr(phpversion(),0,1) > 4) ? '    public '
                                                       : '    ';
            $setters .= "function $methodName() {\n";
            $setters .= "        return \$this->link('$this->name', func_get_args());\n";
            $setters .= "    }\n\n";
        }
         
        return $setters;
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
