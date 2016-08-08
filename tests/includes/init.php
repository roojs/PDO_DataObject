<?php

require_once __DIR__ .'/../../PDO/DataObject.php';
require_once __DIR__ .'/PDO_Dummy.php';

PDO_DataObject::loadConfig(array(
    'database' => 'mysql://user:pass@localhost/testdb',
    'PDO' => 'PDO_Dummy',
    'debug' => 1,
    
));




