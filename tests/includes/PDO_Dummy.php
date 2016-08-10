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
        
        switch($key) {
            case PDO::ATTR_DRIVER_NAME:
                echo __FUNCTION__ . '==' .  json_encode(func_get_args()) . " => " . $this->_dbtype  . "\n";
                return $this->_dbtype;
                break;
            default:
                echo __FUNCTION__ . '==' .  json_encode(func_get_args()). "\n";
                throw new Exception("getAttribute - invalid argument");
        }
        return "???";
    }
    function query($str)
    {
        
        
        echo "QUERY: $str  \n";
        
        require_once __DIR__ .'/PDO_DummyStatement.php';
        
        return new PDO_DummyStatement($this->database, $str);
        
        
        
    }
    
}
