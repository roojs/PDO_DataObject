<?php


class PDO_DummyStatement {
    
    static $results = array(
        
        // database
        'somedb' => array(
            
            'SHOW TABLES' =>  '[
                    {"Tables_in_somedb":"Companies"}
                    {"Tables_in_somedb":"Events"}
                    {"Tables_in_somedb":"Groups"}
                ]',
            
                
            ),
 
    );
    
    function __construct($array)
    {
        $this->result = $array;
        
    }
    
}