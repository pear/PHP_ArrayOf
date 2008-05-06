--TEST--
Countable Interface
--FILE--
<?php
/**
 * Checks count() function can be called
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

$instance = new PHP_ArrayOf_Anything();

echo count($instance)."\n";
for ($i = 0; $i < 4; ++$i) {
    $instance->offsetSet($i, 'a');
    echo count($instance)."\n";
}

$instance->offsetUnset(2);
echo count($instance)."\n";

?>
--EXPECT--
0
1
2
3
4
3