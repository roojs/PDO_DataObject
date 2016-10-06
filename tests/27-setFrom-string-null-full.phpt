--TEST--
setFrom / set Test (where enable_string_null = true)
--FILE--
<?php
require_once 'includes/init.php';

PDO_DataObject::config(array(
        'class_location' => __DIR__.'/includes/sample_classes/DataObjects_',
    // fake db..
   
        'database' => 'mysql://user:pass@localhost/inserttest'
      
));

PDO_DataObject::debugLevel(0);
 



echo "\n\n----------------------------------------------------------------\n";

echo "enable_null_strings = true\n" ;
PDO_DataObject::config('enable_null_strings', 'full');

PDO_DataObject::debugLevel(0);
  
  
?>
--EXPECT--

 
