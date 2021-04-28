--TEST--
Generator - write files
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
$base_config = PDO_DataObject::config();

 

// test structure from introspection
 
$fn = tempnam (sys_get_temp_dir(), 'pdo-do-tests-') . '-dir';
mkdir($fn);


PDO_DataObject::config(
    array(
        'schema_location' => $fn,
        'PDO' => 'PDO_Dummy',
        'proxy' => true,
        'database' => '',
        'databases' => array(
            'mysql_anotherdb' => 'mysql://root:@localhost:3344/anotherdb'
        ),
    )
);
 

$gen = (new PDO_DataObject('mysql_anotherdb/Events'))->generator();

PDO_DataObject_Generator::config(array(
         
            
            //'strip_schema' => true,
            'embed_schema' => true,
            'extends_class' => 'PDO_DataObject_Test1',
            'extends_class_location' => 'PDO/DataObject_Test1.php',
                
        
            //'generate_links' => false,
                // generate .link.ini files based on introspecting the database.
        
            'var_keyword' => 'private',
                
            'add_database_nickname' => true,
                
            // 'no_column_vars' => false,
                
                
            'setters' => true,
            'getters' => true,
            'add_defaults' => true,
            'link_methods'  =>true,
                
            //'include_regex' =>  '/^Companies$/'
            //'exclude_regex' => false,
              
            


));

try { 
    $gen->start();
} catch(PDO_DataObject_Exception_InvalidConfig $e) {
    echo "Expected Exception (no class location) - " . $e->getMessage();
}
echo "\nSetting class location\n";

copy(__DIR__.'/includes/test_ini/Companies.php', $fn.'/Companies.php');


PDO_DataObject::config('class_location', $fn);
$gen->start();

echo `cd  $fn; md5sum *`;

echo file_get_contents($fn.'/Companies.php');

`rm -rf $fn`;

?>
--EXPECT--
__construct==["mysql:dbname=anotherdb;host=localhost;port=3344","root","",[]]
setAttribute==[3,2]
QUERY:9c36cac1372650b703400c60dd29042c:
SHOW TABLES
QUERY:e7e98b166e84d8a86f012e03789dc226:

                        
                        SELECT
                            COLUMNS.TABLE_NAME as tablename,
                            COLUMNS.COLUMN_NAME as name,
                            COLUMN_DEFAULT as default_value_raw,
                            DATA_TYPE as type,
                            COALESCE(NUMERIC_PRECISION,CHARACTER_MAXIMUM_LENGTH) as len,
                            CONCAT(
                                EXTRA,  -- autoincrement...
                                IF (IS_NULLABLE, '', ' not_null'),
                                IF (COLUMN_KEY = 'PRI', ' primary', ''),
                                IF (COLUMN_KEY = 'UNI', ' unique', ''),
                                IF (COLUMN_KEY = 'MUL', ' multiple_key', '')
                                
                            )    as flags,
                            COALESCE(REFERENCED_TABLE_NAME,'') as fk_table,
                            COALESCE(REFERENCED_COLUMN_NAME,'') as fk_column,
                             12 as _prevent_cache
                            
                        FROM
                            INFORMATION_SCHEMA.COLUMNS
                        LEFT JOIN
                            INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                        ON
                            KEY_COLUMN_USAGE.TABLE_NAME = COLUMNS.TABLE_NAME 
                            AND
                            KEY_COLUMN_USAGE.COLUMN_NAME = COLUMNS.COLUMN_NAME
                            AND
                            KEY_COLUMN_USAGE.TABLE_SCHEMA = COLUMNS.TABLE_SCHEMA 
                        WHERE
                            COLUMNS.TABLE_SCHEMA = DATABASE()
                
QUERY:9c36cac1372650b703400c60dd29042c:
SHOW TABLES
Expected Exception (no class location) - option[class_location] must be set, and a single location for the generator to work.Current value is ''
Setting class location
QUERY:9c36cac1372650b703400c60dd29042c:
SHOW TABLES
3e2299f34018e2aef619036a82269563  Companies.php
b1569d7150f2417d52a7a0b118c033d2  Events.php
086c0d30a14f05968a8b5b627a213aa0  Groups.php
a65c403d8bb8f3c328a370a38524d58d  mysql_anotherdb.ini
<?php
/**
 * Table Definition for Companies
 */
class_exists('DataObjects_Companies') ? '' : require_once 'PDO/DataObject_Test1.php';

