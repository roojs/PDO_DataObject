--TEST--
config - schema_location Test  
--FILE--
<?php
require_once 'includes/init.php';


echo "\n\n--------\n";
echo "Test Mysql \n" ;



PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
        
        'class_prefix' => 'DataObjects_',
        
        'database' => '',
        'databases' => array(
            'mysql_anotherdb' =>  'mysql://username:test@localhost:3344/somedb#',
            'inserttest' => 'mysql://user:pass@localhost/inserttest',
        ),
        
          
     
));

PDO_DataObject::debugLevel(1);
 

echo "\n\n--------\n";
echo "listed with seperators\n" ;
PDO_DataObject::config(array(
    'schema_location' => __DIR__.'/includes' . PATH_SEPARATOR . __DIR__.'/includes/test_ini'
));


PDO_DataObject::factory('Events')
        ->limit(1)
        ->find(true);
        
print_r(PDO_DataObject::factory('Events')->tableColumns());

PDO_DataObject::factory('account_transaction')
        ->limit(1)
        ->find();
        
print_r(PDO_DataObject::factory('account_transaction')->tableColumns());

PDO_DataObject::reset();
echo "\n\n--------\n";
echo "listed with seperators\n" ;

PDO_DataObject::config(array(
    'schema_location' => array(
        'inserttest' =>    __DIR__.'/includes' ,
        'mysql_anotherdb' =>   PATH_SEPARATOR . __DIR__.'/includes/test_ini'
    )
));



PDO_DataObject::factory('Events')
        ->limit(1)
        ->find(true);
        
print_r(PDO_DataObject::factory('Events')->tableColumns());

PDO_DataObject::factory('account_transaction')
        ->limit(1)
        ->find();
        
print_r(PDO_DataObject::factory('account_transaction')->tableColumns());



?>
--EXPECT--
