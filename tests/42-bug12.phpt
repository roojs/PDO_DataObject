--TEST--
github bug #12
--FILE--
<?php
require_once 'includes/init.php';
class Foo extends PDO_DataObject
{
    public function __construct()
    {
        parent::__construct();
        $this->__table = 'imgcache';
    }
}

PDO_DataObject::config(['database' => 'sqlite::memory:', 'proxy' => true]);

$foo = new Foo();
$foo->PDO()->query('CREATE TABLE IF NOT EXISTS "imgcache" (
    id     INTEGER PRIMARY KEY,
    foobar VARCHAR (255)
);');

$foo->get(); // PHP Fatal error:  Uncaught PDO_DataObject_Exception_InvalidConfig


?>
--EXPECT--
 