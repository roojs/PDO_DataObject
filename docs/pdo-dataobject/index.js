//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

index = new Roo.XComponent({



  part     :  ["pdo-dataobject", "index" ],
  order    : '001-index',
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
   brand : 'PDO_DataObject Documentation',
   xns : Roo.bootstrap,
   '|xns' : 'Roo.bootstrap',
   items  : [
    {
     xtype : 'NavHeaderbar',
     brand : 'PDO_DataObject manual',
     desktopCenter : true,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Container',
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap',
     items  : [
      {
       xtype : 'Container',
       xns : Roo.bootstrap,
       '|xns' : 'Roo.bootstrap',
       items  : [
        {
         xtype : 'Row',
         xns : Roo.bootstrap,
         '|xns' : 'Roo.bootstrap',
         items  : [
          {
           xtype : 'Column',
           sm : 2,
           listeners : {
            render : function (_self)
             {
                 Roo.log('render index');
             }
           },
           xns : Roo.bootstrap,
           '|xns' : 'Roo.bootstrap'
          },
          {
           xtype : 'Column',
           sm : 10,
           listeners : {
            render : function (_self)
             {
             
                 // let's try and load some content.
                 
                 var baseURL = window.location.pathname.replace(/index\.html$/, '');
                 
                 // what to load -- use window.location.hash ??
                 
                 var el = this;
                 
                 var walk = function(node) {
                     if (node['|xns'] == 'Roo.doc') {
                         node.xns = Roo.doc;
                     }
                     Roo.each(node.items || [],walk);
                 
                 }
                 
                 var build = function(node)
                 {
                     walk(node);
                     var items = typeof(node.items) == 'undefined' ? false : node.items;
                     delete node.items;
             
                     node._tree = (function(){
                         var _this = this;
                         var MODULE = this;
                         return items[0]
                     }).createDelegate(node);
                     node.parent = { el : el };
                     new_comp = new Roo.XComponent(node);
                     Roo.log(new_comp);
                     new_comp.render();
                     
                 
                 }
                 
                 
             
                 Roo.Ajax.request({ 
                         url: baseURL + 'pdo-dataobject/autoJoin.bjs',
                         method: 'GET', 
                         success: function(response, opts) { 
                             var res = Roo.decode(response.responseText); // needs error checking
                             Roo.log(res);
                             build(res);
                             
                             
                         },
                         failure : function() {
                             // show error.
                         },
                         scope : this
                     });
             
             }
           },
           xns : Roo.bootstrap,
           '|xns' : 'Roo.bootstrap'
          }
         ]
        }
       ]
      }
     ]
    }
   ]
  };  }
});
