//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

introduction = new Roo.XComponent({

 _strings : {
  '0b79795d3efc95b9976c7c5b933afce2' :"Introduction",
  '6ed348e04674567827e341bb5b6d9d82' :"Example of using PDO_DataObjects",
  'cca65c5b03db8ac0d31402bef3188f65' :"<p>\nPDO_DataObject is a SQL Builder and Data Modeling Layer built on top of PHP's PDO library. Its main purpose is to\n</p>\n<ul>\n<li>Build SQL and execute statements based on the objects variables.\n<li>Group source code around the data that they relate to.\n<li>Provide a simple consistent API to access and manipulate that data.\n</ul>\n\n<p>\nPDO_DataObject is based on PEAR's <a href=\"https://pear.php.net/manual/en/package.database.db-dataobject.php\">DB_DataObject</a> and for most purposes is \nfunctionally compatibly (see <a href=\"db-dataobject-compatibility\">DB_DataObject Compatibility</a>)\n</p>\n\n<p>\nSo what does that mean in English? Well, if you look around at some of the better written PHP applications and frameworks\n out there, you will notice a common approach to using classes to wrap access to database tables or groups.\n</p>\n<p>\nPDO_DataObjects follows this pattern, In normal usage, you define one Class for each table that you use \n(you can use the genreator tools to automate this process), \n\nonce you have created the classes, and configured PDO_DataObjects you can the access the database  like this\n\n"
 },

  part     :  ["docs", "introduction" ],
  order    : '001-introduction',
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
     html : _this._strings['0b79795d3efc95b9976c7c5b933afce2'] /* Introduction */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['cca65c5b03db8ac0d31402bef3188f65'] /* 
     <p>     
PDO_DataObject is a SQL Builder and Data Modeling Layer built on top of PHP's PDO library. Its main purpose is to     
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
         code : ' \nPDO_DataObject::factory(\'Events\')\n    ->load(3523)\n    ->set([\'action\' => \"testing\" ])\n    ->save();\n',
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
