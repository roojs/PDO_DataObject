//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

index = new Roo.XComponent({

 _strings : {
  'c2b942b501dc222d608980c0ed40b07c' :"Fetching Results",
  '0b79795d3efc95b9976c7c5b933afce2' :"Introduction",
  '9f6e6800cfae7749eb6c486619254b9c' :"sss",
  '254f642527b45bc260048e30704edb39' :"Configuration",
  '8413aa2e38fdd078a3d96e34592d286a' :"Building Queries"
 },

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
           xns : Roo.bootstrap,
           '|xns' : 'Roo.bootstrap',
           items  : [
            {
             xtype : 'NavSidebar',
             html : _this._strings['9f6e6800cfae7749eb6c486619254b9c'] /* sss */,
             xns : Roo.bootstrap,
             '|xns' : 'Roo.bootstrap',
             items  : [
              {
               xtype : 'NavCategory',
               name : 'introduction',
               title : _this._strings['0b79795d3efc95b9976c7c5b933afce2'] /* Introduction */,
               xns : Roo.doc,
               '|xns' : 'Roo.doc'
              },
              {
               xtype : 'NavCategory',
               name : 'config',
               title : _this._strings['254f642527b45bc260048e30704edb39'] /* Configuration */,
               xns : Roo.doc,
               '|xns' : 'Roo.doc'
              },
              {
               xtype : 'NavCategory',
               name : 'build',
               title : _this._strings['8413aa2e38fdd078a3d96e34592d286a'] /* Building Queries */,
               xns : Roo.doc,
               '|xns' : 'Roo.doc'
              },
              {
               xtype : 'NavCategory',
               name : 'fetch',
               title : _this._strings['c2b942b501dc222d608980c0ed40b07c'] /* Fetching Results */,
               xns : Roo.doc,
               '|xns' : 'Roo.doc'
              },
              {
               xtype : 'NavCategory',
               name : 'introduction',
               title : _this._strings['0b79795d3efc95b9976c7c5b933afce2'] /* Introduction */,
               xns : Roo.doc,
               '|xns' : 'Roo.doc'
              },
              {
               xtype : 'NavCategory',
               name : 'introduction',
               title : _this._strings['0b79795d3efc95b9976c7c5b933afce2'] /* Introduction */,
               xns : Roo.doc,
               '|xns' : 'Roo.doc'
              }
             ]
            }
           ]
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
