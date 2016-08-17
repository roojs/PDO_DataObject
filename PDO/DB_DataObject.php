<?php

/**
 *
 * Compatibility wrapper.
 *
 */

class_exists('PDO_DataObject') ? '' : require_once 'PDO/DataObject.php';

class DB_DataObject extends PDO_DataObject
{
    
    
    
    
    
}