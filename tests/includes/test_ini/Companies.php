<?php
/**
 * Table Definition for Companies
 */
class_exists('PDO_DataObject') ? '' : require_once 'PDO/DataObject.php';

class DataObjects_Companies extends PDO_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag if you want to regenerate it */

    private $__table = 'Companies';           // table name
    private $_database_nickname = 'mysql_anotherdb';    // database name (used with databases[{*}] config)
    private $id;                             // INT auto_increment not_null primary
    private $code;                           // VARCHAR not_null
    private $name;                           // VARCHAR not_null multiple_key
    private $remarks;                        // TEXT not_null
    private $owner_id;                       // INT not_null
    private $address;                        // TEXT not_null
    private $tel;                            // VARCHAR not_null
    private $fax;                            // VARCHAR not_null
    private $email;                          // VARCHAR not_null
    private $isOwner;                        // INT not_null
    private $logo_id;                        // INT not_null
    private $background_color;               // VARCHAR not_null
    
    private $updated_dt;                     // DATETIME not_null
    private $passwd;                         // VARCHAR not_null
    private $dispatch_port;                  // VARCHAR not_null
    private $province;                       // VARCHAR not_null
    private $country;                        // VARCHAR not_null

 
    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    
    
    function mycode_goes_here()
    {
        
        // some code...
        
    }
    
}
