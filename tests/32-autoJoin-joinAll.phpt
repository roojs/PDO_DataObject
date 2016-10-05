--TEST--
autoJOin and joinAll Test 
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest',
        'class_prefix' => 'DataObjects_',
));

PDO_DataObject::debugLevel(0);
 
// these need the links to calculate the join..
 
$j = PDO_DataObject::factory('joinerb')
    ->joinAll()
    ->find(true);

var_export(     
    PDO_DataObject::factory('joinerb')
    ->autoJoin()
);
     



echo "\n\n--------\n";
echo "Exclude tests\n" ;
     
     
echo "\nexclude single resulting column and column that hides a link.\n";
$j = PDO_DataObject::factory('joinerb')
    ->joinAll([
        'exclude' => array('childa_id_ca_id', 'childc_id')
    ])
    ->find(true);

var_export(     
    PDO_DataObject::factory('joinerb')
    ->autoJoin([
        'exclude' => array('childa_id_ca_id', 'childc_id')
    ])
);    
    
    
    
echo "\nexclude joined table.., but keep the column.\n";
$j = PDO_DataObject::factory('joinerb')
    ->joinAll([
        'exclude' => array('childc_id.*')
    ])
    ->find(true);


var_export(     
    PDO_DataObject::factory('joinerb')
    ->autoJoin([
         'exclude' => array('childc_id.*')
    ])
);    
        
    
    
echo "\nexclude joined table using target* and 'joined as' name.., .\n";
$j = PDO_DataObject::factory('joinerc')
    ->joinAll([
        'exclude' => array('childa.*','join_childb_id_ca_id')
    ])
    ->find(true);
 
 
var_export(     
    PDO_DataObject::factory('joinerb')
    ->autoJoin([
          'exclude' => array('childa.*','join_childb_id_ca_id')
    ])
);    
   
echo "\n\n--------\n";
echo "Include tests\n" ;

echo "\n include only two columns...  .\n";
$j = PDO_DataObject::factory('joinerc')
    ->joinAll([
        'include' => array('childa_id','childa_id_name')
    ])
    ->find(true);
  
 
var_export(     
    PDO_DataObject::factory('joinerb')
    ->autoJoin([
          'include' => array('childa_id','childa_id_name')
    ])
);    
   
echo "\n\n--------\n";
echo "links tests\n" ;

echo "\n links add extra link...  .\n";
$j = PDO_DataObject::factory('joiner')
    ->joinAll([
        'links' => array('childb_id' => 'childb:cb_id')
    ])
    ->find(true);

var_export(     
    PDO_DataObject::factory('joinerb')
    ->autoJoin([
          'links' => array('childb_id' => 'childb:cb_id')
    ])
);    
   

echo "\n distinct column...  .\n";
$j = PDO_DataObject::factory('joiner')
    ->joinAll([
        'distinct' => 'childa_id'
    ])
    ->find(true);
    
 
var_export(     
    PDO_DataObject::factory('joinerb')
    ->autoJoin([
          'distinct' => 'childa_id'
    ])
);   
echo "\n distinct column...  .\n";
$j = PDO_DataObject::factory('joiner')
    ->joinAll([
        'distinct' => 'childa_id_name'
    ])
    ->find(true);
  
var_export(     
    PDO_DataObject::factory('joinerb')
    ->autoJoin([
          'distinct' => 'childa_id_name'
    ])
);   
 
 
 
?>
--EXPECT--
__construct==["mysql:dbname=inserttest;host=localhost","user","pass",[]]
setAttribute==[3,2]
QUERY:63b2e336f37283287a1211f183a9e1df:
SELECT joinerb.id as id
 ,  joinerb.childa_id as childa_id
 ,  joinerb.childb_id as childb_id
 ,  joinerb.childc_id as childc_id
 ,  join_childa_id_ca_id.ca_id as childa_id_ca_id
 ,  join_childa_id_ca_id.name as childa_id_name
 ,  join_childa_id_ca_id.ex_int as childa_id_ex_int
 ,  join_childa_id_ca_id.ex_string as childa_id_ex_string
 ,  join_childa_id_ca_id.ex_date as childa_id_ex_date
 ,  join_childa_id_ca_id.ex_datetime as childa_id_ex_datetime
 ,  join_childa_id_ca_id.ex_time as childa_id_ex_time
 ,  join_childc_id_ca_id.ca_id as childc_id_ca_id
 ,  join_childc_id_ca_id.name as childc_id_name
 ,  join_childc_id_ca_id.ex_int as childc_id_ex_int
 ,  join_childc_id_ca_id.ex_string as childc_id_ex_string
 ,  join_childc_id_ca_id.ex_date as childc_id_ex_date
 ,  join_childc_id_ca_id.ex_datetime as childc_id_ex_datetime
 ,  join_childc_id_ca_id.ex_time as childc_id_ex_time
 FROM   joinerb   

 LEFT JOIN childa AS join_childa_id_ca_id ON (join_childa_id_ca_id.ca_id=joinerb.childa_id)  
 LEFT JOIN childa AS join_childc_id_ca_id ON (join_childc_id_ca_id.ca_id=joinerb.childc_id) 

