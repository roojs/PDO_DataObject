<?php
/**
 * Prototype Castable Object.. for DataObject queries
 *
 * Storage for Data that may be cast into a variety of formats.
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
*  
* Common usages:
*   // blobs
*   $data = PDO_DataObject_Cast::blob($somefile);
*   $data = PDO_DataObject_Cast::string($somefile);
*   $dataObject->someblobfield = $data
*
*   // dates?
*   $d1 = new PDO_DataObject_Cast::date('12/12/2000');
*   $d2 = new PDO_DataObject_Cast::date(2000,12,30);
*   $d3 = new PDO_DataObject_Cast::date($d1->year, $d1->month+30, $d1->day+30);
*   
*   // time, datetime.. ?????????
*
*   // raw sql????
*    $data = PDO_DataObject_Cast::sql('cast("123123",datetime)');
*    $data = PDO_DataObject_Cast::sql('NULL');
*
*   // int's/string etc. are proably pretty pointless..!!!!
*
*   
*   inside DB_DataObject, 
*   if (is_a($v,'db_dataobject_class')) {
*           $value .= $v->toString(PDO_DataObject::INT,'mysql');
*   }
*
*
*
*

*/ 
class PDO_DataObject_Cast {
        
    /**
    * Type of data Stored in the object..
    *
    * @var string       (date|blob|.....?)
    * @access public        
    */
    var $type;
        
    /**
    * Data For date representation
    *
    * @var int  day/month/year
    * @access public
    */
    var $day;
    var $month;
    var $year;

    
    /**
    * Generic Data..
    *
    * @var string
    * @access public
    */

    var $value;



    /**
    * Blob consructor
    *
    * create a Cast object from some raw data.. (binary)
    * 
    * 
    * @param   string (with binary data!)
    *
    * @return   object PDO_DataObject_Cast
    * @access   public 
    */
  
    static function blob($value) {
        $r = new PDO_DataObject_Cast;
        $r->type = 'blob';
        $r->value = $value;
        return $r;
    }


    /**
    * String consructor (actually use if for ints and everything else!!!
    *
    * create a Cast object from some string (not binary)
    * 
    * 
    * @param   string (with binary data!)
    *
    * @return   object PDO_DataObject_Cast
    * @access   public 
    */
  
    static function string($value) {
        $r = new PDO_DataObject_Cast;
        $r->type = 'string';
        $r->value = $value;
        return $r;
    }
    
    /**
    * SQL constructor (for raw SQL insert)
    *
    * create a Cast object from some sql
    * 
    * @param   string (with binary data!)
    *
    * @return   object PDO_DataObject_Cast
    * @access   public 
    */
  
    static function sql($value) 
    {
        $r = new PDO_DataObject_Cast;
        $r->type = 'sql';
        $r->value = $value;
        return $r;
    }


    /**
    * Date Constructor
    *
    * create a Cast object from some string (not binary)
    * NO VALIDATION DONE, although some crappy re-calcing done!
    * 
    * @param   vargs... accepts
    *       dd/mm
    *       dd/mm/yyyy
    *       yyyy-mm
    *       yyyy-mm-dd
    *       array(yyyy,dd)
    *       array(yyyy,dd,mm)
    *
    *
    *
    * @return   object PDO_DataObject_Cast
    * @access   public 
    */
  
    static function date() 
    {  
        $args = func_get_args();
        switch(count($args)) {
            case 0: // no args = today!
                $bits =  explode('-',date('Y-m-d'));
                break;
            case 1: // one arg = a string 
            
                if (strpos($args[0],'/') !== false) {
                    $bits = array_reverse(explode('/',$args[0]));
                } else {
                    $bits = explode('-',$args[0]);
                }
                break;
            default: // 2 or more..
                $bits = $args;
        }
        if (count($bits) == 1) { // if YYYY set day = 1st..
            $bits[] = 1;
        }
        
        if (count($bits) == 2) { // if YYYY-DD set day = 1st..
            $bits[] = 1;
        }
        
        // if year < 1970 we cant use system tools to check it...
        // so we make a few best gueses....
        // basically do date calculations for the year 2000!!!
        // fix me if anyone has more time...
        if (($bits[0] < 1975) || ($bits[0] > 2030)) {
            $oldyear = $bits[0];
            $bits = explode('-',date('Y-m-d',mktime(1,1,1,$bits[1],$bits[2],2000)));
            $bits[0] = ($bits[0] - 2000) + $oldyear;
        } else {
            // now mktime
            $bits = explode('-',date('Y-m-d',mktime(1,1,1,$bits[1],$bits[2],$bits[0])));
        }
        $r = new PDO_DataObject_Cast;
        $r->type = 'date';
        list($r->year,$r->month,$r->day) = $bits;
        return $r;
    }
    
   

