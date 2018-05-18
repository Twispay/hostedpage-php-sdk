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
        // empty
    }

    public function next()
    {
        // empty
    }

    public function key()
    {
        // empty
    }

    public function valid()
    {
        // empty
    }

    public function rewind()
    {
        // empty
    }

    public function offsetExists($offset)
    {
        // empty
    }

    public function offsetGet($offset)
    {
        // empty
    }

    public function offsetSet($offset, $value)
    {
        // empty
    }

    public function offsetUnset($offset)
    {
        // empty
    }

    public function count()
    {
        // empty
    }
}
