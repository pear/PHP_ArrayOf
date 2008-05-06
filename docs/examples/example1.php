<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Example usage of PHP_ArrayOf package
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * Copyright (c) 2007-2008, Philippe Jausions / 11abacus
 *
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *   - Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *   - Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in the
 *     documentation and/or other materials provided with the distribution.
 *   - Neither the name of the 11abacus nor the names of its contributors may
 *     be used to endorse or promote products derived from this software
 *     without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   PHP
 * @package    PHP_ArrayOf
 * @subpackage Documentation
 * @author     Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyight   (c) 2007-2008 by Philippe Jausions / 11abacus
 * @license    http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/PHP_ArrayOf
 */

/**
 * Requires base class
 */
require_once 'PHP/ArrayOf.php';


/**
 * Some simple classes for the examples
 *
 * @ignore
 */
class A
{
}

/**
 * Some simple classes for the examples
 *
 * @ignore
 */
class B
{
}

$a = new A();
$b = new B();

/**
 * An array class that only accepts instances of class A
 *
 * @ignore
 */
class ArrayOfA extends PHP_ArrayOf
{
    /**
     * Checks whether a value is suitable for the array
     *
     * @param mixed $value  value to check
     * @param mixed $offset offset the value would be stored at
     *
     * @return boolean TRUE if valid, FALSE otherwise
     * @access protected
     */
    public function isValidElement($value, $offset = null)
    {
        return ($value instanceof A);
    }
}

$aOfA   = new ArrayOfA();
$aOfA[] = $a;

try {
    $aOfA[] = $b;
} catch (PHP_ArrayOf_Exception $e) {
    echo '['.__LINE__.'] '.$e->getMessage()."\r\n";
}

/**
 * Nested array of ArrayOfA. This array accepts instances of A and ArrayOfA.
 * Normal PHP arrays are automatically converted to instances of NestedArrayOfA
 * therefore enforcing that the array only contains instances of A or ArrayOfA
 *
 * @ignore
 */
class NestedArrayOfA extends PHP_ArrayOf
{
    /**
     * Checks whether a value is suitable for the array
     *
     * @param mixed $value  value to check
     * @param mixed $offset offset the value would be stored at
     *
     * @return boolean TRUE if valid, FALSE otherwise
     * @access protected
     */
    public function isValidElement($value, $offset = null)
    {
        return ($value instanceof A || $value instanceof self);
    }

    /**
     * Converts an offset/value pair
     *
     * @param mixed $offset offset to convert
     * @param mixed $value  value to convert
     *
     * @return array 2-element array [new offset to use, new value to use]
     * @access public
     */
    public function convertOffsetValue($offset, $value)
    {
        if (is_array($value)) {
            $value = new self($value);
        }
        return array($offset, $value);
    }
}

$nOfA2 = new NestedArrayOfA(array(array($a), $a));

$nOfA = new NestedArrayOfA();
echo '['.__LINE__.'] ';
print_r($nOfA);

$nOfA->exchangeArray($nOfA2);

try {
    $nOfA[0][] = $b;
} catch (PHP_ArrayOf_Exception $e) {
    echo '['.__LINE__.'] '.$e->getMessage()."\r\n";
}
$nOfA[0][] = $a;

$nOfA[] = array();

echo '['.__LINE__.'] ';
print_r($nOfA);

/**
 * An array class that only accept 3 elements maximum
 *
 * @ignore
 */
class Array3Max extends PHP_ArrayOf
{
    /**
     * Checks if an element can be set at the offset
     *
     * @param mixed $offset offset to use
     * @param mixed $value  value that would be set
     *
     * @return boolean TRUE if can be set, FALSE otherwise
     * @access public
     */
    public function offsetAvailable($offset, $value)
    {
        return array_key_exists($offset, $this->data)
               || (count($this->data) < 3);
    }
}

$m = new Array3Max();

$m['a'] = 'apple';
$m['o'] = 'orange';
$m['b'] = 'banana';
try {
    $m['p'] = 'pear';
} catch (PHP_ArrayOf_Exception $e) {
    echo '['.__LINE__.'] '.$e->getMessage()."\r\n";
}

?>
