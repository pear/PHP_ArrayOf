--TEST--
Initialize with SPL ArrayObject
--FILE--
<?php
/**
 * Checks class accepts a SPL ArrayObject instance
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

$ao = new ArrayObject();

try {
    $instance = new PHP_ArrayOf_Anything($ao);
    echo "Empty ArrayObject: OK\n";
} catch (Exception $e) {
    echo "Empty ArrayObject: FAILED (".$e->getMessage().")\n";
}

$ao = new ArrayObject(array('A', 'B', 1, false, null));
try {
    $instance = new PHP_ArrayOf_Anything($ao);
    echo "Populated ArrayObject: OK\n";
} catch (Exception $e) {
    echo "Populated ArrayObject: FAILED\n";
}

?>
--EXPECT--
Empty ArrayObject: OK
Populated ArrayObject: OK
