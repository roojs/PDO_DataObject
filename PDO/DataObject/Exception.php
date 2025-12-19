<?php
/**
 * DataObjects error handler, loaded on demand...
 *
 * PDO_DataObject_Error is a quick wrapper around pear error, so you can distinguish the
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
 * @package    PDO_DataObject
 * @author     Alan Knowles <alan@akbkhome.com>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id: Error.php 339237 2016-05-26 03:59:27Z alan_k $
 * @link       http://pear.php.net/package/PDO_DataObject
 */
  

class_exists('PDO_DataObject_Exception_InvalidArgs') ? '' : require_once 'PDO/DataObject/Exception/InvalidArgs.php';
class_exists('PDO_DataObject_Exception_NoData') ? '' : require_once 'PDO/DataObject/Exception/NoData.php';
class_exists('PDO_DataObject_Exception_InvalidConfig') ? '' : require_once 'PDO/DataObject/Exception/InvalidConfig.php';
class_exists('PDO_DataObject_Exception_NoClass') ? '' : require_once 'PDO/DataObject/Exception/NoClass.php';
class_exists('PDO_DataObject_Exception_Set') ? '' : require_once 'PDO/DataObject/Exception/Set.php';
class_exists('PDO_DataObject_Exception_Connect') ? '' : require_once 'PDO/DataObject/Exception/Connect.php';
class_exists('PDO_DataObject_Exception_Query') ? '' : require_once 'PDO/DataObject/Exception/Query.php';

class PDO_DataObject_Exception extends Exception
{
    
   
     /**
     * PDO_DataObject_Exception factory constructor.
     * @param mixed   $message The text description of the message
     * @param mixed   $type    The type of error message
     * @param mixed   $previous_exception (optional)  the previous exception that triggered this one.
     *
     * @access public
     *
     * @see @Exception
     */
    // todo : - support code -> message handling, and translated error messages...
    static function factory($message, $type, $previous_exception)
    {
        $cls = 'PDO_DataObject_Exception_'. $type;
        $code = $previous_exception ? $previous_exception->getCode() : 0;
        return new $cls($message, 0, $previous_exception );
    }
    
    
     
}

