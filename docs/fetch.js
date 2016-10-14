//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

fetch = new Roo.XComponent({

 _strings : {
  'c2b942b501dc222d608980c0ed40b07c' :"Fetching Results",
  'dd3017609e5cbd3c6782241364790151' :"<p>\nTo actually fetch data from the database, one of the fetch commands must be run.\n</p>\n\n<p>\nFor loading single rows\n</p>\n<ul>\n<li><a href=\"#pdo-dataobject/load\">load</a> - this loads a single row (Chainable)\n<li><a href=\"#pdo-dataobject/reload\">reload</a> - this reloads the existing object from the database (Chainable)\n<li><a href=\"#pdo-dataobject/get\">get</a> - this loads a single row\n<li><a href=\"#pdo-dataobject/count\">count</a> - counts the number of a results a query will return.\n</ul>\n\n\n<p>\nFor sending queries\n</p>\n<ul>\n<li><a href=\"#pdo-dataobject/find\">find</a> - builds the query from the properties and called methods\n<li><a href=\"#pdo-dataobject/query\">query</a> - sends a raw query\n<li><a href=\"#pdo-dataobject/get\">get</a> - this loads a single row\n</ul>\n\n<p>\nFor fetching results\n</p>\n<ul>\n<li><a href=\"#pdo-dataobject/fetch\">fetch</a> - loads the object's propeties with the values from the database\n<li><a href=\"#pdo-dataobject/query\">fetchAll</a> - retrieves all the results in various formats\n<li><a href=\"#pdo-dataobject/get\">get</a> - this loads a single row\n</ul>\n\n\n\nBuffered results.",
  '6ed348e04674567827e341bb5b6d9d82' :"Example of using PDO_DataObjects",
  'd6aa8be6ff38aa217305484e5dd38a88' :"<p>\nWhat that code does should be reasonably clear\n</p>\n<ul>\n<li>Load, and create an instance of the 'events' class\n<li>fetch the record with the primary ID = 3523\n<li>set the value of 'action' to 'testing'\n<li>perform a database update\n</ul>\n\n<p>\nMost methods in PDO_DataObjects support chaining, except on methods which are designed to be\n compatibile with DB_DataObjects.\n</p>\n\n\n"
 },

  part     :  ["docs", "fetch" ],
  order    : '001-fetch',
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
     html : _this._strings['c2b942b501dc222d608980c0ed40b07c'] /* Fetching Results */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['dd3017609e5cbd3c6782241364790151'] /* 
     <p>     
To actually fetch data from the database, one of the fetch commands must be run.     
</p>     
     
<p>     
For loading single rows     
</p>     
<ul>     
<li><a href="#pdo-dataobject/load">load</a> - this loads a single row (Chainable)     
<li><a href="#pdo-dataobject/reload">reload</a> - this reloads the existing object from the database (Chainable)     
<li><a href="#pdo-dataobject/get">get</a> - this loads a single row     
<li><a href="#pdo-dataobject/count">count</a> - counts the number of a results a query will return.     
</ul>     
     
     
<p>     
For sending queries     
</p>     
<ul>     
<li><a href="#pdo-dataobject/find">find</a> - builds the query from the properties and called methods     
<li><a href="#pdo-dataobject/query">query</a> - sends a raw query     
<li><a href="#pdo-dataobject/get">get</a> - this loads a single row     
</ul>     
     
<p>     
For fetching results     
</p>     
<ul>     
<li><a href="#pdo-dataobject/fetch">fetch</a> - loads the object's propeties with the values from the database     
<li><a href="#pdo-dataobject/query">fetchAll</a> - retrieves all the results in various formats     
<li><a href="#pdo-dataobject/get">get</a> - this loads a single row     
</ul>     
     
     
     
Buffered results.
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
