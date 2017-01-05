//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

fetch = new Roo.XComponent({

 _strings : {
  'c2b942b501dc222d608980c0ed40b07c' :"Fetching Results",
  'aed714b47bb8cb9c375ef026e478f1b4' :"Fetching with buffering turned off",
  '3de4716711c5d5add3559a379b808814' :"<p>\nTo actually fetch data from the database, one of the fetch commands must be run.\n</p>\n\n<p>\nFor loading single rows\n</p>\n<ul>\n<li><a href=\"#pdo-dataobject/load\">load</a> - this loads a single row (Chainable)\n<li><a href=\"#pdo-dataobject/reload\">reload</a> - this reloads the existing object from the database (Chainable)\n<li><a href=\"#pdo-dataobject/get\">get</a> - this loads a single row\n<li><a href=\"#pdo-dataobject/count\">count</a> - counts the number of a results a query will return.\n</ul>\n\n\n<p>\nFor sending queries\n</p>\n<ul>\n<li><a href=\"#pdo-dataobject/find\">find</a> - builds the query from the properties and called methods\n<li><a href=\"#pdo-dataobject/query\">query</a> - sends a raw query\n<li><a href=\"#pdo-dataobject/get\">get</a> - this loads a single row\n</ul>\n\n<p>\nFor fetching results\n</p>\n<ul>\n<li><a href=\"#pdo-dataobject/fetch\">fetch</a> - loads the object's propeties with the values from the database\n<li><a href=\"#pdo-dataobject/fetchAll\">fetchAll</a> - retrieves all the results in various formats\n<li><a href=\"#pdo-dataobject/fetchAllAssoc\">fetchAllAssoc</a> - very fast way to retrieve multiple rows of data.\n</ul>\n\n\n<h3>Buffered results.</h3>\n<p>\nNormally results are buffered, and find() will return the number of rows returned, however if you are fetching \na unbuffered, find() will return true, even if there are no results.\n\n</p>"
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
     html : _this._strings['3de4716711c5d5add3559a379b808814'] /* 
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
<li><a href="#pdo-dataobject/fetchAll">fetchAll</a> - retrieves all the results in various formats     
<li><a href="#pdo-dataobject/fetchAllAssoc">fetchAllAssoc</a> - very fast way to retrieve multiple rows of data.     
</ul>     
     
     
<h3>Buffered results.</h3>     
<p>     
Normally results are buffered, and find() will return the number of rows returned, however if you are fetching      
a unbuffered, find() will return true, even if there are no results.     
     
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
         code : 'PDO_DataObject::factory(\'Events\')\n    ->PDO()\n    ->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);\n \n$x = PDO_DataObject::factory(\'Events\');\n$x->find();\n\nwhile($x->fetch()) {\n    print_r($x->toArray());\n    exit;\n    \n}',
         title : _this._strings['aed714b47bb8cb9c375ef026e478f1b4'] /* Fetching with buffering turned off */,
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
