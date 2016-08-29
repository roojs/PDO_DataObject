--TEST--
databaseStructure - sqlite - real database (file is in includes)
--FILE--
<?php
require_once 'includes/init.php';
PDO_DataObject::debugLevel(0);
$base_config = PDO_DataObject::config();

 
 
 
 
// sqlite
PDO_DataObject::config(array(
        'PDO' => 'PDO', // we can do this for real...
        'tables' => array(
            'Customers' => 'EssentialSQL'
        )
        'databases' => array(
            'EssentialSQL' => 'sqlite:'.__DIR__.'/includes/EssentialSQL.db'
        ),
        'proxy' => true,
        'debug' => 0,
));

 

$obj = new PDO_DataObject();
$obj->__table = 'Customers';
$obj->PDO(true);
print_r($obj->databaseStructure('EssentialSQL'));


// set structure + retrieve it.
// test not really needed as proxy really tests this..

 
// test error conditions?!? 
// not sure about this one...












?>
--EXPECT--
Array
(
    [Customers] => Array
        (
            [CustomerID] => 1
            [CompanyName] => 2
            [ContactName] => 2
            [ContactTitle] => 2
            [Address] => 2
            [City] => 2
            [State] => 2
        )

    [Customers__keys] => Array
        (
            [CustomerID] => N
        )

    [Employees] => Array
        (
            [EmployeeID] => 1
            [LastName] => 2
            [FirstName] => 2
            [Title] => 2
            [Address] => 2
            [HireDate] => 2
        )

    [Employees__keys] => Array
        (
            [EmployeeID] => N
        )

    [OrderDetails] => Array
        (
            [OrderDetailID] => 1
            [OrderID] => 1
            [ProductID] => 1
            [UnitPrice] => 1
            [Quantity] => 1
        )

    [OrderDetails__keys] => Array
        (
            [OrderDetailID] => N
        )

    [Orders] => Array
        (
            [OrderID] => 1
            [CustomerID] => 1
            [EmployeeID] => 1
            [OrderDate] => 2
            [RequiredDate] => 2
            [ShippedDate] => 2
            [ShipVia] => 1
            [FreightCharge] => 1
        )

    [Orders__keys] => Array
        (
            [OrderID] => N
        )

    [Shippers] => Array
        (
            [ShipperID] => 1
            [CompanyName] => 2
            [Phone] => 2
        )

    [Shippers__keys] => Array
        (
            [ShipperID] => N
        )

)