--TEST--
ArrayAccess Interface (methods)
--FILE--
<?php
/**
 * Checks class implements the ArrayAccess properly
 *
 * This tests the access methods of the ArrayAccess interface
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

echo 'Index 0 exists:                       ';
var_dump($instance->offsetExists(0));

echo 'Set value at index 0, index exists:   ';
$instance->offsetSet(0, 'a');
var_dump($instance->offsetExists(0));

echo 'Value at index 0:                     ';
var_dump($instance->offsetGet(0));

echo 'Unset value at index 0, index exists: ';
$instance->offsetUnset(0);
var_dump($instance->offsetExists(0));

for ($i = 0; $i < 10; ++$i) {
    $instance->offsetSet($i, chr(65 + $i));
}

for ($i = 0; $i < 10; ++$i) {
    echo 'Value at index '.$i.':                     ';
    var_dump($instance->offsetGet($i));
}

for ($i = 3; $i < 6; ++$i) {
    $instance->offsetUnset($i);
}
echo 'Unset value at index 3, index exists: ';
var_dump($instance->offsetExists(3));
echo 'Unset value at index 4, index exists: ';
var_dump($instance->offsetExists(4));
echo 'Unset value at index 5, index exists: ';
var_dump($instance->offsetExists(5));

for ($i = 0; $i < 3; ++$i) {
    echo 'Value at index '.$i.':                     ';
    var_dump($instance->offsetGet($i));
}
for ($i = 6; $i < 10; ++$i) {
    echo 'Value at index '.$i.':                     ';
    var_dump($instance->offsetGet($i));
}

echo 'Append value. Value at index 10:      ';
$instance->append('Z');
var_dump($instance->offsetGet(10));

?>
--EXPECT--
Index 0 exists:                       bool(false)
Set value at index 0, index exists:   bool(true)
Value at index 0:                     string(1) "a"
Unset value at index 0, index exists: bool(false)
Value at index 0:                     string(1) "A"
Value at index 1:                     string(1) "B"
Value at index 2:                     string(1) "C"
Value at index 3:                     string(1) "D"
Value at index 4:                     string(1) "E"
Value at index 5:                     string(1) "F"
Value at index 6:                     string(1) "G"
Value at index 7:                     string(1) "H"
Value at index 8:                     string(1) "I"
Value at index 9:                     string(1) "J"
Unset value at index 3, index exists: bool(false)
Unset value at index 4, index exists: bool(false)
Unset value at index 5, index exists: bool(false)
Value at index 0:                     string(1) "A"
Value at index 1:                     string(1) "B"
Value at index 2:                     string(1) "C"
Value at index 6:                     string(1) "G"
Value at index 7:                     string(1) "H"
Value at index 8:                     string(1) "I"
Value at index 9:                     string(1) "J"
Append value. Value at index 10:      string(1) "Z"
