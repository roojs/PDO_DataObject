//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

join = new Roo.XComponent({

 _strings : {
  'aca0253c82fea77fa2c8cbe60cd619f2' :"Joins and referenced Tables",
  'e663c4f830fd6401ebec75faaab19a65' :"Example of a links.ini with one table",
  '15bcef4620646f469603a75168da6b10' :"<p>\nWhen designing a database, often some tables are related to others - a membership table would\n contain a reference to a person's id and the group id that they are a member of. \n</p> \n<p>\nUsing the Join and Link methods, you can fetch related information easily.\n</p>\n\n\n<p>\nThe relationship information is supported using by a \"links.ini\" file. which stores the \nrelations ship between tables, maping one tables column to anothers.\n</p>\n\n<p>This \"links.ini\" file is used by the <a href=\"#pdo-dataobject/link\">link</a>,\n<a href=\"#pdo-dataobject/joinAll\">joinAll</a>, <a href=\"#pdo-dataobject/join\">join</a> and\n<a href=\"#pdo-dataobject/joinAdd\">joinAdd</a> methods\n</p>\n\n<p>Used with methods like <a href=\"#pdo-dataobject/selectAs\">selectAs</a> it is possible to very quickly\nbuild complex requests and fetch data from the database without having to type long queries.\n</p>\n",
  'a4882f671a5210f8175ffb683cdfe878' :"<p>\nIn the above example\n</p>\n<ul>\n<li>The column company_id points to the table company using column id\n<li>The column photo_id points to the table images using the column id.\n</ul>\n\n<p>\nUsing <a href=\"#pdo-dataobject/joinAll\">joinAll</a>, would modify the select query to join both these tables in the query, and select the relivant information\n</p>\n\n\n"
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
         code : '[person]\ncompany_id = company:id\nphoto_id = images:id\n\n\n',
         title : _this._strings['e663c4f830fd6401ebec75faaab19a65'] /* Example of a links.ini with one table */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Element',
     html : _this._strings['a4882f671a5210f8175ffb683cdfe878'] /* 
     <p>     
In the above example     
</p>     
<ul>     
<li>The column company_id points to the table company using column id     
<li>The column photo_id points to the table images using the column id.     
</ul>     
     
<p>     
Using <a href="#pdo-dataobject/joinAll">joinAll</a>, would modify the select query to join both these tables in the query, and select the relivant information     
</p>     
     
     

     */ ,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    }
   ]
  };  }
});
