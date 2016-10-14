//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

build = new Roo.XComponent({

 _strings : {
  '9bf38a80987bf15dce35ca41b3a34f35' :"Setting Properties to generate a query",
  'af8a4bf8e4b692982022a39295f4b176' :"<p>\nUsing the 'set' method will also do some basic validation.\n</p>\n<p>\nMost of the method names match the SQL standard names, and build up query.\n</p>\n\n\n",
  '7dd6d86a2c8648fe541335db76a0cabb' :"<p>\nThere are two ways that queries are built in PDO_DataObjects\n</p>\n<ul>\n<li>Properties of the object, that match the column names in the table\n<li>Calling the query modification methods.\n</ul>\n\n<p>\nBy just assigning values to the DataObject, then running fetchAll() or find/fetch() the query will be built \nbased on the values you set.\n</p>\n\n",
  '8413aa2e38fdd078a3d96e34592d286a' :"Building Queries"
 },

  part     :  ["docs", "build" ],
  order    : '001-build',
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
     html : _this._strings['8413aa2e38fdd078a3d96e34592d286a'] /* Building Queries */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['7dd6d86a2c8648fe541335db76a0cabb'] /* 
     <p>     
There are two ways that queries are built in PDO_DataObjects     
</p>     
<ul>     
<li>Properties of the object, that match the column names in the table     
<li>Calling the query modification methods.     
</ul>     
     
<p>     
By just assigning values to the DataObject, then running fetchAll() or find/fetch() the query will be built      
based on the values you set.     
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
         code : '\n\n$company = PDO_DataObject::factory(\'Companies\');\n$company->comptype = \'CONSULTANT\';\n$company->limit(1);\n$company->find(true);\n\n ',
         output : '\nWill run the following Query\n\nSELECT *\n FROM   Companies   \n WHERE ( (Companies.comptype  = \'CONSULTANT\') ) \n LIMIT  1\n \n \n',
         outputlang : 'sql',
         title : _this._strings['9bf38a80987bf15dce35ca41b3a34f35'] /* Setting Properties to generate a query */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Element',
     html : _this._strings['af8a4bf8e4b692982022a39295f4b176'] /* 
     <p>     
Using the 'set' method will also do some basic validation.     
</p>     
<p>     
Most of the method names match the SQL standard names, and build up query.     
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
         code : '$numbers = array(1,2,3,4,5);\n$company = PDO_DataObject::factory(\'Companies\');\n$company->whereIn(\'id\', $numbers, \'int\');\necho \"resulting query: \" . $company->toSelectSQL();\n',
         output : '\nWill run the following Query\n\nSELECT *\n FROM   Companies   \n WHERE ( (Companies.comptype  = \'CONSULTANT\') ) \n LIMIT  1\n \n \n',
         outputlang : 'sql',
         title : _this._strings['9bf38a80987bf15dce35ca41b3a34f35'] /* Setting Properties to generate a query */,
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
