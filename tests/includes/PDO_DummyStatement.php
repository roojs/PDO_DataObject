<?php


class PDO_DummyStatement {
    
    static $results = array(
        // 01 quote ident tests
        'mysql:dbname=somedb;host=localhost' => array(), 
        'sybase:dbname=somedb;host=localhost' => array(),
        'pgsql:dbname=somedb;host=localhost' => array(),
        'oci:dbname=mydb' => array(),
        'oci:dbname=//localhost:1521/mydb' => array(),
        'oci:dbname=192.168.10.145/orcl;charset=CL8MSWIN1251'
        //02 dsn tests
        'pgsql:dbname=example;host=localhost;port=3434' => array(),
        'pgsql:dbname=example;host=localhost;port=3434;user=nobody;password=change_me' => array(),
        'sqlsrv:Database=somedb;Server=localhost' => array(),
        'sqlsrv:Database=somedb;Server=12345abcde.database.windows.net' => array(),
        'sqlsrv:Database=somedb;Server=(localdb)\v11.0;AttachDBFilename=C:\Users\user\my_db.mdf' => array(),
        'sqlite:/opt/databases/mydb.sq3'=> array(),
        'sqlite::memory:'=> array(),
        'sqlite2:/opt/databases/mydb.sq2'=> array(),
        'sqlite2::memory:'=> array(),

        // 03 - databaseStructure tests.
        'mysql:dbname=anotherdb;host=localhost;port=3344' => array(
            
            // QUeries
            'SHOW TABLES' =>  '[
                    {"Tables_in_somedb":"Companies"},
                    {"Tables_in_somedb":"Events"},
                    {"Tables_in_somedb":"Groups"}
                ]',
                
            'DESCRIBE Companies' => '[
                    {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},
                    {"Field":"code","Type":"varchar(32)","Null":"NO","Key":"","Default":"","Extra":""},
                    {"Field":"name","Type":"varchar(128)","Null":"YES","Key":"MUL","Default":null,"Extra":""},
                    {"Field":"remarks","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""},
                    {"Field":"owner_id","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""},
                    {"Field":"address","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""},
                    {"Field":"tel","Type":"varchar(32)","Null":"YES","Key":"","Default":null,"Extra":""},
                    {"Field":"fax","Type":"varchar(32)","Null":"YES","Key":"","Default":null,"Extra":""},
                    {"Field":"email","Type":"varchar(128)","Null":"YES","Key":"","Default":null,"Extra":""},
                    {"Field":"isOwner","Type":"int(11)","Null":"YES","Key":"","Default":null,"Extra":""},
                    {"Field":"logo_id","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""},
                    {"Field":"background_color","Type":"varchar(8)","Null":"NO","Key":"","Default":null,"Extra":""},
                    {"Field":"comptype","Type":"varchar(32)","Null":"YES","Key":"","Default":"","Extra":""},
                    {"Field":"url","Type":"varchar(254)","Null":"NO","Key":"","Default":"","Extra":""},
                    {"Field":"main_office_id","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""},
                    {"Field":"created_by","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""},
                    {"Field":"created_dt","Type":"datetime","Null":"NO","Key":"","Default":null,"Extra":""},
                    {"Field":"updated_by","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""},
                    {"Field":"updated_dt","Type":"datetime","Null":"NO","Key":"","Default":null,"Extra":""},
                    {"Field":"passwd","Type":"varchar(64)","Null":"NO","Key":"","Default":"","Extra":""},
                    {"Field":"dispatch_port","Type":"varchar(255)","Null":"NO","Key":"","Default":"","Extra":""},
                    {"Field":"province","Type":"varchar(255)","Null":"NO","Key":"","Default":"","Extra":""},
                    {"Field":"country","Type":"varchar(4)","Null":"NO","Key":"","Default":"","Extra":""}
                    ]',
            
            'DESCRIBE Events' => '[
                    {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},
                    {"Field":"person_name","Type":"varchar(128)","Null":"YES","Key":"","Default":null,"Extra":""},
                    {"Field":"event_when","Type":"datetime","Null":"YES","Key":"MUL","Default":null,"Extra":""},
                    {"Field":"action","Type":"varchar(32)","Null":"YES","Key":"MUL","Default":null,"Extra":""},
                    {"Field":"ipaddr","Type":"varchar(16)","Null":"YES","Key":"","Default":null,"Extra":""},
                    {"Field":"on_id","Type":"int(11)","Null":"YES","Key":"MUL","Default":null,"Extra":""},
                    {"Field":"on_table","Type":"varchar(64)","Null":"YES","Key":"MUL","Default":null,"Extra":""},
                    {"Field":"person_id","Type":"int(11)","Null":"YES","Key":"","Default":null,"Extra":""},
                    {"Field":"person_table","Type":"varchar(64)","Null":"YES","Key":"MUL","Default":null,"Extra":""},
                    {"Field":"remarks","Type":"text","Null":"YES","Key":"","Default":null,"Extra":""}
                    ]',
            'DESCRIBE Groups' => '[
                {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},
                {"Field":"name","Type":"varchar(64)","Null":"NO","Key":"","Default":"","Extra":""},
                {"Field":"type","Type":"int(11)","Null":"YES","Key":"","Default":"0","Extra":""},
                {"Field":"leader","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
            ]',
        ),
        'pgsql:dbname=xtuple;host=localhost' => array(
            "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'public' order by table_name ASC" => '[
                {"table_name":"acalitem"},
                {"table_name":"accnt"},
                {"table_name":"addr"}
            ]',
            // table def for acalitem
            '08e4aa9f52824fa6d6c01dfea04d5efd' => '[
            
                {"number":1,"name":"acalitem_id","attnum":1,"notnull":true,"type":"integer","primarykey":"t","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"nextval((\'\"xcalitem_xcalitem_id_seq\"\'::text)::regclass)"},
                {"number":2,"name":"acalitem_calhead_id","attnum":2,"notnull":false,"type":"integer","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":3,"name":"acalitem_periodstart","attnum":3,"notnull":false,"type":"date","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":4,"name":"acalitem_periodlength","attnum":4,"notnull":false,"type":"integer","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":5,"name":"acalitem_name","attnum":5,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
            ]',
            // def for accnt
            '910efae3bc8352cab9a73df70006a9bc' => '[
                {"number":1,"name":"accnt_id","attnum":1,"notnull":true,"type":"integer","primarykey":"t","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"nextval((\'accnt_accnt_id_seq\'::text)::regclass)"},
                {"number":2,"name":"accnt_number","attnum":2,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":3,"name":"accnt_descrip","attnum":3,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":4,"name":"accnt_comments","attnum":4,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":5,"name":"accnt_profit","attnum":5,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":6,"name":"accnt_sub","attnum":6,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":7,"name":"accnt_type","attnum":7,"notnull":true,"type":"character(1)","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":8,"name":"accnt_extref","attnum":8,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":9,"name":"accnt_company","attnum":9,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":"company","foreignkey_fieldnum":"{2}","foreignkey_connnum":"{9}","default":null},
                {"number":10,"name":"accnt_closedpost","attnum":10,"notnull":false,"type":"boolean","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":11,"name":"accnt_forwardupdate","attnum":11,"notnull":false,"type":"boolean","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":12,"name":"accnt_subaccnttype_code","attnum":12,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":13,"name":"accnt_curr_id","attnum":13,"notnull":false,"type":"integer","primarykey":"f","uniquekey":"f","foreignkey":"curr_symbol","foreignkey_fieldnum":"{1}","foreignkey_connnum":"{13}","default":"basecurrid()"},
                {"number":14,"name":"accnt_active","attnum":14,"notnull":true,"type":"boolean","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"true"},
                {"number":15,"name":"accnt_name","attnum":15,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null},
                {"number":16,"name":"accnt_code_alt","attnum":16,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"\'\'::text"},
                {"number":17,"name":"accnt_descrip_alt","attnum":17,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"\'\'::text"}
            ]',
            // for addr
            '0464cd1439d5cf9ac030e8cbe858bbfd' => '[
                {"number":1,"name":"addr_id","attnum":1,"notnull":true,"type":"integer","primarykey":"t","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"nextval(\'addr_addr_id_seq\'::regclass)"},
                {"number":2,"name":"addr_active","attnum":2,"notnull":false,"type":"boolean","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"true"},
                {"number":3,"name":"addr_line1","attnum":3,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"\'\'::text"},
                {"number":4,"name":"addr_line2","attnum":4,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"\'\'::text"},
                {"number":5,"name":"addr_line3","attnum":5,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"\'\'::text"},
                {"number":6,"name":"addr_city","attnum":6,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"\'\'::text"},
                {"number":7,"name":"addr_state","attnum":7,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"\'\'::text"},
                {"number":8,"name":"addr_postalcode","attnum":8,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"\'\'::text"},
                {"number":9,"name":"addr_country","attnum":9,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"\'\'::text"},
                {"number":10,"name":"addr_notes","attnum":10,"notnull":false,"type":"text","primarykey":"f","uniquekey":"f","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":"\'\'::text"},
                {"number":11,"name":"addr_number","attnum":11,"notnull":true,"type":"text","primarykey":"f","uniquekey":"t","foreignkey":null,"foreignkey_fieldnum":null,"foreignkey_connnum":null,"default":null}
 
            ]'
        ),
          'mysql:dbname=somedb;host=localhost;port=3344' => array(
            
            // QUeries
            'SHOW TABLES' =>  '[
                   
                    {"Tables_in_somedb":"Groups"}
                ]',
             'DESCRIBE Groups' => '[
                {"Field":"id","Type":"int(11)","Null":"NO","Key":"PRI","Default":null,"Extra":"auto_increment"},
                {"Field":"name","Type":"varchar(64)","Null":"NO","Key":"","Default":"","Extra":""},
                {"Field":"type","Type":"int(11)","Null":"YES","Key":"","Default":"0","Extra":""},
                {"Field":"leader","Type":"int(11)","Null":"NO","Key":"","Default":"0","Extra":""}
            ]',
        ),
        
        // another DB...
    );
    var $result = false;
    var $row = 0;
    
  
    
    
    
    function __construct($db, $query)
    {
        if (isset(self::$results[$db][$query])) {
            $this->result = json_decode(self::$results[$db][$query]);
            return;
        }
        if (isset(self::$results[$db][md5($query)])) {
            $this->result = json_decode(self::$results[$db][md5($query)]);
            return;
        }
        throw new Exception(__CLASS__  . " missing query: DB: $db  QUERY=$query ");
        
        
        
    }
    
    function closeCursor()
    {
        echo "Close Cursor\n";
    }
    
    function fetch($method , &$obj=null)
    {
        echo "Fetch Row {$this->row} / " . count($this->result) . "\n";
        
        $row = $this->row  >= count($this->result) ? false : (array)$this->result[$this->row++];
        if ($row === false) {
            return $row;
        }
        if ($method & PDO::FETCH_INTO) {
            foreach($row as $k=>$v) {
                $obj->$k = $v;
            }
        }
        if ($method & PDO::FETCH_ASSOC) {
            return $row;
        }
        throw new Exception("invalid argument for Fetch in dummy PDOStatement");
        
        
    }
    
      
    function rowCount()
    {
        return count( $this->result);
    }
    function columnCount()
    {
        return count(array_keys((array)$this->result[0]));
    }
    function getColumnMeta()
    {
        return false; // pretend we do not support stuff.
    }
    
}