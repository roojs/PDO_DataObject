# PDO_DataObject

PDO replacement for PEAR's DB_DataObject

Work has been funded by CentralNic Group plc 

In General, this should be API compatible with DB_DataObject, except for

 * getDatabaseConnection(), which is replaced with PDOConnection() - and returns a PDO object, rather than a PEAR DB object.
 * staticGet() - has been removed
 * array of database (like a pool is no longer supported) - use a DB proxy

Other Changes
a) chained methods have been added, and some methods have chained wrappers. 
```
$key_value =  DB_DAtaObject::Factory('table')
      ->joinAll()
      ->where('A=12')
      ->limit(0,10)
      ->fetchAll(function() { print_R($this); });
```
b) PEAR::Error has been replaced with Exceptions 

c) Overloading has been removed - you should be able to wrap the DataObject and add it back in (it's not recommended - causes more problems than it solves)

d) You can configure DataObjects direct by calling PDO_DataObject::config()

# See the migration document - at present that contains the most information.

---------------------
Commit Log

* note we use git autocommit on save - so the early history does not have much valuable information - as we near completion, valid commit messages will be used.
