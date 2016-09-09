//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

count = new Roo.XComponent({

 _strings : {
  '26104d42330ba2eb2f80ce7c5559da44' :"It performs a select count() request on the tables key column and returns the number of resulting rows.\n The default condition applied to the count() is a combination of the object variables and whereAdd settings. \n If the constant <B>PDO_DataObject::WHEREADD_ONLY</B> is passed in as the first parameter then only the whereAdd settings will be used.\n\n"
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
     returntype : 'int',
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
       html : _this._strings['26104d42330ba2eb2f80ce7c5559da44'] /* 
       It performs a select count() request on the tables key column and returns the number of resulting rows.       
 The default condition applied to the count() is a combination of the object variables and whereAdd settings.        
 If the constant <B>PDO_DataObject::WHEREADD_ONLY</B> is passed in as the first parameter then only the whereAdd settings will be used.       
       

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
    }
   ]
  };  }
});
