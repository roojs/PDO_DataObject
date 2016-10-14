//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

introspect = new Roo.XComponent({

 _strings : {
  '3160871894589120db13fb8399c16735' :"Introspecting the database and table schema Information",
  '6ed348e04674567827e341bb5b6d9d82' :"Example of using PDO_DataObjects",
  '2500b7f7f9d2ecfdb2ee50c2c1014d77' :"<p>\nFor PDO_DataObject to work, it has to know a considerable amount about the database it is working with.\nMost of this is done once, and cached in a file. These methods allow you to retrieve that information\n</p>\n\n\n<ul>\n<li>Build SQL and execute statements based on the objects variables.\n<li>Group source code around the data that they relate to.\n<li>Provide a simple consistent API to access and manipulate that data.\n</ul>\n\n<p>\nPDO_DataObject is based on PEAR's <a href=\"https://pear.php.net/manual/en/package.database.db-dataobject.php\">DB_DataObject</a> and for most purposes is \nfunctionally compatibly (see <a href=\"db-dataobject-compatibility\">DB_DataObject Compatibility</a>)\n</p>\n\n<p>\nSo what does that mean in English? Well, if you look around at some of the better written PHP applications and frameworks\n out there, you will notice a common approach to using classes to wrap access to database tables or groups.\n</p>\n<p>\nPDO_DataObjects follows this pattern, In normal usage, you define one Class for each table that you use \n(you can use the genreator tools to automate this process), \n\nonce you have created the classes, and configured PDO_DataObjects you can the access the database  like this\n\n",
  'd6aa8be6ff38aa217305484e5dd38a88' :"<p>\nWhat that code does should be reasonably clear\n</p>\n<ul>\n<li>Load, and create an instance of the 'events' class\n<li>fetch the record with the primary ID = 3523\n<li>set the value of 'action' to 'testing'\n<li>perform a database update\n</ul>\n\n<p>\nMost methods in PDO_DataObjects support chaining, except on methods which are designed to be\n compatibile with DB_DataObjects.\n</p>\n\n\n"
 },

  part     :  ["docs", "introspect" ],
  order    : '001-introspect',
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
     html : _this._strings['3160871894589120db13fb8399c16735'] /* Introspecting the database and table schema Information */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['2500b7f7f9d2ecfdb2ee50c2c1014d77'] /* 
     <p>     
For PDO_DataObject to work, it has to know a considerable amount about the database it is working with.     
Most of this is done once, and cached in a file. These methods allow you to retrieve that information     
</p>     
     
     
<ul>     
<li>Build SQL and execute statements based on the objects variables.     
<li>Group source code around the data that they relate to.     
<li>Provide a simple consistent API to access and manipulate that data.     
</ul>     
     
<p>     
PDO_DataObject is based on PEAR's <a href="https://pear.php.net/manual/en/package.database.db-dataobject.php">DB_DataObject</a> and for most purposes is      
functionally compatibly (see <a href="db-dataobject-compatibility">DB_DataObject Compatibility</a>)     
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
