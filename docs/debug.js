//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

debug = new Roo.XComponent({

 _strings : {
  '5bd34b0eae1fda09128a49aac0b54b95' :"Debugging and error handling",
  '78822f52f1081854d2d1235070e2f57b' :"<p>\nOne of the big problems with automatically building all your SQL, is not knowing exactly what is going on. PDO_DataObjects solves this by\nhaving a simple method to turn on, and adjust how much debugging information is shown. It will show you exactly what queries are being built,\nenabling you to either copy and overide them or just see any typos.\n</p>\n\n<p>\nOne of the key issues is that at a basic level, PDO_DataObjects tries not to exposes sensitive information,\n like database passwords or settings - the default debug Level does not show any of this information.\n</p>\n\n<p>\nCalling <a href=\"#pdo-dataobject/debugLevel\">debugLevel</a> turns on and off the debugging, it also can be called with a closure which is called with all the debug information, \ntechnically it just set's the configuration value of debug, so you can actually set the debug level using the a href=\"#pdo-dataobject/config\">config</a> method \n</p>\n\n<h3>Debugging methods</h3>\n\n<ul>\n<li><a href=\"#pdo-dataobject/debugLevel\">debugLevel</a> - sets the level of debugging to show\n<li><a href=\"#pdo-dataobject/debug\">debug</a> - enables you to add debug output to your own code\n</ul>\n\n\n<h3>Error handling</h3>\n<p>\nPDO uses Exceptions throughout, It is recommended that you either catch them, or implement a global exception handler to log failure. \n</p>\n<ul>\n<li><a href=\"#pdo-dataobject/free\">raise</a> - raises an excpetion\n</ul>\n\n\n\n<h3>Memory related methods</h3>\n<p>\nin DB_DataObject, these actually had an effect on memory usage, however since result objects are no cached seperatly in PDO_DataObject,\nthese have little effect now.\n</p>\n<ul>\n<li><a href=\"#pdo-dataobject/free\">free</a> - clears the query settings, result, and removes any links (not needed any more normally)\n<li><a href=\"#pdo-dataobject/reset\">reset</a> - clears all the database schema information \n</ul>\n"
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
     html : _this._strings['78822f52f1081854d2d1235070e2f57b'] /* 
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
     
<h3>Debugging methods</h3>     
     
<ul>     
<li><a href="#pdo-dataobject/debugLevel">debugLevel</a> - sets the level of debugging to show     
<li><a href="#pdo-dataobject/debug">debug</a> - enables you to add debug output to your own code     
</ul>     
     
     
<h3>Error handling</h3>     
<p>     
PDO uses Exceptions throughout, It is recommended that you either catch them, or implement a global exception handler to log failure.      
</p>     
<ul>     
<li><a href="#pdo-dataobject/free">raise</a> - raises an excpetion     
</ul>     
     
     
     
<h3>Memory related methods</h3>     
<p>     
in DB_DataObject, these actually had an effect on memory usage, however since result objects are no cached seperatly in PDO_DataObject,     
these have little effect now.     
</p>     
<ul>     
<li><a href="#pdo-dataobject/free">free</a> - clears the query settings, result, and removes any links (not needed any more normally)     
<li><a href="#pdo-dataobject/reset">reset</a> - clears all the database schema information      
</ul>     

     */ ,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    }
   ]
  };  }
});