    /**
    * Data For time representation ** does not handle timezones!!
    *
    * @var int  hour/minute/second
    * @access public
    */
    var $hour;
    var $minute;
    var $second;

    
    /**
    * DateTime Constructor
    *
    * create a Cast object from a Date/Time
    * Maybe should accept a Date object.!
    * NO VALIDATION DONE, although some crappy re-calcing done!
    * 
    * @param   vargs... accepts
    *              noargs (now)
    *              yyyy-mm-dd HH:MM:SS (Iso)
    *              array(yyyy,mm,dd,HH,MM,SS) 
    *
    *
    * @return   object PDO_DataObject_Cast
    * @access   public 
    * @author   therion 5 at hotmail
    */
    
    static function dateTime()
    {
        $args = func_get_args();
        switch(count($args)) {
            case 0: // no args = now!
                $datetime = date('Y-m-d G:i:s', mktime());
            
            case 1:
                // continue on from 0 args.
                if (!isset($datetime)) {
                    $datetime = $args[0];
                }
                
                $parts =  explode(' ', $datetime);
                $bits = explode('-', $parts[0]);
                $bits = array_merge($bits, explode(':', $parts[1]));
                break;
                
            default: // 2 or more..
                $bits = $args;
                
        }

        if (count($bits) != 6) {
            // PEAR ERROR?
            return false;
        }
        
        $r = PDO_DataObject_Cast::date((int)$bits[0], (int)$bits[1], (int)$bits[2]);
       
        // change the type!
        $r->type = 'datetime';
        
        // should we mathematically sort this out.. 
        // (or just assume that no-one's dumb enough to enter 26:90:90 as a time!
        $r->hour = (int)$bits[3];
        $r->minute = (int)$bits[4];
        $r->second = (int)$bits[5];
        return $r;

    }



    /**
    * time Constructor
    *
    * create a Cast object from a Date/Time
    * Maybe should accept a Date object.!
    * NO VALIDATION DONE, and no-recalcing done!
    *
    * @param   vargs... accepts
    *              noargs (now)
    *              HH:MM:SS (Iso)
    *              array(HH,MM,SS)    
    *
    *
    * @return   object PDO_DataObject_Cast
    * @access   public 
    * @author   therion 5 at hotmail
    */
    static function time()
    {
        $args = func_get_args();
        switch (count($args)) {
            case 0: // no args = now!
                $time = date('G:i:s', mktime());
                
            case 1:
                // continue on from 0 args.
                if (!isset($time)) {
                    $time = $args[0];
                }
                $bits =  explode(':', $time);
                break;
                
            default: // 2 or more..
                $bits = $args;
                
        }
        
        if (count($bits) != 3) {
            return false;
        }
        
        // now take data from bits into object fields
        $r = new PDO_DataObject_Cast;
        $r->type = 'time';
        $r->hour = (int)$bits[0];
        $r->minute = (int)$bits[1];
        $r->second = (int)$bits[2];
        return $r;

    }

  
  
    /**
    * get the string to use in the SQL statement for this...
    *
    * 
    * @param   int      $to Type (PDO_DataObject::*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    */
  
    function toString($to=false,$PDO=false) 
    {
        // if $this->type is not set, we are in serious trouble!!!!
        // values for to:
        $method = 'toStringFrom'.$this->type;
        return $this->$method($to,$PDO);
    }
    
