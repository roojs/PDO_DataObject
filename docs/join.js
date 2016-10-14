//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

join = new Roo.XComponent({

 _strings : {
  'aca0253c82fea77fa2c8cbe60cd619f2' :"Joins and referenced Tables",
  '6ed348e04674567827e341bb5b6d9d82' :"Example of using PDO_DataObjects",
  '15bcef4620646f469603a75168da6b10' :"<p>\nWhen designing a database, often some tables are related to others - a membership table would\n contain a reference to a person's id and the group id that they are a member of. \n</p> \n<p>\nUsing the Join and Link methods, you can fetch related information easily.\n</p>\n\n\n<p>\nThe relationship information is supported using by a \"links.ini\" file. which stores the \nrelations ship between tables, maping one tables column to anothers.\n</p>\n\n<p>This \"links.ini\" file is used by the <a href=\"#pdo-dataobject/link\">link</a>,\n<a href=\"#pdo-dataobject/joinAll\">joinAll</a>, <a href=\"#pdo-dataobject/join\">join</a> and\n<a href=\"#pdo-dataobject/joinAdd\">joinAdd</a> methods\n</p>\n\n<p>Used with methods like <a href=\"#pdo-dataobject/selectAs\">selectAs</a> it is possible to very quickly\nbuild complex requests and fetch data from the database without having to type long queries.\n</p>\n",
  'd6aa8be6ff38aa217305484e5dd38a88' :"<p>\nWhat that code does should be reasonably clear\n</p>\n<ul>\n<li>Load, and create an instance of the 'events' class\n<li>fetch the record with the primary ID = 3523\n<li>set the value of 'action' to 'testing'\n<li>perform a database update\n</ul>\n\n<p>\nMost methods in PDO_DataObjects support chaining, except on methods which are designed to be\n compatibile with DB_DataObjects.\n</p>\n\n\n"
 },

  part     :  ["docs", "join" ],
  order    : '001-join',
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
     html : _this._strings['aca0253c82fea77fa2c8cbe60cd619f2'] /* Joins and referenced Tables */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['15bcef4620646f469603a75168da6b10'] /* 
     <p>     
When designing a database, often some tables are related to others - a membership table would     
 contain a reference to a person's id and the group id that they are a member of.      
</p>      
<p>     
Using the Join and Link methods, you can fetch related information easily.     
</p>     
     
     
<p>     
The relationship information is supported using by a "links.ini" file. which stores the      
relations ship between tables, maping one tables column to anothers.     
</p>     
     
<p>This "links.ini" file is used by the <a href="#pdo-dataobject/link">link</a>,     
<a href="#pdo-dataobject/joinAll">joinAll</a>, <a href="#pdo-dataobject/join">join</a> and     
<a href="#pdo-dataobject/joinAdd">joinAdd</a> methods     
</p>     
     
<p>Used with methods like <a href="#pdo-dataobject/selectAs">selectAs</a> it is possible to very quickly     
build complex requests and fetch data from the database without having to type long queries.     
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
         code : 'person]\ncompany_id = company:id\nphoto_id = images:id\n\n\n',
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
