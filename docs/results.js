//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

results = new Roo.XComponent({

 _strings : {
  '9270d88c256afb00e822a804ee566ffa' :"Working with results",
  '6ed348e04674567827e341bb5b6d9d82' :"Example of using PDO_DataObjects",
  '3888d83a7e81378724a67ba22921576b' :"<p>\nafter using <a href=\"#pdo-dataobject/fetch\">fetch</a> or <a href=\"#pdo-dataobject/fetchAll\">fetchAll</a>\nyour dataobject will contiain all the values returned from the database. Other than performing an update\nor outputing the properties of the object, you can also call a number of methods\n</p>\n<ul>\n<li><a href=\"#pdo-dataobject/toArray\">toArray</a> can be used to output the data into various formats.\n<li><a href=\"#pdo-dataobject/pid\">pid</a> will fetch the value of the primary id\n<li>Group source code around the data that they relate to.\n<li>Provide a simple consistent API to access and manipulate that data.\n</ul>\n\n<p>\nPDO_DataObject is based on PEAR's <a href=\"https://pear.php.net/manual/en/package.database.db-dataobject.php\">DB_DataObject</a> and for most purposes is \nfunctionally compatibly (see <a href=\"db-dataobject-compatibility\">DB_DataObject Compatibility</a>)\n</p>\n\n<p>\nSo what does that mean in English? Well, if you look around at some of the better written PHP applications and frameworks\n out there, you will notice a common approach to using classes to wrap access to database tables or groups.\n</p>\n<p>\nPDO_DataObjects follows this pattern, In normal usage, you define one Class for each table that you use \n(you can use the genreator tools to automate this process), \n\nonce you have created the classes, and configured PDO_DataObjects you can the access the database  like this\n\n",
  'd6aa8be6ff38aa217305484e5dd38a88' :"<p>\nWhat that code does should be reasonably clear\n</p>\n<ul>\n<li>Load, and create an instance of the 'events' class\n<li>fetch the record with the primary ID = 3523\n<li>set the value of 'action' to 'testing'\n<li>perform a database update\n</ul>\n\n<p>\nMost methods in PDO_DataObjects support chaining, except on methods which are designed to be\n compatibile with DB_DataObjects.\n</p>\n\n\n"
 },

  part     :  ["docs", "results" ],
  order    : '001-results',
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
     html : _this._strings['9270d88c256afb00e822a804ee566ffa'] /* Working with results */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['3888d83a7e81378724a67ba22921576b'] /* 
     <p>     
after using <a href="#pdo-dataobject/fetch">fetch</a> or <a href="#pdo-dataobject/fetchAll">fetchAll</a>     
your dataobject will contiain all the values returned from the database. Other than performing an update     
or outputing the properties of the object, you can also call a number of methods     
</p>     
<ul>     
<li><a href="#pdo-dataobject/toArray">toArray</a> can be used to output the data into various formats.     
<li><a href="#pdo-dataobject/pid">pid</a> will fetch the value of the primary id     
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