    /**
    * get the string to use in the SQL statement from a blob of binary data 
    *   ** Suppots only blob->postgres::bytea
    *
    * @param   int      $to Type (PDO_DataObject::*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    */
    function toStringFromBlob($to,$PDO) 
    {
        // first weed out invalid casts..
        // in blobs can only be cast to blobs.!
        
        // perhaps we should support TEXT fields???
        
        if (!($to & PDO_DataObject::BLOB)) {
            return self::raise('Invalid Cast from a PDO_DataObject_Cast::blob to something other than a blob!', PDO_DataObject::ERROR_INVALIDARGS);
        }
        
        switch ($PDO->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            case 'pgsql':
                return $PDO->quote($this->value. PDO::PARAM_LOB) .'::bytea';
                
            case 'mysql':
            case 'sqlite':    
                return $PDO->quote($this->value);
            
            case 'mssql':
                if(is_numeric($this->value)) {
                    return $this->value;
                }
                $unpacked = unpack('H*hex', $this->value);
                return '0x' . $unpacked['hex'];
                        
                 
   
            default:
                return self::raise("PDO_DataObject_Cast cant handle blobs for Database:{$PDO->getAttribute(PDO::ATTR_DRIVER_NAME)} Yet",
                    PDO_DataObject::ERROR_INVALIDARGS);
        }
    
    }
    
    /**
    * get the string to use in the SQL statement for a blob from a string!
    *   ** Suppots only string->postgres::bytea
    * 
    *
    * @param   int      $to Type (PDO_DataObject::*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    */
    function toStringFromString($to,$PDO) 
    {
        // first weed out invalid casts..
        // in blobs can only be cast to blobs.!
        
        // perhaps we should support TEXT fields???
        // 
        
        // $to == a string field which is the default type (0)
        // so we do not test it here. - we assume that number fields
        // will accept a string?? - which is stretching it a bit ...
        // should probaly add that test as some point. 
        
        switch ($PDO->getAttribute(PDO::ATTR_DRIVER_NAME)) {
            case 'sqlite':    
            case 'pgsql':
            case 'mysql':
                return $PDO->quote($this->value);
           
           
            case 'mssql':
                // copied from the old DB mssql code...?? not sure how safe this is.
                return "'" . str_replace(
                        array("'", "\\\r\n", "\\\n"),
                        array("''", "\\\\\r\n\r\n", "\\\\\n\n"),
                        $this->value 
                    ) . "'";
                

            default:
                return self::raise("PDO_DataObject_Cast cant handle blobs for Database:{$PDO->getAttribute(PDO::ATTR_DRIVER_NAME)} Yet",
                  PDO_DataObject::ERROR_INVALIDARGS);
        }
    
    }
    
    
    /**
    * get the string to use in the SQL statement for a date
    *   
    * 
    *
    * @param   int      $to Type (PDO_DataObject::*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    */
    function toStringFromDate($to,$db) 
    {
        // first weed out invalid casts..
        // in blobs can only be cast to blobs.!
         // perhaps we should support TEXT fields???
        // 
         switch (true) {
             case ($to & PDO_DataObject::DATE && $to & PDO_DataObject::TIME):
                return sprintf("'%04d-%02d-%02d %02d:%02d:%02d'", 
                    $this->year,$this->month, $this->day,  0,0,0);

            case ($to & PDO_DataObject::DATE):
                return sprintf("'%04d-%02d-%02d'", 
                    $this->year,$this->month, $this->day);

            default:

                return self::raise('Invalid Cast from a PDO_DataObject_Cast::string to something other than a date or datetime!'.
                    ' (why not just use native features)',PDO_DataObject::ERROR_INVALIDARGS);
        }

    }
    
    /**
    * get the string to use in the SQL statement for a datetime
    *   
    * 
    *
    * @param   int     $to Type (PDO_DataObject::*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    * @author   therion 5 at hotmail
    */
    
