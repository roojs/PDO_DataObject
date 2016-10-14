//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

creating-dataobjects = new Roo.XComponent({

 _strings : {
  '27acce31dc1956874cd77b52da134506' :"An example ini file for use with createTables.php",
  'ff2469a7973af3013351239b0ec94efe' :"<p>\nRather than using the standard createTables, code, you can easily create your own\n</p>",
  '2ee868dc71d76b74e5af6c689ef9ffe0' :"Creating DataObjects",
  '2314287293fbe38854242eac7f34855a' :"<p>\nThis will result in the creation of an 'ini' file containing the database structure.\n</p>\n",
  'ce0ef332536ddbe0f2d91179a923b3b0' :"<p>\nIt will also create skeleton DataObjects. \n</p>\n<p>\nThese files can be updated to match any changes you make to the database schema,\n if you run the command again and leave the comments in place.\n</p>",
  'd06bda29ade3b12c79092ea8e173dbc0' :"Creating schema and Base DataObjects",
  '6edce050ce6cb982c46e228782dbd8ed' :"<p>\nOnce the classes have been created, you can add methods below the ###END_AUTOCODE that \nare relivant for your project.\n</p>\n<p>\nThe Generator contains many features to alter what is generated at this stage.\n</p>",
  'd438a0af0c2a3eb34111e45e615fe4a7' :"<p>\nThere are two components that are needed before you can start using DataObjects in your code\n\n<ul>\n<li>a schema file describing the database\n<li>PHP classes representing each of the tables\n</ul>\n<p>\nBoth of these can be created using the tools included with PDO_DataObjects, or you can use the code in \nthe Generator to write the schema files when a page is requested, and cache the results.\n\n<p>\nFor basic usage, use the file PDO/DataObject/createTables.php to create your schema file\n ",
  '789953c34df03c98c141ec54e226becd' :"Example .ini file",
  '5f31614f3d53f25fd4adadc06738bf59' :"Example Generated DataObject"
 },

  part     :  ["docs", "creating-dataobjects" ],
  order    : '001-creating-dataobjects',
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
     html : _this._strings['2ee868dc71d76b74e5af6c689ef9ffe0'] /* Creating DataObjects */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['d438a0af0c2a3eb34111e45e615fe4a7'] /* 
     <p>     
There are two components that are needed before you can start using DataObjects in your code     
     
<ul>     
<li>a schema file describing the database     
<li>PHP classes representing each of the tables     
</ul>     
<p>     
Both of these can be created using the tools included with PDO_DataObjects, or you can use the code in      
the Generator to write the schema files when a page is requested, and cache the results.     
     
<p>     
For basic usage, use the file PDO/DataObject/createTables.php to create your schema file     
 
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
         code : '#/usr/bin/php  PDO/DataObjects/createTables.php  your_ini_file.ini',
         title : _this._strings['d06bda29ade3b12c79092ea8e173dbc0'] /* Creating schema and Base DataObjects */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Element',
     html : _this._strings['2314287293fbe38854242eac7f34855a'] /* 
     <p>     
This will result in the creation of an 'ini' file containing the database structure.     
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
         code : '[group]\nid = 129\nname = 130 \ngrp_owner = 129 \nofficial = 130 \nstreet = 130 \npostcode = 130\ncity = 130 \nhomepage = 130 \nemail = 130 \nextra = 130 \n\n[group__keys]\nid = N',
         title : _this._strings['789953c34df03c98c141ec54e226becd'] /* Example .ini file */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Element',
     html : _this._strings['ce0ef332536ddbe0f2d91179a923b3b0'] /* 
     <p>     
It will also create skeleton DataObjects.      
</p>     
<p>     
These files can be updated to match any changes you make to the database schema,     
 if you run the command again and leave the comments in place.     
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
         code : '/*\n* Table Definition for group\n*/\n\nclass_exists(\'PDO_DataObject\') ? \'\' : require_once \'PDO/DataObject.php\';\n\nclass DataObjects_Group extends PDO_DataObject {\n\n    ###START_AUTOCODE\n    /* the code below is auto generated do not remove the above tag */\n\n    var $__table=\'group\';                             // table name\n    var $id;                              // int primary_key\n    var $name;                            // string\n    var $grp_owner;                       // int\n    var $official;                        // string\n    var $street;                          // string\n    var $postcode;                        // string\n    var $city;                            // string\n    var $homepage;                        // string\n    var $email;                           // string\n    var $extra;                           // blob\n\n\n    /* the code above is auto generated do not remove the tag below */\n    ###END_AUTOCODE\n}',
         title : _this._strings['5f31614f3d53f25fd4adadc06738bf59'] /* Example Generated DataObject */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Element',
     html : _this._strings['6edce050ce6cb982c46e228782dbd8ed'] /* 
     <p>     
Once the classes have been created, you can add methods below the ###END_AUTOCODE that      
are relivant for your project.     
</p>     
<p>     
The Generator contains many features to alter what is generated at this stage.     
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
         code : '[PDO_DataObject]\n\ndatabase = mysql://user:pass@localhost/testdb\nschema_location = /path/to/my/DataObjects\n\n ',
         title : _this._strings['27acce31dc1956874cd77b52da134506'] /* An example ini file for use with createTables.php */,
         xns : Roo.doc,
         '|xns' : 'Roo.doc'
        }
       ]
      }
     ]
    },
    {
     xtype : 'Element',
     html : _this._strings['ff2469a7973af3013351239b0ec94efe'] /* 
     <p>     
Rather than using the standard createTables, code, you can easily create your own     
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
         code : '[PDO_DataObject]\n\ndatabase = mysql://user:pass@localhost/testdb\nschema_location = /path/to/my/DataObjects\n\n ',
         title : _this._strings['27acce31dc1956874cd77b52da134506'] /* An example ini file for use with createTables.php */,
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
