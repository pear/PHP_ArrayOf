--TEST--
Accept acceptable values
--FILE--
<?php
/**
 * Checks class accepts acceptable values
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
require 'ArrayOfString.inc';
require 'ArrayOfAnything.inc';

/**
 * Main
 */

$instance = new PHP_ArrayOf_String();

echo 'Append value: ';
try {
    $instance[] = 'a';
    echo "OK\n";
} catch (Exception $e) {
    echo "FAILED (".$e->getMessage().")\n";
}

echo 'Modify index: ';
try {
    $instance[0] = 'b';
    echo "OK\n";
} catch (Exception $e) {
    echo "FAILED (".$e->getMessage().")\n";
}

$data = array('a', 'b');
echo 'Init with array: ';
try {
    $instance = new PHP_ArrayOf_String($data);
    echo "OK\n";
} catch (Exception $e) {
    echo "FAILED (".$e->getMessage().")\n";
}

$data = new ArrayObject(array('a', 'b'));
echo 'Init with ArrayObject: ';
try {
    $instance = new PHP_ArrayOf_String($data);
    echo "OK\n";
} catch (Exception $e) {
    echo "FAILED (".$e->getMessage().")\n";
}

$data = new PHP_ArrayOf_String(array('a', 'b'));
echo 'Init with self class: ';
try {
    $instance = new PHP_ArrayOf_String($data);
    echo "OK\n";
} catch (Exception $e) {
    echo "FAILED (".$e->getMessage().")\n";
}

$data = new PHP_ArrayOf_Anything(array('a', 'b'));
echo 'Init with base class: ';
try {
    $instance = new PHP_ArrayOf_String($data);
    echo "OK\n";
} catch (Exception $e) {
    echo "FAILED (".$e->getMessage().")\n";
}

?>
--EXPECT--
Append value: OK
Modify index: OK
Init with array: OK
Init with ArrayObject: OK
Init with self class: OK
Init with base class: OK