//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

db-dataobject-compatibility = new Roo.XComponent({

 _strings : {
  '1677feef3f32a6ce37a3f18947514ce5' :"DB_DataObject Compatibility",
  '00175fb9f3d007d29118b6f794384cee' :"<p>\nPDO_DataObject is based on the original codebase from DB_DataObjects, however some changes have been made \nsince DB_DataObject was originally used on PHP4, and many features and practices have changed since then.\n</p>\n<ul>\n<li>using PDO rather than native drivers and the PEAR DB wrapper\n<li>more strict static methods\n<li>removal of PEAR dependancies, including error handling\n<li>addition of chained methods\n<li>simpler configuration (again not using PEAR getStaticProperty\n<li>some features - that where not a great idea have been removed, or depricated\n<li>some methods that where very badly named have been renamed.\n</ul>\n\n<h3>Detail incompatibilities</h3>\n\n<p>\nPDO_DataObject is based on PEAR's <a href=\"https://pear.php.net/manual/en/package.database.db-dataobject.php\">DB_DataObject</a> and for most purposes is \nfunctionally compatibly (see <a href=\"#db-dataobject-compatibility\">DB_DataObject Compatibility</a>)\n</p>\n\n<p>\nSo what does that mean in English? Well, if you look around at some of the better written PHP applications and frameworks\n out there, you will notice a common approach to using classes to wrap access to database tables or groups.\n</p>\n<p>\nPDO_DataObjects follows this pattern, In normal usage, you define one Class for each table that you use \n(you can use the genreator tools to automate this process), \n\nonce you have created the classes, and configured PDO_DataObjects you can the access the database  like this\n\n",
  '6ed348e04674567827e341bb5b6d9d82' :"Example of using PDO_DataObjects",
  'd6aa8be6ff38aa217305484e5dd38a88' :"<p>\nWhat that code does should be reasonably clear\n</p>\n<ul>\n<li>Load, and create an instance of the 'events' class\n<li>fetch the record with the primary ID = 3523\n<li>set the value of 'action' to 'testing'\n<li>perform a database update\n</ul>\n\n<p>\nMost methods in PDO_DataObjects support chaining, except on methods which are designed to be\n compatibile with DB_DataObjects.\n</p>\n\n\n"
 },

  part     :  ["docs", "db-dataobject-compatibility" ],
  order    : '001-db-dataobject-compatibility',
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
     html : _this._strings['1677feef3f32a6ce37a3f18947514ce5'] /* DB_DataObject Compatibility */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['00175fb9f3d007d29118b6f794384cee'] /* 
     <p>     
PDO_DataObject is based on the original codebase from DB_DataObjects, however some changes have been made      
since DB_DataObject was originally used on PHP4, and many features and practices have changed since then.     
</p>     
<ul>     
<li>using PDO rather than native drivers and the PEAR DB wrapper     
<li>more strict static methods     
<li>removal of PEAR dependancies, including error handling     
<li>addition of chained methods     
<li>simpler configuration (again not using PEAR getStaticProperty     
<li>some features - that where not a great idea have been removed, or depricated     
<li>some methods that where very badly named have been renamed.     
</ul>     
     
<h3>Detail incompatibilities</h3>     
     
<p>     
PDO_DataObject is based on PEAR's <a href="https://pear.php.net/manual/en/package.database.db-dataobject.php">DB_DataObject</a> and for most purposes is      
functionally compatibly (see <a href="#db-dataobject-compatibility">DB_DataObject Compatibility</a>)     
</p>     
     
<p>     
So what does that mean in English? Well, if you look around at some of the better written PHP applications and frameworks     
 out there, you will notice a common approach to using classes to wrap access to database tables or groups.     
</p>     
<p>     
PDO_DataObjects follows this pattern, In normal usage, you define one Class for each table that you use      
(you can use the genreator tools to automate this process),      
     
once you have created the classes, and configured PDO_DataObjects you can the access the database  like this     
     

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
         code : 'PDO_DataObject::factory(\'Events\')\n    ->load(3523)\n    ->set([\'action\' => \"testing\" ])\n    ->save();\n',
         title : _this._strings['6ed348e04674567827e341bb5b6d9d82'] /* Example of using PDO_DataObjects */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Element',
     html : _this._strings['d6aa8be6ff38aa217305484e5dd38a88'] /* 
     <p>     
What that code does should be reasonably clear     
</p>     
<ul>     
<li>Load, and create an instance of the 'events' class     
<li>fetch the record with the primary ID = 3523     
<li>set the value of 'action' to 'testing'     
<li>perform a database update     
</ul>     
     
<p>     
Most methods in PDO_DataObjects support chaining, except on methods which are designed to be     
 compatibile with DB_DataObjects.     
</p>     
     
     

     */ ,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    }
   ]
  };  }
});
