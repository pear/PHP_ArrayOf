--TEST--
IteratorAggregate Interface
--FILE--
<?php
/**
 * Checks class implements the IteratorAggregate properly
 *
 * This tests the access methods of the IteratorAggregate interface
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

$instance = new PHP_ArrayOf_Anything(array('A', 'B', 1, false, null));

foreach ($instance as $i => $v) {
    echo 'Value at index '.$i.': ';
    var_dump($v);
}

?>
--EXPECT--
Value at index 0: string(1) "A"
Value at index 1: string(1) "B"
Value at index 2: int(1)
Value at index 3: bool(false)
Value at index 4: NULL
