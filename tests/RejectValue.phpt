--TEST--
Reject unacceptable values
--FILE--
<?php
/**
 * Checks class rejects unacceptable values
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
    $instance[] = 3;
    echo "FAILED (Value was accepted)\n";
} catch (PHP_ArrayOf_Exception_WrongTypeOfElement $e) {
    echo "OK\n";
} catch (Exception $e) {
    echo "FAILED (".$e->getMessage().")\n";
}

$instance[0] = 'a';
echo 'Modify index: ';
try {
    $instance[0] = 3;
    echo "FAILED (Value was accepted)\n";
} catch (PHP_ArrayOf_Exception_WrongTypeOfElement $e) {
    echo "OK\n";
} catch (Exception $e) {
    echo "FAILED (".$e->getMessage().")\n";
}

$data = array('a', 1);
echo 'Init with array: ';
try {
    $instance = new PHP_ArrayOf_String($data);
    echo "FAILED (Value was accepted)\n";
} catch (PHP_ArrayOf_Exception_WrongTypeOfElement $e) {
    echo "OK\n";
} catch (Exception $e) {
    echo "FAILED (".$e->getMessage().")\n";
}

$data = new ArrayObject(array('a', 1));
echo 'Init with ArrayObject: ';
try {
    $instance = new PHP_ArrayOf_String($data);
    echo "FAILED (Value was accepted)\n";
} catch (PHP_ArrayOf_Exception_WrongTypeOfElement $e) {
    echo "OK\n";
} catch (Exception $e) {
    echo "FAILED (".$e->getMessage().")\n";
}

$data = new PHP_ArrayOf_Anything(array('a', 1));
echo 'Init with base class: ';
try {
    $instance = new PHP_ArrayOf_String($data);
    echo "FAILED (Value was accepted)\n";
} catch (PHP_ArrayOf_Exception_WrongTypeOfElement $e) {
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
Init with base class: OK