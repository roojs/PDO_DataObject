<?php
/**
 * DataObjects error handler, loaded on demand...
 *
 * DB_DataObject_Error is a quick wrapper around pear error, so you can distinguish the
 * error code source.
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
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id: Error.php 339237 2016-05-26 03:59:27Z alan_k $
 * @link       http://pear.php.net/package/DB_DataObject
 */
  
 
class DB_DataObject_Exception extends Exception
{
    
    /**
     * DB_DataObject_Error constructor.
     *
     * @param mixed   $code   DB error code, or string with error message.
     * @param integer $mode   what "error mode" to operate in
     * @param integer $level  what error level to use for $mode & PEAR_ERROR_TRIGGER
     * @param mixed   $debuginfo  additional debug info, such as the last query
     *
     * @access public
     *
     * @see PEAR_Error
     */
    function __construct($message = '', $type, $previous_exception = null)
    {
        parent::__construct('DB_DataObject Error: ' . $message, $code, $mode, $level);
        
    }
    
    
    // todo : - support code -> message handling, and translated error messages...
    static factory
    
    
    
    
    
    const ERROR_INVALIDARGS =   -1;  // wrong args to function
    const ERROR_NODATA =        -2;  // no data available
    const ERROR_INVALIDCONFIG = -3;  // something wrong with the config
    const ERROR_NOCLASS =       -4;  // no class exists
    const ERROR_SET =           -5;  // set() caused errors when calling set*** methods.
    
    
    
}

// child classes - so you can catch them..
class DB_DataObject_Exception_InvalidArgs extends class DB_DataObject_Exception {};
class DB_DataObject_Exception_NoData extends class DB_DataObject_Exception {};
class DB_DataObject_Exception_InvalidConfig extends class DB_DataObject_Exception {};
class DB_DataObject_Exception_NoClass extends class DB_DataObject_Exception {};
class DB_DataObject_Exception_Set extends class DB_DataObject_Exception {};


