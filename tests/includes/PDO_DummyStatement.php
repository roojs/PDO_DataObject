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
                
            'DESCRIBE Companies' => '[
                    {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"}
                    {"Field":"code","Type":"varchar(32)","Null":"NO","Key":"","Default":"","Extra":""}
                    {"Field":"name","Type":"varchar(128)","Null":"YES","Key":"MUL","Default":null,"Extra":""}
                    {"Field":"remarks","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""}
                    {"Field":"owner_id","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
                    {"Field":"address","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""}
                    {"Field":"tel","Type":"varchar(32)","Null":"YES","Key":"","Default":null,"Extra":""}
                    {"Field":"fax","Type":"varchar(32)","Null":"YES","Key":"","Default":null,"Extra":""}
                    {"Field":"email","Type":"varchar(128)","Null":"YES","Key":"","Default":null,"Extra":""}
                    {"Field":"isOwner","Type":"int(11)","Null":"YES","Key":"","Default":null,"Extra":""}
                    {"Field":"logo_id","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
                    {"Field":"background_color","Type":"varchar(8)","Null":"NO","Key":"","Default":null,"Extra":""}
                    {"Field":"comptype","Type":"varchar(32)","Null":"YES","Key":"","Default":"","Extra":""}
                    {"Field":"url","Type":"varchar(254)","Null":"NO","Key":"","Default":"","Extra":""}
                    {"Field":"main_office_id","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
                    {"Field":"created_by","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
                    {"Field":"created_dt","Type":"datetime","Null":"NO","Key":"","Default":null,"Extra":""}
                    {"Field":"updated_by","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
                    {"Field":"updated_dt","Type":"datetime","Null":"NO","Key":"","Default":null,"Extra":""}
                    {"Field":"passwd","Type":"varchar(64)","Null":"NO","Key":"","Default":"","Extra":""}
                    {"Field":"dispatch_port","Type":"varchar(255)","Null":"NO","Key":"","Default":"","Extra":""}
                    {"Field":"province","Type":"varchar(255)","Null":"NO","Key":"","Default":"","Extra":""}
                    {"Field":"country","Type":"varchar(4)","Null":"NO","Key":"","Default":"","Extra":""}
                    ]',
            
            'DESCRIBE Events' => '[
                    {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"}
                    {"Field":"person_name","Type":"varchar(128)","Null":"YES","Key":"","Default":null,"Extra":""}
                    {"Field":"event_when","Type":"datetime","Null":"YES","Key":"MUL","Default":null,"Extra":""}
                    {"Field":"action","Type":"varchar(32)","Null":"YES","Key":"MUL","Default":null,"Extra":""}
                    {"Field":"ipaddr","Type":"varchar(16)","Null":"YES","Key":"","Default":null,"Extra":""}
                    {"Field":"on_id","Type":"int(11)","Null":"YES","Key":"MUL","Default":null,"Extra":""}
                    {"Field":"on_table","Type":"varchar(64)","Null":"YES","Key":"MUL","Default":null,"Extra":""}
                    {"Field":"person_id","Type":"int(11)","Null":"YES","Key":"","Default":null,"Extra":""}
                    {"Field":"person_table","Type":"varchar(64)","Null":"YES","Key":"MUL","Default":null,"Extra":""}
                    {"Field":"remarks","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""}
                    ]',
            'DESCRIBE Groups' => '[
                {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"}
                {"Field":"name","Type":"varchar(64)","Null":"NO","Key":"","Default":"","Extra":""}
                {"Field":"type","Type":"int(11)","Null":"YES","Key":"","Default":"0","Extra":""}
                {"Field":"leader","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
            ]',
        ),
        // another DB...
    );
    var $result = false;
    var $row = 0;
    
    function __construct($db, $query)
    {
        if (!isset(self::$results[$db][$query])) {
            throw new Exception(__CLASS__  . " missing query: DB: $db  QUERY=$query ");
        }
        $this->result = self::$results[$db][$query];
        
    }
    
    
    function fetch()
    
    
}