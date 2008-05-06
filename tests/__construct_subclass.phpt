--TEST--
Initialize with subclass
--FILE--
<?php
/**
 * Checks class accepts an instance of the class itself
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

class PHP_ArrayOf_Anything2 extends PHP_ArrayOf_Anything
{
}
$ao = new PHP_ArrayOf_Anything2();

try {
    $instance = new PHP_ArrayOf_Anything($ao);
    echo "Empty subclass: OK\n";
} catch (Exception $e) {
    echo "Empty subclass: FAILED (".$e->getMessage().")\n";
}

$ao = new PHP_ArrayOf_Anything2(array('A', 'B', 1, false, null));
try {
    $instance = new PHP_ArrayOf_Anything($ao);
    echo "Populated subclass: OK\n";
} catch (Exception $e) {
    echo "Populated subclass: FAILED\n";
}

?>
--EXPECT--
Empty subclass: OK
Populated subclass: OK
