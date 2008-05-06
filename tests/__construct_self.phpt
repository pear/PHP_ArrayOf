--TEST--
Initialize with same class as class itself
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

$ao = new PHP_ArrayOf_Anything();

try {
    $instance = new PHP_ArrayOf_Anything($ao);
    echo "Empty self class: OK\n";
} catch (Exception $e) {
    echo "Empty self class: FAILED (".$e->getMessage().")\n";
}

$ao = new PHP_ArrayOf_Anything(array('A', 'B', 1, false, null));
try {
    $instance = new PHP_ArrayOf_Anything($ao);
    echo "Populated self class: OK\n";
} catch (Exception $e) {
    echo "Populated self class: FAILED\n";
}

?>
--EXPECT--
Empty self class: OK
Populated self class: OK
