//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

creating-dataobjects = new Roo.XComponent({

 _strings : {
  '6ed348e04674567827e341bb5b6d9d82' :"Example of using PDO_DataObjects",
  '2ee868dc71d76b74e5af6c689ef9ffe0' :"Creating DataObjects",
  'd438a0af0c2a3eb34111e45e615fe4a7' :"<p>\nThere are two components that are needed before you can start using DataObjects in your code\n\n<ul>\n<li>a schema file describing the database\n<li>PHP classes representing each of the tables\n</ul>\n<p>\nBoth of these can be created using the tools included with PDO_DataObjects, or you can use the code in \nthe Generator to write the schema files when a page is requested, and cache the results.\n\n<p>\nFor basic usage, use the file PDO/DataObject/createTables.php to create your schema file\n ",
  'd6aa8be6ff38aa217305484e5dd38a88' :"<p>\nWhat that code does should be reasonably clear\n</p>\n<ul>\n<li>Load, and create an instance of the 'events' class\n<li>fetch the record with the primary ID = 3523\n<li>set the value of 'action' to 'testing'\n<li>perform a database update\n</ul>\n\n<p>\nMost methods in PDO_DataObjects support chaining, except on methods which are designed to be\n compatibile with DB_DataObjects.\n</p>\n\n\n"
 },

  part     :  ["docs", "creating-dataobjects" ],
  order    : '001-creating-dataobjects',
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
     html : _this._strings['2ee868dc71d76b74e5af6c689ef9ffe0'] /* Creating DataObjects */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['d438a0af0c2a3eb34111e45e615fe4a7'] /* 
     <p>     
There are two components that are needed before you can start using DataObjects in your code     
     
<ul>     
<li>a schema file describing the database     
<li>PHP classes representing each of the tables     
</ul>     
<p>     
Both of these can be created using the tools included with PDO_DataObjects, or you can use the code in      
the Generator to write the schema files when a page is requested, and cache the results.     
     
<p>     
For basic usage, use the file PDO/DataObject/createTables.php to create your schema file     
 
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
