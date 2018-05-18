<?php

namespace Mocks;

use Twispay\Entity\Item\ItemListInterface;
use Twispay\Exception\ValidationException;

/**
 * Class MockItemList
 *
 * @category Mocks
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class MockItemList implements ItemListInterface
{
    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'items' => 'sample'
        ];
    }

    /**
     * Method getAmount
     *
     * @return float
     */
    public function getAmount()
    {
        return 0.0;
    }

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate()
    {
        // empty
    }

    public function current()
    {
        // TODO: Implement current() method.
    }

    public function next()
    {
        // TODO: Implement next() method.
    }

    public function key()
    {
        // TODO: Implement key() method.
    }

    public function valid()
    {
        // TODO: Implement valid() method.
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function count()
    {
        // TODO: Implement count() method.
    }
}
