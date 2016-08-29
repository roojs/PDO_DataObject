--TEST--
Generator - INI file
--FILE--
<?php
require_once 'includes/init.php';
 
 

// test structure from introspection
 

 
// sqlite
PDO_DataObject::config(array(
        'PDO' => 'PDO', // we can do this for real...
        'tables' => array(
            'Customers' => 'EssentialSQL'
        ),
        'databases' => array(
            'EssentialSQL' => 'sqlite:'.__DIR__.'/includes/EssentialSQL.db'
        ),
        'proxy' => true,
        'debug' => 0,
));

 

 


$gen = (new PDO_DataObject('EssentialSQL/Customers'))->generator();

PDO_DataObject_Generator::config(array(
         
           // 'build_views' => true,
            //'strip_schema' => true,
            'embed_schema' => true,
              
        
            //'generate_links' => true,
        
            //'var_keyword' => 'private',
                
            //'add_database_nickname' => true,
                
            // 'no_column_vars' => false,
                
                
            'setters' => true,
            'getters' => true,
            'add_defaults' => true,
            'link_methods'  =>true,
                
           // 'include_regex' =>  '/^Companies$/'
            //'exclude_regex' => false,
              
            


));
$tables = $gen->readTableList() ;
echo $gen->toIni();
echo $gen->toLinksIni(); 

foreach($tables as $table) {

    echo $gen->toPhp($table);
}
 
?>
--EXPECT--
[Customers]
CustomerID = 1
CompanyName = 2
ContactName = 2
ContactTitle = 2
Address = 2
City = 2
State = 2

[Customers__keys]
CustomerID = N

[Employees]
EmployeeID = 1
LastName = 2
FirstName = 2
Title = 2
Address = 2
HireDate = 2

[Employees__keys]
EmployeeID = N

[OrderDetails]
OrderDetailID = 1
OrderID = 1
ProductID = 1
UnitPrice = 1
Quantity = 1

[OrderDetails__keys]
OrderDetailID = N

[Orders]
OrderID = 1
CustomerID = 1
EmployeeID = 1
OrderDate = 2
RequiredDate = 2
ShippedDate = 2
ShipVia = 1
FreightCharge = 1

[Orders__keys]
OrderID = N

[Shippers]
ShipperID = 1
CompanyName = 2
Phone = 2

[Shippers__keys]
ShipperID = N

<?php
/**
 * Table Definition for Customers
 */
class_exists('PDO_DataObject') ? '' : require_once 'PDO/DataObject.php';

