<?php

ini_set('include_path', __DIR__ .'/../../' . PATH_SEPARATOR. ini_get('include_path');
require_once 'PDO/DataObject.php';
require_once __DIR__ .'/PDO_Dummy.php';

PDO_DataObject::loadConfig(array(
    'database' => 'mysql://user:pass@localhost/testdb',
    'PDO' => 'PDO_Dummy',
    'debug' => 5,
    
));