array (
  'cols' => 
  array (
    'id' => 'joinerb.id',
    'childa_id' => 'joinerb.childa_id',
    'childb_id' => 'joinerb.childb_id',
    'childc_id' => 'joinerb.childc_id',
    'childa_id_ca_id' => 'childa.ca_id',
    'childa_id_name' => 'childa.name',
    'childa_id_ex_int' => 'childa.ex_int',
    'childa_id_ex_string' => 'childa.ex_string',
    'childa_id_ex_date' => 'childa.ex_date',
    'childa_id_ex_datetime' => 'childa.ex_datetime',
    'childa_id_ex_time' => 'childa.ex_time',
    'childc_id_ca_id' => 'childa.ca_id',
    'childc_id_name' => 'childa.name',
    'childc_id_ex_int' => 'childa.ex_int',
    'childc_id_ex_string' => 'childa.ex_string',
    'childc_id_ex_date' => 'childa.ex_date',
    'childc_id_ex_datetime' => 'childa.ex_datetime',
    'childc_id_ex_time' => 'childa.ex_time',
  ),
  'join_names' => 
  array (
    'childa_id_ca_id' => 'join_childa_id_ca_id.ca_id',
    'childa_id_name' => 'join_childa_id_ca_id.name',
    'childa_id_ex_int' => 'join_childa_id_ca_id.ex_int',
    'childa_id_ex_string' => 'join_childa_id_ca_id.ex_string',
    'childa_id_ex_date' => 'join_childa_id_ca_id.ex_date',
    'childa_id_ex_datetime' => 'join_childa_id_ca_id.ex_datetime',
    'childa_id_ex_time' => 'join_childa_id_ca_id.ex_time',
    'childc_id_ca_id' => 'join_childc_id_ca_id.ca_id',
    'childc_id_name' => 'join_childc_id_ca_id.name',
    'childc_id_ex_int' => 'join_childc_id_ca_id.ex_int',
    'childc_id_ex_string' => 'join_childc_id_ca_id.ex_string',
    'childc_id_ex_date' => 'join_childc_id_ca_id.ex_date',
    'childc_id_ex_datetime' => 'join_childc_id_ca_id.ex_datetime',
    'childc_id_ex_time' => 'join_childc_id_ca_id.ex_time',
  ),
  'count' => false,
)

--------
Exclude tests

exclude single resulting column and column that hides a link.
QUERY:53ff1c2697a5129f4b05a7f2cf134fb9:
SELECT joinerb.id as id
 ,  joinerb.childa_id as childa_id
 ,  joinerb.childb_id as childb_id
 ,  join_childa_id_ca_id.name as childa_id_name
 ,  join_childa_id_ca_id.ex_int as childa_id_ex_int
 ,  join_childa_id_ca_id.ex_string as childa_id_ex_string
 ,  join_childa_id_ca_id.ex_date as childa_id_ex_date
 ,  join_childa_id_ca_id.ex_datetime as childa_id_ex_datetime
 ,  join_childa_id_ca_id.ex_time as childa_id_ex_time
 FROM   joinerb   

 LEFT JOIN childa AS join_childa_id_ca_id ON (join_childa_id_ca_id.ca_id=joinerb.childa_id)  
 LEFT JOIN childa AS join_childc_id_ca_id ON (join_childc_id_ca_id.ca_id=joinerb.childc_id) 

