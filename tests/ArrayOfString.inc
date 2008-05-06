<?php
/**
 * Basic test class.
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    PHP_ArrayOf
 * @subpackage Tests
 * @author     Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyight   2008 by Philippe Jausions / 11abacus
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/PHP_ArrayOf
 */

/**
 * Required package to test
 */
error_reporting(E_ALL);
require_once 'PHP/ArrayOf.php';

/**
 * Basic test class.
 *
 * This class is supposed to only accept PHP strings
 *
 * @category   PHP
 * @package    PHP_ArrayOf
 * @subpackage Tests
 * @author     Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyight   2008 by Philippe Jausions / 11abacus
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link       http://pear.php.net/package/PHP_ArrayOf
 */
class PHP_ArrayOf_String extends PHP_ArrayOf
{
    /**
     * Checks whether a value is suitable for the array
     *
     * @param mixed $value value to check
     *
     * @return boolean TRUE if valid, FALSE otherwise
     * @access protected
     */
    public function isValidElement($value)
    {
        return is_string($value);
    }
}

?>