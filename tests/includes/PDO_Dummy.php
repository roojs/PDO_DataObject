<?php

/**
 * As testing is really difficult when using real databases, we can use these classes to emulate
 * Database interactions.
 *
 * Most of the time it will echo out the called values...
 *
 */

 
class PDO_Dummy {
    
    function __construct($dsn,$user,$pass, $options)
    {
        echo __FUNCTION__ . '==' . json_encode(func_get_args()). "\n";
        $this->_dsn = $dsn;
        $ar = explode(':', $dsn);
        $this->_dbtype = array_shift($ar);
        
        $this->user = $user;
        $this->pass = $pass;
        $this->options = $options;
    }
    
    function getAttribute($key)
    {
        echo __FUNCTION__ . '==' .  json_encode(func_get_args()). "\n";
        switch($key) {
            case PDO::ATTR_DRIVER_NAME:
                return $this->_dbtype;
                break;
            default:
                throw new Exception("getAttribute - invalid argument");
        }
        return "???";
    }
    
}