array (
  'cols' => 
  array (
    'id' => 'joinerb.id',
    'childa_id' => 'joinerb.childa_id',
    'childb_id' => 'joinerb.childb_id',
    'childa_id_name' => 'childa.name',
    'childa_id_ex_int' => 'childa.ex_int',
    'childa_id_ex_string' => 'childa.ex_string',
    'childa_id_ex_date' => 'childa.ex_date',
    'childa_id_ex_datetime' => 'childa.ex_datetime',
    'childa_id_ex_time' => 'childa.ex_time',
  ),
  'join_names' => 
  array (
    'childa_id_name' => 'join_childa_id_ca_id.name',
    'childa_id_ex_int' => 'join_childa_id_ca_id.ex_int',
    'childa_id_ex_string' => 'join_childa_id_ca_id.ex_string',
    'childa_id_ex_date' => 'join_childa_id_ca_id.ex_date',
    'childa_id_ex_datetime' => 'join_childa_id_ca_id.ex_datetime',
    'childa_id_ex_time' => 'join_childa_id_ca_id.ex_time',
  ),
  'count' => false,
)
exclude joined table.., but keep the column.
QUERY:6ca862a16d64367cc5608215a75be882:
SELECT joinerb.id as id
 ,  joinerb.childa_id as childa_id
 ,  joinerb.childb_id as childb_id
 ,  joinerb.childc_id as childc_id
 ,  join_childa_id_ca_id.ca_id as childa_id_ca_id
 ,  join_childa_id_ca_id.name as childa_id_name
 ,  join_childa_id_ca_id.ex_int as childa_id_ex_int
 ,  join_childa_id_ca_id.ex_string as childa_id_ex_string
 ,  join_childa_id_ca_id.ex_date as childa_id_ex_date
 ,  join_childa_id_ca_id.ex_datetime as childa_id_ex_datetime
 ,  join_childa_id_ca_id.ex_time as childa_id_ex_time
 FROM   joinerb   

 LEFT JOIN childa AS join_childa_id_ca_id ON (join_childa_id_ca_id.ca_id=joinerb.childa_id) 

array (
  'cols' => 
  array (
    'id' => 'joinerb.id',
    'childa_id' => 'joinerb.childa_id',
    'childb_id' => 'joinerb.childb_id',
    'childc_id' => 'joinerb.childc_id',
    'childa_id_ca_id' => 'childa.ca_id',
    'childa_id_name' => 'childa.name',
    'childa_id_ex_int' => 'childa.ex_int',
    'childa_id_ex_string' => 'childa.ex_string',
    'childa_id_ex_date' => 'childa.ex_date',
    'childa_id_ex_datetime' => 'childa.ex_datetime',
    'childa_id_ex_time' => 'childa.ex_time',
  ),
  'join_names' => 
  array (
    'childa_id_ca_id' => 'join_childa_id_ca_id.ca_id',
    'childa_id_name' => 'join_childa_id_ca_id.name',
    'childa_id_ex_int' => 'join_childa_id_ca_id.ex_int',
    'childa_id_ex_string' => 'join_childa_id_ca_id.ex_string',
    'childa_id_ex_date' => 'join_childa_id_ca_id.ex_date',
    'childa_id_ex_datetime' => 'join_childa_id_ca_id.ex_datetime',
    'childa_id_ex_time' => 'join_childa_id_ca_id.ex_time',
  ),
  'count' => false,
)
exclude joined table using target* and 'joined as' name.., .
QUERY:ce74af86aeeaf9fd9261e3bdf54a9e33:
SELECT joinerc.id as id
 ,  joinerc.childa_id as childa_id
 ,  joinerc.childb_id as childb_id
 ,  joinerc.childc_id as childc_id
 ,  joinerc.childd_id as childd_id
 ,  join_childd_id_ca_id.cb_id as childd_id_cb_id
 ,  join_childd_id_ca_id.name as childd_id_name
 ,  join_childd_id_ca_id.ex_int as childd_id_ex_int
 ,  join_childd_id_ca_id.ex_string as childd_id_ex_string
 ,  join_childd_id_ca_id.ex_date as childd_id_ex_date
 ,  join_childd_id_ca_id.ex_datetime as childd_id_ex_datetime
 ,  join_childd_id_ca_id.ex_time as childd_id_ex_time
 FROM   joinerc   

 LEFT JOIN childb AS join_childd_id_ca_id ON (join_childd_id_ca_id.ca_id=joinerc.childd_id) 

