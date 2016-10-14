//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

build = new Roo.XComponent({

 _strings : {
  '9bf38a80987bf15dce35ca41b3a34f35' :"Setting Properties to generate a query",
  '7dd6d86a2c8648fe541335db76a0cabb' :"<p>\nThere are two ways that queries are built in PDO_DataObjects\n</p>\n<ul>\n<li>Properties of the object, that match the column names in the table\n<li>Calling the query modification methods.\n</ul>\n\n<p>\nBy just assigning values to the DataObject, then running fetchAll() or find/fetch() the query will be built \nbased on the values you set.\n</p>\n\n",
  '8413aa2e38fdd078a3d96e34592d286a' :"Building Queries",
  'd6aa8be6ff38aa217305484e5dd38a88' :"<p>\nWhat that code does should be reasonably clear\n</p>\n<ul>\n<li>Load, and create an instance of the 'events' class\n<li>fetch the record with the primary ID = 3523\n<li>set the value of 'action' to 'testing'\n<li>perform a database update\n</ul>\n\n<p>\nMost methods in PDO_DataObjects support chaining, except on methods which are designed to be\n compatibile with DB_DataObjects.\n</p>\n\n\n"
 },

  part     :  ["docs", "build" ],
  order    : '001-build',
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
     html : _this._strings['8413aa2e38fdd078a3d96e34592d286a'] /* Building Queries */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['7dd6d86a2c8648fe541335db76a0cabb'] /* 
     <p>     
There are two ways that queries are built in PDO_DataObjects     
</p>     
<ul>     
<li>Properties of the object, that match the column names in the table     
<li>Calling the query modification methods.     
</ul>     
     
<p>     
By just assigning values to the DataObject, then running fetchAll() or find/fetch() the query will be built      
based on the values you set.     
</p>     
     

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
         title : _this._strings['9bf38a80987bf15dce35ca41b3a34f35'] /* Setting Properties to generate a query */,
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
