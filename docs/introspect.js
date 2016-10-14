//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

introspect = new Roo.XComponent({

 _strings : {
  '3160871894589120db13fb8399c16735' :"Introspecting the database and table schema Information",
  'd12417572d33fde8d22c6ceb832f2d74' :"<p>\nFor PDO_DataObject to work, it has to know a considerable amount about the database it is working with.\nMost of this is done once, and cached in a file. These methods allow you to retrieve that information\n</p>\n\n<p>\nSome of these methods can be overridden so that you can use DataObjects without ini files.\n<ul>\n<li><a href=\"#pdo-dataobject/databaseNickname\">databaseNickname</a> - set or retrieve the nickname for the database\n<li><a href=\"#pdo-dataobject/databaseStructure\">databaseStructure</a> - get information about the database or table structure\n\n<li><a href=\"#pdo-dataobject/keys\">keys</a> - returns a list of the primary and unique keys in the database\n<li><a href=\"#pdo-dataobject/sequenceKey\">sequenceKey</a> - returns information on the primary key (and sequence method)\n<li><a href=\"#pdo-dataobject/tableColumns\">tableColumns</a> - returns an array of columns in the database\n<li><a href=\"#pdo-dataobject/tableColumns\">tableName</a> - returns the real name of the table\n\n<li><a href=\"#pdo-dataobject/generator\">generator</a> - create an instance of the generator - used with proxy to query the databases structure\n<li><a href=\"#pdo-dataobject/table\">table</a> - table - depricated just throws an error. (there for compatibility)\n\n<li>Provide a simple consistent API to access and manipulate that data.\n</ul>\n "
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
     html : _this._strings['d12417572d33fde8d22c6ceb832f2d74'] /* 
     <p>     
For PDO_DataObject to work, it has to know a considerable amount about the database it is working with.     
Most of this is done once, and cached in a file. These methods allow you to retrieve that information     
</p>     
     
<p>     
Some of these methods can be overridden so that you can use DataObjects without ini files.     
<ul>     
<li><a href="#pdo-dataobject/databaseNickname">databaseNickname</a> - set or retrieve the nickname for the database     
<li><a href="#pdo-dataobject/databaseStructure">databaseStructure</a> - get information about the database or table structure     
     
<li><a href="#pdo-dataobject/keys">keys</a> - returns a list of the primary and unique keys in the database     
<li><a href="#pdo-dataobject/sequenceKey">sequenceKey</a> - returns information on the primary key (and sequence method)     
<li><a href="#pdo-dataobject/tableColumns">tableColumns</a> - returns an array of columns in the database     
<li><a href="#pdo-dataobject/tableColumns">tableName</a> - returns the real name of the table     
     
<li><a href="#pdo-dataobject/generator">generator</a> - create an instance of the generator - used with proxy to query the databases structure     
<li><a href="#pdo-dataobject/table">table</a> - table - depricated just throws an error. (there for compatibility)     
     
<li>Provide a simple consistent API to access and manipulate that data.     
</ul>     
 
     */ ,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    }
   ]
  };  }
});
