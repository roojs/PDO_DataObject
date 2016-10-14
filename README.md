# PDO_DataObject

PDO replacement for PEAR's DB_DataObject

Work has been funded by CentralNic Group plc 

---------------------
Manual :

https://roojs.github.io/PDO_DataObject/docs/index.html

---------------------



In General, this should be API compatible with DB_DataObject, except for
* getDatabaseConnection(), which is replaced with PDOConnection() - and returns a PDO object, rather than a PEAR DB object.
* staticGet() - has been removed
* array of database (like a pool is no longer supported) - use a DB proxy

Other Changes
a) chained methods (prefixed with 'c', and throw exceptions)
$key_value =  DB_DAtaObject::Factory('table')
      ->cautoJoin()
      ->cwhere('A=12')
      ->climit(0,10)
      ->fetchAll('id','name');

b) Default behaviour is to throw exceptions (compatibility - PEAR::Error is available as a setting)

c) Overloading has been removed - you should be able to wrap the DataObject and add it back in (it's not recommended - causes more problems than it solves)

d) You can configure DataObjects direct by setting PDO_DataObject::$config - (if PEAR is not loaded, then PEAR::getStaticPropery will not be called...)

---------------------
Commit Log

* note we use git autocommit on save - so the early history does not have much valuable information - as we near completion, valid commit messages will be used.
