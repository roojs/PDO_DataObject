//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

index = new Roo.XComponent({

 _strings : {
  '150e558f4884668e5a5b45a8410b5d2f' :"Introspection - Database and table schema information",
  'aca0253c82fea77fa2c8cbe60cd619f2' :"Joins and referenced Tables",
  '7c83fdebb29c28504c91870e03666cd8' :"Configuration and Database DSN",
  'c2b942b501dc222d608980c0ed40b07c' :"Fetching Results",
  '0b79795d3efc95b9976c7c5b933afce2' :"Introduction",
  '2ee868dc71d76b74e5af6c689ef9ffe0' :"Creating DataObjects",
  '1d866b2915d91065ba174a39994bab6f' :"Creating an instance",
  '556315ce9fbee2dfda70f8a91138d2b3' :"Create, Update and Delete",
  '5e434159c315edc6ae8d816255bffaec' :"Debugging & Error Handling",
  '2c918a06bae30fdcf78f8810894a67af' :"Working with Results",
  '8413aa2e38fdd078a3d96e34592d286a' :"Building Queries",
  'b73ec9912d761600946fab487e0de1cc' :"DB_DataObject compatibility"
 },

  part     :  ["docs", "index" ],
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
     autohide : true,
     brand : 'PDO_DataObject manual',
     desktopCenter : true,
     main : true,
     position : 'fixed-top',
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Row',
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap',
     items  : [
      {
       xtype : 'Column',
       resize : function() { 
       
           this.el.setHeight(Roo.lib.Dom.getViewHeight()- 100);
           
       },
       sm : 3,
       style : 'height: 500px;\n    overflow-y: scroll; overflow-x:hidden;\n    margin-top:80px;',
       listeners : {
        render : function (_self)
         {
             
             this.resize();
             window.addEventListener("resize", function() { _self.resize()  } );
             var el = this;
             
             var walk = function(node) {
                 if (node['|xns'] == 'Roo.doc') {
                     node.xns = Roo.doc;
                 }
                  if (node['|xns'] == 'Roo.bootstrap') {
                     node.xns = Roo.bootstrap;
                 }
                 Roo.each(node.items || [],walk);
             
             }
             
             var build = function(cat, tnode)
             {
                 if (typeof(Roo.doc.NavCategory.registry[cat]) == 'undefined') {
                     Roo.log("skip category - no navcategory item : " + cat );
                     return;
                 }
                 
                 walk(tnode);
         
                 var node = {
                     name: 'category-' + cat,
                     parent: {el : Roo.doc.NavCategory.registry[cat]},
                     title: "",
                     permname: "",
                     modOrder: "001",
                 };
                 node._tree = (function(){
                     var _this = this;
                     var MODULE = this;
                     return tnode
                 }).createDelegate(node);
         
                 var new_comp = new Roo.XComponent(node);
          
                 new_comp.render();
                 
             
             }
             
             
         
             Roo.Ajax.request({ 
                     url: baseURL + 'categories.json',
                     method: 'GET', 
                     success: function(response, opts) { 
                         var res = Roo.decode(response.responseText); // needs error checking
                         Roo.log(res);
                         for(var k in res) {
                             build(k, res[k]);
                         }
                         
                     },
                     failure : function() {
                         // show error.
                     },
                     scope : this
                 });
         }
       },
       xns : Roo.bootstrap,
       '|xns' : 'Roo.bootstrap',
       items  : [
        {
         xtype : 'NavSidebar',
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
           name : 'creating-dataobjects',
           title : _this._strings['2ee868dc71d76b74e5af6c689ef9ffe0'] /* Creating DataObjects */,
           xns : Roo.doc,
           '|xns' : 'Roo.doc'
          },
          {
           xtype : 'NavCategory',
           name : 'config',
           title : _this._strings['7c83fdebb29c28504c91870e03666cd8'] /* Configuration and Database DSN */,
           xns : Roo.doc,
           '|xns' : 'Roo.doc'
          },
          {
           xtype : 'NavCategory',
           name : 'create',
           title : _this._strings['1d866b2915d91065ba174a39994bab6f'] /* Creating an instance */,
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
           name : 'join',
           title : _this._strings['aca0253c82fea77fa2c8cbe60cd619f2'] /* Joins and referenced Tables */,
           xns : Roo.doc,
           '|xns' : 'Roo.doc'
          },
          {
           xtype : 'NavCategory',
           name : 'results',
           title : _this._strings['2c918a06bae30fdcf78f8810894a67af'] /* Working with Results */,
           xns : Roo.doc,
           '|xns' : 'Roo.doc'
          },
          {
           xtype : 'NavCategory',
           name : 'crud',
           title : _this._strings['556315ce9fbee2dfda70f8a91138d2b3'] /* Create, Update and Delete */,
           xns : Roo.doc,
           '|xns' : 'Roo.doc'
          },
          {
           xtype : 'NavCategory',
           name : 'introspect',
           title : _this._strings['150e558f4884668e5a5b45a8410b5d2f'] /* Introspection - Database and table schema information */,
           xns : Roo.doc,
           '|xns' : 'Roo.doc'
          },
          {
           xtype : 'NavCategory',
           name : 'debug',
           title : _this._strings['5e434159c315edc6ae8d816255bffaec'] /* Debugging & Error Handling */,
           xns : Roo.doc,
           '|xns' : 'Roo.doc'
          },
          {
           xtype : 'NavCategory',
           name : 'db-dataobject-compatibility',
           title : _this._strings['b73ec9912d761600946fab487e0de1cc'] /* DB_DataObject compatibility */,
           xns : Roo.doc,
           '|xns' : 'Roo.doc'
          }
         ]
        }
       ]
      },
      {
       xtype : 'Column',
       load : function(path) { 
       
           var el = this;
           this.el.dom.innerHTML = '';
           
           var walk = function(node) {
               if (node['|xns'] == 'Roo.doc' || node['$ xns'] == 'Roo.doc') {
                   node.xns = Roo.doc;
               }
               if (node['|xns'] == 'Roo.bootstrap' || node['$ xns'] == 'Roo.bootstrap' ) {
                   node.xns = Roo.bootstrap;
               }
               // builder uses very different format now..
               for(var k in node) {
                   if (k.match(/\s+/)) { 
                       var kk = k.split(/\s+/).pop();
                       if (kk !='xns' && kk != k) {
                           Roo.log('set : ' + kk);
                           node[kk] = node[k];
                       }
                   }
               }
               Roo.log(node);
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
               var new_comp = new Roo.XComponent(node);
               Roo.log(new_comp);
               new_comp.render();
               
           
           }
           
           
       
           Roo.Ajax.request({ 
                   url: baseURL + path + '.bjs',
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
       },
       sm : 9,
       listeners : {
        render : function (_self)
         {
                 window.onhashchange = function() {
                     //Roo.log('hashchange?');
                     _self.load(window.location.hash.substring(1));
                 };
                 
                 
                 if (window.location.hash == '') {
                     window.location.hash = '#introduction';
                     
                 } else {
                     _self.load(window.location.hash.substring(1));
                 }
         }
       },
       xns : Roo.bootstrap,
       '|xns' : 'Roo.bootstrap'
      }
     ]
    },
    {
     xtype : 'Container',
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap',
     items  : [
      {
       xtype : 'Container',
       xns : Roo.bootstrap,
       '|xns' : 'Roo.bootstrap'
      }
     ]
    }
   ]
  };  }
});