array (
  'cols' => 
  array (
    'id' => 'joinerb.id',
    'childa_id' => 'joinerb.childa_id',
    'childb_id' => 'joinerb.childb_id',
    'childc_id' => 'joinerb.childc_id',
  ),
  'join_names' => 
  array (
  ),
  'count' => false,
)

--------
Include tests

 include only two columns...  .
QUERY:f22c41fe7544ede8005d2d59ee926b49:
SELECT joinerc.childa_id as childa_id
 ,  join_childa_id_ca_id.name as childa_id_name
 FROM   joinerc   

 LEFT JOIN childa AS join_childa_id_ca_id ON (join_childa_id_ca_id.ca_id=joinerc.childa_id)  
 LEFT JOIN childb AS join_childb_id_ca_id ON (join_childb_id_ca_id.ca_id=joinerc.childb_id)  
 LEFT JOIN childb AS join_childd_id_ca_id ON (join_childd_id_ca_id.ca_id=joinerc.childd_id) 

array (
  'cols' => 
  array (
    'childa_id' => 'joinerb.childa_id',
    'childa_id_name' => 'childa.name',
  ),
  'join_names' => 
  array (
    'childa_id_name' => 'join_childa_id_ca_id.name',
  ),
  'count' => false,
)

--------
links tests

 links add extra link...  .
QUERY:09bd7e8892d64e8dfe9e6b4b620b5890:
SELECT joiner.id as id
 ,  joiner.childa_id as childa_id
 ,  joiner.childb_id as childb_id
 ,  join_childa_id_ca_id.ca_id as childa_id_ca_id
 ,  join_childa_id_ca_id.name as childa_id_name
 ,  join_childa_id_ca_id.ex_int as childa_id_ex_int
 ,  join_childa_id_ca_id.ex_string as childa_id_ex_string
 ,  join_childa_id_ca_id.ex_date as childa_id_ex_date
 ,  join_childa_id_ca_id.ex_datetime as childa_id_ex_datetime
 ,  join_childa_id_ca_id.ex_time as childa_id_ex_time
 ,  join_childb_id_cb_id.cb_id as childb_id_cb_id
 ,  join_childb_id_cb_id.name as childb_id_name
 ,  join_childb_id_cb_id.ex_int as childb_id_ex_int
 ,  join_childb_id_cb_id.ex_string as childb_id_ex_string
 ,  join_childb_id_cb_id.ex_date as childb_id_ex_date
 ,  join_childb_id_cb_id.ex_datetime as childb_id_ex_datetime
 ,  join_childb_id_cb_id.ex_time as childb_id_ex_time
 FROM   joiner   

 LEFT JOIN childa AS join_childa_id_ca_id ON (join_childa_id_ca_id.ca_id=joiner.childa_id)  
 LEFT JOIN childb AS join_childb_id_cb_id ON (join_childb_id_cb_id.childb_id=joiner.childb_id) 

