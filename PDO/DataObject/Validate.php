<?php
/**
 * Validation code (simple version.)
 *
 * Storage for Data that may be cast into a variety of formats.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Database
 * @package    DB_DataObject
 * @author     Alan Knowles <alan@akbkhome.com>
 * @copyright  1997-2008 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id: Cast.php 287158 2009-08-12 13:58:31Z alan_k $
 * @link       http://pear.php.net/package/DB_DataObject
 */

 
class PDO_DataObject_Validate
{
    
    // the dataObject being validated..
    private $do;
      
    /**
     * Constructor
     * @param PDO_DataObject $dataobject The object to validate.
     *
     */
    function __construct($dataobject)
    {
        $this->do = $dataobject;
    }
    
   /**
     * validate the values of the object (can be used prior to inserting/updating..)
     *
     * Note: This was always intended as a simple validation routine.
     * It lacks understanding of field length, whether you are inserting or updating (and hence null key values)
     *
     * Usage:
     * if (is_array($ret = $obj->validate())) { ... there are problems with the data ... }
     *
     * Logic:
     *   - defaults to only testing strings/numbers if numbers or strings are the correct type and null values are correct
     *   - validate Column methods : "validate{ROWNAME}()"  are called if they are defined.
     *            These methods should return 
     *                  true = everything ok
     *                  false|object = something is wrong!
     * 
     *   - This method loads and uses the PEAR Validate Class.
     *
     * @requires PEAR Validate.php
     *
     * @access  public
     * @return  array of validation results (where key=>value, value=false|object if it failed) or true (if they all succeeded)
     */
    function validate()
    {
        require_once 'Validate.php';
        
        $table = $this->do->tableColumns();
        $ret   = array();
        $seq   = $this->do->sequenceKey();
        
        foreach($table as $key => $val) {
            
            
            // call user defined validation always...
            $method = "Validate" . ucfirst($key);
            if (method_exists($this->do, $method)) {
                $ret[$key] = $this->do->$method();
                continue;
            }
            
            // if not null - and it's not set.......
            
            if ($val & PDO_DataObject::NOTNULL && PDO_DataObject::_is_null($this, $key)) {
                // dont check empty sequence key values..
                if (($key == $seq[0]) && ($seq[1] == true)) {
                    continue;
                }
                $ret[$key] = false;
                continue;
            }
            
            
             if (PDO_DataObject::_is_null($this, $key)) {
                if ($val & PDO_DataObject::NOTNULL) {
                    $this->do->debug("'null' field used for '$key', but it is defined as NOT NULL", 'VALIDATION', 4);
                    $ret[$key] = false;
                    continue;
                }
                continue;
            }

            // ignore things that are not set. ?
           
            if (!isset($this->$key)) {
                continue;
            }
            
            // if the string is empty.. assume it is ok..
            if (!is_object($this->$key) && !is_array($this->$key) && !strlen((string) $this->$key)) {
                continue;
            }
            
            // dont try and validate cast objects - assume they are problably ok..
            if (is_object($this->$key) && is_a($this->$key,'DB_DataObject_Cast')) {
                continue;
            }
            // at this point if you have set something to an object, and it's not expected
            // the Validate will probably break!!... - rightly so! (your design is broken, 
            // so issuing a runtime error like PEAR_Error is probably not appropriate..
            
            switch (true) {
                // todo: date time.....
                case  ($val & DB_DATAOBJECT_STR):
                    $ret[$key] = Validate::string($this->$key, VALIDATE_PUNCTUATION . VALIDATE_NAME);
                    continue;
                case  ($val & DB_DATAOBJECT_INT):
                    $ret[$key] = Validate::number($this->$key, array('decimal'=>'.'));
                    continue;
            }
        }
        // if any of the results are false or an object (eg. PEAR_Error).. then return the array..
        foreach ($ret as $key => $val) {
            if ($val !== true) {
                return $ret;
            }
        }
        return true; // everything is OK.
    }
