//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

debug = new Roo.XComponent({

 _strings : {
  '5bd34b0eae1fda09128a49aac0b54b95' :"Debugging and error handling",
  '6ed348e04674567827e341bb5b6d9d82' :"Example of using PDO_DataObjects",
  'ac246f757ff67582eced6cead1da3b13' :"<p>\nOne of the big problems with automatically building all your SQL, is not knowing exactly what is going on. PDO_DataObjects solves this by\nhaving a simple method to turn on, and adjust how much debugging information is shown. It will show you exactly what queries are being built,\nenabling you to either copy and overide them or just see any typos.\n</p>\n\n<p>\nOne of the key issues is that at a basic level, PDO_DataObjects tries not to exposes sensitive information,\n like database passwords or settings - the default debug Level does not show any of this information.\n</p>\n\n<p>\nCalling <a href=\"#pdo-dataobject/debugLevel\">debugLevel</a> turns on and off the debugging, it also can be called with a closure which is called with all the debug information, \ntechnically it just set's the configuration value of debug, so you can actually set the debug level using the a href=\"#pdo-dataobject/config\">config</a> method \n</p>\n\n<h3>Debugging methods</a>\n\n<ul>\n<li><a href=\"#pdo-dataobject/debugLevel\">debugLevel</a> - sets the level of debugging to show\n<li><a href=\"#pdo-dataobject/debug\">debug</a> - enables you to add debug output to your own code\n<li>Provide a simple consistent API to access and manipulate that data.\n</ul>\n\n<p>\nPDO_DataObject is based on PEAR's <a href=\"https://pear.php.net/manual/en/package.database.db-dataobject.php\">DB_DataObject</a> and for most purposes is \nfunctionally compatibly (see <a href=\"db-dataobject-compatibility\">DB_DataObject Compatibility</a>)\n</p>\n\n<p>\nSo what does that mean in English? Well, if you look around at some of the better written PHP applications and frameworks\n out there, you will notice a common approach to using classes to wrap access to database tables or groups.\n</p>\n<p>\nPDO_DataObjects follows this pattern, In normal usage, you define one Class for each table that you use \n(you can use the genreator tools to automate this process), \n\nonce you have created the classes, and configured PDO_DataObjects you can the access the database  like this\n\n",
  'd6aa8be6ff38aa217305484e5dd38a88' :"<p>\nWhat that code does should be reasonably clear\n</p>\n<ul>\n<li>Load, and create an instance of the 'events' class\n<li>fetch the record with the primary ID = 3523\n<li>set the value of 'action' to 'testing'\n<li>perform a database update\n</ul>\n\n<p>\nMost methods in PDO_DataObjects support chaining, except on methods which are designed to be\n compatibile with DB_DataObjects.\n</p>\n\n\n"
 },

  part     :  ["docs", "debug" ],
  order    : '001-debug',
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
     html : _this._strings['5bd34b0eae1fda09128a49aac0b54b95'] /* Debugging and error handling */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['ac246f757ff67582eced6cead1da3b13'] /* 
     <p>     
One of the big problems with automatically building all your SQL, is not knowing exactly what is going on. PDO_DataObjects solves this by     
having a simple method to turn on, and adjust how much debugging information is shown. It will show you exactly what queries are being built,     
enabling you to either copy and overide them or just see any typos.     
</p>     
     
<p>     
One of the key issues is that at a basic level, PDO_DataObjects tries not to exposes sensitive information,     
 like database passwords or settings - the default debug Level does not show any of this information.     
</p>     
     
<p>     
Calling <a href="#pdo-dataobject/debugLevel">debugLevel</a> turns on and off the debugging, it also can be called with a closure which is called with all the debug information,      
technically it just set's the configuration value of debug, so you can actually set the debug level using the a href="#pdo-dataobject/config">config</a> method      
</p>     
     
<h3>Debugging methods</a>     
     
<ul>     
<li><a href="#pdo-dataobject/debugLevel">debugLevel</a> - sets the level of debugging to show     
<li><a href="#pdo-dataobject/debug">debug</a> - enables you to add debug output to your own code     
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