array (
  'cols' => 
  array (
    'id' => 'joinerb.id',
    'childa_id' => 'joinerb.childa_id',
    'childb_id' => 'joinerb.childb_id',
    'childc_id' => 'joinerb.childc_id',
    'childa_id_ca_id' => 'childa.ca_id',
    'childa_id_name' => 'childa.name',
    'childa_id_ex_int' => 'childa.ex_int',
    'childa_id_ex_string' => 'childa.ex_string',
    'childa_id_ex_date' => 'childa.ex_date',
    'childa_id_ex_datetime' => 'childa.ex_datetime',
    'childa_id_ex_time' => 'childa.ex_time',
    'childc_id_ca_id' => 'childa.ca_id',
    'childc_id_name' => 'childa.name',
    'childc_id_ex_int' => 'childa.ex_int',
    'childc_id_ex_string' => 'childa.ex_string',
    'childc_id_ex_date' => 'childa.ex_date',
    'childc_id_ex_datetime' => 'childa.ex_datetime',
    'childc_id_ex_time' => 'childa.ex_time',
    'childb_id_cb_id' => 'childb.cb_id',
    'childb_id_name' => 'childb.name',
    'childb_id_ex_int' => 'childb.ex_int',
    'childb_id_ex_string' => 'childb.ex_string',
    'childb_id_ex_date' => 'childb.ex_date',
    'childb_id_ex_datetime' => 'childb.ex_datetime',
    'childb_id_ex_time' => 'childb.ex_time',
  ),
  'join_names' => 
  array (
    'childa_id_ca_id' => 'join_childa_id_ca_id.ca_id',
    'childa_id_name' => 'join_childa_id_ca_id.name',
    'childa_id_ex_int' => 'join_childa_id_ca_id.ex_int',
    'childa_id_ex_string' => 'join_childa_id_ca_id.ex_string',
    'childa_id_ex_date' => 'join_childa_id_ca_id.ex_date',
    'childa_id_ex_datetime' => 'join_childa_id_ca_id.ex_datetime',
    'childa_id_ex_time' => 'join_childa_id_ca_id.ex_time',
    'childc_id_ca_id' => 'join_childc_id_ca_id.ca_id',
    'childc_id_name' => 'join_childc_id_ca_id.name',
    'childc_id_ex_int' => 'join_childc_id_ca_id.ex_int',
    'childc_id_ex_string' => 'join_childc_id_ca_id.ex_string',
    'childc_id_ex_date' => 'join_childc_id_ca_id.ex_date',
    'childc_id_ex_datetime' => 'join_childc_id_ca_id.ex_datetime',
    'childc_id_ex_time' => 'join_childc_id_ca_id.ex_time',
    'childb_id_cb_id' => 'join_childb_id_cb_id.cb_id',
    'childb_id_name' => 'join_childb_id_cb_id.name',
    'childb_id_ex_int' => 'join_childb_id_cb_id.ex_int',
    'childb_id_ex_string' => 'join_childb_id_cb_id.ex_string',
    'childb_id_ex_date' => 'join_childb_id_cb_id.ex_date',
    'childb_id_ex_datetime' => 'join_childb_id_cb_id.ex_datetime',
    'childb_id_ex_time' => 'join_childb_id_cb_id.ex_time',
  ),
  'count' => false,
)
 distinct column...  .
QUERY:155a7e32d3188fa3b596136f3a738a6a:
SELECT DISTINCT( joiner.childa_id) as childa_id ,  joiner.childb_id as childb_id
 ,  join_childa_id_ca_id.ca_id as childa_id_ca_id
 ,  join_childa_id_ca_id.name as childa_id_name
 ,  join_childa_id_ca_id.ex_int as childa_id_ex_int
 ,  join_childa_id_ca_id.ex_string as childa_id_ex_string
 ,  join_childa_id_ca_id.ex_date as childa_id_ex_date
 ,  join_childa_id_ca_id.ex_datetime as childa_id_ex_datetime
 ,  join_childa_id_ca_id.ex_time as childa_id_ex_time
 FROM   joiner   

 LEFT JOIN childa AS join_childa_id_ca_id ON (join_childa_id_ca_id.ca_id=joiner.childa_id) 

array (
  'cols' => 
  array (
    'id' => 'joinerb.id',
    'childa_id' => 'joinerb.childa_id',
    'childb_id' => 'joinerb.childb_id',
    'childc_id' => 'joinerb.childc_id',
    'childa_id_ca_id' => 'childa.ca_id',
    'childa_id_name' => 'childa.name',
    'childa_id_ex_int' => 'childa.ex_int',
    'childa_id_ex_string' => 'childa.ex_string',
    'childa_id_ex_date' => 'childa.ex_date',
    'childa_id_ex_datetime' => 'childa.ex_datetime',
    'childa_id_ex_time' => 'childa.ex_time',
    'childc_id_ca_id' => 'childa.ca_id',
    'childc_id_name' => 'childa.name',
    'childc_id_ex_int' => 'childa.ex_int',
    'childc_id_ex_string' => 'childa.ex_string',
    'childc_id_ex_date' => 'childa.ex_date',
    'childc_id_ex_datetime' => 'childa.ex_datetime',
    'childc_id_ex_time' => 'childa.ex_time',
  ),
  'join_names' => 
  array (
    'childa_id_ca_id' => 'join_childa_id_ca_id.ca_id',
    'childa_id_name' => 'join_childa_id_ca_id.name',
    'childa_id_ex_int' => 'join_childa_id_ca_id.ex_int',
    'childa_id_ex_string' => 'join_childa_id_ca_id.ex_string',
    'childa_id_ex_date' => 'join_childa_id_ca_id.ex_date',
    'childa_id_ex_datetime' => 'join_childa_id_ca_id.ex_datetime',
    'childa_id_ex_time' => 'join_childa_id_ca_id.ex_time',
    'childc_id_ca_id' => 'join_childc_id_ca_id.ca_id',
    'childc_id_name' => 'join_childc_id_ca_id.name',
    'childc_id_ex_int' => 'join_childc_id_ca_id.ex_int',
    'childc_id_ex_string' => 'join_childc_id_ca_id.ex_string',
    'childc_id_ex_date' => 'join_childc_id_ca_id.ex_date',
    'childc_id_ex_datetime' => 'join_childc_id_ca_id.ex_datetime',
    'childc_id_ex_time' => 'join_childc_id_ca_id.ex_time',
  ),
  'count' => 'DISTINCT  joinerb.childa_id',
)
 distinct column...  .
