<?php
/**
 * Join tables
 *
 * Note - not complete - code is still in core DataObjects..
 * 
 *
 * For PHP versions  5 and 7
 * 
 * 
 * Copyright (c) 2023 Alan Knowles
 * 
 * This program is free software: you can redistribute it and/or modify  
 * it under the terms of the GNU Lesser General Public License as   
 * published by the Free Software Foundation, version 3.
 *
 * This program is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU 
 * Lesser General Lesser Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *  
 * @category   Database
 * @package    PDO_DataObject
 * @author     Alan Knowles <alan@roojs.com>
 * @copyright  2016 Alan Knowles
 * @license    https://www.gnu.org/licenses/lgpl-3.0.en.html  LGPL 3
 * @version    1.0
 * @link       https://github.com/roojs/PDO_DataObject
 */
/**
 * Previously on DB_DataObject
 *
 * various methods existed to do Joins.
 *
 * simplist
 *   $do->_join = ....... << set's the string..
 *
 * joinAdd($obj, $jointype, 'INNER|....', joinAss,  ) ... lot's of args + allows array(....)
 *
 *  
 *
 * joinString(.....) << a string.. either '' (reset) or '....' appends 
 *
 * join('sometable as xxx')
 * join('right join sometable as xxx')
 * join('right join sometable as xxx on xxx.id=vv.id')
 *
 * --> set's _join_xxx to the dataobject...
 * 
 * 
 * BC: joinAdd(.... old messy way... ) -- mapped to join()
 
 *
 * autoJoin
 *
 * 
 * ----------------
 *
 *
 * Design theory..
 *
 * -> before we treated joins as just a method to build a string.
 *
 * Can we revamp that idea to add objects (and retreive)
 * building the structured data, then calling 'toString()' on build, and generate the join..
 *
 * $sometable = $do->join('some_table');
 * $sometable->id = 123
 * $all_data = $do->fetchAllAssoc();
 * 
 * 
 *
 *
 */
class PDO_DataObject_Join {
    
    private $do;
    
    /**
     * Associative map of joined elements and their names..
     * 
     * @access public
     */
    var $joins = array(); // 
    /**
     * Associative map of joined  names, with map of original 'dotted' column name to derived one..
     * 
     * @access public
     */
    
    var $columns = array(); 
    
    
    /**
     * constructor
     * The primary dataObject to work on..
     */
    function __construct(PDO_DataObject $dataObject)
    {
        $this->do = $dataObject;
    }
    
    
    
    
    
