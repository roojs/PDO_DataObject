//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

find = new Roo.XComponent({

 _strings : {
  '2098bf2d5f7c8bfc302286fccad39c63' :" for example\n\n $object = new mytable();\n $object->ID = 1;\n $object->find();\n\n\n will set $object->N to number of rows, and expects next command to fetch rows\n will return $object->N\n\n if an error occurs $object->N will be set to false and return value will also be false;\n if numRows is not supported it will return true.\n \n"
 },

  part     :  ["pdo-dataobject", "find" ],
  order    : '001-find',
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
   name : 'find',
   purpose : ' find results, either normal or crosstable',
   stype : 'function',
   xns : Roo.doc,
   '|xns' : 'Roo.doc',
   items  : [
    {
     xtype : 'Synopsis',
     is_static : false,
     memberof : 'PDO_DataObject',
     name : 'find',
     returndesc : '(number of rows returned, or true if numRows fetching is not supported)',
     returntype : 'mixed',
     xns : Roo.doc,
     '|xns' : 'Roo.doc',
     items  : [
      {
       xtype : 'Param',
       desc : '$n',
       is_optional : false,
       name : '$n',
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
       html : _this._strings['2098bf2d5f7c8bfc302286fccad39c63'] /* 
        for example       
       
 $object = new mytable();       
 $object->ID = 1;       
 $object->find();       
       
       
 will set $object->N to number of rows, and expects next command to fetch rows       
 will return $object->N       
       
 if an error occurs $object->N will be set to false and return value will also be false;       
 if numRows is not supported it will return true.       
        

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
     stype : 'return',
     xns : Roo.doc,
     '|xns' : 'Roo.doc'
    },
    {
     xtype : 'Section',
     stype : 'example',
     xns : Roo.doc,
     '|xns' : 'Roo.doc'
    }
   ]
  };  }
});