QUERY:a1d40fdfa7c3e183c07d017ffdff67e9:
SELECT DISTINCT( join_childa_id_ca_id.name)  as childa_id_name ,  joiner.id as id
 ,  joiner.childa_id as childa_id
 ,  joiner.childb_id as childb_id
 ,  join_childa_id_ca_id.ca_id as childa_id_ca_id
 ,  join_childa_id_ca_id.ex_int as childa_id_ex_int
 ,  join_childa_id_ca_id.ex_string as childa_id_ex_string
 ,  join_childa_id_ca_id.ex_date as childa_id_ex_date
 ,  join_childa_id_ca_id.ex_datetime as childa_id_ex_datetime
 ,  join_childa_id_ca_id.ex_time as childa_id_ex_time
 FROM   joiner   

 LEFT JOIN childa AS join_childa_id_ca_id ON (join_childa_id_ca_id.ca_id=joiner.childa_id) 

array (
  'cols' => 
  array (
    'id' => 'joinerb.id',
    'childa_id' => 'joinerb.childa_id',
    'childb_id' => 'joinerb.childb_id',
    'childc_id' => 'joinerb.childc_id',
    'childa_id_ca_id' => 'childa.ca_id',
    'childa_id_name' => 'childa.name',
    'childa_id_ex_int' => 'childa.ex_int',
    'childa_id_ex_string' => 'childa.ex_string',
    'childa_id_ex_date' => 'childa.ex_date',
    'childa_id_ex_datetime' => 'childa.ex_datetime',
    'childa_id_ex_time' => 'childa.ex_time',
    'childc_id_ca_id' => 'childa.ca_id',
    'childc_id_name' => 'childa.name',
    'childc_id_ex_int' => 'childa.ex_int',
    'childc_id_ex_string' => 'childa.ex_string',
    'childc_id_ex_date' => 'childa.ex_date',
    'childc_id_ex_datetime' => 'childa.ex_datetime',
    'childc_id_ex_time' => 'childa.ex_time',
  ),
  'join_names' => 
  array (
    'childa_id_ca_id' => 'join_childa_id_ca_id.ca_id',
    'childa_id_name' => 'join_childa_id_ca_id.name',
    'childa_id_ex_int' => 'join_childa_id_ca_id.ex_int',
    'childa_id_ex_string' => 'join_childa_id_ca_id.ex_string',
    'childa_id_ex_date' => 'join_childa_id_ca_id.ex_date',
    'childa_id_ex_datetime' => 'join_childa_id_ca_id.ex_datetime',
    'childa_id_ex_time' => 'join_childa_id_ca_id.ex_time',
    'childc_id_ca_id' => 'join_childc_id_ca_id.ca_id',
    'childc_id_name' => 'join_childc_id_ca_id.name',
    'childc_id_ex_int' => 'join_childc_id_ca_id.ex_int',
    'childc_id_ex_string' => 'join_childc_id_ca_id.ex_string',
    'childc_id_ex_date' => 'join_childc_id_ca_id.ex_date',
    'childc_id_ex_datetime' => 'join_childc_id_ca_id.ex_datetime',
    'childc_id_ex_time' => 'join_childc_id_ca_id.ex_time',
  ),
  'count' => 'DISTINCT  join_childa_id_ca_id.name',
)