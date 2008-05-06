--TEST--
Initialize with regular PHP array
--FILE--
<?php
/**
 * Checks class accepts a regular array value
 *
 * PHP version 5
 *
 * @category PHP
 * @package  PHP_ArrayOf
 * @author   Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyight 2008 by Philippe Jausions / 11abacus
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  CVS: $Id$
 * @link     http://pear.php.net/package/PHP_ArrayOf
 */

/**
 * Basic test class
 */
require 'ArrayOfAnything.inc';

/**
 * Main
 */

try {
    $instance = new PHP_ArrayOf_Anything(array());
    echo "Empty array: OK\n";
} catch (Exception $e) {
    echo "Empty array: FAILED\n";
}

try {
    $instance = new PHP_ArrayOf_Anything(array('A', 'B', 1, false, null));
    echo "Populated array: OK\n";
} catch (Exception $e) {
    echo "Populated array: FAILED\n";
}

?>
--EXPECT--
Empty array: OK
Populated array: OK
