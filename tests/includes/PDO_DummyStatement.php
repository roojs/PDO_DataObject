<?php


class PDO_DummyStatement {
    
    static $results = array(
        
        'SHOW TABLES' => array (
   
            array('avalue' => 'account_code'),
            array('avalue' => 'account_month'),
            array('avalue' => 'account_transaction')
            
        ),
 
    );
    
    function __construct($array)
    {
        $this->result = $array;
        
    }
    
}