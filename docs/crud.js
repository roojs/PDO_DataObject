//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

crud = new Roo.XComponent({

 _strings : {
  '1f24195702e70ab41a269f831364d4aa' :"<p>\nObviously one of the main reasons to use a database is to change the data contained in it.\n PDO_DataObjects has a number of was of doing this. \n</p>\n<ul>\n<li><a href=\"#pdo-dataobjects/insert\">insert</a> a record into the database, using the properties of the object\n<li><a href=\"#pdo-dataobjects/update\">update</a> update the record with some changes.\n<li><a href=\"#pdo-dataobjects/delete\">delete</a>delete a record  - usually based on the primary id\n</ul>\n\n<p>\nIn PDO_DataObject these methods have been added to, allowing chained modifications\n\n<ul>\n<li><a href=\"#pdo-dataobjects/load\">load</a> is a chainable method to load data \n<li><a href=\"#pdo-dataobjects/snapshot\">snapshot</a> keeps a record of the objects properties at the beginning of the changes\n<li><a href=\"#pdo-dataobjects/snapshot\">save</a> either inserts or updates the record, if an update is done, then it will \nuse the snapshot information to determine what to update.\n</li>\n</ul>\n\n",
  '6ed348e04674567827e341bb5b6d9d82' :"Example of using PDO_DataObjects",
  '0b2e73391e1393962ec1b53fc13a31da' :"Create, Update and Deleting records"
 },

  part     :  ["docs", "crud" ],
  order    : '001-crud',
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
     html : _this._strings['0b2e73391e1393962ec1b53fc13a31da'] /* Create, Update and Deleting records */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['1f24195702e70ab41a269f831364d4aa'] /* 
     <p>     
Obviously one of the main reasons to use a database is to change the data contained in it.     
 PDO_DataObjects has a number of was of doing this.      
</p>     
<ul>     
<li><a href="#pdo-dataobjects/insert">insert</a> a record into the database, using the properties of the object     
<li><a href="#pdo-dataobjects/update">update</a> update the record with some changes.     
<li><a href="#pdo-dataobjects/delete">delete</a>delete a record  - usually based on the primary id     
</ul>     
     
<p>     
In PDO_DataObject these methods have been added to, allowing chained modifications     
     
<ul>     
<li><a href="#pdo-dataobjects/load">load</a> is a chainable method to load data      
<li><a href="#pdo-dataobjects/snapshot">snapshot</a> keeps a record of the objects properties at the beginning of the changes     
<li><a href="#pdo-dataobjects/snapshot">save</a> either inserts or updates the record, if an update is done, then it will      
use the snapshot information to determine what to update.     
</li>     
</ul>     
     

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
    }
   ]
  };  }
});