    /**
     * joinAdd - adds another dataobject to this, building a joined query.
     *
     * example (requires links.ini to be set up correctly)
     * // get all the images for product 24
     * $i = new DataObject_Image();
     * $pi = new DataObjects_Product_image();
     * $pi->product_id = 24; // set the product id to 24
     * $i->joinAdd($pi); // add the product_image connectoin
     * $i->find();
     * while ($i->fetch()) {
     *     // do stuff
     * }
     * // an example with 2 joins
     * // get all the images linked with products or productgroups
     * $i = new DataObject_Image();
     * $pi = new DataObject_Product_image();
     * $pgi = new DataObject_Productgroup_image();
     * $i->joinAdd($pi);
     * $i->joinAdd($pgi);
     * $i->find();
     * while ($i->fetch()) {
     *     // do stuff
     * }
     *
     *
     * @param    optional $obj       object |array    the joining object (no value resets the join)
     *                                          If you use an array here it should be in the format:
     *                                          array('local_column','remotetable:remote_column');
     *                                             if remotetable does not have a definition, you should
     *                                             use @ to hide the include error message..
     *                                          array('local_column',  $dataobject , 'remote_column');
     *                                             if array has 3 args, then second is assumed to be the linked dataobject.
     *
     * @param    optional $joinType  string | array
     *                                          'LEFT'|'INNER'|'RIGHT'|'' Inner is default, '' indicates 
     *                                          just select ... from a,b,c with no join and 
     *                                          links are added as where items.
     *                                          
     *                                          If second Argument is array, it is assumed to be an associative
     *                                          array with arguments matching below = eg.
     *                                          'joinType' => 'INNER',
     *                                          'joinAs' => '...'
     *                                          'joinCol' => ....
     *                                          'useWhereAsOn' => false,
     *
     * @param    optional $joinAs    string     if you want to select the table as anther name
     *                                          useful when you want to select multiple columsn
     *                                          from a secondary table.
     
     * @param    optional $joinCol   string     The column on This objects table to match (needed
     *                                          if this table links to the child object in 
     *                                          multiple places eg.
     *                                          user->friend (is a link to another user)
     *                                          user->mother (is a link to another user..)
     *
     *           optional 'useWhereAsOn' bool   default false;
     *                                          convert the where argments from the object being added
     *                                          into ON arguments.
     * 
     * 
     * @return   none
     * @access   public
     * @author   Stijn de Reede      <sjr@gmx.co.uk>
     */
    
    
    function joinAddBC($obj = false, $joinType='INNER', $joinAs=false, $joinCol=false)
    {
         
        $ofield = false; // object field
        $tfield = false; // this field
        $toTable = false;
        if (is_array($obj)) {
            $tfield = $obj[0];
            
            if (count($obj) == 3) {
                $obj = $obj[1];
                $ofield = $obj[2];
            } else {
                list($toTable,$ofield) = explode(':',$obj[1]);
                
                try {
                    $obj = is_string($toTable) ? PDO_DataObject::factory($toTable) : $toTable;
                } catch (Exception $e) {
                    $obj = new PDO_DataObject($toTable);
                }
                
            }
            // set the table items to nothing.. - eg. do not try and match
            // things in the child table...???
            
        }
        if (!is_a('PDO_DataObject', $obj)) {
            $this->do->raise("JoinAddBC - Object is not a PDO_DataObject", PDO_DataObject::ERROR_INVALIDARGS);
        }
        
        if (is_array($joinType)) {
            return $this->add($obj, array_merge($joinType,  array(
                
                'ofield' => $ofield,
                'tfield' => $tfield,
               
            )));
            
        }
        
        return $this->add($obj,  array(
            'joinType' => $joinType,
            'joinCol' => $joinCol,
            'joinAss' => $joinAs,
            'ofield' => $ofield,
            'tfield' => $tfield,
        ));
        
    }
    
