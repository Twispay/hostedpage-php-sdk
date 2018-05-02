<?php

namespace Twispay\Entity\Item;

use Twispay\Exception\ValidationException;

/**
 * Class ItemList
 *
 * @package Twispay\Entity\Item
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class ItemList implements \ArrayAccess, \Iterator, \Countable
{
    /** @var Item[] $list */
    protected $list = [];

    /**
     * Method offsetSet
     *
     * @param int $offset
     * @param Item $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->list[] = $value;
        } else {
            $this->list[$offset] = $value;
        }
    }

    /**
     * Method offsetExists
     *
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->list[$offset]);
    }

    /**
     * Method offsetUnset
     *
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->list[$offset]);
    }

    /**
     * Method offsetGet
     *
     * @param int $offset
     *
     * @return Item|null
     */
    public function offsetGet($offset)
    {
        return isset($this->list[$offset]) ? $this->list[$offset] : null;
    }

    /**
     * Method rewind
     */
    public function rewind()
    {
        reset($this->list);
    }

    /**
     * Method current
     *
     * @return Item
     */
    public function current()
    {
        return current($this->list);
    }

    /**
     * Method key
     *
     * @return int
     */
    public function key()
    {
        return key($this->list);
    }

    /**
     * Method next
     */
    public function next()
    {
        next($this->list);
    }

    /**
     * Method valid
     *
     * @return bool
     */
    public function valid()
    {
        $key = key($this->list);
        return (!is_null($key) && ($key !== false));
    }

    /**
     * Method count
     *
     * @return int
     */
    public function count()
    {
        return count($this->list);
    }

    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        $list = [];
        foreach ($this->list as $item) {
            $data = $item->toArray();
            foreach ($data as $key => $value) {
                if (!isset($list[$key])) {
                    $list[$key] = [];
                }
                $list[$key][] = $value;
            }
        }
        return $list;
    }

    /**
     * Method getAmount
     *
     * @return float
     */
    public function getAmount()
    {
        $amount = 0.0;
        foreach ($this->list as $item) {
            $amount += (float)$item->getUnitPrice() * (float)$item->getUnits();
        }
        return $amount;
    }

    /**
     * Method validate
     *
     * @throws ValidationException
     */
    public function validate() {
        foreach ($this->list as $item) {
            $item->validate();
        }
    }
}
