<?php

// wrapper to assist in migration...

require_once 'PDO/DataObject.php';

class DB_DataObject extends PDO_DataObject {
    static function factory($v)
    {
        return PDO_DataObject::factory($v);
    }
    static function debugLevel($v)
    {
        return PDO_DataObject::debugLevel($v);
    }
}
// declare so any include/usage triggers an error... 
class DB_DataObject_Cast {}
class DB_DataObject_Generator {}