    function add($obj = false, $options = array())
    {
          
        
        // new options can now go in here... (dont forget to document them)
        $useWhereAsOn = isset($options['useWhereAsOn']) ? $options['useWhereAsOn'] : false;
        $joinCol      = isset($options['joinCol'])  ? $options['joinCol']  : false;
        $joinAs       = isset($options['joinAs'])   ? $options['joinAs']   : false;
        $joinType     = isset($options['joinType']) ? $options['joinType'] : 'INNER';
        $ofield     = isset($options['ofield']) ? $options['ofield']     : false;
        $tfield     = isset($options['tfield']) ? $options['tfield']     : false;
        
          // support for array as first argument 
        // this assumes that you dont have a links.ini for the specified table.
        // and it doesnt exist as am extended dataobject!! - experimental.
        
        
        if (!is_a($obj,'PDO_DataObject')) {
            return $this->do->raise("joinAdd: called without an object", self::ERROR_INVALIDARGS);
        }
        
        /// CHANGED 26 JUN 2009 - we prefer links from our local table over the remote one.
        
        /* otherwise see if there are any links from this table to the obj. */
        //print_r($this->links());
        
        
        if (($ofield === false) && ($links = $this->do->links())) {
            // this enables for support for arrays of links in ini file.
            // link contains this_column[] =  linked_table:linked_column
            // or standard way.
            // link contains this_column =  linked_table:linked_column
            foreach ($links as $k => $linkVar) {
            
                if (!is_array($linkVar)) {
                    $linkVar  = array($linkVar);
                }
                foreach($linkVar as $v) {

                    
                    
                    /* link contains {this column} = {linked table}:{linked column} */
                    $ar = explode(':', $v);
                    // Feature Request #4266 - Allow joins with multiple keys
                    if (strpos($k, ',') !== false) {
                        $k = explode(',', $k);
                    }
                    if (strpos($ar[1], ',') !== false) {
                        $ar[1] = explode(',', $ar[1]);
                    }

                    if ($ar[0] != $obj->tableName()) {
                        continue;
                    }
                    if ($joinCol !== false) {
                        if ($k == $joinCol) {
                            // got it!?
                            $tfield = $k;
                            $ofield = $ar[1];
                            break;
                        } 
                        continue;
                        
                    } 
                    $tfield = $k;
                    $ofield = $ar[1];
                    break;
                        
                }
            }
        }
         /* look up the links for obj table */
        //print_r($obj->links());
        if (!$ofield && ($olinks = $obj->links())) {
            
            foreach ($olinks as $k => $linkVar) {
                /* link contains {this column} = array ( {linked table}:{linked column} )*/
                if (!is_array($linkVar)) {
                    $linkVar  = array($linkVar);
                }
                foreach($linkVar as $v) {
                    
                    /* link contains {this column} = {linked table}:{linked column} */
                    $ar = explode(':', $v);
                    
                    // Feature Request #4266 - Allow joins with multiple keys
                    $links_key_array = strpos($k,',');
                    if ($links_key_array !== false) {
                        $k = explode(',', $k);
                    }
                    
                    $ar_array = strpos($ar[1],',');
                    if ($ar_array !== false) {
                        $ar[1] = explode(',', $ar[1]);
                    }
                 
                    if ($ar[0] != $this->do->tableName()) {
                        continue;
                    }
                    
                    // you have explictly specified the column
                    // and the col is listed here..
                    // not sure if 1:1 table could cause probs here..
                    
                    if ($joinCol !== false) {
                         $this->do->raise( 
                            "joinAdd: You cannot target a join column in the " .
                            "'link from' table ({$obj->tableName()}). " . 
                            "Either remove the fourth argument to joinAdd() ".
                            "({$joinCol}), or alter your links.ini file. ",
                            self::ERROR_NODATA);
                        return false;
                    }
                
                    $ofield = $k;
                    $tfield = $ar[1];
                    break;
                    
                }
            }
        }

        // finally if these two table have column names that match do a join by default on them

        if (($ofield === false) && $joinCol) {
            $ofield = $joinCol;
            $tfield = $joinCol;

        }
        /* did I find a conneciton between them? */

        if ($ofield === false) {
            $this->do->raise(
                "joinAdd: {$obj->tableName()} has no link with {$this->tableName()}",
                self::ERROR_NODATA);
            return false;
        }
        $joinType = strtoupper($joinType);
        
        // we default to joining as the same name (this is remvoed later..)
        
        if ($joinAs === false) {
            $joinAs = $obj->tableName();
        }
        
        
        
        
        $options = PDO_DataObject::config();
        $quoteIdentifiers = $options['quote_identifiers'];
        
        // not sure  how portable adding database prefixes is..
        $objTable = $quoteIdentifiers ? 
                $this->do->quoteIdentifier($obj->tableName()) : 
                $obj->tableName() ;
        
        
        
        $dbPrefix  = '';
        $my_pdo = $this->do->PDO();
        $obj_pdo = $obj->PDO();
        
        
        if ($my_pdo->getAttribute(PDO::ATTR_DRIVER_NAME) != $obj_pdo->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            $this->do->raise("Can not join two different database types", PDO_DataObject::ERROR_INVALIDARGS);
        }
        $my_db_name = $my_pdo->dsn_ar['database_name'];
        $obj_db_name = $obj_pdo->dsn_ar['database_name'];
        
        // database prefixes?  - only supported in mysql?
        if ($my_db_name != $obj_db_name  && $my_pdo->getAttribute(PDO::ATTR_DRIVER_NAME)  == 'mysql') {
            $dbPrefix = ($quoteIdentifiers
                         ? $this->do->quoteIdentifier($obj->_database)
                         : $obj->_database) . '.';    
        }
        
        // as far as we know only mysql supports database prefixes..
        // prefixing the database name is now the default behaviour,
        // as it enables joining mutiple columns from multiple databases...
         
            // prefix database (quoted if neccessary..)
        $objTable = $dbPrefix . $objTable;
       
        $cond = '';

        // if obj only a dataobject - eg. no extended class has been defined..
        // it obvioulsy cant work out what child elements might exist...
        // until we get on the fly querying of tables..
        // note: we have already checked that it is_a(db_dataobject earlier)
        if ( strtolower(get_class($obj)) != 'db_dataobject') {
                 
            // now add where conditions for anything that is set in the object 
        
        
        
            $items = $obj->tableColumns();
            // will return an array if no items..
            
            // only fail if we where expecting it to work (eg. not joined on a array)
             
            if (!$items) {
                return $this->do->raise(
                    "joinAdd: No table definition for {$obj->tableName()}", 
                    PDO_DataObject::ERROR_INVALIDCONFIG);
            }
            
            $ignore_null = $options['disable_null_strings'] === false;
            
            
            $obj->tableName($joinAs);
              
            if ($this->_query === false) {
                $this->raise(
                    "joinAdd can not be run from a object that has had a query run on it,
                    clone the object or create a new one and use setFrom()", 
                    self::ERROR_INVALIDARGS);
                return false;
            }
        }

        // and finally merge the whereAdd from the child..
        if ($obj->_query['condition']) {
            $cond = preg_replace('/^\sWHERE/i','',$obj->_query['condition']);

            if (!$useWhereAsOn) {
                $this->whereAdd($cond);
            }
        }
    
        
        
        
        // nested (join of joined objects..)
        $appendJoin = '';
        if ($obj->_join) {
            // postgres allows nested queries, with ()'s
            // not sure what the results are with other databases..
            // may be unpredictable..
            if (in_array($DB->dsn["phptype"],array('pgsql'))) {
                $objTable = "($objTable {$obj->_join})";
            } else {
                $appendJoin = $obj->_join;
            }
        }
        
  
        // fix for #2216
        // add the joinee object's conditions to the ON clause instead of the WHERE clause
        if ($useWhereAsOn && strlen($cond)) {
            $appendJoin = ' AND ' . $cond . ' ' . $appendJoin;
        }
               
        
        
        $table = $this->tableName();
        
        if ($quoteIdentifiers) {
            $joinAs   = $DB->quoteIdentifier($joinAs);
            $table    = $DB->quoteIdentifier($table);     
            $ofield   = (is_array($ofield)) ? array_map(array($DB, 'quoteIdentifier'), $ofield) : $DB->quoteIdentifier($ofield);
            $tfield   = (is_array($tfield)) ? array_map(array($DB, 'quoteIdentifier'), $tfield) : $DB->quoteIdentifier($tfield); 
        }
        // add database prefix if they are different databases
       
        
        $fullJoinAs = '';
        $addJoinAs  = ($quoteIdentifiers ? $DB->quoteIdentifier($obj->tableName()) : $obj->tableName()) != $joinAs;
        if ($addJoinAs) {
            // join table a AS b - is only supported by a few databases and is probably not needed
            // , however since it makes the whole Statement alot clearer we are leaving it in
            // for those databases.
            $fullJoinAs = in_array($DB->dsn["phptype"],array('mysql','mysqli','pgsql')) ? "AS {$joinAs}" :  $joinAs;
        } else {
            // if 
            $joinAs = $dbPrefix . $joinAs;
        }
        
        
        switch ($joinType) {
            case 'INNER':
            case 'LEFT': 
            case 'RIGHT': // others??? .. cross, left outer, right outer, natural..?
                
                // Feature Request #4266 - Allow joins with multiple keys
                $jadd = "\n {$joinType} JOIN {$objTable} {$fullJoinAs}";
                //$this->_join .= "\n {$joinType} JOIN {$objTable} {$fullJoinAs}";
                if (is_array($ofield)) {
                	$key_count = count($ofield);
                    for($i = 0; $i < $key_count; $i++) {
                    	if ($i == 0) {
                    		$jadd .= " ON ({$joinAs}.{$ofield[$i]}={$table}.{$tfield[$i]}) ";
                    	}
                    	else {
                    		$jadd .= " AND {$joinAs}.{$ofield[$i]}={$table}.{$tfield[$i]} ";
                    	}
                    }
                    $jadd .= ' ' . $appendJoin . ' ';
                } else {
	                $jadd .= " ON ({$joinAs}.{$ofield}={$table}.{$tfield}) {$appendJoin} ";
                }
                // jadd avaliable for debugging join build.
                //echo $jadd ."\n";
                $this->_join .= $jadd;
                break;
                
            case '': // this is just a standard multitable select..
                $this->_join .= "\n , {$objTable} {$fullJoinAs} {$appendJoin}";
                $this->whereAdd("{$joinAs}.{$ofield}={$table}.{$tfield}");
        }
         
         
        return true;

    }

}

 