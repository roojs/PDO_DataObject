//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

count = new Roo.XComponent({

 _strings : {
  '27119804928acfc9a5ebdf43bcc918bd' :"It performs a select count() request on the tables key column and returns the number of resulting rows.\n The default condition applied to the count() is a combination of the object variables and whereAdd settings. \n If the constant <B>PDO_DataObject::WHEREADD_ONLY</B> is passed in as the first (or second) parameter then only the whereAdd settings will be used.\n\n"
 },

  part     :  ["pdo-dataobject", "count" ],
  order    : '001-count',
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
   xtype : 'Entry',
   name : ' count',
   purpose : 'Perform a SELECT COUNT(*) request using critera',
   stype : 'function',
   xns : Roo.doc,
   '|xns' : 'Roo.doc',
   items  : [
    {
     xtype : 'Synopsis',
     name : '$do->count',
     returntype : 'int|false',
     xns : Roo.doc,
     '|xns' : 'Roo.doc',
     items  : [
      {
       xtype : 'Param',
       desc : 'by default count will count on the primary key, if you need to count something else, if you just say DISTINCT, it will count the primiary key prefixed with distinct, or put your own value in (don\'t forget to escape it if necessary)\n\n',
       is_optional : true,
       name : '$countWhat|$whereAddOnly',
       type : 'string|boolean',
       xns : Roo.doc,
       '|xns' : 'Roo.doc'
      },
      {
       xtype : 'Param',
       desc : 'use only the whereAdd conditions (by default, count will only use both the object settings and the whereAdd conditions),\nyou can use the constant <B>PDO_DataObject::WHERE_ADD_ONLY</B> to make the code clearer',
       is_optional : true,
       name : '$whereAddOnly',
       type : 'boolean',
       xns : Roo.doc,
       '|xns' : 'Roo.doc'
      }
     ]
    },
    {
     xtype : 'Section',
     stype : 'desc',
     xns : Roo.doc,
     '|xns' : 'Roo.doc',
     items  : [
      {
       xtype : 'Para',
       html : _this._strings['27119804928acfc9a5ebdf43bcc918bd'] /* 
       It performs a select count() request on the tables key column and returns the number of resulting rows.       
 The default condition applied to the count() is a combination of the object variables and whereAdd settings.        
 If the constant <B>PDO_DataObject::WHEREADD_ONLY</B> is passed in as the first (or second) parameter then only the whereAdd settings will be used.       
       

       */ ,
       xns : Roo.doc,
       '|xns' : 'Roo.doc'
      }
     ]
    },
    {
     xtype : 'Section',
     stype : 'parameter',
     xns : Roo.doc,
     '|xns' : 'Roo.doc'
    },
    {
     xtype : 'Section',
     stype : 'note',
     xns : Roo.doc,
     '|xns' : 'Roo.doc'
    },
    {
     xtype : 'Section',
     stype : 'example',
     xns : Roo.doc,
     '|xns' : 'Roo.doc',
     items  : [
      {
       xtype : 'Example',
       code : '/* using property values */\n$person = new DataObjects_Person;\n$person->name  = \"test\"\n$total = $person->count();\necho \"There are {$total} people with a name like test\";',
       lang : 'php',
       xns : Roo.doc,
       '|xns' : 'Roo.doc'
      }
     ]
    }
   ]
  };  }
});