class DataObjects_Companies extends PDO_DataObject_Test1
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
    private $comptype;                       // VARCHAR not_null
    private $url;                            // VARCHAR not_null
    private $main_office_id;                 // INT not_null
    private $created_by;                     // INT not_null
    private $created_dt;                     // DATETIME not_null
    private $updated_by;                     // INT not_null
    private $updated_dt;                     // DATETIME not_null
    private $passwd;                         // VARCHAR not_null
    private $dispatch_port;                  // VARCHAR not_null
    private $province;                       // VARCHAR not_null
    private $country;                        // VARCHAR not_null


   /**
    * Getter for $id
    *
    * @return   INT
    * @access   public
    */
    function getId() {
        return $this->id;
    }

   /**
    * Setter for $id
    *
    * @param    mixed   input value
    * @access   public
    */
    function setId($value) {
        $this->id = $value;
    }


   /**
    * Getter for $code
    *
    * @return   VARCHAR
    * @access   public
    */
    function getCode() {
        return $this->code;
    }

   /**
    * Setter for $code
    *
    * @param    mixed   input value
    * @access   public
    */
    function setCode($value) {
        $this->code = $value;
    }


   /**
    * Getter for $name
    *
    * @return   VARCHAR
    * @access   public
    */
    function getName() {
        return $this->name;
    }

   /**
    * Setter for $name
    *
    * @param    mixed   input value
    * @access   public
    */
    function setName($value) {
        $this->name = $value;
    }


   /**
    * Getter for $remarks
    *
    * @return   TEXT
    * @access   public
    */
    function getRemarks() {
        return $this->remarks;
    }

   /**
    * Setter for $remarks
    *
    * @param    mixed   input value
    * @access   public
    */
    function setRemarks($value) {
        $this->remarks = $value;
    }


   /**
    * Getter for $owner_id
    *
    * @return   INT
    * @access   public
    */
    function getOwner_id() {
        return $this->owner_id;
    }

   /**
    * Setter for $owner_id
    *
    * @param    mixed   input value
    * @access   public
    */
    function setOwner_id($value) {
        $this->owner_id = $value;
    }


   /**
    * Getter for $address
    *
    * @return   TEXT
    * @access   public
    */
    function getAddress() {
        return $this->address;
    }

   /**
    * Setter for $address
    *
    * @param    mixed   input value
    * @access   public
    */
    function setAddress($value) {
        $this->address = $value;
    }


   /**
    * Getter for $tel
    *
    * @return   VARCHAR
    * @access   public
    */
    function getTel() {
        return $this->tel;
    }

   /**
    * Setter for $tel
    *
    * @param    mixed   input value
    * @access   public
    */
    function setTel($value) {
        $this->tel = $value;
    }


   /**
    * Getter for $fax
    *
    * @return   VARCHAR
    * @access   public
    */
    function getFax() {
        return $this->fax;
    }

   /**
    * Setter for $fax
    *
    * @param    mixed   input value
    * @access   public
    */
    function setFax($value) {
        $this->fax = $value;
    }


   /**
    * Getter for $email
    *
    * @return   VARCHAR
    * @access   public
    */
    function getEmail() {
        return $this->email;
    }

   /**
    * Setter for $email
    *
    * @param    mixed   input value
    * @access   public
    */
    function setEmail($value) {
        $this->email = $value;
    }


   /**
    * Getter for $isOwner
    *
    * @return   INT
    * @access   public
    */
    function getIsOwner() {
        return $this->isOwner;
    }

   /**
    * Setter for $isOwner
    *
    * @param    mixed   input value
    * @access   public
    */
    function setIsOwner($value) {
        $this->isOwner = $value;
    }


   /**
    * Getter for $logo_id
    *
    * @return   INT
    * @access   public
    */
    function getLogo_id() {
        return $this->logo_id;
    }

   /**
    * Setter for $logo_id
    *
    * @param    mixed   input value
    * @access   public
    */
    function setLogo_id($value) {
        $this->logo_id = $value;
    }


   /**
    * Getter for $background_color
    *
    * @return   VARCHAR
    * @access   public
    */
    function getBackground_color() {
        return $this->background_color;
    }

   /**
    * Setter for $background_color
    *
    * @param    mixed   input value
    * @access   public
    */
    function setBackground_color($value) {
        $this->background_color = $value;
    }


   /**
    * Getter for $comptype
    *
    * @return   VARCHAR
    * @access   public
    */
    function getComptype() {
        return $this->comptype;
    }

   /**
    * Setter for $comptype
    *
    * @param    mixed   input value
    * @access   public
    */
    function setComptype($value) {
        $this->comptype = $value;
    }


   /**
    * Getter for $url
    *
    * @return   VARCHAR
    * @access   public
    */
    function getUrl() {
        return $this->url;
    }

   /**
    * Setter for $url
    *
    * @param    mixed   input value
    * @access   public
    */
    function setUrl($value) {
        $this->url = $value;
    }


   /**
    * Getter for $main_office_id
    *
    * @return   INT
    * @access   public
    */
    function getMain_office_id() {
        return $this->main_office_id;
    }

   /**
    * Setter for $main_office_id
    *
    * @param    mixed   input value
    * @access   public
    */
    function setMain_office_id($value) {
        $this->main_office_id = $value;
    }


   /**
    * Getter for $created_by
    *
    * @return   INT
    * @access   public
    */
    function getCreated_by() {
        return $this->created_by;
    }

   /**
    * Setter for $created_by
    *
    * @param    mixed   input value
    * @access   public
    */
    function setCreated_by($value) {
        $this->created_by = $value;
    }


   /**
    * Getter for $created_dt
    *
    * @return   DATETIME
    * @access   public
    */
    function getCreated_dt() {
        return $this->created_dt;
    }

   /**
    * Setter for $created_dt
    *
    * @param    mixed   input value
    * @access   public
    */
    function setCreated_dt($value) {
        $this->created_dt = $value;
    }


   /**
    * Getter for $updated_by
    *
    * @return   INT
    * @access   public
    */
    function getUpdated_by() {
        return $this->updated_by;
    }

   /**
    * Setter for $updated_by
    *
    * @param    mixed   input value
    * @access   public
    */
    function setUpdated_by($value) {
        $this->updated_by = $value;
    }


   /**
    * Getter for $updated_dt
    *
    * @return   DATETIME
    * @access   public
    */
    function getUpdated_dt() {
        return $this->updated_dt;
    }

   /**
    * Setter for $updated_dt
    *
    * @param    mixed   input value
    * @access   public
    */
    function setUpdated_dt($value) {
        $this->updated_dt = $value;
    }


   /**
    * Getter for $passwd
    *
    * @return   VARCHAR
    * @access   public
    */
    function getPasswd() {
        return $this->passwd;
    }

   /**
    * Setter for $passwd
    *
    * @param    mixed   input value
    * @access   public
    */
    function setPasswd($value) {
        $this->passwd = $value;
    }


   /**
    * Getter for $dispatch_port
    *
    * @return   VARCHAR
    * @access   public
    */
    function getDispatch_port() {
        return $this->dispatch_port;
    }

   /**
    * Setter for $dispatch_port
    *
    * @param    mixed   input value
    * @access   public
    */
    function setDispatch_port($value) {
        $this->dispatch_port = $value;
    }


   /**
    * Getter for $province
    *
    * @return   VARCHAR
    * @access   public
    */
    function getProvince() {
        return $this->province;
    }

   /**
    * Setter for $province
    *
    * @param    mixed   input value
    * @access   public
    */
    function setProvince($value) {
        $this->province = $value;
    }


   /**
    * Getter for $country
    *
    * @return   VARCHAR
    * @access   public
    */
    function getCountry() {
        return $this->country;
    }

   /**
    * Setter for $country
    *
    * @param    mixed   input value
    * @access   public
    */
    function setCountry($value) {
        $this->country = $value;
    }

    function tableColumns()
    {
         return array(
             'id' => PDO_DataObject::INT + PDO_DataObject::NOTNULL,
             'code' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'name' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'remarks' => PDO_DataObject::STR + PDO_DataObject::TXT + PDO_DataObject::NOTNULL,
             'owner_id' => PDO_DataObject::INT + PDO_DataObject::NOTNULL,
             'address' => PDO_DataObject::STR + PDO_DataObject::TXT + PDO_DataObject::NOTNULL,
             'tel' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'fax' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'email' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'isOwner' => PDO_DataObject::INT + PDO_DataObject::NOTNULL,
             'logo_id' => PDO_DataObject::INT + PDO_DataObject::NOTNULL,
             'background_color' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'comptype' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'url' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'main_office_id' => PDO_DataObject::INT + PDO_DataObject::NOTNULL,
             'created_by' => PDO_DataObject::INT + PDO_DataObject::NOTNULL,
             'created_dt' => PDO_DataObject::STR + PDO_DataObject::DATE + PDO_DataObject::TIME + PDO_DataObject::NOTNULL,
             'updated_by' => PDO_DataObject::INT + PDO_DataObject::NOTNULL,
             'updated_dt' => PDO_DataObject::STR + PDO_DataObject::DATE + PDO_DataObject::TIME + PDO_DataObject::NOTNULL,
             'passwd' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'dispatch_port' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'province' => PDO_DataObject::STR + PDO_DataObject::NOTNULL,
             'country' => PDO_DataObject::STR + PDO_DataObject::NOTNULL
         );
    }
    function keys()
    {
         return array(
             'id' => 'N'
         );
    }
    function sequenceKey()
    {
         return array(true,true,'');
    }

    function defaults() // column default values 
    {
         return array(
             'code' => '',
             'owner_id' => 0,
             'logo_id' => 0,
             'comptype' => '',
             'url' => '',
             'main_office_id' => 0,
             'created_by' => 0,
             'updated_by' => 0,
             'passwd' => '',
             'dispatch_port' => '',
             'province' => '',
             'country' => ''
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    
    
    function mycode_goes_here()
    {
        
        // some code...
        
    }
    
}