    function toStringFromDateTime($to,$db) 
    {
        // first weed out invalid casts..
        // in blobs can only be cast to blobs.!
        // perhaps we should support TEXT fields???
        var_dump($to);
        switch (true) {
            case ($to & PDO_DataObject::DATE && $to & PDO_DataObject::TIME):
                return sprintf("'%04d-%02d-%02d %02d:%02d:%02d'", 
                    $this->year,$this->month, $this->day,  $this->hour,$this->minute, $this->second);

            case ($to & PDO_DataObject::DATE):
                return sprintf("'%04d-%02d-%02d'", 
                    $this->year,$this->month, $this->day);

            case ($to & PDO_DataObject::TIME):
                return sprintf("'%02d:%02d:%02d'", 
                     $this->year,$this->month, $this->day,  $this->hour,$this->minute, $this->second);

            default:

                return self::raise('Invalid Cast from a ' .
                    ' PDO_DataObject_Cast::dateTime to something other than a datetime/time or date!' .
                    ' (try using native features)',PDO_DataObject::ERROR_INVALIDARGS);
        }

    }

    /**
    * get the string to use in the SQL statement for a time
    *   
    * 
    *
    * @param   int     $to Type (PDO_DataObject::*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    * @author   therion 5 at hotmail
    */

    function toStringFromTime($to,$db) 
    {
        // first weed out invalid casts..
        // in blobs can only be cast to blobs.!
        // perhaps we should support TEXT fields???
        if (($to !== false) && !($to & PDO_DataObject::TIME)) {
            return self::raise('Invalid Cast from a' . 
                ' PDO_DataObject_Cast::time to something other than a time!'.
                ' (try using native features)',PDO_DataObject::ERROR_INVALIDARGS);
        }
         return sprintf("'%02d:%02d:%02d'", 
             $this->hour,$this->minute, $this->second);
    }
  
    /**
    * get the string to use in the SQL statement for a raw sql statement.
    *
    * @param   int      $to Type (PDO_DataObject::*
    * @param   object   $db DB Connection Object
    * 
    *
    * @return   string 
    * @access   public
    */
    function toStringFromSql($to,$db) 
    {
        return $this->value; 
    }
    /**
    * can this property be converted to a plain value (for toArray)
    *
    * @return   bool 
    * @access   public
    */
    function canToValue() 
    {
        switch($this->type) {
            case 'date':
            case 'datetime':
            case 'time':
            case 'blob': //???
            case 'string':
              return true; 
          
            case 'sql':
              return strtolower($this->value) == 'null' ? true : false;
            
            default:
              return false; // not sould not get here...
        }
    }

    /**
    * can this property be converted to a plain value (for toArray)
    *
    * @return   bool 
    * @access   public
    */
    function toValue() 
    {
        switch($this->type) {
            case 'date':
              return sprintf("%04d-%02d-%02d",  $this->year,$this->month, $this->day);

            case 'datetime':
              return sprintf("%04d-%02d-%02d %02d:%02d:%02d", 
                    $this->year,$this->month, $this->day,  $this->hour,$this->minute, $this->second);

            case 'time':
              return sprintf("%02d:%02d:%02d",  $this->hour,$this->minute, $this->second);

            case 'blob': //???
            case 'string':
              return $this->value; 
          
            case 'sql':
              if (strtolower($this->value) == 'null') {
                  return null;
              }
              $this->raise("converting sql to a plain value is not supported (except for null)", 
                    PDO_DataObject::ERROR_INVALIDARGS);
            
            default:
              $this->raise("converting cast object with type={$this->type}  is not supported ", 
                    PDO_DataObject::ERROR_INVALIDARGS);
        }
    }
   


    /**
    * does this object representing a 'null' value...
    * 
    * @return   bool
    * @access   public
    */
    function isNull() 
    {
        return $this->type == 'sql' && strtolower($this->value) == 'null'; 
    }
    /**
     * Wrapper around throw Exception..., 
      *
     * @param  int $message    message
     * @param  int $type       type
     * @param  Exception $previous_exception  Cause of error...
     * @access public
     * @return error object
     */
    static function raise($message, $type , $previous_exception = null)
    {
        class_exists('PDO_DataObject') ? '' :
            require_once 'PDO/DataObject.php';
         
        return (new PDO_DataObject())->raise($message,$type, $previous_exception);
             
    }

    
}

