<?php


class PDO_DummyStatement {
    
    static $results = array(
        // 01 quote ident tests
        'mysql:dbname=somedb;host=localhost' => array(), 
        'sybase:dbname=somedb;host=localhost' => array(),
        'pgsql:dbname=somedb;host=localhost' => array(),
        'oci:dbname=mydb' => array(),
        'oci:dbname=//localhost:1521/mydb' => array(),
        'oci:dbname=192.168.10.145/orcl;charset=CL8MSWIN1251' => array(),
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
            // describe companies... 
            '6996acc544ef440ec8756b9a474a8261' => '[ 
                    {"tablename":"Companies","name":"id","default_value_raw":null,"type":"int","len":"10","flags":"auto_increment not_null primary","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"code","default_value_raw":"","type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"name","default_value_raw":null,"type":"varchar","len":null,"flags":" not_null multiple_key","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"remarks","default_value_raw":null,"type":"text","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"owner_id","default_value_raw":"0","type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"address","default_value_raw":null,"type":"text","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"tel","default_value_raw":null,"type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"fax","default_value_raw":null,"type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"email","default_value_raw":null,"type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"isOwner","default_value_raw":null,"type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"logo_id","default_value_raw":"0","type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"background_color","default_value_raw":null,"type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"comptype","default_value_raw":"","type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"url","default_value_raw":"","type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"main_office_id","default_value_raw":"0","type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"created_by","default_value_raw":"0","type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"created_dt","default_value_raw":null,"type":"datetime","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"updated_by","default_value_raw":"0","type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"updated_dt","default_value_raw":null,"type":"datetime","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"passwd","default_value_raw":"","type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"dispatch_port","default_value_raw":"","type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"province","default_value_raw":"","type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Companies","name":"country","default_value_raw":"","type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""}
                ]',
            // describe events... 
            'fbfdf155a2b80c37a9da0b57c7ec0c8a' => '[
                    {"tablename":"Events","name":"id","default_value_raw":null,"type":"int","len":"10","flags":"auto_increment not_null primary","fk_table":"","fk_column":""},
                    {"tablename":"Events","name":"person_name","default_value_raw":null,"type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Events","name":"event_when","default_value_raw":null,"type":"datetime","len":null,"flags":" not_null multiple_key","fk_table":"","fk_column":""},
                    {"tablename":"Events","name":"action","default_value_raw":null,"type":"varchar","len":null,"flags":" not_null multiple_key","fk_table":"","fk_column":""},
                    {"tablename":"Events","name":"ipaddr","default_value_raw":null,"type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Events","name":"on_id","default_value_raw":null,"type":"int","len":"10","flags":" not_null multiple_key","fk_table":"","fk_column":""},
                    {"tablename":"Events","name":"on_table","default_value_raw":null,"type":"varchar","len":null,"flags":" not_null multiple_key","fk_table":"","fk_column":""},
                    {"tablename":"Events","name":"person_id","default_value_raw":null,"type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Events","name":"person_table","default_value_raw":null,"type":"varchar","len":null,"flags":" not_null multiple_key","fk_table":"","fk_column":""},
                    {"tablename":"Events","name":"remarks","default_value_raw":null,"type":"text","len":null,"flags":" not_null","fk_table":"","fk_column":""}
                ]',
            'f77e1669034239c845220bf51ee0a9f2' => '[
                    {"tablename":"Groups","name":"id","default_value_raw":null,"type":"int","len":"10","flags":"auto_increment not_null primary","fk_table":"","fk_column":""},
                    {"tablename":"Groups","name":"name","default_value_raw":"","type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Groups","name":"type","default_value_raw":"0","type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Groups","name":"leader","default_value_raw":"0","type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""}
                ]',
        ),
        'pgsql:dbname=xtuple;host=localhost' => array(
            "SELECT table_name FROM information_schema.tables WHERE table_type = 'BASE TABLE' AND table_schema = 'public' order by table_name ASC" => '[
                {"table_name":"acalitem"},
                {"table_name":"accnt"},
                {"table_name":"addr"}
            ]',
            // table def for acalitem
            'eb30dc0b1b7c48a6974d9399257e82ff' => '[ 
               {"tablename":"acalitem","name":"acalitem_id","default_value_raw":"nextval((\'\\"xcalitem_xcalitem_id_seq\\"\'::text)::regclass)","type":"integer","len":"32","flags":" not_null primary","fk_table":null,"fk_column":null},
               {"tablename":"acalitem","name":"acalitem_calhead_id","default_value_raw":null,"type":"integer","len":"32","flags":"","fk_table":null,"fk_column":null},
               {"tablename":"acalitem","name":"acalitem_periodstart","default_value_raw":null,"type":"date","len":null,"flags":"","fk_table":null,"fk_column":null},
               {"tablename":"acalitem","name":"acalitem_periodlength","default_value_raw":null,"type":"integer","len":"32","flags":"","fk_table":null,"fk_column":null},
               {"tablename":"acalitem","name":"acalitem_name","default_value_raw":null,"type":"text","len":null,"flags":"","fk_table":null,"fk_column":null}
            ]',
            // def for accnt
            'f08fe09be9698b4d9a44cf6e90250153' => '[
                        {"tablename":"accnt","name":"accnt_id","default_value_raw":"nextval((\'accnt_accnt_id_seq\'::text)::regclass)","type":"integer","len":"32","flags":" not_null primary","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_number","default_value_raw":null,"type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_descrip","default_value_raw":null,"type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_comments","default_value_raw":null,"type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_profit","default_value_raw":null,"type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_sub","default_value_raw":null,"type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_type","default_value_raw":null,"type":"character","len":"1","flags":" not_null","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_extref","default_value_raw":null,"type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_company","default_value_raw":null,"type":"text","len":null,"flags":"","fk_table":"company","fk_column":"company_number"},
                       {"tablename":"accnt","name":"accnt_closedpost","default_value_raw":null,"type":"boolean","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_forwardupdate","default_value_raw":null,"type":"boolean","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_subaccnttype_code","default_value_raw":null,"type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_curr_id","default_value_raw":"basecurrid()","type":"integer","len":"32","flags":"","fk_table":"curr_symbol","fk_column":"curr_id"},
                       {"tablename":"accnt","name":"accnt_active","default_value_raw":"true","type":"boolean","len":null,"flags":" not_null","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_name","default_value_raw":null,"type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_code_alt","default_value_raw":"\'\'::text","type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                       {"tablename":"accnt","name":"accnt_descrip_alt","default_value_raw":"\'\'::text","type":"text","len":null,"flags":"","fk_table":null,"fk_column":null}
                    ]',
            // for addr
            '4e13cce432f03f6cb6b4b66b56d60b43' => '[
                    {"tablename":"addr","name":"addr_id","default_value_raw":"nextval(\'addr_addr_id_seq\'::regclass)","type":"integer","len":"32","flags":" not_null primary","fk_table":null,"fk_column":null},
                   {"tablename":"addr","name":"addr_active","default_value_raw":"true","type":"boolean","len":null,"flags":"","fk_table":null,"fk_column":null},
                   {"tablename":"addr","name":"addr_line1","default_value_raw":"\'\'::text","type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                   {"tablename":"addr","name":"addr_line2","default_value_raw":"\'\'::text","type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                   {"tablename":"addr","name":"addr_line3","default_value_raw":"\'\'::text","type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                   {"tablename":"addr","name":"addr_city","default_value_raw":"\'\'::text","type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                   {"tablename":"addr","name":"addr_state","default_value_raw":"\'\'::text","type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                   {"tablename":"addr","name":"addr_postalcode","default_value_raw":"\'\'::text","type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                   {"tablename":"addr","name":"addr_country","default_value_raw":"\'\'::text","type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                   {"tablename":"addr","name":"addr_notes","default_value_raw":"\'\'::text","type":"text","len":null,"flags":"","fk_table":null,"fk_column":null},
                   {"tablename":"addr","name":"addr_number","default_value_raw":null,"type":"text","len":null,"flags":" not_null","fk_table":null,"fk_column":null}
                ]'
        ),
        
        // 03 - error tests..
          'mysql:dbname=somedb;host=localhost;port=3344' => array(
            
            // QUeries
            'SHOW TABLES' =>  '[
                   
                    {"Tables_in_somedb":"Groups"}
                ]',
             'f77e1669034239c845220bf51ee0a9f2' => '[
                  {"tablename":"Groups","name":"id","default_value_raw":null,"type":"int","len":"10","flags":"auto_increment not_null primary","fk_table":"","fk_column":""},
                    {"tablename":"Groups","name":"name","default_value_raw":"","type":"varchar","len":null,"flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Groups","name":"type","default_value_raw":"0","type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""},
                    {"tablename":"Groups","name":"leader","default_value_raw":"0","type":"int","len":"10","flags":" not_null","fk_table":"","fk_column":""}
            ]',
        ),
          
        'oci:dbname=somedb' => array(
            'SELECT table_name FROM user_tables' =>  '[
                   
                    {"table_name":"Groups"}
            ]',
            // select columname,data_type,data_lenght, nullable
            'd632f626d40c91f7f96d697e86122c38' => '[
                {"column_name":"id","data_type":"int","data_length":11,"nullable":"N"},
                {"column_name":"name","data_type":"varchar","data_length":64,"nullable":""},
                {"column_name":"type","data_type":"int","data_length":11,"nullable":""}
                
            ]'
            
            
        ),
        // 08-get tests..
        'mysql:dbname=gettest;host=localhost' => array(
            // select companies where id = 12;
              'dde36b8c2603ce0b7357c878a4c6ad50'     => '[
              {"code":"MASL","name":"Modern (INTL) Access & Scaffolding Ltd","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":null,"id":"12","isOwner":"0","logo_id":"0","background_color":"","comptype":"",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
                ]',
             '4f8bbbe831550e7ece687a7f98bbdb32' => '[]', // id = 13 .. no results..
             'ba1ed5f8fbeba84966d40094fc0771f4' => '[
              {"code":"MASL","name":"Modern (INTL) Access & Scaffolding Ltd","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"15","isOwner":"0","logo_id":"0","background_color":"","comptype":"",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
            ]',
            'b72a52d4f5f0ada645dcf4e594992766' => '[]', // id = 12 and isOwner = 1
            'e3d46f1f19d5a7eacbd4e5464358b26e' => '[]', // id = 12 and updated_by > 10
            // select a single row from events.. (bad pid test)
            '196f2986575f749efe84e6134d37fbf7' => '[
                {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD",
                "ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
            ]',
            // 18 - find test 3 rows where comptype = 'CONSULT'
            'ebba0af48c52cc567e77a69664b3addb' => '[
                  {"code":"vinski","name":"Vinski Web","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"15","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"},
                 {"code":"MASL","name":"Modern (INTL) Access & Scaffolding Ltd","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"16","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"},
                 {"code":"HKDNR","name":"HK Domain Registry","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"17","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
                
            ]',
            // limit 1...
            '2a1daa39fc1c411b62e53c52ff873eee' => '[
                  {"code":"vinski","name":"Vinski Web","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"15","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"},
            ]',
             // limit 1... (!=1)
            'd67f7387466fef0c36b56c91273fa513' => '[
                  {"code":"vinski","name":"Vinski Web","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"15","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"},
            ]',
            // fetchall - id only
            '23df5cd6e811c14da7711b51d7298521' => '[
                    {"id": 2}, {"id": 4}, {"id": 6}
            ]',
            // get lenghts..
            '33f59edd5519f8086b193b7f9132403d' => '[
                    {"alen": 29}, {"alen": 19}, {"alen": 17}
            ]',
            /// list of names.
            '9beebf44ab64393f0c2b80f9d7f1172b' => '[
                {"code":"vinski","name":"Vinski Web","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"15","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"},
                 {"code":"MASL","name":"Modern (INTL) Access & Scaffolding Ltd","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"16","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"},
                 {"code":"HKDNR","name":"HK Domain Registry","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"17","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
                
            ]',
            // id=>name
            'd4905245ba332d8a3f42024e1e09c124' => '[
                {"code":"vinski","name":"Vinski Web","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"15","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"},
                 {"code":"MASL","name":"Modern (INTL) Access & Scaffolding Ltd","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"16","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"},
                 {"code":"HKDNR","name":"HK Domain Registry","remarks":"","owner_id":"0","address":"",
                 "tel":"","fax":"","email":"test@example.com","id":"17","isOwner":"0","logo_id":"0","background_color":"","comptype":"CONSULTANT",
                 "url":"","main_office_id":"0","created_by":"0","created_dt":"0000-00-00 00:00:00",
                 "updated_by":"0","updated_dt":"0000-00-00 00:00:00"}
                
            ]'
        ),
        'mysql:dbname=inserttest;host=localhost' => array(  
            // insert....
            '628879af4d41c471483702443eb35560' => 34343,
            
            '5f82f3a2da7afaa78228444fbcba3e37' => 123123,
            // update testing..
            '2bdf264b81e628acfbf68368a1175be6' => '[
                {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
             ]',
             '0b5821c352497585812c2320e23bccbb' => 1, // update rows affected...
             '9da43100ad8e2d1eee0cfee396c16588' => 1, // update rows affected...
            'a6282b3421edef2d12c5aa79b5c3ea77' => 3, // update with where, rows affected...
            
            // delete tests..
            'e343124dcbff70aa23becf0195d27e35' => 1,
            'e0f63974357eab3b7b082f80cf5c26aa' => 10, // multiple delte..
            
            // count tests..
            'da10443bc8585f7dc122c0bb5c930945' => '[ { "DATAOBJECT_NUM": 574675 }]',
            // personname = alan..
            '47e8ef81ad766bcb6406bbafc65c9a68' => '[ { "DATAOBJECT_NUM": 4516 }]',
            // person_id < 20
             '6dae8ae5d6c695bb4e18534694646a97' => '[ { "DATAOBJECT_NUM": 547179 }]',
            // distinct person_name
            'b8e89f17120074c01b0f14f4c0d6af77' => '[ { "DATAOBJECT_NUM": 41 }]',
            // distinct + property
            '617692175d0901d4d050a9fb4ff199c2' => '[ { "DATAOBJECT_NUM": 19 }]',
            // distinct, where + property
            '3aea344ea577bc8c10cd183ac72dad94' => '[ { "DATAOBJECT_NUM": 16 }]',
            // distinct, where + property & WHERE_ONLY
            'b39eb0824e17aab3aef96a262d2a8b7a'=> '[ { "DATAOBJECT_NUM": 38 }]',
              // zero results.
            'fc6b5bd4000b9295f9d2efdf833d5335'=> '[ { "DATAOBJECT_NUM": 0 }]',
            
            'de2b1352684938007346c359b3406ea9' => false, // invalid SQL..
            // error testing - fetch, then count.
             '8954200ac8480d37239612ab7fe410a3' => '[
                {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
             ]',
             
            // load/save... 
            '19aad9f2fe3ce0023298ab83f7e75775'  => 1,
            '183b4035a4a59e23b849e6bdd8a53fdb' => '[
                {"id":"3523","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
             ]',
             '9da43100ad8e2d1eee0cfee396c16588' => 1, // update
             
             // 
             '30e4e6e9c534f092302558ec8faa1c11' =>'[
                {"id":"3601","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
             ]', 
             '35026f20209f1caa71d6443d725b9aa2' => 1,
             
             // select limit action=
             'abbcef562aa23b791bed62846d4ca33f' =>'[
                {"id":"3524","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
              ]',
              '0115ca6837334e416b34e84c0b4f31a7' => 1, // update
              
              '2bdf264b81e628acfbf68368a1175be6' => '[]', // no results..
              // to many reuslts...
              '65e45926e39a354d24d0cefa47038dd8' => '[
                {"id":"3524","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
                {"id":"3525","person_name":"Alan","event_when":"2009-04-16 14:05:32","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
              ]',
             '9d10a45b72cac1e6e75db3e71e077d7c' => '[
                {"id":"3526","person_name":"Alan","event_when":"2009-04-16 14:08:40","action":"RELOAD","ipaddr":"202.134.82.251","on_id":"0","on_table":"","person_id":"4","remarks":"0","person_table":null}
                
             ]',
             '86f9b0a9131676c87d66a0cb0264b879' => 1, // insert.
             
        ), 
         'pgsql:dbname=pginsert;host=localhost' => array(  
            // insert....
            
            'b641522a3fbae38828891f330aeb7313' => 43434,
        ), 
        
        
        
        // another DB...
    );
    var $result = false;
    var $row = 0;
    
  
    
    
    
    function __construct($db, $query)
    {
        
        if (isset(self::$results[$db][$query])) {
            $value = self::$results[$db][$query];
            
            
        }
        if (isset(self::$results[$db][md5($query)])) {
            $value = self::$results[$db][md5($query)];
            
        }
        if (!isset($value)) {
            throw new Exception(__CLASS__  . " missing query: DB: $db  QUERY=  " . md5($query) ."\n" . $query);
        }
        
        if ($value === false) {
            throw new PDOException("dummy sql error", 9999);
        }
        $this->result = json_decode($value,true);
        
        
        
    }
    
    function closeCursor()
    {
        echo "Close Cursor\n";
    }
    
    var $fetchMode = false;
    var $fetchModeObject;
    
    function setFetchMode($method, $obj)
    {
        $this->fetchMode = $method;
        $this->fetchModeObject = $obj;
    }
    
    
    
    function fetch($method = false)
    {
        $method = $method === false ? $this->fetchMode : $method;
        
        echo "Fetch Row {$this->row} / " . count($this->result) . "\n";
        
        $row = $this->row  >= count($this->result) ? false : (array)$this->result[$this->row++];
        if ($row === false) {
            return $row;
        }
        if ($method & PDO::FETCH_INTO) {
            foreach($row as $k=>$v) {
                $this->fetchModeObject->$k = $v;
            }
            return $row;
        }
        if ($method & PDO::FETCH_ASSOC) {
            return $row;
        }
        throw new Exception("invalid argument for Fetch in dummy PDOStatement");
        
        
    }
    
    function fetchAll($method, $col=0)
    {
        $ret = array();
        switch($method) {
            case PDO::FETCH_ASSOC:
                return $this->result;
                
            case PDO::FETCH_COLUMN:
                $cols = array_keys($this->result[0]);
                
                $ret = array();
                for ($i =0; $i <  count($this->result) ; $i++) {
                    $ret[] = $this->result[$i][$cols[$col]];
                }
                return $ret;
            
            default:
                throw new Exception("invalid argument for FetchAll in dummy PDOStatement");
        }
    }
    
      
    function rowCount()
    {
        return is_int($this->result) ? $this->result : count( $this->result);
    }
    function columnCount()
    {
        
        return count(array_keys((array)$this->result[0]));
    }
    function getColumnMeta($i)
    {
        // limited support for this..
        
        return array(
            'name' => array_keys($this->result[0])[$i],
            'pdo_type' => 2, // default string...
        );
        
    }
    
}