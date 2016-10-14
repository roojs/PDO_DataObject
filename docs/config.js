//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

config = new Roo.XComponent({

 _strings : {
  'c73e1063642e4b100f0d27e1bf13213a' :"<p>\nPDO_DataObject can be configured in many ways, the exact properties are listed\n in the <a href=\"#pdo-dataobject/config\">config</a> method\n</p>\n\n<p>\nDatabase DSNs are based around the classic PEAR DB, format (URL), and are mapped to PDO DSN for connecting.\nA DSN consists of\n<dl>\n\n<dt>database type://</dt>\n<dd>currently supported are mysql, pgsql, sqlite and to some degree oracle and mssql</dd>\n\n\n\n<dt>user:pass@</dt>\n<dd>before the host, you can put the user and password combination,<br/>\n for postgresql the user pass will be set as the arguments on the PDO constructor\n</dd>\n\n<dt>hostname/</dt>\n<dd>normally  localhost, or an IP or server. if you are using sqlite the format is slightly different, see below.\n</dd>\n\n<dt>databasename</dt>\n<dd>the database name.</dd>\n\n<dt>?some=params</dt>\n<dd>if the PDO connections needs other information it can go here.\n</dd>\n\n<dt>#ATTR_PERSISENT</dt>\n<dd>you can set PDO connection properties using the pipe character as a seperator after the hash, eg.\nXXXX=1|YYY=2\n</dd>\n\n</dl>",
  '1a0042954f1d5836710c84459618f095' :"Postgresql Connection examples",
  '694ce9694362ab071d46ae7dda42a0f7' :"MS SQL server connection examples",
  '35be5669049f8fb369c7654567b1d1ab' :"Mysql Connection examples",
  '5a74df583978a5eff924d7231d726b2c' :"Sqlite Connection examples",
  '8d029c3f3751d2ca224271f75ab606c7' :"oracle server connection examples",
  '254f642527b45bc260048e30704edb39' :"Configuration"
 },

  part     :  ["docs", "config" ],
  order    : '001-config',
  region   : 'center',
  parent   : false,
  name     : "unnamed module",
  disabled : false, 
  permname : '', 
  _tree : function()
  {
   var _this = this;
   var MODULE = this;
   return {
   xtype : 'Body',
   xns : Roo.bootstrap,
   '|xns' : 'Roo.bootstrap',
   items  : [
    {
     xtype : 'Header',
     html : _this._strings['254f642527b45bc260048e30704edb39'] /* Configuration */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['c73e1063642e4b100f0d27e1bf13213a'] /* 
     <p>     
PDO_DataObject can be configured in many ways, the exact properties are listed     
 in the <a href="#pdo-dataobject/config">config</a> method     
</p>     
     
<p>     
Database DSNs are based around the classic PEAR DB, format (URL), and are mapped to PDO DSN for connecting.     
A DSN consists of     
<dl>     
     
<dt>database type://</dt>     
<dd>currently supported are mysql, pgsql, sqlite and to some degree oracle and mssql</dd>     
     
     
     
<dt>user:pass@</dt>     
<dd>before the host, you can put the user and password combination,<br/>     
 for postgresql the user pass will be set as the arguments on the PDO constructor     
</dd>     
     
<dt>hostname/</dt>     
<dd>normally  localhost, or an IP or server. if you are using sqlite the format is slightly different, see below.     
</dd>     
     
<dt>databasename</dt>     
<dd>the database name.</dd>     
     
<dt>?some=params</dt>     
<dd>if the PDO connections needs other information it can go here.     
</dd>     
     
<dt>#ATTR_PERSISENT</dt>     
<dd>you can set PDO connection properties using the pipe character as a seperator after the hash, eg.     
XXXX=1|YYY=2     
</dd>     
     
</dl>
     */ ,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Entry',
     xns : Roo.doc,
     '|xns' : 'Roo.doc',
     items  : [
      {
       xtype : 'Section',
       lang : 'php',
       xns : Roo.doc,
       '|xns' : 'Roo.doc',
       items  : [
        {
         xtype : 'Example',
         code : 'PDO_DataObject::config(\'database\', \'mysql://username:test@localhost:3344/somedb#\' . implode( \'|\',\n    array(\n        \'MYSQL_ATTR_SSL_KEY=/path/to/client-key.pem\',\n        \'MYSQL_ATTR_SSL_CERT=/path/to/client-cert.pem\',\n        \'MYSQL_ATTR_SSL_CA=/path/to/ca-cert.pem\',\n        \n        \'MYSQL_ATTR_LOCAL_INFILE=1\',\n        \'MYSQL_ATTR_INIT_COMMAND=2\',\n       // \'MYSQL_ATTR_READ_DEFAULT_FILE=3\',\n       //  \'MYSQL_ATTR_READ_DEFAULT_GROUP=4\',\n        \'MYSQL_ATTR_MAX_BUFFER_SIZE=5\',\n        \'MYSQL_ATTR_DIRECT_QUERY=6\',\n        \'MYSQL_ATTR_FOUND_ROWS=7\',\n        \'MYSQL_ATTR_IGNORE_SPACE=8\',\n        \'MYSQL_ATTR_COMPRESS=9\',\n        \'MYSQL_ATTR_SSL_CIPHER=10\',\n        \'MYSQL_ATTR_SSL_KEY=11\',\n        \'MYSQL_ATTR_MULTI_STATEMENTS=12\',\n        \n    )));\n(new PDO_DataObject())->PDO();\n',
         output : 'results in the following call to connect to PDO\n\nnew PDO(\n    \"mysql:dbname=somedb;host=localhost;port=3344\",\n    \"username\",\n    \"test\",\n    array(\n        \"1007\" => \"11\",\n        \"1008\"=> \"/path/to/client-cert.pem\",\n        \"1009\"=> \"/path/to/ca-cert.pem\",\n        \"1001\"=> \"1\",\n        \"1002\"=> \"2\",\n        \"0\"=> \"5\",\n        \"1004\"=> \"6\",\n        \"1005\"=> \"7\",\n        \"1006\"=> \"8\",\n        \"1003\"=> \"9\",\n        \"1011\"=> \"10\",\n        \"1013\"=> \"12\"\n    )\n);\n',
         outputlang : 'php',
         title : _this._strings['35be5669049f8fb369c7654567b1d1ab'] /* Mysql Connection examples */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Entry',
     xns : Roo.doc,
     '|xns' : 'Roo.doc',
     items  : [
      {
       xtype : 'Section',
       lang : 'php',
       xns : Roo.doc,
       '|xns' : 'Roo.doc',
       items  : [
        {
         xtype : 'Example',
         code : '// Postgres\nPDO_DataObject::config(\'database\', \'pgsql://nobody:change_me@localhost:3434/example\');\n(new PDO_DataObject())->PDO();\n// postgres (with user/pass in dsn..\nPDO_DataObject::config(\'database\', \'pgsql://localhost:3434/example?user=nobody&password=change_me\');\n(new PDO_DataObject())->PDO();\n',
         output : 'Results in these calls to PDO\n\nnew PDO(\"pgsql:dbname=example;host=localhost;port=3434\",\"nobody\",\"change_me\");\n\nnew PDO(\"pgsql:dbname=example;host=localhost;port=3434;user=nobody;password=change_me\",\"\",\"\");\n',
         outputlang : 'php',
         title : _this._strings['1a0042954f1d5836710c84459618f095'] /* Postgresql Connection examples */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Entry',
     xns : Roo.doc,
     '|xns' : 'Roo.doc',
     items  : [
      {
       xtype : 'Section',
       lang : 'php',
       xns : Roo.doc,
       '|xns' : 'Roo.doc',
       items  : [
        {
         xtype : 'Example',
         code : '\nPDO_DataObject::config(\'database\', \'sqlite:/opt/databases/mydb.sq3\');\n(new PDO_DataObject())->PDO();\nPDO_DataObject::config(\'database\', \'sqlite::memory:\');\n(new PDO_DataObject())->PDO();\nPDO_DataObject::config(\'database\', \'sqlite2:/opt/databases/mydb.sq2#ATTR_PERSISTENT=1\');\n(new PDO_DataObject())->PDO();\nPDO_DataObject::config(\'database\', \'sqlite2::memory:\');\n(new PDO_DataObject())->PDO();',
         title : _this._strings['5a74df583978a5eff924d7231d726b2c'] /* Sqlite Connection examples */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Entry',
     xns : Roo.doc,
     '|xns' : 'Roo.doc',
     items  : [
      {
       xtype : 'Section',
       lang : 'php',
       xns : Roo.doc,
       '|xns' : 'Roo.doc',
       items  : [
        {
         xtype : 'Example',
         code : 'PDO_DataObject::config(\'database\', \'sqlsrv://test@localhost/somedb\');\n(new PDO_DataObject())->PDO();\nPDO_DataObject::config(\'database\', \'sqlsrv://UserName%4012345abcde:Password@12345abcde.database.windows.net/somedb\');\n(new PDO_DataObject())->PDO();\nPDO_DataObject::config(\'database\', \'sqlsrv://UserName%4012345abcde:Password@(localdb)\\\\v11.0/somedb?AttachDBFilename=C:\\Users\\user\\my_db.mdf\');\n(new PDO_DataObject())->PDO();\n',
         title : _this._strings['694ce9694362ab071d46ae7dda42a0f7'] /* MS SQL server connection examples */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Entry',
     xns : Roo.doc,
     '|xns' : 'Roo.doc',
     items  : [
      {
       xtype : 'Section',
       lang : 'php',
       xns : Roo.doc,
       '|xns' : 'Roo.doc',
       items  : [
        {
         xtype : 'Example',
         code : '// oci:dbname=mydb\nPDO_DataObject::config(\'database\', \'oci://mydb\'); \n(new PDO_DataObject())->PDO();\n \n// oci:dbname=//localhost:1521/mydb\nPDO_DataObject::config(\'database\', \'oci://localhost:1521/mydb\'); \n(new PDO_DataObject())->PDO();\n\n// oci:dbname=192.168.10.145/orcl;charset=CL8MSWIN1251\nPDO_DataObject::config(\'database\', \'oci://user:pass@192.168.10.145/orcl?charset=CL8MSWIN1251\'); \n(new PDO_DataObject())->PDO();',
         title : _this._strings['8d029c3f3751d2ca224271f75ab606c7'] /* oracle server connection examples */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    }
   ]
  };  }
});
