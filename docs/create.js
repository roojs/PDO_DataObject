//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

create = new Roo.XComponent({

 _strings : {
  '72caaab8039d8b75a86f805743b3716c' :"Creating instances of DataObjects",
  '6ed348e04674567827e341bb5b6d9d82' :"Example of using PDO_DataObjects",
  'a2a4c78ae5a110e9467fe679033c6d0b' :"<p>\nPDO_DataObjects was designed to be used with the factory method by default.\nWhile you can just create an instance of your child class, factory offers a number of advantages.\n</p>\n<ul>\n<li>Support for modular development, where table references come from multiple locations.\n<li>Different modules can add features to existing tables \n<li>Table aliasing, so you can rename tables, and alias the names\n</ul>\n\n"
 },

  part     :  ["docs", "create" ],
  order    : '001-create',
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
     html : _this._strings['72caaab8039d8b75a86f805743b3716c'] /* Creating instances of DataObjects */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['a2a4c78ae5a110e9467fe679033c6d0b'] /* 
     <p>     
PDO_DataObjects was designed to be used with the factory method by default.     
While you can just create an instance of your child class, factory offers a number of advantages.     
</p>     
<ul>     
<li>Support for modular development, where table references come from multiple locations.     
<li>Different modules can add features to existing tables      
<li>Table aliasing, so you can rename tables, and alias the names     
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
         code : '\n\n\n$e = PDO_DataObject::factory(\'Events\')\n\n// create a new instance (or call it from a method in your events object.\n$e->factorySelf()\n\n// create a \n\n$e = new DataObject_Events();\n',
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
