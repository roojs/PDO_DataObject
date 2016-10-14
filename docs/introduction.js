//<script type="text/javascript">

// Auto generated file - created by app.Builder.js- do not edit directly (at present!)

introduction = new Roo.XComponent({

 _strings : {
  'efb07d8fb9f0f9705e4c81374a5a64ad' :"A Classic Data Object or Container",
  '0b79795d3efc95b9976c7c5b933afce2' :"Introduction",
  '9954b604316367d52a9446e9f81a91ed' :"<p>\nPDO_DataObject is a SQL Builder and Data Modeling Layer built on top of PHP's PDO library. Its main purpose is to\n</p>\n<ul>\n<li>Build SQL and execute statements based on the objects variables.\n<li>Group source code around the data that they relate to.\n<li>Provide a simple consistent API to access and manipulate that data.\n</ul>\n\n<p>\nPDO_DataObject is based on PEAR's <a href=\"https://pear.php.net/manual/en/package.database.db-dataobject.php\">DB_DataObject</a> and for most purposes is \nfunctionally compatibly (see <a href=\"db-dataobject-compatibility\">DB_DataObject Compatibility</a>)\n</p>\n\n<p>\nSo what does that mean in English? Well, if you look around at some of the better written PHP applications and frameworks\n out there, you will notice a common approach to using classes to wrap access to database tables or groups.\n</p>\n<p>\nPDO_DataObjects follows this pattern, In normal usage, you define one Class for each table that you use \n(you can use the genreator tools to automate this process)\n\n"
 },

  part     :  ["docs", "introduction" ],
  order    : '001-introduction',
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
     html : _this._strings['0b79795d3efc95b9976c7c5b933afce2'] /* Introduction */,
     level : 1,
     xns : Roo.bootstrap,
     '|xns' : 'Roo.bootstrap'
    },
    {
     xtype : 'Element',
     html : _this._strings['9954b604316367d52a9446e9f81a91ed'] /* 
     <p>     
PDO_DataObject is a SQL Builder and Data Modeling Layer built on top of PHP's PDO library. Its main purpose is to     
</p>     
<ul>     
<li>Build SQL and execute statements based on the objects variables.     
<li>Group source code around the data that they relate to.     
<li>Provide a simple consistent API to access and manipulate that data.     
</ul>     
     
<p>     
PDO_DataObject is based on PEAR's <a href="https://pear.php.net/manual/en/package.database.db-dataobject.php">DB_DataObject</a> and for most purposes is      
functionally compatibly (see <a href="db-dataobject-compatibility">DB_DataObject Compatibility</a>)     
</p>     
     
<p>     
So what does that mean in English? Well, if you look around at some of the better written PHP applications and frameworks     
 out there, you will notice a common approach to using classes to wrap access to database tables or groups.     
</p>     
<p>     
PDO_DataObjects follows this pattern, In normal usage, you define one Class for each table that you use      
(you can use the genreator tools to automate this process)     
     

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
         code : '<?php\n\n$db = new PDO(\'.....\');\n \n\nclass MyPerson\n{\n\n    // gets an array of data about the seleted person\n    function getPerson($id)\n    {\n        global $db;\n        $result = $db->query(\'SELECT * FROM person WHERE id=\' . $db->quote($id));\n        return $result->fetch();\n    }\n\n    // example of checking a password.\n    function checkPassword($username, $password)\n    {\n        global $db;\n\n        $hashed = md5($password);\n        $result = $db->query(\n            \'SELECT name FROM person WHERE name=\' . $db->quote($username)\n            . \' AND password = \' . $db->quote($hashed)\n        );\n        return $result->fetch();\n    }\n\n}\n\n// get the persons details..\n$a_person = new MyPerson();\n$data = $a_person->getPerson(12);\necho $array[\'name\'] . \"\\n\";\n ',
         title : _this._strings['efb07d8fb9f0f9705e4c81374a5a64ad'] /* A Classic Data Object or Container */,
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
