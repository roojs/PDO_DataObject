--TEST--
github bug #12
--FILE--
<?php


ini_set('include_path', __DIR__ .'/../' . PATH_SEPARATOR .  ini_get('include_path'));
require_once 'PDO/DataObject.php';
 

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

$foo->get(1);  

echo "DONE\n";

?>
--EXPECT--
DONE