class DataObjects_Customers extends PDO_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag if you want to regenerate it */

    public $__table = 'Customers';           // table name
    public $CustomerID;                     // INTEGER primary_key auto_increment
    public $CompanyName;                    // VARCHAR
    public $ContactName;                    // VARCHAR
    public $ContactTitle;                   // VARCHAR
    public $Address;                        // VARCHAR
    public $City;                           // VARCHAR
    public $State;                          // VARCHAR


   /**
    * Getter for $CustomerID
    *
    * @return   INTEGER
    * @access   public
    */
    function getCustomerID() {
        return $this->CustomerID;
    }

   /**
    * Setter for $CustomerID
    *
    * @param    mixed   input value
    * @access   public
    */
    function setCustomerID($value) {
        $this->CustomerID = $value;
    }


   /**
    * Getter for $CompanyName
    *
    * @return   VARCHAR
    * @access   public
    */
    function getCompanyName() {
        return $this->CompanyName;
    }

   /**
    * Setter for $CompanyName
    *
    * @param    mixed   input value
    * @access   public
    */
    function setCompanyName($value) {
        $this->CompanyName = $value;
    }


   /**
    * Getter for $ContactName
    *
    * @return   VARCHAR
    * @access   public
    */
    function getContactName() {
        return $this->ContactName;
    }

   /**
    * Setter for $ContactName
    *
    * @param    mixed   input value
    * @access   public
    */
    function setContactName($value) {
        $this->ContactName = $value;
    }


   /**
    * Getter for $ContactTitle
    *
    * @return   VARCHAR
    * @access   public
    */
    function getContactTitle() {
        return $this->ContactTitle;
    }

   /**
    * Setter for $ContactTitle
    *
    * @param    mixed   input value
    * @access   public
    */
    function setContactTitle($value) {
        $this->ContactTitle = $value;
    }


   /**
    * Getter for $Address
    *
    * @return   VARCHAR
    * @access   public
    */
    function getAddress() {
        return $this->Address;
    }

   /**
    * Setter for $Address
    *
    * @param    mixed   input value
    * @access   public
    */
    function setAddress($value) {
        $this->Address = $value;
    }


   /**
    * Getter for $City
    *
    * @return   VARCHAR
    * @access   public
    */
    function getCity() {
        return $this->City;
    }

   /**
    * Setter for $City
    *
    * @param    mixed   input value
    * @access   public
    */
    function setCity($value) {
        $this->City = $value;
    }


   /**
    * Getter for $State
    *
    * @return   VARCHAR
    * @access   public
    */
    function getState() {
        return $this->State;
    }

   /**
    * Setter for $State
    *
    * @param    mixed   input value
    * @access   public
    */
    function setState($value) {
        $this->State = $value;
    }

    function table()
    {
         return array(
             'CustomerID' => PDO_DataObject::INT,
             'CompanyName' => PDO_DataObject::STR,
             'ContactName' => PDO_DataObject::STR,
             'ContactTitle' => PDO_DataObject::STR,
             'Address' => PDO_DataObject::STR,
             'City' => PDO_DataObject::STR,
             'State' => PDO_DataObject::STR
         );
    }
    function keys()
    {
         return array(
             'CustomerID' => 'N'
         );
    }
    function sequenceKey()
    {
         return array(true,true,'');
    }

    function defaults() // column default values 
    {
         return array(
             'CustomerID' => null,
             'CompanyName' => null,
             'ContactName' => null,
             'ContactTitle' => null,
             'Address' => null,
             'City' => null,
             'State' => null
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
<?php
/**
 * Table Definition for Employees
 */
class_exists('PDO_DataObject') ? '' : require_once 'PDO/DataObject.php';

class DataObjects_Employees extends PDO_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag if you want to regenerate it */

    public $__table = 'Employees';           // table name
    public $EmployeeID;                     // INTEGER primary_key auto_increment
    public $LastName;                       // VARCHAR
    public $FirstName;                      // VARCHAR
    public $Title;                          // VARCHAR
    public $Address;                        // VARCHAR
    public $HireDate;                       // VARCHAR


   /**
    * Getter for $EmployeeID
    *
    * @return   INTEGER
    * @access   public
    */
    function getEmployeeID() {
        return $this->EmployeeID;
    }

   /**
    * Setter for $EmployeeID
    *
    * @param    mixed   input value
    * @access   public
    */
    function setEmployeeID($value) {
        $this->EmployeeID = $value;
    }


   /**
    * Getter for $LastName
    *
    * @return   VARCHAR
    * @access   public
    */
    function getLastName() {
        return $this->LastName;
    }

   /**
    * Setter for $LastName
    *
    * @param    mixed   input value
    * @access   public
    */
    function setLastName($value) {
        $this->LastName = $value;
    }


   /**
    * Getter for $FirstName
    *
    * @return   VARCHAR
    * @access   public
    */
    function getFirstName() {
        return $this->FirstName;
    }

   /**
    * Setter for $FirstName
    *
    * @param    mixed   input value
    * @access   public
    */
    function setFirstName($value) {
        $this->FirstName = $value;
    }


   /**
    * Getter for $Title
    *
    * @return   VARCHAR
    * @access   public
    */
    function getTitle() {
        return $this->Title;
    }

   /**
    * Setter for $Title
    *
    * @param    mixed   input value
    * @access   public
    */
    function setTitle($value) {
        $this->Title = $value;
    }


   /**
    * Getter for $Address
    *
    * @return   VARCHAR
    * @access   public
    */
    function getAddress() {
        return $this->Address;
    }

   /**
    * Setter for $Address
    *
    * @param    mixed   input value
    * @access   public
    */
    function setAddress($value) {
        $this->Address = $value;
    }


   /**
    * Getter for $HireDate
    *
    * @return   VARCHAR
    * @access   public
    */
    function getHireDate() {
        return $this->HireDate;
    }

   /**
    * Setter for $HireDate
    *
    * @param    mixed   input value
    * @access   public
    */
    function setHireDate($value) {
        $this->HireDate = $value;
    }

    function table()
    {
         return array(
             'EmployeeID' => PDO_DataObject::INT,
             'LastName' => PDO_DataObject::STR,
             'FirstName' => PDO_DataObject::STR,
             'Title' => PDO_DataObject::STR,
             'Address' => PDO_DataObject::STR,
             'HireDate' => PDO_DataObject::STR
         );
    }
    function keys()
    {
         return array(
             'EmployeeID' => 'N'
         );
    }
    function sequenceKey()
    {
         return array(true,true,'');
    }

    function defaults() // column default values 
    {
         return array(
             'EmployeeID' => null,
             'LastName' => null,
             'FirstName' => null,
             'Title' => null,
             'Address' => null,
             'HireDate' => null
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
<?php
/**
 * Table Definition for OrderDetails
 */
class_exists('PDO_DataObject') ? '' : require_once 'PDO/DataObject.php';

class DataObjects_OrderDetails extends PDO_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag if you want to regenerate it */

    public $__table = 'OrderDetails';        // table name
    public $OrderDetailID;                  // INTEGER primary_key auto_increment
    public $OrderID;                        // INTEGER
    public $ProductID;                      // INTEGER
    public $UnitPrice;                      // REAL
    public $Quantity;                       // INTEGER


   /**
    * Getter for $OrderDetailID
    *
    * @return   INTEGER
    * @access   public
    */
    function getOrderDetailID() {
        return $this->OrderDetailID;
    }

   /**
    * Setter for $OrderDetailID
    *
    * @param    mixed   input value
    * @access   public
    */
    function setOrderDetailID($value) {
        $this->OrderDetailID = $value;
    }


   /**
    * Getter for $OrderID
    *
    * @return   INTEGER
    * @access   public
    */
    function getOrderID() {
        return $this->OrderID;
    }

   /**
    * Setter for $OrderID
    *
    * @param    mixed   input value
    * @access   public
    */
    function setOrderID($value) {
        $this->OrderID = $value;
    }


   /**
    * Getter for $ProductID
    *
    * @return   INTEGER
    * @access   public
    */
    function getProductID() {
        return $this->ProductID;
    }

   /**
    * Setter for $ProductID
    *
    * @param    mixed   input value
    * @access   public
    */
    function setProductID($value) {
        $this->ProductID = $value;
    }


   /**
    * Getter for $UnitPrice
    *
    * @return   REAL
    * @access   public
    */
    function getUnitPrice() {
        return $this->UnitPrice;
    }

   /**
    * Setter for $UnitPrice
    *
    * @param    mixed   input value
    * @access   public
    */
    function setUnitPrice($value) {
        $this->UnitPrice = $value;
    }


   /**
    * Getter for $Quantity
    *
    * @return   INTEGER
    * @access   public
    */
    function getQuantity() {
        return $this->Quantity;
    }

   /**
    * Setter for $Quantity
    *
    * @param    mixed   input value
    * @access   public
    */
    function setQuantity($value) {
        $this->Quantity = $value;
    }

    function table()
    {
         return array(
             'OrderDetailID' => PDO_DataObject::INT,
             'OrderID' => PDO_DataObject::INT,
             'ProductID' => PDO_DataObject::INT,
             'UnitPrice' => PDO_DataObject::INT,
             'Quantity' => PDO_DataObject::INT
         );
    }
    function keys()
    {
         return array(
             'OrderDetailID' => 'N'
         );
    }
    function sequenceKey()
    {
         return array(true,true,'');
    }

    function defaults() // column default values 
    {
         return array(
             'OrderDetailID' => null,
             'OrderID' => null,
             'ProductID' => null,
             'UnitPrice' => null,
             'Quantity' => null
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
<?php
/**
 * Table Definition for Orders
 */
class_exists('PDO_DataObject') ? '' : require_once 'PDO/DataObject.php';

class DataObjects_Orders extends PDO_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag if you want to regenerate it */

    public $__table = 'Orders';              // table name
    public $OrderID;                        // INTEGER primary_key auto_increment
    public $CustomerID;                     // INTEGER
    public $EmployeeID;                     // INTEGER
    public $OrderDate;                      // VARCHAR
    public $RequiredDate;                   // VARCHAR
    public $ShippedDate;                    // VARCHAR
    public $ShipVia;                        // INTEGER
    public $FreightCharge;                  // REAL


   /**
    * Getter for $OrderID
    *
    * @return   INTEGER
    * @access   public
    */
    function getOrderID() {
        return $this->OrderID;
    }

   /**
    * Setter for $OrderID
    *
    * @param    mixed   input value
    * @access   public
    */
    function setOrderID($value) {
        $this->OrderID = $value;
    }


   /**
    * Getter for $CustomerID
    *
    * @return   INTEGER
    * @access   public
    */
    function getCustomerID() {
        return $this->CustomerID;
    }

   /**
    * Setter for $CustomerID
    *
    * @param    mixed   input value
    * @access   public
    */
    function setCustomerID($value) {
        $this->CustomerID = $value;
    }


   /**
    * Getter for $EmployeeID
    *
    * @return   INTEGER
    * @access   public
    */
    function getEmployeeID() {
        return $this->EmployeeID;
    }

   /**
    * Setter for $EmployeeID
    *
    * @param    mixed   input value
    * @access   public
    */
    function setEmployeeID($value) {
        $this->EmployeeID = $value;
    }


   /**
    * Getter for $OrderDate
    *
    * @return   VARCHAR
    * @access   public
    */
    function getOrderDate() {
        return $this->OrderDate;
    }

   /**
    * Setter for $OrderDate
    *
    * @param    mixed   input value
    * @access   public
    */
    function setOrderDate($value) {
        $this->OrderDate = $value;
    }


   /**
    * Getter for $RequiredDate
    *
    * @return   VARCHAR
    * @access   public
    */
    function getRequiredDate() {
        return $this->RequiredDate;
    }

   /**
    * Setter for $RequiredDate
    *
    * @param    mixed   input value
    * @access   public
    */
    function setRequiredDate($value) {
        $this->RequiredDate = $value;
    }


   /**
    * Getter for $ShippedDate
    *
    * @return   VARCHAR
    * @access   public
    */
    function getShippedDate() {
        return $this->ShippedDate;
    }

   /**
    * Setter for $ShippedDate
    *
    * @param    mixed   input value
    * @access   public
    */
    function setShippedDate($value) {
        $this->ShippedDate = $value;
    }


   /**
    * Getter for $ShipVia
    *
    * @return   INTEGER
    * @access   public
    */
    function getShipVia() {
        return $this->ShipVia;
    }

   /**
    * Setter for $ShipVia
    *
    * @param    mixed   input value
    * @access   public
    */
    function setShipVia($value) {
        $this->ShipVia = $value;
    }


   /**
    * Getter for $FreightCharge
    *
    * @return   REAL
    * @access   public
    */
    function getFreightCharge() {
        return $this->FreightCharge;
    }

   /**
    * Setter for $FreightCharge
    *
    * @param    mixed   input value
    * @access   public
    */
    function setFreightCharge($value) {
        $this->FreightCharge = $value;
    }

    function table()
    {
         return array(
             'OrderID' => PDO_DataObject::INT,
             'CustomerID' => PDO_DataObject::INT,
             'EmployeeID' => PDO_DataObject::INT,
             'OrderDate' => PDO_DataObject::STR,
             'RequiredDate' => PDO_DataObject::STR,
             'ShippedDate' => PDO_DataObject::STR,
             'ShipVia' => PDO_DataObject::INT,
             'FreightCharge' => PDO_DataObject::INT
         );
    }
    function keys()
    {
         return array(
             'OrderID' => 'N'
         );
    }
    function sequenceKey()
    {
         return array(true,true,'');
    }

    function defaults() // column default values 
    {
         return array(
             'OrderID' => null,
             'CustomerID' => null,
             'EmployeeID' => null,
             'OrderDate' => null,
             'RequiredDate' => null,
             'ShippedDate' => null,
             'ShipVia' => null,
             'FreightCharge' => null
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
<?php
/**
 * Table Definition for Shippers
 */
class_exists('PDO_DataObject') ? '' : require_once 'PDO/DataObject.php';

class DataObjects_Shippers extends PDO_DataObject 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag if you want to regenerate it */

    public $__table = 'Shippers';            // table name
    public $ShipperID;                      // INTEGER primary_key auto_increment
    public $CompanyName;                    // VARCHAR
    public $Phone;                          // VARCHAR


   /**
    * Getter for $ShipperID
    *
    * @return   INTEGER
    * @access   public
    */
    function getShipperID() {
        return $this->ShipperID;
    }

   /**
    * Setter for $ShipperID
    *
    * @param    mixed   input value
    * @access   public
    */
    function setShipperID($value) {
        $this->ShipperID = $value;
    }


   /**
    * Getter for $CompanyName
    *
    * @return   VARCHAR
    * @access   public
    */
    function getCompanyName() {
        return $this->CompanyName;
    }

   /**
    * Setter for $CompanyName
    *
    * @param    mixed   input value
    * @access   public
    */
    function setCompanyName($value) {
        $this->CompanyName = $value;
    }


   /**
    * Getter for $Phone
    *
    * @return   VARCHAR
    * @access   public
    */
    function getPhone() {
        return $this->Phone;
    }

   /**
    * Setter for $Phone
    *
    * @param    mixed   input value
    * @access   public
    */
    function setPhone($value) {
        $this->Phone = $value;
    }

    function table()
    {
         return array(
             'ShipperID' => PDO_DataObject::INT,
             'CompanyName' => PDO_DataObject::STR,
             'Phone' => PDO_DataObject::STR
         );
    }
    function keys()
    {
         return array(
             'ShipperID' => 'N'
         );
    }
    function sequenceKey()
    {
         return array(true,true,'');
    }

    function defaults() // column default values 
    {
         return array(
             'ShipperID' => null,
             'CompanyName' => null,
             'Phone' => null
         );
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}