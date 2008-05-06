<?php

/**
 * Basic array class
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
 * @category PHP
 * @package  PHP_ArrayOf
 * @author   Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyight (c) 2007-2008 by Philippe Jausions / 11abacus
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  CVS: $Id$
 * @link     http://pear.php.net/package/PHP_ArrayOf
 */

/**
 * Get interface declaration and exceptions
 */
require_once 'PHP/ArrayOfInterface.php';
require_once 'PHP/ArrayOf/Exception.php';

/**
 * Basic array class
 *
 * @category PHP
 * @package  PHP_ArrayOf
 * @author   Philippe Jausions <Philippe.Jausions@11abacus.com>
 * @copyight (c) 2007-2008 by Philippe Jausions / 11abacus
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/PHP_ArrayOf
 */
abstract class PHP_ArrayOf implements PHP_ArrayOfInterface
{
    /**
     * Iterator
     *
     * @var Iterator
     * @access private
     */
    private $_iterator;

    /**
     * Iterator class
     *
     * @var string
     * @access private
     */
    private $_iteratorClass;

    /**
     * To hold array data
     *
     * @var array
     * @access protected
     */
    protected $data = array();

    /**
     * Class constructor
     *
     * @param array  $array         initialization array
     * @param string $iteratorClass Iterator class to use
     *
     * @throws PHP_ArrayOf_Exception
     */
    public function __construct($array = null, $iteratorClass = 'ArrayIterator')
    {
        if ($array === null) {
            $array = array();
        }
        $this->exchangeArray($array);
        $this->_iteratorClass = $iteratorClass;
    }

    /**
     * Appends an element to the array
     *
     * @param mixed $value value to append
     *
     * @return void
     * @throws PHP_ArrayOf_Exception
     */
    public function append($value)
    {
        $this->offsetSet(null, $value);
    }

    /**
     * Merges arrays to the current object
     *
     * @param array $array1 First array to merge
     * @param array $array2 Second array to merge
     * @param array ...     Etc
     *
     * @return void
     * @throws PHP_ArrayOf_Exception
     */
    public function merge()
    {
        $args = func_get_args();
        foreach ($args as &$array) {
            foreach ($array as $i => &$v) {
                if (ctype_digit((string)$i)) {
                    $this[] = $v;
                } else {
                    $this->offsetSet($i, $v);
                }
            }
        }
    }

    /**
     * Returns iterator for the object
     *
     * @return Iterator
     */
    public function getIterator()
    {
        if (!isset($this->_iterator)) {
            $this->_iterator = new $this->_iteratorClass($this->data);
        }
        return $this->_iterator;
    }

    /**
     * Returns iterator class name for the object
     *
     * @return string
     */
    public function getIteratorClass()
    {
        return $this->_iteratorClass;
    }

    /**
     * Sets the iterator class name for the object
     *
     * @param string $iteratorClass new class name
     *
     * @return void
     */
    public function setIteratorClass($iteratorClass)
    {
        $this->_iteratorClass = $iteratorClass;
        unset($this->_iterator);
    }

    /**
     * Returns whether the offset exists
     *
     * @param mixed $offset to check
     *
     * @return boolean whether the offset exists
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * Returns the element for the offset
     *
     * @param mixed $offset to retrieve
     *
     * @return mixed value at given offset
     * @throws PHP_ArrayOf_Exception
     */
    public function offsetGet($offset)
    {
        if (array_key_exists($offset, $this->data)) {
            return $this->data[$offset];
        }

        throw new PHP_ArrayOf_Exception_OffsetNotAvailable('Undefined "'
                                                      .$offset.'" offset');
    }

    /**
     * Sets the element for the offset
     *
     * @param mixed $offset to modify
     * @param mixed $value  new value
     *
     * @return void
     * @throws PHP_ArrayOf_Exception
     */
    public function offsetSet($offset, $value)
    {
        $originalOffset = $offset;

        list($offset, $value) = $this->convertOffsetValue($offset, $value);

        if (!$this->isValidElement($value, $offset)) {
            throw new PHP_ArrayOf_Exception_WrongTypeOfElement('Element is not of a valid type');
        }
        if (!$this->offsetAvailable($offset, $value)) {
            throw new PHP_ArrayOf_Exception_OffsetNotAvailable('Element cannot be put at offset ['.$originalOffset.']');
        }
        if ($offset === null) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * Deletes the element for the offset
     *
     * @param mixed $offset to delete
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

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
        return true;
    }

    /**
     * Checks if an element can be set at the offset
     *
     * @param mixed $offset offset to use
     * @param mixed $value  value that would be set
     *
     * @return boolean TRUE if can be set, FALSE otherwise
     */
    public function offsetAvailable($offset, $value)
    {
        return true;
    }

    /**
     * Converts an offset/value pair
     *
     * @param mixed $offset offset to convert
     * @param mixed $value  value to convert
     *
     * @return array 2-element array [new offset to use, new value to use]
     * @throws PHP_ArrayOf_Exception
     */
    public function convertOffsetValue($offset, $value)
    {
        return array($offset, $value);
    }

    /**
     * Returns the count of elements
     *
     * @return integer
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Sets a whole new array replacement
     *
     * @param array|PHP_ArrayOfInterface|ArrayObject $array New array
     *
     * @return void
     * @throws PHP_ArrayOf_Exception
     */
    public function exchangeArray($array)
    {
        $class = get_class($this);
        $error = 'Argument passed is neither a standard array, a '.$class
                 .', an ArrayObject, nor a PHP_ArrayOfInterface instance';

        if (is_array($array)) {
            $array = $this->_verifyArray($array);

        } elseif (is_object($array)) {
            if ($array instanceof ArrayObject) {
                $array = $this->_verifyArray($array);

            } elseif ($array instanceof $class) {
                $array = $array->data;

            } elseif ($array instanceof PHP_ArrayOfInterface) {
                $array = $this->_verifyArray($array);

            } else {
                throw new PHP_ArrayOf_Exception_WrongTypeOfArray($error);
            }

        } else {
            throw new PHP_ArrayOf_Exception_NotAnArray($error);
        }
        $this->data = $array;
    }

    /**
     * Verifies an array is suitable for the class
     *
     * @param array $array array to verify
     *
     * @return array
     */
    private function _verifyArray($array)
    {
        if (count($array) === 0) {
            return $array;
        }
        $class = get_class($this);
        $data  = new $class();
        foreach ($array as $offset => $value) {
            $data[$offset] = $value;
        }
        return $data->data;
    }
}

?>