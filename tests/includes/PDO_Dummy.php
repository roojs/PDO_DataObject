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
        
        // for connect to work - we have to have something in dummystatement
        require_once __DIR__ .'/PDO_DummyStatement.php';
        if (!isset(PDO_DummyStatement::$results[$dsn])) {
            throw new Exception("Fake connection failed to non-existant database");
        }
     
    }
    
    function getAttribute($key)
    {
        
        switch($key) {
            case PDO::ATTR_DRIVER_NAME:
                // it does this alot!!!?
                //echo __FUNCTION__ . '==' .  json_encode(func_get_args()) . " => " . $this->_dbtype  . "\n";
                return $this->_dbtype;
                break;
            default:
                echo __FUNCTION__ . '==' .  json_encode(func_get_args()). "\n";
                throw new Exception("getAttribute - invalid argument");
        }
        return "???";
    }
    
    function setAttribute($key, $value)
    {
        echo __FUNCTION__ . '==' .  json_encode(func_get_args()). "\n";
        switch($key) {
            
            case PDO::ATTR_ERRMODE:
                return; // all ok..
                break;
            default:
                throw new Exception("setAttribute - invalid arguments");
        }
    }
    
    function query($str)
    {
        require_once __DIR__ .'/PDO_DummyStatement.php';
        // hopefully database is set!!!
        $q = md5($str);
        if (!in_array($q, PDO_DummyStatement::$hide_queries)) {
            $q .= ":\n" . $str;
        } else {
            $q .= ": [Query hidden from tests]";
        }
        echo "QUERY:". $q ."\n";
        
        
        
        $this->last_statement = new PDO_DummyStatement($this->_dsn, $str);
        return $this->last_statement;
        
        
        
    }
    function quote($str)
    {
        // not  a very good test...
        return "'" . str_replace("'", "\'", $str) . "'";
    }
    function lastInsertId($val= '')
    {
        echo "lastInsertId from sequence='{$val}'  is {$this->last_statement->result}\n";
        return $this->last_statement->result;
        
    }
    function beginTransaction()
    {
        echo __METHOD__ ."\n"
    }
    function commit()
    {
        echo __METHOD__ ."\n"
    }
    function rollback()
    {
        echo __METHOD__ ."\n"
    }
}
